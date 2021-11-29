<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $instituicao_id
 * @property string $nome
 * @property Instituicao $instituicao
 * @property ProfessorDepartamento[] $professorDepartamentos
 */
class Departamento extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'departamento';

    /**
     * @var array
     */
    protected $fillable = ['instituicao_id', 'nome'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicao()
    {
        return $this->belongsTo('App\Models\Instituicao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professorDepartamentos()
    {
        return $this->hasMany('App\Models\ProfessorDepartamento');
    }
}
