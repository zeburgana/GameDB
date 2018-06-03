<?php
require_once 'utils/paging.class.php';
require_once 'utils/validator.class.php';
require_once 'libraries/user.php';

class userController {

    public static $defaultAction = "list";

    // nustatome privalomus laukus
    private $required = array('name', 'games_rented', 'games_bought');

    // maksimalūs leidžiami laukų ilgiai
    private $maxLengths = array (
        'name'          => 45,
        'games_rented'  => 11,
        'games_bought'  => 45,
        'points'        => 11
    );

    // nustatome laukų validatorių tipus
    private $validations = array (
        'name'          =>    'varchar',
        'games_rented'  =>       'int',
        'games_bought'  =>    'varchar',
        'points'        =>    'int'
    );

    public function listAction() {
        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = user::getUserListCount();

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(NUMBER_OF_ROWS_IN_PAGE);

        // suformuojame sąrašo puslapius
        $paging->process($elementCount, routing::getPageId());

        // išrenkame nurodyto puslapio markes
        $data = user::getUserList($paging->size, $paging->first);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if(!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if(!empty($_GET['id_error']))
            $template->assign('id_error', true);

        $template->setView("user_list");
    }

    public function createAction() {
        $data = $this->validateInput();
        // If entered data was valid
        if ($data) {
            // Find max ID in the database
            $latestId = user::getMaxIdOfUser();
            // Increment it by one
            $data['id'] = $latestId + 1;

            // Insert row into database
            user::insertUser($data);

            // Redirect back to the list
            routing::redirect(routing::getModule(), 'list');
        } else {
            $this->showForm();
        }
    }

    public function editAction() {
        $id = routing::getId();

        $style = user::getUser($id);
        if ($style == false) {
            routing::redirect(routing::getModule(), 'list', 'id_error=1');
            return;
        }

        // Fill form fields with current data
        $template = template::getInstance();
        $template->assign('fields', $style);

        $data = $this->validateInput();
        // If Entered data was valid
        if ($data) {
            $data['id'] = $id;

            // Upda6te it in database
            user::updateUser($data);

            // Redirect back to the list
            routing::redirect(routing::getModule(), 'list');
        } else {
            $this->showForm();
        }
    }

    private function showForm() {
        //TODO: do a create form
        $template = template::getInstance();

        $user = user::getUserList();

        $template->assign('user', $user);
        $template->assign('required', $this->required);
        $template->assign('maxLengths', $this->maxLengths);
        $template->setView("user_form");
    }

    private function validateInput() {
        // Check if we even have any input
        if (empty($_POST['submit'])) {
            return false;
        }

        // Create Validator object
        $validator = new validator($this->validations,
            $this->required, $this->maxLengths);

        if(!$validator->validate($_POST)) {
            $template = template::getInstance();

            // Overwrite fields array with submitted $_POST values
            $template->assign('fields', $_POST);

            // Get error message
            $formErrors = $validator->getErrorHTML();
            $template->assign('formErrors', $formErrors);
            return false;
        }

        // Prepare data array to be entered into SQL DB
        $data = $validator->preparePostFieldsForSQL();
        return $data;
    }

    public function deleteAction() {
        $id = routing::getId();

        // šaliname markę
        $err = (user::deleteUser($id)) ? '' : 'delete_error=1';

        // nukreipiame į markių puslapį
        routing::redirect(routing::getModule(), 'list', $err);
    }

};

