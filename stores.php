<?php 
session_start();
error_reporting(0);
include('includes/config.php');
include('function.php');

$get_soc_data = mysqli_query($con,"SELECT * from social_info_pages where newid='5'");
$row_soc_data = mysqli_fetch_array($get_soc_data);
$soc_title = $row_soc_data['title'];
$soc_image = $row_soc_data['image'];
$soc_description = $row_soc_data['soc_info_description'];

$idStoreItem = 0;
$rowStoreItem = [];
$getParamTransName= removeRootDir();

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$storesCorrectLink = checkIsHttp() .  $_SERVER['SERVER_NAME'] . '/stores';
$storesCorrectLink2 = checkIsHttp() .  $_SERVER['SERVER_NAME'] . '/stores/';
$storesCorrectLink3 = checkIsHttp() .  $_SERVER['SERVER_NAME'] . '/stores.php';
$storesCorrectLink4 = checkIsHttp() .  $_SERVER['SERVER_NAME'] . '/stores.php/';

if($getParamTransName !== 'stores'){
    $sql = mysqli_query($con,"SELECT * from stores");
    while($rowStore = mysqli_fetch_array($sql)){
        $transCatName = transliterate($rowStore['adres']);
        $isEqual = trim($getParamTransName) == trim($transCatName);
        if ($isEqual) {
            $idStoreItem = $rowStore['id'];
            $rowStoreItem = $rowStore;
        }
    }
}

if ($idStoreItem === 0 ) {
    if($actual_link !== $storesCorrectLink && $actual_link !==  $storesCorrectLink2 && $actual_link !== $storesCorrectLink3 && $actual_link !== $storesCorrectLink4){
        show404();
    }
}

$storesTitleId = 0;
$planeDescription = '';

switch ($idStoreItem) {
    case "1":
        $storesTitleId = 17;
        $planeDescription = 'Магазин VIKAR в Борисполі &#11088; Відмінні будівельні матеріали, інструменти та обладнання &#9742; +380670088304';
        break;
    case "2":
        $storesTitleId = 18;
        $planeDescription = 'Магазин VIKAR в Броварах &#11088; Відмінні будівельні матеріали, інструменти та обладнання &#9742; +380670088304';
        break;
    case "3":
        $storesTitleId = 19;
        $planeDescription = 'Магазин VIKAR в Києві &#11088; Відмінні будівельні матеріали, інструменти та обладнання &#9742; +380670088304';
        break;
    case "4":
        $storesTitleId = 20;
        $planeDescription= 'Магазин VIKAR у Вишневому &#11088; Відмінні будівельні матеріали, інструменти та обладнання &#9742; +380670088304';
        break;
    
    default:
        $storesTitleId = 16;
        $planeDescription = 'Наші магазини VIKAR в Борисполі, Броварах, Києві та Вишневому &#11088; Відмінні будівельні матеріали, інструменти та обладнання &#9742; +380670088304';
}
?>
<!DOCTYPE html>
<html lang="uk">

<head>

    <base href="<?php echo checkIsHttp() .  $_SERVER['SERVER_NAME']; ?>" />

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <meta property="og:title" content="<?=$soc_title?>" />
    <meta property="og:image" content="information/img/<?=$soc_image?>" />

    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<?=$planeDescription?>" />
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title><?=getGoogleTitle($con,$storesTitleId)?></title>
    <?php include('includes/links.php');?>

    <link rel="stylesheet" href="assets/css/our_stores.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="assets/css/our_stores.css">
    <link rel="stylesheet" href="assets/css/stores.css">

</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="body-content outer-top-xs wow fadeInUp" id="top-banner-and-menu">
        <div class="container">
            <div class="furniture-container homepage-container">
                <?php
                if ($idStoreItem > 0 ) {
                    
                ?>
                <div class="stores_container">
                    <h1><?=$rowStoreItem['page_header']?></h1>

                    <div class="stores_container_row">
                        <div class="stores_info">
                            <div class="stores_info_row">
                                <span class="stores_info_row_title">
                                    Адрес:
                                </span>
                                <div class="stores_info_row_text">
                                    <p><?=$rowStoreItem['adres']?></p>
                                </div>
                            </div>
                            <div class="stores_info_row">
                                <span class="stores_info_row_title">
                                    Графік роботи:
                                </span>
                                <div class="stores_info_row_text">
                                    <p><?=$rowStoreItem['time']?><br></p>
                                </div>
                            </div>
                            <div class="stores_info_row">
                                <span class="stores_info_row_title">
                                    Телефон:
                                </span>
                                <div class="stores_info_row_text">
                                    <a href="tel:<?=$rowStoreItem['phone']?>">
                                        <p><?=$rowStoreItem['phone']?><br></p>
                                    </a>
                                </div>
                            </div>
                            <div class="stores_info_row">
                                <span class="stores_info_row_title">
                                    Email:
                                </span>
                                <div class="stores_info_row_text">
                                    <span><a href="mailto:sales@vikar.center"><?=$rowStoreItem['email']?></a></span>
                                </div>
                            </div>
                        </div>
                        <span id='map'></span>
                        <span class='maps' style="display: none;"><?=$rowStoreItem['maps'];?></span>
                    </div>
                    <div class="stores_container_row">
                        <div>
                            <p><?=$rowStoreItem['description']?></p>
                        </div>
                        <div class="stores_container_row_media">
                            <div class="stores_container_row_media_images">
                                <?if($rowStoreItem['img1']!=="/img/ourstores/"):?>
                                <div class="stores_container_row_media_item">
                                    <a href="<?=$rowStoreItem['img1']?>" data-fancybox="gallery">
                                        <img class="stores_container_row_media_item_img shop_img "
                                            src="<?=$rowStoreItem['img1']?>" alt="picture 1">
                                    </a>
                                </div>
                                <?endif;?>
                                <?if($rowStoreItem['img2']!=="/img/ourstores/"):?>
                                <div class="stores_container_row_media_item">
                                    <a href="<?=$rowStoreItem['img2']?>" data-fancybox="gallery">
                                        <img class="stores_container_row_media_item_img "
                                            src="<?=$rowStoreItem['img2']?>" alt="picture 2">
                                    </a>
                                </div>
                                <?endif;?>
                                <?if($rowStoreItem['img3']!=="/img/ourstores/"):?>
                                <div class="stores_container_row_media_item"><a href="<?=$rowStoreItem['img3']?>"
                                        data-fancybox="gallery"><img class="stores_container_row_media_item_img "
                                            src="<?=$rowStoreItem['img3']?>" alt="3">
                                    </a>
                                </div>
                                <?endif;?>
                                <?if($rowStoreItem['img4']!=="/img/ourstores/"):?>
                                <div class="stores_container_row_media_item"><a href="<?=$rowStoreItem['img4']?>"
                                        data-fancybox="gallery"><img src="<?=$rowStoreItem['img4']?>"
                                            class="stores_container_row_media_item_img " alt="4">
                                    </a>
                                </div>
                                <?endif;?>
                            </div>
                            <div class="stores_container_row_media_video">
                                <p class="video"><?=$rowStoreItem['video']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="stores_container_row_stores">
                        <?$sql = mysqli_query($con,"SELECT id,adres,logo from stores")?>
                        <?while($rowStoreItem = mysqli_fetch_array($sql)):?>
                        <div class="stores_container_row_stores_item">
                            <a href="stores/<?=transliterate($rowStoreItem['adres'])?>">
                                <img width="80" src="<?=$rowStoreItem['logo']?>"></a>
                            <p>
                                <a href="stores/<?=transliterate($rowStoreItem['adres'])?>">
                                    <?=$rowStoreItem['adres']?>
                                </a>
                            </p>
                        </div>
                        <?endwhile;?>
                    </div>
                </div>
                <? } else { ?>

                <div class="row ">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1 style="text-align:center;font-size:25px;font-weight:bold;color:#8EC340;margin-top:25px;">
                            Наші магазини працюють
                        </h1>
                        <div style="margin-left:10%;">
                            <?$sql = mysqli_query($con,"SELECT * from stores");
                                $i = 0;
                                while($rowStores = mysqli_fetch_array($sql)):
                                $i++;
                            ?>
                            <div class="outers" id="otp<?=$rowStores['id']?>">
                                <a href="stores/<?=transliterate($rowStores['adres'])?>">
                                    <img src="<?=$rowStores['logo']?>" width="200px">
                                </a>
                                <p>
                                    <a href="stores/<?=transliterate($rowStores['adres'])?>"
                                        data="<?=$rowStores['id']?>">
                                        <?=$rowStores['adres']?>
                                    </a>
                                </p>
                            </div>
                            <?endwhile;?>
                        </div>
                    </div>
                </div>
                <? } ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
    $(document).ready(function() {
        $('[data-fancybox]').fancybox({
            buttons: [
                'close'
            ],
            wheel: false,
            transitionEffect: "slide",
            thumbs: false,
            loop: true,
            toolbar: false,
            clickContent: false
        });

        $("#map").html($(".maps").html());
    });
    </script>
</body>

</html>