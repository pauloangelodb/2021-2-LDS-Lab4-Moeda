<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\User;
use App\Models\Vantagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class VantagemController extends Controller
{


    public function __construct()
    {
    }

    public function lista(Request $request)
    {        
        return response()->json(Vantagem::with('empresa.pessoa')->paginate());
    }

    public function save(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required',
            'empresa_id' => 'required'
        ]);

        $vantagem = new Vantagem();
        $vantagem->empresa_id = $request->empresa_id;
        $vantagem->nome = $request->nome;
        $vantagem->descricao = isset($request->descricao) ? $request->descricao : null ;
        $vantagem->valor = $request->valor;
        $vantagem->save();

        return response()->json(['message' => 'ok']);
    }


}
