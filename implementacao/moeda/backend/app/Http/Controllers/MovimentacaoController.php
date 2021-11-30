<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\Instituicao;
use App\Models\Movimentacao;
use Carbon\Carbon;

class MovimentacaoController extends Controller
{


    public function __construct()
    {
    }

    public function lista()
    {
        $lista = Movimentacao::with('contaOrigem.pessoas', 'contaDestino.pessoas');
        return response()->json($lista->paginate());
    }

    public function save(Request $request){
        $request->validate([
            'conta_origem_id' => 'required',
            'conta_destino_id' => 'required',
            'valor' => 'required',
        ]);
        $valor = floatval($request->valor);
        $origem = Conta::find($request->conta_origem_id)->first();
        if(($origem->saldo - $valor) < 0){
            return response()->json(["message"=>"Saldo insuficiente"], 400);
        }
        $origem->saldo = $origem->saldo - $valor;        
        $origem->save();
        dd($origem);

        $destino = Conta::find($request->conta_destino_id)->first();
        $destino->saldo += $valor;
        $destino->save();

        //Carbon::parse($request->dataVenda)->format('Y-m-d H:i');
        Movimentacao::create([
            'data' => date('Y-m-d H:i:s'),
            'conta_origem_id' => $request->conta_origem_id,
            'conta_destino_id' => $request->conta_destino_id,
            'valor' => $request->valor
        ]);

        return response()->json(["message" => 'Transacao realizada com suceso']);
    }
}
