<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
class ExchangeRate extends BaseModel
{
    protected $fillable = [
        'symbol',
        'exchange_rate',
        'title',
    ];
    
    protected $appends = ['BuyRate', 'SellRate'];

    public function users(){

        return $this->belongsToMany(User::class, 'user_exchange_rates');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userExchangeRates(){

        return $this->user_exchange_rates();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_exchange_rates()
    {

        return $this->hasMany(UserExchangeRate::class, 'exchange_rate_id');
    }

    /**
     * Attribute to add the buy rate, calculated from exchange_rate+exchange_rate*buy_markup
     *
     * @return decimal
     */
    public function getBuyRateAttribute()
    {
        return sprintf('%01.3f', $this->exchangeRate * (($this->buyMarkup + 100) / 100));
    }
    
    /**
     * Attribute to add the sell rate, calculated from exchange_rate+exchange_rate*sell_markup
     *
     * @return decimal
     */
    public function getSellRateAttribute()
    {
        return sprintf('%01.3f', $this->exchangeRate * ((100 - $this->sellMarkup) / 100));
    }

    public function scopeSearchFor(Builder $query)
    {
        if (\Request::get('search') != '') {

            $query->where('symbol', 'LIKE', '%'.\Request::get('search').'%')
                ->orWhere('title', 'LIKE','%'.\Request::get('search').'%')
                ->orderBy('symbol', 'asc');
        }
    }


}
