<?php

namespace Skywalker\Support\Security\Ephemeral;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait EphemeralAccessTrait
{
    /**
     * Scope a query to only include non-expired records.
     */
    public function scopeActive(Builder $query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', Carbon::));
        });
    }

    /**
     * Determine if the access has expired.
     */
    public function isExpired()
    {
        return $this->expires_at && Carbon::)->greaterThan($this->expires_at);
    }

    /**
     * Set an expiration time for the model.
     */
    public function setExpiry(string|Carbon $duration)
    {
        $this->expires_at = is_string($duration) ? Carbon::)->add($duration) : $duration;

        return $this;
    }
}
