<?php
    namespace Models;

    use DateTime;

    class Person
        {
            private string $firstName;
            private string $lastName;
            private string $dni;
            private string $gender;
            private DateTime $birthDate;
            private string $email;
            private string $phoneNumber;
            private bool $active;

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

            public function getDni(): string
            {
                return $this->dni;
            }

            public function setDni($dni): void
            {
                $this->dni = (string) $dni;
            }

            public function getGender(): string
            {
                return $this->gender;
            }

            public function setGender(string $gender): void
            {
                $this->gender = $gender;
            }

            public function getBirthDate(): DateTime
            {
                return $this->birthDate;
            }

            public function setBirthDate($birthDate): void
            {
                $this->birthDate = new DateTime($birthDate);
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

            public function setPhoneNumber($phoneNumber): void
            {
                $this->phoneNumber = (string) $phoneNumber;
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
