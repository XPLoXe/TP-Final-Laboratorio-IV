<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Utils\Utils as Utils;

    class LoginController
    {
        public function Login()
        {
            $parameters = array();
            
            if ($_SERVER['REQUEST_METHOD'] == "POST") 
            {
                $parameters = $_POST;
                $email = $_POST["email"];
                $password = $_POST["password"];

                if (($email == "admin@admin.com") && ($password == "12345")) {
                    $_SESSION["loggedUser"] = "admin";
                    $_SESSION["isAdmin"] = true;
                    require_once(VIEWS_PATH."home.php");
                } else
                {
                    //Load users
                    $userDAO = new userDAO();
                    $userList = array();
                    $userList = $userDAO->GetAll();
                    $user = new User();
                    $user = $userDAO->getUserByEmail($email); //TODO: write method

                    if (!is_null($user)) {
                        
                        if (true) { // TODO: check user password
                            $_SESSION["loggedUser"] = $user;
                            require_once(VIEWS_PATH."home.php"); //Regular user redirect
                        }
                        else
                        {
                            echo "<script> if(confirm('Email or Password Incorrect, please try again'));</script>";
                            require_once(VIEWS_PATH."login.php");
                        }
                    }
                    else
                    {
                        echo "<script> if(confirm('Email not found'));</script>";
                        require_once(VIEWS_PATH."login.php");
                    }
                }
            } else
            {
                header("location:login.php");
                exit;
            }
        }


        public function Logout()
        {
            $_SESSION = array(); //Cleans every variable set in $_SESSION (session_destroy() does not clean them)
            session_destroy();
            require_once(VIEWS_PATH."login.php");
        }


        public function ShowSignupView()
        {
            $userRoleController = new UserRoleController();
            $message = "";
            $studentRoleId = $userRoleController->getIdByDescription(ROLE_STUDENT);
            require_once(VIEWS_PATH."signup.php");
        }
    }
?>