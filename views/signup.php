<?php
  $current_page = "Signup";
  require_once __DIR__.'/_components/_header.php';

  if (isset($_SESSION['user']) && $_SESSION['user']) {
    header('Location: /homepage');
    exit();
  }
?>

<main class="relative w-full mx-auto grid place-items-center h-screen">
  <div class="absolute bg-wave-pattern bg-no-repeat bg-stretch w-full h-1/2 bottom-0 -z-10"></div>
  <div class="flex shadow-md rounded-2xl md:shadow-xl">

    <form method="POST" onsubmit="validate(signUp)" class="flex flex-col items-center gap-y-4 bg-white px-8 py-12 lg:px-12 lg:py-16 w-fit sm:w-[32rem] rounded-2xl lg:rounded-none lg:rounded-tl-2xl lg:rounded-bl-2xl">
      <img src="img/logo.svg" alt="" class="mb-6">
      <div id="validation-error-wrapper" class="h-16 w-full">
        <p id="validation-error-message" onclick="classList.add('hidden')" class="py-2 px-4 text-center text-error text-sm border border-error bg-error/10 rounded-lg hover:opacity-75 transition-opacity cursor-pointer hidden">ERROR: 418 I'm a teapot</p>
      </div>

      <div class="relative w-full">
        <input data-validate="text" type="text" name="user_first_name" id="user-first-name" class="floating-input peer" placeholder="" onfocus="classList.remove('validate-error')" data-min="<?= USER_FIRST_NAME_MIN ?>" data-max="<?= USER_FIRST_NAME_MAX ?>" />
        <label for="user-first-name" class="floating-label before:content-['✉️_']">First name</label>
      </div>
      <div class="relative w-full">
        <input data-validate="text" type="text" name="user_last_name" id="user-last-name" class="floating-input peer" placeholder="" onfocus="classList.remove('validate-error')" data-min="<?= USER_LAST_NAME_MIN ?>" data-max="<?= USER_LAST_NAME_MAX ?>" />
        <label for="user-last-name" class="floating-label before:content-['✉️_']">Last name</label>
      </div>
      <div class="relative w-full">
        <input data-validate="email" type="email" name="user_email" id="user-email" class="floating-input peer" placeholder="" onfocus="classList.remove('validate-error')" onblur="isEmailAvailable()" />
        <label for="user-email" class="floating-label before:content-['✉️_']">E-mail</label>
      </div>
      <div class="relative w-full">
        <input data-validate="text" type="phone" name="user_phonenumber" id="user-phonenumber" class="floating-input peer" placeholder="" onfocus="classList.remove('validate-error')" data-min="<?= USER_PHONENUMBER_MIN ?>" data-max="<?= USER_PHONENUMBER_MAX ?>" />
        <label for="user-phonenumber" class="floating-label before:content-['📞_']">Phone number</label>
      </div>
      <div class="relative w-full">
        <input data-validate="text" type="password" name="user_password" id="user-password" class="floating-input peer" placeholder="" onfocus="classList.remove('validate-error')" data-min="<?= USER_PASSWORD_MIN ?>" data-max="<?= USER_PASSWORD_MAX ?>" />
        <label for="user-password" class="floating-label before:content-['🔑_']">Password</label>
      </div>
      <div class="relative w-full">
        <input data-validate="match" data-match-name="user_password" type="password" name="user_confirm_password" id="user-confirm-password" class="floating-input peer" placeholder="" onfocus="classList.remove('validate-error')" />
        <label for="user-confirm-password" class="floating-label before:content-['🔑_']">Confirm password</label>
      </div>

      <button class="btn-primary uppercase w-full">SIGN-UP</button>
      <p class="mt-2">Already have an account? <a href="/" class="link-gradient">Login here!</a></p>
    </form>

    <div class="hidden lg:block relative text-white bg-primary-500 rounded-br-2xl rounded-tr-2xl max-w-lg bg-bottom bg-no-repeat bg-contain px-12 py-16 text-center">
      <h1 class="text-lg font-medium before:content-['🎉_'] after:content-['_🎉']">Welcome to Santia-Go</h1> 
      <p class="mt-2">Savor the flavor at your door! Delivering delight in every bite, because good food should go where you go!</p>
      <img src="img/front-page-add.svg" alt="" class="absolute bottom-0 right-0 left-0 px-14">
    </div>

  </div>
</main>