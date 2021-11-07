<?php
    namespace Controllers;

    use Utils\Utils as Utils;

    class HomeController
    {
        public function Index($message = ""): void
        {
            if (Utils::isUserLoggedIn())
            {
                $message = "";
                require_once(VIEWS_PATH."home.php");
            }
            else
            {
                $message = "";
                require_once(VIEWS_PATH."login.php");
            }
        }
    }