<?php

namespace App\Http\Controllers\API;

use App\Models\Inverter;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\InverterRequest;

class InverterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Inversores registrados: ',
            'data' => Inverter::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InverterRequest $request)
    {
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $inverter = Inverter::create($request->all());

        return response()->json([
            'message' => 'Sucesso, inversor criado: ',
            'data' => $inverter
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Inverter $inverter)
    {
        return response()->json([
            'message' => 'Sucesso, inversor: ',
            'data' => $inverter
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InverterRequest $request, Inverter $inverter)
    {   
        
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $inverter->update($request->all());

        return response()->json([
            'message' => 'Sucesso, inversor atualizado: ',
            'data' => $inverter
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inverter $inverter)
    {
        $inverter->delete();
        return response()->json([
            'message' => 'Inversor deletado com sucesso'
        ],200);
    }
}
