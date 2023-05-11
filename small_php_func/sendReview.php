
<?php 
include('../includes/config.php');

if(isset($_REQUEST)) {
  $req = $_REQUEST['submit'];
	$pid=$req['productCode'];
	$value=$req['userStars'];
	$name=$req['userName'];
	$email=$req['userEmail'];
	$review=$req['userMessage'];
	$date=$req['reviewDate'];

	mysqli_query($con,"INSERT into productreviews(productId,value,name,summary,review) values('$pid','$value','$name','$email','$review')");
}
?>
