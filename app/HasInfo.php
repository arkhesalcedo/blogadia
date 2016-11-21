<?php

namespace App;

trait HasInfo
{
    public function info()
    {
        return $this->hasOne(Info::class);
    }

    public function createInfo()
    {
    	$info = new Info;
        $info->user_id = $this->id;
        $info->country = 'PH';
        $info->save();

        return $this;
    }

    public function getFirstName()
    {
        return $this->info ? $this->info->first_name : $this->getRoleLabel();
    }

    public function getFullName()
    {
        if ($this->info) {
            if (!$this->info->first_name && !$this->info->last_name) {
                return $this->email;
            }

            return $this->info->first_name . ' ' . $this->info->last_name;
        }

        return 'Administrator';
    }
}
