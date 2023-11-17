<?php
class ProductsController extends Controller
{

    private $productModel;
    private $customerModel;
    private $screenModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
        $this->customerModel = $this->model('customerModel');
        $this->screenModel = $this->model('screenModel');
    }

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getProducts = $this->productModel->getActiveproducts();
            $data = [
                'Products' => $getProducts
            ];

            $this->view('products/overview', $data);
        }
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $productOwner = ($post['productOwner']);
            $productName = ($post['productName']);
            $productDescription = ($post['productDescription']);
            $productPrice = ($post['productPrice']);
            $productType = ($post['productType']);

            if (
                empty($productOwner) || empty($productName) ||
                empty($productDescription) || empty($productPrice) ||
                empty($productType)
            ) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the product has failed');
                header('Location:' . URLROOT . '/productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                // Form data is valid; proceed with creating the customer
                $this->productModel->createProduct($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the product was successful');

                header('Location:' . URLROOT . '/productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            $activeCustomers = $this->customerModel->getactiveCustomers(); // Retrieve active stores
            $data = [
                'Customers' => $activeCustomers,
            ];

            $this->view('products/create', $data);
        }
    }

    public function delete($productId)
    {
        if ($this->productModel->deleteProduct($productId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Product deletion was successful');
            header('Location: ' . URLROOT . '/productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', 'Product deletion has failed');
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Product deletion has failed');
            header('Location:' . URLROOT . '/productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }


    public function update($productId = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->productModel->updateProduct($productId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the product was successful');
                    header('Location:' . URLROOT . 'productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the product has failed');
                    header('Location:' . URLROOT . 'productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->productModel->getProductById($productId);
            $image = $this->screenModel->getScreenDataById($productId, 'product', 'main');
            if ($image !== false) {
                // Check if the necessary properties exist before accessing them
                if (property_exists($image, 'screenCreateDate') && property_exists($image, 'screenId')) {
                    $createDate = date('Ymd', $image->screenCreateDate);
                    $imageSrc = URLROOT . 'public/media/' . $createDate . '/' . $image->screenId . '.jpg';
                } else {
                    // Handle the case where expected properties are missing
                    $imageSrc = URLROOT . 'public/default-image.jpg';
                }
            } else {
                // Handle the case where no image data is found
                $imageSrc = URLROOT . 'public/default-image.jpg';
            }
            $data = [
                'Product' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('products/update', $data);
        }
    }


    public function updateImage($productId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'product';
            $this->screenModel->insertScreenImages($screenId, $productId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
        // Redirect to the overview page
    }
}
