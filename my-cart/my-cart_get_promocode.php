<?php
require_once '../includes/config.php';
$user_promocode = $_POST['user_promocode'];
$getPromocode = mysqli_query($con,"SELECT * from promocode");

while ($rowPromo = mysqli_fetch_array($getPromocode)){   
    if($user_promocode === $rowPromo['promo_text']){
        echo($rowPromo['promo_discount']);
    }
}
?>