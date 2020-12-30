<?php


use entities\Role;
use services\Connection;


class UserRepository
{

    static function getAll(): array
    {
        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("SELECT * FROM USER");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            var_dump($e);
            return [];
        }
    }

    static function updateUserById($id, $name, $surname, $phone_number, $city, $street, $home_number, $zip, $email)
    {
        try {
            self::updateDeliveryInfo($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip, $id);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    static function createUser($password, $name, $surname, $email, $phone_number, $city, $street, $home_number, $zip, $role = Role::user): ?int
    {
        try {
            $userId = self::createUserRow($password, Role::user, $email);
            self::createDeliveryInfo($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip, $userId);

            return $userId;
        } catch (\Exception $e) {
            var_dump($e);
            return null;
        }

    }

    static function getUserById($id)
    {
        try {
            $pdo = Connection::getPdoInstance();
            $stmt = $pdo->prepare("SELECT * FROM USER WHERE id =:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
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


    static function getUsersDeliveryInfo($id): array
    {
        try {
            $pdo = Connection::getPdoInstance();
            $stmt = $pdo->prepare("SELECT i.* FROM DELIVERY_INFO i WHERE i.id_user =:id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {

        }
    }

    public static function updateDeliveryInfo($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip, $userId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("UPDATE DELIVERY_INFO SET name =:name , surname =:surname , city :=city, street =:street , home_number:= home_number ,zip =:zip, email = :email where id_user = :id_user");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':home_number', $home_number);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':id_user', $userId);
        $stmt->execute();
    }

    public static function createDeliveryInfo($email, $name, $surname, $phone_number, $city, $street, $home_number, $zip, $userId)
    {
        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("INSERT INTO DELIVERY_INFO(name, surname , city, street , home_number,zip , email , id_user, phone_number ) VALUES(:name , :surname , :city, :street , :home_number ,:zip, :email, :id_user, :phone_number)");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':home_number', $home_number);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':id_user', $userId);
        $stmt->bindParam(':phone_number', $phone_number);

        $stmt->execute();
    }

    public static function createUserRow($password, $role, $email)
    {
        $hashpass = password_hash($password,
            PASSWORD_DEFAULT);

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("insert into USER(email, password,role) values (:email,:password,:role)");
        $stmt->bindParam(':password', $hashpass);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public static function getUserRole($uid): string
    {

        $pdo = Connection::getPdoInstance();
        $stmt = $pdo->prepare("select role from USER where id = :id");
        $stmt->bindParam(':id', $uid);
        $stmt->execute();
        return $stmt->fetch()["role"];
    }

    public static function changeUserPass($uid, $password)
    {
        $pdo = Connection::getPdoInstance();
        $hashpass = password_hash($password,
            PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE USER SET password =:password where id = :id");
        $stmt->bindParam(':id', $uid);
        $stmt->bindParam(':password', $hashpass);
        $stmt->execute();
    }
}