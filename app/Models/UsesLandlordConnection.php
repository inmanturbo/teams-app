<?php

namespace App\Models;

trait UsesLandlordConnection
{
    public function getConnectionName()
    {
        return config('landlord.db_connection');
    }
}
