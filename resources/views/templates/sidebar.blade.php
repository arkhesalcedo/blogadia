@if (!auth()->guest())
	<div class="col-md-3">
	    <div class="panel panel-info">
	        <div class="panel-heading">Manage</div>
	        <div class="panel-body">
	            <ul class="nav nav-pills nav-stacked">
	            	@if(auth()->user()->hasRole('administrator'))
				  	<li>
				  		<a href="{{ url('user') }}">Members</a>
				  	</li>
				  	@endif
				  	@if(!auth()->user()->hasRole('administrator'))
				  	<li>
				  		<a href="{{ route('user.edit', ['id' => auth()->user()->id]) }}">Profile</a>
				  	</li>
				  	@endif
				  	<li>
				  		<a href="{{ url('campaigns') }}">Campaigns</a>
				  	</li>
				</ul>
	        </div>
	    </div>
	</div>
@endif