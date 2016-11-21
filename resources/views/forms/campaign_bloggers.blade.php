@if(!$campaign->offeredBloggers()->isEmpty())
    <h3>Offered to Bloggers</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Site</th>
                <th>Ad Price/mo</th>
                <th>Page View/mo</th>
                <th>Post/mo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaign->offeredBloggers() as $blogger)
                <tr>
                    <td>{{ $blogger->getFullName() }}</td>
                    <td>{{ $blogger->sites()->first()->name }} {!! $blogger->isVerified() ? '<span class="label label-success">Verified</span>' : '<span class="label label-warning">Unverified</span>' !!}</td>
                    <td>{{ money_format('%.2n', $blogger->sites()->first()->price) }}</td>
                    <td>{{ config('settings.pageviews')[$blogger->sites()->first()->pageviews][0] }}</td>
                    <td>{{ config('settings.posts_per_month')[$blogger->sites()->first()->posts_per_month] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
@endif
@if(!$campaign->maxedBloggers() && !$bloggers->isEmpty())
<h3>Invite Bloggers</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Site</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bloggers as $blogger)
            @if(!$campaign->offered($blogger->id))
            <tr>
                <td>{{ $blogger->getFullName() }}</td>
                <td>{!! $blogger->isVerified() ? '<span class="label label-success">Verified</span>' : '<span class="label label-warning">Unverified</span>'  !!}</td>
                <td>
                    <a href="{{ route('user.show', ['id' => $blogger->id]) }}" class="btn btn-xs btn-info" target="_blank">View</a>
                    <a href="{{ url('invite') . '/' . $campaign->id . '/' . $blogger->id }}" class="btn btn-xs btn-{{ $campaign->invited($blogger->id) ? 'danger' : 'success' }} ajax">{{ $campaign->invited($blogger->id) ? 'Cancel Invitation' : 'Invite' }}</a>
                    <a href="{{ url('offer') . '/' . $campaign->id . '/' . $blogger->id }}" class="btn btn-xs btn-primary offer {{ $campaign->invited($blogger->id) ? '' : 'hide' }}">Offer Job</a>
                </td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>

@section('scripts')
    <script>
        $(function(){
            $('.btn.ajax').click(function(ev){
                ev.preventDefault();
                var item = $(this);
                $.ajax({
                    url: item.prop('href'),
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    success: function(data){
                        switch (item.text()) {
                            case 'Cancel Invitation':
                                item.text('Invite').removeClass('btn-danger').addClass('btn-success').next('.offer').addClass('hide');
                                break;
                            case 'Invite':
                                item.text('Cancel Invitation').removeClass('btn-success').addClass('btn-danger').next('.offer').removeClass('hide');
                                break;
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endif