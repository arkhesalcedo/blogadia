<h3>New Campaign</h3>
<hr>
<div class="row">
    <div class="col-sm-12">
        <form method="POST" action="{{ url('campaign/store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" class="form-control" placeholder="Campaign Name" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Enter description...">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" rows="20" class="form-control" placeholder="Enter content...">{{ old('content') }}</textarea>
                        <p class="help-block">You can upload files after saving this campaign.</p>
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
                                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"> {{ $category->name }}
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
                        <input id="number_of_bloggers" type="number" min="1" name="number_of_bloggers" class="form-control" placeholder="Number of Bloggers" value="{{ old('number_of_bloggers') ?? 1 }}">
                    </div>

                    <div class="form-group">
                        <label for="budget">Budget</label>
                        <input id="budget" type="number" min="0" step="any" name="budget" class="form-control" placeholder="Enter budget" value="{{ old('budget') ?? 100 }}">
                    </div>

                    <div class="form-group">
                        <label for="advertiser">Select Advertiser</label>
                        <select name="user_id" id="advertiser" class="form-control">
                            @foreach ($advertisers as $advertiser)
                                <option value="{{ $advertiser->id }}">{{ $advertiser->getFullName() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-6">
                            <button type="submit" class="btn btn-primary btn-block">Add Campaign</button>
                        </div>
                    </div>  
                </div>
            </div>
        </form>
    </div>
</div>