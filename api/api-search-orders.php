<?php
  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{
    // TODO: Validation for the serach (user_name_or_last_name)
    
    //`SELECT user_first_name, user_last_name, user_is_blocked, role_name FROM `users` INNER JOIN roles ON users.user_role_fk = roles.role_id`;
    
    // echo json_encode($_POST['query']);

 
    $db = _db();
      $q = $db->prepare('SELECT order_id, product_name, user_first_name, product_img, order_is_delivered
      FROM `orders` 
      INNER JOIN products ON orders.order_product_fk = products.product_id 
      INNER JOIN users ON orders.order_user_fk = users.user_id
      WHERE order_id LIKE :order_id
      OR user_first_name LIKE :user_first_name
      OR product_name LIKE :product_name');

    $q->bindValue(':order_id', "%{$_POST['query']}%");
    $q->bindValue(':user_first_name', "%{$_POST['query']}%");
    $q->bindValue(':product_name', "%{$_POST['query']}%");
/*     $q->bindValue(':user_first_name', "%{$_POST['query']}%");
    $q->bindValue(':user_last_name', "%{$_POST['query']}%"); */
    $q->execute();
    $orders = $q->fetchAll();
    
    echo json_encode($orders);


  } catch(Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
  }
?>