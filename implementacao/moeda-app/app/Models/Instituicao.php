<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $deleted_at
 * @property string $nome
 * @property Aluno[] $alunos
 * @property Departamento[] $departamentos
 * @property Professor[] $professors
 */
class Instituicao extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'instituicao';

    /**
     * @var array
     */
    protected $fillable = ['deleted_at', 'nome'];

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
    public function departamentos()
    {
        return $this->hasMany('App\Models\Departamento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professors()
    {
        return $this->hasMany('App\Models\Professor');
    }
}
