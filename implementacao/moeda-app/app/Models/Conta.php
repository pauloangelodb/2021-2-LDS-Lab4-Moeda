<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $deleted_at
 * @property float $saldo
 * @property Movimentacao[] $movimentacaos
 * @property Movimentacao[] $movimentacaos
 * @property Pessoa[] $pessoas
 */
class Conta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'conta';

    /**
     * @var array
     */
    protected $fillable = ['deleted_at', 'saldo'];

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function movimentacaos()
    // {
    //     return $this->hasMany('App\Models\Movimentacao', 'conta_destino_id');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function movimentacaos()
    // {
    //     return $this->hasMany('App\Models\Movimentacao', 'conta_origem_id');
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pessoas()
    {
        return $this->hasMany('App\Models\Pessoa', 'conta_id');
    }
}
