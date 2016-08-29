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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sellMarkup(){

        return $this->hasOne(MarkupSell::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buyMarkup(){

        return $this->hasOne(MarkupBuy::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rate(){

        return $this->belongsTo(ExchangeRate::class, 'exchange_rate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }
}