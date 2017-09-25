<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Exchange extends Model
{

    protected $guarded = [
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chain()
    {
        return $this->hasOne(Chain::class, 'origin_id', 'chain_id');
    }

    public static function getDetails(Builder $query)
    {
        $query->where('symbol', 'LIKE', '%a%')
            ->orWhere('title', 'LIKE','%a%');
    }
}
