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


        public function __construct($companyId = 0)
        {
            $this->companyId = $companyId;
            parent::setUserId($companyId);
        }

        
        public function getCompanyId(): int
        {
            return $this->companyId;
        }


        public function setCompanyId(int $companyId): void
        {
            $this->companyId = $companyId;
            parent::setUserId($companyId);
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

        
        public function getLogo(): ?string
        {
            if (isset($this->logo))
                return $this->logo;
            else
                return null;
        }


        public function setLogo($logo): void
        {
            if(empty($logo) || is_null($logo))
                $this->logo = " ";
            else
                $this->logo = $logo;
            
        }      

        
        /* public function getEmail(): string
        {
            return $this->email;
        }


        public function setEmail(string $email): void
        {
            parent::setEmail($email);
            $this->email = $email;
        }      */

        
        public function getPhoneNumber(): string
        {
            return $this->phoneNumber;
        }


        public function setPhoneNumber(string $phoneNumber): void
        {
            $this->phoneNumber = $phoneNumber;
        }


        /* public function isActive(): bool
        {
            return $this->active;
        }


        public function setActive(bool $active): void
        {
            parent::setActive($active);
            $this->active = $active;
        } */

        public function isApproved(): bool
        {
            return $this->approved;
        }

        public function setApproved(bool $approved)
        {
            $this->approved = $approved;
        }

        public function getUser(): User
        {
            $user = new User;
            $userRole = new UserRole(3);
            $userRole->setActive(1);
            
            $userRole->setDescription("Company");

            $user->setEmail($this->getEmail());
            $user->setPassword($this->getPassword());
            $user->setUserId($this->getCompanyId());
            $user->setUserRole($userRole);

            return $user;
        }
    }