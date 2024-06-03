<?php
  $current_page = "Dashboard";
  require_once __DIR__.'/_components/_header.php';
  require_once __DIR__.'/../_.php';

  _is_logged_in();

  // require_once __DIR__.'../api/api-get-orders.php';
  /* $db = _db();
  $q = $db->prepare('SELECT user_id, user_first_name, user_last_name, user_is_blocked, role_name FROM `users` INNER JOIN roles ON users.user_role_fk = roles.role_id');
  $q->execute();
  $users = $q->fetchAll(); */
  //$db = _db();
/*   $q = $db->prepare('SELECT order_id, product_name, product_img, user_first_name FROM `orders` INNER JOIN products ON orders.order_product_fk = products.product_id INNER JOIN users ON orders.order_user_fk = users.user_id');
  $q->execute();
  $orders = $q->fetchAll(); */

  $frm_search_url = 'api-search-user.php';
  $frm_search_url_orders = 'api-search-orders.php';


?>
<main class="max-w-7xl m-auto flex flex-col gap-4 items-center  md:p-8 max-md:p-2 text-off-black">
  <h1 class="text-slate-500 text-xl ">Dashboard</h1>

  <!-- ORDERS -->
  <?php require_once __DIR__.'/_components/_dashboard_orders.php'?>

  <!-- USERS -->
  <?php require_once __DIR__.'/_components/_dashboard_users.php'?>
  
</main>
<?php require_once __DIR__.'/_components/_footer.php' ?>