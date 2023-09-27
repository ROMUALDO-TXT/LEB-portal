<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class FileController extends Controller
{
    private $file;

    public function __construct(File $f)
    {
        $this->file = $f;
    }

    public function save(Request $request)
    {
        if (is_null($request->input('edit-file-id'))) {
            //ADD
            if ($request->hasFile('edit-file-file')) {
                $name = $request->file('edit-file-file')->getClientOriginalName();
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = $request->file('edit-file-file')->getClientOriginalExtension();
                $path = $filename . '_' . time() . '.' . $extension;
                $request->file('edit-file-file')->storeAs('public/uploads', $path);

                $folder = Folder::find($request->input('edit-file-folder'));
                $cliente = User::find($request->input('edit-file-clienteId'));

                $file = new File([
                    'name' => $request->input('edit-file-name'),
                    'path' => $path,
                    'description' => $request->input('edit-file-description'),
                    'updated_by' => auth()->user()->id,
                    'user_id' => $request->input('edit-file-clienteId'),
                    'folder_id' => $request->input('edit-file-folder'),
                ]);

                $cliente->files()->save($file);
                $folder->files()->save($file);

                Session::flash('message', 'Arquivo adicionado com sucesso!');

                return redirect()->route('dashboard', ['cliente' => $request->input('edit-file-clienteId'), 'folder' =>  $request->input('edit-file-folder')]);
            }
        } else {
            $existingFile = File::find($request->input('edit-file-id'));
            $path = $existingFile->path;

            if ($request->hasFile('edit-file-file')) {
                $name = $request->file('edit-file-file')->getClientOriginalName();
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = $request->file('edit-file-file')->getClientOriginalExtension();
                $now = Carbon::now()->timestamp * 1000;
                $path = $now . '.' . $extension;
                $request->file('edit-file-file')->storeAs('public/uploads', $path);
                if (Storage::exists('public/uploads/' . $existingFile->path)) {
                    Storage::delete('public/uploads/' . $existingFile->path);
                }
            }

            $existingFile['name'] = $request->input('edit-file-name');
            $existingFile['path'] = $path;
            $existingFile['description'] = $request->input('edit-file-description');
            $existingFile['updated_by'] = auth()->user()->id;
            $existingFile['user_id'] = $request->input('edit-file-clienteId');
            $existingFile['folder_id'] = $request->input('edit-file-folder');


            $folder = Folder::find($request->input('edit-file-folder'));
            $cliente = User::find($request->input('edit-file-clienteId'));

            $cliente->files()->save($existingFile);
            $folder->files()->save($existingFile);

            Session::flash('message', 'Arquivo atualizado com sucesso!');

            return redirect()->route('dashboard', ['cliente' => $request->input('edit-file-clienteId'), 'folder' =>  $request->input('edit-file-folder')]);
        }
    }

    public function remove(Request $request, $id)
    {
        $file = File::find($id);
        if (!is_null($file)) {
            $file->delete();
            return response('', 200);
        } else {
            Session::flash('message', 'Arquivo não encontrado!');
            return response('', 404);
        }
    }


    public function getClienteFolderFiles(Request $request)
    {
        if ($request->ajax()) {
            $clienteId = $request->query('cliente');
            if (!empty($clienteId) && !is_null($clienteId)) {
                $user = User::find($clienteId);

                $folderId = $request->query('folder');
                $folder = Folder::find($folderId);

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
                    ->addColumn('action', function ($row) use ($user, $folder) {
                        $actionBtn = '
                    <button onclick="openDocumentModal({
                        id: ' . $row->id . ',
                        cliente: `' . htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') . '`,
                        folder: `' . htmlspecialchars($folder->name, ENT_QUOTES, 'UTF-8') . '`,
                        name: `' . htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8') . '`,
                        description: `' . htmlspecialchars($row->description, ENT_QUOTES, 'UTF-8'). '`,
                        updatedAt: `' . $row->updated_at . '`,
                        file: `' . $row->path . '`,
                        path: `' . asset('storage/uploads/' . $row->path) . '`
                    })" title="Visualizar documento" class="actions btn btn-success btn-sm">
                        <span class="fa fa-eye preview-eye"></span>
                    </button> 
                    <button onclick="openFileModal({
                        id: ' . $row->id . ',
                        clienteId: ' . $user->id . ',
                        folderId: ' . $folder->id . ',
                        name: `' . htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8') . '`,
                        description: `' . htmlspecialchars($row->description, ENT_QUOTES, 'UTF-8') . '`,
                        file: `' . $row->path . '`
                    })" title="Editar documento" class="actions btn btn-secondary btn-sm">
                        <span class="fa fa-regular fa-pen"></span>
                    </button> 
                    <button onclick="removeFile('.$row->id.')" title="Deletar documento" class="actions btn btn-danger btn-sm">
                        <span class="fa fa-times "></span>
                    </button>                     
                    <a class="actions btn btn-primary btn-sm " onclick="(e)=>{e.preventDefault(); e.stopPropagation()}" href="' . route('download', ['id' => $row->id]) . '" target="_blank" title="Download do documento" download>
                    <span style="color: white" class="fa fa-arrow-down"></span>
                    </a>';

                        return $actionBtn;
                    })
                    ->rawColumns(['extension', 'action'])
                    ->make(true);
            }
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
                ->addColumn('action', function ($row) use ($user, $folder) {
                    $actionBtn = '
                    <button onclick="openDocumentModal({
                        id: ' . $row->id . ',
                        cliente: `' . $user->name . '`,
                        folder: `' . $folder->name . '`,
                        name: `' . $row->name . '`,
                        description: `' . $row->description . '`,
                        updatedAt: `' . $row->updated_at . '`,
                        file: `' . $row->path . '`,
                        path: `' . asset('storage/uploads/' . $row->path) . '`
                    })" title="Visualizar documento" class="actions btn btn-success btn-sm">
                        <span class="fa fa-eye preview-eye"></span>
                    </button> 
                    <a class="actions btn btn-primary btn-sm " onclick="(e)=>{e.preventDefault(); e.stopPropagation();}" href="' . route('download', ['id' => $row->id]) . '" target="_blank" title="Download do documento" download>
                    <span style="color: white" class="fa fa-arrow-down"></span>
                    </a>';

                    return $actionBtn;
                })
                ->rawColumns(['extension', 'action'])
                ->make(true);
        }
    }

    public function download(Request $request)
    {
        $id = $request->query('id');
        $file = File::find($id);
    
        $filePath = 'public/uploads/'. $file->path;
        if (Storage::exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $mimeTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
    
            $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';
            return Storage::download($filePath, $file->name .'.'. $extension, ['Content-Type' => $contentType]);
        } else {
            Session::flash('message', 'Arquivo não encontrado!');
            return response('', 404);
        }
    
    }

    public function messages()
    {
        return [
            'client.required' => 'É necessário escolher um cliente.',
            'folder.required' => 'É necessário escolher uma pasta.',
            'name.required' => 'É necessário um nome para o arquivo.',
            'path.required' => 'É necessário adicionar um arquivo para cadastrar.',
        ];
    }
}
