@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">Members<a href="{{ route('user.create') }}" class="btn btn-info pull-right">Add Administrator</a></div>
	        <div class="panel-body">
	        	@include('templates.message')
	            @if (!$users->isEmpty())
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr class="{{ $user->trashed() ? 'danger' : '' }}">
									<td>{{ $user->getFullName() }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->roles()->first()->label }} {!! $user->isVerified() ? '<span class="label label-success">Verified</span>' : ''  !!}</td>
									<td>
										@if($user->trashed())
											<a href="#" onclick="event.preventDefault(); document.getElementById('account_status_form').submit();" class="btn btn-xs btn-success">Activate</a>

	                                        <form id="account_status_form" action="{{ route('user.destroy', ['id' => $user->id]) }}" method="POST" class="hidden">
	                                            {{ csrf_field() }}
	                                            {{ method_field('DELETE') }}
	                                        </form>
										@else
											<a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-xs btn-primary">Edit</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $users->links() }}
					@else
						<div class="alert alert-warning" role="alert">
						  	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						  	<span class="sr-only">Warning:</span>
						  	No users created yet!
						</div>
					@endif
	        </div>
	    </div>
	</div>
@endsection