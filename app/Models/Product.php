<?php

namespace App\Models;

use App\Traits\PartnerProductCommons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 * @package 
 * @method static self create()
 * @method static self|null find(int $id)
 */
class Product extends Model
{
    use HasFactory, SoftDeletes, PartnerProductCommons;

    protected $fillable = [
        'name',
    ];

    /**
     * Relacionamento com a tabela `partners`
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
}
