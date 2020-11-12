<?php


class Connection
{
    static private $instance = NULL;

    static function getPdoInstance(): PDO
    {

        if (self::$instance == NULL) {
            try {
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance = $conn;

            } catch (Exception $e) {
                echo($e);
            }
        }
        // set the PDO error mode to exception
        return self::$instance;

    }

}