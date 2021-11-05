<?php
    namespace Interfaces;

    use Models\JobOffer as JobOffer;

    interface IJobOfferDAO
    {
        function Add(JobOffer $jobOffer);
        function Edit(JobOffer $jobOffer);
        function Delete(int $jobOfferId);
        function GetAll();
    }
?>