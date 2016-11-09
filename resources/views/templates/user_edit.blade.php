@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">{{ $user->email }}'s Profile</div>
	        <div class="panel-body">
	        	@include('templates.message')
				  	<ul class="nav nav-tabs" role="tablist">
				  		@can('update', $user)
				    		<li role="presentation" class="active"><a href="#account" aria-controls="account" role="tab" data-toggle="tab">Account</a></li>
				    	@endcan
				    	@if($user->hasRole('blogger') || $user->hasRole('advertiser'))
				    		<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
				    	@endif
				    	@if($user->hasRole('blogger'))
				    		<li role="presentation"><a href="#sites" aria-controls="sites" role="tab" data-toggle="tab">Sites</a></li>
				    		<li role="presentation"><a href="#social-media" aria-controls="social-media" role="tab" data-toggle="tab">Social Media</a></li>
				    	@endif
				    	@if($user->hasRole('advertiser'))
				    		<li role="presentation"><a href="#campaigns" aria-controls="campaigns" role="tab" data-toggle="tab">Campaigns</a></li>
			    		@endif
				  	</ul>

				  	<div class="tab-content">
				  		@can('update', $user)
					    	<div role="tabpanel" class="tab-pane active" id="account">
						    	<div class="col-sm-6">
						    		@include('forms.reset_password')
						    	</div>
					    		<div class="col-sm-6">
						    		@if(auth()->user()->hasRole('administrator'))
						    			@if(!$user->isOwned())
							    			@include('forms.user_status')
							    		@endif
						    		@endif
						    	</div>
					    	</div>
				    	@endcan
				    	@if($user->hasRole('blogger') || $user->hasRole('advertiser'))
				    		<div role="tabpanel" class="tab-pane" id="profile">
				    			@can('update', $user)
							    	@include('forms.update_profile')
						    	@endcan
				    		</div>
				    	@endif
				    	@if($user->hasRole('blogger'))
				    		<div role="tabpanel" class="tab-pane" id="sites">
				    			@can('update', $user)
				    				@include('forms.sites')
				    			@endcan
				    		</div>
				    		<div role="tabpanel" class="tab-pane" id="social-media">
				    			@can('update', $user)
				    				@include('forms.social_media')
				    			@endcan
				    		</div>
				    	@endif
				    	@if($user->hasRole('advertiser'))
				    		<div role="tabpanel" class="tab-pane" id="campaigns">
				    			Campaigns
				    		</div>
				    	@endif
				  </div>
	        </div>
	    </div>
	</div>
@endsection