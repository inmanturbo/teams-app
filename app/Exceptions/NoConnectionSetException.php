<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class NoConnectionSetException extends Exception
{
    public function __construct($manager)
    {
        parent::__construct("No connection was set on this $manager instance.");
    }
}
