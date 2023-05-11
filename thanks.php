<?php
header('Access-Control-Allow-Origin: *');
if(isset($_POST['data']) || isset($_POST['order_id'])) {
    include('includes/config.php');
    unset($_SESSION['cart']); 

    
    if (isset($_POST['data'])) {   
        require("pay/LiqPay.php");
        
        $data = $_POST['data'];
        $decodedData = base64_decode($data);
        // true parameter to return an associative array
        $decodedJsonData = json_decode($decodedData, true); 
        $order_id = $decodedJsonData['order_id'];
    }else{
        $order_id = $_POST['order_id'];
    }
?>
<!DOCTYPE html>

<html lang="uk">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="Vikar.center">
    <meta name="robots" content="all">
    <?include('includes/links.php');?>

    <link rel="stylesheet" href="assets/css/thanks.css">
    <title>Дякуємо за покупку ❤️ | Vikar.center</title>
</head>

<body>
    <?include('includes/main-header.php');?>
    <main>
        <div class="thanks">
            <div class="thanks_icon">
                <img src="assets/icon/my_cart_check_icon.svg" alt="">
            </div>

            <h1>
                Дякуємо за покупку!
            </h1>

            <h2>
                <span>
                    Ваше замовлення
                </span>
                <?=$order_id;?>
                <span>
                    прийнято.
                </span>
            </h2>

            <div class="thanks_texts">
                <span>
                    Підтвердження відправлено вам на e-mail.
                </span>
                <span>
                    Ми зв'яжемось з вами, якщо знадобиться уточнення інформації.
                </span>
            </div>

            <a href="/">
                Продовжити покупки
            </a>
        </div>
    </main>
    <?php include('includes/footer.php'); ?>
</body>

<? } else {
    require("function.php");
    show404();
}
?>