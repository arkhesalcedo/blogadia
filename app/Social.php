<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = [
        'name', 'label'
    ];

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public static function getAll()
    {
    	return self::get();
    }

    public function getUrl()
    {
        return trim(str_replace('/', '',preg_replace('#^https?://#', '', strtolower($this->pivot->url))));
    }
}
