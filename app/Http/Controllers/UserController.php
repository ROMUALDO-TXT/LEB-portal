<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Folder;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function workspace(Request $request)
    {
        $error = '';
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);

            $folderId = $request->query('folder');
            if (!empty($folderId) && !is_null($folderId)) {
                $folder = $user->folders()->where('id', $folderId)->first();
                if (empty($folder) && is_null($folder)) {
                    $error = "Pasta não encontrada!";
                    $folder = $user->folders()->first();
                }
            } else {
                $folder = $user->folders()->first();
            }
            $childFolders = $folder->childFolders()->get();
            $parentFolder = $folder->parentFolder()->first();

            if (isset($parentFolder->id) && !is_null($parentFolder->id)) {
                $parentUrl = route('workspace', ['folder' => $parentFolder->id]);
            } else {
                $parentUrl = "#";
            }

            return view('cliente/workspace')->with('user', $user)->with('folder', $folder)->with('parentFolder', $parentFolder)->with('childFolders', $childFolders)->with('parentUrl', $parentUrl)->with('errors', $error);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function dashboard(Request $request)
    {
        $error = '';
        $admin = null;
        $cliente = null;
        $adminId = null;
        $clienteId = null;
        $folder = null;
        $parentFolder = null;
        $childFolders = null;
        $parentUrl = null;
        $folders = [];

        try {
            $clientes = User::select("id", "name", "cnpj", "role")->where('role', "=", "Cliente")->where('deleted_at', '=', null)->get();
            $admins = User::select("id", "name", "cnpj", "role")->where('role', "=", "Admin")->where('deleted_at', '=', null)->get();
            $clienteId = $request->query('cliente');
            if (!empty($clienteId) && !is_null($clienteId)) {
                $cliente = User::select("id", "name", "cnpj", "role")->where('id', "=", $clienteId)->first();
                
                if (!is_null($cliente)) {
                    if ($cliente->role === 'Admin') return redirect()->route('dashboard', ['admin' => $clienteId]);
                    $folders = Folder::where('user_id', '=', $cliente->id)->get();
                    $folderId = $request->query('folder');
                    if (!empty($folderId) && !is_null($folderId)) {
                        $folder = $cliente->folders()->where('id', $folderId)->first();
                        if (empty($folder) && is_null($folder)) {
                            $error = "Pasta não encontrada!";
                            $folder = $cliente->folders()->first();
                        }
                    } else {
                        $folder = $cliente->folders()->first();
                    }

                    $childFolders = $folder->childFolders()->get();
                    $parentFolder = $folder->parentFolder()->first();

                    if (isset($parentFolder->id) && !is_null($parentFolder->id)) {
                        $parentUrl = route('dashboard', ['cliente' => $clienteId, 'folder' => $parentFolder->id]);
                    } else {
                        $parentUrl = "#";
                    }
                } else {
                    $error = "Cliente não encontrado!";
                    return view('admin/dashboard')->with('clienteId', $clienteId)->with('adminId', $adminId)->with('clientes', $clientes)->with('admins', $admins)->with('cliente', $cliente)->with('admin', $admin)
                        ->with('folder', $folder)->with('parentFolder', $parentFolder)->with('childFolders', $childFolders)->with('parentUrl', $parentUrl)->with('error', $error);
                }
            }
            $adminId = $request->query('admin');
            if (!empty($adminId) && !is_null($adminId)) {
                $admin = User::select("id", "name", "cnpj", "role")->where('id', "=", $adminId)->where('deleted_at', '=', null)->first();
                
                if (is_null($admin)) {
                    $error = "Administrador não encontrado!";
                    return view('admin/dashboard')->with('clienteId', $clienteId)->with('adminId', $adminId)->with('clientes', $clientes)->with('admins', $admins)->with('cliente', $cliente)->with('admin', $admin)
                    ->with('folder', $folder)->with('parentFolder', $parentFolder)->with('childFolders', $childFolders)->with('parentUrl', $parentUrl)->with('error', $error);
                }else{
                    if ($admin->role === 'Cliente') return redirect()->route('dashboard', ['cliente' => $adminId]);
                }
            }


            return view('admin/dashboard')->with('clienteId', $clienteId)->with('adminId', $adminId)->with('clientes', $clientes)->with('admins', $admins)->with('cliente', $cliente)->with('admin', $admin)
                ->with('folders', $folders)->with('folder', $folder)->with('parentFolder', $parentFolder)->with('childFolders', $childFolders)->with('parentUrl', $parentUrl)->with('error', $error);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAdminActivities(Request $request)
    {
        if ($request->ajax()) {
            $adminId = $request->query('admin');
            if (!empty($adminId) && !is_null($adminId)) {
                $admin = User::find($adminId);

                $files = DB::select("
                SELECT files.name as name, users.name as cliente, files.updated_at as date, files.deleted_at as deleted_at
                FROM files
                INNER JOIN users ON files.user_id = users.id
                WHERE files.updated_by = :adminId
                ", ['adminId' => $adminId]);

                $folders = DB::select("
                SELECT folders.name, users.name as cliente, folders.updated_at as date, folders.deleted_at as deleted_at
                FROM folders
                INNER JOIN users ON folders.user_id = users.id
                WHERE folders.updated_by = :adminId
                ", ['adminId' => $adminId]);

                $clientes = DB::select("
                SELECT name, updated_at as date, deleted_at
                FROM users
                WHERE updated_by = :adminId
                ", ['adminId' => $adminId]);

                // dump($folders);

                $activities = [];

                foreach ($files as $file) {
                    array_push($activities, [
                        'cliente' => $file->cliente,
                        'file' => 'Arquivo: ' . $file->name,
                        'date' => date("d/m/Y", strtotime($file->date)),
                        'updatedAt' => $file->date,
                        'action' => is_null($file->deleted_at) ? 'Atualização' : 'Remoção',
                    ]);
                }

                foreach ($clientes as $cliente) {
                    array_push($activities, [
                        'cliente' => $cliente->name,
                        'file' => 'Perfil',
                        'date' => date("d/m/Y", strtotime($cliente->date)),
                        'updatedAt' => $cliente->date,
                        'action' => is_null($cliente->deleted_at) ? 'Atualização' : 'Remoção',
                    ]);
                }

                foreach ($folders as $folder) {
                    array_push($activities, [
                        'cliente' => $folder->cliente,
                        'file' => 'Pasta: ' . $folder->name,
                        'date' => date("d/m/Y", strtotime($folder->date)),
                        'updatedAt' => $folder->date,
                        'action' => is_null($folder->deleted_at) ? 'Atualização' : 'Remoção',
                    ]);
                }

                usort($activities, function ($a, $b) {
                    if (empty($a['updatedAt']) && empty($b['updatedAt'])) {
                        return 0;
                    } elseif (empty($a['updatedAt'])) {
                        return 1;
                    } elseif (empty($b['updatedAt'])) {
                        return -1;
                    }

                    $timestampA = strtotime($a['updatedAt']);
                    $timestampB = strtotime($b['updatedAt']);

                    if ($timestampA == $timestampB) {
                        return 0;
                    }

                    return ($timestampA > $timestampB) ? -1 : 1;
                });

                return Datatables::of($activities)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $action = '';
                        if ($row['action'] == 'Atualização') {
                            $action = '<h6 class="action-green title="O arquivo, pasta ou usuário foi inserido ou editado"">' . $row['action'] . '</h6>';
                        } else {
                            $action = '<h6 class="action-red" title="O arquivo, pasta ou usuário foi removido">' . $row['action'] . '</h6>';
                        }
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
    }

    public function save(Request $request)
    {

        if (is_null($request->input('edit-user-id'))) {
            DB::beginTransaction();

            try {
                event(new Registered($user = User::create([
                    'name' => $request->input('edit-user-name'),
                    'cnpj' => $request->input('edit-user-cnpj'),
                    'role' => $request->input('edit-user-role'),
                    'password' => Hash::make($request->input('edit-user-password')),
                    'updated_by' => auth()->user()->id,
                ])));

                $folder = new Folder([
                    'name' => 'principal',
                    'updated_by' => auth()->user()->id,
                ]);
                $user->folders()->save($folder);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                Session::flash('message', 'Falha ao registrar o usuário!');

                return redirect()->route('dashboard', ['cliente' => $request->input('edit-file-clienteId'), 'folder' =>  $request->input('edit-file-folder')]);
            }

            if ($user) {
                Session::flash('message', 'Usuário registrado com sucesso!');

                return redirect()->route('dashboard');
            } else {
                Session::flash('message', 'Falha ao registrar o usuário!');

                return redirect()->route('dashboard');
            }
        } else {
            $user = User::find($request->input('edit-user-id'));

            if ($request->input('edit-user-password')) {
                $user['password'] = Hash::make($request->input('edit-user-password'));
            }
            $user['name'] = $request->input('edit-user-name');
            $user['cnpj'] = $request->input('edit-user-cnpj');
            $user['role'] = $request->input('edit-user-role');
            $user['updated_by'] = auth()->user()->id;

            $user->save();

            Session::flash('message', 'Usuário atualizado com sucesso!');

            if ($request->input('edit-user-role') === 'Cliente') {
                return redirect()->route('dashboard', ['cliente' => $request->input('edit-user-id')]);
            } else if ($request->input('edit-user-role') === 'Admin') {
                return redirect()->route('dashboard', ['admin' => $request->input('edit-user-id')]);
            }
        }
    }

    protected function validar_cnpj($cnpj)
    {

        // Verificar se foi informado
        if (empty($cnpj))
            return false;

        // Remover caracteres especias
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se o numero de digitos informados
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i]);

        if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);

        if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function remove($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
            return response('', 200);
        } else {
            Session::flash('message', 'Usuário não encontrado!');
            return response('', 404);
        }
    }
}


