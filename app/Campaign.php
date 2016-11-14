<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'content', 'duration', 'number_of_bloggers', 'budget', 'user_id'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function uploads()
    {
    	return $this->hasMany(Upload::class);
    }

    public function categories()
    {
    	return $this->belongsToMany(Category::class);
    }

    public function hasCategory($name)
    {
        foreach ($this->categories as $category)
        {
            if ($category->name == $name)
            {
                return true;
            }
        }

        return false;
    }

    public function toggle()
    {
        return $this->trashed() ? $this->restore() : $this->delete(); 
    }
}
