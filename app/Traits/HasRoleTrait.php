<?php

namespace App\Traits;

trait HasRoleTrait
{
    public function hasRole($roles)
    {
        if (is_array($roles)){
            return in_array($this->role, $roles);
        }
        return $this->role == $roles;
    }
}