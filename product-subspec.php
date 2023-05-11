<?php
session_start();
error_reporting(0);
include('includes/config.php');
include 'function.php';

$url = $_GET['filter'];

$parts = explode(';', $url);
$real_part_1 = explode('/', $url); 
$first_part = reset($parts); // get first element
$second_part = basename($first_part); 

$filter_parse_url = filter_db_query_from_url($url);

$filter_object = $filter_parse_url['filter_object'];
$filter_db_query = $filter_parse_url['filter_db_query'];

$cat=0;
$cid=0;
$product_cat=0;
$sub_product=0;

$getParamTransName= removeRootDir();

$get_prodcategory=mysqli_query($con,"SELECT * from product_subspec");

$sub_product_row = [];
while($row_prod_category = mysqli_fetch_array($get_prodcategory)){   
    $transSubCatName = transliterate($row_prod_category['subspecname']);

    $isEqual = trim($getParamTransName) == trim($transSubCatName);

    if ($isEqual) {
        $sub_product_row = $row_prod_category;
        $cat = $row_prod_category['category_id'];
        $cid = $row_prod_category['subcategoryid'];
        $product_cat = $row_prod_category['product_category_id'];
        $sub_product = $row_prod_category['product_subspec_id'];
    }
        
}

if($sub_product_row === []){
    show404();
}

$sub_product_name = $sub_product_row['subspecname'];    
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <meta property="og:image" content="categoryImage/<?echo $sub_product_row['sub_product_image']?>" />
    <meta property="og:title" content="<?=$sub_product_name?>" />
    <meta property="og:description" content="<?echo $sub_product_row['sub_product_soc_description']?>" />
    <meta name="description" content="<?echo $sub_product_row['sub_product_soc_description']?>">

    <title><?=$sub_product_name?> | Vikar.center</title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/product_category_withFilter.css">
</head>

<body>
    <input type="hidden" id='cat' value='<?=$cat?>'>
    <input type="hidden" id='cid' value='<?=$cid?>'>
    <input type="hidden" id='product' value='<?=$product_cat?>'>
    <input type="hidden" id='subproduct' value='<?=$sub_product?>'>
    <input type="hidden" id='part1' value='<?= $real_part_1[1] ?>'>
    <input type="hidden" id='part2' value='<?= $second_part ?>'>
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <main class="product_category_container">
        <!-- Breadcrumbs -->
        <ul class="product_category_breadcrumb">
            <?php 
                $params = [$cat,$cid,$product_cat,$sub_product];
                echo getBreadcrumbs($con ,$params);
            ?>
        </ul>

        <div class="product_category_row">
            <!-- Filters -->
            <? include('includes/product_filters/product_filters.php'); ?>

            <!-- Product results -->
            <div class="product_category_row_results">
                <div class="product_category_row_results_header">
                    <div class="product_category_row_results_header_row">
                        <h1>
                            <?=$sub_product_name?>
                        </h1>

                        <!-- Sort buttons -->
                        <? include('includes/product_filters/sort_button.php'); ?>
                    </div>
                </div>

                <div class="product_category_row_results_block">
                    <?php
                        $retDistinct=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_work_name
                                                        FROM products
                                                        WHERE organization='Вікар' 
                                                        AND category='$cat' 
                                                        AND sub_сategory='$cid' 
                                                        AND product_category='$product_cat'
                                                        AND product_subspec='$sub_product'
                                                        AND product_price > 1 
                                                        ORDER BY product_availability DESC
                                                        LIMIT 30
                                                        ");
                        $numDistinct=mysqli_num_rows($retDistinct);
                        $existedNames = [];
                        if($numDistinct>0):
                            $i=0;
                            while($rowDisctinct=mysqli_fetch_array($retDistinct)):   
                                $isExist = array_search($rowDisctinct['product_work_name'], $existedNames); 
                                if ($isExist === false) {
                                    $ret=mysqli_query($con,"SELECT * 
                                                            FROM products
                                                            WHERE organization='Вікар'
                                                            and c_code='$rowDisctinct[c_code]'
                                                            and characteristic_uuid='$rowDisctinct[characteristic_uuid]'");
                                    $row=mysqli_fetch_array($ret);                                                              
                                    include('includes/display_product_card_item.php');
                                    array_push($existedNames, $rowDisctinct['product_work_name']);
                                }
                            endwhile;
                        endif;
                    ?>
                </div>
                <div id='loadMore'>
                    <img src="../assets/load.gif">
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script type="text/javascript" src="assets/js/product_filters.js"></script>
    <script type="text/javascript" src="assets/js/load_more_on_scroll.js"></script>

</body>

</html>