<?php
namespace DAO;

use \Exception as Exception;
use Interfaces\IAdministratorDAO as IAdministratorDAO;
use Models\Administrator as Administrator;
use DAO\Connection as Connection;

class AdministratorDAO implements IAdministratorDAO
{
    private $connection;
    private $tableName = "administrators";

    public function Add(Administrator $admin)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (adminId, firstName, lastName, dni, birthDate, email, phoneNumber, active, password) VALUES (:adminId, :firstName, :lastName, :dni, :birthDate, :email, :phoneNumber, :active, :password);";
            
            $parameters["adminId"] = $admin->getRecordId();
            $parameters["firstName"] = $admin->getFirstName();
            $parameters["lastName"] = $admin->getLastName();
            $parameters["dni"] = $admin->getDni();
            $parameters["birthDate"] = $admin->getBirthDay();
            $parameters["email"] = $admin->getEmail();
            $parameters["phoneNumber"] = $admin->getPhoneNumber();
            $parameters["active"] = $admin->getActive();
            $parameters["password"] = $admin->getPassword(); // We have to see the name of the atribute password in the DB

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try
        {
            $adminList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row)
            {                
                $admin = new Administrator();
                $admin->setRecordId($row["adminId"]);
                $admin->setFirstName($row["firstName"]);
                $admin->setLastName($row["lastName"]);
                $admin->setDni($row["dni"]);
                $admin->setBirthDay($row["birthDate"]);
                $admin->setEmail($row["email"]);
                $admin->setPhoneNumber($row["phoneNumber"]);
                $admin->setActive($row["active"]);
                $admin->setPassword($row["password"]); // We have to see the name of the atribute password in the DB

                array_push($adminList, $admin);
            }

            return $adminList;
        }
        catch (Exception $ex)
        {
            throw $ex;
        }
    }

    public function getAdminByEmail($email)
    {

    }

    public function getActiveAdmins()
    {

    }

    public function getAdminById($id)
    {

    }
    
}
