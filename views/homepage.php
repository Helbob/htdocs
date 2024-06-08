<?php
  $current_page = "Homepage";

  require_once __DIR__ . '/_components/_header.php';
  require_once __DIR__ . '/../_.php';
  
  $db = _db();

  // get categories
  $q = $db->prepare('SELECT * FROM categories');
  $q->execute();
  $categories = $q->fetchAll();
  //echo json_encode($categories);

  // get all products
  $q = $db->prepare('SELECT * FROM products INNER JOIN categories ON products.product_category_fk = categories.category_id');
  $q->execute();
  $products = $q->fetchAll();
  //echo json_encode($products);
  //echo $_SESSION['CSRF_token'];

?>


<main class="max-w-7xl m-auto p-4">
  <section class="hidden md:flex justify-between items-center bg-light-blue px-32 rounded-lg">
    <div>
      <h1 class="text-xl font-bold text-darker-blue">Quick Bites, Big Delights: Your Culinary Adventure Starts Here</h1>
      <h2 class="text-lg font-medium text-darker-blue">Deliciously Easy - Order, Relax, Enjoy!</h2>
    </div>
    <div class="before:content-['🥗'] before:text-7xl" role="img"></div>
  </section>

  <section>
    <ul class="flex overflow-y-auto gap-2 md:gap-4 pt-0 md:pt-6 pb-8 text-base font-normal">
      <li>
        <input class="appearance-none peer absolute" type="radio" name="category" id="all-category" value="*" onchange="filterProducts()" checked />
        <label class="cursor-pointer bg-secondary drop-shadow-card peer-checked:bg-gradient-primary peer-checked:text-white flex rounded-lg gap-2 px-4 py-2" for="all-category">All</label>
      </li>
      <?php foreach ($categories as $category) : ?>
        <li>
          <input class="appearance-none peer absolute" type="radio" name="category" id="<?= $category['category_name'] ?>" value="<?= $category['category_name'] ?>" onchange="filterProducts()" />
          <label class="cursor-pointer bg-secondary drop-shadow-card peer-checked:bg-gradient-primary peer-checked:text-white flex rounded-lg gap-2 px-4 py-2" for="<?= $category['category_name'] ?>"><span class="select-none"><?= $category['category_img'] ?></span> <?= ucfirst($category['category_name']) ?></label>
        </li>
      <?php endforeach ?>
    </ul>
  </section>
  <section class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
    <?php require_once __DIR__ . '/_components/_product_popup.php'; ?>
    <?php foreach ($products as $key=>$product) : ?>
      <article onclick='openModal(event, <?= json_encode($product) ?>)'  class="homepage_products flex flex-col bg-white rounded-2xl p-2.5 md:p-5 drop-shadow-card"> <!-- OnClick til en modal -->
        <div class="text-4xl flex items-center rounded-lg aspect-square" style="background-color: <?= $product['category_color'] ?>;">
          <div class="mx-auto select-none"><?= $product['product_img'] ?></div>
          <button id="toggleLike" onclick="toggleLike(<?=$key?>)" class="absolute top-5 md:top-10 right-5 md:right-10 h-8 md:h-10 w-8 md:w-10 bg-rgba-grey opacity-30 grid place-items-center rounded-lg">
            <img class="empty-heart" src="/img/empty-heart.svg">
            <img class="full-heart hidden" src="/img/full-heart.svg">
          </button>
        </div>
        <h4 class="font-medium text-base md:text-lg"><?= $product['product_name'] ?></h4>
        <p class="font-medium text-base text-light-grey"><?= $product['category_name'] ?></p>
        <div class="flex justify-between">
          <div class="text-yellow bg-yellow bg-opacity-10 rounded-lg flex self-end place-items-center gap-1.5 px-1.5 py-0.5 h-min">
            <img src="/img/rating.svg" alt="rating star" class="select-none">
            <p><?= $product['product_rating'] ?></p>
          </div>
          <div class="text-base md:text-lg font-medium drop-shadow-card">
            <p><?= $product['product_price'] ?><span class="text-base"> kr</span></p>
          </div>
        </div>
      </article>
    <?php endforeach ?>
  </section>
</main>




<?php require_once __DIR__ . '/_components/_footer.php' ?>