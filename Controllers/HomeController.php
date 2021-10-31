<?php
    namespace Controllers;

    use Utils\Utils as Utils;

    class HomeController
        {
            public function Index($message = "")
            {
                if (Utils::isUserLoggedIn())
                    require_once(VIEWS_PATH."home.php");
                else
                    require_once(VIEWS_PATH."login.php");
            }        
        }