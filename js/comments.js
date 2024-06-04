const dialog = document.querySelector("dialog");
const showButton = document.querySelector("dialog + button");
const closeButton = document.querySelector("dialog button");
const documentBody = document.querySelector("body");
const userCommentsList = document.querySelector("#user_comments_list");
const products = document.querySelectorAll(".homepage_products");

function openModal(event, product) {
  const id = product.product_id;
  userCommentsList.innerHTML = "";
  // hvis like knappen på produktet så gør intet
  if (event.target.localName == "img" || event.target.localName == "button") {
    return;
    // ellers så åben modal
  } else {
    // åben modal
    dialog.showModal();
    //documentBody.classList.add("overflow-hidden");
    // kald function og hvis kommentar
    openPopup(id);

    // tjek for escape key og luk modal hvis den trykkes på.
    window.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        dialog.showModal();
      }
    });
  }

  productDetails(id, product);
}

async function openPopup(id) {
  const url = "api-get-comments.php";
  const response = await fetch(`/api/${url}`, {
    // headers: {
    //   "Content-Type": "application/json",
    // },
    method: "POST",
    body: JSON.stringify({ product_id_comment_fk: id }),
  });
  const data = await response.json();
  console.log(data);
  printOutCommentInfo(data);
}

function printOutCommentInfo(data) {
  console.log(data);
  // Clear comments list
  userCommentsList.innerHTML = "";
  // add all/new comments
  data.forEach((comment) => {
    // console.log(comment);
    const commentContainer = document.createElement("article");
    commentContainer.classList.add(
      "w-full",
      "border-solid",
      "border-2",
      "rounded-lg",
      "p-2",
      "grid",
      "mb-2"
    );
    commentContainer.innerHTML = `
    <div class="flex items-center gap-2">
    <img class="w-[35px] h-[35px] object-cover rounded-full" src="data:image/jpeg;base64,${comment.user_img}" />
    <p class="text-base font-semibold">${comment.commenter_first_name} ${comment.commenter_last_name}</p></div>
    <p class=""text-xs>${comment.user_comment}</p>
  `;
    userCommentsList.appendChild(commentContainer);
  });
}

function productDetails(id, product) {
  console.log(product);
  const productImg = document.getElementById("product_img_modal");
  const productId = document.getElementById("product_comment_id");
  const productName = document.getElementById("product_comment_name");
  const productPrice = document.getElementById("product_comment_price");
  const productRating = document.getElementById("product_comment_rating");
  const productCategory = document.getElementById("product_comment_category");
  const productDescription = document.getElementById(
    "product_comment_description"
  );
  console.log(product.category_name);

  productName.textContent = product.product_name;
  productPrice.textContent = product.product_price;
  productRating.textContent = product.product_rating;
  productCategory.textContent = product.productCategory;
  productDescription.textContent = product.product_description;

  productId.value = product.product_id;
  productImg.textContent = product.product_img;
  productImg.parentElement.style.setProperty(
    "background-color",
    product.category_color
  );
}

async function submitComment() {
  // Include event as a parameter
  // Prevent default form submission behavior
  event.preventDefault();
  const commentForm = event.target;
  const product_comment_id = event.target.product_comment_id.value;
  const comment = event.target.comment.value;
  console.log(commentForm);
  /* const formData = {
    product_comment_id: product_comment_id,
    comment: comment,
  }; */

  // Correctly construct the URL for the fetch call
  const url = "api/api-post-comment.php"; // Ensure this path is correct relative to your HTML file
  const response = await fetch(url, {
    // Removed /api/ prefix
    /* headers: {
      "Content-Type": "application/json",
    }, */
    method: "POST",
    body: new FormData(commentForm),
  });
  const data = await response.json();
  console.log(data);

  const commentContainer = document.createElement("article");
  commentContainer.classList.add(
    "w-full",
    "border-solid",
    "border-2",
    "rounded-lg",
    "p-2",
    "grid",
    "mb-2"
  );
  commentContainer.innerHTML = `
      <div class="flex items-center gap-2">
    <img class="w-[35px] h-[35px] object-cover rounded-full" src="data:image/jpeg;base64,${comment.user_img}" />
    <p class="text-base font-semibold">${comment.commenter_first_name} ${comment.commenter_last_name}</p></div>
    <p class=""text-xs>${comment.user_comment}</p>
  `;
  userCommentsList.prepend(commentContainer);
  commentForm.comment.value = " ";
}
