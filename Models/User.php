<?php
    namespace Models;

    use Models\UserRole as UserRole;
    use DateTime;

    class User
    {
        private int $userId;
        private string $email;
        private string $password;
        private string $firstName;
        private string $lastName;
        private UserRole $userRole;
        private int $apiUserId;
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


        public function getFirstName(): string
        {
            return $this->firstName;
        }
        
    
        public function setFirstName(string $firstName): void
        {
            $this->firstName = $firstName;
        }


        public function getLastName(): string
        {
            return $this->lastName;
        }

    
        public function setLastName(string $lastName): void
        {
            $this->lastName = $lastName;
        }


        public function getUserRole(): UserRole
        {
            return $this->userRole;
        }

    
        public function setUserRole(UserRole $userRole): void
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

        public function getApiUserId()
        {
            return $this->apiUserId;
        }

        public function setApiUserId($apiUserId)
        {
            $this->apiUserId = $apiUserId;
        }
    }
