<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
	protected $fillable = [
        'first_name', 'last_name', 'country', 'reference', 'subscribe'
    ];

	public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
