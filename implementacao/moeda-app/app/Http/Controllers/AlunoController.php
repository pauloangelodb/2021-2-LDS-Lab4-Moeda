<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
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
        $relationShips = ['instituicao', 'pessoa', 'pessoa.conta'];
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

    public function save(Request $request)
    {
        
        $new = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'tipo' => $request->input('tipo'),
            'entidade_id' => $request->input('entidade_id')
        ];

        //dd('teste');
        $lista = DB::table('users')->insert($new);

        dd($lista);
        return response()->json($lista);
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
