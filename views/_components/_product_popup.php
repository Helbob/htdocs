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
        <div class="p-4 rounded-lg w-2/3 h-4/6 bg-white overflow-auto">
            <form method="dialog" class="w-fit ml-auto">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
            </form>
            <section class="flex max-md:flex-col max-md:items-center gap-4 h-[95%] overflow-hidden">
                <article class="w-1/3 flex flex-col items-center h-fit">
                    <div class="w-full rounded-lg">
                        <p id="product_img_modal" class="text-5xl mx-auto text-center"></p>
                    </div>
                    <h3 id="product_comment_name" class="font-medium text-base md:text-lg">PRODUCT NAME</h3>
                    <div class="flex justify-between">
                        <div class="text-yellow bg-yellow bg-opacity-10 rounded-lg flex self-start place-items-center gap-1.5 px-1.5 py-0.5 h-min">
                            <img src="/img/rating.svg" alt="rating star" class="select-none">
                            <p id="product_comment_rating">PRODUCT Rating</p>
                        </div>
                        <div class="text-base md:text-lg font-medium drop-shadow-card">
                            <h4 id="product_comment_price">PRODUCT price</h4>
                        </div>
                    </div>
                    <p id="product_comment_category">PRODUCT category</p>
                    <p id="product_comment_description">PRODUCT description</p>

                </article>
                <article class="w-2/3 h-full overflow-auto grid">
                    <p class="text-lg font-semibold">User comments</p>
                        <article id="user_comments_list" class="mt-2 mb-2  overflow-auto"></article>
                    <div class="w-full border-solid border-2 rounded-lg p-2"> 
                        <?php foreach ($users as $user) : ?>
                            <div class="flex gap-2 items-center">
                                <img class="w-[35px] h-[35px] object-cover rounded-full" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($user['user_img']); ?>" /> 
                                <span class="text-base"><?= $user['user_first_name'] ." ". $user['user_last_name']?></span>
                            </div>
                            <?php endforeach ?>
                            <form method="POST" onsubmit="submitComment()">
                                <input type="text" id="product_comment_id" name="product_comment_id" class="hidden">
                                <textarea type="text" name="comment" id="comment" class="w-full rounded-lg outline-none resize-none"></textarea>
                                <div class="flex">
                                    <button type="submit" class="bg-darker-blue text-white py-2 px-4 rounded ml-auto">Comment</button>
                                </div>
                            </form>
                        </div>
                    </article>
                </section>
        </div>
    </div>
</dialog>

