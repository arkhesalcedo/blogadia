<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function campaign()
    {
    	return $this->belongsToMany(Campaign::class);
    }

    public function sites()
    {
    	return $this->hasMany(Site::class);
    }
}
