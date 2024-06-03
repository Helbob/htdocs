<?php

  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{

    $user_id = $_SESSION['user']['user_id'];
    $db = _db();
    $q = $db->prepare('UPDATE users SET user_deleted_at = :user_deleted_at WHERE user_id = :user_id');
    $q -> bindValue(':user_deleted_at', time());
    $q -> bindValue(':user_id', $user_id);
    $q->execute();
    
    // To see rows affected
    $deleted_rows = $q->rowCount();
    if ($deleted_rows != 1){
        throw new Exception('Could not delete user', 500);
    }
    http_response_code(204);

    echo json_encode(['info' => 'user updated']);

  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>
