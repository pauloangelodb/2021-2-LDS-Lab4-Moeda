<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EntidadeController extends Controller
{


    public function __construct()
    {
    }

    public function lista()
    {
        $lista = Array();

        //dd('teste');
        $lista = DB::table('entidade')->get();

        dd($lista);

        return response()->json($lista);
    }

    public function save()
    {

        //dd('teste');
        $lista = DB::table('entidade')->insert(
            [
                'nome' => 'joao2',
                'documento' => '134242445',
                'endereco_id' => 1
            ]
        );

        dd($lista);
        return response()->json($lista);
    }


}
