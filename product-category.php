<?php
error_reporting(3);
include('includes/config.php');
include 'function.php';

$url = $_GET['filter'];
$parts = explode(';', $url);
$real_part_1 = explode('/', $url); 
// get first element
$first_part = reset($parts); 
$second_part = basename($first_part); 

$filter_parse_url = filter_db_query_from_url($url);

$filter_object = $filter_parse_url['filter_object'];
$filter_db_query = $filter_parse_url['filter_db_query'];

$cat=0;
$cid=0;
$product_cat=0;
$getParamTransName = $second_part;
$get_prodcategory=mysqli_query($con,"SELECT * from product_category");

$product_row = [];
while($row_prod_category = mysqli_fetch_array($get_prodcategory)){   
    $transSubCatName = transliterate($row_prod_category['productcategoryname']);

    $isEqual = trim($getParamTransName) == trim($transSubCatName);

    if ($isEqual) {
        $product_row = $row_prod_category;
        $cat = $row_prod_category['category_id'];
        $cid = $row_prod_category['subcategoryid'];
        $product_cat = $row_prod_category['product_category_id'];
    } 
}

if($product_row === []){
   show404();
   exit;
}

$get_sub_product_row=mysqli_query($con,"SELECT * from product_subspec where category_id='$cat' and subcategoryid='$cid' and product_category_id='$product_cat' ");
$num_sub_product_row=mysqli_num_rows($get_sub_product_row);

$product_cat_name = $product_row['productcategoryname'];
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <base href="<?= checkIsHttp() .  $_SERVER['SERVER_NAME']; ?>" />

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <meta property="og:image" content="categoryImage/<?= $product_row['product_image']?>" />
    <meta property="og:title" content="<?=$product_cat_name?>" />
    <meta property="og:description" content="<?= $product_row['product_soc_description']?>" />
    <meta name="description" content="<?= $product_row['product_soc_description']?>">

    <title><?=$product_row['title_google']?></title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/product_category_withFilter.css">
</head>

<body>
    <input type="hidden" id='cat' value='<?=$cat?>'>
    <input type="hidden" id='cid' value='<?=$cid?>'>
    <input type="hidden" id='product' value='<?=$product_cat?>'>
    <input type="hidden" id='subproduct' value=''>
    <input type="hidden" id='part1' value='<?= $real_part_1[1] ?>'>
    <input type="hidden" id='part2' value='<?= $second_part ?>'>

    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <main class="product_category_container">
        <!-- Breadcrumbs -->
        <ul class="product_category_breadcrumb">
            <?php 
                $params = [$cat,$cid,$product_cat,0];
                echo getBreadcrumbs($con ,$params);
            ?>
        </ul>

        <?if ($num_sub_product_row == 0){
            include('includes/product_category_list.php');
        } else { 
            include('includes/product_category_subspec.php');
        }; ?>
    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>
    <script type="text/javascript" src="assets/js/product_filters.js"></script>

</body>

</html>