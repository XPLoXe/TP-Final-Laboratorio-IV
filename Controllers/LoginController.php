<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Utils\Utils as Utils;

    use DAO\JobPositionDAO as JobPositionDAO;
    use DAO\CareerDAO as CareerDAO;

    class LoginController
    {
        private $message;

        public function Login()
        {
            $parameters = array();
            
            if ($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $parameters = $_POST;
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Load users
                $userDAO = new userDAO();
                $user = new User();
                if ($userDAO->VerifyEmailDataBase($email)) {
                    $user = $userDAO->getUserByEmail($email);
                    if (($email == "admin@admin.com") && ($password == "12345")) 
                    {

                        $_SESSION["loggedUser"] = $user; 
                        $message = "";
                        require_once(VIEWS_PATH."home.php");
                    } else
                    {
                            
                        if ($password == $user->getPassword()) 
                        {
                            $_SESSION["loggedUser"] = $user;
                            require_once(VIEWS_PATH."home.php");
                        }
                        else
                        {
                            $this->message = "<h4 class = 'text-center' style='color: red;'> Contraseña incorrecta </h4>";
                            $message = $this->message;
                            require_once(VIEWS_PATH."login.php");
                        }
                    }
                }
                else
                {
                    $this->message = "<h4 class = 'text-center' style='color: red;'> El Email ingresado no existe </h4>";
                    $message = $this->message;
                    require_once(VIEWS_PATH."login.php");
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
            $message = "";
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