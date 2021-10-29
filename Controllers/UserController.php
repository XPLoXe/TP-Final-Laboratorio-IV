<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Models\UserRole as UserRole;
    use Utils\Utils as Utils;

    class UserController
    {
        private $userDAO;
        private $userRoleController;
        private $text;
        private $studentController;


        public function __construct()
        {
            $this->studentController = new StudentController();
            $this->text = "";
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

            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setUserRole($userRole);
            $user->setActive(true);

            $this->userDAO->Add($user);

            // TODO: show something or redirect to login view
        }
    

        public function VerifyPassword(string $password, string $password_confirmation)
        {
            if (strcmp($password, $password_confirmation) == 0)
            {
                return true;
            }
            else
            {
                $this->text = "<h4 class = 'text-center' style='color: red;'> las contraseñas ingresadas no son las mismas </h4>";
                return false;
            }
            
        }

        public function VerifyEmail($email)
        {
            if (!is_null($this->studentController->getStudentByEmail($email))) 
            {
                $this->text = "<h4 class = 'text-center' style='color: green;'> Usuario registrado con éxito </h4>";
                return true;
            }
            else
            {
                $this->text = "<h4 class = 'text-center' style='color: red;'> El mail no existe </h4>";
                return false;
            }
        }

        public function Register(array $parameters)
        {
            $email = $parameters['email'];
            $password = $parameters['password'];
            $password_confirmation = $parameters['password_confirmation'];
            $user_role_id = $parameters['user_role_id'];

            if ($this->VerifyEmail($email))
            {
                if($this->VerifyPassword($password, $password_confirmation))
                {
                    $this->Add($email, $password, $user_role_id);
                    $message = $this->text;
                    require_once(VIEWS_PATH."login.php");
                }
            }
            $message = $this->text;
            require_once(VIEWS_PATH."signup.php");
        }
    }
?>