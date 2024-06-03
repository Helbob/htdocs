<?php

_is_logged_in();

$user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : null;

if ($user_id) {
  $db = _db();
  $q = $db->prepare('SELECT user_id, user_first_name, user_last_name, user_email, user_is_blocked, user_img, role_name FROM `users` INNER JOIN roles ON users.user_role_fk = roles.role_id WHERE user_id = :user_id');
  $q->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $q->execute();
  $users = $q->fetchAll();
} else {
  $users = array();
}


?>
<dialog  class="z-50 fixed top-0 left-0 w-screen h-screen bg-transparent">
    <div id="product_modal" class="w-full h-full flex justify-center items-center">
        <div class="p-4 rounded-lg w-2/3 h-4/6 bg-white">
            <form method="dialog" class="w-fit ml-auto">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
            </form>
            <section class="flex">
                <article class="w-1/2 flex items-center">
                    <p id="product_img_modal" class="text-5xl ml-12"></p>
                </article>
                <article class="w-1/2">
                    <p>User comments</p>
                    <article id="user_comments_list" class="mt-2 mb-2"></article>
                    <div class="w-full border-solid border-2 rounded-lg p-1">    
                        <?php foreach ($users as $user) : ?>
                            <div class="flex gap-2 items-center">
                                <div class="text-lg select-none"><?= $user['user_img'] ?></div>
                                <span class="text-base"><?= $user['user_first_name'] ." ". $user['user_last_name']?></span>
                            </div>
                            <?php endforeach ?>
                            <textarea name="comment" id="" method="POST" class="w-full rounded-lg outline-none resize-none"></textarea>
                            <button class="bg-darker-blue text-white py-1 px-3 rounded ml-auto">Comment</button>
                        </div>
                    </article>
                </section>
                <span id="product_comment_id"></span>
        </div>
    </div>
</dialog>

