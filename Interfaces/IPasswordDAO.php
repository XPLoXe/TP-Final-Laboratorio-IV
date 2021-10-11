<?php
    namespace Interfaces;

    interface IPasswordDAO
    {
        //function Add(Career $career);
        function GetAll();
        function SearchByID();
        function RetrieveData();

    }
?>