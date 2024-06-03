<?php

  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{
     $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['product_id_comment_fk'])) {
      throw new Exception('comment_id not found', 400);
    }
    $comment_id = $data['product_id_comment_fk'];

    $db = _db();
    $q = $db->prepare('SELECT comment_id, commenter_first_name, commenter_last_name, user_comment, product_id_comment_fk, user_id_fk, users.user_img
    FROM comments
    JOIN products ON comments.product_id_comment_fk = products.product_id
    JOIN users ON comments.user_id_fk = users.user_id
    WHERE products.product_id = :comment_id');
    $q->bindValue(':comment_id', $comment_id);
    $q->execute();
    $comments = $q->fetchAll();
    echo json_encode($comments);

  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>


