<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @package 
 * @method static \Illuminate\Database\Eloquent\Builder inRandomOrder()
 */
class Proposal extends Model
{
    use HasFactory;

    /**
     * Retorna o status (model Status) atual da proposta
     * 
     * @return HasOne
     */
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    /**
     * Relacionamento com a tabela `status`
     * 
     * @return BelongsToMany 
     */
    public function statuses()
    {
        return $this->belongsToMany(Status::class);
    }
}
