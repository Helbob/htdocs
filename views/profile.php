<?php
$current_page = "Profile";
require_once __DIR__ . '/_components/_header.php';
require_once __DIR__ . '/../_.php';

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

<main class="max-w-2xl m-auto p-4">
  <section class="flex justify-start items-center gap-8 m-4">
    <?php foreach ($users as $user) : ?>
      <form onsubmit="updateUserImg(event);" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
        <label for="profilepicture">Profile Picture</label>  
        <input type="file" id="profilepicture" name="profilepicture">
        <button type="submit">Upload</button>
        <!-- <div class="text-4xl select-none h-[100px] w-[100px] overflow-hidden"><?= $user['user_img'] ?></div> -->
        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($user['user_img']); ?>" /> 
      </form>
      <div class="flex flex-col gap-2">
        <div class="flex gap-2">
          <form class="flex gap-2" onsubmit="updateUser(event); return false">
            <h2 id="profile-name" class="font-medium text-lg flex flex-row gap-2">
              <span class="relative flex">
                <span class=""><?= $user['user_first_name'] ?></span>
                <input onkeyup="updateInputWidth()" type="text" readonly maxlength="20" name="user_first_name" id="user_first_name" value="<?= $user['user_first_name'] ?>" class="absolute w-full left-0 p-2 border outline-none border-slate-200 focus:border-primary-300 transition-colors rounded-lg read-only:hidden" />
              </span>
              <span class="relative flex">
                <span class=""><?= $user['user_last_name'] ?></span>
                <input onkeyup="updateInputWidth()" type="text" readonly maxlength="20" name="user_last_name" id="user_last_name" value="<?= $user['user_last_name'] ?>" class="absolute w-full left-0 p-2 border outline-none border-slate-200 focus:border-primary-300 transition-colors rounded-lg read-only:hidden" />
              </span>
            </h2>
            <button id="profile_edit" onclick="allowEdit()" data-edit="false" class="hidden text-lg">✅</button>
          </form>
          <button id="profile_start_edit" onclick="allowEdit()" class="">✏️</button>
        </div>
        <div class="">
          <h3 class=""><?= $user['user_email'] ?></h3>
          <h4 class=""><?= $user['role_name'] ?></h4>
        </div>
      </div>
    <?php endforeach ?>
  </section>
  <h2 class="font-medium text-lg text-light-grey m-4">Preferences</h2>
  <section class="w-full bg-white shadow-sm p-4 rounded-md flex flex-col gap-4">
    <div class="flex justify-between">
      <p class="">Language</p>
      <button>English</button>
    </div>
    <div class="flex justify-between">
      <p class="">Dark mode</p>
      <label class="relative inline-flex items-center cursor-pointer">
          <input value="" type="checkbox" class="sr-only peer" >
          <div class="w-11 h-6 bg-light-grey peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-400"></div>
        </label>
    </div>
    <div class="flex justify-between">
      <p class="">Payment method</p>
      <button>Card</button>
    </div>
    <div class="flex justify-between">
      <p class="">Room</p>
      <button>E248</button>
    </div>
    <div class="flex justify-between">
      <p class="">School</p>
      <button>Guldbergsgade</button>
    </div>
    <form onsubmit="deleteUser();">
    <input class="hidden" type="text" name="user_id" value="<?= $user['user_id'] ?>">
    <button class="self-start text-red-500">Delete profile</button>
    </form>
  </section>
  <button class="btn-primary uppercase w-full mt-6">Logout</button>
  
</main>

<?php require_once __DIR__ . '/_components/_footer.php' ?>