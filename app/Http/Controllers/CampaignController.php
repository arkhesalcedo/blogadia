<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\User;
use App\Upload;

class CampaignController extends Controller
{

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
        $campaigns = Campaign::with('user', 'user.info')->withTrashed()->paginate(10);

        return view('templates.campaigns', compact(['campaigns']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Campaign::class);

        $advertisers = User::whereHas('roles', function($query){
            $query->where('name', '=', 'advertiser');
        })->get();

        if ($advertisers->isEmpty()) {
            return redirect()->back()->with([
                'message' => 'Please register an advertiser before creating a campaign!',
                'title' => 'Error!',
                'class' => 'danger',
                'icon' => 'check'
            ]);
        }

        return view('templates.campaign_create', compact(['advertisers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Campaign::class);

        $user = auth()->user()->hasRole('administrator') ? User::findorFail($request->input('user_id')) : auth()->user();

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'duration' => 'required',
            'number_of_bloggers' => 'required',
            'budget' => 'required'  
        ]);

        $request->request->add(['user_id' => $user->id]);

        $campaign = Campaign::create($request->input());

        $campaign->categories()->sync($request->categories);

        return redirect('user/' . $user->id . '/campaign/' . $campaign->id . '/edit' )->with([
            'message' => 'New Campaign Added Succesfully!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $campaign_id)
    {
        $campaign = Campaign::withTrashed()->findOrFail($campaign_id);

        $this->authorize('update', $campaign);

        $campaign->load(['categories']);

        return view('templates.campaign_edit', compact(['campaign', 'user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Campaign $campaign)
    {
        $this->authorize('create', $campaign);

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'duration' => 'required',
            'number_of_bloggers' => 'required',
            'budget' => 'required'  
        ]);

        $request->request->add(['user_id' => $user->id]);

        $campaign->update($request->input());

        $campaign->categories()->sync($request->categories);

        return redirect()->back()->with([
            'message' => 'Campaign Updated Succesfully!',
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
    public function destroy($id, $campaign_id)
    {
        $this->authorize('delete', auth()->user());

        Campaign::withTrashed()->findOrFail($campaign_id)->toggle();

        return redirect()->back()->with([
            'message' => 'Campaign Status Updated Succesfully!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    public function uploads(Request $request, $campaign)
    {
        $campaign = Campaign::withTrashed()->findOrFail($campaign);

        $path = $request->file->storeAs('uploads', time() . '_' . $request->file('file')->getClientOriginalName(), 'public');

        $upload = new Upload;
        $upload->campaign_id = $campaign->id;
        $upload->path = $path;
        $upload->type = $request->file('file')->getClientOriginalName();
        $upload->save();
    }
}
