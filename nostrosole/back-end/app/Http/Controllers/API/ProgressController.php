<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Project;

use App\Http\Requests\ProgressRequest;

class ProgressController extends Controller
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
            'data'      =>  Progress::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgressRequest $request)
    {
        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $request->merge([
            'project_id'=>$request->project_id
        ]);


        $progress = Progress::create($request->all());
        return response()->json([
            'message'   =>  'Andamento criado',
            'data'      =>   $progress
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
        $progress = Progress::find($id);
        if (!$progress)
           return response()->json(['message' => 'Andamento nao encontrado', 'data' => null], 404);

        return response()->json([
            'message'   =>  'Andamento encontrado:',
            'data'      =>  $progress
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgressRequest $request, $id)
    {
        $progress = Progress::find($id);
        if (!$progress)
            return response()->json(['message' => 'Andamento nao encontrado', 'data' => null], 404);

        if (!Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        $request->merge([
            'project_id'=>$request->project_id
        ]);


        $progress->update($request->all());
        return response()->json([
            'message'   =>  'Andamento atualizado',
            'data'      =>  $progress
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
        $progress = Progress::find($id);
        if (!$progress)
           return response()->json(['message' => 'Andamento nao encontrado', 'data' => null], 404);

        $progress->delete();
        return response()->json([
            'message'   =>  'Andamento destruído',
            'data'      =>   $progress
        ], 200);
    }
}
