@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">Campaigns<a href="{{ url('campaign/create') }}" class="btn btn-info pull-right">Add Campaign</a></div>
	        <div class="panel-body">
	        	@include('templates.message')
	            @if (!$campaigns->isEmpty())
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Advertiser</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($campaigns as $campaign)
								<tr class="{{ $campaign->trashed() ? 'danger' : '' }}">
									<td>{{ $campaign->name }}</td>
									<td>{{ $campaign->user->getFullName() }}</td>
									<td>{{ $campaign->trashed() ? 'Inactive' : 'Active' }}</td>
									<td>
										<a href="{{ route('user.campaign.edit',  ['user_id' => $campaign->user->id, 'id' => $campaign->id]) }}" class="btn btn-xs btn-primary">Edit</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $campaigns->links() }}
					@else
						<div class="alert alert-warning" role="alert">
						  	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  	<span class="sr-only">Warning:</span>
						  	No campaign created yet!
						</div>
					@endif
	        </div>
	    </div>
	</div>
@endsection