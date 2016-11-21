@if (!$jobs->isEmpty())
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
			@foreach($jobs as $job)
			<tr class="{{ $job->offered($user->id) ? 'success' : '' }}">
				<td>{{ $job->name }}</td>
				<td>{{ $job->user->getFullName() }}</td>
				<td>{{ $job->offered($user->id) ? 'Offered' : 'Applied/Invited' }}</td>
				<td>
					@if(!auth()->user()->hasRole('blogger'))
					<a href="{{ route('user.campaign.edit',  ['user_id' => $job->user->id, 'id' => $job->id]) }}" class="btn btn-xs btn-primary">Edit</a>
					@endif
					@if(!$job->trashed())
					<a href="{{ route('user.campaign.show', ['user_id' => $job->user->id, 'id' => $job->id]) }}" class="btn btn-xs btn-info">View</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $jobs->links() }}
@else
	<div class="alert alert-warning" role="alert">
	  	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  	<span class="sr-only">Warning:</span>
	  	No job offers yet!
	</div>
@endif