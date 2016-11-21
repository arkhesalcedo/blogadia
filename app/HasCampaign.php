<?php

namespace App;

trait HasCampaign {

	public function campaigns()
	{
		return $this->hasMany(Campaign::class);
	}

	public function invitedTo()
	{
		return $this->belongsToMany(Campaign::class)->withPivot('rating', 'message', 'id');;
	}

}