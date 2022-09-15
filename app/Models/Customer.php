<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Campos para alteração em massa
     * 
     * @var string[]
     */
    protected $fillable = [
        'state_id',
        'city_id',
        'name',
        'cpf',
        'rg',
        'birth_date',
        'street',
        'number',
        'district',
        'complement',
        'cep',
        'additional_info',
    ];

    /**
     * Relacionamento com a tabela `contacts`
     * 
     * @return HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Relacionamento com a tabela `proposals`
     * 
     * @return HasMany
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
