<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Movimentacao;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
class UsuarioController extends Controller
{


    public function __construct()
    {
    }

    public function lista(Request $request)
    {
        //$relationShips = ['instituicao', 'pessoa', 'curso', 'pessoa.conta'];
        return response()->json(User::paginate());
    }

    public function save(Request $request)
    {

        $data = $request->only('name', 'email', 'password', 'tipo');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
            'tipo' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tipo' => trim($request->tipo)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);

    }

}
