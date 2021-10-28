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


        public function __construct()
        {
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
    

        public static function Verify(string $password, string $password_confirmation, $email)
        {
            $studentController = new StudentController();
            if (strcmp($password, $password_confirmation) == 0) // TODO: Handle when passwords don't match, show error message
            {
                if (!is_null($studentController->getStudentByEmail($email))) {
                    return true;
                }
                else
                    echo "<h4 class = 'text-center' style='color: red;'> El mail no existe </h4>";
                    return false;
            }
            else
            {
                echo "<h4 class = 'text-center' style='color: red;'> las contraseñas ingresadas no son las mismas </h4>";
                return false;
            }
                
            // TODO: StudentDAO::getStudentByEmail() Verify if email exists in API, fetch name
        }


        public function Register(array $parameters)
        {
            // TODO: Verify POST
            $email = $parameters['email'];
            $password = $parameters['password'];
            $password_confirmation = $parameters['password_confirmation'];
            $user_role_id = $parameters['user_role_id'];

            

            if (!$this->Verify($password, $password_confirmation, $email))
            {
                
                require_once(VIEWS_PATH."signup.php");
            }
            else
                $this->Add($email, $password, $user_role_id);
        }
    }
?>