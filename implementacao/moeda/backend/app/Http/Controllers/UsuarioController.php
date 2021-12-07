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
use Inertia\Inertia;

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

    // public function save(Request $request)
    // {

    //     $request->validate([
    //         'nome' => 'required|string|max:255',
    //         'documento' => 'required|string|max:255',
    //         'curso_id' => 'required',
    //         'instituicao_id' => 'required'
    //     ]);

    //     $aluno = new Aluno();
    //     $aluno->curso_id = intval($request->curso_id);
    //     $aluno->instituicao_id = intval($request->instituicao_id);
    //     $aluno->pessoa_id = DB::table('pessoa')->insertGetid([
    //         'nome' => $request->nome,
    //         'documento_tipo' => 'CPF',
    //         'documento' => $request->documento,
    //         'conta_id' => DB::table('conta')->insertGetId(['saldo' => 0])
    //     ]);
    //     $aluno->save();
    //     return response()->json(['message' => 'ok']);
    // }

}
