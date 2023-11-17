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
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Screen creation successful.');
                header('Location: ' . URLROOT . '/screenscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Screen could not be created.');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Screen creation failed. Please try again.');
                header('Location: ' . URLROOT . '/screenscontroller/create/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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
            // Handle the case where the screen is not found
            Helper::log('error', 'Screen ID could not be found.');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Screen ID could not be found.');
            header('Location:' . URLROOT . 'screenscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the screen using the retrieved POST data
            $updated = $this->screenModel->updateScreen($screenId, $post);

            if ($updated) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Screen update was successful.');
                header('Location: ' . URLROOT . 'screenscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Screen update failed.');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Screen update failed.');
                header('Location:' . URLROOT . 'screenscontroller/update/' . $screenId . '/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            }
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
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Screen deletion was successful.');
            header('Location:' . URLROOT . 'screenscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit();
        } else {
            // Log the error using Helper
            Helper::log('error', 'Screen deletion failed.');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Screen deletion failed.');
            header('Location:' . URLROOT . 'screenscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit();
        }
    }
}
