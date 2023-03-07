<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;
    
    /**
     * Campos para alterações em massa
     * 
     * @var string[]
     */
    protected $fillable = [
        'seller_commission',
    ];
}
