<?php

namespace App\Contracts;

interface UserInterface extends CrudInterface
{
    public function allUsers($request);
}