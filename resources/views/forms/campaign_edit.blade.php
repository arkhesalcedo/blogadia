@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@endsection

<h3>Update Campaign <a href="{{ route('user.campaign.show', ['id' => $campaign->user->id, 'campaign_id' => $campaign->id]) }}" class="btn btn-success pull-right">View</a></h3>
<hr>
<div class="row">
    <div class="col-sm-12">
        <form method="POST" action="{{ route('user.campaign.update', ['id' => $user->id, 'campaign_id' => $campaign->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" class="form-control" placeholder="Campaign Name" value="{{ $campaign->name }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Enter description...">{{ $campaign->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" rows="20" class="form-control" placeholder="Enter content...">{{ $campaign->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <p>Download Attachments</p>
                        @foreach ($campaign->uploads as $files)
                            <a href="{{ asset('storage/' . $files->path) }}" id="download" class="btn btn-success btn-xs" download>{{ $files->type }}</a><br><br>
                        @endforeach
                    </div>

                </div>

                <div class="col-sm-6">

                    <div class="form-group">
                        <label for="category">Type</label>
                        @foreach(App\Category::get()->chunk(3) as $categories)
                            <div class="row">
                                @foreach ($categories as $category)
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label for="cat_{{ $category->id }}">
                                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ $campaign->hasCategory($category->name) ? 'checked': '' }}> {{ $category->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <select name="duration" class="form-control">
                            @foreach (Config::get('settings.duration') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="number_of_bloggers">Number of Bloggers</label>
                        <input id="number_of_bloggers" type="number" min="1" name="number_of_bloggers" class="form-control" placeholder="Number of Bloggers" value="{{ $campaign->number_of_bloggers ?? 1 }}">
                    </div>

                    <div class="form-group">
                        <label for="budget">Budget</label>
                        <input id="budget" type="number" min="0" step="any" name="budget" class="form-control" placeholder="Enter budget" value="{{ $campaign->budget ?? 100 }}">
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-6">
                            <button type="submit" class="btn btn-primary btn-block">Update Campaign</button>
                        </div>
                    </div>  
                </div>
            </div>
        </form>
        @include('forms.campaign_status')
        <hr>
        <h3>Upload Files</h3>
        <form method="POST" class="dropzone" action="{{ url('campaign/' . $campaign->id . '/uploads') }}">
            {{ csrf_field() }}
        </form>
    </div>
</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
@endsection