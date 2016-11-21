<div class="row">
    <div class="col-sm-12">
        <p><span class="bold">Name: </span>{{ $campaign->name }}</p>
        <p><span class="bold">Description: </span>{{ $campaign->description }}</p>
        <p><span class="bold">Content: </span>{{ $campaign->content }}</p>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <p><span class="bold">Duration: </span>{{ config('settings.duration')[$campaign->duration] }}</p>
                <p><span class="bold">Number of Bloggers: </span>{{ $campaign->number_of_bloggers }}</p>
                <p><span class="bold">Budget: </span>{{ money_format('%.2n', $campaign->budget) }}</p>
                <p><span class="bold">Categories: </span></p>
                @foreach ($campaign->categories as $category)
                    <span class="btn btn-info btn-xs">{{ $category->name }}</span>
                @endforeach
            </div>
            <div class="col-sm-6">
                @if(!$campaign->uploads->isEmpty())
                    <p><span class="bold">Attachments: </span></p>
                    @foreach ($campaign->uploads as $files)
                        <a href="{{ asset($files->path) }}" id="download" class="btn btn-success btn-xs" download>{{ $files->type }}</a><br><br>
                    @endforeach
                @endif
                @can('update', $campaign)
                    <hr>
                    <a href="{{ route('user.campaign.edit', ['id' => $campaign->user->id, 'campaign_id' => $campaign->id]) }}" class="btn btn-primary pull-right">Edit</a>
                @endcan
                @if(auth()->user()->hasRole('blogger'))
                    @if(!$campaign->invited(auth()->user()->id))
                        <hr>
                        <form action="{{ url('apply') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="5"></textarea>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary pull-right">Apply</button>
                        </form>
                    @endif
                    @if($campaign->offered(auth()->user()->id))
                        <hr>
                        <h3>Leave a comment</h3>

                        <form action="{{ url('comment') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ $campaign->user->id }}">
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select id="rating" name="rating" class="form-control">
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Stars</option>
                                </select>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
        <hr>
        @if(!$campaign->invitedUsers->isEmpty())
            <h3>Invited Bloggers / Bloggers Who Applied</h3>
            <hr>
            @foreach($campaign->invitedUsers as $blogger)
                <div class="bs-callout bs-callout-primary">
                    <h4>{{ $blogger->getFullName() }} <a href="{{ route('user.show', ['id' => $blogger->id]) }}" class="btn btn-xs btn-info pull-right" target="_blank">View Blogger</a></h4>
                    <p class="italic">{{ $blogger->pivot->message }}</p>
                </div>
            @endforeach
        @endif
    </div>
</div>

@section('footer')
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
                                item.text('Invite').removeClass('btn-danger').addClass('btn-success');
                                break;
                            case 'Invite':
                                item.text('Cancel Invitation').removeClass('btn-success').addClass('btn-danger');
                                break;
                        }
                    }
                });
            });
        });
    </script>
@endsection