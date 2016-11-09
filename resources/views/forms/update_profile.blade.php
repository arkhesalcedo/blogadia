<h3>Update Profile</h3>
<hr>
<form method="POST" action="{{ route('user.info.update', ['id' => $user->id, 'info_id' => $user->info->id]) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}

    <div class="col-sm-6">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') ?? $user->info->first_name }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') ?? $user->info->last_name }}">
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <select name="country" class="form-control">
                @foreach (config('settings.countries') as $country_code => $country)
                    <option value="{{ $country_code }}" {{ $user->info->country == $country_code ? 'selected' : '' }}>{{ $country }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="reference">How did you hear about us?</label>
            <select name="reference" class="form-control">
                @foreach (config('settings.reference') as $reference)
                    <option value="{{ $reference }}" {{ $user->info->reference == $reference ? 'selected' : '' }}>{{ $reference }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label for="subscribe">
                    <input id="subscribe" type="checkbox" name="subscribe" {{ $user->info->subscribe ? 'checked' : '' }}>
                    Yes! Send me useful emails every now and then to help me get the most out of BlogADia.
                </label>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
        </div>
    </div> 
    
</form>