<?php

namespace services;

use entities\User;
use UserRepository;

class AuthController
{

    static function register($password, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip): ?User
    {
        try {
            return UserRepository::createUser($password, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip);
        } catch (\Exception $e) {
            var_dump($e);
            Log::write_line($e);
            return null;
        }

    }


    /** login user into system and put his email into $_SESSIN[LOGGED_USER_EMAIL]
     * if email and password is correct
     *
     * @param string $email
     * @param string $password
     * @return true if success false when email or password is incorrect
     */
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
        $id = $_SESSION[USER_ID];
        $user = UserRepository::getById($id);
        if ($user == null) {
            return false;
        }
        return $user->getRole() == 2;

    }

    static function logout()
    {
        unset($_SESSION[USER_ID]);
    }

    static function getMe(): ?User
    {
        if (isset($_SESSION[USER_ID])) {
            return UserRepository::getByid($_SESSION[USER_ID]);
        }
        return null;
    }


}