<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $pessoa_id
 * @property string $deleted_at
 * @property Pessoa $pessoa
 * @property Vantagem[] $vantagems
 */
class Empresa extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'empresa';

    /**
     * @var array
     */
    protected $fillable = ['pessoa_id', 'deleted_at'];

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
    public function vantagems()
    {
        return $this->hasMany('App\Models\Vantagem');
    }
}
