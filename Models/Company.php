<?php
    namespace Models;

    class Company
    {
        private string $name;
        private int $yearFoundation;
        private string $city;
        private string $description;
        private string $logo;
        private string $email;
        private string $phoneNumber;
        private bool $active;
        
        public function getName(): string
        {
            return $this->name;
        }

        public function setName($name): void
        {
            $this->name = $name;
        }

        public function getYearFoundation(): int
        {
            return $this->$yearFoundation;
        }

        public function setYearFoundation($yearFoundation): void
        {
            $this->yearFoundation = $yearFoundation;
        }        
        
        public function getCity(): string
        {
            return $this->city;
        }

        public function setCity($city): void
        {
            $this->city = $city;
        }        
        
        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription($description): void
        {
            $this->description = $description;
        }        
        
        public function getLogo(): string
        {
            return $this->logo;
        }

        public function setLogo($logo): void
        {
            $this->logo = $logo;
        }        
        
        public function getEmail(): string
        {
            return $this->email;
        }

        public function setEmail($email): void
        {
            $this->email = $email;
        }        
        
        public function getPhoneNumber(): string
        {
            return $this->phoneNumber;
        }

        public function setPhoneNumber($phoneNumber): void
        {
            $this->phoneNumber = $phoneNumber;
        }

        public function isActive(): bool
        {
            return $this->active;
        }

        public function setActive($active): void
        {
            $this->active = $active;
        }
    }
?>