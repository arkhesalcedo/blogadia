<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;
use App\Info;
use App\Events\NewUserRegister;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, HasInfo, HasSocial, HasPermission, HasSites, HasCampaign;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function createUser($email, $password, $role)
    {
        $user = self::create([
            'email' => $email,
            'password' => bcrypt($password),
        ])->assignRole($role);

         event(new NewUserRegister($user));

         return $user;
    }

    public function toggle()
    {
        return $this->trashed() ? $this->restore() : $this->delete(); 
    }

    public function isOwned()
    {
        return auth()->user()->id == $this->id ? true : false;
    }

    public function isVerified()
    {
        if ($this->sites()->count() > 0) {
            return $this->sites()->first()->verified;
        }

        return false;
    }

    public function getBloggers()
    {
        if ($this->info->subscription_id == 1) {
            return User::with('sites', 'info', 'social')->has('sites')->has('info')->has('social')->whereHas('sites', function($query){
                $query->where('verified', '!=', true);
            })->take(10)->get();
        }

        return User::with('sites', 'info', 'social')->has('sites')->has('info')->has('social')->paginate(10); 
    }

    public function reviews()
    {
        return $this->belongsToMany(User::class, 'comments', 'commenter_id', 'user_id')->withPivot('rating', 'message', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments', 'user_id', 'commenter_id')->withPivot('rating', 'message', 'id');
    }

    public function workedWith()
    {
        if (!auth()->user()->hasRole('administrator')) {
            $campaigns = auth()->user()->campaigns;

            foreach ($campaigns as $campaign) {
                return $campaign->offered($this->id);
            }
        }

        return false;
    }

    public function workedFor()
    {
        if (!auth()->user()->hasRole('administrator')) {
            $campaigns = $this->campaigns;

            foreach ($campaigns as $campaign) {
                return $campaign->offered(auth()->user()->id);
            }
        }

        return false;
    }

}
