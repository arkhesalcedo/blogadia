<h3>{{ $user->trashed() ? 'Activate' : 'Deactivate' }} User</h3>
<hr>
<form method="POST" action="{{ route('user.destroy', ['id' => $user->id]) }}">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}

    <p class="text-danger">This account will be deactivated and you will not be able to access this account's information until you re-activate this account.</p>

    <div class="row">
        <div class="col-xs-4 col-xs-offset-8">
            <button type="submit" class="btn btn-{{ $user->trashed() ? 'success' : 'danger' }} btn-block">{{ $user->trashed() ? 'Activate' : 'Deactiavte' }}</button>
        </div>
    </div>
</form>