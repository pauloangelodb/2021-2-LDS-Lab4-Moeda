<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmpresaController extends Controller
{


    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $relationShips = ['pessoa', 'pessoa.conta'];
        return response()->json(Empresa::with($relationShips)->paginate());
    }

    public function save(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|max:255',
        ]);

        $empresa = new Empresa();
        $empresa->pessoa_id = DB::table('pessoa')->insertGetid([
            'nome' => $request->nome,
            'documento_tipo' => 'CNPJ',
            'documento' => $request->documento,
            'conta_id' => DB::table('conta')->insertGetId(['saldo' => 0])
        ]);
        $empresa->save();
        return response()->json();
    }


    public function lista()
    {
        $lista = Array();

        //dd('teste');
        $lista = DB::table('users')->get()->where('tipo', 'e');

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
