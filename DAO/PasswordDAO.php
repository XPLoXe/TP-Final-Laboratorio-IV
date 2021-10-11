<?php
    namespace DAO;
    use Interfaces\IPasswordDAO as IPasswordDAO;

    class PasswordDAO implements IPasswordDAO
    {

        private $filename;
        private $itemsList;

        public function __construct()
        {
            $this->filename = dirname(__DIR__)."items.json";
            $this->itemsList = array();
        }

        function GetAll()
        {
            
        }

        function SearchByID()
        {

        }

        function RetrieveData()
        {

        }
    }
?>