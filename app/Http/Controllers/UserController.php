<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Folder;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
                    $error = "Diretório não encontrado!";
                    $folder = $user->folders()->where('name', 'main')->first();
                }
            } else {
                $folder = $user->folders()->where('name', 'main')->first();
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

    public function getFolderFiles(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;
            $user = User::find($userId);


            $folderId = $request->query('folder');

            $folder = $user->folders()->where('id', $folderId)->first();
            $files = $folder->files()->get();


            $fileTypeToIcon = [
                "pdf" => "fas fa-file-pdf",
                "doc" => "fas fa-file-word",
                "docx" => "fas fa-file-word",
                "jpg" => "fas fa-file-image",
                "png" => "fas fa-file-image",
                "jpg" => "fas fa-file-image",
                "jpeg" => "fas fa-file-image",
                "csv" => "fas fa-file-csv",
                "xls" => "fas fa-file-excel",
                "xlsx" => "fas fa-file-excel",
            ];

            return Datatables::of($files)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    $timestamp = strtotime($row->updated_at);
                    $dataFormatada = date("d/m/Y", $timestamp);
                    return $dataFormatada;
                })
                ->addColumn('extension', function ($row) use ($fileTypeToIcon) {
                    $file = explode('.', $row->path);
                    $fileType = end($file);
                    $iconClass = $fileTypeToIcon[$fileType] ?? "fas fa-file";
                    $extension = '<p><span style="color: #203c7f;" class="' . $iconClass . '" title="' . $fileType . '"></span>  ' . $fileType . '</p>';


                    return $extension;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <button onclick="previewDocument(`' . $row->path . '`)" title="Visualizar documento" class="actions btn btn-success btn-sm">
                        <span class="fa fa-eye preview-eye"></span>
                    </button> 
                    <a class="actions btn btn-primary btn-sm " href="' . asset("uploads/" . $row->path) . '" target="_blank" title="Download do documento" download>
                    <span style="color: white" class="fa fa-arrow-down"></span>
                    </a>';

                    return $actionBtn;
                })
                ->rawColumns(['extension', 'action'])
                ->make(true);
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

        try {
            $clientes = User::select("id", "name", "cnpj", "role")->where('role', "=", "Cliente")->where('deleted_at', '=', null)->get();
            $admins = User::select("id", "name", "cnpj", "role")->where('role', "=", "Admin")->where('deleted_at', '=', null)->get();
            $clienteId = $request->query('cliente');
            if (!empty($clienteId) && !is_null($clienteId)) {
                $cliente = User::select("id", "name", "cnpj", "role")->where('id', "=", $clienteId)->first();
                if (!is_null($cliente)) {
                    $folderId = $request->query('folder');
                    if (!empty($folderId) && !is_null($folderId)) {
                        $folder = $cliente->folders()->where('id', $folderId)->first();
                        if (empty($folder) && is_null($folder)) {
                            $error = "Diretório não encontrado!";
                            $folder = $cliente->folders()->where('name', 'main')->first();
                        }
                    } else {
                        $folder = $cliente->folders()->where('name', 'main')->first();
                    }

                    $childFolders = $folder->childFolders()->get();
                    $parentFolder = $folder->parentFolder()->first();

                    if (isset($parentFolder->id) && !is_null($parentFolder->id)) {
                        $parentUrl = route('dashboard', ['folder' => $parentFolder->id]);
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
                }
            }


            return view('admin/dashboard')->with('clienteId', $clienteId)->with('adminId', $adminId)->with('clientes', $clientes)->with('admins', $admins)->with('cliente', $cliente)->with('admin', $admin)
                ->with('folder', $folder)->with('parentFolder', $parentFolder)->with('childFolders', $childFolders)->with('parentUrl', $parentUrl)->with('error', $error);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getClienteFolderFiles(Request $request)
    {
        if ($request->ajax()) {
            $clienteId = $request->query('cliente');
            if (!empty($clienteId) && !is_null($clienteId)) {
                $user = User::find($clienteId);

                $folderId = $request->query('folder');

                $folder = $user->folders()->where('id', $folderId)->first();
                $files = $folder->files()->get();


                $fileTypeToIcon = [
                    "pdf" => "fas fa-file-pdf",
                    "doc" => "fas fa-file-word",
                    "docx" => "fas fa-file-word",
                    "jpg" => "fas fa-file-image",
                    "png" => "fas fa-file-image",
                    "jpg" => "fas fa-file-image",
                    "jpeg" => "fas fa-file-image",
                    "csv" => "fas fa-file-csv",
                    "xls" => "fas fa-file-excel",
                    "xlsx" => "fas fa-file-excel",
                ];

                return Datatables::of($files)
                    ->addIndexColumn()
                    ->addColumn('date', function ($row) {
                        $timestamp = strtotime($row->updated_at);
                        $dataFormatada = date("d/m/Y", $timestamp);
                        return $dataFormatada;
                    })
                    ->addColumn('extension', function ($row) use ($fileTypeToIcon) {
                        $file = explode('.', $row->path);
                        $fileType = end($file);
                        $iconClass = $fileTypeToIcon[$fileType] ?? "fas fa-file";
                        $extension = '<p><span style="color: #203c7f;" class="' . $iconClass . '" title="' . $fileType . '"></span>  ' . $fileType . '</p>';


                        return $extension;
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '

                    <button onclick="previewDocument(`' . $row->path . '`)" title="Visualizar documento" class="actions btn btn-success btn-sm">
                        <span class="fa fa-eye preview-eye"></span>
                    </button> 
                    <button onclick="edit" title="Editar documento" class="actions btn btn-secondary btn-sm">
                        <span class="fa fa-regular fa-pen"></span>
                    </button> 
                    <button onclick="delete" title="Deletar documento" class="actions btn btn-danger btn-sm">
                        <span class="fa fa-times "></span>
                    </button>                     <a class="actions btn btn-primary btn-sm " href="' . asset("uploads/" . $row->path) . '" target="_blank" title="Download do documento" download>
                    <span style="color: white" class="fa fa-arrow-down"></span>
                    </a>';

                        return $actionBtn;
                    })
                    ->rawColumns(['extension', 'action'])
                    ->make(true);
            }
        }
    }

    public function getAdminActivities(Request $request)
    {
        if ($request->ajax()) {
            $adminId = $request->query('admin');
            if (!empty($adminId) && !is_null($adminId)) {
                $admin = User::find($adminId);

                $files = File::select('files.name as name', 'users.name as cliente', 'files.updated_at as date', 'files.deleted_at as deleted_at')
                ->join('users', 'files.user_id', '=', 'users.id')
                ->where('files.updated_by', '=', $admin->id)->get();

                $clientes = User::select('name', 'updated_at as date', 'deleted_at')
                ->where('updated_by', '=', $admin->id)->get();
                
                $activities = [];

                foreach ($files as $file) {
                    array_push($activities, [
                        'cliente' => $file->cliente,
                        'file' => $file->name,
                        'date' => date("d/m/Y", strtotime($file->date)),
                        'action' => is_null($file->deleted_at) ? 'Atualização' : 'Remoção',
                    ]);
                }

                foreach($clientes as $cliente){
                    array_push($activities, [
                        'cliente' => $cliente->name,
                        'file' => 'Perfil',
                        'date' => date("d/m/Y", strtotime($cliente->date)),
                        'action' => is_null($cliente->deleted_at) ? 'Atualização' : 'Remoção',
                    ]);
                }

                return Datatables::of($activities)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $action = '';
                        if($row['action'] == 'Atualização'){
                            $action = '<h6 class="action-green title="O arquivo ou usuário foi inserido ou editado"">'.$row['action'].'</h6>';
                        }else{
                            $action = '<h6 class="action-red" title="O arquivo ou usuário foi removido">'.$row['action'].'</h6>';

                        }
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
    }

    function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            $roleId = $request->query('role');
            if (!empty($roleId) && !is_null($roleId)) {
                $folder = $user->folders()->where('id', $roleId)->first();
                $files = $folder->files()->get();

                return Datatables::of($files)
                    ->addIndexColumn()
                    ->addColumn('date', function ($row) {
                        $timestamp = strtotime($row->updated_at);
                        $dataFormatada = date("d/m/Y", $timestamp);
                        return $dataFormatada;
                    })
                    // ->addColumn('extension', function ($row) use ($fileTypeToIcon) {
                    //     $file = explode('.', $row->path);
                    //     $fileType = end($file);
                    //     $iconClass = $fileTypeToIcon[$fileType] ?? "fas fa-file";
                    //     $extension = '<p><span style="color: #203c7f;" class="' . $iconClass . '" title="' . $fileType . '"></span>  ' . $fileType . '</p>';


                    //     return $extension;
                    // })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '
                <button onclick="previewDocument(`' . $row->path . '`)" title="Visualizar documento" class="actions btn btn-success btn-sm">
                    <span class="fa fa-eye preview-eye"></span>
                </button> 
                <a class="actions btn btn-primary btn-sm " href="' . asset("uploads/" . $row->path) . '" target="_blank" title="Download do documento" download>
                <span style="color: white" class="fa fa-arrow-down"></span>
                </a>';

                        return $actionBtn;
                    })
                    ->rawColumns(['extension', 'action'])
                    ->make(true);
            }
        }
    }

    public function userData(Request $request)
    {

        try {
            $userId = $request->query('userId');
            $user = User::find($userId);

            $folderId = $request->query('folder');
            if (empty($folderId) && is_null($folderId)) {
                $folder = $user->folders()->where('name', 'main');
            } else {
                $folder = $user->folders()->find($folderId);
            }

            $files = $folder->files()->all();
            $childFolders = $folder->childFolders()->all();

            return view('admin/userData')->with('user', $user)->with('folder', $folder)->with('childFolders', $childFolders)->with('files', $files);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function new()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {

            return redirect()->route('user-add')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            event(new Registered($user = $this->create($request->all())));

            $folder = new Folder(['name' => 'principal']);
            $user->folders()->save($folder);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('user-add')->with('error', 'Falha ao criar o usuário.');
        }

        if ($user) {
            return redirect()->route('user-add')->with('success', 'Usuário criado com sucesso.');
        } else {
            return redirect()->route('user-add')->with('error', 'Falha ao criar o usuário.');
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

    protected function validator(array $data)
    {
        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O :attribute já existe',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'confirmed' => 'A confirmação do campo :attribute não corresponde.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.max' => 'A Senha não pode ter mais de :max caracteres.',
            'password.min' => 'A Senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'role.required' => 'O Nível de acesso é obrigatório.',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'cnpj' => ['required', 'string', 'max:191', 'unique:users'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);

        $validator->after(function ($validator) use ($data) {
            if (!$this->validar_cnpj($data['cnpj'])) {
                $validator->errors()->add('cnpj', 'O CNPJ é inválido.');
            }
        });

        return $validator;
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'cnpj' => $data['cnpj'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function remove(Request $request)
    {
        $id = $request->route('id');
        $user = User::find($id);
        if (!$user) {
            $error = 'Usuário não encontrado';
            return redirect()->route('user-list')->with('error', $error);
        } else {
            $user->delete();
            $success = 'Usuário deletado com sucesso';
            return redirect()->route('user-list')->with('success', $success);
        }
    }
}
