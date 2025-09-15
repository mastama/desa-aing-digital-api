<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Otomatis set nilai PK (id) sebagai UUID saat creating.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Inisialisasi trait pada model:
     * - PK bertipe string
     * - PK tidak auto-increment (karena kita pakai UUID)
     */
    protected function initializeHasUuid(): void
    {
        $this->setKeyType('string');
        $this->setIncrementing(false);
    }
}
