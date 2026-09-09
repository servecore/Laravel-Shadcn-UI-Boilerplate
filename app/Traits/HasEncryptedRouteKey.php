<?php

namespace App\Traits;

use App\Support\EncryptedId;

trait HasEncryptedRouteKey
{
    /**
     * Use an encrypted ID when generating route URLs.
     */
    public function getRouteKey(): string
    {
        return EncryptedId::encrypt($this->getKey());
    }

    /**
     * Resolve an encrypted route parameter back to the model.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $id = EncryptedId::decrypt($value);

        return $this->resolveRouteBindingQuery(
            $this,
            $id,
            $field
        )->first();
    }
}