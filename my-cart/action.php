<?
foreach ($_SESSION['cart'] as $key => $value) {
  $ids = $key ;
}
if(isset($_POST['submit'])){
		if(!empty($_SESSION['cart'])){
		foreach($_POST['quantity'] as $key => $val){
			if($val==0){
				unset($_SESSION['cart'][$key]);
			}else{
				$_SESSION['cart'][$key]['quantity']=$val;
			}
		}
		}
	}
// Code for Remove a Product from Cart
if(isset($_POST['remove_code']))
	{
if(!empty($_SESSION['cart'])){
		foreach($_POST['remove_code'] as $key){
				unset($_SESSION['cart'][$key]);
		}
			echo "<script>alert('Кошик був оновленний');</script>";
	}
}

// code for insert product in order table
if(isset($_POST['ordersubmit'])) {
	if(strlen($_SESSION['login'])==0) {   
	header('location:login.php');
	}
echo '<meta http-equiv="refresh" content="0;URL=payment-method.php" />';
exit;
}
// code for Shipping address updation
if($_SESSION['username']){$name = $_SESSION['username'];}else{$name = '';} //ім"я default
if($_SESSION['id']){
$sel = mysqli_query($con,"SELECT bonus from users where email = '$_SESSION[login]' and name='$_SESSION[username]'");
$row_bonus = mysqli_fetch_array($sel);
$bonus = $row_bonus['bonus'];} //бонуси
$city = 'Київ'; //город
$delivery = '<span style="font-size:14px;color:#8EC340;">Уточніть у менеджера</span>';
?>