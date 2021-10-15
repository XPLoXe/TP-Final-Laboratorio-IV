<?php
    namespace Controllers;

    use Utils\Utils as Utils;

    class HomeController
        {
            public function Index($message = "")
            {
                Utils::checkUserLoggedIn();

                require_once(VIEWS_PATH."login.php");
            }        
        }
?>