<?php

  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{
     $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['user_id'])) {
      throw new Exception('user_id not found', 400);
    }
    $user_id = $data['user_id'];

    $db = _db();
    $q = $db->prepare('SELECT user_id, user_first_name, user_last_name, user_is_blocked, user_email, user_phonenumber, user_created_at, user_updated_at, user_deleted_at, role_name 
    FROM `users` INNER JOIN roles 
    ON users.user_role_fk= roles.role_id 
    WHERE user_id = :user_id');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $users = $q->fetchAll();
    echo json_encode($users);

  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>