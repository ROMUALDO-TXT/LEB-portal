<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestValidation;
use App\Models\File;
use App\Models\User;

class FileController extends Controller
{
    private $file;

    public function __construct(File $f)
    {
        $this->file = $f;
    }

    public function list()
    {
        $clients = User::select('id', 'name', 'cnpj')->where('role', 'Client')->whereNull('deleted_at')->get();
        $clientId = Request::route('clientId');
        $folderId = Request::route('folderId');
        if (!is_null($clientId) && !empty($clientId)) {
            $client = User::find($clientId);
            if(!is_null($folderId) && !empty($folderId)){
                $folder = $client->folders()->find($folderId);
            }else{
                $folder = $client->folders()->where('name', 'main');
                $folderId = $folder->id;
            }
            $child_folders = $folder->childFolders()->all();
            $files = $folder->files()->all();
        } else {
            $client = '';
            $clients = [];
            $folder = '';
            $child_folders = [];
            $files = [];
        }
        echo 'clients:';
        var_dump($clients);
        echo '.      client:';
        var_dump($client);
        echo '.      clientId:';
        var_dump($clientId);
        echo '.     clients:';
        var_dump($clients);

        return view('private/files/list-file')->with('client', $client)->with('clients', $clients)->with('clientId', $clientId)
        ->with('files', $files)->with('folders', $child_folders)->with('folderId', $folderId);
    }

    public function new()
    {
        $folderId = Request::route('folderId');
        $clientId = Request::route('clientId');

        if (!is_null($clientId) && !empty($clientId)) {
            $client = User::find($clientId);
            $folder = $client->folders()->find($folderId);

            return view('private/files/new-file')->with('client', $client)->with('folder', $folder)->
            with('clientId', $clientId)->with('folderId', $folderId);
        }
        return redirect()->action([\App\Http\Controllers\FileController::class, 'list']);
    }

    public function add(RequestValidation $request)
    {
        $this->validate($request, $this->file->rules, $this->messages());
        $clientId = Request::input('clientId');
        $folderId = Request::input('folderId');
        $client = User::find($clientId);
        $folder = $client->folders()->find($folderId);
        $file = new File();
        $file['name'] = Request::input('name');
        $file['description'] = Request::input('description');
        $file['path'] = Request::input('path');
        $folder->files()->save($file);

        return redirect()->action('FileController@list');
    }

    public function edit()
    {
        $clientId = Request::route('clientId');
        $folderId = Request::route('folderId');
        $fileId = Request::route('fileId');

        $client = User::find($clientId);
        $folder = $client->folders()->find($folderId);
        $file = $client->files()->find($fileId);

        if (empty($file)) {
            return "Este arquivo não existe.";
        } else {
            return view('private/files/update-file')->with('folder', $folder)->with('client', $client)
                ->with('folderId', $folderId)->with('clientId', $clientId)->with('file', $file)->with('fileId', $fileId);
        }
    }

    public function update(RequestValidation $request)
    {
        $this->validate($request, $this->file->rules, $this->messages());
        $clientId = Request::input('client');
        $folderId = Request::input('folderId');
        $fileId = Request::input('fileId');
        $client = User::find($clientId);
        $folder = $client->folders->find($folderId);
        $file = $folder->files()->find($fileId);
        $file['name'] = Request::input('name');
        $file['description'] = Request::input('description');
        $file['path'] = Request::input('path');
        $folder->files()->save($file);

        return redirect()->action('FileController@list');
    }

    public function remove()
    {
        $folderId = Request::route('folderId');
        $clientId = Request::route('clientId');
        $fileId = Request::route('fileId');
        $client = User::find($clientId);
        $folders = $client->folders->find($folderId);

        foreach ($folders->files as $f) {
            if ($f['_id'] == $fileId) {
                $f->delete();
            }
        }

        return redirect()->action('FileController@list');
    }

    public function getData()
    {
        $clientId = Request::route('clientId');
        $folderId = Request::route('folderId');
        $clients = User::all();

        if (isset($folderId) && !empty($folderId)) {
            $client = User::find($clientId);
            $folders = $client->folders->all();
            $folder = $client->folders->find($folderId);
            $files = $folder->files->all();
            return view('private/files/list-file')->with('folderId', $folderId)->with('files', $files)
                ->with('clientId', $clientId)->with('folders', $folders)->with('clients', $clients);
        } else {
            $client = User::find($clientId);
            $folders = $client->folders->all();
            $folderId = null;
            $files = [];
            return view('private/files/list-file')->with('folderId', $folderId)->with('files', $files)
                ->with('clientId', $clientId)->with('folders', $folders)->with('clients', $clients);
        }

    }

    public function messages()
    {
        return [
            'client.required' => 'É necessário escolher um cliente.',
            'folder.required' => 'É necessário escolher um diretório.',
            'name.required' => 'É necessário um nome para o arquivo.',
            'path.required' => 'É necessário adicionar um arquivo para cadastrar.',
        ];
    }


    public function show(){
        $folderId = Request::route('folderId');
        $clientId = Request::route('clientId');
        $fileId = Request::route('fileId');

        $client = User::find($clientId);

        $folder = $client->folders()->find($folderId);
        $folders = $client->folders()->all();

        $file = $folder->files()->find($fileId);

        if (empty($folder)) {
            return "Este arquivo não existe.";
        } else {
            return view('private/files/show-file')->with('folders', $folders)
                ->with('clientId', $clientId)->with('folderId', $folderId)->with('file', $file);
        }
    }}
