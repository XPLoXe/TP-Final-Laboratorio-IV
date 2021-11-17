<?php
    namespace Controllers;

    use DAO\StudentDAO as StudentDAO;
    use DAO\UserDAO as UserDAO;
    use DAO\UserRoleDAO as UserRoleDAO;
    use Models\Student as Student;
    use Models\User as User;
    use Models\UserRole as UserRole;
    use Utils\Utils as Utils;


    class UserController
    {
        private $userDAO;
        private $userRoleController;
        private $message;
        private $studentController;
        private $userRoleDAO;


        public function __construct()
        {
            $this->studentController = new StudentController();
            $this->userRoleController = new UserRoleController();
            $this->message = "";
            $this->userDAO = new UserDAO();
            $this->userRoleDAO = new userRoleDAO();
        }


        private function Add(string $email, string $password, int $userRoleId)
        {          
            $userRole = $this->userRoleDAO->GetUserRoleById($userRoleId);

            $student = new Student();
            $student = $this->studentController->GetStudentByEmail($email);

            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setFirstName($student->getFirstName());
            $user->setLastName($student->getLastName());
            $user->setUserRole($userRole);
            $user->setAssociatedId($student->getStudentId());

            $this->userDAO->Add($user);
        }

    
        public function GetUserByEmail(string $email): User
        {
            return $this->userDAO->GetUserByEmail($email);
        }


        public function GetUserById(int $userId): User
        {
            return $this->userDAO->GetUserById($userId);
        }


        public function VerifyPassword(string $password, string $passwordConfirmation): bool
        {
            if (strcmp($password, $passwordConfirmation) == 0)
                return true;
            else
            {
                $this->message = ERROR_VERIFY_PASSWORD;
                return false;
            }
        }


        public function IsEmailInDataBase(string $email): bool
        {
            if ($this->userDAO->IsEmailInDB($email))
            {
                $this->message = ERROR_VERIFY_EMAIL_DATABASE;//error para el register
                return true;
            } 
            return false;
        }


        public function Register(array $parameters): void
        {
            $email = $parameters['email'];
            $password = $parameters['password'];
            $passwordConfirmation = $parameters['password_confirmation'];
            $userRoleId = (int) $parameters['user_role_id'];

            if ($this->studentController->IsStudentActiveInUniversity($email))
            {
                if ($this->VerifyPassword($password, $passwordConfirmation))
                {
                    if (!$this->IsEmailInDataBase($email))
                    {   
                        $this->Add($email, $password, $userRoleId);

                        $message = SIGNUP_SUCCESS;

                        if (Utils::isAdmin())
                            require_once(VIEWS_PATH."home.php");
                        else
                            require_once(VIEWS_PATH."login.php");
                    }
                }
            } else
            {
                $message = ERROR_VERIFY_EMAIL;
                require_once(VIEWS_PATH."signup.php");
            }
        }


        public function ShowAddView()
        {
            Utils::checkAdmin();

            require_once(VIEWS_PATH."user-add.php");
        }


        public function ShowListView()
        {
            Utils::checkUserLoggedIn();

            $userList = $this->userDAO->GetAll();

            require_once(VIEWS_PATH."user-list.php");
        }
    }