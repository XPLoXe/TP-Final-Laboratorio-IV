<?php
    namespace Models;

    use Models\UserRole as UserRole;
    use DateTime;

    class User
    {
        private int $userId;
        private string $email;
        private string $password;
        private UserRole $userRole;
        private bool $active;


        public function getUserId(): int
        {
            return $this->userId;
        }
    

        public function setUserId(int $userId): void
        {
            $this->userId = $userId;
        }
        

        public function getEmail(): string
        {
            return $this->email;
        }


        public function setEmail(string $email): void
        {
            $this->email = $email;
        }


        public function getPassword(): string
        {
            return $this->password;
        }

    
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }


        public function getUserRole(): UserRole
        {
            return $this->userRole;
        }

    
        public function setUserRole(UserRole $userRole): void
        {
            $this->userRole = $userRole;
        }


        public function getUserRoleDescription(): string
        {
            return $this->userRole->getDescription();
        }

        public function isActive(): bool
        {
            return $this->active;
        }


        public function setActive(bool $active): void
        {
            $this->active = $active;
        }

        public function getUserRoleId(): int
        {
            return $this->userRole->getUserRoleId();
        }

        public function getUser()
        {
            return $this;
        }
    }