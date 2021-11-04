<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\User as User;
    use Utils\Utils as Utils;
    use Controllers\StudentController as StudentController;

class LoginController
    {
        private $message;

        public function Login()
        {
            $parameters = array();
            $jobOfferDAO = new JobOfferDAO;
            
            if ($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $parameters = $_POST;
                $email = $_POST["email"];
                $password = $_POST["password"];
                $message = ""; //needs to be set in order to avoid Views errors in login.php when logging out

                // Load users
                $userController = new UserController;
                $user = new User();
                $StudentController = new StudentController();
                
                if ($userController->VerifyEmailDataBase($email)) {

                    $user = $userController->getUserByEmail($email);
                    
                    if ($password == $user->getPassword()) {
                        
                        if ($user->getUserRole()->getDescription() == ROLE_ADMIN)
                        {
                            $jobOfferDAO->updateDatabase();

                            $_SESSION["loggedUser"] = $user;   
                            require_once(VIEWS_PATH."home.php");
                        } 
                        else
                        {
                            if ($StudentController->getStudentByEmail($email)->isActive())  //checks if user is active in the API 
                            {
                                $jobOfferDAO->updateDatabase();

                                $_SESSION["loggedUser"] = $user;
                                require_once(VIEWS_PATH."home.php");
                            }
                            else
                            {
                                $this->message = "<h4 class = 'text-center' style='color: red;'> El Usuario ha sido dado de baja </h4>
                                                    <p class = 'text-center' style='color: red;'> Para más información contactarse con la universidad </p> ";
                                $message = $this->message;
                                require_once(VIEWS_PATH."login.php");
                            }
                            
                        }
                    }
                    else
                    {
                        $this->message = "<h4 class = 'text-center' style='color: red;'> Contraseña incorrecta </h4>";
                        $message = $this->message;
                        require_once(VIEWS_PATH."login.php");
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