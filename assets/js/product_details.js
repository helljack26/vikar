// Close fullscreen slider
const closeFullScreenSlider = () => {
    $(".product_img_fullscreen_container").animate({
        opacity: "0",
    });
    // On body scroll when fullscreen off
    $("body").css("padding-right", "0px");
    $("body").css("overflow-y", "scroll");
    setTimeout(() => {
        // Hide fullscreen slider
        $(".product_img_fullscreen_container").css("top", "-100%");
    }, 300);
}

$(document).ready(function () {

    // Fullscreen slider
    const largeFullSlider = $(".product_img_fullscreen_largeImg_slider");
    largeFullSlider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        swipe: true,
        arrows: true,
        fade: false,
        infinite: false,
        prevArrow: '<button type="button" class="slick-prev"></button>',
        nextArrow: '<button type="button" class="slick-next"></button>',
        responsive: [{
                breakpoint: 992,
                settings: {
                    swipe: true,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    swipe: true,
                    arrows: true,
                    prevArrow: '<button type="button" class="slick-prev"></button>',
                    nextArrow: '<button type="button" class="slick-next"></button>',
                },
            },
        ],
    });

    // On click on nav item set active class
    $(".product_img_fullscreen_slider_item").click(function (e) {
        const itemIndex = e.target.attributes[1].value;
        $(".product_img_fullscreen_largeImg_slider").slick("slickGoTo", +itemIndex);
    });


    // Listen fullscreen slider
    $(".product_img_fullscreen_largeImg_slider").on(
        "afterChange",
        function (event, slick, currentSlide, nextSlide) {
            // Set active class for fullscreen nav
            $(".product_img_fullscreen_slider_item").removeClass(
                "product_img_fullscreen_slider_item_active"
            );
            setTimeout(() => {
                $(
                    `.product_img_fullscreen_slider div:nth-child(${currentSlide + 1})`
                ).addClass("product_img_fullscreen_slider_item_active");
            }, 200);
        }
    );

    // Close fullscreen slider
    $(".product_img_fullscreen_container_close").click(function () {
        closeFullScreenSlider()
    });

    // Вначале нужно показать а потом спрятать полноекранний слайдер что би отрабативались клики на мобильном хедере
    $(".product_img_fullscreen_container").hide();
    // Zoom and open fullscreen slider
    $(".product_img_container_largeImg_slider_item").click(function (e) {
        $(".product_img_fullscreen_container").show();

        const windowHeight = window.innerHeight
        $(".product_img_fullscreen_container").css({
            "top": "0px",
            'height': `${windowHeight}`
        });

        // Wait while slider change offset top
        setTimeout(() => {
            // Off body scroll when fullscreen on
            $(".product_img_fullscreen_container").animate({
                opacity: "1",
            });
            // Set current slide in fullscreen slider
            const currentSlide = $(".product_img_container_largeImg_slider").slick(
                "slickCurrentSlide"
            );
            $(".product_img_fullscreen_largeImg_slider").slick(
                "slickGoTo",
                +currentSlide
            );

            // Set active class for fullscreen nav
            $(".product_img_fullscreen_slider_item").removeClass(
                "product_img_fullscreen_slider_item_active"
            );
            $(
                `.product_img_fullscreen_slider div:nth-child(${currentSlide + 1})`
            ).addClass("product_img_fullscreen_slider_item_active");
        }, 300);
        setTimeout(() => {
            $("body").css("overflow-y", "hidden");
            $("body").css("padding-right", "10px");
        }, 500);
    });


    // Largeimg Page slider
    $(".product_img_container_largeImg_slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: false,
        vertical: false,
        infinite: false,
        swipe: false,
        variableWidth: true,
        asNavFor: ".product_img_container_slider",
        responsive: [{
            breakpoint: 992,
            settings: {
                variableWidth: true,
                swipe: true,
            },
        }, ],
    });
});
// Page slider navigation
$(document).ready(function () {
    const smallSlider = $(".product_img_container_slider");
    smallSlider.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: ".product_img_container_largeImg_slider",
        dots: false,
        centerMode: false,
        vertical: true,
        verticalSwiping: true,
        infinite: false,
        focusOnSelect: true,
        arrows: false,
        swipe: true,
        responsive: [{
                breakpoint: 992,
                settings: {
                    variableWidth: true,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    dots: false,
                    vertical: false,
                    verticalSwiping: false,
                    swipe: true,
                },
            },
            {
                breakpoint: 576,
                settings: {
                    variableWidth: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    vertical: false,
                    verticalSwiping: false,
                    swipe: true,
                },
            },
        ],
    });

    const smallSliderItemsLength =
        smallSlider.children()[0].children[0].children.length;
    //Implementing navigation of slides using mouse scroll
    smallSlider.on("wheel", function (e) {
        if (smallSliderItemsLength > 3) {
            e.preventDefault();
            if (e.originalEvent.deltaY > 0) {
                $(this).slick("slickNext");
            } else {
                $(this).slick("slickPrev");
            }
        }
    });
});

// Recommend slider
$(document).ready(function () {
    $("#similar_slider").slick({
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 6000,
        arrows: false,
        dots: true,
        responsive: [{
                breakpoint: 1650,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                },
            },
        ],
    });
    // Discount slider
    $("#discount_slider").slick({
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        arrows: false,
        dots: true,
        responsive: [{
                breakpoint: 1650,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false,
                },
            },
        ],
    });
});

$(document).ready(function () {

    const resetBuyButton = () => {
        $(".exampleModalLong24").text("Купити");
        $(".exampleModalLong24").css({
            "background-color": "#8ec340",
            color: "white",
        });
    }

    // <!-- Select and count -->
    num = parseFloat($(".select_tb").val());
    $(".select_tb").change(function () {
        resetBuyButton()
        num = parseFloat($(this).val());
        unit = parseFloat($(this).val());
        $(".prices").html(unit.toFixed(2) + " грн");
        $(".prices").attr("data", unit.toFixed(2) + " грн");
        $(".quant").val(1);
        $(".price").val(unit.toFixed(2)); //плюсуємо товар
        $(".price").attr("data", unit.toFixed(2) + " грн");
    });

    $(".plus").click(function () {
        resetBuyButton()
        quant = parseFloat($(".quant").val());
        price = parseFloat($(".prices").html()); //цена товара
        old = parseFloat($(".prices").attr("data"));
        res = old * (quant + 1);
        if (
            $(".quant").val() == null ||
            $(".quant").val() == "0" ||
            $(".quant").val() == ""
        ) {
            $(".quant").val(1);
        }
        if (quant > 0) {
            $(".quant").val(quant + 1);
            $(".prices").html(res.toFixed(2) + " грн");
            $(".price").val(res.toFixed(2)); //плюсуємо товар
        }
    });
    $(".minus").click(function () {
        resetBuyButton()
        quant = parseInt($(".quant").val());
        price = parseFloat($(".prices").html()); //цена товара
        old = parseFloat($(".prices").attr("data"));
        res = old * (quant - 1);
        if (quant > 1) {
            $(".quant").val(quant - 1);
            $(".prices").html(res.toFixed(2) + " грн");
            $(".price").val(res.toFixed(2)); //плюсуємо товар
        }
    });
    $(".quant").bind("keyup change paste", function () {
        resetBuyButton()
        quant = parseInt($(this).val());
        price = parseFloat($(".prices").html()); //цена товара
        old = parseFloat($(".prices").attr("data"));
        res = old * quant;
        if (quant > 0) {
            $(".prices").html(res.toFixed(2) + " грн");
            $(".price").val(res.toFixed(2)); //плюсуємо товар
        }
    });

    // Buy button
    $(".exampleModalLong24").click(function (event) {
        if (event.target.innerText === "Оформити") {
            return (document.location = "my-cart.php");
        } else {
            var price = parseFloat($(".prices").attr("data"));
            quant = parseInt($(".quant").val());
            unit = $(".select_tb").val();
            userAddress = $(".product_info_stores_btn_address").html();
            product_code = event.target.attributes[2].value;
            char_hash = event.target.attributes[3].value;
            const isCharHash = char_hash.length > 0 ? char_hash : '';
            $.ajax({
                type: "POST",
                url: "my-cart/my-cart-no-reload.php",
                data: {
                    pid: product_code,
                    price: price,
                    quant: quant,
                    unit: unit,
                    userAddress: userAddress.trim(),
                    char_hash: isCharHash,
                },
                success: function (results) {
                    const data = results.split("|");
                    const countInBasket = data[0];
                    const sumInBasket = parseFloat(data[1]).toFixed(2);
                    const newBasketData = data[2];

                    $(".exampleModalLong24").text("Оформити");
                    $(".exampleModalLong24").css({
                        "background-color": "#679500",
                        color: "#ffcd00",
                    });
                    // Basket update
                    $(".header_second_row_basket_block").html(newBasketData);
                    $(".count").fadeIn();
                    $(".count").html(countInBasket);
                    $(".value").html(`${sumInBasket} ₴`);
                    $(".valuee").html(`${sumInBasket} ₴`);
                    $(".price_sum").html(`${sumInBasket} ₴`);
                },
            });
        }
    });

    $("#noreload").click(function () {
        window.location.href = "my-cart.php";
    });
});
$(document).ready(function () {
    // Open dropdown with address
    $(".product_info_stores_btn").click(function () {
        $(".product_info_stores_btn_arrow").toggleClass(
            "product_info_stores_btn_arrow_rotate"
        );
        $(".product_info_stores_dropdown").slideToggle();
    });

    $(document).click(function (e) {
        // Close dropdown 
        const dropdownParentBlock = $(".product_info_stores_block");
        if (dropdownParentBlock.has(e.target).length === 0) {
            $(".product_info_stores_btn_arrow").removeClass(
                "product_info_stores_btn_arrow_rotate"
            );
            $(".product_info_stores_dropdown").slideUp();
        }
    });

    // Change dropdown with address header
    $(".product_info_stores_dropdown_item").click(function (e) {
        const currentChild = $(this).children();
        const currentAddress = currentChild[0].innerText;
        const currentAvailable = currentChild[1].innerText;
        $(".product_info_stores_btn_address").text(currentAddress);
        $(".product_info_stores_btn_title").text(currentAvailable);

        $(".product_info_stores_btn_arrow").removeClass(
            "product_info_stores_btn_arrow_rotate"
        );
        $(".product_info_stores_dropdown").slideUp();
    });

    // Share in social media
    $(".social_link").click(function (e) {
        const url = e.target.attributes[2].value;
        window.open(url);
    });

    // Review/Description
    const scrollToReviewDesktop = (e) => {
        $(".product_reviewDescription_header_btn").removeClass(
            "product_reviewDescription_header_btn_active"
        );
        $(".product_reviewDescription_header_btn_review").addClass(
            "product_reviewDescription_header_btn_active"
        );

        $(".product_reviewDescription_block_item_video").fadeOut();
        $(".product_reviewDescription_block_item_description").fadeOut();

        setTimeout(() => {
            $(".product_reviewDescription_block_item_review").fadeIn();
        }, 400);
        const blockHash =
            e !== "review_form" ? e.target.attributes[2].value : "review_form";

        setTimeout(() => {
            const reviewBlock = $(".product_reviewDescription_block_item_review");
            jQuery("html:not(:animated),body:not(:animated)").animate({
                    scrollTop: reviewBlock.offset().top - 100,
                },
                1000
            );

            if (blockHash === "review_form") {
                reviewBlock.scrollTop(reviewBlock.prop("scrollHeight"));
            } else {
                reviewBlock.scrollTop(0);
            }
            return false;
        }, 600);
    };

    // When click review in header
    $(".scroll_to_review").click(function (e) {
        scrollToReviewDesktop(e);
    });

    const scrollToReviewMobile = (e) => {
        $(".product_reviewDescription_header_btn_mobile").removeClass(
            "product_reviewDescription_header_btn_active"
        );
        $(".product_reviewDescription_header_btn_review_mobile").addClass(
            "product_reviewDescription_header_btn_active"
        );

        $(".product_reviewDescription_block_item_video").fadeOut();
        $(".product_reviewDescription_block_item_description").fadeOut();

        setTimeout(() => {
            $(
                ".product_reviewDescription_block_item_review_container_mobile"
            ).fadeIn();
        }, 400);
        const blockHash =
            e !== "review_form_mobile" ?
            e.target.attributes[2].value :
            "review_form_mobile";
        setTimeout(() => {
            const reviewBlock = $(
                ".product_reviewDescription_block_item_review_container_mobile"
            );
            jQuery("html:not(:animated),body:not(:animated)").animate({
                    scrollTop: reviewBlock.offset().top - 150,
                },
                1000
            );

            if (blockHash === "review_form_mobile") {
                reviewBlock.scrollTop(reviewBlock.prop("scrollHeight"));
            } else {
                reviewBlock.scrollTop(0);
            }
            return false;
        }, 600);
    };

    $(".scroll_to_review_mobile").click(function (e) {
        scrollToReviewMobile(e);
    });

    // If click leave review in some small card
    if (location.hash === "#review") {
        setTimeout(() => {
            if (window.innerWidth > 991) {
                scrollToReviewDesktop("review_form");
            } else {
                scrollToReviewMobile("review_form_mobile");
            }
        }, 400);
    }

    // Description open
    $(".product_reviewDescription_header_btn").click(function (e) {
        const hash = e.target.innerText.split(" ")[0];
        $(".product_reviewDescription_header_btn").removeClass(
            "product_reviewDescription_header_btn_active"
        );
        $(this).addClass("product_reviewDescription_header_btn_active");

        const openActiveTab = (activeTab) => {
            $(".product_reviewDescription_block_item_description").fadeOut();
            $(".product_reviewDescription_block_item_attributes").fadeOut();
            $(".product_reviewDescription_block_item_review").fadeOut();
            $(".product_reviewDescription_block_item_video").fadeOut();

            setTimeout(() => {
                $(activeTab).fadeIn();
            }, 400);
        }

        if (hash === "Опис") {
            openActiveTab('.product_reviewDescription_block_item_description');
        } else if (hash === "Характеристики") {
            openActiveTab('.product_reviewDescription_block_item_attributes');
        } else if (hash === "Відгуки") {
            openActiveTab('.product_reviewDescription_block_item_review');
        } else {
            openActiveTab('.product_reviewDescription_block_item_video');
        }
    });


    // Description open mobile
    $(".product_reviewDescription_header_btn_mobile").click(function (e) {
        const hash = e.target.innerText.split(" ")[0];
        $(".product_reviewDescription_header_btn_mobile").removeClass(
            "product_reviewDescription_header_btn_active"
        );
        $(this).addClass("product_reviewDescription_header_btn_active");

        const openActiveTab = (activeTab) => {
            $(".product_reviewDescription_block_item_description").fadeOut();
            $(".product_reviewDescription_block_item_attributes").fadeOut();
            $(".product_reviewDescription_block_item_review_container_mobile").fadeOut();
            $(".product_reviewDescription_block_item_video").fadeOut();

            setTimeout(() => {
                $(activeTab).fadeIn();
            }, 400);
        }

        if (hash === "Опис") {
            openActiveTab('.product_reviewDescription_block_item_description');
        } else if (hash === "Характеристики") {
            openActiveTab('.product_reviewDescription_block_item_attributes');
        } else if (hash === "Відгуки") {
            openActiveTab('.product_reviewDescription_block_item_review_container_mobile');
        } else {
            openActiveTab('.product_reviewDescription_block_item_video');
        }
    });
});