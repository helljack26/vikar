<?php 
error_reporting(0);
include('includes/config.php');
include('my-cart/action.php');


if($_POST['del_product']=='1'){
	$id_product = $_POST['product']; //id product
		unset($_SESSION['cart'][$id_product]); //удаляемо из сесси продукт
		exit;
}
if($_POST['checked_email']=='1'){
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo '1';
	};
    exit;
}
if($_POST['otdelenie']=='1'):
$serch = $_POST['serch'];
?>
<script>
    $(document).ready(function () {
        $(".select2-results__option").click(function () {
            $(".select2-results__option--highlighted").attr("class", "select2-results__option");
            $(".select2-results__option").css("background", "#fff");
            $(this).css("background", "#F2F2F2");
            $(".select3-selection__rendered").text($(this).text()).css("font-weight", "bold").css(
                "color", "#a59e9e");
            delivery_np = $(this).text();
            delivery = $(this).text();
            $(".opn").html("0");
            $(".adres_pochta2").css("display", "none");
            return false;
        });
    });
</script>
<?
//search city по отделение 
$code = $_POST['code'];
$cities = $np->getCity($city,$city);
$s=$serch;
	$cities = $np->getWarehouses($code);
	foreach ($cities['data'] as $city) {
		if(preg_match("/{$s}/iu", $city['Description'])) { 
		//echo "<p value='$city[Ref]'>$city[Description]</p>";
	    echo"	<li class='select2-results__option select2-results__option--highlighted' id='select2-np_office_target-x5-result-0i37-1734' role='treeitem'>
		$city[Description]
		<div class='delivery_add'></div></li>";
		}
		}
//end search отделение 
?>
<?
exit;
endif;?>
<?if($_POST['sel_city']=='2'): 
//выбираем города для Самовывоз из отделения Новой Почты
?>
<script>
    $(document).ready(function () {
        $(".select2-results__option").click(function () {
            $(".select2-results__option--highlighted").attr("class", "select2-results__option");
            $(".select2-results__option").css("background", "#fff");
            $(this).css("background", "#F2F2F2");
            $(".select3-selection__rendered").text($(this).text()).css("font-weight", "bold").css(
                "color",
                "#a59e9e");
            delivery_np = $(this).text();
            delivery = $(this).text();
            $(".opn").html("0");
            $(".adres_pochta2").css("display", "none");
            return false;
        });
    });
</script>
<? $cities = $np->getWarehouses($_POST['code_city']);

	foreach ($cities['data'] as $city):?>
<li class="select2-results__option select2-results__option--highlighted"
    id="select2-np_office_target-x5-result-0i37-1734" role="treeitem" style='display: block;'>
    <?=$city['Description']?>
    <div class="delivery_add"></div>
</li>
<?endforeach;?>
<? exit; endif;?>

<?if($_POST['sel_city']=='1'): 
    //выбираем города для Самовывоз из магазина
	?>
<script>
    $(document).ready(function () {
        $(".select2-results__option").click(function () {
            $(".select2-results__option--highlighted").attr("class", "select2-results__option");
            $(".select2-results__option").css("background", "#fff");
            $(this).css("background", "#F2F2F2");
            $(".select2-selection__rendered").text($(this).text());
            delivery_np = $(this).text();
            delivery = $(this).text();
            $(".opn").html("0");
            $(".adres_pochta").css("display", "none");
            return false;
        });
    });
</script>

<?
$sql7 = mysqli_query($con,"SELECT * from stores");
$i = 0;
while($row7 = mysqli_fetch_array($sql7)):
$i++;
?>
<li class="select2-results__option select2-results__option--highlighted"
    id="select2-np_office_target-x5-result-0i37-1734" role="treeitem">
    <?=$row7['adres']?>
    <div class="delivery_add"></div>
</li>
<?endwhile;?>
<?
	exit;
	endif;?>

<?
	if($_POST['serch']=='1'):

	$text = $_POST['text'];
	$cities = $np->getCities(0,$text);
	foreach ($cities['data'] as $city) {
		$num = count($city);
		if($num >0){
            if($city['0']['Description']==""){
                $n = $city['Description'];
                $codes = $city['Ref'];
            }else{
                $n = $city['0']['Description'];
                $codes = $city['0']['Ref'];
            }
            echo "<div style='padding-top:5px;' class='city_name' code='$codes'>$n</div>";
		}
	}
	exit;
    endif;
/* end search */
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>Кошик | Vikar.center</title>

    <?php include('includes/links.php');?>
    <link href="assets/css/my-cart.css" rel="stylesheet">
</head>

<body class="cnt-home">
    <span class="check" style="display:none;">0</span>
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="/">Головна</a></li>
                    <li class="active">Кошик</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-xs">
        <div class="row inner-bottom-sm cartCont">
            <? require_once 'my-cart/my-cart.php';?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script src="assets/js/my-cart.js"></script>

</body>

</html>