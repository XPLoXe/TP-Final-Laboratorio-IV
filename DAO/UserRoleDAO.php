<?php
    namespace DAO;

    use Exception as Exception;
    use Interfaces\IUserRoleDAO as IUserRoleDAO;
    use DAO\Connection;
    use Models\UserRole;

    class userRoleDAO implements IUserRoleDAO
    {
        private $connection;
        private $tableName = "UserRoles";


        public function GetAll()
        {
            try
            {
                $userRoleList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {
                    $userRole = new UserRole($row["user_role_id"]);
                    $userRole->setDescription($row["description"]);
                    $userRole->isActive($row["active"]);
                    
                    array_push($userRoleList, $userRole);
                }

                return $userRoleList;
            }
            catch (Exception $ex)
            {
                throw $ex;
            }
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


        public function getUserRoleById(int $userRoleId): UserRole
        {
            try
            {
                $query = "SELECT * FROM ".$this->tableName.' WHERE user_role_id = :user_role_id;';

                $parameters['user_role_id'] = $userRoleId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                $userRole = new UserRole($userRoleId);
                $userRole->setDescription($resultSet[0]['description']);
                $userRole->setActive($resultSet[0]['active']);

                return $userRole;
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