<?php

  require_once __DIR__.'/../../_.php';

  $pages = [
    [ "name" => "Homepage",     "href" => "/homepage" ],
    [ "name" => "Profile",      "href" => "/profile" ],
    [ "name" => "Dashboard",    "href" => "/dashboard" ],
    [ "name" => "Logout",       "href" => "/logout" ],
  ];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Santia-Go | <?=$current_page?></title>
  <link rel="stylesheet" href="/app.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <script src="/app.js" defer></script>
  <script src="/validator.js" defer></script>
  <script src="/comments.js" defer></script>
</head>
<body class="min-h-screen font-poppins bg-off-white overflow-x-hidden">

<?php
/* 
  $db = _db();
  $q = $db->prepare('SELECT * FROM products');
  $q->execute();
  $products = $q->fetchAll();
  echo json_encode($products);  */

/*   if( ! $_SESSION ){
  header('Location: /login.php');
  exit();
} */

  if (isset($_SESSION['user'])) {
    $user_email = $_SESSION['user']['user_email'];
  }
?>

<!-- <nav class="bg-slate-200 p-2">
  <ul class="max-w-8xl mx-auto flex flex-wrap gap-4">
    <?php foreach($pages as $page): ?>
    <li class="<?= ($page['name'] == $current_page ? 'text-red-500': 'text-blue-500') ?>"><a href="<?= $page['href'] ?>"><?= $page['name'] ?></a></li>
    <?php endforeach ?>
    <li class="ml-auto"><?= $user_email ?></li>
  </ul>
</nav> -->

<?php if(isset($_SESSION['user'])): ?>
<header id="nav-menu" class="w-full p-4 sticky top-0 z-50 transition duration-100 ease-in-out">
  <nav class="max-w-8xl mx-auto flex justify-between items-center py-2">
    <a href="/" class="p-2">
      <img class="block h-8" src="/img/logo.svg" alt="Logo">
    </a>
    <button onclick="slideOut()" class="p-2">
      <img class="block h-8 w-8" src="/img/burger.svg" alt="Menu icon button">
    </button>
  </nav>
</header>
<?php endif?>

<?php
require_once __DIR__.'/_burger_menu.php';
?>

