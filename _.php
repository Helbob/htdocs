<?php

  ini_set('display_errors', 1); // Error for mac

  session_start(); // start session on all pages

  /*
  *  
  *  DATABASE
  *  
  */

  function _db() {
    try {
      $user_name = "root";
      $user_password = "root"; // $user_password = "root"; MAC
      //$db_connection = 'sqlite:'.__DIR__.'/db/database.sqlite';
	    $db_connection = "mysql:host=localhost; dbname=food_delivery; charset=utf8mb4";
    
      // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ   [{}]   $user->id
      $db_options = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // [['id'=>1, 'name'=>'A'],[]]  $user['id']
      );
      return new PDO( $db_connection, $user_name, $user_password, $db_options );
    } catch(PDOException $e) {
      throw new Exception($e, 500);
      exit();
    }	
  }

  /*
  *  
  *  VALIDATION
  *  
  */

  // FIRST NAME
  define('USER_FIRST_NAME_MIN', 2);
  define('USER_FIRST_NAME_MAX', 20);
  function _validate_user_first_name($client_error_message = 'oops') {

    if (!isset($_POST['user_first_name'])) {
      throw new Exception($client_error_message, 400);
    }
    $_POST['user_first_name'] = trim($_POST['user_first_name']);

    if (strlen($_POST['user_first_name']) < USER_FIRST_NAME_MIN) {
      throw new Exception($client_error_message, 400);
    }

    if (strlen($_POST['user_first_name']) > USER_FIRST_NAME_MAX) {
      throw new Exception($client_error_message, 400);
    }
  }

  // LAST NAME
  define('USER_LAST_NAME_MIN', 2);
  define('USER_LAST_NAME_MAX', 20);
  function _validate_user_last_name($client_error_message = 'oops') {

    if (!isset($_POST['user_last_name'])) { 
      throw new Exception($client_error_message, 400); 
    }
    $_POST['user_last_name'] = trim($_POST['user_last_name']);

    if (strlen($_POST['user_last_name']) < USER_LAST_NAME_MIN ) {
      throw new Exception($client_error_message, 400);
    }

    if (strlen($_POST['user_last_name']) > USER_LAST_NAME_MAX) {
      throw new Exception($client_error_message, 400);
    }
  }

  // EMAIL
  function _validate_user_email($client_error_message = 'oops') {

    if (!isset($_POST['user_email'])) { 
      throw new Exception($client_error_message, 400); 
    }
    $_POST['user_email'] = trim($_POST['user_email']); 
    if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
      throw new Exception($client_error_message, 400); 
    }
  }

  // PASSWORD
  define('USER_PASSWORD_MIN', 6);
  define('USER_PASSWORD_MAX', 50);
  function _validate_user_password($client_error_message = 'oops') {

    if (!isset($_POST['user_password'])) { 
      throw new Exception($client_error_message, 400); 
    }
    $_POST['user_password'] = trim($_POST['user_password']);

    if (strlen($_POST['user_password']) < USER_PASSWORD_MIN) {
      throw new Exception($client_error_message, 400);
    }

    if (strlen($_POST['user_password']) > USER_PASSWORD_MAX) {
      throw new Exception($client_error_message, 400);
    }
  }

  // CONFIRM PASSWORD
  function _validate_user_confirm_password($client_error_message = 'oops') {
    
    if (!isset($_POST['user_confirm_password'])) { 
      throw new Exception($client_error_message, 400); 
    }
    $_POST['user_confirm_password'] = trim($_POST['user_confirm_password']);
    if ($_POST['user_password'] != $_POST['user_confirm_password']) {
      throw new Exception($client_error_message, 400); 
    }
  }

  // PHONENUMBER
  define('USER_PHONENUMBER_MIN', 3);
  define('USER_PHONENUMBER_MAX', 20);
  function _validate_user_phonenumber($client_error_message = 'oops') {

    $error = 'user_phonenumber min '.USER_PHONENUMBER_MIN.' characters, max '.USER_PHONENUMBER_MAX.' characters';
    
    if (!isset($_POST['user_phonenumber'])) { 
      throw new Exception($client_error_message, 400); 
    }

    $_POST['user_phonenumber'] = trim($_POST['user_phonenumber']);

    if (strlen($_POST['user_phonenumber']) < USER_PHONENUMBER_MIN ) {
      throw new Exception($client_error_message, 400);
    }

    if (strlen($_POST['user_phonenumber']) > USER_PHONENUMBER_MAX) {
      throw new Exception($client_error_message, 400);
    }
  }

  /*
  *  
  *  FUNCTIONS
  *  
  */

  function _is_admin() {
    return (! isset($_SESSION['user']) || $_SESSION['user']['user_role_fk'] != '3') ? false : true;
  }

  function _is_partner_or_admin() {
    return (! isset($_SESSION['user']) || !in_array($_SESSION['user']['user_role_fk'], ['2', '3'])) ? false : true;
  } 

  function _is_logged_in() {
    if (!isset($_SESSION['user'])) {
      header('Location: /login');
      exit();
    }
  }

  /*
  *  
  * VARIABLES
  *  
  */

  // users to fetch from the database per page
  define('_USERS_PER_PAGE', 5);

?>