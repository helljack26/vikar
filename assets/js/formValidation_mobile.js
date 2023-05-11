// // Email input validation
const emailRefexp_mobile =
  /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
const formBlock_mobile = document.getElementById("review_form_mobile");
const submitBtn_mobile = document.getElementById("review_form_submit_mobile");

const productCode_mobile = document.getElementById("product_header_code");
// Form fields
const userName_mobile = document.getElementById("exampleInputName_mobile");
const userEmail_mobile = document.getElementById("exampleInputEmail_mobile");
const userTextArea_mobile = document.getElementById(
  "exampleInputReview_mobile"
);
// Form labels
const userNameLabel_mobile = document.getElementById(
  "exampleInputName_label_mobile"
);
const userEmailLabel_mobile = document.getElementById(
  "exampleInputEmail_label_mobile"
);
const userTextLabel_mobile = document.getElementById(
  "exampleInputReview_label_mobile"
);
// Submit window
const onSubmitSuccessModal_mobile = document.getElementById(
  "review_form_success_mobile"
);

// Is can submit
let isUserName_mobile = false;
let isUserEmail_mobile = false;
let isUserMessage_mobile = false;
let isCanSubmit_mobile = false;

// Colors
const defaultBorderColor_mobile = "#ccc";
const defaultTextColor_mobile = "#212322";
const errorBorderColor_mobile = "#d0021b";
const errorTextColor_mobile = "#d0021b";

// Rewiew stars_mobile
let starsCount_mobile = 0;
const stars_mobile = document.querySelectorAll(
  ".review_star_container_star_mobile"
);
const starsContainer_mobile = document.querySelector(
  ".product_reviewDescription_block_item_review_star_container_mobile"
);
starsContainer_mobile.addEventListener("click", starRating_mobile);

function starRating_mobile(e) {
  stars_mobile.forEach((star) => star.classList.remove("star__checked"));
  const i = [...stars_mobile].indexOf(e.target);
  if (i > -1) {
    stars_mobile[i].classList.add("star__checked");
    starsCount_mobile = stars_mobile.length - i;
  } else {
    starsCount_mobile = 0;
  }
}

// Check name field
function updateName_mobile() {
  if (userName_mobile.value.length > 1) {
    userName_mobile.style.borderColor = defaultBorderColor_mobile;
    userNameLabel_mobile.style.color = defaultTextColor_mobile;
    userName_mobile.addEventListener("blur", () => {
      userName_mobile.style.borderColor = defaultBorderColor_mobile;
      userNameLabel_mobile.style.color = defaultTextColor_mobile;
    });
    isCanSubmit_mobile = true;
    isUserName_mobile = true;
  } else {
    userName_mobile.style.borderColor = errorBorderColor_mobile;
    userNameLabel_mobile.style.color = errorTextColor_mobile;
    isCanSubmit_mobile = false;
    isUserName_mobile = false;
  }
}
// Email validate
function validateEmail_mobile(value) {
  return emailRefexp_mobile.test(value);
}

function updateEmail_mobile() {
  if (validateEmail_mobile(userEmail_mobile.value)) {
    userEmail_mobile.style.borderColor = defaultBorderColor_mobile;
    userEmailLabel_mobile.style.color = defaultTextColor_mobile;
    userEmail_mobile.addEventListener("blur", () => {
      userEmail_mobile.style.borderColor = defaultBorderColor_mobile;
      userEmailLabel_mobile.style.color = defaultTextColor_mobile;
    });
    isCanSubmit_mobile = true;
    isUserEmail_mobile = true;
  } else {
    userEmail_mobile.style.borderColor = errorBorderColor_mobile;
    userEmailLabel_mobile.style.color = errorTextColor_mobile;
    isCanSubmit_mobile = false;
    isUserEmail_mobile = false;
  }
}

// Check user message
function updateTextArea_mobile() {
  if (userTextArea_mobile.value.length > 4) {
    userTextArea_mobile.style.borderColor = defaultBorderColor_mobile;
    userTextLabel_mobile.style.color = defaultTextColor_mobile;

    userTextArea_mobile.addEventListener("blur", () => {
      userTextArea_mobile.style.borderColor = defaultBorderColor_mobile;
      userTextLabel_mobile.style.color = defaultTextColor_mobile;
    });
    isCanSubmit_mobile = true;
    isUserMessage_mobile = true;
  } else {
    userTextArea_mobile.style.borderColor = errorBorderColor_mobile;
    userTextLabel_mobile.style.color = errorTextColor_mobile;
    isCanSubmit_mobile = false;
    isUserMessage_mobile = false;
  }
}

// Submit
const submitHandler_mobile = () => {
  const isCanSubmit_mobile =
    isUserEmail_mobile === true && isUserMessage_mobile === true;
  if (isCanSubmit_mobile === true) {
    const submit = {
      productCode: productCode_mobile.innerText,
      userStars: starsCount_mobile,
      userName: userName_mobile.value,
      userEmail: userEmail_mobile.value,
      userMessage: userTextArea_mobile.value,
    };

    $.ajax({
      type: "POST",
      url: "/../small_php_func/sendReview.php",
      // processData: false,
      data: {
        submit: submit,
      },
      success: function () {
        // Clear inputs
        stars_mobile.forEach((star) => star.classList.remove("star__checked"));
        userName_mobile.value = "";
        userEmail_mobile.value = "";
        userTextArea_mobile.value = "";

        onSubmitSuccessModal_mobile.style.visibility = "visible";
        onSubmitSuccessModal_mobile.style.opacity = "1";
        setTimeout(() => {
          onSubmitSuccessModal_mobile.style.visibility = "hidden";
          onSubmitSuccessModal_mobile.style.opacity = "0";
        }, 5000);
      },
    });
  } else {
    !isUserName_mobile && updateName_mobile(true);
    !isUserEmail_mobile && updateEmail_mobile(true);
    !isUserEmail_mobile && updateTextArea_mobile(true);
  }
};
formBlock_mobile.addEventListener("keydown", (event) => {
  if (event.keyCode === 13) {
    event.preventDefault();
    userName_mobile.addEventListener("input", updateName_mobile());
    userEmail_mobile.addEventListener("input", updateEmail_mobile());
    userTextArea_mobile.addEventListener("input", updateTextArea_mobile());
    submitHandler_mobile(event);
  }
});
submitBtn_mobile.addEventListener("click", (event) => {
  event.preventDefault();
  userName_mobile.addEventListener("input", updateName_mobile());
  userEmail_mobile.addEventListener("input", updateEmail_mobile());
  userTextArea_mobile.addEventListener("input", updateTextArea_mobile());
  submitHandler_mobile(event);
});