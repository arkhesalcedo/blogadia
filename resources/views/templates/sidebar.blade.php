@if (!auth()->guest())
	<div class="col-md-3">
	    <div class="panel panel-info">
	        <div class="panel-heading">Manage</div>
	        <div class="panel-body">
	            <ul class="nav nav-pills nav-stacked">
				  	<li>
				  		<a href="{{ url('user') }}">Members</a>
				  		<ul class="nav nav-pills nav-stacked">
						  	<li><a href="{{ url('add-credits') }}">Add Credits</a></li>
						  	<li><a href="{{ url('add-administrator') }}">Add Administrator</a></li>
						</ul>
				  	</li>
				  	<li>
				  		<a href="{{ url('campaign') }}">Campaigns</a>
				  		<ul class="nav nav-pills nav-stacked">
						  	<li><a href="{{ url('add-credits') }}">Add Credits</a></li>
						  	<li><a href="{{ url('add-administrator') }}">Add Administrator</a></li>
						</ul>
				  	</li>
				</ul>
	        </div>
	    </div>
	</div>
@endif