<?php
    namespace Models;

    class Career;
    {
        private $name;
        private $description;
        private $active;

        public function getName(): string
        {
            return $this->name;
        }

        public function setName($name): void
        {
            $this->name = $name;
        }
        
        public function getDescription(): string
        {
            return $this->description;
        }

        public function setDescription($description): void
        {
            $this->description = $description;
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
?>