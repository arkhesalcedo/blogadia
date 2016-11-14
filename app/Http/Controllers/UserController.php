<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Campaign;
use Illuminate\Http\Request;

class UserController extends Controller
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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAllUsers', User::class);

        $users = User::with('roles', 'sites')->withTrashed()->paginate(10);

        return view('templates.users', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('templates.user_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $this->validate($request, [
            'email' => 'required|unique:users',
            'password' => 'required'  
        ]);

        $user = (new User)->createUser($request->email, $request->password, Role::getRole('administrator'));

        return redirect()->back()->with([
            'message' => 'New Administrator Added Successfully!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load('info', 'social', 'roles');

        $campaigns = Campaign::where('user_id', '=', $user->id)->withTrashed()->paginate(10);

        return view('templates.user_edit', compact(['user', 'campaigns']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        if ($request->add_credits) {
            $this->validate($request, [
                'credits' => 'required'  
            ]);

            $user->info->credits += $request->credits;
            $user->info->save();

            return redirect()->back()->with([
                'message' => 'Credits Added Successfully!',
                'title' => 'Success!',
                'class' => 'success',
                'icon' => 'check'
            ]);
        }

        $this->validate($request, [
            'password' => 'required'  
        ]);

        $this->password = bcrypt($request->input('password'));
        $this->save();

        return redirect()->back()->with([
            'message' => 'Password Reset Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', auth()->user());

        User::withTrashed()->findOrFail($id)->toggle();

        return redirect('user')->with([
            'message' => 'Account Status Update Successful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }
}
