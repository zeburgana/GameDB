<?php
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.6.2
 * Time: 19.06
 */

require_once "libraries/console.php";
require_once "utils/paging.class.php";
require_once "utils/validator.class.php";

class consoleController {
    public static $defaultAction = "list";

    // nustatome privalomus laukus
    private $required = array('name', 'cpu', 'gpu', 'max_resolution_output', 'wifi_adapter', 'price');

    // maksimalūs leidžiami laukų ilgiai
    private $maxLengths = array (
        'name'          => 45,
        'cpu'  => 45,
        'gpu'         => 45,
        'portable'     => 4,
        'max_resolution_output'     => 45,
        'wifi_adapter'      =>  45,
        'controller_support'         =>  45,
        'RJ-45'         =>  45,
        'VR_ready'         =>  45,
        'backwards_compatibility'         =>  45,
        'online_store'         =>  45,
        'price'         =>  11
    );

    // nustatome laukų validatorių tipus
    private $validations = array (
        'name'          => 'varchar',
        'cpu'  => 'varchar',
        'gpu'         => 'varchar',
        'portable'     => 'tinyint',
        'max_resolution_output'     => 'varchar',
        'wifi_adapter'      =>  'varchar',
        'controller_support'         =>  'varchar',
        'RJ-45'         =>  'varchar',
        'VR_ready'         =>  'varchar',
        'backwards_compatibility'         =>  'varchar',
        'online_store'         =>  'varchar',
        'price'         =>  'int'
    );

    public function listAction() {
        // suskaičiuojame bendrą įrašų kiekį
        $elementCount = console::getConsoleListCount();

        // sukuriame puslapiavimo klasės objektą
        $paging = new paging(NUMBER_OF_ROWS_IN_PAGE);

        // suformuojame sąrašo puslapius
        $paging->process($elementCount, routing::getPageId());

        // išrenkame nurodyto puslapio markes
        $data = console::getConsoleList($paging->size, $paging->first);

        $template = template::getInstance();

        $template->assign('data', $data);
        $template->assign('pagingData', $paging->data);

        if(!empty($_GET['delete_error']))
            $template->assign('delete_error', true);

        if(!empty($_GET['id_error']))
            $template->assign('id_error', true);

        $template->setView("console_list");
    }

    public function createAction() {
        $data = $this->validateInput();
        // If entered data was valid
        if ($data) {
            // Find max ID in the database
            $latestId = console::getMaxIdOfConsole();
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
            console::updateConsole($data);

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
        $template->setView("console_form");
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
        $err = (console::deleteConsole($id)) ? '' : 'delete_error=1';

        // nukreipiame į markių puslapį
        routing::redirect(routing::getModule(), 'list', $err);
    }
};