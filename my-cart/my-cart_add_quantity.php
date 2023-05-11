<?php
require_once '../includes/config.php';
$pid = $_POST['pid'];
$quant = $_POST['quant'];
$price = $_POST['price'];
$unit = $_POST['product_unit'];
$unit = preg_replace('/^[^а-яёa-z,]+/iu', '', $unit);
$char_hash = $_POST['char_hash'];

// Set in cart
$_SESSION['cart'][$pid . $char_hash]=array("quantity" => $quant,'price'=> $price, 'product_unit'=> $unit, 'pid' => $pid , 'char_hash' => $char_hash);	
?>