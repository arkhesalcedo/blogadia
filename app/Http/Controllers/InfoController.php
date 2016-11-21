<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class InfoController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request, User $user)
    {
    	$this->authorize('update', $user);

        $subscription = $request->input('subscription');

        if (!auth()->user()->hasRole('administrator')) {
            $subscription = $user->info->subscription_id;
        }

        $user->info->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'country' => $request->input('country'),
            'subscribe' => $request->input('subscribe') ? true : false,
            'reference' => $request->input('reference'),
            'subscription_id' => $subscription
        ]);

        return redirect()->back()->with([
            'message' => 'Update Info Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }
}
