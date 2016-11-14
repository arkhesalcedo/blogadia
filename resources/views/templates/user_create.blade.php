@extends('layouts.app')

@section('content')
	<div class="col-md-9">
	    <div class="panel panel-warning">
	        <div class="panel-heading">Add Administrator</div>
	        <div class="panel-body">
	        	@include('templates.message')
				  	<ul class="nav nav-tabs" role="tablist">
				    	<li role="presentation" class="active"><a href="#account" aria-controls="account" role="tab" data-toggle="tab">Account</a></li>
				  	</ul>

				  	<div class="tab-content">
				  		@can('create', auth()->user())
					    	<div role="tabpanel" class="tab-pane active" id="account">
						    	<div class="col-sm-12">
						    		<form class="form-horizontal" role="form" method="POST" action="{{ route('user.store') }}">
				                        {{ csrf_field() }}

				                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

				                            <div class="col-md-6">
				                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

				                                @if ($errors->has('email'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('email') }}</strong>
				                                    </span>
				                                @endif
				                            </div>
				                        </div>

				                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				                            <label for="password" class="col-md-4 control-label">Password</label>

				                            <div class="col-md-6">
				                                <input id="password" type="password" class="form-control" name="password" required>

				                                @if ($errors->has('password'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('password') }}</strong>
				                                    </span>
				                                @endif
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <div class="col-md-8 col-md-offset-4">
				                                <button type="submit" class="btn btn-primary">
				                                    Create
				                                </button>
				                            </div>
				                        </div>
				                    </form>
						    	</div>
					    	</div>
				    	@endcan
				  </div>
	        </div>
	    </div>
	</div>
@endsection