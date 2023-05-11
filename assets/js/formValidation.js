// // Email input validation
const emailRefexp =
  /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
const formBlock = document.getElementById("review_form");
const submitBtn = document.getElementById("review_form_submit");

const productCode = document.getElementById("product_header_code");
// Form fields
const userName = document.getElementById("exampleInputName");
const userEmail = document.getElementById("exampleInputEmail");
const userTextArea = document.getElementById("exampleInputReview");
// Form labels
const userNameLabel = document.getElementById("exampleInputName_label");
const userEmailLabel = document.getElementById("exampleInputEmail_label");
const userTextLabel = document.getElementById("exampleInputReview_label");
// Submit window
const onSubmitSuccessModal = document.getElementById("review_form_success");

// Is can submit
let isUserName = false;
let isUserEmail = false;
let isUserMessage = false;
let isCanSubmit = false;

// Colors
const defaultBorderColor = "#ccc";
const defaultTextColor = "#212322";
const errorBorderColor = "#d0021b";
const errorTextColor = "#d0021b";

// Rewiew stars
let starsCount = 0;
const stars = document.querySelectorAll(".review_star_container_star");
const starsContainer = document.querySelector(
  ".product_reviewDescription_block_item_review_star_container"
);
starsContainer.addEventListener("click", starRating);
function starRating(e) {
  stars.forEach((star) => star.classList.remove("star__checked"));
  const i = [...stars].indexOf(e.target);
  if (i > -1) {
    stars[i].classList.add("star__checked");
    starsCount = stars.length - i;
  } else {
    starsCount = 0;
  }
}

// Check name field
function updateName() {
  if (userName.value.length > 1) {
    userName.style.borderColor = defaultBorderColor;
    userNameLabel.style.color = defaultTextColor;
    userName.addEventListener("blur", () => {
      userName.style.borderColor = defaultBorderColor;
      userNameLabel.style.color = defaultTextColor;
    });
    isCanSubmit = true;
    isUserName = true;
  } else {
    userName.style.borderColor = errorBorderColor;
    userNameLabel.style.color = errorTextColor;
    isCanSubmit = false;
    isUserName = false;
  }
}
// Email validate
function validateEmail(value) {
  return emailRefexp.test(value);
}
function updateEmail() {
  if (validateEmail(userEmail.value)) {
    userEmail.style.borderColor = defaultBorderColor;
    userEmailLabel.style.color = defaultTextColor;
    userEmail.addEventListener("blur", () => {
      userEmail.style.borderColor = defaultBorderColor;
      userEmailLabel.style.color = defaultTextColor;
    });
    isCanSubmit = true;
    isUserEmail = true;
  } else {
    userEmail.style.borderColor = errorBorderColor;
    userEmailLabel.style.color = errorTextColor;
    isCanSubmit = false;
    isUserEmail = false;
  }
}

// Check user message
function updateTextArea() {
  if (userTextArea.value.length > 4) {
    userTextArea.style.borderColor = defaultBorderColor;
    userTextLabel.style.color = defaultTextColor;

    userTextArea.addEventListener("blur", () => {
      userTextArea.style.borderColor = defaultBorderColor;
      userTextLabel.style.color = defaultTextColor;
    });
    isCanSubmit = true;
    isUserMessage = true;
  } else {
    userTextArea.style.borderColor = errorBorderColor;
    userTextLabel.style.color = errorTextColor;
    isCanSubmit = false;
    isUserMessage = false;
  }
}

// Submit
const submitHandler = () => {
  const isCanSubmit = isUserEmail === true && isUserMessage === true;
  if (isCanSubmit === true) {
    const submit = {
      productCode: productCode.innerText,
      userStars: starsCount,
      userName: userName.value,
      userEmail: userEmail.value,
      userMessage: userTextArea.value,
    };

    $.ajax({
      type: "POST",
      url: "/../small_php_func/sendReview.php",
      data: {
        submit: submit,
      },
      success: function () {
        // Clear inputs
        stars.forEach((star) => star.classList.remove("star__checked"));
        userName.value = "";
        userEmail.value = "";
        userTextArea.value = "";

        onSubmitSuccessModal.style.visibility = "visible";
        onSubmitSuccessModal.style.opacity = "1";
        setTimeout(() => {
          onSubmitSuccessModal.style.visibility = "hidden";

          onSubmitSuccessModal.style.opacity = "0";
        }, 5000);
      },
    });
  } else {
    !isUserName && updateName(true);
    !isUserEmail && updateEmail(true);
    !isUserEmail && updateTextArea(true);
  }
};
formBlock.addEventListener("keydown", (event) => {
  if (event.keyCode === 13) {
    event.preventDefault();
    userName.addEventListener("input", updateName());
    userEmail.addEventListener("input", updateEmail());
    userTextArea.addEventListener("input", updateTextArea());
    submitHandler(event);
  }
});
submitBtn.addEventListener("click", (event) => {
  event.preventDefault();
  userName.addEventListener("input", updateName());
  userEmail.addEventListener("input", updateEmail());
  userTextArea.addEventListener("input", updateTextArea());
  submitHandler(event);
});
