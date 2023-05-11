<?php
error_reporting(3);
include('includes/config.php');
include('function.php');

$url = $_GET['filter'];
$parts = explode(';', $url);
$real_part_1 = explode('/', $url); 
$first_part = reset($parts); // get first element
$second_part = basename($first_part); 

$filter_parse_url = filter_db_query_from_url($url);

$filter_object = $filter_parse_url['filter_object'];
$filter_db_query = $filter_parse_url['filter_db_query'];

$cat = 0;
$cid = 0;

$getParamTransName = $second_part;

$get_subcategory=mysqli_query($con,"SELECT * from subcategory");

$get_sub_row = [];
while($row_subcategory = mysqli_fetch_array($get_subcategory)){   
    $transSubCatName = transliterate($row_subcategory['subcategory']);

    $isEqual = trim($getParamTransName) == trim($transSubCatName);

    if ($isEqual) {
        $get_sub_row = $row_subcategory;
        $cat = $row_subcategory['categoryid'];
        $cid = $row_subcategory['subcategory_id'];
    } 
}

$ret2=mysqli_query($con,"SELECT * from product_category where subcategoryid='$cid' and category_id='$cat'");
$num2=mysqli_num_rows($ret2);

if($get_sub_row === []){
    show404();
}

$subCatName = $get_sub_row['subcategory'];
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

    <meta property="og:image" content="categoryImage/<?= $get_sub_row['subcategory_image']?>" />
    <meta property="og:title" content="<?=$subCatName?>" />
    <meta property="og:description" content="<?= $get_sub_row['sub_soc_description']?>" />
    <meta name="description" content="<?= $get_sub_row['sub_soc_description']?>">

    <title><?=$get_sub_row['title_google']?></title>

    <?php include('includes/links.php');?>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="icon" href="assets/images/favicon.ico">

    <link rel="stylesheet" href="assets/css/category_sub_table.css">
</head>

<body>
    <input type="hidden" id='cat' value='<?=$cat?>'>
    <input type="hidden" id='cid' value='<?=$cid?>'>
    <input type="hidden" id='product' value=''>
    <input type="hidden" id='subproduct' value=''>
    <input type="hidden" id='part1' value='<?= $real_part_1[1] ?>'>
    <input type="hidden" id='part2' value='<?= $second_part ?>'>

    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <? 
        $ret1 = mysqli_query($con,"SELECT table_list from category where id='$cat'");
        $row1=mysqli_fetch_array($ret1);
    ?>
    <? if($row1['table_list']==1 || $num2 > 0): ?>
    <!-- If sub_table or sub_category  -->
    <main class='table_category_container'>
        <!-- Breadcrumbs -->
        <ul class="table_category_container_breadcrumbs">
            <?php 
                $params = [$cat,$cid,0,0];
                echo getBreadcrumbs($con ,$params);
            ?>
        </ul>

        <?php 
            if($row1['table_list']==1){ 
                // If sub table_list
                include('includes/sub_table_list.php');
            }
        ?>
        <?php 
            if($row1['table_list']==0 && $num2>0) 
                // If sub_category
                include('includes/sub_category_list.php');
            ?>
    </main>
    <? endif; ?>


    <?php // If sub_product
    if($row1['table_list']==0 && $num2==0){ ?>
    <link rel="stylesheet" href="assets/css/product_category_withFilter.css">

    <main class="product_category_container">
        <ul class="product_category_breadcrumb">
            <?php 
                $params = [$cat,$cid,0,0];
                echo getBreadcrumbs($con ,$params);
            ?>
        </ul>
        <? include('includes/product_category_list.php');?>
    </main>

    <? } ?>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script type="text/javascript" src="assets/js/product_filters.js"></script>

</body>

</html>