<?php
    namespace Utils;

    use DateTime;

    class Utils
    {        
        public static function isUserLoggedIn(): bool
        {
            return isset($_SESSION['loggedUser']);
        }


        public static function isAdmin(): bool
        {
            if (isset($_SESSION['loggedUser']))
            {
                if($_SESSION['loggedUser']->getUserRoleDescription() == ROLE_ADMIN)
                    return true;
                else
                    return false;
            }

            return false;
        }


        public static function isStudent(): bool
        {
            if (self::isUserLoggedIn())
                return $_SESSION['loggedUser']->getUserRoleDescription() == ROLE_STUDENT;

            return false;
        }

        
        public static function getLoggedUserFullName(): string
        {
            return $_SESSION['loggedUser']->getFirstName() . " " . $_SESSION['loggedUser']->getLastName();
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

        
        public static function dateTimeToString(DateTime $date): string
        {
            return $date->format('d-m-Y');
        }
    }