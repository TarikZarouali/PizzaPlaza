<?php
class Core
{
    protected $currentController = 'Homepage';
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

        $this->params = $url ? $url[2] : '';

        // Ensure $this->params is a string
        if (is_array($this->params)) {
            $this->params = implode(
                '',
                $this->params
            );
        }

        // URL decode the string and remove unwanted characters
        $decodedString = str_replace(['{', '}'], '', urldecode($this->params));

        // Explode the string using ';' as the main delimiter
        $pairs = explode(';', $decodedString);

        // Initialize an empty associative array
        $array = [];

        // Iterate through each pair and explode using ':' as the delimiter
        foreach ($pairs as $pair) {
            $parts = explode(
                ':',
                $pair,
                2
            ); // Limit to 2 parts to handle values with colons
            if (count($parts) == 2) {
                $array[trim($parts[0], '{}')] = $parts[1];
            }
        }

        call_user_func_array([$this->currentController, $this->currentMethod], [$array]);
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
        if (isset($incoming)) {
            //remove the backslash from the front of the url
            $incoming = trim($incoming, "/");
            $url = filter_var($incoming, FILTER_SANITIZE_URL);
            if (strpos($incoming, '?') !== false) {
                // Get everything behind the "?" character
                $queryString = substr($incoming, strpos($incoming, '?') + 1);

                // Explode the query string into an array
                $queryParamsArray = explode('&', $queryString);

                // Initialize an associative array to store key-value pairs
                $params = array();

                // Iterate through each key-value pair
                foreach ($queryParamsArray as $pair) {
                    // Split the pair into key and value
                    list($key, $value) = explode('=', $pair);

                    // Add to the associative array
                    $params[$key] = $value;
                }

                // Parse the URL
                $urlParts = parse_url($url);

                // Parse the query string
                parse_str($urlParts['query'], $queryParams);

                // Create the new URL format
                $newUrl = $urlParts['path'] . "{";

                // Iterate through each key-value pair
                foreach ($params as $key => $value) {
                    // Append key and value to the URL format
                    $newUrl .= $key . ':' . $value . ';';
                }

                $newUrl .= "}/";

                $transformedParams = [];
                foreach ($params as $key => $value) {
                    $transformedParams[urldecode($key)] = urldecode($value);
                }

                // Output or use the associative array as needed
                Helper::dump($transformedParams);

                // Example: Extract 'page' parameter
                $pageNumber = isset($transformedParams['page']) ? (int)$transformedParams['page'] : 1;
                Helper::dump($pageNumber);

                // Output or use the associative array as needed
                Helper::dump($this->params);

                header("Location:" . URLROOT . $newUrl);
                exit();
            }

            // Trim leading and trailing slashes
            $incoming = rtrim($incoming, "/");

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

            $output = [$urlController, $urlAction, $urlSlug];

            return $output;
        } else {
            return array('Pizza', 'overview');
        }
    }
}
