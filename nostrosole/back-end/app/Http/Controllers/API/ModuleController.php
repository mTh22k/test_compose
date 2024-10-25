<?php

namespace App\Http\Controllers\API;

use App\Models\Module;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Módulos registrados: ',
            'data' => Module::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request)
    {
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $request->merge([
            'project_id'=>$request->project_id
        ]);

        $module = Module::create($request->all());

        return response()->json([
            'message' => 'Sucesso, módulo criado: ',
            'data' => $module
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return response()->json([
            'message' => "Sucesso, módulo: ",
            'data' => $module
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, Module $module)
    {
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto do Modulo nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $request->merge([
            'project_id'=>$request->project_id
        ]);

        $module->update($request->all());

        return response()->json([
            'message' => 'Sucesso, módulo atualizado: ',
            'data' => $module
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->delete();
        return response()->json([
            'message' => 'Módulo deletado com sucesso!'
        ], 200);
    }
}
