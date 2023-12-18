<?php
class Homepage extends Controller
{

    private $productModel;
    private $screenModel;
    private $ingredientModel;
    private $storeModel;
    private $homepageModel;

    private $customerModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
        $this->storeModel = $this->model('storeModel');
        $this->screenModel = $this->model('screenModel');
        $this->homepageModel = $this->model('homepageModel');
        $this->ingredientModel = $this->model('ingredientModel');
        $this->customerModel = $this->model('customerModel');
    }

    public function overview($params = null)
    {
        global $productType;

        $ingredients = $this->ingredientModel->getActiveIngredients();
        $stores = $this->storeModel->getActiveStores();

        $sortOption = isset($params['sort']) ? $params['sort'] : null;
        $keyword = isset($params['search']) ? $params['search'] : null;
        $page = isset($params['page']) ? intval($params['page']) : 1;


        $recordsPerPage = 4;

        // Calculate offset based on the current page
        $offset = ($page - 1) * $recordsPerPage;

        // Retrieve products based on pagination settings
        if (isset($sortOption) && !empty($sortOption)) {
            $productsResult = $this->homepageModel->sortProductByPrice($sortOption, $recordsPerPage, $offset);
        } elseif (isset($keyword) && !empty($keyword)) {
            $productsResult = $this->homepageModel->searchProduct($keyword, $offset, $recordsPerPage);
        } else {
            $productsResult = $this->homepageModel->getProductsByFilter($params, $offset, $recordsPerPage);
        }

        // Update countProducts for proper total pages calculation
        $countProducts = count($this->homepageModel->getProductsByFilter($params));

        // Recalculate the total number of pages
        $totalPages = ceil($countProducts / $recordsPerPage);
        $page = max(1, min($page, $totalPages));

        // Initialize $products array
        $products = [];

        if (!empty($productsResult)) {
            foreach ($productsResult as $product) {
                $productId = $product->productId;
                if (!isset($products[$productId])) {
                    $products[$productId] = $product;
                }
            }
            foreach ($products as $product) {
                $product->imagePath = $this->screenModel->getScreenImage($product->productId);
            }
        }

        $nextPage = $page < $totalPages ? $page + 1 : null;
        $prevPage = $page > 1 ? $page - 1 : null;
        $numberButtons = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $numberButtons[] = $i;
        }

        $paginationButtons = [
            'nextPage' => $nextPage,
            'prevPage' => $prevPage,
            'numberButtons' => $numberButtons
        ];

        $urlQuery = [];

        foreach ($paginationButtons as $buttonName => $buttonValue) {
            if (is_array($buttonValue)) {
                foreach ($buttonValue as $numberButton) {
                    $urlQuery[$buttonName][$numberButton] = URLROOT . "homepages/overview/{page:" . $numberButton . ";";

                    // Iterate through each key-value pair
                    foreach ($params as $key => $value) {
                        if ($key !== 'page') {
                            // Check if the key is "ingredients"
                            if (is_array($value)) {
                                // If the key is "ingredients" and the value is an array, format it as "key[value1,value2];"
                                $urlQuery[$buttonName][$numberButton] .= $key . ':[' . implode(',', $value) . '];';
                            } else {
                                // If the key is not "ingredients" or the value is not an array, append key and value to the URL format
                                $urlQuery[$buttonName][$numberButton] .= $key . ':' . $value . ';';
                            }
                        }
                    }
                    $urlQuery[$buttonName][$numberButton] .= "}";
                }
            } else {
                $urlQuery[$buttonName] = URLROOT . "homepages/overview/{page:" . $buttonValue . ";";

                // Iterate through each key-value pair
                foreach ($params as $key => $value) {
                    if ($key !== 'page') {
                        // Check if the key is "ingredients"
                        if (is_array($value)) {
                            // If the key is "ingredients" and the value is an array, format it as "key[value1,value2];"
                            $urlQuery[$buttonName] .= $key . ':[' . implode(',', $value) . '];';
                        } else {
                            // If the key is not "ingredients" or the value is not an array, append key and value to the URL format
                            $urlQuery[$buttonName] .= $key . ':' . $value . ';';
                        }
                    }
                }
                $urlQuery[$buttonName] .= "}";
            }
        }

        $data = [
            'ingredients' => $ingredients,
            'productTypes' => $productType,
            'stores' => $stores,
            'products' => $products,
            'params' => $params,
            'totalProducts' => $countProducts,
            'currentPage' => $page,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
            'urlQuery' => $urlQuery
        ];

        $this->view('homepages/overview', $data);
    }
}
