<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Exception;

/**
 * App\Models\BaseModel
 *
 */
class BaseModel extends Eloquent
{
    public function setAttribute($key, $value)
    {
        $dates = $this->getDates();

        if (in_array($key, $dates)) {
            if (is_string($value) && !in_array($key, ['created_at', 'updated_at'])) {
                $value = Carbon::createFromFormat(Carbon::ISO8601, $value);
            }
        }

        parent::setAttribute($key, $value);
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getDates() as $key) {
            if (!isset($attributes[$key])) {
                continue;
            }

            try {
                if (is_numeric($attributes[$key])) {
                    $attributes[$key] = Carbon::createFromTimestamp($attributes[$key])->toIso8601String();
                }
                if (is_string($attributes[$key])) {
                    $attributes[$key] = Carbon::createFromFormat($this->getDateFormat(), $attributes[$key])
                        ->toIso8601String();
                }
            } catch (Exception $e) {
                $attributes[$key] = '0000-00-00T00:00:00+0000';
            }
        }

        return $attributes;
    }
}
