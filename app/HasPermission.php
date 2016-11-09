<?php

namespace App;

trait HasPermission
{
	public function hasPermission($name)
	{
		foreach ($this->roles as $role)
        {
            foreach ($role->permissions as $permission)
	        {
	            if ($permission->name == $name)
	            {
	                return true;
	            }
	        }
        }

        return false;
	}
}