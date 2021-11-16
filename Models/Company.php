<?php
    namespace Models;

    use Models\User as User;

    class Company extends User
    {
        private int $companyId;// se tendria que ir ?
        private string $name;
        private int $yearOfFoundation;
        private string $city;
        private string $description;
        private string $logo; // base64 encode of the image
        private string $phoneNumber;
        private bool $approved;
        private bool $active;


        public function __construct($companyId = 0)
        {
            $this->companyId = $companyId;
        }

        
        public function getCompanyId(): int
        {
            return $this->companyId;
        }


        public function setCompanyId(int $companyId): void
        {
            $this->companyId = $companyId;
        }
        

        public function getName(): string
        {
            return $this->name;
        }


        public function setName(string $name): void
        {
            $this->name = $name;
        }


        public function getYearOfFoundation(): int
        {
            return $this->yearOfFoundation;
        }


        public function setYearOfFoundation(string $yearOfFoundation): void
        {
            $this->yearOfFoundation = (int) $yearOfFoundation;
        }        

        
        public function getCity(): string
        {
            return $this->city;
        }


        public function setCity(string $city): void
        {
            $this->city = $city;
        }     

        
        public function getDescription(): string
        {
            return $this->description;
        }


        public function setDescription(string $description): void
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


        public function setEmail(string $email): void
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

        public function isApproved()
        {
            return $this->approved;
        }

        public function setApproved($approved)
        {
            $this->approved = $approved;
        }
    }