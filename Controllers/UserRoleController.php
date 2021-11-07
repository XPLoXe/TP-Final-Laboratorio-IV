<?php
    namespace Controllers;

    use DAO\UserRoleDAO as UserRoleDAO;
    use Models\UserRole as UserRole;

    class UserRoleController
    {
        private $userRoleDAO;

        public function __construct()
        {
            $this->userRoleDAO = new UserRoleDAO();
        }


        public function GetAll(): array
        {
            return $this->userRoleDAO->GetAll();
        }


        public function GetUserRoleById($id): UserRole
        {
            return $this->userRoleDAO->GetUserRoleById($id);
        }


        public function GetIdByDescription(string $description): int
        {
            return $this->userRoleDAO->GetIdByDescription($description);
        }


        public function GetDescriptionById(int $descriptionId): string
        {
            return $this->userRoleDAO->GetDescriptionById($descriptionId);
        }
    }