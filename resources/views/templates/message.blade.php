@if(Session::has('message'))
    <div class="alert alert-{{  Session::get('class') }} alert-dismissable">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    	<h4><i class="icon fa fa-{{ Session::get('icon') }}"></i> {{ Session::get('title') }}</h4>
        <p>{{ Session::get('message') }}</p>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    	<h4><i class="icon fa fa-{{ Session::get('icon') }}"></i> Error</h4>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif