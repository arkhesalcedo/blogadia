<h3>Social Media</h3>
<hr>
<div class="row">
    <div class="col-sm-6">
        <form method="POST" action="{{ route('user.social.store', ['id' => $user->id]) }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="social">Type</label>
                <select name="social" class="form-control">
                    @foreach (App\Social::getAll() as $social_media)
                        <option value="{{ $social_media->id }}">{{ $social_media->label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="url">Link</label>
                <input id="url" type="text" name="url" class="form-control" placeholder="Link" value="{{ old('url') }}">
            </div>

            <div class="row">
                <div class="col-xs-6 col-xs-offset-6">
                    <button type="submit" class="btn btn-primary btn-block">Add Social Media</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6">
        @if($user->social->count() > 0)
            @foreach($user->social as $social)
                <form method="POST" action="{{ route('user.social.update', ['id' => $user->id, 'social_id' => $social->id ]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="_pivot" value="{{ $social->pivot->id }}">

                    <div class="form-group">
                        <label for="url">{{ $social->label }}</label>
                        <input id="url" type="text" name="url" class="form-control" placeholder="Link" value="{{ $social->pivot->url }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="checkbox pull-left">
                                <label>
                                    <input type="checkbox" name="delete_social"> <span class="text-danger">DELETE?</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Update</button>
                        </div>
                    </div>
                </form>
                <hr>
            @endforeach
        @else
            <div class="alert alert-info" role="alert">
                No users social media added yet!
            </div>
        @endif
    </div>
</div>