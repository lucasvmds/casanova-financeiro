<?php

namespace App\Models;

use App\Traits\PartnerProductCommons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 * @package 
 * @method static self create()
 */
class Partner extends Model
{
    use HasFactory, SoftDeletes, PartnerProductCommons;

    protected $fillable = [
        'name',
    ];

    /**
     * Relacionamento com a tabela `products`
     * 
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
