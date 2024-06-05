async function signUp() {
  event.preventDefault();

  const signUpForm = event.target;
  const errorMessage = document.querySelector("#validation-error-message");
  //console.log(signUpForm);

  const response = await fetch("api-signup", {
    method: "POST",
    body: new FormData(signUpForm),
  });

  const data = await response.json();
  errorMessage.classList.add("hidden");
  errorMessage.textContent = "";

  if (!response.ok) {
    errorMessage.classList.remove("hidden");
    errorMessage.textContent = data.info;
    //console.error(data);
    return;
  }

  window.location.href = "homepage";
}

async function login() {
  event.preventDefault();

  const loginForm = event.target;
  const errorMessage = document.querySelector("#validation-error-message");
  //console.log(loginForm);

  const response = await fetch("api-login", {
    method: "POST",
    body: new FormData(loginForm),
  });

  const data = await response.json();
  errorMessage.classList.add("hidden");
  errorMessage.textContent = "";

  if (!response.ok) {
    errorMessage.classList.remove("hidden");
    errorMessage.textContent = data.info;
    //console.error(data);
    return;
  }

  window.location.href = "homepage";
}

async function isEmailAvailable() {
  const emailInput = event.target;
  const emailValue = event.target.value;
  const errorMessage = document.querySelector("#validation-error-message");
  //console.log(email);

  //console.log(submitEmail)

  const response = await fetch("api-email-available", {
    method: "POST",
    body: JSON.stringify({ user_email: emailValue }),
  });

  const data = await response.json();

  if (!response.ok) {
    errorMessage.classList.remove("hidden");
    errorMessage.textContent = data.info;

    emailInput.classList.add("validate-error");
    //console.error(data);
    return;
  }
}

async function filterProducts() {
  const category = event.target.value;
  console.log(category);
}

async function userBlockToggle(user_id, user_is_blocked) {
  if (user_is_blocked == 0) {
  }
}

// ---------- DASHBOARD JS ----------

document
  .querySelector("#user_search_input")
  ?.addEventListener("input", search_users);
document
  .querySelector("#orders_search_input")
  ?.addEventListener("input", search_orders);

// ONLY FOR PHP, ONCE YOU SEARCH USE OTHER IN "displayUsers"
const user_block_toggles = document.querySelectorAll(".user_block_toggle");
user_block_toggles.forEach((toggle) => {
  toggle.addEventListener("click", block_user);
});

// ORDERS SEARCH
let timer_search_orders = "";
function search_orders() {
  clearTimeout(timer_search_orders);
  timer_search_orders = setTimeout(async function () {
    const frm = document.querySelector("#frm_order_search");
    console.log(new FormData(frm));
    const url = frm.getAttribute("data-url");
    const response = await fetch(`/api/${url}`, {
      method: "POST",
      body: new FormData(frm),
    });
    const data = await response.json();
    console.log(data);
    search_results_orders(data);
  }, 100);
}

// Show all search
function search_results_orders(data) {
  const orders_container = document.getElementById("all_orders_container");
  const empty_order_containt = document.querySelectorAll(
    "#all_orders_container article"
  );
  empty_order_containt.forEach((e) => {
    e.remove();
  });
  data.forEach((order) => {
    const article = document.createElement("article");
    article.className =
      "bg-blue-100 w-full grid md:grid-cols-orders-grid max-md:grid-cols-orders-grid-mobile max-md:grid-rows-2 justify-between items-center p-1 rounded-md";
    const htmlcontent = `<span class="col-start-1  bg-white rounded-md w-8 h-8 aspect-square flex items-center justify-center max-md:row-span-2">${
      order.product_img
    }</span>
        <p class="max-md:ml-2 max-md:col-start-2 text-sm">${order.order_id}</p>
        <p class="max-md:ml-2 md:text-center max-md:row-start-2 max-md:col-start-2  text-sm">${
          order.product_name
        }</p>
        <p class="text-center max-md:col-start-3 max-md:row-start-1 max-md:row-span-2 text-sm"?>${
          order.user_first_name
        }</p> 
        <p class="text-center max-md:col-start-4 max-md:row-start-1 max-md:row-span-2 text-sm">${
          order.order_is_delivered === 0 ? "Pending" : "Delivered"
        }</p>
        <div class="w-full grid justify-items-end px-2">
        </div>`;
    article.innerHTML = htmlcontent;

    orders_container.appendChild(article);
  });
}

// USERS SEARCH & BLOCK
let timer_search_users = "";
function search_users() {
  clearTimeout(timer_search_users);
  timer_search_users = setTimeout(async function () {
    const frm = document.querySelector("#frm_user_search");
    const url = frm.getAttribute("data-url");
    const response = await fetch(`/api/${url}`, {
      method: "POST",
      body: new FormData(frm),
    });
    const data = await response.json();
    //console.log(data)

    if (frm.query.value.trim().length > 0) {
      document
        .querySelector("[name='next_page']")
        .setAttribute("disabled", "disabled");
    } else {
      document.querySelector("[name='next_page']").removeAttribute("disabled");
    }

    displayUsers(data);
  }, 500);
}

// Show all search
function displayUsers(data) {
  const users_container = document.getElementById("all_users_container");
  const empty_user_container = document.querySelectorAll(
    "#all_users_container li"
  );
  empty_user_container.forEach((e) => {
    e.remove();

    /*  setTimeout(() => {
      e.classList.add("opacity-0")
    }, 10)
    setTimeout(() => {
    }, 190) */
  });
  data.forEach((user) => {
    const li = document.createElement("li");
    const btn = document.createElement("button");
    btn.className =
      "bg-blue-100 hover:bg-blue-200 w-full grid grid-cols-users-grid gap-2 justify-between items-center p-1 rounded-md opacity-100 text-left";
    //btn.setAttribute("onclick",`openPopup(${user.user_id})`);
    const htmlcontent = `<span class=" bg-white rounded-md w-8 h-8 aspect-square flex items-center justify-center">&#129399;</span>
        <p class="text-sm">${user.user_id}</p>
        <p class="text-sm">${user.user_first_name} ${user.user_last_name}</p>
        <p class="text-sm">${user.role_name}</p>
        <div class="w-full grid justify-items-end px-2">
        <form action="" id="user_toggle" class="flex">
        <label class="relative inline-flex items-center cursor-pointer">
        <input id="${user.user_id}" type="checkbox" name="user_id" value="${
      user.user_id
    }" class="sr-only peer user_block_toggle" ${
      user.user_is_blocked === 1 && "checked"
    }>
        <div class="w-11 h-6 bg-light-grey peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-400"></div>
        </label>
        </form>
        </div>`;
    btn.innerHTML = htmlcontent;
    li.appendChild(btn);
    users_container.appendChild(li);
    btn.addEventListener("click", () => openPopup(user.user_id));
  });
  const user_block_toggles = document.querySelectorAll(".user_block_toggle");
  user_block_toggles.forEach((toggle) => {
    toggle.addEventListener("click", block_user);
  });
}

async function userPagination(action) {
  event.preventDefault();

  const paginationForm = event.target.form;
  const previousButton = event.target.form.querySelector(
    "[name='previous_page']"
  );
  const nextButton = event.target.form.querySelector("[name='next_page']");

  const userPage = event.target.form.user_page;
  const userPageMin = event.target.form.user_page.min;
  const userPageMax = event.target.form.user_page.max;

  switch (action) {
    case "increment":
      userPage.value++;
      break;

    case "decrement":
      userPage.value--;
      break;
  }
  //console.log(userPage.value);

  if (userPage.value > userPageMin) {
    previousButton.removeAttribute("disabled");
  } else {
    previousButton.setAttribute("disabled", "disabled");
  }

  if (userPage.value < userPageMax) {
    nextButton.removeAttribute("disabled");
  } else {
    nextButton.setAttribute("disabled", "disabled");
  }

  const response = await fetch("api-users-pagination", {
    method: "POST",
    body: new FormData(paginationForm),
  });
  const data = await response.json();
  //console.log(data);

  displayUsers(data);
}

async function block_user() {
  const userId = Number(event.target.value);
  const url = "api-block-user-toggle.php";
  const response = await fetch(`/api/${url}`, {
    method: "POST",
    body: JSON.stringify({ user_id: userId }),
  });
  const data = await response.json();
}

// POPUP

async function openPopup(id) {
  console.log(event.target);
  if (event.target.closest("#user_toggle")) {
    console.log("Form element clicked, not proceeding with the popup.");
    return;
  }

  const url = "api-get-user.php";
  const response = await fetch(`/api/${url}`, {
    // headers: {
    //   "Content-Type": "application/json",
    // },
    method: "POST",
    body: JSON.stringify({ user_id: id }),
  });
  const data = await response.json();
  printOutUserInfo(data);
}
function printOutUserInfo(data) {
  const user = data[0];
  const popupContainer = document.querySelector("#popup_container");
  const popupCentent = document.querySelector("#popup_content");
  popupContainer.classList.remove("hidden");
  console.log(user);
  popupCentent.innerHTML = `
  <button onclick="closePopup()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 absolute right-4 top-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button> 
  <h2><span class="text-light-grey text-sm">Name:</span> ${
    user.user_first_name
  } ${user.user_last_name}</h2>
    <p><span class="text-light-grey text-sm">E-mail:</span> ${
      user.user_email
    }</p>
    <p><span class="text-light-grey text-sm">Phone number:</span> ${
      user.user_phonenumber
    }</p>
    <p><span class="text-light-grey text-sm">Role:</span> ${user.role_name}</p>
    <p><span class="text-light-grey text-sm">User ID:</span> ${user.user_id}</p>
    <p><span class="text-light-grey text-sm">Status:</span> ${
      user.user_is_blocked === 1 ? "Blocked" : "Active"
    }</p>
    <p><span class="text-light-grey text-sm">Created at:</span> ${new Date(
      parseInt(user.user_created_at) * 1000
    ).toUTCString()}</p>
    <p><span class="text-light-grey text-sm">Updated at:</span> ${
      user.user_updated_at == 0
        ? "n/a"
        : new Date(parseInt(user.user_updated_at) * 1000).toUTCString()
    }</p>
    <p><span class="text-light-grey text-sm">Deleted at:</span> ${
      user.user_deleted_at == 0
        ? "n/a"
        : new Date(parseInt(user.user_deleted_at) * 1000).toUTCString()
    }</p>
  `;
}

function closePopup() {
  document.querySelector("#popup_container").classList.add("hidden");
  const popupCentent = document.querySelector("#popup_content");
  popupCentent.innerHTML = `<button onclick="closePopup()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 absolute right-4 top-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button> `;
}

// PROFILE

// SOFT DELETE PROFILE
async function deleteUser() {
  event.preventDefault();
  const deleteFrm = event.target;
  //const url = "api-delete-user.php";
  const response = await fetch(`/api/api-delete-user.php`, {
    method: "POST",
    body: new FormData(deleteFrm),
  });
  // const data = await response.json();
  console.log(response);
  window.location.href = "login";
}

// ---------- HOMEPAGE JS ----------

// toggle like button on products
function toggleLike(key) {
  // get all hearts both empty and full as an array
  const emptyHeart = document.querySelectorAll(".empty-heart");
  const fullHeart = document.querySelectorAll(".full-heart");
  // use key (the index of the product array) to select the correct heart to toggle
  emptyHeart[key].classList.toggle("hidden");
  fullHeart[key].classList.toggle("hidden");
}

// Scroll apply background to navbar
const navbar = document.querySelector("#nav-menu");
window.addEventListener("scroll", () => {
  if (window.scrollY > 10) {
    navbar.classList.add("bg-white", "drop-shadow-card");
  } else {
    navbar.classList.remove("bg-white", "drop-shadow-card");
  }
});

// ---------- HEADER JS ----------

//Burger Menu silde out/in
document
  .querySelector("#burger-menu")
  .addEventListener("click", () => slideOut(event));
function slideOut(event) {
  if (event) {
    if (event.target.closest("#menu-slide")) {
      console.log("menu element clicked, not proceeding with the animation.");
      return;
    }
  }
  const menu = document.querySelector("#burger-menu");
  const menuSlide = document.querySelector("#menu-slide");

  if (menu.classList.contains("hidden")) {
    menuSlide.classList.remove("hidden");
    menu.classList.remove("hidden");
    setTimeout(() => {
      menuSlide.classList.remove("translate-x-full");
      menuSlide.classList.add("translate-x-0");
    }, 10);
  } else {
    menuSlide.classList.remove("translate-x-0");
    menuSlide.classList.add("translate-x-full");
    setTimeout(() => {
      menuSlide.classList.add("hidden");
      menu.classList.add("hidden");
    }, 300);
  }
}

// ---------- PROFILE JS ----------

function allowEdit() {
  const btn = document.querySelector("#profile_edit");
  const btnEdit = document.querySelector("#profile_start_edit");
  const user_first_name = document.querySelector("#user_first_name");
  const user_last_name = document.querySelector("#user_last_name");

  if (btn.dataset.edit === "false") {
    btn.dataset.edit = "true";
    user_first_name.removeAttribute("readonly");
    user_last_name.removeAttribute("readonly");
    btn.classList.remove("hidden");
    btnEdit.classList.add("hidden");
    user_first_name.previousElementSibling.classList.add("p-2.5");
    user_last_name.previousElementSibling.classList.add("p-2.5");
  } else {
    user_first_name.setAttribute("readonly", "");
    user_last_name.setAttribute("readonly", "");
    btn.dataset.edit = "false";
    btn.classList.add("hidden");
    btnEdit.classList.remove("hidden");
    user_first_name.previousElementSibling.classList.remove("p-2.5");
    user_last_name.previousElementSibling.classList.remove("p-2.5");
  }

  const userUpdate = {
    user_first_name: user_first_name.textContent.replace(/\s/g, ""),
    user_last_name: user_last_name.textContent.replace(/\s/g, ""),
  };
  //updateUser(userUpdate)
}

async function updateUser(event, userUpdate) {
  event.preventDefault();
  console.log(event.target);
  //console.log(userUpdate);
  const url = "api-update-user.php";
  const response = await fetch(`/api/${url}`, {
    // headers: {
    //   "Content-Type": "application/json",
    // },
    method: "POST",
    /* body: JSON.stringify(userUpdate), */
    body: new FormData(event.target),
  });
  const data = await response.json();
  console.log(data);
}

async function updateUserImg(event) {
  event.preventDefault();
  console.log(event.target);
  const imgForm = event.target;
  const url = "api/api-upload-img.php";
  const response = await fetch(url, {
    method: "POST",
    body: new FormData(imgForm),
  });
  const data = await response.json();
  console.log(data);

  if (data.user_img) {
    document.getElementById(
      "profile_img"
    ).src = `data:image/jpg;charset=utf8;base64,${data.user_img}`;
    console.log(data);
  } else {
    console.log("no image");
  }
}

function updateInputWidth() {
  const spanElement = event.target.previousElementSibling;
  const inputField = event.target;

  spanElement.textContent = inputField.value;
}
