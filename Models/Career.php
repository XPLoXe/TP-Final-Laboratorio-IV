<?php
    namespace Models;

    class Career
    {
        private int $careerId;
        private string $description;
        private bool $active;


        public function getCareerId(): int
        {
            return $this->careerId;
        }


        public function setCareerId(int $careerId): void
        {
            $this->careerId = $careerId;
        }

        
        public function getDescription(): string
        {
            return $this->description;
        }


        public function setDescription(string $description): void
        {
            $this->description = $description;
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