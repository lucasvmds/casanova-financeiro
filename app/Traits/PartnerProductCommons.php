<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait PartnerProductCommons
{
    public function __construct(array ...$arguments)
    {
        parent::__construct(...$arguments);
        $this->appends = array_merge(
            $this->appends,
            ['active', 'linked'],
        );
    }

    protected function active(): Attribute
    {
        return new Attribute(
            get: fn(): bool => !(bool) $this->deleted_at,
        );
    }

    protected function linked(): Attribute
    {
        $type = str_contains(__CLASS__, 'Partner') ? 'products' : 'partners';
        return new Attribute(
            get: fn(): int => $this->{$type}()->count("$type.id"),
        );
    }
}