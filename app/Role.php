<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'label'
    ];

    public function permissions()
    {
    	return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
    	return $this->permissions()->save($permission);
    }

    public static function getUserRoles()
    {
        return self::where('name', '!=', 'administrator')->get(['name', 'label']);    
    }

    public static function getRole($name)
    {
        return self::whereName($name)->firstOrFail();
    }

}
