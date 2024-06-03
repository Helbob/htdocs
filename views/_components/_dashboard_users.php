<?php
  require_once __DIR__ . '/../../_.php';
  // require_once __DIR__.'../api/api-get-orders.php';

  // get users
  $db = _db();
  $q = $db->prepare('SELECT user_id, user_first_name, user_last_name, user_is_blocked, role_name FROM `users` INNER JOIN roles ON users.user_role_fk = roles.role_id LIMIT 0, :users_per_page');
  $q->bindValue(':users_per_page', _USERS_PER_PAGE, PDO::PARAM_INT);
  $q->execute();
  $users = $q->fetchAll();

  // get total user count in database to dynamically set max user pages
  $q = $db->prepare('SELECT * FROM users');
  $q->execute();
  $user_count = $q->rowCount();

  $max_page = ceil($user_count / _USERS_PER_PAGE);
?>

<?php if (_is_admin()) : ?>
  <!-- USERS - READY FOR DATABASE DATA -->
  <section class="w-full bg-white shadow-sm p-4 rounded-md">
    <div class="w-full flex justify-between items-center mb-2">
      <h2 class="text-lg text-gradient">All users</h2>
      <form data-url="<?= $frm_search_url ?>" id="frm_user_search" action="/search-results" method="GET" class="text-sm px-3 py-1 rounded-md bg-off-white flex items-center gap-2 w-content relative">
        <search class="flex flex-row items-center gap-2">
          <span class="leading-none">&#128269;</span>
          <input name="query" id="user_search_input" type="text" placeholder="Search users" class="bg-off-white p-1 w-full">
        </search>
      </form>
    </div>
    <?php require_once __DIR__ . '/_dashboard_popup.php'; ?>
    <header class="grid grid-cols-users-grid gap-2 mb-2 p-1">
      <p class="font-medium"></p>
      <p class="font-medium">Id</p>
      <p class="font-medium">Full name</p>
      <p class="font-medium">Role</p>
      <p class="font-medium text-right">Block user</p>
    </header>
    <ul id="all_users_container" class="flex flex-col gap-2">
      <?php foreach ($users as $user) : ?>
      <li>
        <button onclick="openPopup(<?= $user['user_id'] ?>)" class="bg-blue-100 hover:bg-blue-200 w-full grid grid-cols-users-grid gap-2 justify-between items-center p-1 rounded-md opacity-100 text-left">
          <span class="bg-white rounded-md w-8 h-8 aspect-square flex items-center justify-center">&#129399;</span>
          <p class="text-sm"><?= $user['user_id'] ?></p>
          <p class="max-md:ml-2 text-sm"><?= $user['user_first_name'], ' ', $user['user_last_name'] ?></p>
          <p class="text-sm"><?= $user['role_name'] ?></p>
          <div class="w-full grid justify-items-end px-2">
            <form id="user_toggle" class="flex">
              <label class="relative inline-flex items-center cursor-pointer">
                <input id="<?= $user['user_id'] ?>" name="user_id" value="<?= $user['user_id'] ?>" type="checkbox" class="sr-only peer user_block_toggle" <?= $user['user_is_blocked'] == 1 ? "checked" : "" ?>>
                <div class="w-11 h-6 bg-light-grey peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-400"></div>
              </label>
            </form>
          </div>
        </button>
      </li>
      <?php endforeach ?>
    </ul>

      <form method="POST" class="flex flex-row items-center justify-center gap-4 mt-4">
        <input type="button" value="Previous" name="previous_page" onclick="userPagination('decrement')" class="px-4 py-2 bg-primary-400 text-white rounded-lg disabled:bg-off-white disabled:text-light-grey hover:bg-primary-300 transition-colors cursor-pointer disabled:cursor-default" disabled />
        <div>
          <label>Page</label>
          <input type="text" name="user_page" value="1" min="1" max="<?= $max_page ?>" readonly class="w-6 text-center pointer-events-none">
        </div>
        <input type="button" value="Next" name="next_page" onclick="userPagination('increment')" class="px-4 py-2 bg-primary-400 text-white rounded-lg disabled:bg-off-white disabled:text-light-grey hover:bg-primary-300 transition-colors cursor-pointer disabled:cursor-default" />
      </form>
  </section>
<?php endif ?>