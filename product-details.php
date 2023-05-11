<?php 
error_reporting(0);
include('includes/pdo_config.php');
include('includes/config.php');

include 'function.php';

$product = getPidFromProductNameAndChar();

$getPid = $product['pid'];
$charHash = $product['char'];

if (strlen($getPid) === 0) {
    show404();
}

// Is exist characteristic
$prepareQuery = strlen($charHash) > 0 ? 'and `c_code` = :pid and `characteristic_uuid` = :charHash' : 'and `c_code` = :pid';
$executeQuery = strlen($charHash) > 0 ? [':pid'=> $getPid, ':charHash'=>$charHash] : [':pid'=> $getPid];

$pid = $dbh->prepare("SELECT * from products where organization='Вікар' $prepareQuery ORDER BY product_availability DESC");
$pid->execute($executeQuery);

while ($row = $pid->fetch(PDO::FETCH_LAZY)):
   $c_code         = $row['c_code'];
   $c_category_id  = $row['category'] ;
   $c_group_key    = $row['sub_сategory'];
   $c_product_key_det  = $row['product_category'];
   $c_subspec_key  = $row['product_subspec'];
   $c_product_name = $row['product_name'];
   $c_description  = $row['product_description'];
   $c_main_value   = $row['main_value'];
   $c_second_value = $row['second_value'];
   $c_price	    = $row['product_price'];
   $c_photo1		= $row['productImage1'];
   $c_photo2		= $row['productImage2'];
   $c_photo3		= $row['productImage3'];
   $c_photo4		= $row['productImage4'];
   $c_photo5		= $row['productImage5'];
   $c_photo6		= $row['productImage6'];
   $c_availability	= $row['product_availability'];
   $c_organization = $row['organization'];
   $c_attributes		= $row['attributes'];
   $c_video		= $row['product_video'];
   $c_old_price	= $row['product_old_price'];
   $c_second_price = $row['product_price_second'];
   $c_promo 		= $row['product_promotional'];
   $c_product_count 		= $row['product_count'];
   endwhile;

   $c_characteristic_uuid = $charHash;

   $get_cat_name=mysqli_query($con,"SELECT id,categoryName  from category where id='$c_category_id'");
   $get_sub_name=mysqli_query($con,"SELECT id,categoryid,subcategory_id,subcategory from subcategory where categoryid='$c_category_id' and subcategory_id='$c_group_key'");
   $get_product_name=mysqli_query($con,"SELECT id,category_id,subcategoryid,product_category_id,productcategoryname from product_category where category_id='$c_category_id' and subcategoryid='$c_group_key' and product_category_id='$c_product_key_det'");
   $get_subspec_name = mysqli_query($con,"SELECT subspecname from product_subspec where category_id='$c_category_id' and subcategoryid='$c_group_key' and product_category_id='$c_product_key_det' and product_subspec_id='$c_subspec_key'");
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <base href="<?php echo checkIsHttp() .  $_SERVER['SERVER_NAME']; ?>" />

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta property="og:title" content="<?=replaceDoubleQuote($c_product_name);?>" />
    <meta property="og:image"
        content="<?if($c_photo1=='') {echo'categoryImage/no_foto.png'; }else{echo 'images/'. $c_photo1;}?>">
    <meta property="og:description"
        content="<?=replaceDoubleQuote($c_product_name);?> ✔️ Доступна ціна ✅ В наявності. Доставка у всі регіони України. Великий асортимент товарів на будь який смак" />
    <meta name="description"
        content="<?=replaceDoubleQuote($c_product_name);?> ✔️ Доступна ціна ✅ В наявності. Доставка у всі регіони України. Великий асортимент товарів на будь який смак">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title><?= $c_product_name;?> - Купити в інтернет-магазині VIKAR</title>
    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/product_details.css">
    <link rel="stylesheet" href="assets/css/discounts_slider.css">
</head>

<body class="cnt-home" id="reload-wrapper">
    <!-- Header -->
    <?php include('includes/main-header.php');?>
    <main>
        <!-- Breadcrumbs -->
        <ul class="product_breadcrumb">
            <li>
                <a href="/">
                    Головна
                </a>
            </li>
            <li>
                <? $row = mysqli_fetch_array($get_cat_name); ?>
                <a href="category/<?= transliterate($row['categoryName'])?>">
                    <?=$row['categoryName'];?>
                </a>
            </li>
            <li>
                <?$row2 = mysqli_fetch_array($get_sub_name);?>
                <a href="sub-category/<?=transliterate($row2['subcategory'])?>">
                    <?echo $row2['subcategory'];?>
                </a>
            </li>
            <?php  
            if($c_product_key_det == 0){ echo '<li>' . "$c_product_name";?>
            </li>
            <? } else{  ?>
            <li>
                <? $row3=mysqli_fetch_array($get_product_name);?>
                <a href="product-category/<?= transliterate($row3['productcategoryname'])?>">
                    <?= $row3['productcategoryname']?>
                </a>
            </li>
            <?if (strlen($subspec_name['subspecname']) > 0) {?>
            <li>
                <? $subspec_name = mysqli_fetch_array($get_subspec_name);?>
                <a href="product-subspec/<?= transliterate($subspec_name['subspecname'])?>">
                    <?=$subspec_name['subspecname'] ?>
                </a>
            </li>
            <? } ?>
            <p>
                <? echo '<li> ' . $c_product_name . '</li>' ?>
            </p>
            </li>
            <?}?>
        </ul>
        <!-- Product header -->
        <div class="product_header">
            <div class="product_header_info">
                <!-- Product name -->
                <h1>
                    <?php echo($c_product_name)?>
                </h1>
                <!-- Product rating -->
                <div class="product_header_info_rating">
                    <?php 
                  $rawAverageRating = getAverageRating($con, $c_code);
                  $averageRating = $rawAverageRating['averageRating'];
                  $num = $rawAverageRating['num'];
               ?>
                    <!-- Rating -->
                    <span class='reviews_item_rate'>
                        <? getAverageRatingStars($averageRating) ?>
                    </span>
                    <!-- Review form -->
                    <div class="tablet_display_none">
                        <button type="button" class="scroll_to_review"
                            data-hash="reviews_block">(<?php echo htmlentities($num);?> Відгуки)
                        </button>
                        <button type="button" class="scroll_to_review" data-hash="review_form">
                            Написати вiдгук
                        </button>
                    </div>
                    <div class="tablet_display_block">
                        <button type="button" class="scroll_to_review_mobile" data-hash="reviews_block_mobile">
                            (<?php echo htmlentities($num);?> Відгуки)
                        </button>
                        <button type="button" class="scroll_to_review_mobile" data-hash="review_form_mobile">
                            Написати вiдгук
                        </button>
                    </div>
                </div>
            </div>
            <div class="tablet_display_none">
                <!-- Product code -->
                <div class="product_header_code">
                    <span>Код товару: <?php echo $c_code?></span>
                    <span id="product_header_code"
                        style="width:0px; height:0px; opacity: 0;"><?php echo $c_code?></span>
                </div>
            </div>
        </div>
        <div class="product_row">
            <div class="product_row_col">
                <!-- Image sliders -->
                <div class="product_img_container">
                    <!-- Small slider -->
                    <div class="product_img_container_slider">
                        <? if($c_photo1=='') {$c_photo1 = "no_foto.png";?>
                        <?}?>
                        <div class="product_img_container_slider_item">
                            <img src="images/<?=$c_photo1?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <? if($c_photo2==''){?>
                        <?}?>
                        <? if($c_photo2){?>
                        <div class="product_img_container_slider_item">
                            <img src="images/<?=$c_photo2?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <? if($c_photo3){?>
                        <div class="product_img_container_slider_item">
                            <img src="images/<?=$c_photo3?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <?if($c_photo4){?>
                        <div class="product_img_container_slider_item">
                            <img src="images/<?=$c_photo4?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <? if($c_photo5){?>
                        <div class="product_img_container_slider_item">
                            <img src="images/<?=$c_photo5?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <? if($c_photo6){?>
                        <div class="product_img_container_slider_item">
                            <img src="images/<?=$c_photo6?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                    </div>
                    <!-- Large single image -->
                    <div class="product_img_container_largeImg">
                        <!-- Open fullscreen slider -->
                        <button id="largeImg_zoom" type="button"></button>
                        <div class="product_img_container_largeImg_slider">
                            <? if($c_photo1=='') {$c_photo1 = "no_foto.png";?>
                            <?}?>
                            <div class="product_img_container_largeImg_slider_item">
                                <img src="images/<?=$c_photo1?>">
                            </div>
                            <? if($c_photo2==''){?>
                            <?}?>
                            <? if($c_photo2){?>
                            <div class="product_img_container_largeImg_slider_item">
                                <img src="images/<?=$c_photo2?>">
                            </div>
                            <?}?>
                            <? if($c_photo3){?>
                            <div class="product_img_container_largeImg_slider_item">
                                <img src="images/<?=$c_photo3?>">
                            </div>
                            <?}?>
                            <?if($c_photo4){?>
                            <div class="product_img_container_largeImg_slider_item">
                                <img src="images/<?=$c_photo4?>">
                            </div>
                            <?}?>
                            <? if($c_photo5){?>
                            <div class="product_img_container_largeImg_slider_item">
                                <img src="images/<?=$c_photo5?>">
                            </div>
                            <?}?>
                            <? if($c_photo6){?>
                            <div class="product_img_container_largeImg_slider_item">
                                <img src="images/<?=$c_photo6?>">
                            </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <!-- Review \ Desctription -->
                <div class="tablet_display_none">
                    <div class="product_reviewDescription">
                        <div class="product_reviewDescription_header">
                            <button type="button"
                                class="product_reviewDescription_header_btn product_reviewDescription_header_btn_active">
                                Опис товару
                            </button>

                            <?if($c_attributes !== '{}'):?>
                            <button type="button" class="product_reviewDescription_header_btn">
                                Характеристики
                            </button>
                            <?endif;?>

                            <button type="button"
                                class="product_reviewDescription_header_btn product_reviewDescription_header_btn_review">
                                Відгуки (<?php echo htmlentities($num);?>)
                            </button>
                            <?if($c_video):?>
                            <button type="button" class="product_reviewDescription_header_btn">
                                Відео
                            </button>
                            <?endif;?>
                        </div>
                        <div class="product_reviewDescription_block">
                            <!-- Description -->
                            <div id="description"
                                class="product_reviewDescription_block_item product_reviewDescription_block_item_description active">
                                <p>
                                    <?php echo $c_description?>
                                </p>
                            </div>
                            <!-- Attributes -->
                            <div id="attributes"
                                class="product_reviewDescription_block_item product_reviewDescription_block_item_attributes">
                                <?php
                        $attributesDecoded = json_decode($c_attributes, true);
                        // Read the elements of the associative array
                        $i = 0;

                        foreach($attributesDecoded as $key => $value ): 
                            $isExistFilters = false;
                            $getExistedFilters = mysqli_query($con,"SELECT * from filters_dont_show");
                            while ($rowExistedFilters = mysqli_fetch_array($getExistedFilters)){
                                if (strpos(cleanName($value['name']), $rowExistedFilters['filter_name']) !== false) {
                                    $isExistFilters = true;
                                } 
                            }
        
                            if ( $isExistFilters === true ) {
                                continue;
                            }
                        ?>

                                <div class="product_reviewDescription_block_item_attributes_row">
                                    <span>
                                        <?php echo(cleanName($value['name']).': ')?>
                                    </span>
                                    <span>
                                        <?=$value['value']?>
                                    </span>
                                </div>

                                <?endforeach?>
                            </div>

                            <!-- Review -->
                            <div id="review"
                                class="product_reviewDescription_block_item product_reviewDescription_block_item_review">
                                <div id="reviews_block" class="product_reviewDescription_block_item_reviews">
                                    <? $sql8 = mysqli_query($con,"SELECT * from productreviews where productId='$c_code'");
                              $i = 0;
                              while($row7 = mysqli_fetch_array($sql8)):
                              $i++;
                              ?>
                                    <div class="block_item_reviews_item">
                                        <!-- Name -->
                                        <span class='block_item_reviews_item_name'>
                                            <? echo ($row7['name'])?>
                                        </span>
                                        <!-- Date -->
                                        <span class='block_item_reviews_item_date'>
                                            <? $rawReviewDate = explode(" ", $row7['reviewDate']);
                                       $splitedDate =explode("-", $rawReviewDate[0]); 
                                       echo($splitedDate[2] . '.' . $splitedDate[1] . '.' . $splitedDate[0] );
                                       ?>
                                        </span>
                                        <!-- Rate -->
                                        <span class='block_item_reviews_item_rate'>
                                            <? 
                                 
                                 for ($i = 1; $i < 6 ; $i++) {
                                       if ($i <= $row7['value']) {
                                          echo('<div class="block_item_reviews_item_rate_star reviews_item_rate_star_checked"></div>');
                                       } else {
                                          echo('<div class="block_item_reviews_item_rate_star"></div>');
                                       } }
                                    ?>
                                        </span>
                                        <span class='block_item_reviews_item_text'>
                                            <? echo ($row7['review'])?>
                                        </span>
                                    </div>
                                    <?endwhile;?>
                                </div>
                                <!-- Review form -->
                                <form id="review_form" role="form" class="cnt-form" name="review" method="post"
                                    autocomplete="off">
                                    <!-- Modal Дякуємо за відгук -->
                                    <div id="review_form_success" class="product_reviewDescription_block_item_success">
                                        <div class="product_reviewDescription_block_item_success_header">
                                            <h2>
                                                Дякуємо за відгук! &#10084;
                                            </h2>
                                        </div>
                                        <span class="product_reviewDescription_block_item_success_body">
                                            Ваш відгук дуже важливий для нас
                                        </span>
                                    </div>
                                    <!-- Review form -->
                                    <div class="product_reviewDescription_block_item_review_container">
                                        <h4>
                                            Напишіть власний відгук
                                        </h4>
                                        <div class="product_reviewDescription_block_item_review_header">
                                            <h4>
                                                Оцінка:
                                            </h4>
                                            <!-- Review rating -->
                                            <div class="product_reviewDescription_block_item_review_star_container">
                                                <div class="review_star_container_star"></div>
                                                <div class="review_star_container_star"></div>
                                                <div class="review_star_container_star"></div>
                                                <div class="review_star_container_star"></div>
                                                <div class="review_star_container_star"></div>
                                            </div>
                                        </div>
                                        <div class="form_group">
                                            <label id="exampleInputReview_label" for="exampleInputReview">Відгук
                                                *</label>
                                            <textarea class="form-control" id="exampleInputReview" rows="3"
                                                name="review" required="required"></textarea>
                                        </div>
                                        <div class="product_reviewDescription_block_item_review_form">
                                            <div class="product_reviewDescription_block_item_review_form_item">
                                                <label id="exampleInputName_label" for="exampleInputName">Ваше ім'я
                                                    *</label>
                                                <input type="text" class="form-control txt" id="exampleInputName"
                                                    name="name" required="required">
                                            </div>
                                            <div class="product_reviewDescription_block_item_review_form_item">
                                                <label id="exampleInputEmail_label" for="exampleInputEmail">Email
                                                    *</label>
                                                <input type="text" class="form-control txt" id="exampleInputEmail"
                                                    name="email" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="review_form_submit"
                                        class="product_reviewDescription_block_item_submit">
                                        Залишити відгук
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- If video -->
                        <?if($c_video):?>
                        <div id="video"
                            class="product_reviewDescription_block_item product_reviewDescription_block_item_video">
                            <div class="tab-pane">
                                <p class="text" style="word-break: break-all; max-width:500px;">
                                    <?php echo $c_video;?>
                                </p>
                            </div>
                        </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
            <!-- Right info -->
            <div class='product_row_col'>
                <div class="product_info">
                    <div class="product_info_header">
                        <span class="product_info_availability">
                            <?php 
                           if($c_availability >=1 || $c_product_count >= 1) {
                              echo "В наявності"; 
                           } else{
                              echo "Уточнити наявність";
                           }
                     ?>
                        </span>
                        <div class="tablet_display_block">
                            <!-- Product code -->
                            <div class="product_header_code">
                                <span>Код товару: <?php echo $c_code?></span>
                                <span id="product_header_code"
                                    style="width:0px; height:0px; opacity: 0;"><?php echo $c_code?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Characteristics -->
                    <?
                            $get_chars=mysqli_query($con,"SELECT characteristic_uuid, product_spec, product_availability from products where c_code='$getPid'");
                            $chars_num=mysqli_num_rows($get_chars);
                            
                            if ($chars_num > 0): 
                        ?>
                    <div class="product_info_char">
                        <? while($rowChars = mysqli_fetch_array($get_chars)): 
                            $characteristic_uuid = $rowChars['characteristic_uuid']; 
                            $product_availability = $rowChars['product_availability']; 
                            // Link state 
                            $isActiveCharId = $characteristic_uuid == $charHash ? 'id="product_info_char_button_active"' : '';
                            $isDisableChar = $product_availability == 0 ? 'product_info_char_button_disable' : '';
                            $product_spec_name = $rowChars['product_spec'];
                            if (strlen($product_spec_name) > 0):
                        ?>

                        <a <?=$isActiveCharId?>
                            href="<?=generateProductDetailsUrl($c_product_name, $product_spec_name)?>"
                            class="product_info_char_button <?=$isDisableChar?>">
                            <?=$product_spec_name?>
                        </a>

                        <?endif; endwhile; ?>
                    </div>
                    <? endif; ?>


                    <!-- Pay form -->
                    <form>
                        <div class="product_info_price">
                            <?if($c_old_price >= 1):?>
                            <div class="product_info_price_row">
                                <span class="product_info_price_row_old">
                                    <span></span>
                                    <?php echo htmlentities( $c_old_price);?>
                                </span>
                                <span class="product_info_price_row_discount">
                                    <?php
                                        $sale = round($c_old_price);
                                        $price = round($c_price);
                                        (1 - $oldFigure / $newFigure) * 100;
                                        $discount = round((($sale - $price) / $sale) * 100);
                                        echo ('-' . abs(round($discount)) . '%');
                                    ?>
                                </span>
                            </div>
                            <?if ($c_category_id ==='1'):?>
                            <span class="product_info_price_main prices" data="<?=$c_second_price?>">
                                <?=$c_second_price?> грн
                            </span>
                            <? else: ?>

                            <span class="product_info_price_main prices" data="<?=$c_price?>">
                                <?=$c_price?> грн
                            </span>
                            <? endif; else:
                                if ($c_category_id ==='1'):?>
                            <span class="product_info_price_main prices" style="color: #212322;"
                                data="<?=$c_second_price?>">
                                <?=$c_second_price?> грн
                            </span>
                            <? else: ?>
                            <span class="product_info_price_main prices" style="color: #212322;" data="<?=$c_price?>">
                                <?=$c_price?> грн
                            </span>
                            <?endif;
                            endif;?>
                        </div>

                        <div class="product_info_row">
                            <!-- Count -->
                            <div class="product_info_row_count">
                                <span>Кількість:</span>
                                <div class="count_container">
                                    <input type="number" class="count_container_input quant" min="1" name="quantity"
                                        value="1">
                                    <div class="count_container_arrows">
                                        <button type="button" class="count_container_arrow_plus plus"></button>
                                        <button type="button" class="count_container_arrow_minus minus"></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Value select -->
                            <select class="product_info_select select_tb" name="product_unit">
                                <? if ($c_category_id === '1'): ?>
                                <option data="<?=$c_main_value?>" value="<?=$c_second_price, $c_main_value?>">
                                    <?=$c_main_value?>
                                </option>

                                <? if ($c_main_value !== $c_second_value): ?>
                                <option data="<?=$c_second_value?>" value="<?=$c_price, $c_second_value?>">
                                    <?=$c_second_value?>
                                </option>

                                <?endif;?>

                                <? else: ?>
                                <option data="<?=$c_main_value?>" value="<?=$c_price, $c_main_value?>">
                                    <?=$c_main_value?>
                                </option>
                                <? if ($c_main_value !== $c_second_value): ?>
                                <option data="<?=$c_second_value?>" value="<?=$c_second_price, $c_second_value?>">
                                    <?=$c_second_value?>
                                </option>
                                <?endif;?>
                                <? endif; ?>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="product_info_buttons">
                            <?php if($c_availability >=1 || $c_product_count >= 1){?>
                            <button type="button"
                                class="exampleModalLong24
                                <? if(isExistInBasket($getPid, $c_characteristic_uuid) != 'Купити') { echo('exampleModalLong24_active'); }?>"
                                data-code="<? echo($getPid);?>" data-char='<?=$c_characteristic_uuid?>'>
                                <? echo(isExistInBasket($getPid, $c_characteristic_uuid));?>
                            </button>
                            <button type="button" id="product_info_fastOrder" data-product-code="<?php echo($getPid)?>"
                                data-char='<?=$c_characteristic_uuid?>'>
                                Швидке замовлення
                            </button>
                            <?php } else {?>
                            <button type="button" class="product_info_isAvailable"
                                data-product-code="<?php echo($getPid)?>" data-char='<?=$c_characteristic_uuid?>'>
                                Уточнити наявність
                            </button>
                            <?php } ?>
                            <!-- Wish list button -->
                            <button type="button" class="product_info_buttons_wishlist"
                                data-id-wishList="<?php echo $c_code;?>" data-is-login="<?echo $_SESSION['login']?>"
                                data-char='<?=$c_characteristic_uuid?>'>
                                <!-- Get wish button content -->
                                <? $get_wishList=mysqli_query($con,"SELECT * from wishlist where userid='$_SESSION[id]'");
                           $wishNum=mysqli_num_rows($get_wishList);
                           if($wishNum == 0){
                              echo('<span class="product_info_buttons_wishlist_icon"></span> до закладок');
                           }else{
                              $isInWishListIcon = mysqli_query($con,"SELECT productId from wishlist where productId='$c_code' and characteristic_uuid='$c_characteristic_uuid' and userid='$_SESSION[id]'");
                              while ($isInWishListIconItem = mysqli_fetch_array($isInWishListIcon)) {
                                 if($c_code) {
                                    echo('<span class="product_info_buttons_wishlist_icon_active_block"><span class="product_info_buttons_wishlist_icon product_info_buttons_wishlist_icon_active"></span> видалити з закладок</span>');
                                 } 
                              };
                              echo('<span class="product_info_buttons_wishlist_icon"></span> до закладок');
                           };
                        ?>
                            </button>
                        </div>

                        <!-- Mobile share on social media, hide on desktop -->
                        <div class="tablet_display_block">
                            <div class="product_info_social">
                                <div class="product_info_social_block">
                                    <span class="product_info_social_title">
                                        Поділитись товаром
                                    </span>
                                    <?php
                              $actual_link = 'https://vikar.center'."$_SERVER[REQUEST_URI]"; 
                              $splited_name = explode(" ", $c_product_name);
                              $joined_name = implode("%20", $splited_name);
                              $facebook_link = "https://www.facebook.com/sharer/sharer.php?u=" . $actual_link;
                              $viber_link = "viber://forward?text=" . $actual_link;
                              $telegram_link = "https://t.me/share/url?url=" . $actual_link . '&text=' . $joined_name;
                              $twitter_link = "https://twitter.com/intent/tweet?text=" . $joined_name . '&url=' . $actual_link;
                           ?>
                                    <ul class="product_info_social_row">
                                        <li>
                                            <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_fb "
                                       data-url="'.$facebook_link.'">
                                    </button>';
                                    ?>
                                        </li>
                                        <li>
                                            <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_viber"
                                       data-url="'.$viber_link.'">
                                    </button>';
                                    ?>
                                        </li>
                                        <li>
                                            <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_telegram"
                                       data-url="'.$telegram_link.'">
                                    </button>';
                                    ?>
                                        </li>
                                        <li>
                                            <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_twitter"
                                       data-url="'.$twitter_link.'">
                                    </button>';
                                    ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Address dropdown -->
                        <div class="product_info_stores">
                            <span class="product_info_stores_title">Ваш магазин</span>
                            <div class="product_info_stores_block">
                                <button id="product_info_stores_btn" class="product_info_stores_btn" type="button">
                                    <span class="product_info_stores_btn_address">
                                        <?
                              $sqlAddress = mysqli_query($con,"SELECT * from stores");
                              $rowAddress = mysqli_fetch_array($sqlAddress);
                              $addressArr = $rowAddress['adres'];
                              echo($addressArr);
                              ?>
                                    </span>
                                    <span class="product_info_stores_btn_title">в наявності</span>
                                    <span class="product_info_stores_btn_arrow"></span>
                                </button>
                                <div class="product_info_stores_dropdown">
                                    <?
                              $sql7 = mysqli_query($con,"SELECT * from stores");
                              $i = 0;
                              while($row7 = mysqli_fetch_array($sql7)):
                              $i++;
                              ?>
                                    <button class="product_info_stores_dropdown_item" type="button">
                                        <span class="product_info_stores_dropdown_address">
                                            <?=$row7['adres']?>
                                        </span>
                                        <span class="product_info_stores_dropdown_title">в наявності</span>
                                    </button>
                                    <?endwhile;?>
                                </div>
                            </div>
                            <span class="product_info_stores_text">
                                Будь ласка, уточнюйте вартість та наявність товару.
                            </span>
                        </div>
                    </form>
                    <!-- Review \ Desctription show from 992px -->
                    <div class="tablet_display_block">
                        <div class="product_reviewDescription">
                            <div class="product_reviewDescription_header">
                                <button type="button"
                                    class="product_reviewDescription_header_btn_mobile product_reviewDescription_header_btn_active">
                                    Опис товару
                                </button>
                                <?if($c_attributes !== '{}'):?>
                                <button type="button" class="product_reviewDescription_header_btn_mobile">
                                    Характеристики
                                </button>
                                <?endif;?>
                                <button type="button"
                                    class="product_reviewDescription_header_btn_mobile product_reviewDescription_header_btn_review_mobile">
                                    Відгуки (<?php echo htmlentities($num);?>)
                                </button>
                                <?if($c_video):?>
                                <button type="button" class="product_reviewDescription_header_btn_mobile">
                                    Відео
                                </button>
                                <?endif;?>
                            </div>
                            <div class="product_reviewDescription_block">
                                <!-- Description -->
                                <div
                                    class="product_reviewDescription_block_item product_reviewDescription_block_item_description active">
                                    <p>
                                        <?php echo $c_description?>
                                    </p>
                                </div>
                                <!-- Attributes -->
                                <div id="attributes"
                                    class="product_reviewDescription_block_item product_reviewDescription_block_item_attributes">
                                    <?php
                              $attributesMobileDecoded = json_decode($c_attributes, true);
                           
                              foreach($attributesMobileDecoded as $key => $value ): 
                           ?>
                                    <div class="product_reviewDescription_block_item_attributes_row">
                                        <span>
                                            <?php echo(cleanName($value['name']).': ')?>
                                        </span>
                                        <span>
                                            <?=$value['value']?>
                                        </span>
                                    </div>

                                    <?endforeach?>
                                </div>

                                <!-- Reviews -->
                                <div
                                    class="product_reviewDescription_block_item product_reviewDescription_block_item_review_container_mobile">
                                    <div id="reviews_block_mobile" class="product_reviewDescription_block_item_reviews">
                                        <? $sql8 = mysqli_query($con,"SELECT * from productreviews where productId='$c_code'");
                              $i = 0;
                              while($row7 = mysqli_fetch_array($sql8)):
                              $i++;
                              ?>
                                        <div class="block_item_reviews_item">
                                            <!-- Name -->
                                            <span class='block_item_reviews_item_name'>
                                                <? echo ($row7['name'])?>
                                            </span>
                                            <!-- Date -->
                                            <span class='block_item_reviews_item_date'>
                                                <? $rawReviewDate = explode(" ", $row7['reviewDate']);
                                       $splitedDate =explode("-", $rawReviewDate[0]); 
                                       echo($splitedDate[2] . '.' . $splitedDate[1] . '.' . $splitedDate[0] );
                                       ?>
                                            </span>
                                            <!-- Rate -->
                                            <span class='block_item_reviews_item_rate'>
                                                <? for ($i = 1; $i < 6 ; $i++) {
                                       if ($i <= $row7['value']) {
                                          echo('<div class="block_item_reviews_item_rate_star reviews_item_rate_star_checked"></div>');
                                       } else {
                                          echo('<div class="block_item_reviews_item_rate_star"></div>');
                                       } }
                                    ?>
                                            </span>
                                            <span class='block_item_reviews_item_text'>
                                                <? echo ($row7['review'])?>
                                            </span>
                                        </div>
                                        <?endwhile;?>
                                    </div>
                                    <!-- Review form -->
                                    <form id="review_form_mobile" role="form" class="cnt-form" name="review"
                                        method="post" autocomplete="off">
                                        <!-- Modal Дякуємо за відгук -->
                                        <div id="review_form_success_mobile"
                                            class="product_reviewDescription_block_item_success">
                                            <div class="product_reviewDescription_block_item_success_header">
                                                <h2>
                                                    Дякуємо за відгук! &#10084;
                                                </h2>
                                            </div>
                                            <span class="product_reviewDescription_block_item_success_body">
                                                Ваш відгук дуже важливий для нас
                                            </span>
                                        </div>
                                        <!-- Review form -->
                                        <div class="product_reviewDescription_block_item_review_mobile">
                                            <h4>
                                                Напишіть власний відгук
                                            </h4>
                                            <div class="product_reviewDescription_block_item_review_header">
                                                <h4>
                                                    Оцінка:
                                                </h4>
                                                <!-- Review rating -->
                                                <div
                                                    class="product_reviewDescription_block_item_review_star_container_mobile">
                                                    <div class="review_star_container_star_mobile"></div>
                                                    <div class="review_star_container_star_mobile"></div>
                                                    <div class="review_star_container_star_mobile"></div>
                                                    <div class="review_star_container_star_mobile"></div>
                                                    <div class="review_star_container_star_mobile"></div>
                                                </div>
                                            </div>
                                            <div class="form_group">
                                                <label id="exampleInputReview_label_mobile"
                                                    for="exampleInputReview_mobile">Відгук
                                                    *</label>
                                                <textarea class="form-control" id="exampleInputReview_mobile" rows="3"
                                                    name="review" required="required"></textarea>
                                            </div>
                                            <div class="product_reviewDescription_block_item_review_form">
                                                <div class="product_reviewDescription_block_item_review_form_item">
                                                    <label id="exampleInputName_label_mobile"
                                                        for="exampleInputName_mobile">Ваше ім'я
                                                        *</label>
                                                    <input type="text" class="form-control txt"
                                                        id="exampleInputName_mobile" name="name" required="required">
                                                </div>
                                                <div class="product_reviewDescription_block_item_review_form_item">
                                                    <label id="exampleInputEmail_label_mobile"
                                                        for="exampleInputEmail_mobile">Email
                                                        *</label>
                                                    <input type="text" class="form-control txt"
                                                        id="exampleInputEmail_mobile" name="email" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="review_form_submit_mobile"
                                            class="product_reviewDescription_block_item_submit">
                                            Залишити відгук
                                        </button>
                                    </form>
                                </div>
                                <!-- If video -->
                                <?if($c_video):?>
                                <div id="video"
                                    class="product_reviewDescription_block_item product_reviewDescription_block_item_video">
                                    <div class="tab-pane">
                                        <p class="text" style="word-break: break-all; max-width:500px;">
                                            <?php echo $c_video;?>
                                        </p>
                                    </div>
                                </div>
                                <?endif;?>
                            </div>
                        </div>
                    </div>
                    <!-- Delivery -->
                    <div class="product_info_delivery">
                        <span class="product_info_delivery_title">
                            Спосіб доставки:
                        </span>
                        <?php $tommorrow = date("d")+1 .'.'.date("m"); ?>
                        <div class="product_info_delivery_item">
                            <span class="product_info_delivery_item_title before_icon_np">
                                Самовивіз з відділення «Нова Пошта»
                            </span>
                            <span class="product_info_delivery_item_date">
                                вiдправимо <?php echo($tommorrow)?>
                            </span>
                        </div>
                        <div class="product_info_delivery_item">
                            <span class="product_info_delivery_item_title before_icon_np">
                                Адресна доставка «Нова Пошта»
                            </span>
                            <span class="product_info_delivery_item_date">
                                вiдправимо <?php echo($tommorrow)?>
                            </span>
                        </div>
                        <div class="product_info_delivery_item">
                            <span class="product_info_delivery_item_title before_icon_bus">
                                Адресна доставка кур’єром «Вікар»
                            </span>
                            <span class="product_info_delivery_item_date">
                                вiдправимо <?php echo($tommorrow)?>
                            </span>
                        </div>
                        <!-- <div class="product_info_delivery_item">
                     <span class="product_info_delivery_item_title before_icon_location">
                        Самовивіз з обраного магазину
                     </span>
                     <span class="product_info_delivery_item_date">
                        Товар можна забрати завтра з 9:00 за адресою: м. Київ (м. Осокорки) вул. 53-я
                        Садова,20
                     </span>
                  </div> -->
                    </div>
                    <!-- Pay -->
                    <div class="product_info_pay">
                        <span class="product_info_pay_title">
                            Способи оплати
                        </span>
                        <span class="product_info_pay_text">
                            Готівкою в магазині / відділенні Нової Пошти
                        </span>
                        <span class="product_info_pay_text">
                            Оплата частинами від Приват Банк
                        </span>
                        <span class="product_info_pay_text">
                            Безготівковий розрахунок
                        </span>
                        <img src="./assets/icon/bank/bank_row.svg" width="260px" height="20px" alt="">
                    </div>
                    <!-- Refund -->
                    <div class="product_info_refund">
                        <span class="product_info_refund_title">
                            Гарантія та повернення:
                        </span>
                        <div class="product_info_refund_item">
                            <span>
                                Безкоштовний обмін та повернення протягом 14 днів
                            </span>
                            <span>
                                Гарантія від виробника
                            </span>
                        </div>
                    </div>
                    <!-- Share on social media for more than 992px -->
                    <div class="tablet_display_none">
                        <div class="product_info_social">
                            <div class="product_info_social_block">
                                <span class="product_info_social_title">
                                    Поділитись товаром
                                </span>
                                <?php
                           $actual_link = 'https://vikar.center'."$_SERVER[REQUEST_URI]"; 
                           $splited_name = explode(" ", $c_product_name);
                           $joined_name = implode("%20", $splited_name);
                           $facebook_link = "https://www.facebook.com/sharer/sharer.php?u=" . $actual_link;
                           $viber_link = "viber://forward?text=" . $actual_link;
                           $telegram_link = "https://t.me/share/url?url=" . $actual_link . '&text=' . $joined_name;
                           $twitter_link = "https://twitter.com/intent/tweet?text=" . $joined_name . '&url=' . $actual_link;
                           ?>
                                <ul class="product_info_social_row">
                                    <li>
                                        <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_fb "
                                       data-url="'.$facebook_link.'">
                                    </button>';
                                    ?>
                                    </li>
                                    <li>
                                        <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_viber"
                                       data-url="'.$viber_link.'">
                                    </button>';
                                    ?>
                                    </li>
                                    <li>
                                        <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_telegram"
                                       data-url="'.$telegram_link.'">
                                    </button>';
                                    ?>
                                    </li>
                                    <li>
                                        <?php echo 
                                    '<button  target="_blank" class="social_link product_info_social_row_icon_twitter"
                                       data-url="'.$twitter_link.'">
                                    </button>';
                              ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- FullScreen slider -->
    <div class="product_img_fullscreen_container">
        <div class="product_img_fullscreen_container_block">
            <button class="product_img_fullscreen_container_close" type="button"></button>
            <div class="product_img_fullscreen_header">
                <h2>
                    <?echo $c_product_name;?>
                </h2>
            </div>
            <!-- Sliders -->
            <div class="product_img_fullscreen">
                <!-- Large single image -->
                <div class="product_img_fullscreen_largeImg">
                    <div class="product_img_fullscreen_largeImg_slider">
                        <? if($c_photo1=='') {$c_photo1 = "no_foto.png";?>
                        <?}?>
                        <div class="product_img_fullscreen_largeImg_slider_item">
                            <img src="images/<?=$c_photo1?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <? if($c_photo2==''){?>
                        <?}?>
                        <? if($c_photo2){?>
                        <div class="product_img_fullscreen_largeImg_slider_item">
                            <img src="images/<?=$c_photo2?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <? if($c_photo3){?>
                        <div class="product_img_fullscreen_largeImg_slider_item">
                            <img src="images/<?=$c_photo3?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <?if($c_photo4){?>
                        <div class="product_img_fullscreen_largeImg_slider_item">
                            <img src="images/<?=$c_photo4?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <? if($c_photo5){?>
                        <div class="product_img_fullscreen_largeImg_slider_item">
                            <img src="images/<?=$c_photo5?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                        <? if($c_photo6){?>
                        <div class="product_img_fullscreen_largeImg_slider_item">
                            <img src="images/<?=$c_photo6?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                        </div>
                        <?}?>
                    </div>
                </div>
                <!-- Small navigator slider -->
                <div class="product_img_fullscreen_slider">
                    <? if($c_photo1=='') {$c_photo1 = "no_foto.png";?>
                    <?}?>
                    <div class="product_img_fullscreen_slider_item" data-id='0'>
                        <img src="images/<?=$c_photo1?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                    </div>
                    <? if($c_photo2==''){?>
                    <?}?>
                    <? if($c_photo2){?>
                    <div class="product_img_fullscreen_slider_item" data-id='1'>
                        <img src="images/<?=$c_photo2?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                    </div>
                    <?}?>
                    <? if($c_photo3){?>
                    <div class="product_img_fullscreen_slider_item" data-id='2'>
                        <img src="images/<?=$c_photo3?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                    </div>
                    <?}?>
                    <?if($c_photo4){?>
                    <div class="product_img_fullscreen_slider_item" data-id='3'>
                        <img src="images/<?=$c_photo4?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                    </div>
                    <?}?>
                    <? if($c_photo5){?>
                    <div class="product_img_fullscreen_slider_item" data-id='4'>
                        <img src="images/<?=$c_photo5?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                    </div>
                    <?}?>
                    <? if($c_photo6){?>
                    <div class="product_img_fullscreen_slider_item" data-id='5'>
                        <img src="images/<?=$c_photo6?>" alt="<?=replaceDoubleQuote($c_product_name)?>">
                    </div>
                    <?}?>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/recommend_slider.php');?>
    <?php include('includes/discounts_slider.php');?>
    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script src="assets/js/product_details.js"></script>

    <script src="assets/js/formValidation.js"></script>
    <script src="assets/js/formValidation_mobile.js"></script>
</body>

</html>