<?php


class UserControler
{

    static function getAll()
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("SELECT * FROM uzivatel");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static function deleteUser($email)
    {
        var_dump($email);
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("DELETE FROM uzivatel WHERE email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    static function updateUser($jmeno, $prijmeni, $email, $ulice, $mesto, $cisloPopisne, $psc)
    {

        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("UPDATE uzivatel u 
set u.jmeno=:jmeno, u.prijmeni=:prijmeni, u.ulice=:ulice, u.mesto=:mesto, u.cislo_popisne=:cisloPopisne, u.psc=:psc
where u.email=:email");
        write_log(" email before trim " . $email);
        $email = trim($email);
        write_log(" email after trim " . $email);
        $stmt->bindParam(':email', $email );
        $stmt->bindParam(':jmeno', $jmeno);
        $stmt->bindParam(':prijmeni', $prijmeni);
        $stmt->bindParam(':ulice', $ulice);
        $stmt->bindParam(':mesto', $mesto);
        $stmt->bindParam(':cisloPopisne', $cisloPopisne);
        $stmt->bindParam(':psc', $psc);
        write_log($stmt->queryString);
        $stmt->execute();
    }

    static function getUser($email)
    {

        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare(
            "SELECT * 
                        FROM uzivatel u 
                        WHERE  u.email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}