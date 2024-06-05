<?php
require_once __DIR__.'/../_.php';
header('Content-Type: application/json');

    //session_start(); // Ensure session is started

try {
    
     if(!isset($_SESSION['user']['user_id'])) {
        
        throw new Exception("User not logged in.");
    }
    
    $user_id = $_SESSION['user']['user_id'];  
    
    
    if(isset($_FILES['profilepicture'])) {

       
        $fileName = basename($_FILES['profilepicture']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
       
        $allowedTypes = ['jpg', 'png', 'jpeg'];
        if(in_array(strtolower($fileType), $allowedTypes)) {
              
            // Read the file content securely
            $tmpName = $_FILES['profilepicture']['tmp_name'];
            $imgContent = file_get_contents($tmpName);
            
            $db = _db();
            // Update statement
            $sql = "UPDATE users SET user_img = :imgContent WHERE user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':imgContent', $imgContent, PDO::PARAM_LOB);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Optionally, fetch the updated record
            $sql = "SELECT user_img FROM users WHERE user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $updatedRecord = $stmt->fetch(PDO::FETCH_ASSOC);
            $updatedRecord['user_img'] = base64_encode($updatedRecord['user_img']);
            echo json_encode($updatedRecord);

        } else {
            throw new Exception("Invalid file type.");
        }
    } else {
        throw new Exception("File not uploaded.");
    }
} catch(Exception $e) {
    $status_code = is_numeric($e->getCode()) && $e->getCode() > 0 ? $e->getCode() : 500;
    $message = !empty($e->getMessage()) ? $e->getMessage() : 'An error occurred';
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
?>
