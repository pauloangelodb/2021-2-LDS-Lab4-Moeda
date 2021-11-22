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
        return Inertia::render('Aluno/index', Aluno::with($relationShips)->paginate());
    }

    public function lista()
    {
        $lista = Array();

        //dd('teste');
        //$lista = DB::table('users')->get()->where('tipo', "a");

        //dd($lista);

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
        return redirect()->route('aluno');
    }



    public function edit(Request $request)
    {
        
        $edit = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'tipo' => 'a',
            'entidade_id' => $request->input('entidade_id')
        ];

        //dd('teste');
        $lista = DB::table('users')->where('email', $edit['email'])->update($edit);

        dd($lista);
        return response()->json($lista);
    }

    public function remove(Request $request)
    {
        
        //dd('teste');
        $lista = DB::table('users')->where('id', $request->segment(3))->delete();

        dd($lista);
        return response()->json($lista);
    }
}
