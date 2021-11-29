<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $empresa_id
 * @property string $deleted_at
 * @property string $nome
 * @property string $descricao
 * @property float $valor
 * @property Empresa $empresa
 */
class Vantagem extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'vantagem';

    /**
     * @var array
     */
    protected $fillable = ['empresa_id', 'deleted_at', 'nome', 'descricao', 'valor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }
}
