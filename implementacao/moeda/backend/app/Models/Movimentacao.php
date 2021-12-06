<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $conta_origem_id
 * @property int $conta_destino_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $data
 * @property float $valor
 * @property Contum $contum
 * @property Contum $contum
 */
class Movimentacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'movimentacao';

    /**
     * @var array
     */
    protected $fillable = ['conta_origem_id', 'conta_destino_id', 'created_at', 'updated_at', 'deleted_at', 'data', 'valor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contaDestino()
    {
        return $this->belongsTo('App\Models\Conta', 'conta_destino_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contaOrigem()
    {
        return $this->belongsTo('App\Models\Conta', 'conta_origem_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vantagem()
    {
        return $this->belongsTo('App\Models\Vantagem', 'vantagem_id');
    }
}
