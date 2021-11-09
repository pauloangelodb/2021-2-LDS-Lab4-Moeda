<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome',
        'documento',
    ];

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'endereco_id', 'id');
    }
}
