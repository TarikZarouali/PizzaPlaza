<?php
class Core
{
    protected $currentController = 'DashboardController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        //get the current url
        $url = $this->getUrl();

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
                // unset($url[1]);
            }
        }

        $this->params = $url ? [$url[2]]: [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        //$_GET['url'] comes from the /public/.htaccess line 7
        $incoming = $_SERVER['REQUEST_URI'];

        // 20230224 - forgive me, but PHP + apache mod_rewrite is just no fun...
        // especially on a Friday! 
        $incoming = str_replace("/school/", "", $incoming);
        if (isset($incoming)) {
            //remove the backslash from the front of the url
            $incoming = trim($incoming, "/");
            $url = filter_var($incoming, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // TODO: check if there is a value here for $urlController
            $urlController = $url[0];

            $urlAction = "";
            if (array_key_exists(1, $url)) {
                $urlAction = explode('?', $url[1])[0];
            }

            $urlSlug = "";
            if (array_key_exists(2, $url)) {
                $urlSlug = $url[2];
            }
            $output = [$urlController, $urlAction, $urlSlug];

            return $output;
        } else {
            return array('DashboardController', 'index');
        }
    }
}