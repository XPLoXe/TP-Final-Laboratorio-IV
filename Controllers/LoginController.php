<?php
    namespace Controllers;

    use Config\Message as Message;
    use Controllers\StudentController as StudentController;
    use Controllers\UserController as UserController;
    use Controllers\CompanyController as CompanyController;
    use DAO\JobOfferDAO as JobOfferDAO;
    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Utils\Utils as Utils;
    use Models\Student as Student;
    use Models\Company as Company;

    class LoginController
    {
        private $message;


        public function ShowLoginView(array $parameters): void
        {
            $message = $parameters['message'];
            require_once(VIEWS_PATH."login.php");
        }

        public function Login(): void
        {
            $jobOfferDAO = new JobOfferDAO;

            if ($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $message = "";

                $userController = new UserController();
                
                if ($userController->IsEmailInDataBase($email)) //TODO: rewrite
                {
                    $user = $userController->GetUserByEmail($email);
                    
                    if ($user->getPassword() == $password)
                    {                        
                        if ($user->getUserRoleDescription() == ROLE_ADMIN)
                        {
                            //$jobOfferDAO->TryDatabaseUpdate(); 
                            $_SESSION["loggedUser"] = $user;//admin
                            header('location:'.FRONT_ROOT.'Home/Index');
                        }
                        else if ($user->getUserRoleDescription() == ROLE_STUDENT)
                        {
                            $studentController = new StudentController();
                            $student = $studentController->GetStudentByUserId($user->getUserId());

                            if ($student->isApiActive())
                            {
                                //$jobOfferDAO->TryDatabaseUpdate();
                                $_SESSION["loggedUser"] = $student;
                                header('location:'.FRONT_ROOT.'Home/Index');
                            }
                            else
                            {
                                header('location:'.FRONT_ROOT.'Login/ShowLoginView?message='.STUDENT_INACTIVE);
                            }
                        }
                        else if ($user->getUserRole()->getDescription() == ROLE_COMPANY)
                        {
                            $companyController = new CompanyController();
                            $company = $companyController->GetCompanyByUser($user);

                            if ($company->isApproved())
                            {
                                //$jobOfferDAO->TryDatabaseUpdate();
                                $_SESSION["loggedUser"] = $company;
                                header('location:'.FRONT_ROOT.'Home/Index');
                            }
                            else
                            {
                                $message = COMPANY_NOT_APPROVED;
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
                    $message = WRONG_EMAIL;// el mail no esta en la bd, no se puede logear
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


        public function ShowSignupCompanyView(): void
        {
            require_once(VIEWS_PATH."company-register.php");
        }
    }