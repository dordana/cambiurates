<?php
/**
 * Created by PhpStorm.
 * User: ydiev
 * Date: 8/29/16
 * Time: 2:48 PM
 */

namespace App\Models;

class UserExchangeRate extends BaseModel
{
    protected $table = 'user_exchange_rates';

    protected $fillable = [
        'type_buy',
        'buy',
        'type_sell',
        'sell',
        'visible'
    ];

    protected $casts = [
        'sell' => 'float',
        'buy' => 'float'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchangeRate(){

        return $this->belongsTo(ExchangeRate::class, 'exchange_rate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns correct data upon trade type
     * @param $value
     * @return string
     */
    public function getSellAttribute($value)
    {
        if($this->typeSell === 'percent'){
            return round($value,2);
        }

        return $value;
    }

    /**
     * Returns correct data upon trade type
     * @param $value
     * @return string
     */
    public function getBuyAttribute($value)
    {
        if($this->typeBuy === 'percent'){
            return round($value,2);
        }

        return $value;
    }
}