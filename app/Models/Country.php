<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $guarded = [
		'id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function exchanges(){
	    return $this->hasMany(Exchange::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function chains(){
	    return $this->hasMany(Chain::class);
	}
}
