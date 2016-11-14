<h3>Credits</h3>
<hr>
<form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

	<input type="hidden" name="add_credits" value="1">

	<div class="form-group">
		<label for="credits">Current Credits: <span class="label label-success" style="font-size: 14px;">{{ $user->info->credits }}</span></label>
        <input id="credits" type="number" min="0" step="any" name="credits" class="form-control" value="{{ $user->credits }}">
    </div>

    <div class="row">
        <div class="col-xs-4 col-xs-offset-8">
            <button type="submit" class="btn btn-primary btn-block">Add</button>
        </div>
    </div>
</form>