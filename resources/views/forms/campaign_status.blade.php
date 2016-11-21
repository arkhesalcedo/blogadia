<h3>{{ $campaign->trashed() ? 'Activate' : 'Deactivate' }} Campaign</h3>
<hr>
<form method="POST" action="{{ route('user.campaign.destroy', ['id' => $user->id, 'campaign_id' => $campaign->id]) }}">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}

    <p class="text-danger">This campaign will be deactivated and you will not be able to access this campaign's information until you re-activate this campaign.</p>

    <div class="row">
        <div class="col-xs-4 col-xs-offset-8">
            <button type="submit" class="btn btn-{{ $campaign->trashed() ? 'success' : 'danger' }} btn-block">{{ $campaign->trashed() ? 'Activate' : 'Deactivate' }}</button>
        </div>
    </div>
</form>