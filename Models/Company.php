<?php
    namespace Models;

    class Company
    {
        private int $companyId;
        private string $name;
        private int $yearOfFoundation;
        private string $city;
        private string $description;
        private string $logo; // base64 encode of the image
        private string $email;
        private string $phoneNumber;
        private bool $active;


        public function __construct($companyId)
        {
            $this->companyId = $companyId;
        }

        
        public function getCompanyId(): int
        {
            return $this->companyId;
        }


        public function setCompanyId($companyId): void
        {
            $this->companyId = $companyId;
        }
        

        public function getName(): string
        {
            return $this->name;
        }


        public function setName($name): void
        {
            $this->name = $name;
        }


        public function getYearOfFoundation(): int
        {
            return $this->yearOfFoundation;
        }


        public function setYearOfFoundation($yearOfFoundation): void
        {
            $this->yearOfFoundation = (int) $yearOfFoundation;
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


        public function setLogo(string $logo): void
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


        public function setPhoneNumber(string $phoneNumber): void
        {
            $this->phoneNumber = $phoneNumber;
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