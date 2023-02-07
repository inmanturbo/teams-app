<?php
namespace App\Concerns;

trait ActiveTrait
{
    /**
     * Determine whether the model is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Determine whether the model is inactive.
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        return ! $this->isActive();
    }

    /**
     * Activate the model.
     *
     * @return bool
     */
    public function activate(): bool
    {
        return $this->update(['active' => true]);
    }

    /**
     * Deactivate the model.
     *
     * @return bool
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
