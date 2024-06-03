<?php
  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{

    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['user_id'])) {
      throw new Exception('user_id not found', 400);
    }
    $user_id = $data['user_id'];
    //$user_is_blocked = $_POST['user_is_blocked'];
 
    $db = _db();
    $q = $db->prepare("
      UPDATE users
      SET user_is_blocked = !user_is_blocked
      WHERE user_id = :user_id
    ");

    $q->bindValue(':user_id', $user_id);
    $q->execute();
    echo json_encode(['info' => 'User id '.$user_id.' blocked']);

    //echo json_encode($user_id); 
    //echo 'x';

  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>