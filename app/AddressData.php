<?php

namespace App;

use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public string $city,
        public string $state,
        public string $zip,
        public string $street,
        public ?string $country = 'USA',
        public ?string $lineTwo = null,
    ) {
    }
}
