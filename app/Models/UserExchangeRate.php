<?php
/**
 * Created by PhpStorm.
 * User: ydiev
 * Date: 8/29/16
 * Time: 2:48 PM
 */

namespace App\Models;

use App\Models\Markups\MarkupBuy;
use App\Models\Markups\MarkupSell;

class UserExchangeRate extends BaseModel
{
    protected $table = 'user_exchange_rates';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sell(){

        return $this->hasOne(MarkupSell::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buy(){

        return $this->hasOne(MarkupBuy::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchangeRate(){

        return $this->exchange_rate();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchange_rate(){

        return $this->belongsTo(ExchangeRate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }
}