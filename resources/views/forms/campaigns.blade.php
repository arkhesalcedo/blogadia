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
					@if(!auth()->user()->hasRole('blogger'))
					<a href="{{ route('user.campaign.edit',  ['user_id' => $campaign->user->id, 'id' => $campaign->id]) }}" class="btn btn-xs btn-primary">Edit</a>
					@endif
					@if(!$campaign->trashed())
					<a href="{{ route('user.campaign.show', ['user_id' => $campaign->user->id, 'id' => $campaign->id]) }}" class="btn btn-xs btn-success">View</a>
					@endif
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