<?php
session_start();
error_reporting(0);
include('includes/config.php');

$session_id = $_SESSION['id'];
if(strlen($_SESSION['login'])==0){   
    header('location:login.php');
} else { ?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>Список бажань | Vikar.center</title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/product_category.css">
</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <main class="product_category_container">
        <ul class="product_category_breadcrumb">
            <li>
                <a href="/">
                    Головна
                </a>
            </li>
            <li>
                Cписок бажань
            </li>
        </ul>

        <?php
            $get_wish=mysqli_query($con,"SELECT * from wishlist where userid='$session_id'");
            $num=mysqli_num_rows($get_wish);
        ?>
        <!-- Sub product -->
        <div class="product_category_row">
            <h1>
                Cписок бажань   <? if($num == 0){
                    echo(' пустий');
                }?>
            </h1>

            <div class="product_category_row_results">
                <? if($num>0){
                    while ($rowWish=mysqli_fetch_array($get_wish)) :
                    	$pid = $rowWish['productId'];
                        $characteristic_uuid = $rowWish['characteristic_uuid'];
                        $ret=mysqli_query($con,"SELECT * from products where organization='Вікар' and c_code='$pid' and characteristic_uuid='$characteristic_uuid'");
                        while ($row=mysqli_fetch_array($ret)):
                            include('includes/display_product_card_item.php');
                        endwhile; 
                    endwhile; 
                    };
                ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>
</body>

</html>
<?php } ?>