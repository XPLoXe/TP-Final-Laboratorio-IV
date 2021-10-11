<?php
    namespace Models;

    use Models\Person as Person;

    class Student extends Person
    {
        private int $recordId;
        private int $studentId;
        private int $careerId;
        private int $fileNumber;

        public function getRecordId(): int
        {
            return $this->recordId;
        }

        public function setRecordId(int $recordId): void
        {
            $this->recordId = $recordId;
        }

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

        public function getFileNumber(): int
        {
            return $this->fileNumber;
        }

        public function setFileNumber(int $fileNumber): void
        {
            $this->fileNumber = $fileNumber;
        }
    }
?>

