<?php
    namespace Interfaces;

    use Models\Company as Company;

    interface ICareerDAO
    {
        function Add(Company $company);
        function Delete(int $companyId);
        function Edit(Company $company);
        function GetAll();
    }