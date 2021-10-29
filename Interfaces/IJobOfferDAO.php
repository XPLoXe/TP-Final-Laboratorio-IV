<?php
    namespace Interfaces;

    use Models\JobOffer as JobOffer;

    interface IJobOfferDAO
    {
        function Add(JobOffer $jobOffer);
        function GetAll();
    }
?>