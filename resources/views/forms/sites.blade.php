<h3>Sites</h3>
<hr>
<div class="row">
    <div class="col-sm-12">
        @if($user->sites->count() > 0)
            @foreach($user->sites as $site)
                <form method="POST" action="{{ route('user.site.update', ['id' => $user->id, 'site_id' => $site->id ]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Site Name</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Site Name" value="{{ $site->name }}">
                        </div>
                        <div class="form-group">
                            <label for="url">Site Url</label>
                            <input id="url" type="text" name="url" class="form-control" placeholder="Site Url" value="{{ $site->url }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Site Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ $site->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Site Logo</label>
                            <input type="file" name="image" class="form-control">
                            @if($site->image_path)
                                <img src="{{ asset($site->image_path) }}" class="img-responsive thumbnail">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select for="category" class="form-control" name="category_id">
                                @foreach(App\Category::get() as $category)
                                    <option value="{{ $category->id }}" {{ $site->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="age">Age of Site</label>
                            <select id="age" class="form-control" name="age">
                                @foreach (config('settings.age') as $key => $value)
                                    <option value="{{ $key }}" {{ $site->age == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pageviews">Estimated Monthly Page View</label>
                            <select id="pageviews" class="form-control" name="pageviews">
                                @foreach (config('settings.pageviews') as $key => $value)
                                    <option value="{{ $key }}" data-price="{{ $value[1] }}" {{ $site->pageviews == $key ? 'selected' : '' }}>{{ $value[0] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Your Ad Price Per Month</label>
                            <input id="price" type="text" name="price" class="form-control" placeholder="in PHP" value="{{ $site->price }}">
                        </div>
                        <div class="form-group">
                            <label for="posts_per_month">Average Post per month</label>
                            <select id="posts_per_month" class="form-control" name="posts_per_month">
                                @foreach (config('settings.posts_per_month') as $key => $value)
                                    <option value="{{ $key }}" {{ $site->posts_per_month == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="google_analytics">Do you have Google Analytics on your site?</label>
                            <select id="google_analytics" class="form-control" name="google_analytics">
                                <option value="1" {{ $site->google_analytics ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$site->google_analytics ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantcast">Do you have Quantcast on your site?</label>
                            <select id="quantcast" class="form-control" name="quantcast">
                                <option value="1" {{ $site->quantcast ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$site->quantcast ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="commit">Will you make 1 year commitment to BlogADia?</label>
                            <select id="commit" class="form-control" name="commit">
                                <option value="1" {{ $site->commit ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$site->commit ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <hr>
                        @if(auth()->user()->hasRole('administrator'))
                            @can('update', $user)
                                <div class="form-group">
                                    <label for="verified" class="text-warning">Verified Blogger?</label>
                                    <select id="verified" class="form-control" name="verified">
                                        <option value="1" {{ $site->verified ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$site->verified ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            @endcan
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-8">
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </div>
                </div>
            </form>
            @endforeach
        @else
            <form method="POST" action="{{ route('user.site.store', ['id' => $user->id]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Site Name</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Site Name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="url">Site Url</label>
                            <input id="url" type="text" name="url" class="form-control" placeholder="Site Url" value="{{ old('url') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Site Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Site Logo</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select for="category" class="form-control" name="category_id">
                                @foreach(App\Category::get() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="age">Age of Site</label>
                            <select id="age" class="form-control" name="age">
                                @foreach (config('settings.age') as $key => $value)
                                    <option value="{{ $key }}" {{ old('age') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pageviews">Estimated Monthly Page View</label>
                            <select id="pageviews" class="form-control" name="pageviews">
                                @foreach (config('settings.pageviews') as $key => $value)
                                    <option value="{{ $key }}" data-price="{{ $value[1] }}" {{ old('pageviews') == $key ? 'selected' : '' }}>{{ $value[0] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Your Ad Price Per Month</label>
                            <input id="price" type="text" name="price" class="form-control" placeholder="in PHP" value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label for="posts_per_month">Average Post per month</label>
                            <select id="posts_per_month" class="form-control" name="posts_per_month">
                                @foreach (config('settings.posts_per_month') as $key => $value)
                                    <option value="{{ $key }}" {{ old('posts_per_month') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="google_analytics">Do you have Google Analytics on your site?</label>
                            <select id="google_analytics" class="form-control" name="google_analytics">
                                <option value="1" {{ old('google_analytics') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('google_analytics') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantcast">Do you have Quantcast on your site?</label>
                            <select id="quantcast" class="form-control" name="quantcast">
                                <option value="1" {{ old('quantcast') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('quantcast') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="commit">Will you make 1 year commitment to BlogADia?</label>
                            <select id="commit" class="form-control" name="commit">
                                <option value="1" {{ old('commit') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('commit') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-8">
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

@section('scripts')
    <script>
        $(function(){
            var pageviews = $('#pageviews');
            var price = $('#price');

            pageviews.on('change', function(){
                setPrice();
            });

            function setPrice() {
                price.val($('#pageviews option:selected').data('price'));
            }

            setPrice();
        });
    </script>
@endsection