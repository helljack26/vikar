<?php
require_once '../includes/config.php';
include '../function.php';

$pid = $_POST['pid'];
$quant = $_POST['quant'];
$price = $_POST['price'];
$unit = $_POST['unit'];
$unit = preg_replace('/^[^а-яёa-z,]+/iu', '', $unit);
$address = $_POST['userAddress'];
$char_hash = $_POST['char_hash'];

// Set in cart
$_SESSION['cart'][$pid . $char_hash]=array("quantity" => $quant, "price" => $price, "product_unit" => $unit, "pid" => $pid, 'char_hash'=> $char_hash);	
// Set address in session
$_SESSION['delivery_address']= $address;	

// Item in basket
$itemsInBasket = count($_SESSION['cart']);
// Summ
$basket_summ = 0;
foreach ($_SESSION['cart'] as $item) {
  $basket_summ += intval($item['price'] * $item['quantity'] );
}
// New data for header basket
$basketData = '';
foreach($_SESSION['cart'] as $id => $value):
    $id;
    $num_top=count($_SESSION['cart']);
    
    if($num_top>0):
        $i=0;
        $ret=mysqli_query($con,"SELECT * from products where organization='Вікар' and c_code='$value[pid]' and characteristic_uuid='$value[char_hash]'");
        while($row_basket_top=mysqli_fetch_array($ret)):
            $c_code_top = $row_basket_top['c_code'];
            $c_product_name_top = $row_basket_top['product_name'];
            $c_photo1_top = $row_basket_top['productImage1'];
            $c_characteristic_uuid = $row_basket_top['characteristic_uuid'];
            $product_spec = $row_basket_top['product_spec'];
            $productLink = generateProductDetailsUrl($c_product_name_top, $product_spec);
            
            $totalprice = 0;
            $totalqunty = 0;
            $price_unit = $value['price'];
            $quantity = $value['quantity'];
            $product_unit = $value['product_unit'];
            $subtotal = $value['quantity'] * $price_unit;
            
            $totalprice += $subtotal;
            $_SESSION['qnty']=$totalqunty+=$quantity;
            
            $summa = ($_SESSION['tp']="$totalprice");

            // If no image set logo
            if($c_photo1_top == '') {
                $c_photo1_top = 'categoryImage/no_foto.png'; 
            } else {
                $c_photo1_top = 'images/'. htmlentities($c_photo1_top);
            }
            // New basket item
            $basketItem = "
            <li>
                <div class='cart-item product-summary'>
                    <div class='header_row'>
                        <div class='image'>
                            <a href='$productLink'>
                                <img src='$c_photo1_top' height='60px' width='70px'
                                    style='object-fit: contain;'>
                            </a>
                        </div>
                        <div style='padding-left: 10px;'>
                            <a class='name' href='$productLink'>
                                $c_product_name_top
                            </a>
                            <div class='hide_price' style='display:none'>
                                $price_unit
                            </div>
                            <div class='price'>
                                $quantity $product_unit * $price_unit грн
                            </div>
                        </div>
                    </div>
                </div>
            </li>";

// Push to basket ul
$basketData =  $basketItem . $basketData;

 endwhile; endif; endforeach; 


$basketBlock = "
<ul class='header_second_row_basket_block_ul'>
    $basketData
</ul>

<div class='cart-total'>

<div class='pull-right'>
    <span>Загалом :</span>
    <span class='price_sum' style='color:#8ec340; font-weight:700;'>00.00</span>
</div>

<a href='my-cart.php' id='header_second_row_basket_block_exist' class='header_second_row_basket_button' >
    Кошик
</a>

</div>
";

// Return results
$result = "$itemsInBasket|$basket_summ|$basketBlock";
echo($result);
?>