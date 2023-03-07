<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Campos para alteração em massa
     * 
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
    ];
}
