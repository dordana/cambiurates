<?php

namespace App\Models;

class ExchangeRate extends BaseModel
{
    protected $fillable = [
        'symbol',
        'visible',
        'buy_markup',
        'sell_markup',
        'exchange_rate',
        'ttt_sell',
        'featured',
        'title',
    ];
    
    protected $appends = ['Profit', 'BuyRate', 'SellRate'];
    
    /**
     * Attribute to add the profit markup, calculated from sell_markup-ttt_sell
     *
     * @return decimal
     */
    public function getProfitAttribute()
    {
        return $this->sellMarkup - $this->tttSell;
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
    
    /**
     * Only 1 spot is available for each featured slots. In our case 3
     */
    public function updateFeaturedSpots()
    {
        if ($this->featured > 0) {
            DB::table(self::getTable())
                ->where('id', '!=', $this->id)
                ->where('featured', $this->featured)
                ->update(array('featured' => 0));
        }
    }
    
}
