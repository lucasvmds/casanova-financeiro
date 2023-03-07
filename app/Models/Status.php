<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 * @package 
 * @method static \Illuminate\Database\Eloquent\Builder where()
 * @method static self find()
 */
class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'main',
        'deleted_at',
    ];

    protected $appends = [
        'active',
    ];

    protected function active(): Attribute
    {
        return new Attribute(
            get: fn(): bool => !(bool) $this->deleted_at,
        );
    }
}
