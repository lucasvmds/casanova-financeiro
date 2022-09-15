<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Relacionamento com a tabela `partners`
     * 
     * @return BelongsToMany
     */
    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
}
