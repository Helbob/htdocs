<?php
  require_once __DIR__.'/../_.php';

  header('Content-Type: application/json');
  try {

    $data = json_decode(file_get_contents('php://input'), true);

    $user_email = $data['user_email'];
    
    $db = _db();
    $q = $db->prepare('
      SELECT * FROM users WHERE user_email = :user_email;
    ');
    $q->bindValue(':user_email', $user_email);
    $q->execute();

    $counter = $q->rowCount();
    if ($counter == 1) {
      throw new Exception('Email "'.$user_email.'" already exists', 400);
    }

    echo json_encode(['info' => '👍']);
    
  } catch(Exception $e) {
    
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
    
  }

?>