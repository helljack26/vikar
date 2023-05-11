<?php
session_start();
error_reporting(3);
include('includes/config.php');
include('function.php');

$catId = 0;

$getParamTransName= removeRootDir();

$get_category=mysqli_query($con,"SELECT * from category");

$row = [];
while($row_category = mysqli_fetch_array($get_category)){   
    $transCatName = transliterate($row_category['categoryName']);

    $isEqual = trim($getParamTransName) == trim($transCatName);

    if ($isEqual) {
        $row = $row_category;
        $catId = $row_category['id'];
    } 
}

if($row === []){
    show404();
}

$categoryName = $row['categoryName'];
$soc_title = $row['soc_title'];
$soc_description = $row['soc_description'];
$soc_image = $row['soc_image'];

?>

<!-- Get description -->
<? $retDesc=mysqli_query($con,"SELECT categoryDescription,categoryDescription2,title_google from category where id='$catId'");
    $rowDesc=mysqli_fetch_array($retDesc); 
?>
<!DOCTYPE html>
<html lang="uk">


<head>
    <base href="<?php echo checkIsHttp() .  $_SERVER['SERVER_NAME']; ?>" />

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="author" content="">
    <meta name="robots" content="all">

    <meta property="og:image" content="./img/social_media_category/<? echo($soc_image);?>" />
    <meta property="og:title" content="<? 
            if ($soc_title =='') {
               echo($categoryName);
            }else{
               echo($soc_title);
            }
            ?>" />
    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<? echo($soc_description);?>">

    <title><?=$rowDesc['title_google']?></title>
    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/category.css">
</head>

<body>
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <main class="category_container">
        <!-- Breadcrumbs -->
        <ul class="category_breadcrumb">
            <?php 
                $params = [$catId,0,0,0];
                echo getBreadcrumbs($con ,$params);
            ?>
        </ul>
        <div class="category_row">
            <!-- Category name -->
            <h1>
                <?=$categoryName?>
            </h1>

            <!-- First description -->
            <p class="category_container_description">
                <?echo $rowDesc['categoryDescription'];?>
            </p>

            <!-- Category results -->
            <div class="category_row_results">
                <?php 
               $ret=mysqli_query($con,"SELECT * from subcategory where categoryid='$catId'");
                while ($row=mysqli_fetch_array($ret)){
                
                    $nameForLink = transliterate($row['subcategory']);
                
            ?>
                <div class="category_row_results_item">
                    <!-- Image -->
                    <a class="category_row_results_item_image" href="sub-category/<?=$nameForLink?>">

                        <img src="categoryImage/<?echo $row['subcategory_image']?>" width="200" height="200">
                    </a>
                    <!-- Name -->
                    <div class="category_row_results_item_name">
                        <a href="sub-category/<?=$nameForLink?>">
                            <?php echo htmlentities($row['subcategory']);?>
                        </a>
                        <!-- Show arrow only if sub category exist -->
                        <?php
                        $ret2=mysqli_query($con,"SELECT * from product_category where subcategoryid='$row[subcategory_id]' and category_id='$catId'");
                        $num2=mysqli_num_rows($ret2);
                        if($num2 > 0): ?>
                        <!-- Mobile arrow -->
                        <button type="button" class="category_row_results_item_name_mob_arrow"
                            data-dropdown="<? echo('mobile_dropdown' . $row['subcategory_id']);?>">
                        </button>
                        <? endif; ?>
                    </div>

                    <? $i = 0;?>
                    <div class="category_row_results_item_list_container"
                        id="<? echo('mobile_dropdown'.$row['subcategory_id']);?>">
                        <div class="category_row_results_item_list">
                            <!-- Visible product category -->
                            <?php
                                $ret2=mysqli_query($con,"SELECT * from product_category where subcategoryid='$row[subcategory_id]' and category_id='$catId'");
                                $num2=mysqli_num_rows($ret2);
                                while ($row2=mysqli_fetch_array($ret2)):
                                ++$i;
                                if($i < 5): ?>
                            <a href="product-category/<?=transliterate($row2['productcategoryname'])?>">
                                <? echo($row2['productcategoryname']);?>
                            </a>
                            <? endif; endwhile;?>
                            <?php  $ret2=mysqli_query($con,"SELECT * from product_category where subcategoryid='$row[subcategory_id]' and category_id='$catId'");
                                $num2=mysqli_num_rows($ret2);
                                if($num2 > 4 ): ?>
                            <button type="button" class="category_row_results_item_list_visible_button"
                                data-dropdown="<? echo('dropdown'.$row['subcategory_id']);?>">
                                Бiльше товарiв
                            </button>
                            <? endif; ?>
                        </div>
                        <!-- Hidden product category -->
                        <div class="category_row_results_item_list_dropdown_container">
                            <div class="category_row_results_item_list_dropdown"
                                id="<? echo('dropdown'.$row['subcategory_id']);?>">
                                <?php
                                $i2 = 0;
                                while ($row2=mysqli_fetch_array($ret2)): 
                                ++$i2;
                                if($num2 > 4 && $i2 > 4):
                                ?>
                                <a href="product-category/<?=transliterate($row2['productcategoryname'])?>">
                                    <? echo($row2['productcategoryname']);?>
                                </a>
                                <? endif; endwhile;?>
                            </div>
                        </div>
                    </div>
                </div>
                <? }; ?>
            </div>

            <!-- Second description -->
            <p class="category_container_description">
                <?php echo $rowDesc['categoryDescription2'];?>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script>
    $(document).ready(function() {
        // Desktop dropdowns
        $(".category_row_results_item_list_visible_button").click(function(e) {
            const buttonClass = 'category_row_results_item_list_visible_button';
            const activeButtonClass = 'category_row_results_item_list_visible_button_rotate';

            const isOpened = e.target.classList.value.includes(activeButtonClass);
            const dataDropdown = e.target.attributes[2].value;

            if (!isOpened) {
                $(`.${buttonClass}`).removeClass(activeButtonClass)
                $(this).addClass(activeButtonClass)

                $('.category_row_results_item_list_dropdown').fadeOut();
                $(`#${dataDropdown}`).fadeIn();
            } else {
                $(`.${buttonClass}`).removeClass(activeButtonClass);
                $(`#${dataDropdown}`).fadeOut();
            }
        });

        // Mobile dropdowns
        $(".category_row_results_item_name_mob_arrow").click(function(e) {
            const buttonClass = 'category_row_results_item_name_mob_arrow';
            const activeButtonClass = 'category_row_results_item_name_mob_arrow_rotate';

            const isOpened = e.target.classList.value.includes(activeButtonClass);
            const dataDropdown = e.target.attributes[2].value;

            if (!isOpened) {
                $(`.${buttonClass}`).removeClass(activeButtonClass)
                $(this).addClass(activeButtonClass)

                $('.category_row_results_item_list_container').slideUp();
                $(`#${dataDropdown}`).slideDown();
            } else {
                $(`.${buttonClass}`).removeClass(activeButtonClass);
                $(`#${dataDropdown}`).slideUp();
            }
        });
    });
    </script>
</body>

</html>