<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ExchangeRate extends BaseModel
{
    protected $fillable = [
        'symbol',
        'exchange_rate',
        'title',
        'pos'
    ];
    
    protected $appends = ['BuyRate', 'SellRate'];
    
    public $timestamps = false; // a must !

    public function users(){

        return $this->belongsToMany(User::class, 'user_exchange_rates');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userExchangeRates(){

        return $this->hasMany(UserExchangeRate::class, 'exchange_rate_id');
    }

    /**
     * Attribute to add the buy rate, calculated from exchange_rate+exchange_rate*buy_markup
     *
     * @return float
     */
    public function getBuyRateAttribute()
    {
        if ($this->typeBuy == 'fixed') {
            return sprintf('%01.6f',$this->buy);
        }
	    return sprintf('%01.6f', $this->exchangeRate * (($this->buy + 100) / 100));
    }
    
    /**
     * Attribute to add the sell rate, calculated from exchange_rate+exchange_rate*sell_markup
     *
     * @return float
     */
    public function getSellRateAttribute()
    {
        if ($this->typeSell == 'fixed') {
            return sprintf('%01.6f',$this->sell);
        }

	    return sprintf('%01.6f', $this->exchangeRate * ((100 - $this->sell) / 100));
    }

    public function scopeSearchFor(Builder $query)
    {
        if (\Request::get('search') != '') {

            $query->where('symbol', 'LIKE', '%'.\Request::get('search').'%')
                ->orWhere('title', 'LIKE','%'.\Request::get('search').'%');
        }
    }

    public function scopeVisibleOnly(Builder $query){

	    $query->where(['is_visible' => 1]);
    }

    public function scopeSupportedOnly(Builder $query){

	    $query->whereIn('symbol', config('currencies.supported'));
    }

    public function scopeByUser(Builder $query)
    {
            $query->leftJoin('user_exchange_rates as a', function ($join) {
                    $join->on('a.exchange_rate_id', '=', 'exchange_rates.id')
                        ->where('a.user_id', '=', \Auth::user()->id);
                })
                ->select('exchange_rates.*', 'a.id AS user_ex_id', \DB::Raw('IFNULL(a.type_buy, "disabled") AS type_buy') , \DB::Raw('IFNULL(a.type_sell, "disabled") AS type_sell'), 'a.sell', 'a.buy', 'a.visible');
    }
}
