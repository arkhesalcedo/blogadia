<?php

namespace App;

trait HasSites
{
	public function sites()
	{
		return $this->hasMany(Site::class);
	}
}