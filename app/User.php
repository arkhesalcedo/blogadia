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
    use Notifiable, SoftDeletes, HasRoles, HasInfo, HasSocial, HasPermission, HasSites;

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

}
