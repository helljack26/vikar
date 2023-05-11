<?php
session_start();
error_reporting(0);
include('includes/config.php');
include 'function.php';

$cat=($_GET['scid']);
$cid=($_GET['cat']);
$product_cat=($_GET['product']);
$sub_product=($_GET['sub_product']);

?>

<?php
    $get_sub_product_row=mysqli_query($con,"SELECT * from product_spec where category_id='$cat' and subcategoryid='$cid' and product_category_id='$product_cat' and product_spec_id='$sub_product' ");
    $sub_product_row=mysqli_fetch_array($get_sub_product_row);
    $sub_product_name = $sub_product_row['subproductname'];
    
?>
<!DOCTYPE html>
<html lang="ua">

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
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <main class="product_category_container">
        <!-- Breadcrumbs -->
        <ul class="product_category_breadcrumb">
            <li>
                <a href="index.php">Головна</a>
            </li>
            <li>
                <a href="category.php?cid=<?=intval($_GET['scid'])?>">
                    <?=CategoryName($con,'category',intval($_GET['scid']),'')?>
                </a>
            </li>
            <li>
                <a href="sub-category.php?scid=<?=intval($_GET['cat'])?>&cat=<?=intval($_GET['scid'])?>">
                    <?=CategoryName($con,'subcategory',intval($_GET['cat']),intval($_GET['scid']))?>
                </a>
            </li>
            <li>
                <a href="product-category.php?scid=<?=intval($_GET['scid'])?>&cat=<?=intval($_GET['cat'])?>&product=<?=intval($_GET['product'])?>">
                    <?=CategoryName($con,'product',intval($_GET['product']),intval($_GET['cat']))?>
                </a>
            </li>
            <li>
                <?=$sub_product_name?>
            </li>
        </ul>

        <div class="product_category_row">
            <!-- Filters -->
            <? include('includes/product_filters/product_filters.php'); ?>

            <!-- Product results -->
            <div class="product_category_row_results">
                <div class="product_category_row_results_header">
                    <h1>
                        <?=$sub_product_name?>
                    </h1>

                    <div class="product_category_row_results_header_buttons">
                        <!-- Sort buttons -->
                        <div class="product_category_row_results_header_sort_container">
                            <button type="button" class="product_category_row_results_header_sort">
                                <span class="product_category_row_results_header_sort_text">
                                    Сортувати
                                </span>
                                <div class="product_category_row_results_header_sort_icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </button>

                            <div class="results_header_sort_dropdown">
                                <button class="results_header_sort_dropdown_item" data-sort="cheap" type="button">
                                    Дешеві
                                </button>
                                <button class="results_header_sort_dropdown_item" data-sort="expensive" type="button">
                                    Дорогі
                                </button>
                                <button class="results_header_sort_dropdown_item" data-sort="popular" type="button">
                                    Популярні
                                </button>
                            </div>
                        </div>
                        <!-- Mobile filter button -->
                        <button type="button" class="product_filters_container_header_mobile">
                            <span>
                                Фiльтр
                            </span>
                            <div class="product_filters_container_header_mobile_icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="product_category_row_results_block">
                    <?php
			            $ret=mysqli_query($con,"SELECT * from products where category='$cat' and sub_сategory='$cid' and product_category='$product_cat' and product_spec='$sub_product' and organization='Вікар' ORDER BY product_availability DESC");
			            $num=mysqli_num_rows($ret);
			            if($num>0):
                            while ($row=mysqli_fetch_array($ret)): 
                                include('includes/display_product_card_item.php');
                            ?>
                    <? endwhile; endif; ?>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>
    <script type="text/javascript" src="assets/js/product_filters.js"></script>

</body>

</html>