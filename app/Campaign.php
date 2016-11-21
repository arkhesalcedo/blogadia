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

    public function invitedUsers()
    {
        return $this->belongsToMany(User::class)->withPivot('awarded', 'message');
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

    public function invitedBloggers()
    {
        return array_map(function($blogger){
            return $blogger['id'];
        }, $this->invitedUsers->toArray());
    }

    public function invited($blogger)
    {
        return in_array($blogger, $this->invitedBloggers());
    }

    public function maxedBloggers()
    {
        return $this->offeredBloggers()->count() >= $this->number_of_bloggers ? true : false;
    }

    public function offeredBloggers()
    {
        return $this->invitedUsers()->having('awarded', '=', 1)->get();
    }

    public function offeredToBloggers()
    {
        return array_map(function($blogger){
            return $blogger['id'];
        }, $this->offeredBloggers()->toArray());
    }

    public function offered($blogger)
    {
        return in_array($blogger, $this->offeredToBloggers());
    }

    public function getCampaigns()
    {
        $query = $this::with('user', 'user.info');

        if (auth()->user()->hasRole('administrator')) {
            return $query->withTrashed()->paginate(10);
        }

        if (auth()->user()->hasRole('advertiser')) {
            return $query->withTrashed()->whereUserId(auth()->user()->id)->paginate(10);
        }

        return $query->paginate(10);
    }
}
