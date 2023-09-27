<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Folder;
use Illuminate\Support\Facades\Session;

class FolderController extends Controller
{

    private $folder;

    public function __construct(Folder $f)
    {
        $this->folder = $f;
    }

    public function save(Request $request)
    {
        if (is_null($request->input('edit-folder-id'))) {
            //ADD
            $cliente = User::find($request->input('edit-folder-clienteId'));

            $folder = new Folder([
                'name' => $request->input('edit-folder-name'),
                'updated_by' => auth()->user()->id,
                'parent_folder_id' => $request->input('edit-folder-parent-folder'),
            ]);

            $cliente->files()->save($folder);

            Session::flash('message', 'Pasta adicionada com sucesso!');

            return redirect()->route('dashboard', ['cliente' => $request->input('edit-folder-clienteId'), 'folder' =>  $request->input('edit-folder-folder')]);
        } else {
            $cliente = User::find($request->input('edit-folder-clienteId'));

            $existingFolder = Folder::find($request->input('edit-folder-id'));
            $existingFolder['name'] = $request->input('edit-folder-name');
            $existingFolder['parent_folder_id'] = $request->input('edit-folder-parent-folder');
            $existingFolder['updated_by'] = auth()->user()->id;

            $cliente->files()->save($existingFolder);

            Session::flash('message', 'Pasta atualizada com sucesso!');

            return redirect()->route('dashboard', ['cliente' => $request->input('edit-folder-clienteId'), 'folder' =>  $request->input('edit-folder-folder')]);
        }
    }

    public function remove(Request $request, $id)
    {
        $folder = Folder::find($id);
        if (!is_null($folder) && $folder->name !== "main") {
            $folder->delete();
            return response('', 200);
        } else {
            Session::flash('message', 'Pasta não encontrada!');
            return response('', 404);
        }
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
