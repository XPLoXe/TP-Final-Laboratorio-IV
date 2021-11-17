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

        
        public function Login(): void
        {
            $jobOfferDAO = new JobOfferDAO;
            
            $prices = $this->GetPricesFromBinance();

            foreach ($prices as $k => $v)
            {
                if ($v['symbol'] == 'BTCUSDT')
                {
                    $btc = (double)$v['price'];
                }
                
                if ($v['symbol'] == 'ETHUSDT')
                {
                    $eth = (double)$v['price'];
                }
                
                if ($v['symbol'] == 'LTCUSDT')
                {
                    $ltc = (double)$v['price'];
                }
            }

            if ($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $message = "";

                $userController = new UserController();
                
                if ($userController->IsEmailInDataBase($email)) 
                {
                    $user = $userController->GetUserByEmail($email);
                    
                    if ($user->getPassword() == $password)
                    {                        
                        if ($user->getUserRole()->getDescription() == ROLE_ADMIN)
                        {
                            //$jobOfferDAO->TryDatabaseUpdate(); 
                            $_SESSION["loggedUser"] = $user;//admin
                            require_once(VIEWS_PATH."home.php");
                        }
                        else if($user->getUserRole()->getDescription() == ROLE_STUDENT)
                        {
                            $studentController = new StudentController();
                            $studentToLogged = $studentController->GetStudentByUser($user);

                            if ($studentToLogged->isApiActive())
                            {
                                //$jobOfferDAO->TryDatabaseUpdate();
                                $_SESSION["loggedUser"] = $studentToLogged;
                                require_once(VIEWS_PATH."home.php");
                            }
                            else
                            {
                                $message = STUDENT_INACTIVE;
                                require_once(VIEWS_PATH."login.php");
                            }
                        }
                        else if($user->getUserRole()->getDescription() == ROLE_COMPANY)
                        {
                            $companyController = new CompanyController();
                            $companyToLogged = $companyController->GetCompanyByUser($user);

                            if ($companyToLogged->isApproved())
                            {
                                //$jobOfferDAO->TryDatabaseUpdate();
                                $_SESSION["loggedUser"] = $companyToLogged;
                                require_once(VIEWS_PATH."home.php");
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

        private function GetPricesFromBinance()
        {
            $data = file_get_contents(BINANCE_URL);
            $json = json_decode($data, true);

            return $json;
        }




    }