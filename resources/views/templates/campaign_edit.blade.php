@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">{{ $campaign->name }} by {{ $user->getFullName() }}</div>
	        <div class="panel-body">
	        	@include('templates.message')
				  	<ul class="nav nav-tabs" role="tablist">
				    	<li role="presentation" class="active"><a href="#campaign" aria-controls="campaign" role="tab" data-toggle="tab">Edit Campaign</a></li>
				  	</ul>

				  	<div class="tab-content">
			    		<div role="tabpanel" class="tab-pane active" id="campaign">
						    @include('forms.campaign_edit')
			    		</div>
				  </div>
	        </div>
	    </div>
	</div>
@endsection