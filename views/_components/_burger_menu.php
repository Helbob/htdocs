<?php


?>


<section id="burger-menu" class="hidden fixed top-0 left-0 w-screen h-screen bg-black/10 z-[100] ">
  <div id="menu-slide" class="hidden duration-300 translate-x-full md:w-80 max-md:w-screen h-screen bg-off-white drop-shadow-card fixed items-center top-0 right-0 rounded-l-md">
    <div class="px-4 relative pt-20">
      <button class="absolute top-[32px] right-[24px]" onclick="slideOut()"><img class="block h-8 w-8 rotate-[-45deg]" src="/img/burger.svg" alt="Menu icon button">
      </button>
      <ul class="max-w-8xl mx-auto flex flex-col gap-4 text-lg">
        <li class="text-neutral-500 text-base"><?= isset($_SESSION['user']) ? $user_email : '' ?></li>
        <?php foreach ($pages as $page) : ?>
          <li class="<?= ($page['name'] == $current_page ? 'text-primary-400 font-semibold' : 'text-darker-blue') ?>"><a href="<?= $page['href'] ?>"><?= $page['name'] ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
</section>