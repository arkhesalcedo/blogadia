<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'name', 'label'
    ];
    
    public function info()
    {
    	return $this->hasMany(Info::class);
    }
}
