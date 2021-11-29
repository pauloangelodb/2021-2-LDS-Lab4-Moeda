<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $endereco_id
 * @property int $conta_id
 * @property string $deleted_at
 * @property string $nome
 * @property string $documento_tipo
 * @property string $documento
 * @property Contum $contum
 * @property Endereco $endereco
 * @property Aluno[] $alunos
 * @property Empresa[] $empresas
 * @property Professor[] $professors
 */
class Pessoa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pessoa';

    /**
     * @var array
     */
    protected $fillable = ['endereco_id', 'conta_id', 'deleted_at', 'nome', 'documento_tipo', 'documento'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conta()
    {
        return $this->belongsTo('App\Models\Conta', 'conta_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endereco()
    {
        return $this->belongsTo('App\Models\Endereco');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alunos()
    {
        return $this->hasMany('App\Models\Aluno');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empresas()
    {
        return $this->hasMany('App\Models\Empresa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professors()
    {
        return $this->hasMany('App\Models\Professor');
    }
}
