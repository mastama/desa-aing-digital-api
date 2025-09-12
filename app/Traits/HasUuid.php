<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    // Otomatis set UUID saat creating
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Properti untuk Eloquent
    public $incrementing = false;
    protected $keyType = 'string';
}
