<?php

namespace App\Rules;

use App\Contracts\DatabaseManager;
use Illuminate\Contracts\Validation\Rule;

class DatabaseDoesNotExist implements Rule
{
    protected $databaseManager;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->databaseManager = app(DatabaseManager::class)->setConnection('team');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     */
    public function passes(string $attribute, $value): bool
    {
        return ! $this->databaseManager->databaseExists($value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'Oops! That didn\'t work Please Try a Different Database Name.';
    }
}
