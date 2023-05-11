<?php include('../includes/config.php');

if(isset($_POST['subscribers_email'])) {
	$subscribers_email = $_POST['subscribers_email'];

	if (!filter_var($subscribers_email, FILTER_VALIDATE_EMAIL)) {
		echo("Невiрний формат");
		exit;
	}else{	
		mysqli_query($con,"INSERT into subscribe(subscribers_email) values('$subscribers_email')");
		echo("Ви підписались на розсилку");
	}
}
?>
