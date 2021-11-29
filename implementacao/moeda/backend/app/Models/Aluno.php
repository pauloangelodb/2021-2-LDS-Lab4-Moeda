<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pessoa_id
 * @property int $instituicao_id
 * @property string $deleted_at
 * @property Instituicao $instituicao
 * @property Pessoa $pessoa
 */
class Aluno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'aluno';

    /**
     * @var array
     */
    protected $fillable = ['pessoa_id', 'curso_id', 'instituicao_id', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicao()
    {
        return $this->belongsTo('App\Models\Instituicao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo('App\Models\Curso');
    }
}
