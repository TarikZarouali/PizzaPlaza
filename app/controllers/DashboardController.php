<?php
class DashboardController extends Controller
{

  public function index()
  {
    $data = [
      'title' => "Homepage"
    ];
    $this->view('homepages/index', $data);
  }
}