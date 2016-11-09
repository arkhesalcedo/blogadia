<?php

namespace App;

trait HasRoles {

	public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole(Role $role)
    {
        $this->roles()->save($role);

        return $this;
    }

    public function hasRole($name)
    {
        foreach ($this->roles as $role)
        {
            if ($role->name == $name)
            {
                return true;
            }
        }

        return false;
    }

    public function getRoleName()
    {
    	return $this->roles()->first()->name;
    }

    public function getRoleLabel()
    {
        return $this->roles()->first()->label;
    }
    
}