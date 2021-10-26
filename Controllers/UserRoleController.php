<?php
    namespace Controllers;

    use Models\UserRole as UserRole;

    class UserRoleController
    {
        private $userRoleDAO;

        public function __construct()
        {
            $this->userRoleDAO = new UserRoleDAO();
        }


        public function getIdByDescription(string $description): int // envio "Student" devuelve 2
        {
            return $this->userRoleDAO->getIdByDescription($description);
        }
    }