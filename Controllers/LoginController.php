<?php
    namespace Controllers;

    class LoginController
    {
        public function Login()
        {
            $parameters = array();
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $parameters = $_POST;
                $email = $_POST["user"];
                $password = $_POST["password"];
        

                if (($email == "usuario") && ($password == "123"))
                {
                    session_start();
                    $loggedUser = new Client();
                    $loggedUser->setUserName($email);
                    $loggedUser->setPassword($password);
                    $_SESSION["loggedUser"] = $loggedUser;
                    header("location:nav.php");
                }
            }
            else
            {
                header("location:index.php");
            }
        }
    }
?>