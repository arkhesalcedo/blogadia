<?php

namespace App\Http\Controllers;

use App\User;
use App\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request, User $user)
    {
    	$this->authorize('update', $user);

        $this->validate($request, [
            'social' => 'required|integer',
            'url' => 'required'  
        ]);

        $user->social()->attach($request->input('social'), ['url' => $request->input('url')]);

        return redirect()->back()->with([
            'message' => 'Add Social Media Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        if ($request->input('delete_social')) {
            $user->social()->newPivotStatement()->where('id', $request->input('_pivot'))->delete();

            return redirect()->back()->with([
                'message' => 'Remove Social Media Successful!',
                'title' => 'Success!',
                'class' => 'success',
                'icon' => 'check'
            ]);
        }

        $this->validate($request, [
            'url' => 'required'  
        ]);

        $user->social()->newPivotStatement()->where('id', $request->input('_pivot'))->update(['url' => $request->input('url')]);

        return redirect()->back()->with([
            'message' => 'Update Social Media Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }
}
