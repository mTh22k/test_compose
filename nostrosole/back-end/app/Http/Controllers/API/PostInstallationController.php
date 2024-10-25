<?php

namespace App\Http\Controllers\API;

use App\Models\PostInstallation;
use App\Models\Project;
use App\Models\PreInstallation;
use App\Models\Attachment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostInstallationRequest;

class PostInstallationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postInstallations = PostInstallation::all();

        return response()->json([
            'message' => 'Registros de Pós Instalação: ',
            'data' => $postInstallations
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostInstallationRequest $request)
    {
        $postInstallation = PostInstallation::create($request->all());

        return response()->json([
            'message' => 'Sucesso, registro de Pós Instalação criado: ',
            'data' => $postInstallation
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
        $postInstallation = PostInstallation::find($id);

        if (!$postInstallation) {
            return response()->json(['message' => 'Registro de Pós Instalação não encontrado'], 404);
        }

        return response()->json([
            'message' => 'Sucesso, registro: ',
            'data' => $postInstallation
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostInstallationRequest $request, $id)
    {
        $postInstallation = PostInstallation::find($id);

        if (!$postInstallation) {
            return response()->json(['message' => 'Registro de Pós Instalação não encontrado'], 404);
        }

        $postInstallation->update($request->all());

        return response()->json([
            'message' => 'Sucesso, registro de Pós Instalação atualizado: ',
            'data' => $postInstallation
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
        $postInstallation = PostInstallation::find($id);

        if (!$postInstallation) {
            return response()->json(['message' => 'Registro de Pós Instalação não encontrado'], 404);
        }

        $postInstallation->delete();

        return response()->json([
            'message' => 'Registro de Pós Instalação deletado com sucesso.'
        ], 200);
    }
}
