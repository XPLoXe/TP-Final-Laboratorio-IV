<?php
    namespace Controllers;

    use Config\Message as Message;
    use Controllers\studentController as studentController;
    use DAO\JobOfferDAO as JobOfferDAO;
    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Utils\Utils as Utils;

    class LoginController
    {
        private $message;

        
        public function Login(): void
        {
            $jobOfferDAO = new JobOfferDAO;
            
            if ($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $message = "";

                $studentController = new StudentController;
                $userController = new UserController;
                $user = new User;
                
                if ($userController->VerifyEmailDataBase($email)) 
                {
                    $user = $userController->GetUserByEmail($email);
                    
                    if ($password == $user->getPassword())
                    {                        
                        if ($user->getUserRole()->getDescription() == ROLE_ADMIN)
                        {
                            $jobOfferDAO->TryDatabaseUpdate();

                            $_SESSION["loggedUser"] = $user;   
                            require_once(VIEWS_PATH."home.php");
                        } 
                        else
                        {
                            if ($studentController->GetStudentByEmail($email)->isActive())  //checks if user is active in the API 
                            {
                                $jobOfferDAO->TryDatabaseUpdate();

                                $_SESSION["loggedUser"] = $user;
                                require_once(VIEWS_PATH."home.php");
                            }
                            else
                            {
                                $message = STUDENT_INACTIVE;
                                require_once(VIEWS_PATH."login.php");
                            }
                        }
                    }
                    else
                    {
                        $message = WRONG_PASSWORD;
                        require_once(VIEWS_PATH."login.php");
                    }
                } else
                {
                    $message = WRONG_EMAIL;
                    require_once(VIEWS_PATH."login.php");
                }
            } else
            {
                header("location:login.php");
                exit;
            }
        }


        public function Logout(): void
        {
            $_SESSION = array();
            session_destroy();
            $message = "";
            require_once(VIEWS_PATH."login.php");
        }


        public function ShowSignupView(): void
        {
            $userRoleController = new UserRoleController();
            $message = "";
            $studentRoleId = $userRoleController->GetIdByDescription(ROLE_STUDENT);
            require_once(VIEWS_PATH."signup.php");
        }

       
    }