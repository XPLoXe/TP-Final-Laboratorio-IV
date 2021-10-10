<?php
    namespace Interfaces;

    use Models\Company as Company;

    interface ICompanytDAO
    {
        function Add(Company $company);
        function GetAll();
    }
?>