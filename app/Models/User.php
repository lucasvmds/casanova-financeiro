<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder inRandomOrder()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected const GROUPS = [
        'seller' => 'Vendedor',
        'manager' => 'Gerente',
        'admin' => 'Administrador',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'group',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    protected $appends = [
        'active',
        'group_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function active(): Attribute
    {
        return new Attribute(
            get: fn(): bool => (bool) $this->deleted_at,
        );
    }

    protected function groupName(): Attribute
    {
        return new Attribute(
            get: fn(): string => self::GROUPS[ $this->group ],
        );
    }
}
