<?php
    namespace Models;
    class Person
    {
        private string $firstName;
        private string $lastName;
        private int $dni;
        private string $gender;
        private DateTime $birthDate;
        private string $email;
        private string $phoneNumber;
        private bool $active;

        public function getFirstName(): string
        {
            return $this->firstName;
        }

        public function setFirstName($firstName): void
        {
            $this->firstName = $firstName;
        }

        public function getLastName(): string
        {
            return $this->lastName;
        }

        public function setLastName($lastName): void
        {
            $this->lastName = $lastName;
        }

        public function getDni(): string
        {
            return $this->dni;
        }

        public function setDni($dni): void
        {
            $this->dni = $dni;
        }

        public function getGender(): string
        {
            return $this->gender;
        }

        public function setGender($gender): void
        {
            $this->gender = $gender;
        }

        public function getBirthDate(): DateTime
        {
            return $this->birthDate;
        }

        public function setBirthDate($birthDate): void
        {
            $this->birthDate = $birthDate;
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