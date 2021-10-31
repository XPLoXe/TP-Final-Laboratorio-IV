<?php
    namespace Models;

    use Models\User as User;

    class Student extends User
    {
        private int $careerId;
        private string $fileNumber;
        private $firstName;
        private $lastName;
        private $birthDate;
        private $dni;
        private $gender;
        private $phoneNumber;
        
        
        public function getStudentId(): int
        {
            return $this->studentId;
        }

        public function setStudentId(int $studentId): void
        {
            $this->studentId = $studentId;
        }

        public function getCareerId(): int
        {
            return $this->careerId;
        }

        public function setCareerId(int $careerId): void
        {
            $this->careerId = $careerId;
        }

        public function getFileNumber(): string
        {
            return $this->fileNumber;
        }

        public function setFileNumber(string $fileNumber): void
        {
            $this->fileNumber = $fileNumber;
        }

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

        public function getDni()
        {
            return $this->dni;
        }

        public function setDni($dni)
        {
            $this->dni = $dni;
        }

        public function getGender()
        {
            return $this->gender;
        }

        public function setGender($gender)
        {
            $this->gender = $gender;
        }

        public function getPhoneNumber()
        {
            return $this->phoneNumber;
        }

        public function setPhoneNumber($phoneNumber)
        {
            $this->phoneNumber = $phoneNumber;
        }

        public function getBirthDate()
        {
            return $this->birthDate;
        }

        public function setBirthDate($birthDate)
        {
            $this->birthDate = $birthDate;
        }
    }
?>

