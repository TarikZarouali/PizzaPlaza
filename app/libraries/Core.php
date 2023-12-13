<?php
class Core
{
    protected $currentController = 'homepage';
    protected $currentMethod = 'overview';
    protected $params = '';

    public function __construct()
    {
        //get the current url
        $url = $this->getUrl();
        $urlSlug = $url;

        //check if the controller exists for the current url
        if (file_exists(APPROOT . '/controllers/' . ucwords($url[0]) . '.php')) {
            //change the currentcontroller to the controller in the url
            $this->currentController = ucwords($url[0]);
        }

        //if the controller doesn't exist then change the controller to $currentController
        require_once APPROOT . '/controllers/' . $this->currentController . '.php';
        //instantiate the controllerClass
        define('CURRENTCONTROLLER', $this->currentController);
        $this->currentController = new $this->currentController();

        //Check if the second part of the url is set and if the method exists
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($urlSlug[1]);
            } else if (!empty($url[1])) {
                require APPROOT . '/views/includes/404.php';
                exit;
            }
        }

        $this->params = $url ? $url[2] : '';

        // Ensure $this->params is a string
        if (is_array($this->params)) {
            $this->params = implode('', $this->params);
        }

        // URL decode the string and remove unwanted characters
        $decodedString = str_replace(['{', '}'], '', urldecode($this->params));

        // Explode the string using ';' as the main delimiter
        $pairs = explode(';', $decodedString);

        // Initialize an empty associative array
        $array = [];

        // Iterate through each pair and explode using ':' as the delimiter
        foreach ($pairs as $pair) {
            if (is_string($pair) && strpos($pair, '[') !== false && strpos($pair, ']') !== false) {
                // Extract content between square brackets
                preg_match('/\[(.*?)\]/', $pair, $matches);

                // Check if there are matches
                if (isset($matches[1])) {
                    // Extracted content between square brackets
                    $contentBetweenBrackets = $matches[1];

                    // Split the content into an array using ","
                    $valuesArray = explode(',', $contentBetweenBrackets);

                    $array['ingredients'] = $valuesArray;
                }
            } else {
                $parts = explode(':', $pair, 2); // Limit to 2 parts to handle values with colons
                if (count($parts) == 2) {
                    $array[trim($parts[0], '{}')] = $parts[1];
                }
            }
        }

        // Check if the URL contains a "sort" parameter
        if (strpos($_SERVER['REQUEST_URI'], 'sort=') !== false) {
            // Extract the "sort" parameter from the URL
            $sortParam = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'sort=') + 5);

            // Check if the "sort" parameter is valid (ASC or DESC)
            if (in_array($sortParam, ['ASC', 'DESC'])) {
                // Set the sort option in the associative array
                $array['sort'] = $sortParam;
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

        if (isset($incoming)) {
            //remove the backslash from the front of the url
            $incoming = trim($incoming, "/");


            $url = filter_var($incoming, FILTER_SANITIZE_URL);
            // Check if the string contains %7B
            if (strpos($url, '%7B') !== false && strpos($url, '%7D') !== false) {
                // Parse the URL
                $urlParts = parse_url($url);

                // Split the string by slashes
                $parts = explode('/', $urlParts['path']);

                // Keep the first two parts and include the slash if it exists
                $changedUrl = implode('/', array_slice($parts, 0, 2));
            }

            if (strpos($incoming, '?') !== false) {
                // Get everything behind the "?" character
                $queryString = substr($incoming, strpos($incoming, '?') + 1);

                // Explode the query string into an array
                $queryParamsArray = explode('&', $queryString);

                // Initialize an associative array to store key-value pairs
                $params = array();

                foreach ($queryParamsArray as $pair) {
                    // Split the pair into key and value
                    list($key, $value) = explode('=', $pair);
                    // Check if the key is "ingredients"
                    if ($key === 'ingredients') {
                        // If the key is "ingredients", add the value to an array
                        $params[$key][] = $value;
                    } else {
                        // If the key is not "ingredients", add it as is
                        $params[$key] = $value;
                    }
                }

                $filteredParams = array_filter($params, function ($value) {
                    return !empty($value) && $value !== 'NULL';
                });

                // Parse the URL
                $urlParts = parse_url($url);

                // Parse the query string
                parse_str($urlParts['query'], $queryParams);

                // Create the new URL format
                $newUrl = (isset($changedUrl)) ? $changedUrl . "/{" : $urlParts['path'] . "{";
                // Iterate through each key-value pair
                foreach ($filteredParams as $key => $value) {
                    // Check if the key is "ingredients"
                    if ($key === 'ingredients' && is_array($value)) {
                        // If the key is "ingredients" and the value is an array, format it as "key[value1,value2];"
                        $newUrl .= $key . '[' . implode(',', $value) . '];';
                    } else {
                        // If the key is not "ingredients" or the value is not an array, append key and value to the URL format
                        $newUrl .= $key . ':' . $value . ';';
                    }
                }
                $newUrl .= "}";

                // Check if the URL contains a "sort" parameter
                if (strpos($incoming, 'sort=') !== false) {
                    // Extract the "sort" parameter from the URL
                    $sortParam = substr($incoming, strpos($incoming, 'sort=') + 5);

                    // Check if the "sort" parameter is valid (ASC or DESC)
                    if (in_array($sortParam, ['ASC', 'DESC'])) {
                        // Append the "sort" parameter to the URL format
                        $newUrl .= 'sort=' . $sortParam . '';
                    }
                }

                $transformedParams = [];
                foreach ($params as $key => $value) {
                    if (is_array($value)) {
                        // If the value is an array, urldecode each element
                        $decodedValues = array_map('urldecode', $value);
                        $transformedParams[urldecode($key)] = $decodedValues;
                    } else {
                        // If the value is not an array, urldecode it
                        $transformedParams[urldecode($key)] = urldecode($value);
                    }
                }

                header("Location:" . URLROOT . $newUrl . '/');
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
            return array('homepage', 'overview');
        }
    }
}
