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
    <meta name="description" content="<? echo($soc_description);?>">

    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title><?=getGoogleTitle($con,16)?></title>
    <?php include('includes/links.php');?>

    <link rel="stylesheet" href="assets/css/our_stores.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="body-content outer-top-xs wow fadeInUp" id="top-banner-and-menu">
        <div class="container">
            <div class="furniture-container homepage-container">
                <div class="row ">
                    <a href="#div_id" class="fancybox"></a>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <p style="text-align:center;font-size:25px;font-weight:bold;color:#8EC340;margin-top:25px;">
                            Наші магазини працюють
                        </p>
                        <div style="margin-left:10%;">
                            <?$sql = mysqli_query($con,"SELECT * from stores");
                                $i = 0;
                                while($rowStores = mysqli_fetch_array($sql)):
                                $i++;
                                ?>
                            <span class="video_store<?=$rowStores['id']?>" style="display:none;"><?=$rowStores['video']?></span>
                            <div class="outers" id="otp<?=$rowStores['id']?>">
                                <a href="stores/<?=transliterate($rowStores['adres'])?>">
                                    <img src="<?=$rowStores['logo']?>" width="200px">
                                </a>
                                <p>
                                    <a href="stores/<?=transliterate($rowStores['adres'])?>" data="<?=$rowStores['id']?>">
                                        <?=$rowStores['adres']?>
                                    </a>
                                </p>
                            </div>
                            <?endwhile;?><span class="con" style="display:none;"><?=$i?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

</body>

</html>