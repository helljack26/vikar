// Scroll to top on refresh
if (history.scrollRestoration) {
    history.scrollRestoration = 'manual';
} else {
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    }
}

(function ($) {
    $(document).ready(function () {
        echo.init({
            offset: 100,
            throttle: 250,
            unload: false,
        });

        // Header
        // Get basket data
        $.ajax({
            type: "POST",
            url: "../small_php_func/getBasketList.php",
            success: function (results) {
                if (results.length > 0) {
                    const data = results.split("|");
                    const countInBasket = data[0];
                    const sumInBasket = parseFloat(data[1]).toFixed(2);
                    const newBasketData = data[2];

                    // Set result to ul
                    $(".header_second_row_basket_block").html(results);
                    // Basket update
                    $(".header_second_row_basket_block").html(newBasketData);
                    if (parseFloat(countInBasket) > 0) {
                        $(".count").fadeIn();
                        $(".count").html(countInBasket);
                    }

                    $(".value").html(`${sumInBasket} ₴`);
                    $(".valuee").html(`${sumInBasket} ₴`);
                    $(".price_sum").html(`${sumInBasket} ₴`);
                }
            },
        });

        const closeBasketIcon = () => {
            setTimeout(() => {
                $(".basket_btn_icon").removeClass("basket_btn_icon_open");
                $(".basket_btn_icon").css({
                        transform: "scale(1)",
                    },
                    "slow"
                );
            }, 300);
        };
        // Всі товари
        $(".header_side_menu_btn").click(function () {
            $(".header_side_menu_btn").toggleClass("header_side_menu_btn_open");
            $(".header_side_menu_block").fadeToggle();
        });

        // Iнформація
        $(".header_drop_btn").click(function () {
            $(".header_drop_block").fadeToggle();
        });


        // Корзина
        $(".header_second_row_basket_btn").click(function () {
            $(".basket_btn_icon").css({
                    transform: "scale(0.7)",
                },
                "slow"
            );
            setTimeout(() => {
                $(".basket_btn_icon").toggleClass("basket_btn_icon_open");
                $(".basket_btn_icon").css({
                        transform: "scale(1)",
                    },
                    "slow"
                );
            }, 300);

            $(".header_second_row_basket_block").fadeToggle();
        });

        // Телефони
        $(".desktop-navbar-phones_btn").click(function () {
            $(".desktop-navbar-phones_btn_arrow").toggleClass("phone_arrow_rotate");
            $(".desktop-navbar-phones").fadeToggle();
        });
        $(document).click(function (e) {
            // Закрити інформацію 
            const informationParentBlock = $(".header_first_row");
            if (informationParentBlock.has(e.target).length === 0) {
                $(".header_drop_block").fadeOut();
            }
            // Закрити Всі товари
            const container = $(".header_second_row_allProduct");
            // const allProductBtn = $(".header_side_menu_btn");
            if (container.has(e.target).length === 0) {
                $(".header_side_menu_btn").removeClass("header_side_menu_btn_open");
                $(".header_side_menu_block").fadeOut();
            }
            // Закрити Корзину
            const basketContainer = $(".header_second_row_basket");
            if (basketContainer.has(e.target).length === 0) {
                $(".header_second_row_basket_block").fadeOut();
                closeBasketIcon();
            }
            // Закрити телефони
            const phoneContainer = $(".desktop-navbar-phones_wrapper");
            if (phoneContainer.has(e.target).length === 0) {
                $(".desktop-navbar-phones_btn_arrow").removeClass("phone_arrow_rotate");
                $(".desktop-navbar-phones").fadeOut();
            }
        });

        // Phone block action
        $(".desktop-navbar-phones_close").click(function () {
            $(".desktop-navbar-phones_btn_arrow").removeClass("phone_arrow_rotate");
            $(".desktop-navbar-phones").fadeOut();
        });


        // Search field
        $(".search-field").on("keyup input", function () {
            $("p").slice(2);
            var search = $(this).val();
            $.ajax({
                type: "POST",
                url: "../small_php_func/search_fields.php",
                data: {
                    q: search,
                    search: "1",
                },
                success: function (data) {
                    $(".search_wrapper").html(data).show();
                },
            });
        });

        // Mobile menu
        // Side menu action
        const openSideMenu = () => {
            $(".mobile-navbar-toggle").addClass("mobile-navbar-toggle_open");

            $(".mobile-navbar-collapse").animate({
                    left: "0px",
                },
                "slow"
            );
            $(".mobile-navbar-collapse").attr("data", "1");
            $(".mobile_menu_bg").fadeIn("slow");
            $("body").css("overflow-y", "hidden");
            return;
        };

        const closeSideMenu = () => {
            $(".mobile-navbar-toggle").removeClass("mobile-navbar-toggle_open");

            $(".mobile-navbar-collapse").animate({
                    left: "-100%",
                },
                "slow"
            );
            $(".mobile-navbar-collapse").attr("data", "0");
            $(".mobile_menu_bg").fadeOut("slow");
            $("body").css("overflow-y", "scroll");
            // Close inside items
            setTimeout(() => {
                $(".allproduct_header_button").removeClass(
                    "allproduct_header_button_open"
                );
                $(".allproduct_collapsed").slideUp();
                $(".allproduct_child").slideUp();
                $(".allproduct_category_arrow").removeClass("arrow_rotate");
                $(".mobile_parent_arrow").removeClass("arrow_rotate");
                $(".prod").next("ul").slideUp();
            }, 400);
            return;
        };
        // Close side menu by swipe
        var touchstartXMenu = 0;
        var touchendXMenu = 0;

        var gestureZoneMenu = document.querySelector(".mobile_menu_bg");

        gestureZoneMenu.addEventListener(
            "touchstart",
            function (event) {
                touchstartXMenu = event.changedTouches[0].screenX;
            },
            false
        );

        gestureZoneMenu.addEventListener(
            "touchend",
            function (event) {
                touchendXMenu = event.changedTouches[0].screenX;
                handleGestureMenu();
            },
            false
        );

        function handleGestureMenu() {
            if (
                touchendXMenu < touchstartXMenu + 200 &&
                $(".mobile-navbar-collapse").css("left") == "0px"
            ) {
                closeSideMenu();
            }
        }
        // Phone block action
        const openPhoneBlock = () => {
            $(".mobile-navbar-phones").slideToggle();
            $(".mobile-navbar-phones_bg").fadeToggle();
            $("body").toggleClass('body_hidden');
            return;
        };
        const closePhoneBlock = () => {
            $(".mobile-navbar-phones").slideUp();
            $(".mobile-navbar-phones_bg").fadeOut();
            $("body").removeClass('body_hidden');
            return;
        };
        // Side menu event
        $(".mobile-navbar-toggle").click(function () {
            if ($(".mobile-navbar-collapse").attr("data") == "0") {
                openSideMenu();
                closePhoneBlock();
            } else {
                closeSideMenu();
            }
        });
        $(".mobile_menu_bg").click(function () {
            closeSideMenu();
        });
        // All products events
        $(".allproduct_header").click(function () {
            $(".allproduct_header_button").toggleClass(
                "allproduct_header_button_open"
            );
            $(".allproduct_collapsed").slideToggle();
        });

        // Get menu list
        $(".allproduct_category_arrow").click(function (e) {
            id = $(this).attr("data-id");
            $.ajax({
                type: "POST",
                url: "/includes/header/mobile-side-menu-fetch.php",
                data: {
                    id: id,
                    menu: "1",
                },
                success: function (data) {
                    $("#category" + id).html(data);
                },
            });
            e.stopPropagation();
            e.preventDefault();
        });
        $(".allproduct_category_arrow").click(function (e) {
            const arrowOffsetTop = e.target.offsetTop;
            const isOpened = e.target.classList.value.includes("arrow_rotate");
            id = $(this).attr("data-id");
            e.stopPropagation();
            e.preventDefault();
            if (!isOpened) {
                $(".allproduct_child").slideUp("slow");
                // Scroll to block
                setTimeout(() => {
                    $("#allproduct_child" + id).slideDown();
                }, 200);
                setTimeout(() => {
                    $(".mobile-navbar-collapse").animate({
                            scrollTop: arrowOffsetTop - 50,
                        },
                        1000
                    );
                }, 600);
                // Rotate arrow
                $(".allproduct_category_arrow").removeClass("arrow_rotate");
                $(this).addClass("arrow_rotate");
            } else {
                $(".allproduct_category_arrow").removeClass("arrow_rotate");
                $(".allproduct_child").slideUp("slow");
            }
        });
        // Collapsed more info
        $(".mobile-navbar-item_more_btn").click(function () {
            $(".mobile-navbar-item_more_block").slideToggle();
        });
        // Phones block
        $(".mobile-navbar-phones_btn").click(function () {
            closeSideMenu();
            openPhoneBlock();
        });
        $(".mobile-navbar-phones_close").click(function () {
            closePhoneBlock();
        });
        $(".mobile-navbar-phones_bg").click(function () {
            closePhoneBlock();
        });



        // Brand slider
        $("#brand-slider").slick({
            infinite: true,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            dots: true,
            lazyLoad: "ondemand",
            responsive: [{
                    breakpoint: 2000,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 1102,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });


        /*===================================================================================*/
        /*  QUANTITY
          /*===================================================================================*/
        $(".quant-input .plus").click(function () {
            var val = $(this).parent().next().val();
            val = parseInt(val) + 1;
            $(this).parent().next().val(val);
        });
        $(".quant-input .minus").click(function () {
            var val = $(this).parent().next().val();
            if (val > 0) {
                val = parseInt(val) - 1;
                $(this).parent().next().val(val);
            }
        });

        /*===================================================================================*/
        /*  WOW 
          /*===================================================================================*/
        new WOW().init();

        // Add product to cart
        $(document).on(
            "click",
            ".results_item_content_info_basket, .discount_slider_item_footer_basket, .wishlist_item_content_info_basket",
            function (e) {
                if ($(this).text().trim() === "Оформити") {
                    return (document.location = "my-cart.php");
                } else {
                    const code = e.target.attributes[3].value;
                    const price = e.target.attributes[1].value;
                    const unit = e.target.attributes[2].value;
                    const charHash = $(this).attr('data-char');
                    const isCharHash = charHash.length > 0 ? charHash : '';

                    const setActiveState = () => {
                        $(this).text("Оформити");
                        $(this).css({
                            "background-color": "#679500",
                            color: "#ffcd00",
                        });
                    };
                    setActiveState();

                    $.ajax({
                        type: "POST",
                        url: "my-cart/my-cart-no-reload.php",
                        data: {
                            pid: code,
                            price: price,
                            quant: 1,
                            unit: unit,
                            char_hash: isCharHash,
                        },
                        success: function (results) {
                            const data = results.split("|");
                            const countInBasket = data[0];
                            const sumInBasket = parseFloat(data[1]);
                            const newBasketData = data[2];

                            $(".header_second_row_basket_block").html(newBasketData);

                            $(".count").fadeIn();
                            $(".count").html(countInBasket);
                            $(".value").html(`${sumInBasket.toFixed(2)} ₴`);
                            $(".valuee").html(`${sumInBasket.toFixed(2)} ₴`);
                            $(".price_sum").html(`${sumInBasket.toFixed(2)} ₴`);
                        },
                    });
                }
            }
        );

        // Set num to wishlist
        const setWishNumToHeader = (wishCount) => {
            $(".header_wish_count_button").html(
                `<span class="header_first_row_log_block_favorite"></span> <span class='header_first_row_log_block_favorite_number header_wish_count'>${wishCount}</span>`
            );
            $(".header_wish_count_mobile_button").html(
                `<img src='assets/icon/heart_icon.svg' height='25px' alt=''><span class='wish_count header_wish_count'>${wishCount}</span>`
            );
        };

        // Wish buttom Product details
        $(document).on("click", ".product_info_buttons_wishlist", function (e) {
            const thisButton = this;
            // Buttom content
            const iconDefault =
                "<span class='product_info_buttons_wishlist_icon'></span>до закладок";
            const iconActive =
                "<span class='product_info_buttons_wishlist_icon_active_block'><span class='product_info_buttons_wishlist_icon product_info_buttons_wishlist_icon_active'></span>видалити з закладок</span>";

            const isCanLogin = e.target.attributes[3].value.trim();
            const isAdd = $(this).text().trim();
            const wishProductCode = e.target.attributes[2].value;

            const charHash = $(this).attr('data-char');
            const isCharHash = charHash.length > 0 ? charHash : '';

            // If not login
            if (isCanLogin.length === 0) {
                document.location = "login.php";
            } else {
                if (isAdd === "до закладок") {
                    // If add
                    $.ajax({
                        type: "POST",
                        url: "small_php_func/addToWishList.php",
                        data: {
                            pid: wishProductCode,
                            action: "addToWish",
                            char_hash: isCharHash,
                        },
                        success: function (wishCount) {
                            $(thisButton).html(iconActive);
                            setWishNumToHeader(wishCount);
                        },
                    });
                } else {
                    // If remove
                    $.ajax({
                        type: "POST",
                        url: "small_php_func/addToWishList.php",
                        data: {
                            pid: wishProductCode,
                            action: "removeFromWish",
                        },
                        success: function (wishCount) {
                            $(thisButton).html(iconDefault);
                            setWishNumToHeader(wishCount);
                        },
                    });
                }
            }
        });

        // Wish button Display_product_card_item.php
        $(document).on("click", ".results_item_content_info_wishList", function (e) {
            const thisButton = this;
            // Buttom content
            const activeClass = "results_item_content_info_wishList_active";
            // Active / default icon
            const iconDefault =
                '<span class="results_item_content_info_wishList_icon"></span>';
            const iconActive =
                '<span class="results_item_content_info_wishList_icon results_item_content_info_wishList_icon_active"></span>';

            const isCanLogin = e.target.attributes[3].value.trim();
            const isIconRemove = e.target.classList.value.includes(activeClass);
            const wishProductCode = e.target.attributes[2].value;

            const charHash = $(this).attr('data-char');
            const isCharHash = charHash.length > 0 ? charHash : '';

            // If not login
            if (isCanLogin.length === 0) {
                document.location = "login.php";
            } else {
                if (!isIconRemove) {
                    // If add
                    $.ajax({
                        type: "POST",
                        url: "small_php_func/addToWishList.php",
                        data: {
                            pid: wishProductCode,
                            action: "addToWish",
                            char_hash: isCharHash,
                        },
                        success: function (wishCount) {
                            $(thisButton).addClass(activeClass);
                            $(thisButton).html(iconActive);
                            setWishNumToHeader(wishCount);
                        },
                    });
                } else {
                    // If remove
                    $.ajax({
                        type: "POST",
                        url: "small_php_func/addToWishList.php",
                        data: {
                            pid: wishProductCode,
                            action: "removeFromWish",
                            char_hash: isCharHash,
                        },
                        success: function (wishCount) {
                            $(thisButton).removeClass(activeClass);
                            $(thisButton).html(iconDefault);
                            setWishNumToHeader(wishCount);
                        },
                    });
                }
            }
        });

        // Binotel
        $(".t898__wrapper").show();

        (function (d, w, s) {
            var widgetHash = "84e4xfdxtx6ysr9aacgc",
                ctw = d.createElement(s);
            ctw.type = "text/javascript";
            ctw.async = true;
            ctw.src =
                "//widgets.binotel.com/calltracking/widgets/" + widgetHash + ".js";
            var sn = d.getElementsByTagName(s)[0];
            sn.parentNode.insertBefore(ctw, sn);
        })(document, window, "script");

        (function (d, w, s) {
            var widgetHash = "6vx2kn6z4yatut1c1g65",
                gcw = d.createElement(s);
            gcw.type = "text/javascript";
            gcw.async = true;
            gcw.src = "//widgets.binotel.com/getcall/widgets/" + widgetHash + ".js";
            var sn = d.getElementsByTagName(s)[0];
            sn.parentNode.insertBefore(gcw, sn);
        })(document, window, "script");

        (function (d, w, s) {
            var widgetHash = "KAEy2FirgkorC8FpSfdv",
                bch = d.createElement(s);
            bch.type = "text/javascript";
            bch.async = true;
            bch.src = "//widgets.binotel.com/chat/widgets/" + widgetHash + ".js";
            var sn = d.getElementsByTagName(s)[0];
            sn.parentNode.insertBefore(bch, sn);
        })(document, window, "script");

        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "UA-203449652-1");


        // Subscribers form
        $(".footer_container_subscribe_button").click(function () {
            const thisButton = $(this)
            const subscribeInputVal = thisButton.prev('input').val();

            if (subscribeInputVal.length == 0) {
                return
            } else {
                $.ajax({
                    type: "POST",
                    url: "small_php_func/subscribe_user.php",
                    data: {
                        subscribers_email: subscribeInputVal,
                    },
                    success: function (result) {
                        if (result == 'Невiрний формат') {
                            $('.footer_container_subscribe_success').text('Невiрний формат');
                            $('.footer_container_subscribe_success').css('color', 'red');

                        } else {
                            thisButton.prev('input').val('');
                            $('.footer_container_subscribe_success').text('Ви підписались на розсилку');
                            $('.footer_container_subscribe_success').css('color', 'green');
                            setTimeout(() => {
                                $('.footer_container_subscribe_success').text('');
                                $('.footer_container_subscribe_success').css('color', 'transparent');
                            }, 5000);
                        }
                    },
                });
            }
        });

        // Preloader
        setTimeout(() => {
            $("body").css("overflow-y", "scroll");
            $("#preloader").animate({
                    opacity: "0",
                },
                300
            );

            setTimeout(() => {
                $("#preloader").remove();
            }, 310);
        }, 500);
    });
})(jQuery);