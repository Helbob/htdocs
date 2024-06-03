<?php

  header('Content-Type: application/json');
  require_once __DIR__.'/../_.php';
  try{
     $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['product_id'])) {
      throw new Exception('product_id not found', 400);
    }
    $product_id = $data['product_id'];

    $db = _db();
    $q = $db->prepare('SELECT product_id, product_name, product_img, product_description, product_price, product_rating 
    FROM `products`  
    WHERE product_id = :product_id');
    $q->bindValue(':product_id', $product_id);
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