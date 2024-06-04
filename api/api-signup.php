<?php 
  // user_id, user_first_name, user_last_name, user_email, user_password, user_phonenumber, 
  // user_role_fk, user_is_blocked, user_created_at, user_updated_at, user_deleted_at

  require_once __DIR__.'/../_.php';

  $profileImgArray = [
    'firstImg;' => '&#128110;',
    'secondImg;' => '&#128112;',
    'thirdImg;' => '&#129399;',
    'fourthImg' => '&#128103;',
    'fifthImg;' => '&#128116;',
  ];

  // Find random key
  $randomKeyImg = array_rand($profileImgArray, 1);
  // Find the emoji that matches that random key
  $randomImg = $profileImgArray[$randomKeyImg];

  header('Content-Type: application/json');
  try {
    
    // validate fields
    _validate_user_first_name('🥰 First name length must be '.USER_FIRST_NAME_MIN.' to '.USER_FIRST_NAME_MAX.' characters');
    _validate_user_last_name('🥶 Last name length must be '.USER_LAST_NAME_MIN.' to '.USER_LAST_NAME_MAX.' characters');
    _validate_user_email('😂 Invalid email');
    _validate_user_phonenumber('🤡 Invalid phonenumber, must be '.USER_PHONENUMBER_MIN.' to '.USER_PHONENUMBER_MAX.' digits');
    _validate_user_password('💀 Password length must be '.USER_PASSWORD_MIN.' to '.USER_PASSWORD_MAX.' characters');
    _validate_user_confirm_password('🤠 Confirm password does not match password');

    // send to database
    $db = _db();
    $q = $db->prepare('
      INSERT INTO users 
      VALUES (
        :user_id, 
        :user_first_name, 
        :user_last_name, 
        :user_email, 
        :user_password, 
        :user_phonenumber, 
        :user_role_fk, 
        :user_is_blocked,
        :user_created_at, 
        :user_updated_at,
        :user_deleted_at,
        :user_img
      )'
    );
    $q->bindValue(':user_id', null);
    $q->bindValue(':user_first_name', $_POST['user_first_name']);
    $q->bindValue(':user_last_name', $_POST['user_last_name']);
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));
    $q->bindValue(':user_phonenumber', $_POST['user_phonenumber']);
    $q->bindValue(':user_role_fk', 1);
    $q->bindValue(':user_is_blocked', 0);
    $q->bindValue(':user_created_at', time());
    $q->bindValue(':user_updated_at', 0);
    $q->bindValue(':user_deleted_at', 0);
    $q->bindValue(':user_img', $randomImg);

    $q->execute();

    $counter = $q->rowCount();
    if ($counter != 1) {
      throw new Exception('Server error', 500);
    }

    // set session
    $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->execute();
    $user = $q->fetch();

    $_SESSION['user'] = [
      'user_id' => $user['user_id'],
      'user_first_name' => $user['user_first_name'],
      'user_last_name' => $user['user_last_name'],
      'user_email' => $user['user_email'],
      'user_role_fk' => $user['user_role_fk'],
    ];

    http_response_code(201); // created
    echo json_encode($_SESSION['user']);
    
  } catch(Exception $e) {
    
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
    
  }
  
?>