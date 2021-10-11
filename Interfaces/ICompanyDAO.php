<?php
    namespace Interfaces;

    use Models\Company as Company;

    interface ICompanyDAO
    {
        function Add(Company $company);
        function GetAll();
    }
?>