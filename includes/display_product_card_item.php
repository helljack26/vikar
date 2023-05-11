<?php
include('config.php');

$productLink = generateProductDetailsUrl($row['product_name'], $row['product_spec']);

?>
<form class="product_category_row_results_item wow fadeInUp">
    <div class="product_category_row_results_item_content ">
        <div class="<?php if($row['product_availability'] < 1 && $row['product_count'] < 1){
                echo('product_category_row_results_item_content_disabled');   
            }?>">
            <!-- If discount exist -->
            <? if($row['product_old_price'] !=='0.00'){?>
            <span class="product_category_row_results_item_content_discount">
                знижка
                <span class="product_category_row_results_item_content_discount_value">
                    <?php
                    $sale = round($row['product_old_price']);
                    $price = round($row['product_price']);
                    $discount = round((($sale - $price) / $sale) * 100);
                    echo ('-' . abs(round($discount)) . '%');
                ?>
                </span>
            </span>
            <?}?>

            <!-- Product image -->
            <div class="product_category_row_results_item_content_image">
            <a href="<?=$productLink?>">
                    <img src="<?= $row['productImage1']=='' ? 'categoryImage/no_foto.png' : 'images/'. htmlentities($row['productImage1']);?>"
                        height="210px" alt="">
                </a>
            </div>
            <!-- Product info -->
            <div class="product_category_row_results_item_content_info">
                <!-- Product rating -->
                <?php 
                    $rawDiscountAverageRating = getAverageRating($con, $row['c_code']);
                    $averageRating = $rawDiscountAverageRating['averageRating'];
                    $numReview = $rawDiscountAverageRating['num'];
                    {?>
                <div class="product_category_row_results_item_content_info_reviews">
                    <? if ($numReview == 0) :?>
                    <div class="reviews">
                        <a
                            href="<?=$productLink?>#review">
                            <span class='content_info_reviews_icon'></span>
                            Залишити відгук
                        </a>
                    </div>
                    <? else: ?>
                    <!-- Rating -->
                    <span class='reviews_item_rate'>
                        <? getAverageRatingStars($averageRating) ?>
                    </span>

                    <div class="reviews">
                        <a href="<?=$productLink?>"
                            class="lnk">
                            (<?php echo htmlentities($numReview);?> Відгуки)
                        </a>
                    </div>
                    <? endif; ?>
                </div>
                <!-- Product name -->
                <a class="product_category_row_results_item_content_info_name" style='display:block'
                    href="<?=$productLink?>"
                    >
                    <?php echo htmlentities($row['product_name']);?>
                </a>
                <!-- Product code -->
                <span class="product_category_row_results_item_content_info_code">Код товару:
                    <span>
                        <?php echo $row['c_code']?>
                    </span>
                </span>
                <?php } ?>
                <!-- Product price -->
                <div class="product_category_row_results_item_content_info_price">

                    <?if($row['product_old_price']!=='0.00'):?>
                    <span class="product_category_row_results_item_content_info_price_discount">
                        <?php echo htmlentities($row['product_old_price']);?>
                        грн.
                        <span></span>
                    </span>
                    <span class="product_category_row_results_item_content_info_price_text">
                        <?php echo htmlentities($row['product_price']);?> грн.
                    </span>
                    <?else:?>
                    <span class="product_category_row_results_item_content_info_price_text" style="color:#212322;">
                        <?php echo htmlentities($row['product_price']);?> грн.
                    </span>
                    <?endif;?>
                </div>
            </div>
        </div>

        <!-- Product buttons -->
        <div class="product_category_row_results_item_content_info_footer">
            <?php if($row['product_availability'] >=1 || $row['product_count'] >=1){?>

            <button type="button" data-prices="<?php echo htmlentities($row['product_price']);?>"
                data-unit="<?=$row['product_price'], $row['second_value']?>" data-code="<?php echo $row['c_code']?>"
                data-char='<?=$row['characteristic_uuid']?>' class="results_item_content_info_basket
                            <? if (isExistInBasket($row['c_code'], $row['characteristic_uuid']) != 'Купити') {
                                echo('results_item_content_info_basket_active');
                            }?>">
                <? echo(isExistInBasket($row['c_code'], $row['characteristic_uuid']));?>
            </button>
            <?php } else {?>
                <button type="button" class="results_item_content_info_isAvailable product_info_isAvailable"
                        data-product-code="<?php echo $row['c_code']?>" 
                        data-char='<?=$row['characteristic_uuid']?>'
                    >
                    Уточнити наявність
                </button>
            <?php } ?>

            <!-- Wishlist button -->
            <?
            $isInWishList = mysqli_query($con,"SELECT productId from wishlist where productId='$row[c_code]' and characteristic_uuid='$row[characteristic_uuid]' and userid='$_SESSION[id]'");
            $isExistInWishList = false;
            while ($isInWishListItem = mysqli_fetch_array($isInWishList)) {
                if($row['c_code']) {
                    $isExistInWishList= true;
            } }; ?>
            <button type="button" class="results_item_content_info_wishList
            <?
                if($isExistInWishList=== true) {
                    echo('results_item_content_info_wishList_active');
                }?>" data-id-wishList="<?php echo $row['c_code'];?>" data-is-login="<?=$_SESSION['login']?>"
                data-char='<?=$row['characteristic_uuid']?>'>
                <!-- Icon -->
                <?  if($isExistInWishList=== true) {
                        echo('<span class="results_item_content_info_wishList_icon results_item_content_info_wishList_icon_active"></span>');
                    }else{
                        echo('<span class="results_item_content_info_wishList_icon"></span>');
                }?>
            </button>
        </div>
    </div>
</form>