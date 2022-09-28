<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @package 
 * @method static \Illuminate\Database\Eloquent\Builder inRandomOrder()
 * @method static \Illuminate\Database\Eloquent\Builder orderBy()
 * @method static self create()
 */
class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'required_amount',
        'additional_info',
        'status_id',
        'user_id',
    ];

    protected $appends = [
        'product_name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function statuses()
    {
        return $this->belongsToMany(Status::class)
            ->withTimestamps()
            ->withPivot([
                'note',
                'created_at',
            ]);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function currentStatus(): Attribute
    {
        return new Attribute(
            get: fn() => $this->status()->first(['name', 'color'])->makeHidden('active')->toArray(),
        );
    }

    protected function customerName(): Attribute
    {
        return new Attribute(
            get: fn() => $this->customer()->first('name')->name,
        );
    }

    protected function productName(): Attribute
    {
        return new Attribute(
            get: fn() => $this->product()->withTrashed()->first('name')->name,
        );
    }
}
