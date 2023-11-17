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

  public function imageUploader($screenId)
  {
    // Define the allowed file types
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'bmp'];
    // Check if the file input is set and not empty
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
      $file = $_FILES['file'];
      // Get the file extension
      $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      // Check if the file extension is allowed
      if (in_array($fileExtension, $allowedExtensions)) {
        // Create the directory if it doesn't exist
        $uploadDir = ROOT . '/public/media/' . date('Ymd');
        if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }
        // Generate the filename using the provided screenId
        $filename = $screenId . '.jpg';
        $filePath = $uploadDir . '/' . $filename;
        // Check if the file is successfully moved and saved
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
          // Return a success message or the file path
          return array(
            'status' => 200,
            'message' => 'Image uploaded successfully'
          );
        } else {
          return array(
            'status' => 500,
            'message' => 'Error uploading image. Please try again.'
          );
        }
      } else {
        return 'Invalid file type. Allowed types are: ' . implode(', ', $allowedExtensions);
      }
    } else {
      return 'No file selected for upload.';
    }
  }
}
