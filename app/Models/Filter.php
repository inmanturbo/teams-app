<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Filter extends Pivot
{
    use BindsOnUuid;
    use GeneratesUuid;
    
    public $incrementing = true;

    protected $table = 'stored_queryables';
}
