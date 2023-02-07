<?php

namespace App\Contracts;

use App\AddressData;

interface TeamData
{
    public function logoPath() : string;

    public function logoUrl() : string;

    public function name() : string;

    public function address() : AddressData;

    public function streetAddress() : string;

    public function cityStateZip() : string;

    public function phone() : string;

    public function fax() : string;

    public function email() : string;

    public function website() : string;
}
