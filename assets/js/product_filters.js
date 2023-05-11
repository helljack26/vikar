var isFiltersOn = false;

var alreadyExist = 10;
const step = 10;
var numOfData = 0;
var isScrollQuery = 0;

$(document).ready(function () {
    // Get product category path

    const cat = $("#cat").val();
    const scid = $("#cid").val();
    const product_cat = $("#product").val();
    const product_subspec = $("#subproduct").val();
    const part1 = $("#part1").val();
    const part2 = $("#part2").val();
    const max_number = $("#max_number").val();

    let currentFilterUrl = "";

    let currentPriceQuery = "";

    let isCurrentPopularSortQuery = false;

    let defaultSort = 'and product_price > 1 ORDER BY product_availability DESC'

    const getProduct = () => {
        const load_more_query = {
            start: alreadyExist,
            end: alreadyExist + step,
        }

        const isLoadMoreScrollQuery = isScrollQuery == 1 && load_more_query;
        console.log("🚀 ~ file: product_filters.js:35 ~ getProduct ~ isLoadMoreScrollQuery:", isLoadMoreScrollQuery)

        $.ajax({
            type: "POST",
            url: "/includes/product_filters/price_range.php",
            data: {
                sqlQuery: `${currentPriceQuery} ${defaultSort}`,
                isPopularSort: isCurrentPopularSortQuery,
                category: cat,
                sub_сategory: scid,
                product_category: product_cat,
                product_subspec: product_subspec,
                current_filter_url: currentFilterUrl,
                isLoadMoreScrollQuery
            },

            success: function (result) {
                if (isScrollQuery == 0) {
                    $(".product_category_row_results_block").html(result);
                    isFiltersOn = false;
                } else {
                    alreadyExist += step;
                    $(".product_category_row_results_block").append(result);
                    $('#loadMore').hide();
                    isScrollQuery = 0;
                }
            },
        });
    };

    //////////////////////// end ////////////////////////

    //////////////////////// Price range ////////////////////////
    // Min max price
    let minPrice = 0;
    let maxPrice = $(document).find("#price_range_max").val();
    // Get data from back
    const priceRangeProducts = () => {
        currentPriceQuery = "";
        if (minPrice === 0) {
            minPrice = 1;
        }
        currentPriceQuery = `and product_price BETWEEN '${minPrice}' and '${maxPrice}'`;

        getProduct();
    };

    // Change class if not default value
    const rangeButtonChangeClass = () => {
        if (minPrice > 0 || maxPrice != 100000) {
            $(document).find(".range_slider_button").removeClass("range_slider_button_disable");
        }

        if (minPrice == 0 && maxPrice == 100000) {
            $(document).find(".range_slider_button").addClass("range_slider_button_disable");
        }
    };

    // Price range slider
    (function () {
        const parentNum = document.querySelector(".range_slider_row");
        const parentRange = document.querySelector(".range_slider_row_track");
        if (!parentNum) return;
        if (!parentRange) return;

        const numberS = parentNum.querySelectorAll("input[type=number]");
        const rangeS = parentRange.querySelectorAll("input[type=range]");

        rangeS.forEach(function (el) {
            el.oninput = function () {
                var slide1 = parseFloat(rangeS[0].value),
                    slide2 = parseFloat(rangeS[1].value);

                if (slide1 > slide2) {
                    [slide1, slide2] = [slide2, slide1];
                }

                numberS[0].value = slide1;
                numberS[1].value = slide2;
                // Set input value to variable
                minPrice = slide1;
                maxPrice = slide2;
                rangeButtonChangeClass();
            };
        });

        numberS.forEach(function (el) {
            el.oninput = function () {
                var number1 = parseFloat(numberS[0].value),
                    number2 = parseFloat(numberS[1].value);

                if (number1 > number2) {
                    var tmp = number1;
                    numberS[0].value = number2;
                    numberS[1].value = tmp;
                }

                rangeS[0].value = number1;
                rangeS[1].value = number2;
                // Set input value to variable
                minPrice = number1;
                maxPrice = number2;
                rangeButtonChangeClass();
            };
        });
    })();

    // Range slider submit button
    $(document).on("click", ".range_slider_button", function (e) {
        priceRangeProducts();

        if ($(document).find(".product_filters").css("right") == "0px") {
            closeMobileFilter();
        }
    });

    const curl_path = `${part1}/${part2}`;

    const getAllCheckedCheckbox = () => {
        const allCheckbox = $(".item_hidden_list_row_checkbox:checked");

        currentFilterUrl = "";

        let currentCatType = '';

        let filter_url = '';

        for (let i = 0; i < allCheckbox.length; i++) {
            const element = allCheckbox[i];

            const filterCatType = element.getAttribute("data-cat");
            const filterType = element.getAttribute("name");
            const isNewCatType = currentCatType != filterCatType;

            if (isNewCatType) {
                currentCatType = filterCatType;

                if (currentFilterUrl) {
                    filter_url = filter_url.replace(/,$/, ";");
                }

                filter_url += `;${currentCatType}=${filterType}`;
            } else {
                filter_url += `,${filterType}`;
            }
        }

        if (filter_url) {
            filter_url = filter_url.replace(/,$/, "");
        }

        let loc = decodeURI(`${curl_path}${filter_url}`);

        currentFilterUrl = loc;

        window.history.replaceState(`${curl_path}`, "", `${loc}`);
    };

    //////////////////////// Filters type item  ////////////////////////
    $(".item_hidden_list_row_checkbox").click(function () {
        isFiltersOn = true;
        alreadyExist = 10;
        $(document).scrollTop(0);
        getAllCheckedCheckbox();
        getProduct();
    });
    //////////////////////// end ////////////////////////
    var loadMore = $('#loadMore');

    $(window).on('scroll', function (e) {
        // Disable if filter on
        console.log("🚀 ~ file: product_filters.js:242 ~ isFiltersOn:", isFiltersOn)
        if (isFiltersOn === true) {
            $('#loadMore').hide();
            return
        }
        return
        let offsetTop = loadMore[0].offsetTop - 2000;
        const offsetWindowTop = $(window).scrollTop();
        const isSeeLoader = offsetTop < offsetWindowTop;
        if (isSeeLoader === true && isScrollQuery === 0) {
            isScrollQuery = 1;
            const maxItemsNums = parseInt($(document).find('#max_number').val());
            const isShowLoader = (alreadyExist + step) < maxItemsNums || alreadyExist < maxItemsNums;

            if (isShowLoader === false && maxItemsNums <= 8) {
                $('#loadMore').hide();

            } else {
                $('#loadMore').addClass('load_more_show');
                $('#loadMore').show();
                setTimeout(() => {
                    getProduct();
                }, 2000);
            }
        }
    });

    //////////////////////// Filters item toggle //////////////////////// 
    $(".product_filters_container_item_header").click(function () {
        $(this).next(".product_filters_container_item_hidden").toggle();
        $(this)
            .children(".product_filters_container_item_header_arrow")
            .toggleClass("arrow_rotate");
    });
    //////////////////////// end ////////////////////////

    //////////////////////// Sub filters toggle ////////////////////////
    $(".item_hidden_list_more_btn").click(function () {
        const thisTextDisplay = $(this).children('span').css('display');

        if (thisTextDisplay == 'inline' || thisTextDisplay == 'block') {
            $(this).children('p').show();
            $(this).children('span').hide();
        } else {
            $(this).children('p').hide();
            $(this).children('span').show();
        }
        $(this).siblings(".item_hidden_list_row_hidden").toggle();
    });
    //////////////////////// end ////////////////////////

    //////////////////////////////////////////////// Mobile filters open ////////////////////////////////////////////////
    const openMobileFilter = () => {
        $(".product_filters").animate({
                right: "0px",
            },
            "slow"
        );
        $(".product_filters_mobile_bg").fadeIn("slow");
        $("body").css("overflow-y", "hidden");
        return;
    };
    const closeMobileFilter = () => {
        // $(".product_filters_container_header_mobile").removeClass("product_filters_container_header_mobile_open");

        $(".product_filters").animate({
                right: "-100%",
            },
            "slow"
        );
        $(".product_filters").attr("data", "0");
        $(".product_filters_mobile_bg").fadeOut("slow");
        $("body").css("overflow-y", "scroll");
        return;
    };
    // Mobile side filters button
    $(".product_filters_container_header_mobile").click(function () {
        if ($(".product_filters").attr("data") == "0") {
            openMobileFilter();
        } else {
            closeMobileFilter();
        }
    });
    // If touch opacity bg close
    $(
        ".product_filters_mobile_bg, .product_filters_container_header_icon_sidefilters"
    ).click(function () {
        closeMobileFilter();
    });

    // Swipe close side filters
    var touchstartX = 0;
    var touchendX = 0;

    var gestureZone = document.querySelector(".product_filters_mobile_bg");

    gestureZone.addEventListener(
        "touchstart",
        function (event) {
            touchstartX = event.changedTouches[0].screenX;
        },
        false
    );

    gestureZone.addEventListener(
        "touchend",
        function (event) {
            touchendX = event.changedTouches[0].screenX;
            handleGesture();
        },
        false
    );

    function handleGesture() {
        if (
            touchendX > touchstartX + 100 &&
            $(".product_filters").css("right") == "0px"
        ) {
            closeMobileFilter();
        }
    }

    //////////////////////////////////////////////// Sort dropdown ////////////////////////////////////////////////
    $(".product_category_row_results_header_sort").click(function () {
        $(".results_header_sort_dropdown").slideToggle();
    });

    // Change sort header
    $(".results_header_sort_dropdown_item").click(function (e) {
        const currentText = $(this).text();
        const currentSortType = $(this).attr("data-sort");
        const isComma = currentPriceQuery.length > 0 ? ", " : ",";

        const isExistOrderBy = 'GROUP BY product_work_name ORDER BY product_availability DESC';

        const isEmptyPrice = () => {
            if (currentPriceQuery.length == 0) {
                currentPriceQuery = '';
                currentPriceQuery = 'and product_price > 1';
            }
        }

        switch (currentSortType) {
            case "cheap":
                isCurrentPopularSortQuery = false;
                isEmptyPrice();
                defaultSort = "";
                defaultSort = `${isExistOrderBy}, product_price ASC `;
                break;
            case "expensive":
                isCurrentPopularSortQuery = false;
                isEmptyPrice();
                defaultSort = "";
                defaultSort = `${isExistOrderBy}, product_price DESC`;
                break;
            case "popular":
                isEmptyPrice();
                defaultSort = "";
                isCurrentPopularSortQuery = true;
                break;

            default:
                break;
        }
        getProduct();
        //
        $(".product_category_row_results_header_sort_text").text(currentText);
        $(".results_header_sort_dropdown").slideUp();
    });

    // Close sort dropdown if click outside
    $(document).click(function (e) {
        e.stopPropagation();
        var container = $(".product_category_row_results_header");

        //check if the clicked area is dropDown or not
        if (container.has(e.target).length === 0) {
            $(".results_header_sort_dropdown").slideUp();
        }
    });
});