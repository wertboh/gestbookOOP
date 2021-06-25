<?php
session_start();

class Login
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
    }

    function GetDataAboutUser($postEmail)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->bindParam(':email', $postEmail);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function RemoveHeshing($data)
    {
        $hesh = substr($data[0]['pass'], 0, 60);
        return $hesh;
    }

    function getSessionId($email, $pass, $hesh, $data)
    {
        if (!empty($email) && !empty($pass)) {
            if (password_verify($pass, $hesh) && $email == $data[0]['email'])
                $_SESSION['id_user'] = $data[0]['id_user'];
            else $_SESSION['id_user'] = NULL;
            return $_SESSION['id_user'];
        }
    }

}

$login = new Login ();
$informationAboutUser = $login->GetDataAboutUser($_POST['email']);
$hesh = $login->RemoveHeshing($informationAboutUser);
$getSessionId = $login->getSessionId($_POST['email'], $_POST['pass'], $hesh, $informationAboutUser);
echo json_encode($getSessionId);


