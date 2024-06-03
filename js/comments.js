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

  printOutCommentInfo(data);
}

function printOutCommentInfo(data) {
  console.log(data);

  data.forEach((comment) => {
    console.log(comment);
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
    <p class="text-base font-semibold"> ${
      comment.user_img ? comment.user_img : "?"
    } ${comment.commenter_first_name} ${comment.commenter_last_name}</p>
    <p class=""text-xs>${comment.user_comment}</p>
  `;
    userCommentsList.appendChild(commentContainer);
  });
}

function productDetails(id, product) {
  const productImg = document.getElementById("product_img_modal");
  const productTitle = document.getElementById("product_comment_id");

  productTitle.textContent = product.product_name;
  productImg.textContent = product.product_img;
}
