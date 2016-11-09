<h3>Reset Password</h3>
<hr>
<form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<div class="form-group">
		<label for="password">Enter New Password</label>
        <input id="password" type="password" name="password" class="form-control" placeholder="Password">
    </div>

    <div class="row">
        <div class="col-xs-4 col-xs-offset-8">
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </div>
    </div>
</form>