<?php

class Register
{

    private $pdo;

    function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');

    }

    public function Hashing($pass)
    {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        return $hash;

    }

    public function InsertUser($login, $email, $hash, $firstname, $lastname, $phnumber)
    {
        $stmt = $this->pdo->prepare('INSERT INTO user (login, email, pass, firstname, lastname, phnumber)VALUE(:login, :email, :pass, :firstname,:lastname, :phnumber )');
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $hash);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':phnumber', $phnumber);
        $stmt->execute();

    }

    public function EscapeRederict($login, $email, $pass, $firstname, $lastname)
    {
        if (!empty($login) && !empty($email) && !empty($pass) && !empty($firstname) && !empty($lastname)) {
            $escapeRederict = true;
        }
        return $escapeRederict;

    }
}

$register = new Register ();

$hash = $register->Hashing($_POST['pass']);

$register->InsertUser($_POST['login'], $_POST['email'], $hash, $_POST['firstname'], $_POST['lastname'], $_POST['phnumber']);
echo json_encode($register->EscapeRederict($_POST['login'], $_POST['email'], $_POST['pass'], $_POST['firstname'], $_POST['lastname']));
