<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DesignerAnnex;
use App\Models\Project;

use App\Http\Requests\DesignerAnnexRequest;
use Storage;

class DesignerAnnexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Sucesso, Anexos do Projetista: ',
            'data' => DesignerAnnex::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignerAnnexRequest $request)
    {

        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $file_path = $request->file('file')->store('designerannexes', ['disk'=>'public']);

        $designerAnnex = DesignerAnnex::create([
            'name' => $request->name,
            'file_path' => $file_path,
            'project_id' => $request->project_id
        ]);

        return response()->json([
            'message' => 'Sucesso, seu Anexo do Projetista: ',
            'data'  => $designerAnnex
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DesignerAnnex  $designerAnnex
     * @return \Illuminate\Http\Response
     */
    public function show($id) //DesignerAnnex $designerAnnex
    {
        $designerAnnex = DesignerAnnex::find($id);

        return $designerAnnex ? response()->json(['message' => 'Sucesso, Anexo do Projetista: ', 'data' => $designerAnnex], 200) : 
                                response()->json(['message' => 'Erro: Anexo do Projetista com este id nao encontrado'], 404);

        /*return response()->json([
            'message' => 'Sucesso, Anexo do Projetista: ',
            'data' => $designerAnnex
        ], 200);*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DesignerAnnexRequest $request, $id) //, DesignerAnnex $designerAnnex
    {
        $file_path = NULL;

        $designerAnnex = DesignerAnnex::find($id);

        if (!$designerAnnex)
            return response()->json([
                'message' => 'Erro: Anexo do Projetista com este id nao encontrado'
            ], 404);
        

        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        if ($request->file('file')){
            if (Storage::exists('/public/'.$designerAnnex->file_path)){
                //return true;
                Storage::delete('/public/'.$designerAnnex->file_path);
            }
            $file_path = $request->file('file')->store('designerannexes', ['disk'=>'public']);
        }

        $designerAnnex->update([
            'name' => $request->name,

            'file_path' => $file_path ? $file_path : $designerAnnex->file_path,
            'project_id' => $request->project_id

        ]);

        return response()->json([
            'message' => 'Sucesso, seu Anexo do Projetista atualizado: ',
            'data'  => $designerAnnex
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //DesignerAnnex $designerAnnex
    {
        $designerAnnex = DesignerAnnex::find($id);

        if (!$designerAnnex)
            return response()->json([
                'message' => 'Erro: Anexo do Projetista com este id nao encontrado'
            ], 404);

        if (Storage::exists('/public/'.$designerAnnex->file_path)){
            Storage::delete('/public/'.$designerAnnex->file_path);
        }

        $designerAnnex->delete();

        return response()->json([
            'message' => 'Anexo do Projetista deletado com sucesso'
        ], 200);
    }
}
