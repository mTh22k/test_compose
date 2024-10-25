<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\PreInstallation;
use App\Http\Requests\AttachmentRequest;
use Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attachment = Attachment::all();
        return response()->json([
            'message'   =>  'Success',
            'data'      =>  $attachment
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentRequest $request)
    {
        // o anexo deve estar ligado a alguma coisa, no minimo
        if (!PreInstallation::find($request->pre_installation_id) && !Project::find($request->project_id)){
            return response()->json([
                'message' => 'O anexo deve estar ligado a, no mínimo, uma chave estrangeira válida: (project_id) ou (pre_installation_id)'
            ], 400);
        }

        // caso for passado um id, verifica se eh válido
        if ($request->project_id && !Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        // caso for passado um id, verifica se eh válido
        if ($request->pre_installation_id && !PreInstallation::find($request->pre_installation_id)){
            return response()->json([
                'message' => 'Pre-Installação nao encontrado, chave estrangeira invalida (pre_installation_id)'
            ], 400);
        }

        if (!$request->file('file')){
            return response()->json([
                'message'   =>  'file field is missing'
            ], 400);
        }

        $fileName = $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('public/attachments', $fileName);
        $attachment = Attachment::create([
            'name'  =>  $request->name,
            'file'  =>  $filePath,
            'project_id' => $request->project_id,
            'pre_installation_id' => $request->pre_installation_id
        ]);
        return response()->json(['message'  =>  'Attachment created', 'data'  =>  $attachment], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attachment = Attachment::find($id);
        if (!$attachment)
            return response()->json(['message' => 'Attachment not found', 'data' => null], 404);
        return response()->json(['message' => 'Success', 'data' => $attachment], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttachmentRequest $request, $id)
    {
        // o anexo deve estar ligado a alguma coisa, no minimo
        if (!PreInstallation::find($request->pre_installation_id) && !Project::find($request->project_id)){
            return response()->json([
                'message' => 'O anexo deve estar ligado a, no mínimo, uma chave estrangeira válida: (project_id) ou (pre_installation_id)'
            ], 400);
        }

        // caso for passado um id, verifica se eh válido
        if ($request->project_id && !Project::find($request->project_id)){
            return response()->json([
                'message' => 'Projeto nao encontrado, chave estrangeira invalida (project_id)'
            ], 400);
        }

        // caso for passado um id, verifica se eh válido
        if ($request->pre_installation_id && !PreInstallation::find($request->pre_installation_id)){
            return response()->json([
                'message' => 'Pre-Installação nao encontrado, chave estrangeira invalida (pre_installation_id)'
            ], 400);
        }

        $attachment = Attachment::find($id);
        if (!$attachment)
            return response()->json(['message' => 'Attachment not found', 'data' => null], 404);

        if ($request->hasFile('file')){
            Storage::delete($attachment->file);

            $fileName = $request->file('file')->getClientOriginalname();
            $filePath = $request->file('file')->storeAs('public/attachments', $fileName);
            $attachment->file = $filePath;
        }
      
        $attachment->update(['name' =>  $request->name, 'project_id'=>$request->project_id, 'pre_installation_id'=>$request->pre_installation_id]);
        return response()->json(['message' => 'Attachment updated', 'data' => $attachment], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attachment = Attachment::find($id);
        if (!$attachment)
            return response()->json(['message' => 'Attachment not found', 'data' => null], 404);

        if (Storage::exists($attachment->file)){
            Storage::delete($attachment->file);
        }

        $attachment->delete();
        return response()->json(['message' => 'Attachment destroyed', 'data' => $attachment], 200);
    }
}
