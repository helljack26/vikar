<?
include('../includes/config.php');
include('../function.php');

$session_id = $_SESSION['id'];
$wishCode = $_POST['pid'];
$wishAction = $_POST['action'];
$char_hash = $_POST['char_hash'];

// Add
if(isset($wishCode) && $wishAction =="addToWish"){
	mysqli_query($con,"INSERT into wishlist (userId,productId,characteristic_uuid) values('". $session_id."','".$wishCode."','".$char_hash."')");

	// Return wishlist count
	$get_wishCount=mysqli_query($con,"SELECT * from wishlist where userid='$session_id'");
	$wishCountNum=mysqli_num_rows($get_wishCount);
	echo $wishCountNum;
}

// Delete
if(isset($wishCode) && $wishAction =="removeFromWish") {
	mysqli_query($con,"DELETE from wishlist where productId='$wishCode' and userid='$session_id' and characteristic_uuid='$char_hash'");
	
	// Return wishlist count
	$get_wishCount=mysqli_query($con,"SELECT * from wishlist where userid='$session_id'");
	$wishCountNum=mysqli_num_rows($get_wishCount);
		echo $wishCountNum;
	}
?>