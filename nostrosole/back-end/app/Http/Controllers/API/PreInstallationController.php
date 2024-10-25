<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreInstallation;
use App\Http\Requests\PreInstallationRequest;
use App\Models\Project;

class PreInstallationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message'   =>  'Sucesso:',
            'data'      =>  PreInstallation::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PreInstallationRequest $request)
    {
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }
        
        $preInstallation = PreInstallation::create($request->all());
        return response()->json([
            'message'   =>  'Pre-Instalação criada',
            'data'      =>   $preInstallation
        ], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preInstallation = PreInstallation::find($id);
        if (!$preInstallation)
           return response()->json(['message' => 'Pre-Instalação nao encontrada', 'data' => null], 404);


        return response()->json([
            'message'   =>  'Pre-Instalação encontrada:',
            'data'      =>  $preInstallation
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PreInstallationRequest $request, $id)
    {
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $preInstallation = PreInstallation::find($id);
        if (!$preInstallation)
            return response()->json(['message' => 'Pre-Instalação nao encontrada', 'data' => null], 404);

        $preInstallation->update($request->all());
        return response()->json([
            'message'   =>  'Pre-Instalação atualizada',
            'data'      =>  $preInstallation
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preInstallation = PreInstallation::find($id);
        if (!$preInstallation)
            return response()->json(['message' => 'Pre-Instalação nao encontrada', 'data' => null], 404);

        if ($preInstallation->attachments->isNotEmpty()){
            return response()->json([
                'message'   =>  'Não foi possível deletar diretor, há anexos ligados a ele',
            ], 400);
        }
        
        $preInstallation->delete();
        return response()->json([
            'message'   =>  'Pre-Instalação destruída',
            'data'      =>   $preInstallation
        ], 200);
    }
}
