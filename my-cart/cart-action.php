<?php
require_once '../includes/config.php';
error_reporting(0);

// Счетчик для количества товаров
$i = 0; 

//Post values 
$order_time = $_POST['currentTime'];
$names = $_POST['names'];
$fiz_midlname = $_POST['fiz_midlname'];
$email = $_POST['email'];
$fiz_lastname = $_POST['fiz_lastname'];
$fiz_phone = $_POST['fiz_phone'];

$yur_code = $_POST['yur_code'];
$yur_company = $_POST['yur_company'];
$yur_phone = $_POST['yur_phone'];

$total_price = floatval($_POST['total_price']);

// Delivery
$city = $_POST['city'];
$order_department_np = $_POST['delivery'];
//1 or 2 or 3 (Самовывоз из магазина) or (Самовывоз из отделения Новой Почты) or (Курьером VIKAR по адресу)
$delivery_type = $_POST['delivery_type']; 
//1 or 2 (Наличными или картой при получении)
$paymentMethod = trim($_POST['paymetd_method']); 
$comment = trim($_POST['comment']); 
$delivery_np = $_POST['delivery_np'];


$house = $_POST['house'];
$street = $_POST['street'];
$apartment = $_POST['apartment'];
$comment = $_POST['comment'];
$osoba = $_POST['osoba'];

$password = md5($_POST['pass']);
$unit = $_POST['unit'];
// Promocode
$promocodeText = $_POST['promocodeText'];
$promocodeValue = intval($_POST['promocodeValue']);
// Text
$user_bonus = intval($_POST['bonus']);

$quantity = $_POST['quantity'];

$getLastId = mysqli_query($con,"SELECT id FROM orders ORDER BY id DESC");
$rowLastId = mysqli_fetch_array($getLastId);

$newOrderId = intval($rowLastId['id']) + 1; 

$can_pay = '1';

$isSendAuth = false;

foreach($_SESSION['cart'] as $id => $value){

    $product_code = $value['pid'];
    $char_hash = $value['char_hash'];
    
    $data_product = mysqli_query($con,"SELECT * 
                                        FROM products 
                                        WHERE organization='Вікар' 
                                        AND c_code='$product_code' 
                                        AND characteristic_uuid='$char_hash'
                                        ");
    $num=mysqli_num_rows($data_product);
    
    while ($rowConcretniy=mysqli_fetch_array($data_product)):
        $c_code         = $rowConcretniy['c_code'];
        $c_product_name = $rowConcretniy['product_name'];
        $c_main_value   = $rowConcretniy['main_value'];
        $c_second_value = $rowConcretniy['second_value'];
        $c_price        = $rowConcretniy['product_price'];
        $c_second_price = $rowConcretniy['product_price_second'];
        $c_availability  = floatval($rowConcretniy['product_availability']);
        $c_availability_second = floatval($rowConcretniy['product_availability_second']);
        $price_per_unit = 0;

        //chek input names yur or fiz
        if($osoba == '1') {
            $names = $yur_code;
            $fiz_midlname = $yur_company;
            $fiz_phone = $yur_phone;
            $fiz_lastname = '0';
        }
        
        //real price from db
        if ($unit[$i] === "1") {   
            $unit[$i] = $c_main_value;
            $price_per_unit = $c_second_price;
            $availability = $c_availability_second;
        } else {
            $unit[$i] = $c_second_value;
            $price_per_unit = $c_price;
            $availability = $c_availability;
        }
        //end price

        //if new user 
        $total_order_price = $price_per_unit * intval($quantity[$i]);

        if($paymentMethod == 'Онлайн оплата карткою (LiqPay)' && $availability < $quantity[$i]){
            $can_pay = '0';
        } elseif ($paymentMethod == 'Онлайн оплата карткою (LiqPay)' &&  $availability >= $quantity[$i]) {
            $can_pay = '1';
        } else { 
            $can_pay = '2';
        }

        $session_user_id = isset($_SESSION['id']) ? floatval($_SESSION['id']) : 0;

        $insert_order = mysqli_query($con,"INSERT INTO orders (
                                                        collapse_order_id,
                                                        userId,
                                                        productId,
                                                        quantity,
                                                        paymentMethod,
                                                        summa,
                                                        first_name,
                                                        midle_name,
                                                        email_order,
                                                        last_name,
                                                        phone_order,
                                                        city_order,
                                                        order_department_np,
                                                        delivery_type,
                                                        delivery_street,
                                                        order_house,
                                                        order_region,
                                                        track_np,
                                                        comment,
                                                        price_per_unit,
                                                        unit,
                                                        can_pay,
                                                        used_bonuses,
                                                        used_promocode,
                                                        characteristic_uuid
                                                ) VALUES ('$newOrderId',
                                                        '$session_user_id',
                                                        '$product_code',
                                                        '$quantity[$i]',
                                                        '$paymentMethod',
                                                        '$total_order_price',
                                                        '$names',
                                                        '$fiz_midlname',
                                                        '$email',
                                                        '$fiz_lastname',
                                                        '$fiz_phone',
                                                        '$city',
                                                        '$order_department_np',
                                                        '$delivery_type',
                                                        '$street',
                                                        '$house',
                                                        '$apartment',
                                                        'трек нп',
                                                        '$comment',
                                                        '$price_per_unit',
                                                        '$unit[$i]',
                                                        '$can_pay',
                                                        '$user_bonus',
                                                        '$promocodeValue',
                                                        '$char_hash'
                                                )"); 
    $i++;
    endwhile;
}

$isCanRedirect = false;
include('send_order_to_mail.php');

if ($isCanRedirect == true) :
    unset($_SESSION['cart']); 
    // If liqpay
    if ($can_pay == '1') {
        include('cart-action_liqpay.php');
        exit;
    }
    
    // else
    if ($can_pay == '0' || $can_pay == '2') :
?>
<form id="redirect_to_thanks" action="../thanks" method="post">
    <input type="hidden" name="order_id" value="<?=$newOrderId?>">
</form>
<script type="text/javascript">
document.getElementById('redirect_to_thanks').submit();
</script>

<?endif; endif; exit;?>