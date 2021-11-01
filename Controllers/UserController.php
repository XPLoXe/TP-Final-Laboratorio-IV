<?php
    namespace Controllers;

    use DAO\StudentDAO;
    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Models\UserRole as UserRole;
    use Utils\Utils as Utils;

    class UserController
    {
        private $userDAO;
        private $userRoleController;
        private $message;
        private $studentController;


        public function __construct()
        {
            $this->studentController = new StudentController();
            $this->message = "";
            $this->userDAO = new userDAO();
            $this->userRoleController = new UserRoleController();
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


        private function Add(string $email, string $password, int $userRoleId)
        {
            $userRole = new UserRole($userRoleId);
            $userRole->setDescription($this->userRoleController->getDescriptionById($userRoleId));
            
            $student = $this->studentController->getStudentByEmail($email);

            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setFirstName($student->getFirstName());
            $user->setLastName($student->getLastName());
            $user->setUserRole($userRole);

            $this->userDAO->Add($user);

        }
    
        public function getUserByEmail($email)
        {
            return $this->userDAO->getUserByEmail($email);
        }

        public function VerifyPassword(string $password, string $password_confirmation)
        {
            if (strcmp($password, $password_confirmation) == 0)
            {
                return true;
            }
            else
            {
                $this->message = "<h4 class = 'text-center' style='color: red;'> las contraseñas ingresadas no son las mismas </h4>";
                return false;
            }
            
        }

        public function VerifyEmailAPI($email)
        {
            if (!is_null($this->studentController->getStudentByEmail($email))) 
            {
                $this->message = "<h4 class = 'text-center' style='color: green;'> Usuario registrado con éxito </h4>";
                return true;
            }
            else
            {
                $this->message = "<h4 class = 'text-center' style='color: red;'> El mail no existe </h4>";
                return false;
            }
        }

        public function VerifyEmailDataBase($email)
        {
            if ($this->userDAO->VerifyEmailDataBase($email)) 
            {
                $this->message = "<h4 class = 'text-center' style='color: red;'> El email ya tiene una cuenta registrada </h4>";
                return true;
            } 
            return false;
        }

        public function Register(array $parameters)
        {
            $email = $parameters['email'];
            $password = $parameters['password'];
            $password_confirmation = $parameters['password_confirmation'];
            $user_role_id = $parameters['user_role_id'];

            if ($this->VerifyEmailAPI($email))
            {
                if($this->VerifyPassword($password, $password_confirmation))
                {
                    if(!$this->VerifyEmailDataBase($email))     
                    {   
                        $this->Add($email, $password, $user_role_id);
                        $message = $this->message;
                        if(Utils::isAdmin())
                        {
                            require_once(VIEWS_PATH."home.php");
                        }
                        require_once(VIEWS_PATH."login.php");
                    }
                    
                }
            }
            $message = $this->message;
            require_once(VIEWS_PATH."signup.php");
        }
    }