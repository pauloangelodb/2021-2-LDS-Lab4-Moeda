<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\Instituicao;

class InstituicaoController extends Controller
{


    public function __construct()
    {
    }

    public function lista()
    {
        $lista = Instituicao::all();
        return response()->json($lista);
    }
}
