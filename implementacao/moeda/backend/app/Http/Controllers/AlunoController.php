<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AlunoController extends Controller
{


    public function __construct()
    {
    }

    public function index(Request $request)
    {        
        $relationShips = ['instituicao', 'pessoa', 'curso', 'pessoa.conta'];        
        return response()->json(Aluno::with($relationShips)->paginate());
    }

    public function lista()
    {
        $lista = Array();
        $relationShips = ['instituicao', 'pessoa', 'curso', 'pessoa.conta'];
        $lista = Aluno::with($relationShips)->paginate();

        return response()->json($lista);
    }

    public function save(Request $request){

        $request->validate([
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|max:255',
            'curso_id' => 'required',
            'instituicao_id' => 'required'
        ]);

        $aluno = new Aluno();
        $aluno->curso_id = intval($request->curso_id);
        $aluno->instituicao_id = intval($request->instituicao_id);
        $aluno->pessoa_id = DB::table('pessoa')->insertGetid([
            'nome' => $request->nome,
            'documento_tipo' => 'CPF',
            'documento' => $request->documento,
            'conta_id' => DB::table('conta')->insertGetId(['saldo' => 0])
        ]);
        $aluno->save();
        return response()->json(['message'=> 'ok']);
    }


    public function edit(Request $request, $id)
    {
        $aluno = DB::table('aluno')->firstWhere('id', $id);

        return response()->json(['aluno' => $aluno]);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|max:255',
            'curso_id' => 'required',
            'instituicao_id' => 'required'
        ]);

        $aluno = DB::table('aluno')->firstWhere('id', $id);
        $aluno->curso_id = $request->curso_id;
        $aluno->instituicao_id = $request->instituicao_id;
        $pessoa = DB::table('pessoa')->firstWhere('id', $aluno->pessoa_id);
        $pessoa->nome = $request->nome;
        $pessoa->documento = $request->documento;
        $pessoa->save();        
        
        return response()->json(['code' => 200, 'message' => 'Aluno atualizado com sucesso']);
    }

    public function remove(Request $request)
    {
        
        //dd('teste');
        $lista = DB::table('users')->where('id', $request->id)->delete();

        dd($lista);
        return response()->json($lista);
    }
}
