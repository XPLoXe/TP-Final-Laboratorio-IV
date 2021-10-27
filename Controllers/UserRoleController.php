<?php
    namespace Controllers;

    use Models\UserRole as UserRole;
    use DAO\UserRoleDAO as UserRoleDAO;

    class UserRoleController
    {
        private $userRoleDAO;

        public function __construct()
        {
            $this->userRoleDAO = new UserRoleDAO();
        }


        public function getIdByDescription(string $description): int
        {
            return $this->userRoleDAO->getIdByDescription($description);
        }

        public function getDescriptionById(int $id): string
        {
            return $this->userRoleDAO->getDescriptionById($id);
        }
    }