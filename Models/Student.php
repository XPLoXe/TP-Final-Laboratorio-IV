<?php
    namespace Models;

    use Models\Person as Person;

    class Student extends Person
    {
        private $recordId;
        private $studentId;
        private $careerId;

        public function getRecordId(): int
        {
            return $this->recordId;
        }

        public function setRecordId($recordId): void
        {
            $this->recordId = $recordId;
        }

        public function getStudentId(): int
        {
            return $this->studentId;
        }

        public function setStudentId($studentId): void
        {
            $this->studentId = $studentId;
        }

        public function getCareerId(): int
        {
            return $this->careerId;
        }

        public function setCareerId($careerId): void
        {
            $this->careerId = $careerId;
        }
    }
?>

