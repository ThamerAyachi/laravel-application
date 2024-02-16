<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return Admin
     */
    public static function create($name, $email, $password)
    {
        $admin = new Admin();
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = bcrypt($password);

        $admin->save();

        return $admin;
    }
}
