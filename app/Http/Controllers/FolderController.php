<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestValidation;
use App\Models\User;
use App\Models\Folder;

class FolderController extends Controller
{

    private $folder;

    public function __construct(Folder $f)
    {
        $this->folder = $f;
    }

    public function new()
    {
        $parentId = Request::route('parentId');
        $clientId = Request::route('clientId');

        if (!is_null($clientId) && !empty($clientId)) {
            $client = User::find($clientId);
            if (!is_null($clientId) && !empty($clientId)) {
                $parentFolder = $client->folders()->find($parentId);
            }else{
                $parentFolder = $client->folders()->where('name', 'main');
            }

            return view('private/folders/new-folder')->with('client', $client)->with('parent', $parentFolder)->with('clientId', $clientId)->with('parentId', $parentFolder->id);
        }

        return redirect()->action('FileController@list');
    }

    public function add(RequestValidation $request)
    {
        $this->validate($request, $this->folder->rules, $this->messages());
        $clientId = Request::input('clientId');
        $parentId = Request::input('folderId');-
        $client = User::find($clientId);
        $parent = $client->folders()->find($parentId);
        $folder = new Folder();
        $folder['name'] = Request::input('name');
        $folder['parent_folder_id'] = $parent->id;
        $folder->childFolders()->save($folder);

        return redirect()->action([\App\Http\Controllers\FileController::class, 'list']);
    }

    public function edit()
    {
        $clientId = Request::route('clientId');
        $folderId = Request::route('folderId');

        $client = User::find($clientId);
        $folder = $client->folders()->find($folderId);

        if (empty($folder)) {
            return "Este diretório não existe.";
        } else {
            return view('private/folders/update-folder')->with('folder', $folder)->with('client', $client)
                ->with('folderId', $folderId)->with('clientId', $clientId);
        }
    }

    public function update(RequestValidation $request)
    {
        $this->validate($request, $this->folder->rules, $this->messages());
        $clientId = Request::input('client');
        $folderId = Request::input('folderId');
        $client = User::find($clientId);
        $folder = $client->folders->find($folderId);
        $folder['name'] = Request::input('name');
        $client->folders()->save($folder);

        return redirect()->action('FileController@list');
    }

    public function remove()
    {
        $folderId = Request::route('folderId');
        $clientId = Request::route('clientId');
        $client = User::find($clientId);
        $folder = $client->folders()->find($folderId);

        $filesExists = $folder->files()->whereNull('deleted_at')->get(); 
        $childFolders = $folder->childFolders()->all();

        if(!empty($filesExists) || !empty($childFolders)) {
            return 'Não foi possível remover o diretório, pois ele está povoado';
        }

        $deletedFilesExists = $folder->files()->whereNotNull('deleted_at')->get(); 

        foreach ($deletedFilesExists as $f) {
            $f['folder_id'] = null;
            $client->files()->save($f);
        }

        $folder->delete();

        return redirect()->action('FileController@list');
    }



    public function messages()
    {
        return [
            'client.required' => 'É necessário escolher um cliente.',
            'folder.required' => 'É necessário escolher um diretório.',
            'name.required' => 'É necessário um nome para o diretório.',
        ];
    }
}
