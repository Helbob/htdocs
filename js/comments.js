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

function printOutCommentInfo(listOfComments) {
  console.log(listOfComments);
  // Clear comments list
  userCommentsList.innerHTML = "";
  // add all/new comments
  listOfComments.reverse().forEach((comment) => {
    // console.log(comment);
    if (
      comment.comment_public_status == 0 ||
      comment.commenter_id == comment.user_id
    ) {
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
    <img class="w-[35px] h-[35px] object-cover rounded-full object-center aspect-[1/1]" src="data:image/jpeg;base64,${
      comment.user_img
    }" />
    <p class="text-base font-semibold">${comment.commenter_first_name} ${
        comment.commenter_last_name
      }  <span class="text-sm text-gray-400">${
        comment.toggle_public == 0 ? "Public" : "Private"
      }</span></p></div>
    <p class=""text-xs>${comment.user_comment}</p>
  `;
      userCommentsList.appendChild(commentContainer);
    } else if (
      comment.comment_public_status == 1 &&
      comment.commenter_id != comment.user_id
    ) {
      return;
    }
  });
}

function productDetails(id, product) {
  //console.log(product);
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
  productPrice.textContent = `${product.product_price} kr`;
  productRating.textContent = product.product_rating;
  productCategory.textContent = product.category_name;
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
  const checkbox = event.target.comments_public_status.checked;
  console.log(checkbox, comment, product_comment_id);
  const formData = new FormData(commentForm);

  // Ensure checkbox value is included
  formData.append(
    "comments_public_status",
    commentForm.comments_public_status.checked ? 1 : 0
  );
  console.log(Array.from(formData.entries())); // Check form data

  // Correctly construct the URL for the fetch call
  const url = "api/api-post-comment.php"; // Ensure this path is correct relative to your HTML file
  const response = await fetch(url, {
    // Removed /api/ prefix
    /* headers: {
      "Content-Type": "application/json",
    }, */
    method: "POST",
    body: formData,
  });
  const data = await response.json();
  console.log(data);
  if (data.length > 0 && data[0].comment_id) {
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
    <img class="w-[35px] h-[35px] object-cover rounded-full object-center aspect-[1/1]" src="data:image/jpeg;base64,${
      data[0].user_img
    }" />
    <p class="text-base font-semibold">${data[0].commenter_first_name} ${
      data[0].commenter_last_name
    } <span class="text-sm text-gray-400">${
      data[0].toggle_public == 0 ? "Public" : "Private"
    }</span></p></div>
    <p class=""text-xs>${data[0].user_comment}</p>
  `;
    userCommentsList.prepend(commentContainer);
    // reset comment form
    commentForm.comment.value = " ";
  } else {
    console.log("Error: Comment not posted.");
  }
}

// Toggle comment visability status: public/private
function tgl_visability() {
  console.log(event.target.checked);
  const span = document.getElementById("comment_tgl_public");
  if (span.textContent === "Public") {
    span.textContent = "Private";
  } else {
    span.textContent = "Public";
  }
}
