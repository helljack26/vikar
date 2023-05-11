<?php 
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
    require("pay/LiqPay.php");

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
    <title>Історія замовлень | Vikar.center</title>
    <link rel="stylesheet" href="assets/css/cart_details.css">

    <?php include('includes/links.php');?>
</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="/">Головна</a></li>
                    <li class='active'>Iсторiя замовлень</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content outer-top-xs">
        <div class="container" style="display: flex; flex-direction: column-reverse; margin-bottom: 60px;">
            <table class="table table-bordered">
                <tbody>

                    <?php
                        $payment_order_select = mysqli_query($con,"SELECT *, SUM(summa), orderStatus from orders where userId='$_SESSION[id]' GROUP BY collapse_order_id");
                        $paymentNum = mysqli_num_rows($payment_order_select);
                        if ($paymentNum == 0) {
                            echo('<h2 style="text-align: center;">Історія замовлень порожня.</h2>'); 
                        }
                        
                        while($payment_order = mysqli_fetch_array($payment_order_select)):
                            if ($payment_order['orderStatus'] == 'Відмінений') {
                                break;
                            }
                            $order_paymentMethod = trim($payment_order['paymentMethod']);
                            $order_id = $payment_order['collapse_order_id'];
                            $can_pay = $payment_order['can_pay'];
                            
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
                            
                                // Check liqpay if exist
                                if ($order_paymentMethod == 'Онлайн оплата карткою (LiqPay)') {

                                    $liqpay = new LiqPay($public_key, $private_key);
                                    //Обращаемся к методу cnb_form указывая необходимые настройки для создания формы с кнопкой оплатить
                                    $data = array();
                                    $data['form'] = $liqpay->cnb_form(array(
                                        'version'       => '3',
                                        'amount'        => $summa,
                                        'currency'      => 'UAH',
                                        'description'   => 'Сплата за товар на суму - '.$summa,
                                        'order_id'      => $order_id,
                                        'language'		=> 'uk',
                                        'type'			=> 'donate',
                                        'result_url'	=> 'https://vikar.center/thanks.php',
                                        'server_url'	=> 'https://vikar.center/order-history.php',
                                        'action' 		=> 'pay',
                                    ));
                                    #liq pay status  
                                    $liqpay2 = new LiqPay($public_key, $private_key);
                                    $res = $liqpay2->api("request", array(
                                        'action'        => 'status',
                                        'version'       => '3',
                                        'order_id'      => $order_id
                                        ));
                                    #end liq pay
                                    $pay_status = $res->result;
                                    if ($pay_status == 'error') {
                                        $pay_result = $data['form'];
                                    } else  {
                                        $pay_result = '<img src="assets/images/payed.jpg" name="btn_text">';
                                    }
                                }
                            
                        ?>
                    <div class="main_border" style='margin-bottom: 10px;'>
                        <div class="row" style="text-align: center;vertical-align: middle;font-size:22px;">
                            <div class="col-md-3" style="border-right:1px solid #8ec340;height:50px">
                                № Замовлення <?=$order_id?>
                            </div>
                            <div class="col-md-3" style="border-right:1px solid #8ec340; height:50px">
                                <a href="order-details.php?orderid=<?=$order_id?>"
                                    class="btn-upper btn btn-primary checkout-page-button">
                                    Деталі
                                </a>
                            </div>
                            <div class="col-md-3" style="border-right:1px solid #8ec340;height:50px">
                                <?=$summa?> грн.
                            </div>

                            <? if($can_pay == '1' || $can_pay == '2'){ 
                                    if ($order_paymentMethod == 'Онлайн оплата карткою (LiqPay)'){
                                        echo($pay_result);
                                    } elseif ($order_paymentMethod == 'Оплата готівкою або платіжною карткою Visa/MasterCard') {?>
                            <div class="col-md-3" style="font-size:16px;font-weight:700; color:#6ca91c;">
                                Оплата готівкою або платіжною карткою Visa/MasterCard
                            </div>
                            <?} else {?>
                            <div class="col-md-3" style="font-size:16px;font-weight:700; color:#6ca91c;">
                                По безготівковому розрахунку (рахунок-фактура)
                            </div>
                            <?}?>

                            <? } else {?>
                            <div class="col-md-3"
                                style="font-size:16px;font-weight:700; color:#6ca91c; text-align:center;">
                                Менеджер вже перевіряє наявність, чекайте на дзвінок
                            </div>
                            <? } ?>

                        </div>
                    </div>
                    <?php endwhile; ?>

                </tbody>
            </table>
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
                600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' +
                top + '');
        }
    </script>
</body>

</html>
<?php } ?>