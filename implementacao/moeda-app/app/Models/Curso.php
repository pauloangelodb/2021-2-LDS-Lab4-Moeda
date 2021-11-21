<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $deleted_at
 * @property string $nome
 */
class Curso extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'curso';

    /**
     * @var array
     */
    protected $fillable = ['deleted_at', 'nome'];

}
