<?php
  $current_page = "Index";
  require_once __DIR__.'/_components/_header.php';

  // user is not logged in
  if (!$_SESSION['user']) {
    header('Location: /login');
    exit();
  }

  //TODO: user is logged in and is admin
  if ($_SESSION['user']['role'] == 3) {
    header('Location: /dashboard');
    exit();
  }

  // user is logged in
  header('Location: /homepage');
?> 