let isAvailabilityPopup;
let popupProductCode;
let charHash;

$(document).ready(function () {

  $(document).click(function (e) {
    var container = $("#product_details_popup");
    if (container.has(e.target).length === 0) {
      $(".product_details_popup_bg").fadeOut();
      $(".product_details_popup_container").fadeOut();
      $("#product_details_popup").fadeOut();
    }
  });
  const setContentToPopUp = (isAvailabilityPopup) => {
    // Popup content
    const isFastHeader = isAvailabilityPopup ?
      "Уточнити наявнiсть" :
      "Замовити швидко";
    const isFastButton = isAvailabilityPopup ?
      "Вiдправити" :
      "Оформити замовлення";
    const isFastFooterText = isAvailabilityPopup ?
      "" :
      "Підтверджуючи замовлення, я приймаю умови угоди користувача.";

    // Get fields
    $("#popup_header").text(isFastHeader);
    $("#product_details_popup_form_button").text(isFastButton);
    $("#product_details_popup_footer_form_text").text(isFastFooterText);

    return;
  };

  // Open and set content
  $(document).on(
    "click",
    ".product_info_isAvailable, #product_info_fastOrder",
    function (e) {
      isAvailabilityPopup = e.target.classList.contains(
        "product_info_isAvailable"
      );
      setContentToPopUp(isAvailabilityPopup);

      popupProductCode = $(this).attr('data-product-code');
      charHash = $(this).attr('data-char');

      // Open popup
      $(".product_details_popup_bg").fadeIn();
      $(".product_details_popup_container").fadeIn();
      $("#product_details_popup").fadeIn();
      return false;
    }
  );
  // Close popup
  $(".product_details_popup_container_close").click(function () {
    $(".product_details_popup_bg").fadeOut();
    $(".product_details_popup_container").fadeOut();
    $("#product_details_popup").fadeOut();
    return false;
  });
});
// // // Email input validation
const emailPopupRefexp =
  /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
const popupFormBlock = document.getElementById("popup_form");
const popupSubmitBtn = document.getElementById(
  "product_details_popup_form_button"
);

// Form fields
const popupUserName = document.getElementById("product_details_popup_name");
const popupUserEmail = document.getElementById("product_details_popup_email");
const popupUserPhone = document.getElementById("product_details_popup_phone");
// Form labels
const popupUserNameLabel = document.getElementById(
  "product_details_popup_name_label"
);
const popupUserEmailLabel = document.getElementById(
  "product_details_popup_email_label"
);
const popupUserPhoneLabel = document.getElementById(
  "product_details_popup_phone_label"
);
// Submit window
const popupOnSubmitSuccessModal = document.getElementById(
  "product_details_popup_success"
);
const popupOnSubmitSuccessModalHeader = document.getElementById(
  "product_details_popup_success_header"
);

// Is can submit
let isPopupUserName = false;
let isPopupUserEmail = false;
let isPopupPhone = false;
let isPopupCanSubmit = false;

// Colors
const defaultPopupBorderColor = "#ccc";
const defaultPopupTextColor = "#212322";
const errorPopupBorderColor = "#d0021b";
const errorPopupTextColor = "#d0021b";

// Check name field
function updatePopupName() {
  if (popupUserName.value.length > 1) {
    popupUserName.style.borderColor = defaultPopupBorderColor;
    popupUserNameLabel.style.color = defaultPopupTextColor;
    popupUserName.addEventListener("blur", () => {
      popupUserName.style.borderColor = defaultPopupBorderColor;
      popupUserNameLabel.style.color = defaultPopupTextColor;
    });
    isPopupCanSubmit = true;
    isPopupUserName = true;
  } else {
    popupUserName.style.borderColor = errorPopupBorderColor;
    popupUserNameLabel.style.color = errorPopupTextColor;
    isPopupCanSubmit = false;
    isPopupUserName = false;
  }
}
// Email validate
function validatePopupEmail(value) {
  return emailPopupRefexp.test(value);
}

function updatePopupEmail() {
  if (validatePopupEmail(popupUserEmail.value)) {
    popupUserEmail.style.borderColor = defaultPopupBorderColor;
    popupUserEmailLabel.style.color = defaultPopupTextColor;
    popupUserEmail.addEventListener("blur", () => {
      popupUserEmail.style.borderColor = defaultPopupBorderColor;
      popupUserEmailLabel.style.color = defaultPopupTextColor;
    });
    isPopupCanSubmit = true;
    isPopupUserEmail = true;
  } else {
    popupUserEmail.style.borderColor = errorPopupBorderColor;
    popupUserEmailLabel.style.color = errorPopupTextColor;
    isPopupCanSubmit = false;
    isPopupUserEmail = false;
  }
}

// Check user message
function updatePhone() {
  if (popupUserPhone.value.length > 4) {
    popupUserPhone.style.borderColor = defaultPopupBorderColor;
    popupUserPhoneLabel.style.color = defaultPopupTextColor;

    popupUserPhone.addEventListener("blur", () => {
      popupUserPhone.style.borderColor = defaultPopupBorderColor;
      popupUserPhoneLabel.style.color = defaultPopupTextColor;
    });
    isPopupCanSubmit = true;
    isPopupPhone = true;
  } else {
    popupUserPhone.style.borderColor = errorPopupBorderColor;
    popupUserPhoneLabel.style.color = errorPopupTextColor;
    isPopupCanSubmit = false;
    isPopupPhone = false;
  }
}

// Submit
const popupSubmitHandler = (e) => {
  const isPopupCanSubmit = isPopupUserEmail === true && isPopupPhone === true;
  const messageSubject = isAvailabilityPopup ?
    "Уточнення наявностi на сайті vikar.center" :
    "Швидке замовлення на сайті vikar.center";
  const successWindowHeader = isAvailabilityPopup ?
    "Запит вiдправлено" :
    "Замовлення вiдправлено";

  if (isPopupCanSubmit === true) {
    popupOnSubmitSuccessModalHeader.innerText = successWindowHeader;
    popupOnSubmitSuccessModal.style.visibility = "visible";
    popupOnSubmitSuccessModal.style.opacity = "1";
    $.ajax({
      type: "POST",
      url: "/small_php_func/speed_message.php",
      data: {
        messageSubject: messageSubject,
        product: popupProductCode,
        char_hash: charHash,
        name: popupUserName.value,
        phone: popupUserPhone.value,
        email: popupUserEmail.value,
      },
      success: function (data) {

        console.log("🚀 ~ file: product_details_popup.js:208 ~ popupSubmitHandler ~ data", data)
        popupOnSubmitSuccessModalHeader.innerText = successWindowHeader;
        popupOnSubmitSuccessModal.style.visibility = "visible";
        popupOnSubmitSuccessModal.style.opacity = "1";
        setTimeout(() => {
          popupOnSubmitSuccessModal.style.visibility = "hidden";
          popupOnSubmitSuccessModal.style.opacity = "0";
          $(".product_details_popup_bg").fadeOut();
          $(".product_details_popup_container").fadeOut();
          $("#product_details_popup").fadeOut();
        }, 2000);
      },
      error: function () {
        alert("Помилка вiдправлення, спробуйте ще раз пiзнiше.");
      },
    });
  } else {
    !isPopupUserName && updatePopupName(true);
    !isPopupUserEmail && updatePopupEmail(true);
    !isPopupUserEmail && updatePhone(true);
  }
};
popupFormBlock.addEventListener("keydown", (event) => {
  if (event.keyCode === 13) {
    event.preventDefault();
    popupUserName.addEventListener("input", updatePopupName());
    popupUserEmail.addEventListener("input", updatePopupEmail());
    popupUserPhone.addEventListener("input", updatePhone());
    popupSubmitHandler(event);
  }
});
popupSubmitBtn.addEventListener("click", (event) => {
  event.preventDefault();
  popupUserName.addEventListener("input", updatePopupName());
  popupUserEmail.addEventListener("input", updatePopupEmail());
  popupUserPhone.addEventListener("input", updatePhone());
  popupSubmitHandler(event);
});