<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/tp-final-laboratorio-iv/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("ROOT_", ucwords(str_replace("\\", "/", ROOT)));
define("JSON_PATH", ucwords(str_replace("\\", "/", ROOT."Data/")));
define("IMG_PATH", VIEWS_PATH."img/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
define('API_KEY','4f3bceed-50ba-4461-a910-518598664c08');
define('API_URL','https://utn-students-api2.herokuapp.com/api/');
define('BINANCE_URL','https://api.binance.com/api/v3/ticker/price');
define("DB_HOST", "localhost");
define("DB_NAME", "University");
define("DB_USER", "root");
define("DB_PASS", "");
define("ROLE_ADMIN", "Administrator");
define("ROLE_STUDENT", "Student");
define("ROLE_COMPANY", "Company");
define("UPDATE_FILE_PATH", ROOT . "last-update.log");
define("FILTER_ALL",1);
define("FILTER_TRUE",2);
define("FILTER_FALSE",3);
define("FILTER_STUDENT",2);
define("FILTER_COMPANY",3);