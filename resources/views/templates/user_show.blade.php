@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">{{ $user->email }}'s Profile</div>
	        <div class="panel-body">
	        	@include('templates.message')
				  	<div class="row">
					    <div class="col-sm-6">
					    	<h3>Personal Details</h3>
					    	<hr>
					        <p><span class="bold">First Name: </span>{{ $user->info->first_name }}</p>
					        <p><span class="bold">Last Name: </span>{{ $user->info->last_name }}</p>
					        <p><span class="bold">Email Address: </span>{{ $user->email }}</p>
					        <p><span class="bold">Country: </span>{{ config('settings.countries')[$user->info->country] }}</p>
					        @if (!$user->social->isEmpty())
					        	<hr>
						        <h3>Social Media</h3>
						    	<hr>
						    	@foreach ($user->social as $social)
						    		<a href="https://{{ $social->getUrl() }}" target="_blank" class="social_links"><i class="fa fa-{{ $social->name }}" aria-hidden="true"></i></a>
						    	@endforeach
					    	@endif

					    	@if(!$user->comments->isEmpty())
					    		<hr>
					    		<h3>Comments</h3>
					    		<hr>
					    		@foreach($user->comments as $blogger)
					    			<div class="bs-callout bs-callout-primary">
					                    <h4>{{ $blogger->getFullName() }} <a href="{{ route('user.show', ['id' => $blogger->id]) }}" class="btn btn-xs btn-info pull-right" target="_blank">View User</a></h4>
					                    <p class="text-warning">
					                    	<span class="bold">Rating: </span>
					                    	<?php
					                    		$ctr = 5;
					                    		$rating = $blogger->pivot->rating;
					                    		while ($ctr > 0) {
					                    			if ($rating > 0) {
					                    				echo '<i class="fa fa-star" aria-hidden="true"></i>';
					                    				$rating--;
					                    			} else {
					                    				echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
					                    			}
					                    			$ctr--;
					                    		}
					                    	?>
					                    </p>
					                    <p class="italic">"{{ $blogger->pivot->message }}"</p>
					                </div>
					    		@endforeach
					    	@endif

					    	@if($user->workedWith())
					    		<hr>
					    		<h3>Leave a comment</h3>

					    		<form action="{{ url('comment') }}" method="POST">
					    			{{ csrf_field() }}
					    			<input type="hidden" name="user_id" value="{{ $user->id }}">
					    			<div class="form-group">
					    				<label for="message">Message</label>
					    				<textarea id="message" name="message" class="form-control" rows="5"></textarea>
					    			</div>
					    			<div class="form-group">
					    				<label for="rating">Rating</label>
					    				<select id="rating" name="rating" class="form-control">
					    					<option value="5">5 Stars</option>
					    					<option value="4">4 Stars</option>
					    					<option value="3">3 Stars</option>
					    					<option value="2">2 Stars</option>
					    					<option value="1">1 Stars</option>
					    				</select>
					    			</div>
					    			<hr>
					    			<button type="submit" class="btn btn-primary pull-right">Submit</button>
					    		</form>
					    	@endif
					    </div>
					    <div class="col-sm-6">
					    	@if(!$user->sites->isEmpty())
						    	@foreach($user->sites as $site)
						    		<h3>Site Details</h3>
						    		<hr>
						    		@if ($site->image_path)
						    			<p><span class="bold">Logo: </span></p>
						    			<img src="{{ asset('storage/' . $site->image_path) }}" class="img-responsive thumbnail">
						    			<hr>
						    		@endif
						    		<p><span class="bold">Site Name: </span>{{ $site->name }}</p>
						    		<p><span class="bold">Site URL: </span><a href="http://{{ $site->getUrl() }}" target="_blank">{{ $site->getUrl() }}</a></p>
						    		<p><span class="bold">Description: </span>{{ $site->description }}</p>
						    		<hr>
						    		<p><span class="bold">Age of Site: </span>{{ config('settings.age')[$site->age] }}</p>
						    		<p><span class="bold">Estimated Monthly Page View: </span>{{ config('settings.pageviews')[$site->pageviews][0] }}</p>
						    		<p><span class="bold">Average Post per month: </span>{{ config('settings.posts_per_month')[$site->posts_per_month] }}</p>
						    		<p><span class="bold">Ad Price Per Month: </span>{{ money_format('%.2n', $site->price) }}</p>
						    		<p><span class="bold">Verified Blogger?: </span>{{ $site->verified ? 'Yes' : 'No' }}</p>
						    	@endforeach
					    	@endif

					    	@if(!$user->campaigns->isEmpty())
					    		<h3>Campaigns</h3>
						    	@foreach($user->campaigns as $campaign)
						    		<hr>
						    		<p><span class="bold">Name: </span>{{ $campaign->name }}</p>
						    		<p><span class="bold">Status: </span>{{ $campaign->trashed() ? 'Inactive' : 'Active' }}</p>
						    		<p><a href="{{ route('user.campaign.show', ['id' => $user->id, 'campaign_id' => $campaign->id]) }}" class="btn btn-info btn-xs">View Details</a></p>
						    	@endforeach
					    	@endif
					    </div>
					</div>
	        </div>
	    </div>
	</div>
@endsection