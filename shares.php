<?php
error_reporting(0);
include('includes/config.php');
include('function.php');

$get_soc_data = mysqli_query($con,"SELECT * from social_info_pages where newid='2'");
$row_soc_data = mysqli_fetch_array($get_soc_data);

$soc_title = $row_soc_data['title'];
$soc_image = $row_soc_data['image'];
$soc_description = $row_soc_data['soc_info_description'];
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    
    <meta property="og:title" content="<?=$soc_title?>" />
    <meta property="og:image" content="information/img/<?=$soc_image?>" />
    
    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<? echo($soc_description);?>">
    
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title><?=getGoogleTitle($con,2)?></title>
    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/product_category.css">
</head>

<body>
    <!-- Header -->
    <?php include('includes/main-header.php');?>
    
    <main class="product_category_container">
        <ul class="product_category_breadcrumb">
            <li>
                <a href="/">Головна</a>
            </li>
            <li>
                Акції
            </li>
        </ul>
        <div class="product_category_row">

            <h1>Акції</h1>

            <div class="product_category_row_results">
                <?php
                    $retDistinct=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_work_name
                                                                FROM products
                                                                WHERE organization='Вікар' 
                                                                and product_promotional = '1'
                                                                ORDER BY product_availability DESC");
                    $numDistinct=mysqli_num_rows($retDistinct);
                    $existedNames = [];
                    if($numDistinct>0):
                        $i=0;
                        while($rowDisctinct=mysqli_fetch_array($retDistinct)):   
                            $isExist = array_search($rowDisctinct['product_work_name'], $existedNames); 
                            if ($isExist === false) {
                                $ret=mysqli_query($con,"SELECT * FROM products WHERE organization='Вікар' and c_code='$rowDisctinct[c_code]' and characteristic_uuid='$rowDisctinct[characteristic_uuid]'");
                                $row=mysqli_fetch_array($ret);                                                              
                                include('includes/display_product_card_item.php');
                                array_push($existedNames, $rowDisctinct['product_work_name']);
                            }
                        endwhile;
                    endif;
                ?>
            </div>
        </div>
    </main>
    
         <!-- Footer -->
    <?php include('includes/footer.php');?>

</body>

</html>