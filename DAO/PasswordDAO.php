<?php
    namespace DAO;
    use Interfaces\IPasswordDAO as IPasswordDAO;

    class PasswordDAO implements IPasswordDAO
    {

        private $filename;
        private $passwordList;

        public function __construct()
        {
            $this->filename = JSON_PATH."passwords.json";
            $this->passwordList = array();
        }

        function GetAll()
        {
            $this->RetrieveData();
            return $this->passwordList;
        }

        public function CheckUser($id, $password)
        {
            $this->passwordList = array();
            if(file_exists($this->filename))
            {
                $jsonContent = file_get_contents($this->filename);
                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
                foreach ($arrayToDecode as $value)
                {
                    if($value["studentId"] == $id && $value["password"] == $password)
                    {
                        return true;
                    }
                }
                $this->passwordList = $arrayToDecode;
                return false;
            }
        }

        private function RetrieveData()
        {
            $this->passwordList = array();
            if(file_exists($this->filename))
            {
                $jsonContent = file_get_contents($this->filename);
                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
                /* foreach ($arrayToDecode as $value)
                {
                    $item = new Item();
                    $item->setName($value["name"]);
                    $item->setDescription($value["description"]);
                    $item->setPrice($value["price"]);
                    $item->setQuantity($value["quantity"]);
                    array_push($this->passwordList, $item);
                } */
                array_push($this->passwordList, $arrayToDecode);
            }
        }
    }
?>