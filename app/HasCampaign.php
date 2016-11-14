<?php

namespace App;

trait HasCampaign {

	public function campaigns()
	{
		return $this->hasMany(Campaign::class);
	}

}