<?php
    namespace Interfaces;

    use Models\User as User;
    use DAO\Connection as Connection;

    interface IUserDAO
    {
        function Add(User $user);
        function Delete(int $userId);
        function Edit(User $user);
        function GetAll();
    }