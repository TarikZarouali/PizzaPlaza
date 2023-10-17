<?php
// Dit wordt de parentclass van alle andere controller
// We loaden de model en de view
class Controller
{
  // Geen properties


  public function model($model)
  {
    require_once(APPROOT . '/models/' . $model . '.php');
    return new $model();
  }

  public function view($view, $data = [])
  {
    if (file_exists(APPROOT . '/views/' . $view . '.php')) {
      require_once(APPROOT . '/views/' . $view . '.php');
    } else {
      die('View bestaat niet');
    }
  }

  public function pagination($pageNumber, $recordsPerPage, $totalRecords)
  {
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $offset = ($pageNumber * $recordsPerPage) - $recordsPerPage;
    $nextPage = $pageNumber + 1;
    $previousPage = $pageNumber - 1;
    $firstPage = 1;
    $secondPage = 2;
    $thirdPage = 3;
    // Page number 1
    if ($pageNumber == 1) {
      $firstPage = $pageNumber;
    } else {
      if ($pageNumber == $totalPages) {
        $firstPage = $pageNumber - 2;
      } else {
        $firstPage = $pageNumber - 1;
      }
    }
    if ($pageNumber == 2) {
      if ($pageNumber == $totalPages) {
        $firstPage = $pageNumber - 1;
      } else {
        $firstPage = $pageNumber - 1;
      }
    }
    //Page number 2
    if ($pageNumber != 1) {
      $secondPage = $pageNumber;
      if ($pageNumber == $totalPages) {
        $secondPage = $pageNumber - 1;
      } else {
        $secondPage = $pageNumber;
      }
    } else {
      $secondPage = $pageNumber + 1;
    }
    if ($pageNumber == 2) {
      if ($pageNumber == $totalPages) {
        $secondPage = $pageNumber;
      } else {
        $secondPage = $pageNumber;
      }
    }
    //Page number 3
    if ($pageNumber == 1 || $pageNumber == 2) {
      $thirdPage = 3;
    } elseif ($pageNumber == $totalPages) {
      $thirdPage = $pageNumber;
    } else {
      $thirdPage = $pageNumber + 1;
    }
    return $data = [
      'pageNumber' => $pageNumber,
      'recordsPerPage' => $recordsPerPage,
      'offset' => $offset,
      'nextPage' => $nextPage,
      'previousPage' => $previousPage,
      'totalPages' => $totalPages,
      'firstPage' => $firstPage,
      'secondPage' => $secondPage,
      'thirdPage' => $thirdPage
    ];
  }
}