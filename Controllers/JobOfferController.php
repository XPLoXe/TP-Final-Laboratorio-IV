<?php
    namespace Controllers;

    use DAO\JobOfferDAO as JobOfferDAO;
    use Models\JobOffer as JobOffer;
    use Models\JobPosition as JobPosition;
    use Models\Company as Company;
    use Controllers\CompanyController as CompanyController;
    use Controllers\JobPositionController as JobPositionController;
    use Utils\Utils as Utils;

    class JobOfferController
    {
        private $jobOfferDAO;

        public function __construct()
        {
            $this->jobOfferDAO = new JobOfferDAO();
        }

        public function ShowAddView()
        {
            Utils::checkAdmin();
            
            $companyController = new CompanyController;
            $jobPositionController = new JobPositionController;

            $companyList = $companyController->GetAll();
            $jobPositionList = $jobPositionController->GetAll();

            require_once(VIEWS_PATH."job-offer-add.php");
        }

        public function ShowListView()
        {
            Utils::checkUserLoggedIn();

            //Debo actualizar la base de datos con la api: JobPosition, Career, CareerJobPosition
            //y con esto actualizado, actualizar tmb la base de datos de las JobOffer

            if (Utils::isAdmin())
                $jobOfferList = $this->getActiveJobOfferList();

            if (Utils::isUserLoggedIn())
            { //modificar el jobOfferList para q aparezcan los de su carrera
                $studentController = new StudentController();

                $careerId = $studentController->getCareerIdByStudentId($_SESSION['loggedUser']['api_user_id']);

                $jobOfferList = $this->jobOfferDAO->getJobOfferByCareerId($careerId);//no va xq joboffer no tiene careerId
            }
            //necesito ir a la controladora de JobPosition y Company para q me tire los datos necesarios de la $jobOfferList
            require_once(VIEWS_PATH."job-offer-list.php");
        }


        public function ShowEditView($parameters)
        {
            // Utils::checkAdmin();
            
            // $company = $this->companyDAO->getCompanyById($parameters['edit']);

            // require_once(VIEWS_PATH."company-edit.php");
        }


        public function Edit($parameters)
        {
            // Utils::checkAdmin();
            
            // $companyId = $parameters['id'];
            // $name = $parameters['name'];
            // $yearFoundation = $parameters['yearFoundation'];
            // $city = $parameters['city'];
            // $description = $parameters['description'];           
            // $logo = $parameters['logo']['name'];
            // $tmp_name = $parameters['logo']['tmp_name'];
            // $email = $parameters['email'];
            // $phoneNumber = $parameters['phoneNumber'];

            // $this->companyDAO->editCompany($companyId, $name, $yearFoundation, $city, $description, $logo, $tmp_name, $email, $phoneNumber);

            // $this->ShowInfo($parameters);
        }


        public function Delete($parameters)
        {
            Utils::checkAdmin();

            //$this->jobOfferDAO->deleteJobOffer($parameters['delete']);

            $this->ShowListView();
        }


        public function Add($parameters)
        {
            Utils::checkAdmin();

            // Bind parameters to JobOffer object
            // Call DAO
            $jobOffer = new JobOffer;
            $jobOffer->setCompany(new Company($parameters["companyId"]));
            $jobOffer->setJobPosition(new JobPosition($parameters["jobPositionId"]));
            $jobOffer->setDescription($parameters["description"]);
            $jobOffer->setPublicationDate($parameters["publicationDate"]);
            $jobOffer->setExpirationDate($parameters["expirationDate"]);
            
            $this->jobOfferDAO->Add($jobOffer);
            echo "Todo bien";
            die();
            //$this->ShowListView();
        }

        
        public function getActiveJobOfferList(): array
        {
            $jobPositionController = new JobPositionController;
            $userController = new UserController;
            $companyController = new CompanyController;

            $jobOffers = $this->jobOfferDAO->GetAll(); // Array of JobOffer objects (incomplete)

            foreach ($jobOffers as $jobOffer)
            {
                $jobOffer->setJobPosition($jobPositionController->getJobPositionById($jobOffer->getJobPositionId())); //Sets JobPosition object as attribute of JobOffer
                $jobOffer->setApplicant($userController->getUserById($jobOffer->getApplicant()->getUserId()));
                $jobOffer->setCompany($companyController->getCompanyById($jobOffer->getCompanyId()));
            }

            return $jobOffers;
        }
    }
