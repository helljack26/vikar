<!-- Similar products -->
<div class="discount_container wow fadeInUp">
    <div class="discount_container_header">
        <h3 class="discount_container_header_text">Рекомендованi товари</h3>
    </div>

    <div id="similar_slider" class="discount_slider">
        <?php
            $promo = $dbh->prepare('SELECT * from products  
                                    where sub_сategory= ? 
                                    and category=? 
                                    and organization="Вікар" 
                                    and product_price > 1 
                                    GROUP BY product_work_name 
                                    LIMIT 10');
                                    
            $promo->execute([$c_group_key, $c_category_id]);
            while ($row2 = $promo->fetch(PDO::FETCH_LAZY)): 	
                $c_coder         = $row2['c_code'];
                $c_category_idr  = $row2['category'];
                $c_group_keyr    = $row2['sub_сategory'];
                $c_product_keyr  = $row2['product_category'];
                $c_product_namer = $row2['product_name'];
                $c_descriptionr  = $row2['product_description'];
                $c_main_valuer   = $row2['main_value'];
                $c_second_valuer = $row2['second_value'];
                $c_pricer	    = $row2['product_price'];
                $c_photo1r		= $row2['productImage1'];
                $c_availabilityr = $row2['product_availability'];
                $c_organizationr = $row2['organization'];
                $c_videor		 = $row2['product_video'];
                $c_old_pricer	 = $row2['product_old_price'];
                $c_second_pricer = $row2['product_price_second'];
                $c_product_spec = $row['product_spec'];

                $productLink = generateProductDetailsUrl($c_product_namer, $c_product_spec);
            ?>

        <div>
            <div class="discount_slider_item">
                <div class="<?php if($row2['product_availability'] == 0 || $row2['product_count'] ==0){
                        echo('discount_slider_item_disabled');   
                    }?>">
                    <!-- If discount exist -->
                    <? if($row2['product_old_price'] !=='0.00'){?>
                    <span class="discount_slider_item_discount">
                        знижка
                        <span class="discount_slider_item_discount_value">
                            <?php
                            $sale = round($c_old_pricer);
                            $price = round($c_pricer);
                            $discount = round((($sale - $price) / $sale) * 100);
                            echo ('-' . abs(round($discount)) . '%');
                        ?>
                        </span>
                    </span>
                    <?}?>
                    <!-- Product image -->
                    <div class="discount_slider_item_image">
                        <a
                            href="<?= $productLink?>">
                            <img src="<?if($row2['productImage1']=='') {echo'categoryImage/no_foto.png'; }else{echo 'images/'.$row2['productImage1'];}?>"
                                height="210px" alt=""
                                loading="lazy"
                                >
                        </a>
                    </div>

                    <div class="discount_slider_item_info">
                        <!-- Product rating -->
                        <?php 
                            $rawDiscountAverageRating = getAverageRating($con, $c_coder);
                            $averageRating = $rawDiscountAverageRating['averageRating'];
                            $num = $rawDiscountAverageRating['num'];
                        {?>
                        <div class="discount_slider_item_info_reviews">
                            <?
                        if ($num == 0) :?>
                            <div class="reviews">
                                <a  href="<?= $productLink?>#review">
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
                                <span class="lnk">(<?php echo htmlentities($num);?> Відгуки)</span>
                            </div>
                            <? endif; ?>

                        </div>
                        <!-- Product name -->
                        <h3 class="discount_slider_item_info_name">
                            <a href="<?= $productLink?>">
                                <?php echo htmlentities($row2['product_name']);?>
                            </a>
                        </h3>
                        <!-- Product code -->
                        <span class="discount_slider_item_info_code">Код товару:
                            <span>
                                <?php echo $row2['c_code']?>
                            </span>
                        </span>
                        <?php } ?>
                        <!-- Product price -->
                        <div class="discount_slider_item_info_price">

                            <?if($row2['product_old_price']!=='0.00'):?>
                            <span class="discount_slider_item_info_price_discount">
                                <?php echo htmlentities($row2['product_old_price']);?>
                                грн.
                                <span></span>
                            </span>
                            <span class="discount_slider_item_info_price_text">
                                <?php echo htmlentities($row2['product_price']);?> грн.
                            </span>
                            <?else:?>
                            <span class="discount_slider_item_info_price_text" style="color:#212322;">
                                <?php echo htmlentities($row2['product_price']);?> грн.
                            </span>
                            <?endif;?>

                        </div>
                    </div>
                </div>

                <!-- Product buttons -->
                <div class="discount_slider_item_footer">

                    <?php if($row2['product_availability'] >=1 || $row2['product_count'] >=1){?>

                    <button type="button" data-prices="<?php echo htmlentities($row2['product_price']);?>"
                        data-unit="<?=$row2['product_price'], $row2['second_value']?>"
                        data-code="<?php echo $row2['c_code']?>"
                        data-char='<?=$row2['characteristic_uuid']?>'
                        class="discount_slider_item_footer_basket
                        <? if (isExistInBasket($row2['c_code'], $row2['characteristic_uuid']) != 'Купити') {
                                echo('discount_slider_item_footer_basket_active');
                            }?>">
                        <? echo(isExistInBasket($row2['c_code'], $row2['characteristic_uuid']));?>
                    </button>

                    <?php } else {?>

                    <button type="button" class="discount_slider_item_footer_isAvailable product_info_isAvailable"
                        data-product-code="<?php echo $row2['c_code']?>"
                        data-char='<?=$row2['characteristic_uuid']?>'
                        >
                        Уточнити наявність
                    </button>

                    <?php } ?>
                    <!-- Wishlist button -->
                    <?
                    $isInWishListRecommend = mysqli_query($con,"SELECT productId from wishlist where productId='$row2[c_code]' and characteristic_uuid='$row2[characteristic_uuid]' and userid='$_SESSION[id]'");
                    $isExistInWishRecommendList = false;

                    while ($isInWishListRecommendItem = mysqli_fetch_array($isInWishListRecommend)) {
                        if($row2['c_code']) {
                            $isExistInWishRecommendList= true;
                    } }; ?>
                    <button type="button" class="results_item_content_info_wishList
                    <?
                        if($isExistInWishRecommendList=== true) {
                            echo('results_item_content_info_wishList_active');
                        }?>" 
                        data-id-wishList="<?php echo $row2['c_code'];?>"
                        data-is-login="<?echo $_SESSION['login']?>"
                        data-char='<?=$row2['characteristic_uuid']?>'
                        >
                        <!-- Icon -->
                        <?  if($isExistInWishRecommendList=== true) {
                                echo('<span class="results_item_content_info_wishList_icon results_item_content_info_wishList_icon_active"></span>');
                            }else{
                                echo('<span class="results_item_content_info_wishList_icon"></span>');
                        }?>
                    </button>

                </div>
            </div>
        </div>
        <?php endwhile;?>
    </div>
</div>