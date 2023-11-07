<?php
class DashboardController extends Controller
{

  private $storeModel;

  public function __construct()
  {
    $this->storeModel = $this->model('storeModel');
  }

  public function overview()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $getActiveStores = $this->storeModel->getActiveStores();
      $data = [
        'Stores' => $getActiveStores
      ];

      $this->view('homepages/overview', $data);
    }
  }
}
