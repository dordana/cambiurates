<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{

	protected $guarded = [
		'id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function country(){
		return $this->belongsTo(Country::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function chain(){
		return $this->hasOne(Chain::class, 'origin_id', 'chain_id');
	}
}
