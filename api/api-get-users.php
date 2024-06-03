<?php

  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{

    $db = _db();
    $q = $db->prepare('SELECT user_id, user_first_name, user_last_name, user_is_blocked, user_email, user_phonenumber, role_name FROM `users` INNER JOIN roles ON users.user_role_fk= roles.role_id');
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