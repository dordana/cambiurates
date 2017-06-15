<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{

	protected $guarded = [
		'id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function exchanges(){
		return $this->hasMany(Exchange::class, 'chain_id', 'origin_id');
	}
}
