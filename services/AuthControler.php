<?php

class AuthControler
{


    /** @returns true when registration successful else false */
    static function register($jmeno, $prijmeni, $email, $heslo, $mesto, $ulice, $cisloPopisne, $psc): bool
    {
        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("INSERT INTO uzivatel( jmeno, prijmeni,email, heslo,mesto, ulice,cislo_popisne, psc)
        VALUES( :jmeno , :prijmeni , :email, :heslo, :mesto , :ulice, :cisloPopisne, :psc)");
            $stmt->bindParam(':jmeno', $jmeno);
            $stmt->bindParam(':prijmeni', $prijmeni);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':heslo', $heslo);
            $stmt->bindParam(':mesto', $mesto);
            $stmt->bindParam(':ulice', $ulice);
            $stmt->bindParam(':cisloPopisne', $cisloPopisne);
            $stmt->bindParam(':psc', $psc);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }

    }


    /** login user into system and put his email into $_SESSIN[LOGGED_USER_EMAIL]
     * if email and password is correct
     *
     * @return true if success false when email or password is incorrect
     */
    static function login($email, $password): bool
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare(
            "SELECT u.email 
                        FROM uzivatel u 
                        WHERE  u.email='$email' and u.heslo='$password'");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':heslo', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user["email"] != null) {
            $_SESSION[LOGGED_USER_EMAIL] = $user["email"];

            return true;
        }
        return false;
    }


    static function isLoggedIn(): bool
    {
        return isset($_SESSION[LOGGED_USER_EMAIL]);
    }


    static function isAdmin(): bool
    {
        $email = $_SESSION[LOGGED_USER_EMAIL];
        echo($_SESSION[LOGGED_USER_EMAIL]);

        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("SELECT u.role FROM uzivatel u WHERE  u.email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $role = $stmt->fetch();
        return $role["role"] == 2;
    }

    static function logout()
    {
        unset($_SESSION[LOGGED_USER_EMAIL]);
    }

    static function getMe()
    {
        if (isset($_SESSION[LOGGED_USER_EMAIL])) {

            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare(
                "SELECT * 
                        FROM uzivatel u 
                        WHERE  u.email=:email");
            $stmt->bindParam(':email', $_SESSION[LOGGED_USER_EMAIL]);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
        return null;
    }


}