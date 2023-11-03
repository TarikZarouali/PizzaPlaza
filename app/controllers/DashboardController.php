<?php
class DashboardController extends Controller
{

  private $storeModel;

  public function __construct()
  {
    $this->storeModel = $this->model('storeModel');
  }

  public function index()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $getStores = $this->storeModel->getActiveStores();
      $data = [
        'Stores' => $getStores
      ];

      $this->view('homepages/index', $data);
    }
  }
}
