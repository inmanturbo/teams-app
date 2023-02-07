<?php
namespace App\Concerns;

trait ActiveTrait
{
    /**
     * Determine whether the model is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Determine whether the model is inactive.
     */
    public function isInactive(): bool
    {
        return ! $this->isActive();
    }

    /**
     * Activate the model.
     */
    public function activate(): bool
    {
        return $this->update(['active' => true]);
    }

    /**
     * Deactivate the model.
     */
    public function deactivate(): bool
    {
        return $this->update(['active' => false]);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
