<?php
  require_once __DIR__.'/../_.php';
  header('Content-Type: application/json');

  try{
    $user_id = $_SESSION['user']['user_id'];
    $user_first_name = $_SESSION['user']['user_first_name'];
    $user_last_name = $_SESSION['user']['user_last_name']; 
    $user_comments = $_POST['comment'];
    $product_id_comment_fk = $_POST['product_comment_id'];

   // echo json_encode(['id' => $product_id_comment_fk, 'comment' => $user_comments, 'user_id' =>$user_id, 'firstname' =>$user_first_name, 'lastname'=>$user_last_name]); 
    //exit;

    $db = _db();
    $q = $db->prepare('
      INSERT INTO comments 
      VALUES (
        :comment_id, 
        :commenter_first_name, 
        :commenter_last_name, 
        :user_comment, 
        :product_id_comment_fk, 
        :user_id_fk
        )'
    );
    $q->bindValue(':comment_id', null);
    $q -> bindValue(':commenter_first_name', $user_first_name);
    $q -> bindValue(':commenter_last_name', $user_last_name);
    $q -> bindValue(':user_comment',  $user_comments);
    $q -> bindValue(':product_id_comment_fk', $product_id_comment_fk);
    $q -> bindValue(':user_id_fk', $user_id);
    $q->execute();

    $inserted_id = $db->lastInsertId();
    $q = $db->prepare('SELECT comment_id, commenter_first_name, commenter_last_name, user_comment, product_id_comment_fk, user_id_fk, user_img
    FROM comments
    JOIN products ON comments.product_id_comment_fk = products.product_id
    JOIN users ON comments.user_id_fk = users.user_id
    WHERE comment_id = :comment_id
    ORDER BY comment_id DESC');
    $q->bindValue(':comment_id', $inserted_id);
    $q->execute();
    $comments = $q->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as &$comment) {
        // Base64 encode the user_img field
        $comment['user_img'] = base64_encode($comment['user_img']);
    }
    
    // To see rows affected
    $counter = $q->rowCount();
    
    echo json_encode($comments);

  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>