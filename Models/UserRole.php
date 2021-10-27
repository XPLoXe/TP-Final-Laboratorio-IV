<?php
    namespace Models;

    class UserRole
    {
        private int $userRoleId;
        private string $description;
        private bool $active;


        public function __construct(int $userRoleId)
        {
            $this->userRoleId = $userRoleId;
            $this->active = true;
        }


        public function getUserRoleId(): int
        {
            return $this->userRoleId;
        }


        public function setUserRoleId(int $userRoleId)
        {
            $this->userRoleId = $userRoleId;
        }


        public function getDescription(): string
        {
            return $this->description;
        }


        public function setDescription(string $description)
        {
            $this->description = $description;
        }

        public function isActive(): bool
        {
            return $this->active;
        }

        public function setActive(bool $active)
        {
            $this->active = $active;
        }
    }