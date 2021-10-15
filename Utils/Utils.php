<?php
    namespace Utils;

    class Utils
    {
        public static function isAdmin(): bool
        {
            return isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : false;
        }

        
        public static function isUserLoggedIn(): bool
        {
            return Utils::isAdmin() || isset($_SESSION['loggedUser']);
        }

        
        public static function getLoggedUserFullName(): string
        {
            $name = (Utils::isAdmin()) ? "Admin" : $_SESSION['loggedUser']->getFirstName() . " " . $_SESSION['loggedUser']->getLastName();
            return $name;
        }

        public static function checkUserLoggedIn(): void
        {
            if (!Utils::isUserLoggedIn())
            {
                header("location: ../index.php");
            }
        }

        public static function checkAdmin(): void
        {
            if(!Utils::isAdmin())
                header("location: ../index.php");
        }
    }
?>