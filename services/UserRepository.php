<?php


use entities\DeliveryInfo;
use entities\User;
use services\Connection;
use services\Log;

class UserRepository
{

    static function getAll(): array
    {
        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("SELECT * FROM USER");
            $stmt->execute();
            $users_row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $users = array();
            foreach ($users_row as $user) {
                array_push($users, User::load($user));
            }
            return $users;
        } catch (Exception $e) {
            var_dump($e);
            Log::write_line($e);
        }
    }

    static function updateUserByEmail($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip)
    {
        try {
            DeliveryInfo::update($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip);
        } catch (Exception $e) {
            var_dump($e);
            Log::write_line($e);
        }
    }

    static function updateUserById($id, $name, $surname, $phone_number, $city, $street, $home_number, $zip)
    {
        try {
            DeliveryInfo::updateByUserId($id, $name, $surname, $phone_number, $city, $street, $home_number, $zip);
            Log::write_line($name);
        } catch (Exception $e) {
            var_dump($e);
            Log::write_line($e);
        }
    }

    static function createUser($password, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip): ?User
    {
        try {
            $pdo = Connection::getPdoInstance();
            $delivery = DeliveryInfo::createRow($name, $surname, $email, $phone_number, $city, $street, $home_number, $zip);
            $hashpass = password_hash($password,
                PASSWORD_DEFAULT);
            $deliId = $delivery->getId();

            $stmt = $pdo->prepare("INSERT INTO USER SET email = :email, password = :password , delivery_info = :delivery_info");
            $stmt->bindParam(':password', $hashpass);
            $stmt->bindParam(':delivery_info', $deliId);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $id = $pdo->lastInsertId();

            return User::create($id, $hashpass, $delivery, 1);
        } catch (\Exception $e) {
            var_dump($e);
            Log::write_line($e);
            return null;
        }

    }

    static function getById($id): ?User
    {
        try {
            $pdo = Connection::getPdoInstance();
            $stmt = $pdo->prepare("SELECT * FROM USER WHERE id =:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $userRow = $stmt->fetch();

            if ($userRow != false) {
                return User::load($userRow);
            }
            return null;
        } catch (\Exception $e) {
            Log::write_line($e);
            var_dump($e);
        }
    }


    static function deleteUser($id)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("DELETE FROM USER WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    static function getByEmail(string $email)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select * from USER where email =:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static function getEmail($id): string
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("SELECT email FROM USER_DELIVERY where id =:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $userRow = $stmt->fetch();
        return $userRow["email"];

    }

    static function getUsersDeliveryInfo($id): array
    {
        try {
            $pdo = Connection::getPdoInstance();
            var_dump($id);
            $stmt = $pdo->prepare("SELECT i.* FROM USER u inner join DELIVERY_INFO i on u.delivery_info = i.id WHERE u.id =:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            Log::write_line($e);
        }
    }
}