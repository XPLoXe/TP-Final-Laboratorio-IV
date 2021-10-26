<?php
    namespace Models;

    use UserRole;
    use DateTime;

    class User
    {
        private int $userId;
        private UserRole $userRole;
        private string $email;
        private string $password;
        private bool $active;


        public function getUserId()
        {
            return $this->userId;
        }
    
        public function setUserId($userId)
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

        public function getPassword()
        {
            return $this->password;
        }
    
        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getUserRole(): UserRole
        {
            return $this->userRole;
        }
    
        public function setUserRole(UserRole $userRole)
        {
            $this->userRole = $userRole;
        }

        public function isActive(): bool
        {
            return $this->active;
        }

        public function setActive(bool $active): void
        {
            $this->active = $active;
        }
    }
