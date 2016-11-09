<?php

namespace App\Http\Controllers;

use App\User;
use App\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function store(Request $request, User $user, Site $site)
    {
    	$this->authorize('update', $user);

    	$site->validator($request);

        $request->request->add(['user_id' => $user->id]);

        $site->addImage($request)->create($request->input());

        return redirect()->back()->with([
            'message' => 'Add Site Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    public function update(Request $request, User $user, Site $site)
    {

    	$this->authorize('update', $user);

        $site->validator($request);

        $site->addImage($request)->update($request->input());

        return redirect()->back()->with([
            'message' => 'Update Site Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }
}
