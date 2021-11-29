<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{


    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $relationShips = ['instituicao', 'pessoa', 'pessoa.conta'];

        return response()->json(Professor::with($relationShips)->paginate());
    }

    public function lista()
    {
        $lista = array();

        //dd('teste');
        //$lista = DB::table('users')->get()->where('tipo', "a");

        //dd($lista);

        return response()->json($lista);
    }

}
