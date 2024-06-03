function validate(callback) {
  event.preventDefault();
  const form = event.target;
  //console.log(form)

  form.querySelectorAll("[data-validate]").forEach((element) => {
    element.classList.remove("validate-error");

    let regex;
    switch (element.getAttribute("data-validate")) {
      case "text":
        if (
          element.value.length < parseInt(element.getAttribute("data-min")) ||
          element.value.length > parseInt(element.getAttribute("data-max"))
        ) {
          element.classList.add("validate-error");
        }
        break;
      case "number":
        if (
          !/^\d+$/.test(element.value) ||
          parseInt(element.value) <
            parseInt(element.getAttribute("data-min")) ||
          parseInt(element.value) > parseInt(element.getAttribute("data-max"))
        ) {
          element.classList.add("validate-error");
        }
        break;
      case "email":
        regex =
          /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!regex.test(element.value.toLowerCase())) {
          element.classList.add("validate-error");
        }
        break;
      /*case "regex":
        //regex = new RegExp(element.getAttribute("data-regex"))
        //regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
        if (!regex.test(element.value)) {
          element.classList.add("validate-error")
        }
        break;*/
      case "match":
        if (
          element.value !=
            form.querySelector(
              `[name='${element.getAttribute("data-match-name")}']`
            ).value ||
          element.value.length == 0
        ) {
          element.classList.add("validate-error");
        }
        break;
    }
  });
  // if (!form.querySelector(".validate-error")) {
  //   callback();
  //   return;
  // }

  callback();

  //form.querySelector(".validate-error").focus()
}
