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

    public function lista(Request $request)
    {
        
        $lista = Movimentacao::with('contaOrigem.pessoas', 'contaDestino.pessoas', 'vantagem');
        return response()->json($lista->paginate());
    }

    public function save(Request $request){
        $request->validate([
            'conta_origem_id' => 'required',
            'conta_destino_id' => 'required_without:vantagem_id',
            'vantagem_id' => 'required_without:conta_destino_id',
            'valor' => 'required',
        ]);
        $valor = floatval($request->valor);
        $vantagem_id = isset($request->vantagem_id) ? $request->vantagem_id : null;
        //dd($vantagem_id);
        $origem = Conta::firstWhere('id', $request->conta_origem_id);

        if(($origem->saldo - $valor) < 0){
            return response()->json(["message"=>"Saldo insuficiente"], 400);
        }
        $origem->saldo = $origem->saldo - $valor;        
        $origem->save();        
        
        $destino = Conta::firstWhere('id', $request->conta_destino_id);
        $destino->saldo += $valor;
        $destino->save();
        
        $movimentacao = new Movimentacao();
        $movimentacao->data = date('Y-m-d H:i:s');
        $movimentacao->vantagem_id = $vantagem_id;
        $movimentacao->conta_origem_id = $request->conta_origem_id;
        $movimentacao->conta_destino_id = $request->conta_destino_id;
        $movimentacao->valor = $valor;
        $movimentacao->save();
        //Carbon::parse($request->dataVenda)->format('Y-m-d H:i');
        return response()->json(["message" => 'Transacao realizada com suceso', 'movimentacao' => $movimentacao]);
    }
}

