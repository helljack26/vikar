<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
if($_POST['info_add']=='1'){
	$adres  = $_POST['address'];
	$state  = $_POST['shippingstate'];
	$city   = $_POST['shippingcity'];
	$code   = $_POST['shippingpincode'];
	$query=mysqli_query($con,"update users set shippingAddress='$adres',shippingState='$state',shippingCity='$city',shippingPincode='$code' where id='".$_SESSION['id']."'");
	if($query){
		echo 'Адреса відновлена';
	}
	exit;
}
	if($_POST['shippingaddress']){
		$shippingaddress = iconv('utf-8//IGNORE', 'utf-8//IGNORE', $_POST['shippingaddress']);
	}
	if($_POST['shippingstate']){
		$shippingstate = iconv('utf-8//IGNORE', 'utf-8//IGNORE', $_POST['shippingstate']);
	}
	if($_POST['shippingcity']){
		$shippingcity = iconv('utf-8//IGNORE', 'utf-8//IGNORE', $_POST['shippingcity']);
	}
	if($_POST['shippingpincode']){
		$shippingpincode = iconv('utf-8//IGNORE', 'utf-8//IGNORE', $_POST['shippingpincode']);
	}
	$res = mysqli_query($con,"update users set shippingState='$shippingstate',shippingAddress='$shippingaddress',shippingCity='$shippingcity',shippingPincode='$shippingpincode' where id='$_SESSION[id]'");
//select last order id for liq pay
	$select_last_id = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
if($result = $con->query($select_last_id)){
    foreach($result as $last_id){
        $userid = $last_id["id"];
    }
}
$insert_last_id = $last_id["id"]+1;
//end select liq pay  collapse_order_id, '$insert_last_id',
if (isset($_POST['submit'])) {	
foreach($_SESSION['cart'] as $id => $value){
	$id;
$data = $client->{'InformationRegister_ТовариДляСайту'}->get("Код eq '$id'")->values();
foreach($data as $key => $value):
	$c_ref_key      = $value['Номенклатура_Key'];
	$c_code         = $value['Код'];
	$c_spec_key     = $value['Характеристика_Key'];
	$c_category_id  = $value['КатегоріяНомер'] ;
	$c_group_key    = $value['ГрупаТоварівНомер'];
	$c_product_key  = $value['ВидТоварівНомер'];
	$c_product_name = $value['НоменклатураНайменування'];
	$c_description  = $value['НоменклатураТекстовийОпис'];
	$c_main_value   = $value['НоменклатураОдиницяДляЗвітів'];
	$c_second_value = $value['НоменклатураОдиницяЗберігання'];
	$c_price	    = $value['Ціна'];
	$c_kof		    = $value['НоменклатураКоефіцієнтОдиниціДляЗвітів'];
	$c_photo1		= $value['Фото1'];
	$c_photo2		= $value['Фото2'];
	$c_photo3		= $value['Фото3'];
	$c_photo4		= $value['Фото4'];
	$c_photo5		= $value['Фото5'];
	$c_photo6		= $value['Фото6'];
	$c_availability	= $value['ВНаявності'];
	$c_organization = $value['ОрганізаціяНазва'];
endforeach; 
	$totalprice=0;
	$totalqunty=0;
	foreach ($_SESSION['cart'][$id] as $key => $value) {
		$sum_price+=$value*=$c_price;
	}
}
$pay = $_POST['paymethod'];
	foreach ($_SESSION['cart'] as $n => $row) {
				$quant = $_SESSION['cart'][$n]['quantity'];
				$kof =	$_SESSION['cart'][$n]['kof'];
	//Не понятно откудава тянится 0 приходится проверят чтобы не было товара с кодом 0
				if ($quant != 0) {		
			$sql_insert = mysqli_query($con,"insert into orders (collapse_order_id,userId,productId,quantity,paymentMethod,kof,summa) values ('$insert_last_id','$_SESSION[id]','$n','$quant','$pay','$kof','$sum_price')");
				}	
			}
		unset($_SESSION['cart']);
		header('location:order-history.php');
	}
?>
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
    <title>Спосіб оплати | Vikar.center</title>

    <?php include('includes/links.php');?>
</head>

<body>
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="/">Головна</a></li>
                    <li class='active'>Спосіб оплати</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="checkout-box faq-page inner-bottom-sm">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Оберіть спосіб оплати</h2>
                        <div class="panel-group checkout-steps" id="accordion">
                            <!-- checkout-step-01  -->
                            <div class="panel panel-default checkout-step-01">
                                <!-- panel-heading -->
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                            Виберіть спосіб оплати
                                        </a>
                                    </h4>
                                </div>
                                <!-- panel-heading -->
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <!-- panel-body  -->
                                    <div class="panel-body">
                                        <form name="payment" method="post">
                                            <input type="radio" name="paymethod" value="Оплата при отриманні"> Оплата
                                            готівкою при отриманні<br>
                                            <input type="radio" name="paymethod" value="Оплата онлайн"> Оплата онлайн
                                            <span class="sum_payment"></span>

                                            <!-- <input type="radio" name="paymethod" value="Internet Banking">Інтернет-банкінг! <input type="radio" name="paymethod" value="COD" checked="checked"> COD-->
                                            <input type="hidden" name="kof" value="<?=$_POST['kof']?>" />
                                            <br>
                                            <input type="submit" value="Перейти далі" name="submit"
                                                class="btn btn-primary">
                                        </form>
                                    </div>
                                </div>
                            </div>
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
<?php }?>