<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;


class UserController extends Controller
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
            'data'      =>  User::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->merge([
            'password'=>bcrypt($request->password),
        ]);
        $user = User::create($request->all());
        return response()->json([
            'message'   =>  'Usuário criado: ',
            'data'      =>   $user
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
        $user = User::find($id);
        if (!$user)
           return response()->json(['message' => 'Usuário nao encontrado', 'data' => null], 404);

        return response()->json([
            'message'   =>  'Usuário encontrado: ',
            'data'      =>  $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
           return response()->json(['message' => 'Usuário nao encontrado', 'data' => null], 404);

        $request->merge([
            'password'=>bcrypt($request->password),
        ]);

        $user->update($request->all());
        return response()->json([
            'message'   =>  'Usuário atualizado',
            'data'      =>  $user
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
        $user = User::find($id);
        if (!$user)
           return response()->json(['message' => 'Usuário nao encontrado', 'data' => null], 404);

        $user->delete();
        return response()->json([
            'message'   =>  'Usuário removido',
            'data'      =>   $user
        ], 200);
    }
}
