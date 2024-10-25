<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Projetos registrados: ',
            'data' => Project::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {   
        $project = Project::create($request->all());
        if ($request->has('modules')){
            foreach ($request->modules as $module) {
                $project->modules()->create($module);
            }
        }


        if ($request->has('inverters')) {
            foreach ($request->inverters as $inverter) {
                $project->inverters()->create($inverter);
            }
        }

        if ($request->has('designer_annexes')) {
            foreach ($request->designer_annexes as $annex) {
                $project->designerAnnexes()->create($annex);
            }
        }
    
        return response()->json([
            'message' => 'Sucesso, projeto criado: ',
            'data' => $project->load('modules', 'inverters', 'designerAnnexes')
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json([
            'message' => 'Projeto: ',
            'data' => $project->load('modules', 'inverters', 'designerAnnexes', 'attachments', 'progresses')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        if ($request->has('modules')){
            $project->modules()->delete();
            foreach ($request->modules as $module) {
                $project->modules()->create($module);
            }
        }

        if ($request->has('inverters')) {
            $project->inverters()->delete();
            foreach ($request->inverters as $inverter) {
                $project->inverters()->create($inverter);
            }
        }

        if ($request->has('designer_annexes')) {
            $project->designerAnnexes()->delete();
            foreach ($request->designer_annexes as $annex) {
                $project->designerAnnexes()->create($annex);
            }
        }

        return response()->json([
            'message' => 'Sucesso, projeto atualizado: ',
            'data' => $project->load('modules', 'inverters', 'designerAnnexes')
        ], 200);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->modules->isNotEmpty()){
            return response()->json([
                'message'=>'Nao pode deletar, possui os ' . $project->modules->count() . ' modulos com id: ' . $project->modules->implode('id', ', ')
            ],400);
        }

        if ($project->inverters->isNotEmpty()){
            return response()->json([
                'message'=>'Nao pode deletar, possui os ' . $project->inverters->count() . ' inversores com id: ' . $project->inverters->implode('id', ', ')
            ],400);
        }

        if ($project->attachments->isNotEmpty()){
            return response()->json([
                'message'=>'Nao pode deletar, possui os ' . $project->attachments->count() . ' anexos com id: ' . $project->attachments->implode('id', ', ')
            ],400);
        }

        if ($project->progresses->isNotEmpty()){
            return response()->json([
                'message'=>'Nao pode deletar, possui os ' . $project->progresses->count() . ' andamentos com id: ' . $project->progresses->implode('id', ', ')
            ],400);
        }

        if ($project->designerAnnexes->isNotEmpty()){
            return response()->json([
                'message'=>'Nao pode deletar, possui os ' . $project->designerAnnexes->count() . ' anexos do projetista com id: ' . $project->designerAnnexes->implode('id', ', ')
            ],400);
        }

        if ($project->delete()){
            return response()->json([
                'message' => 'Projeto deletado com sucesso!'
            ], 200);
        }

        return response()->json([
            'message' => 'Erro ao deletar Projeto'
        ], 401);
    }


    //ROTA ADICIONAL
    public function projectStatusCount()
    {
        $statusCounts = Project::selectRaw('
            SUM(CASE WHEN status = "Em andamento" THEN 1 ELSE 0 END) AS in_progress,
            SUM(CASE WHEN status = "Finalizado" THEN 1 ELSE 0 END) AS completed,
            SUM(CASE WHEN status = "Cancelado" THEN 1 ELSE 0 END) AS cancelled
        ')->first();

        return response()->json([
            'message' => 'Quantidade de projetos por andamento: ',
            'data' => $statusCounts
        ], 200);
    }
}
