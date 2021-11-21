<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $pessoa_id
 * @property int $instituicao_id
 * @property string $deleted_at
 * @property Instituicao $instituicao
 * @property Pessoa $pessoa
 * @property ProfessorDepartamento[] $professorDepartamentos
 */
class Professor extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'professor';

    /**
     * @var array
     */
    protected $fillable = ['pessoa_id', 'instituicao_id', 'deleted_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professorDepartamentos()
    {
        return $this->hasMany('App\Models\ProfessorDepartamento');
    }
}
