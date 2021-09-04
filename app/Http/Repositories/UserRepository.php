<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(new User());
    }
}
