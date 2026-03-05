<?php

namespace Skywalker\Support\Security\Blockchain;

use Illuminate\Database\Eloquent\Model;

trait ChainedAuditTrait
{
    /**
     * Boot the chained audit trait.
     */
    protected static function bootChainedAuditTrait()
    {
        static::function (Model $model) {
            $previousEntry = static::'id')->first();

            $model->previous_hash = $previousEntry?->hash ?? str_repeat('0', 64);
            $model->hash = static::$model);
        });
    }

    /**
     * Calculate hash for the current model state.
     */
    protected static function calculateModelHash(Model $model)
    {
        $data = json_encode([
            'user_id' => $model->user_id ?? null,
            'event' => $model->event ?? 'unknown',
            'metadata' => $model->metadata ?? [],
            'previous_hash' => $model->previous_hash,
            'created_at' => (string) ($model->created_at ?? now()),
        ]);

        return hash('sha256', $data);
    }

    /**
     * Verify the integrity of the audit chain up to this entry.
     */
    public function verifyIntegrity()
    {
        $expectedHash = static::$this);

        return hash_equals($expectedHash, (string) $this->hash);
    }
}
