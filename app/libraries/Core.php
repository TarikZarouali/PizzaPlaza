<?php
class Core
{
    protected $currentController = 'DashboardController';
    protected $currentMethod = 'overview';
    protected $params = [];

    public function __construct()
    {
        //get the current url
        $url = $this->getUrl();
        $urlSlug = $url;

        //check if the controller exists for the current url
        if (file_exists(APPROOT . '/controllers/' . ucwords($url[0]) . '.php')) {
            //change the currentcontroller to the controller in the url
            $this->currentController = ucwords($url[0]);
            //destroy the first part of the url after the the urlroot
            // unset($url[0]);
        }


        //if the controller doesn't exist then change the controller to $currentController
        require_once APPROOT . '/controllers/' . $this->currentController . '.php';
        //instantiate the controllerClass
        $this->currentController = new $this->currentController();

        //Check if the second part of the url is set and if the method exists
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($urlSlug[1]);
            }
        }

        $this->params = $url ? [$url[2]] : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        // $_GET['url'] comes from the /public/.htaccess line 7
        $incoming = $_SERVER['REQUEST_URI'];

        // Remove the base URL from the request
        $incoming = str_replace("/pizzaplaza/", "", $incoming);

        // Ensure a trailing slash
        if (!empty($incoming) && substr($incoming, -1) !== '/') {
            $incoming .= '/';
        }

        // Trim leading and trailing slashes
        $incoming = trim($incoming, "/");

        $url = filter_var($incoming, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        $urlController = $url[0];

        $urlAction = "";
        if (array_key_exists(1, $url)) {
            $urlAction = explode('?', $url[1])[0];
        }

        $urlSlug = $url;
        if (array_key_exists(2, $url)) {
            $urlSlug = $url[2];
        }



        // $modal = array('title' => '', 'message' => '');

        // // //$data = $url[2];

        // // // Remove curly braces "{" and "}" from the string
        // // $data = str_replace(['%7B', '%7D'], '', $data);
        // // $data = explode(";", $data);

        // // foreach ($data as $entry) {
        // //     $entry = explode(':', $entry);
        // //     if ($entry[0] == 'title') {
        // //         $modal['title'] = $entry[1];
        // //     }

        // //     if ($entry[0] == 'message') {
        // //         $modal['message'] = $entry[1];
        // //     }
        // // }


        $output = [$urlController, $urlAction, $urlSlug];

        return $output;
    }
}
