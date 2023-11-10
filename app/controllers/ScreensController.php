<?php

class ScreensController extends Controller
{
    private $screenModel;

    public function __construct()
    {
        $this->screenModel = $this->model('screenModel');
    }

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getScreens = $this->screenModel->getActiveScreens();
            $data = [
                'Screens' => $getScreens
            ];

            $this->view('screens/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate and process the form data, and insert a new screen into the database
            $createScreen = $this->screenModel->createScreen($post);

            if ($createScreen) {
                header('Location: ' . URLROOT . '/screenscontroller/overview/');
                exit();
            } else {
                // If screen creation failed, you can handle it here
                Helper::log('error', 'Screen could not be created.');
                header('Location: ' . URLROOT . '/screenscontroller/create/');
                exit();
            }
        } else {
            $this->view('screens/create');
        }
    }

    public function update($screenId)
    {
        $selectedScreen = $this->screenModel->getScreenById($screenId);

        if (!$selectedScreen) {
            Helper::log('error', 'Screen ID could not be found.');
            header('Location:' . URLROOT . 'screenscontroller/index/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the screen using the retrieved POST data
            $updated = $this->screenModel->updateScreen($screenId, $post);

            if ($updated) {
                // Screen updated successfully, redirect to the screen overview page
                header('Location: ' . URLROOT . 'screenscontroller/index/');
            } else {
                Helper::log('error', 'Screen update failed.');
                header('Location:' . URLROOT . 'screenscontroller/update/' . $screenId);
            }
            exit; // Move the exit statement here
        }

        // Load the update view with the selected screen data and list of entities
        $data = [
            'screen' => $selectedScreen,
        ];
        $this->view('screens/update', $data);
    }

    public function delete($screenId)
    {
        if ($this->screenModel->deleteScreen($screenId)) {
            header('Location:' . URLROOT . 'screenscontroller/overview/');
        } else {
            Helper::log('error', 'vehicle deletion failed.');
            header('Location:' . URLROOT . 'screenscontroller/overview/');
            exit;
        }
    }
}
