<?php
    namespace Models;

    use Models\Person as Person;

    class Student extends Person
    {
        private int $studentId;
        private int $careerId;
        private string $fileNumber;
        
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
    }
?>

