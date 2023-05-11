$("#phone").mask("+38 (999) 99-99-999");

// Объявления
var msg = document.querySelector(".msg");
var gsapMsg = gsap.to(".msg", 0.25, {
  autoAlpha: 1,
  y: -40,
  ease: Expo.inOut,
  paused: true,
});
var arrInput = document.querySelectorAll(".aInput");


// Функция появления статуса отправки сообщения
function showMsg(message, color) {
  msg.innerText = message;
  msg.style.background = color;
  gsapMsg.restart();
}

// Оформление input file
function inputFile(e) {
  el = e.target.parentNode.querySelector(".count");
  if (e.target.value != "")
    el.innerHTML = "Выбрано файлов: " + e.target.files.length;
  else el.innerHTML = "Прикрепить файлы";
}

// Анимация input text
for (var i = 0, count = arrInput.length; i < count; i++) {
  arrInput[i].addEventListener("focus", function () {
    this.nextElementSibling.classList.add("active");
  });
  arrInput[i].addEventListener("blur", function () {
    if (this.value == false) this.nextElementSibling.classList.remove("active");
  });
}

// Анимация появления блоков
// window.onload = function () {
//   var loadPage = gsap.timeline();
//   loadPage.to("#form", 0.7, { autoAlpha: 1, y: 0, ease: Expo.inOut });
//   // loadPage.to(".link", 0.7, { autoAlpha: 1, y: 0, ease: Expo.inOut }, 0);
//   loadPage.to(
//     ".input-wrap",
//     0.5,
//     { stagger: 0.15, autoAlpha: 1, y: 0, ease: Expo.inOut },
//     0.35
//   );
//   loadPage.to(
//     ".file-wrap, .button",
//     0.5,
//     { stagger: 0.15, autoAlpha: 1, x: 0, ease: Expo.inOut },
//     0.6
//   );
// };

$(document).ready(function () {
  var dis = false;
  // $("#response").click(function () {
  // 	if (dis == true) {
  // 		alert(1);
  // 	}
  // });
  $("#email").on("keyup input", function () {
    if ($("#email").val() !== "") {
      dis = true;
    } else {
      dis = false;
      $("#email").addClass("inpt");
    }
  });
  $("#name").on("keyup input", function () {
    if ($("#name").val().length > 0) {
      dis = true;
    } else {
      dis = false;
      $("#name").css("border", "1px solid #A30000");
    }
  });
  $("#phone").on("keyup input", function () {
    if ($("#phone").val().length > 0) {
      dis = true;
    } else {
      dis = false;
      $("#phone").css("border", "1px solid #A30000");
    }
  });
  $("#texta").on("keyup input", function () {
    if ($("#texta").val().length > 0) {
      dis = true;
    } else {
      dis = false;
      $("#texta").css("border", "1px solid #A30000");
    }
  });
});