<?php
    namespace Interfaces;

    use Models\Administrator as Administrator;

    interface IAdministratortDAO
    {
        function Add(Administrator $administrator);
        function GetAll();
    }
?>