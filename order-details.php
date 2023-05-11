<?php 
error_reporting(0);
include('includes/config.php');
include('function.php');
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
    <title>Деталі замовлення | Vikar.center</title>
    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/order_details.css">
</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="/">Головна</a></li>
                    <li><a href="order-history.php">Iсторiя замовлень</a></li>
                    <li class='active'>Деталі замовлення</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="shopping-cart">
                    <?php 
                        $orderid=$_GET['orderid'];
                        $cnt=1;
                        $sql1 = mysqli_query($con,"SELECT * from orders where userId='$_SESSION[id]' and collapse_order_id='$orderid'");
                        $row_order = mysqli_fetch_array($sql1);
                        $order_id_h = $row_order['productId'];
                        $characteristic_uuid = $row_order['characteristic_uuid'];
                        
                        $order_paymentMethod = trim($row_order['paymentMethod']);
                        $summa = $row_order['summa'];
                        $order_user_name = $row_order['first_name'];
                    ?>
                    <div class="col-md-12" style="border:1px solid #8ec340; padding: 20px;">
                        <div class="text-inside">
                            Дата:<?php echo htmlentities($row_order['orderDate']); ?>
                        </div>
                        <div class="text-inside">
                            Статус:<?php echo htmlentities($row_order['orderStatus']); ?>
                        </div>
                        <div class="text-inside">
                            №:<?php echo htmlentities($row_order['collapse_order_id']); ?>
                        </div>
                        <div class="text-inside">
                            Ім'я/органiзація: <?php echo htmlentities($order_user_name)?>
                        </div>
                        <div class="text-inside">
                            тел.<?php echo htmlentities($row_order['phone_order']); ?>
                        </div>
                        <?php 
                            if($row_order['order_department_np'] !=='') {
				                echo '<div class="text-inside">' . $row_order['delivery_type'],': '. $row_order['city_order'] .'. '.   $row_order['order_department_np']  . '</div>' ; 
                            } else {
				            echo '<div class="text-inside">Місто ' . $row_order['city_order'],  ' Вул. ' . $row_order['delivery_street'], ', буд. ' .  $row_order['order_house']  . ', кв. ' .  $row_order['order_region']  . '</div>'; 
				            }
                        ?>
                        <div class="text-inside">Спосіб оплати:
                            <?php echo ($order_paymentMethod ); ?>
                        </div>

                        <? if ($order_paymentMethod == 'Онлайн оплата карткою (LiqPay)' || 
                                    $order_paymentMethod == 'По безготівковому розрахунку (рахунок-фактура)') :?>

                        <div class="text-inside">Aбо</div>
                        <div class="payment_info">
                            <span> Найменування одержувача:</span>
                            <span> ФОП Дикунець Ярослав Павлович</span>
                        </div>
                        <div class="payment_info">
                            <span> Код одержувача:</span>
                            <span> 3301500530</span>
                        </div>

                        <div class="payment_info">
                            <span> Рахунок одержувача у форматі IBAN:</span>
                            <span> UA173052990000026005030124921</span>
                        </div>
                        <?endif;?>

                    </div>

                    <div class="col-md-12 col-sm-12 shopping-cart-table ">
                        <div class="table-responsive">

                            <form name="cart" method="post">
                                <table class="table table-bordered">
                                    <div class="row" style="border-left:1px solid #8ec340;">
                                        <?php 
                                        $orderid=$_GET['orderid'];
                                        $cnt=1;
                                        
                                        $sql1 = mysqli_query($con,"SELECT * from orders where userId='$_SESSION[id]' and collapse_order_id='$orderid'");
                                        while($row1 = mysqli_fetch_array($sql1)):
                                        $order_id_h = $row1['productId'];
                                        
                                        $ret=mysqli_query($con,"SELECT * from products where organization='Вікар' and c_code='$order_id_h'  and characteristic_uuid='$characteristic_uuid'");
                                        $num=mysqli_num_rows($ret);
                                            while ($row=mysqli_fetch_array($ret)):
                                                $c_code         = $row['c_code'];
                                                $c_category_id  = $row['category'] ;
                                                $c_group_key    = $row['sub_сategory'];
                                                $c_product_key  = $row['product_category'];
                                                $c_product_name = $row['product_name'];
                                                $c_description  = $row['product_description'];
                                                $c_main_value   = $row['main_value'];
                                                $c_second_value = $row['second_value'];
                                                $c_price	    = $row['product_price'];
                                                $c_photo1		= $row['productImage1'];
                                                $c_video		= $row['product_video'];
                                                $c_old_price	= $row['product_old_price'];
                                                $c_second_price = $row['product_price_second'];
                                                $characteristic_uuid = $row['characteristic_uuid'];
                                                $product_spec = $row['product_spec'];
                                        ?>
                                        <div class="col-md-4"
                                            style="border-top:1px solid #8ec340; border-right:1px solid #8ec340; border-bottom:1px solid #8ec340; padding: 20px;">
                                            <div class="text-inside">
                                                <a
                                                    href="<?=generateProductDetailsUrl($c_product_name, $product_spec)?>">

                                                    <img style="object-fit: contain;" width="100" height="100" src="<? if($c_photo1=='') {
						                            	echo'categoryImage/no_foto.png'; 
						                            }else{
						                            	echo 'images/'.$c_photo1;}?>" alt="<?=$c_product_name?>"
                                                        title="<?=$c_product_name?>">
                                                    <div class="text-inside-second-col">
                                                        <?php echo htmlentities($c_product_name); ?>
                                                        <br>
                                                    </div>
                                                </a>
                                                <div class="text-inside-second-col">Код товару:
                                                    <?php echo htmlentities($c_code ); ?><br>
                                                    <div class="text-inside-second-col">Кількість:
                                                        <?php echo htmlentities($row1['quantity']),  ' ' . htmlentities($row1['unit']);?>.<br>

                                                        <div class="text-inside-second-col">
                                                            Ціна:
                                                            <?php echo $row1['price_per_unit'] * $row1['quantity']; ?>
                                                            грн.<br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <? endwhile; endwhile;?>
                                    </div>
                                </table>
                            </form>

                            <div class="main_border" style="margin-top: 20px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php $payment_order_select = mysqli_query($con,"SELECT  collapse_order_id, summa, can_pay, SUM(summa), used_promocode, used_bonuses from orders where userId='$_SESSION[id]' and collapse_order_id='$orderid' GROUP BY collapse_order_id"); 
                                        while($payment_order = mysqli_fetch_array($payment_order_select)){ 
	                                        $summa = floatval($payment_order['SUM(summa)']);
                                            $user_bonus = $payment_order['used_bonuses'];
                                            $promocodeValue = $payment_order['used_promocode'];

                                            if ($user_bonus > 0 && strlen($promocodeValue) == 0) {
                                                $summa = $summa - $user_bonus;
                                            };
                                            if ($user_bonus == 0 && strlen($promocodeValue) > 0) {
                                                $appliedPromocodeDiscount = $summa / 100 * $promocodeValue;
                                                $summa = $summa - $appliedPromocodeDiscount;
                                            };
                                            if ($user_bonus > 0 && strlen($promocodeValue) > 0) {
                                                $appliedPromocodeDiscount = $summa / 100 * $promocodeValue;
                                                $summa = $summa - $appliedPromocodeDiscount - $user_bonus;
                                            };
                                            ?>

                                        <? if ($user_bonus > 0 ){ ?>
                                        <div class="text-inside-second-col" style="font-size:18px;">
                                            Застосовані бонуси: <?php echo $user_bonus; ?> грн.
                                        </div>
                                        <?};
                                            if ($promocodeValue > 0) {?>
                                        <div class="text-inside-second-col" style="font-size:18px;">
                                            За промокодом знижка: <?php echo $promocodeValue; ?>%
                                        </div>

                                        <?}; ?>
                                        <div class="text-inside-second-col" style="font-size:22px;">
                                            Сума замовлення: <?php echo $summa; ?> грн.
                                        </div>
                                        <? if ($user_bonus > 0 || $promocodeValue > 0){ ?>
                                        <div class="text-inside-second-col" style="font-size:22px;">
                                            Сума замовлення без знижки:
                                            <?php echo floatval($payment_order['SUM(summa)']); ?> грн.
                                        </div>
                                        <?} } ?>
                                    </div>
                                </div>
                            </div>

                            <?php $cnt=$cnt+1;?>
                            <?
                            $num=mysqli_num_rows($sql1);
                            if($num>0){
                            $cnt=1;
                            while($row=mysqli_fetch_array($query)) { ?>
                            <form>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']);?>');"
                                                    title="Track order">
                                                    Відстежити
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $cnt=$cnt+1;} } else { ?>
                                        <tr>
                                            <td colspan="8">
                                                Ідентифікатор замовлення або ідентифікатор зареєстрованої електронної
                                                пошти недійсній
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <?php } ?>
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

    <script language="javascript" type="text/javascript">
    var popUpWin = 0;

    function popUpWindow(URLStr, left, top, width, height) {
        if (popUpWin) {
            if (!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin',
            'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' +
            600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top +
            '');
    }
    </script>
</body>

</html>