let alreadyExist = 30;
const step = 30;
let isCanGet = 0;
let numOfData = 0;

$(document).ready(function () {
    // Get and parse url
    const cat = $("#cat").val();
    const scid = $("#cid").val();
    const product_cat = $("#product").val();
    const product_subspec = $("#subproduct").val();


    const urlFromSearchResult = decodeURI(window.location.search).split('=');
    const isSearchResultPage = urlFromSearchResult[0] === '?search';

    // Query template
    const searchResultPageQuery = `and product_name LIKE '%${urlFromSearchResult[1]}%'`;
    let productPageQuery = `and category='${cat}' and sub_сategory='${scid}'`;

    const isProductCat = product_cat != undefined;
    if (isProductCat) {
        productPageQuery += ` and product_category ='${product_cat}'`
    }

    const isSpecProductCat = product_subspec != undefined;
    if (isSpecProductCat) {
        productPageQuery += ` and product_subspec ='${product_subspec}'`
    }

    // Define what type of page
    const loadMoreQuery = isSearchResultPage ? searchResultPageQuery : productPageQuery

    // Get num of all data
    if (numOfData == 0) {

        $.ajax({
            type: 'POST',
            url: '../small_php_func/load_more_products.php',
            data: {
                isGetNum: true,
                searchQuery: loadMoreQuery,
            },
            success: function (maxNum) {
                return numOfData = parseInt(maxNum);
            }
        });

    }

    // Scroll event
    $(window).on('scroll', function (e) {
        // Disable if filter on
        if (isFiltersOn === true) {
            $('#loadMore').hide();

            return
        }
        var loadMore = $('#loadMore');
        const offsetTop = loadMore[0].offsetTop - 2000;
        const offsetWindowTop = $(window).scrollTop();
        let isSeeLoader = offsetTop < offsetWindowTop;
        if (isSeeLoader && isCanGet === 0) {
            isCanGet = 1;
            const isShowLoader = (alreadyExist + step) < numOfData;
            if (isShowLoader === false) {
                $('#loadMore').hide();
            } else {
                $('#loadMore').show();
            }

            setTimeout(() => {
                async function asyncCall() {
                    const result = await load_more_data({
                        start: alreadyExist,
                        end: alreadyExist + step,
                        query: loadMoreQuery,
                    });
                }
                asyncCall();
            }, 2000);
        }
    });
});

function load_more_data({
    start,
    end,
    query
}) {
    return new Promise(resolve => {
        $.ajax({
            type: 'POST',
            url: '../small_php_func/load_more_products.php',
            data: {
                start: start,
                end: end,
                searchQuery: query,
            },
            success: function (data) {
                alreadyExist += step;
                $('#load_more_results').append(data);
                setTimeout(function () {
                    isCanGet = 0;
                }, 3000);
                return
            }
        });
    });
}