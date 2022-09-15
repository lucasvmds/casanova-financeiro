<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    /**
     * Relacionamento com a tabela `cities`
     * 
     * @return HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
