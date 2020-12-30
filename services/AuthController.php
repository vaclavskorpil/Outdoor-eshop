<?php

namespace services;

use entities\User;
use UserRepository;

class AuthController
{

    static function register($password, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip): ?int
    {
        try {
            return UserRepository::createUser($password, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip);
        } catch (\Exception $e) {
            return null;
        }

    }


    static function login(string $email, string $password): bool
    {

        if ($user = UserRepository::getByEmail($email)) {
            $valid = password_verify($password, $user["password"]);

            if ($valid) {
                $_SESSION[USER_ID] = $user["id"];
                return true;
            }
        }

        return false;
    }


    static function isLoggedIn(): bool
    {
        return isset($_SESSION[USER_ID]);
    }


    static function isAdmin(): bool
    {
        if (!isset($_SESSION[USER_ID])) return false;

        $id = $_SESSION[USER_ID];
        return UserRepository::getUserRole($id) == "admin";
    }

    static function logout()
    {
        unset($_SESSION[USER_ID]);
    }


}