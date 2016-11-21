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
        $campaigns = (new Campaign)->getCampaigns();

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
    public function show(User $user, Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $campaign->load(['user', 'uploads', 'invitedUsers', 'user.info', 'user.sites']);

        $bloggers = $user->getBloggers();

        return view('templates.campaign_show', compact(['campaign', 'bloggers']));
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
        $campaign = Campaign::withTrashed()->findOrFail($campaign_id);

        $this->authorize('delete', $campaign);

        $campaign->toggle();

        return redirect()->back()->with([
            'message' => 'Campaign Status Updated Succesfully!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }

    public function uploads(Request $request, $campaign)
    {
        $this->authorize('update', auth()->user());

        $campaign = Campaign::withTrashed()->findOrFail($campaign);

        $path = $request->file->storeAs('uploads', time() . '_' . $request->file('file')->getClientOriginalName(), 'public');

        $upload = new Upload;
        $upload->campaign_id = $campaign->id;
        $upload->path = $path;
        $upload->type = $request->file('file')->getClientOriginalName();
        $upload->save();
    }

    public function invite(Campaign $campaign, User $user)
    {
        $this->authorize('update', $campaign);

        if ($campaign->invitedUsers->contains($user->id)) {
            $campaign->invitedUsers()->detach($user);

            return [
                'status' => 'success'
            ];
        }

        $campaign->invitedUsers()->save($user, ['message' => 'You invited '.$user->getFullName().' to this campaign.']);

        return [
            'status' => 'success'
        ];
    }

    public function offer(Campaign $campaign, User $user)
    {
        $this->authorize('update', $campaign);

        if (!$campaign->maxedBloggers()) {
            $campaign->invitedUsers()->updateExistingPivot($user->id, ['awarded' => true]);

            return redirect()->back()->with([
                'message' => 'Campaign Offered To Blogger Succesfully!',
                'title' => 'Success!',
                'class' => 'success',
                'icon' => 'check'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Bloggers Maxed Out!',
            'title' => 'Error!',
            'class' => 'danger',
            'icon' => 'check'
        ]);
    }

    public function apply(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'campaign_id' => 'required'
        ]);

        $campaign = Campaign::findOrFail($request->campaign_id);

        $campaign->invitedUsers()->save(auth()->user(), ['message' => $request->message]);

        return redirect()->back()->with([
            'message' => 'Application Succesful!',
            'title' => 'Success!',
            'class' => 'success',
            'icon' => 'check'
        ]);
    }
}
