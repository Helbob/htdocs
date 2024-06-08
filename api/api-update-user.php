<?php

  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';

  try{
     // Retrieve JSON data from the request body
    //$jsonData = json_decode(file_get_contents('php://input'), true);
    
    // You might want to check if $jsonData['userUpdate'] is set before using it
   // $userUpdate = $jsonData['userUpdate'];
   /*  $userUpdate = json_decode($_POST['userUpdate'], true);
    $data = json_decode(file_get_contents('php://input'), true); */

        // Assuming $userUpdate is an array with 'user_first_name' and 'user_last_name'
    $user_id = $_SESSION['user']['user_id'];
    $user_first_name = $_POST['user_first_name'];
    $user_last_name = $_POST['user_last_name'];
    //echo json_encode(["user_id"=>"$user_id", "user_first_name"=>"$user_first_name","user_last_name"=>"$user_last_name"]);
  
    
    $db = _db();
    $q = $db->prepare('UPDATE users SET user_first_name = :user_first_name, user_last_name = :user_last_name, user_updated_at = :user_updated_at WHERE user_id = :user_id');
    $q -> bindValue(':user_first_name', $_POST['user_first_name']);
    $q -> bindValue(':user_last_name', $_POST['user_last_name']);
    $q -> bindValue(':user_updated_at', time());
    $q -> bindValue(':user_id', $user_id);
    $q->execute();
    // Too see rows affected
    $counter = $q->rowCount();

    echo json_encode(['info' => 'user updated']); 

  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>