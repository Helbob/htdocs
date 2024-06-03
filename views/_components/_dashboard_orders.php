<?php
  require_once __DIR__.'/../../_.php';
  // require_once __DIR__.'../api/api-get-orders.php';
  $db = _db();
  $q = $db->prepare('SELECT order_id, product_name, product_img, user_first_name, order_is_delivered FROM `orders` INNER JOIN products ON orders.order_product_fk = products.product_id INNER JOIN users ON orders.order_user_fk = users.user_id');
  $q->execute();
  $orders = $q->fetchAll();

?>
   <!-- ORDER - READY FOR DATABASE DATA -->
  <section id="all_orders_container" class="w-full bg-white shadow-sm p-4 rounded-md flex flex-col gap-2">
    <div class="w-full flex justify-between items-center mb-2">
      <h2 class="text-lg text-gradient">All orders</h2>
      <form data-url="<?= $frm_search_url_orders ?>" id="frm_order_search" action="/search-results" method="GET" class="text-sm px-3 py-1 rounded-md bg-off-white flex items-center gap-2 w-content relative">
        <search class="flex flex-row items-center gap-2">
          <span class="leading-none">&#128269;</span>
          <input name="query" type="text" placeholder="Search orders" class="bg-off-white p-1" id="orders_search_input">
        </search>
      </form>

     
    </div>
    <?php foreach( $orders as $order ): ?>
    <article  class="bg-blue-100 w-full grid md:grid-cols-orders-grid max-md:grid-cols-orders-grid-mobile max-md:grid-rows-2 justify-between items-center p-1 rounded-md opacity-100">
      <span class="col-start-1  bg-white rounded-md w-8 h-8 aspect-square flex items-center justify-center max-md:row-span-2"><?= $order['product_img']?></span>
      <p class="max-md:ml-2 max-md:col-start-2 text-sm"><?= $order['order_id']?></p>
      <p class="max-md:ml-2 md:text-center max-md:row-start-2 max-md:col-start-2  text-sm"><?= $order['product_name']?></p>
      <p class="text-center max-md:col-start-3 max-md:row-start-1 max-md:row-span-2 text-sm"><?= $order['user_first_name']?></p>
      <?php if(_is_partner_or_admin()) : ?>
      <p class="text-center max-md:col-start-4 max-md:row-start-1 max-md:row-span-2 text-sm"><?php if ($order['order_is_delivered'] == 0): echo "Pending"; else: echo "Delived"; endif?></p>
      <?php endif ?>
    </article>
    <?php endforeach ?> 
  </section>