<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @package 
 * @method static static create()
 * @method static \Illuminate\Database\Eloquent\Builder where()
 */
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

    protected $appends = [
        'phone',
        'location',
    ];

    protected $casts = [
        'birth_date' => 'datetime:Y-m-d',
    ];

    /**
     * Relacionamento com a tabela `contacts`
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Relacionamento com a tabela `proposals`
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function phone(): Attribute
    {
        return new Attribute(
            get: fn(): int => $this->contacts()->first('phone')->phone,
        );
    }

    public function location(): Attribute
    {
        return new Attribute(
            get: fn(): string => $this->city()->first('name')->name.'/'.$this->state()->first('iso2')->iso2,
        );
    }
}
