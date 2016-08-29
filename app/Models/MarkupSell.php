<?php
/**
 * Created by PhpStorm.
 * User: ydiev
 * Date: 8/29/16
 * Time: 1:01 PM
 */

namespace App\Models;


class MarkupSell extends BaseModel
{

    protected $table = 'markups_sell';

    protected $fillable = [
        'user_exchange_rate_id',
        'trade_type',
        'value',
        'active'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userExchangeRate(){

        return $this->belongsTo(UserExchangeRate::class);
    }
}