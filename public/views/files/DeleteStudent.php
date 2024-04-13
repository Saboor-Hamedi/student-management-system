<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
use Thesis\config\Database;
use Thesis\controllers\users\DeleteUsers;


// Assuming the AJAX request sends the ID in the "id" parameter:
$scoreId = isset($_POST['id']) ? $_POST['id'] : null;
$database = Database::GetInstance();

if ($scoreId) {
  $delete = new DeleteUsers($database);
  $result = $delete->destroy($scoreId); // Pass the received score ID
  if ($result) {
    // Deletion was successful
    echo json_encode(array('success' => true));
  } else {
    // Deletion failed
    echo json_encode(array('success' => false, 'error' => 'Failed to delete record'));
  }
} else {
  // Handle missing score ID case (optional: return error message)
  echo json_encode(array('success' => false, 'error' => 'Missing score ID'));
}
