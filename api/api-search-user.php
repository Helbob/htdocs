<?php
  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{
    // TODO: Validation for the serach (user_name_or_last_name)
    
    //`SELECT user_first_name, user_last_name, user_is_blocked, role_name FROM `users` INNER JOIN roles ON users.user_role_fk = roles.role_id`;
    
    // echo json_encode($_POST['query']);
    $db = _db();
    $q = $db->prepare("SELECT user_id, user_first_name, user_last_name, user_phonenumber, user_email, user_is_blocked, role_name
      FROM users
      INNER JOIN roles ON users.user_role_fk = roles.role_id
      WHERE user_first_name LIKE :user_first_name
      OR user_last_name LIKE :user_last_name
      OR user_email LIKE :user_email
      OR user_phonenumber LIKE :user_phonenumber
      OR role_name LIKE :role_name
      LIMIT 5
    ");

    $q->bindValue(':user_first_name', "%{$_POST['query']}%");
    $q->bindValue(':user_last_name', "%{$_POST['query']}%");
    $q->bindValue(':user_email', "%{$_POST['query']}%");
    $q->bindValue(':user_phonenumber', "%{$_POST['query']}%");
    $q->bindValue(':role_name', "%{$_POST['query']}%");
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