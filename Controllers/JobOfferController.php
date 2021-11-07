<?php
    namespace Controllers;

    use Controllers\CompanyController as CompanyController;
    use Controllers\JobPositionController as JobPositionController;
    use DAO\CompanyDAO as CompanyDAO;
    use DAO\JobOfferDAO as JobOfferDAO;
    use DAO\JobPositionDAO as JobPositionDAO;
    use Models\Company as Company;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition;
    use Utils\Utils as Utils;
    use DateTime;

    class JobOfferController
    {
        private $jobPositionController;
        private $companyDAO;
        private $jobOfferDAO;
        private $jobPositionDAO;


        public function __construct()
        {
            $this->jobOfferDAO = new JobOfferDAO();// SACAR
            $this->companyDAO = new CompanyDAO();// SACAR
            $this->jobPositionDAO = new JobPositionDAO();// SACAR
            $this->jobPositionController = new JobPositionController();
        }


        public function Add(array $parameters)
        {
            Utils::checkAdmin();
            
            $jobOffer = new JobOffer;
            
            $company = $this->companyDAO->GetCompanyById($parameters["companyId"]);
            $jobOffer->setCompany($company);

            $jobPosition = $this->jobPositionDAO->GetJobPositionById($parameters["jobPositionId"]);
            $jobOffer->setJobPosition($jobPosition);

            $jobOffer->setDescription($parameters["description"]);
            $jobOffer->setPublicationDate(new DateTime($parameters["publicationDate"]));
            $jobOffer->setExpirationDate(new DateTime($parameters["expirationDate"]));
            
            $this->jobOfferDAO->Add($jobOffer);

            $this->ShowListView();
        }


        public function Delete(array $parameters)
        {
            Utils::checkAdmin();

            $this->jobOfferDAO->Delete($parameters['jobOfferId']);

            $this->ShowListView();
        }

        public function FilterByPosition($parameters)
        {
            Utils::checkUserLoggedIn();

            if ($_SERVER['REQUEST_METHOD'] == "POST") { 
                
                if (empty($parameters["nameToFilter"])) 
                {   
                    $this->ShowListView();
                } else
                {
                    $jobPositionList  = $this->jobPositionController->getJobPositionByName($parameters["nameToFilter"]);

                    $jobOfferList = $this->GetAll();

                    $jobOfferFiltered = array();

                    if (!empty($jobPositionList))
                    {
                        foreach ($jobPositionList as $jobPosition)
                        {
                            foreach ($jobOfferList as $jobOffer)
                            {
                                if ($jobPosition->getJobPositionId() == $jobOffer->getJobPositionId()) {
                                    array_push($jobOfferFiltered, $jobOffer);
                                }
                            }
                        }

                        $jobOfferList = $jobOfferFiltered;

                    } 
                    else
                    {
                        $msgErrorFilter = ERROR_JOBOFFER_FILTER; // TODO: move HTML code to view
                    } 

                    require_once(VIEWS_PATH."job-offer-list.php");
                }
            }
        }


        public function Edit(array $parameters)
        {
            Utils::checkAdmin();

            $jobOffer = new JobOffer;

            $jobOffer->setJobOfferId($parameters['jobOfferId']);
            $jobOffer->setJobPositionId($parameters['jobPositionId']);
            $jobOffer->setCompanyId($parameters['companyId']);      
            $jobOffer->setExpirationDate(new DateTime($parameters['expirationDate']));
            $jobOffer->setDescription($parameters['description']);
            
            $this->jobOfferDAO->Edit($jobOffer);

            $jobOfferList = $this->GetAll();
            require_once(VIEWS_PATH."job-offer-list.php");
        }

        
        public function GetAll(): array
        {
            if(Utils::isAdmin())
                $jobOffers = $this->jobOfferDAO->GetAll(FILTER_ALL);
            else if(Utils::isStudent())
                $jobOffers = $this->jobOfferDAO->GetAll(FILTER_STUDENT);

            return $jobOffers;
        }
        

        public function Apply(array $parameters): void
        {
            if (Utils::isStudent())
                $this->jobOfferDAO->Apply($parameters['jobOfferId'], $_SESSION["loggedUser"]->getUserId());

            $message = APPLY_SUCCESS;
            require_once(VIEWS_PATH."home.php");
        }


        public function ShowAddView(): void
        {
            Utils::checkAdmin();
            
            $companyController = new CompanyController;
            $jobPositionController = new JobPositionController;

            $companyList = $companyController->GetAll();
            $jobPositionList = $jobPositionController->GetAll();

            require_once(VIEWS_PATH."job-offer-add.php");
        }


        public function ShowListView(): void
        {
            Utils::checkUserLoggedIn();

            if (Utils::isStudent())
            {
                $isLookingForJob = $this->jobOfferDAO->isUserIdInOffer($_SESSION["loggedUser"]->getUserId());
            }
            
            $jobOfferList = $this->GetAll();

            require_once(VIEWS_PATH."job-offer-list.php");
        }


        public function FilterByName(array $parameters)
        {
            Utils::checkUserLoggedIn();

            if (Utils::isStudent())
                $isLookingForJob = $this->jobOfferDAO->IsUserIdInOffer($_SESSION["loggedUser"]->getUserId());
           
            if (empty($parameters["nameToFilter"]))
                $this->ShowListView();
            else
            {
                $jobPositionList  = $this->jobPositionController->GetJobPositionByName($parameters["nameToFilter"]);
                $jobOfferList = $this->GetAll();
                $jobOfferFiltered = array();

                if (!empty($jobPositionList))
                {
                    foreach ($jobPositionList as $jobPosition)
                    {
                        foreach ($jobOfferList as $jobOffer)
                        {
                            if ($jobPosition->getJobPositionId() == $jobOffer->getJobPositionId()) {
                                array_push($jobOfferFiltered, $jobOffer);
                            }
                        }
                    }
                } 
                else
                {
                    $msgErrorFilter = ERROR_JOBOFFER_FILTER;
                    $jobOfferList = $this->jobOfferDAO->GetAll();
                }

                $jobOfferList = array();
                $jobOfferList = $jobOfferFiltered;

                require_once(VIEWS_PATH."job-offer-list.php");
            }
        }


        public function ShowEditView(array $parameters): void
        {
            Utils::checkAdmin();
            
            $jobOffer = $this->jobOfferDAO->GetJobOfferById($this->GetAll(),$parameters['jobOfferId']);

            $jobPositionList = $this->jobPositionDAO->GetAll();
            array_unshift($jobPositionList, $jobOffer->getJobPosition());

            $companyList = $this->companyDAO->GetAll();
            array_unshift($companyList, $jobOffer->getCompany());

            require_once(VIEWS_PATH."job-offer-edit.php");
        }

    }
