<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public const DEFAULTS = [
        'office_name' => 'MUBS Counseling Office',
        'office_location' => '',
        'office_hours' => '',
        'office_phone' => '',
        'office_email' => '',
        'phq9_threshold' => '10',
        'gad7_threshold' => '10',
    ];

    /** Every setting, with defaults filled in for keys never saved. */
    public static function values(): array
    {
        return array_merge(self::DEFAULTS, static::query()->pluck('value', 'key')->all());
    }

    public static function value(string $key): ?string
    {
        return static::values()[$key] ?? null;
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
