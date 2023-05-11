<?php 
$user_email = $_SESSION['login'];
$fio = mysqli_query($con,"SELECT name,midle_name,last_name,email,contactno from users where email='$user_email'");
$row = mysqli_fetch_array($fio);
?>

<!-- Product details popup Швидке замовлення / Взнати наявнiсть -->
<div class="product_details_popup_bg"></div>
<div id="product_details_popup">
	<form id="popup_form" class="product_details_popup_container">
		<!-- Повідомлення вiдправлено -->
		<div id="product_details_popup_success">
			<span id="product_details_popup_success_header"></span>
			<span>
				Наш менеджер зателефонує вам найближчим часом.
			</span>
		</div>

		<button class="product_details_popup_container_close" type="button"></button>

		<span id="popup_header"></span>

		<div class="product_details_popup_container_form">

			<div class="product_details_popup_container_form_row">
				<label for="name" id="product_details_popup_name_label">
					Iм'я
				</label>
				<input type="text" name="name" id="product_details_popup_name" value="<?=$_SESSION['username']?>">
			</div>

			<div class="product_details_popup_container_form_row">
				<label for="email" id="product_details_popup_email_label">
					Е-пошта
				</label>
				<input type="text" name="email" id="product_details_popup_email" value="<?=$row['email'];?>">
			</div>

			<div class="product_details_popup_container_form_row">
				<label for="phone" id="product_details_popup_phone_label">
					Телефон
				</label>
				<input type="text" name="phone" id="product_details_popup_phone" maxlength="15"
					placeholder="+38(___)_______" value="<?=$row['contactno'];?>">
			</div>

			<button id="product_details_popup_form_button" 
			data-product-code="<?php echo($_GET['pid'])?>"
			type="button"></button>

			<span id="product_details_popup_footer_form_text"></span>
		</div>
	</form>
</div>
