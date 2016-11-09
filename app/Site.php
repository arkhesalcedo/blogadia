<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Site extends Model
{
	protected $fillable = [
        'name', 'url', 'user_id', 'category_id', 'description', 'age', 'pageviews', 'posts_per_month', 'price', 'google_analytics', 'quantcast', 'commit', 'image_path', 'verified'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function validator(Request $request)
    {
    	Validator::make($request->input(), [
    		'name' => 'required',
            'url' => 'required',
            'uploaded_image' => 'mimes:jpeg,jpg,png'
    	])->validate();
    }

    public function addImage(Request $request)
    {
    	if ($request->file('image')) {
    		$request->request->add(['image_path' => $request->image->store('uploads', 'public')]);
    	}

    	return $this;
    }

}
