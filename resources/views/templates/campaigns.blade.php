@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">Campaigns
	        	@if(!auth()->user()->hasRole('blogger'))
	        		<a href="{{ url('campaign/create') }}" class="btn btn-info pull-right">Add Campaign</a>
	        	@endif
	        </div>
	        <div class="panel-body">
	        	@include('templates.message')
	            @include('forms.campaigns')
	        </div>
	    </div>
	</div>
@endsection