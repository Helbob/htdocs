<?php

  require_once __DIR__.'/../_.php';
  
  header('Content-Type: application/json');
  try {
    
    $db = _db();

    $q = $db->prepare('
      SELECT user_id, user_first_name, user_last_name,user_phonenumber, user_email, user_is_blocked, role_name
      FROM users
      INNER JOIN roles ON users.user_role_fk = roles.role_id
      LIMIT :offset, :users_per_page
    ');
    $q->bindValue(':offset', _USERS_PER_PAGE * ($_POST['user_page'] - 1), PDO::PARAM_INT);
    $q->bindValue(':users_per_page', _USERS_PER_PAGE, PDO::PARAM_INT);
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