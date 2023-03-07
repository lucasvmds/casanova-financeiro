<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 * @package 
 * @method static \Illuminate\Database\Eloquent\Builder whereNull()
 */
class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'user_id',
        'amount',
        'percentage',
    ];
}
