@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">{{ $campaign->name }} by {{ $campaign->user->getFullName() }}</div>
	        <div class="panel-body">
	        	@include('templates.message')
				  	<ul class="nav nav-tabs" role="tablist">
				    	<li role="presentation" class="active"><a href="#campaign" aria-controls="campaign" role="tab" data-toggle="tab">Campaign Details</a></li>
				    	@can('update', $campaign)
				    	<li role="presentation"><a href="#bloggers" aria-controls="bloggers" role="tab" data-toggle="tab">Bloggers</a></li>
				    	@endcan
				  	</ul>

				  	<div class="tab-content">
			    		<div role="tabpanel" class="tab-pane active" id="campaign">
						    @include('forms.campaign_show')
			    		</div>
			    		@can('update', $campaign)
			    		<div role="tabpanel" class="tab-pane" id="bloggers">
			    			@include('forms.campaign_bloggers')
			    		</div>
			    		@endcan
				  	</div>
	        </div>
	    </div>
	</div>
@endsection