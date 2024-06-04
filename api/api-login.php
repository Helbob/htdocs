<?php 
  // user_id, user_first_name, user_last_name, user_email, user_password, user_phonenumber, 
  // user_role_fk, user_is_blocked, user_created_at, user_updated_at
 require_once __DIR__.'/../_.php';

 header('Content-Type: application/json');
  try {
    
    // validate fields
    _validate_user_email('E-mail or password is incorrect');
    _validate_user_password('E-mail or password is incorrect');

    $db = _db();

    $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->execute();
    $user = $q->fetch();

    if (!$user) {
      throw new Exception('Invalid email or password.');
    }

    if (!password_verify($_POST['user_password'], $user['user_password'])) {
      throw new Exception('Invalid email or password.');
    }

    $_SESSION['user'] = [
      'user_id' => $user['user_id'],
      'user_first_name' => $user['user_first_name'],
      'user_last_name' => $user['user_last_name'],
      'user_email' => $user['user_email'],
      'user_role_fk' => $user['user_role_fk'],
    ];

    echo json_encode($_SESSION['user']);

  } catch(Exception $e) {
    
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
    
  }

?>