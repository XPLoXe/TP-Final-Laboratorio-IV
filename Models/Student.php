<?php
    namespace Models;

    use Models\User as User;
    use DateTime;

    class Student extends User
    {
        private int $studentId;
        private string $fileNumber;
        private int $careerId;
        private string $firstName;
        private string $lastName;
        private DateTime $birthDate;
        private string $dni;
        private string $gender;
        private string $phoneNumber;
        

        public function getStudentId()
        {
            return $this->studentId;
        }


        public function setStudentId($studentId)
        {
            $this->studentId = $studentId;
        }


        public function getFileNumber(): string
        {
            return $this->fileNumber;
        }


        public function setFileNumber(string $fileNumber): void
        {
            $this->fileNumber = $fileNumber;
        }


        public function getCareerId(): int
        {
            return $this->careerId;
        }


        public function setCareerId(int $careerId): void
        {
            $this->careerId = $careerId;
        }


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

        
        public function getBirthDate(): DateTime
        {
            return $this->birthDate;
        }


        public function setBirthDate(DateTime $birthDate): void
        {
            $this->birthDate = $birthDate;
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


        public function getPhoneNumber(): string
        {
            return $this->phoneNumber;
        }


        public function setPhoneNumber($phoneNumber): void
        {
            $this->phoneNumber = $phoneNumber;
        }
    }