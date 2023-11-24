<?php
// Dit wordt de parentclass van alle andere controller
// We loaden de model en de view
class Controller
{
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

    // Ensure the page number is within valid bounds
    $pageNumber = max(1, min($totalPages, $pageNumber));

    $offset = ($pageNumber - 1) * $recordsPerPage;

    $nextPage = ($pageNumber < $totalPages) ? '{page:' . ($pageNumber + 1) . '}' : null;
    $previousPage = ($pageNumber > 1) ? '{page:' . ($pageNumber - 1) . '}' : null;
    $firstPage = '{page:' . max(1, $pageNumber - 1) . '}';
    $secondPage = '{page:' . $pageNumber . '}';
    $thirdPage = '{page:' . min($totalPages, $pageNumber + 1) . '}';

    // Generate the page parameter for the URL
    $pageParameter = ($pageNumber > 1) ? '{page:' . $pageNumber . '}' : '';

    return [
      'pageNumber' => $pageNumber,
      'recordsPerPage' => $recordsPerPage,
      'offset' => $offset,
      'nextPage' => $nextPage,
      'previousPage' => $previousPage,
      'totalPages' => $totalPages,
      'firstPage' =>  $firstPage,
      'secondPage' =>  $secondPage,
      'thirdPage' =>  $thirdPage,
      'pageParameter' => $pageParameter,
    ];
  }






  public function imageUploader($screenId, $i = null)
  {
    // Define the allowed file types
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'bmp'];
    // Check if the file input is set and not empty
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
      $file = $_FILES['file'];
      $fileName = (isset($i) || !empty($i)) ? $file['name'][$i] : $file['name'];
      $fileTmpName = (isset($i) || !empty($i)) ? $file['tmp_name'][$i] : $file['tmp_name'];
      // Get the file extension
      $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      // Check if the file extension is allowed
      if (in_array($fileExtension, $allowedExtensions)) {
        // Create the directory if it doesn't exist
        $uploadDir = ROOT . '/public/media/' . date('Ymd');
        if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }
        // Generate the finalFileName using the provided screenId
        $finalFileName = $screenId . '.jpg';
        $finalFilePath = $uploadDir . '/' . $finalFileName;
        // Check if the file is successfully moved and saved
        if (move_uploaded_file($fileTmpName, $finalFilePath)) {
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

  public function multipleImageUploader($screenId)
  {
    // Define the allowed file types
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'bmp'];
    $uploadDir = ROOT . '/public/media/' . date('Ymd');
    $uploadErrors = [];

    $file = $_FILES['file'];

    // Check if files are set and not empty
    if (isset($file) && !empty($file['name'])) {
      // Convert to array if only one file is uploaded
      $fileTmpNames = (is_array($file['tmp_name'])) ? $file['tmp_name'] : [$file['tmp_name']];
      // Loop through each file
      foreach ($fileTmpNames as $key => $tmpName) {
        // Get the file extension without duplication
        $fileExtension = strtolower(pathinfo($file['name'][$key], PATHINFO_EXTENSION));
        // Debugging statement

        // Check if the file extension is allowed (case-insensitive)
        if (in_array($fileExtension, $allowedExtensions, true)) {
          // Create the directory if it doesn't exist
          if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
          }

          // Generate the filename using the provided screenId and original filename
          $filename = $screenId . '_' . $key . '.' . $fileExtension;
          $filePath = $uploadDir . '/' . $filename;

          // Check if the file is successfully moved and saved
          if (move_uploaded_file($tmpName, $filePath)) {
            // File uploaded successfully
            // You can add additional logic here if needed
          } else {
            // Error uploading file
            $uploadErrors[] = 'Error uploading file ' . $file['name'][$key];
          }
        } else {
          // Invalid file type
          $uploadErrors[] = 'Invalid file type for ' . $file['name'][$key];
        }
      }
    } else {
      // No file selected for upload
      $uploadErrors[] = 'No file selected for upload.';
    }

    if (empty($uploadErrors)) {
      return [
        'status' => 200,
        'message' => 'Images uploaded successfully'
      ];
    } else {
      return [
        'status' => 500,
        'message' => implode('; ', $uploadErrors)
      ];
    }
  }
}
