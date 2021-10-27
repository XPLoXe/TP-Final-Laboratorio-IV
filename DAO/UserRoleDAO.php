<?php
    namespace DAO;

    use Interfaces\IUserRoleDAO as IUserRoleDAO;
    use DAO\Connection;
    use Models\UserRole;

    class userRoleDAO implements IUserRoleDAO
    {
        private $connection;
        private $tableName = "UserRoles";


        public function GetAll()
        {
            return null;
        }


        public function getIdByDescription(string $description): int
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE description='".$description."'";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                $result = (int) $resultSet[0]['user_role_id'];
                
                return $result;
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