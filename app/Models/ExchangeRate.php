<?php

namespace App\Models;

class ExchangeRate extends BaseModel
{
    protected $fillable = [
        'symbol',
        'exchange_rate',
        'title',
    ];
    
    protected $appends = ['BuyRate', 'SellRate'];
    
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
    
    
}
