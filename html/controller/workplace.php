<?php
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.6.2
 * Time: 19.06
 */

require_once "libraries/workplace.php";
require_once "utils/paging.class.php";
require_once "utils/validator.class.php";

class workplaceController {
    public static $defaultAction = "list";

    // nustatome privalomus laukus
    private $required = array('city', 'address');

    // maksimalūs leidžiami laukų ilgiai
    private $maxLengths = array (
        'city'          => 45,
        'address'  => 45
    );

    // nustatome laukų validatorių tipus
    private $validations = array (
        'city'          => 'varchar',
        'address'  => 'varchar'
    );

    public function listAction() {
        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = workplace::getWorkplaceListCount();

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(NUMBER_OF_ROWS_IN_PAGE);

        // suformuojame sąrašo puslapius
        $paging->process($elementCount, routing::getPageId());

        // išrenkame nurodyto puslapio markes
        $data = workplace::getWorkplaceList($paging->size, $paging->first);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if(!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if(!empty($_GET['id_error']))
            $template->assign('id_error', true);

        $template->setView("workplace_list");
    }

    public function createAction() {
        $data = $this->validateInput();
        // If entered data was valid
        if ($data) {
            // Find max ID in the database
            $latestId = workplace::getMaxIdOfWorkplace();
            // Increment it by one
            $data['id'] = $latestId + 1;

            // Insert row into database
            game::insertGame($data);

            // Redirect back to the list
            routing::redirect(routing::getModule(), 'list');
        } else {
            $this->showForm();
        }
    }

    public function editAction() {
        $id = routing::getId();

        $style = game::getGame($id);
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
            workplace::updateWorkplace($data);

            // Redirect back to the list
            routing::redirect(routing::getModule(), 'list');
        } else {
            $this->showForm();
        }
    }

    private function showForm() {
        $template = template::getInstance();

        $template->assign('required', $this->required);
        $template->assign('maxLengths', $this->maxLengths);
        $template->setView("workplace_form");
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
        $err = (workplace::deleteWorkplace($id)) ? '' : 'delete_error=1';

        // nukreipiame į markių puslapį
        routing::redirect(routing::getModule(), 'list', $err);
    }
};