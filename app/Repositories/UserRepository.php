<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public static function create($name, $email, $password)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);

        $user->save();

        return $user;
    }
}
