<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chain extends Model
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
}
