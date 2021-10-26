<?php
    namespace DAO;

    use Interfaces\IUserRoleDAO as IUserRoleDAO;
    use Connection;
    use Models\UserRole;

    class userRoleDAO implements IUserRoleDAO
    {
        private $connection;
        private $tableName = "UserRoles";


        public function GetAll()
        {
            return null;
        }


        public function getIdByDescription(string $description): int // envio "Student"
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE description = ".$description;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query); // Verify if it returns an array

                return $result; // returns 2
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }


        public function getDescriptionById($userRoleId): string
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    if ($row["user_role_id"] == $userRoleId)
                        return $row["description"];
                }

                return null;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
        }
    }