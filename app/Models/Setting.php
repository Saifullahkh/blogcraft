<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function allAsArray(): array
    {
        return Cache::rememberForever('settings.all', fn () => self::query()->pluck('value', 'key')->all());
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return self::allAsArray()[$key] ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        self::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }
}
