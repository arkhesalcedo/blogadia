<?php

namespace App;

trait HasSocial
{
    public function social()
    {
        return $this->belongsToMany(Social::class)->withPivot('id', 'url');
    }
}
