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
        <div class="relative p-4 rounded-lg md:w-4/5 md:h-4/5 max-w-6xl max-md:h-full max-md:w-full bg-white overflow-auto">
            <form method="dialog" class="absolute right-[10px] top-[10px] w-fit ml-auto">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
            </form>
            <section class="flex max-md:flex-col max-md:items-center gap-4 h-full overflow-hidden">
                <article class="md:w-1/3 max-md:w-full flex flex-col gap-2 items-center h-fit">
                    <div class="w-full rounded-lg">
                        <p id="product_img_modal" class="text-5xl mx-auto text-center max-md:py-8"></p>
                    </div>
                    <div class="flex flex-col gap-2 max-md:w-full">
                    <h3 id="product_comment_name" class="font-medium text-base md:text-lg">PRODUCT NAME</h3>
                    <div class="flex justify-between items-center">
                        <div class="text-yellow bg-yellow bg-opacity-10 rounded-lg flex self-start place-items-center gap-1.5 px-1.5 py-0.5 h-min">
                            <img src="/img/rating.svg" alt="rating star" class="select-none">
                            <p id="product_comment_rating">PRODUCT Rating</p>
                        </div>
                            <h4 id="product_comment_price" class=" text-base md:text-lg font-medium drop-shadow-card">PRODUCT price</h4>
                    </div>
                    <p id="product_comment_category" class="w-full text-gray-400">PRODUCT category</p>
                    <p id="product_comment_description" >PRODUCT description</p>
                    </div>
                </article>
                <article class="md:w-2/3 max-md:w-full h-full overflow-auto grid grid-rows-[auto_1fr_auto]">
                    <p class="text-lg font-semibold ">User comments</p>
                        <article id="user_comments_list" class="mt-2 mb-2  overflow-auto"></article>
                    <div class="w-full border-solid border-2 rounded-lg p-2 h-fit mt-auto"> 
                        <?php foreach ($users as $user) : ?>
                            <div class="flex gap-2 items-center">
                                <img class="w-[35px] h-[35px] object-cover rounded-full object-center aspect-[1/1]" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($user['user_img']); ?>" /> 
                                <span class="text-base"><?= $user['user_first_name'] ." ". $user['user_last_name']?></span>
                            </div>
                        <?php endforeach ?>
                            <form method="POST" onsubmit="submitComment()">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['CSRF_token'];?>">
                                <input type="text" id="product_comment_id" name="product_comment_id" class="hidden">
                                <textarea type="text" name="comment" id="comment" class="w-full rounded-lg outline-none resize-none"></textarea>
                                <div class="flex align-middle">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input onclick="tgl_visability()" name="comments_public_status" type="checkbox" class="sr-only peer" >
                                    <div class="w-11 h-6 bg-light-grey peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[10px] after:start-[1.5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-400"></div>
                                    <span id="comment_tgl_public" class="ml-2 text-gray-400 text-sm">Public</span>
                                </label>
                                <button type="submit" class="bg-darker-blue text-white py-2 px-4 rounded ml-auto">Comment</button>
                                </div>
                            </form>
                        </div>
                    </article>
                </section>
        </div>
    </div>
</dialog>

