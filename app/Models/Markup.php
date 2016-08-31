<?php
/**
 * Created by PhpStorm.
 * User: ydiev
 * Date: 8/30/16
 * Time: 1:02 PM
 */

namespace App\Models;


class Markup extends BaseModel
{
    protected $fillable = [
        'user_exchange_rate_id',
        'trade_type',
        'value',
        'active'
    ];

    protected $casts = [
        'active' => 'integer',
        'value'  => 'float'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userExchangeRate(){

        return $this->belongsTo(UserExchangeRate::class);
    }

    /**
     * Returns correct data upon trade type
     * @param $value
     * @return string
     */
    public function getValueAttribute($value)
    {
        if($this->tradeType === 'percent'){
            return round($value,2);
        }

        return $value;
    }

    /**
     * It is created with the purpose of clearer blade template
     * @return mixed|string
     */
    public function scopeState(){

        if($this->active === 0 || !$this->tradeType){

            return 'disabled';
        }

        return $this->tradeType;
    }
}