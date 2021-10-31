<?php
    namespace Models;

    class Career
    {
        private int $careerId;
        private string $description;
        private string $name;
        private bool $active;

        
        public function getCareerId(): int
        {
            return $this->careerId;
        }

        public function setCareerId($careerId): void
        {
            $this->careerId = $careerId;
        }
        
        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription($description): void
        {
            $this->description = $description;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function setName($name): void
        {
            $this->name = $name;
        }

        public function isActive(): bool
        {
            return $this->active;
        }

        public function getActive($active): void
        {
            $this->active = $active;
        }
    }