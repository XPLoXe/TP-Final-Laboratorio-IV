<?php
namespace Models;

<<<<<<< HEAD
class Person
{
    private $firstName;
    private $lastName;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
}
=======
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
>>>>>>> 479e4542380d2203e3b3678a85c0009714f88d50
