<?php
require_once '../includes/config.php';
$user_email = $_POST['user_email'];

$fio = mysqli_query($con,"SELECT bonus from users where email='$user_email'");
$row = mysqli_fetch_array($fio);

echo($row['bonus']);
?>