<?php

namespace App\Models;

/**
 * Class CityforexRate
 *
 * @package Modules\Delivery\Models
 */
class CityforexRate extends BaseModel
{
    protected $fillable = [
        'symbol',
        'exchange_rate'
    ];
}
