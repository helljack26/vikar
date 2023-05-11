<?php 
error_reporting(0);

include('includes/config.php');
include('function.php');

if($_SERVER['REQUEST_URI'] === '/index.php'){
    echo('<script>window.location.href = "/";</script>');
}

$get_soc_data = mysqli_query($con,"SELECT * from social_info_pages where newid='1'");
$row_soc_data = mysqli_fetch_array($get_soc_data);
$soc_title = $row_soc_data['title'];
$soc_image = $row_soc_data['image'];
$soc_description = $row_soc_data['soc_info_description'];
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <meta property="og:title" content="<?=$soc_title?>" />
    <meta property="og:image" content="information/img/<?=$soc_image?>" />

    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<? echo($soc_description);?>">

    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <meta property="og:image" content="categoryImage/no_foto.png">
    <meta name="google-site-verification" content="tz-iKO36VsJcg4-7NuZpdWcFA5ePyc11K7O-UqnlSPE" />
    <title><?=getGoogleTitle($con,1)?></title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/discounts_slider.css">



</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <main>
        <!-- Main slider -->
        <div id="main_index_slider" class="wow fadeInUp">
            <?$sql = mysqli_query($con,"SELECT * from baners");?>
            <?while($row = mysqli_fetch_array($sql)):?>
            <div class="main_index_slider_item">
                <a href="<?=$row['banner_url']?>">
                    <img src="/banerImage/<?=$row['image']?>" width="100%">
                </a>
            </div>
            <?endwhile;?>
        </div>
        <div class="main_index_header">
            <h1>VIKAR - Будівельний магазин</h1>
        </div>

        <div class="change_position_on_tablet">
            <!-- Discount slider -->
            <?php include('includes/discounts_slider.php');?>

            <!-- Categories -->
            <div class="categories_container wow fadeInUp">
                <? 
                $sql1 = mysqli_query($con,"SELECT * from category ORDER BY index_position ");  
                $id = 0;
                while($row = mysqli_fetch_array($sql1)){   
                    ++$id;
                    $position = $row['index_position'];
                    if ($row['show_index'] == '1') {
                ?>
                <a class="categories_container_item" href="category/<?=transliterate($row['categoryName'])?>">
                    <img src="./img/index_categories/<?=$row['image_url_index']?>" loading="lazy"
                        alt="Зображення категорії <?php $row['categoryName']?>">
                    <span>
                        <?php 
                            if($row['categoryName'] ==='Електроінструменти'){
                                echo 'Електро-інструменти';
                            } else {
                                echo $row['categoryName'];
                            }
                        ?>
                    </span>
                </a>
                <?}; }; ?>
            </div>
        </div>

        <!--  INFO BOXES  -->
        <div class="info_container wow fadeInUp">
            <div class="info_container_header">
                <h3>
                    Нашi переваги
                </h3>
            </div>

            <div class="info_container_row">
                <div class="info_container_item">
                    <i class="icon_dollar"></i>
                    <span class="info_container_item_title green">
                        Повернення коштів
                    </span>
                    <span class="info_container_item_text">
                        впродовж 14 днів.
                    </span>
                </div>

                <div class="info_container_item">
                    <i class="icon_truck"></i>
                    <span class="info_container_item_title orange">
                        Адресна доставка
                    </span>
                    <span class="info_container_item_text">
                        Дуже швидка
                    </span>
                </div>

                <div class="info_container_item">
                    <i class="icon_gift"></i>
                    <span class="info_container_item_title red">
                        Програма лояльності
                    </span>
                    <span class="info_container_item_text">
                        Знижки можуть досягати до 20%
                    </span>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>
    <script type="text/javascript" src="assets/js/index.js"></script>

</body>

</html>