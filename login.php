<?php
session_start();
include('includes/config.php');
include('includes/config_google.php');
require_once 'function.php';


// Data for social media
$get_soc_data = mysqli_query($con,"SELECT * from social_info_pages where newid='4'");
$row_soc_data = mysqli_fetch_array($get_soc_data);
$soc_title = $row_soc_data['title'];
$soc_image = $row_soc_data['image'];
$soc_description = $row_soc_data['soc_info_description'];
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta property="og:title" content="<?=$soc_title?>" />
    <meta property="og:image" content="information/img/<?=$soc_image?>" />
    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<? echo($soc_description);?>">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">

    <title><?=getGoogleTitle($con,4)?></title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/login.css">

</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="/">Головна</a></li>
                    <li class='active'>Авторизація</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content outer-top-bd">
        <div class="container">
            <h1>Авторизація</h1>
            <div class="sign-in-page inner-bottom-sm">
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-6 col-sm-6 sign-in">
                        <h4 class="sign_in_header">
                            <span>
                                Увійти
                            </span>
                            <a class="sign_in_header_google" href="<?php echo $login_url;?>">
                            </a>
                        </h4>
                        <p>Привіт! Ласкаво просимо до вашого облікового запису.</p>
                        <form class="register-form outer-top-xs" method="post">
                            <span style="color:red;">
                                <?php
                                    echo htmlentities($_SESSION['errmsg']);
                                    ?>
                                <?php
                                    echo htmlentities($_SESSION['errmsg']="");
                                    ?>
                            </span>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">
                                    Адреса електронної пошти<span>*</span>
                                </label>
                                <input type="email" name="email" class="form-control unicase-form-control text-input"
                                    id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputPassword1">
                                    Пароль <span>*</span>
                                </label>
                                <div
                                    style=" height: 43px; margin-bottom: 20px; margin-right: 12px; position: relative; width: 100%;">
                                    <span class="show-pass2">
                                        <img src="img/show-pass.png">
                                    </span>
                                    <input type="password" name="password"
                                        class="form-control unicase-form-control text-input pass2"
                                        id="exampleInputPassword1">
                                </div>
                            </div>
                            <div class="radio outer-xs">
                                <a href="forgot-password.php" class="forgot-password pull-right">
                                    Забули свій пароль?
                                </a>
                            </div>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="login">
                                Увійти
                            </button>
                        </form>
                    </div>

                    <!-- Sign-in -->
                    <div class="col-md-6 col-sm-6 create-new-account">
                        <h4 class="checkout-subtitle sign_in_header">
                            <span>
                                Створити новий акаунт
                            </span>
                            <a class="sign_in_header_google" href="<?php echo $login_url;?>">
                            </a>
                        </h4>
                        <p class="text title-tag-line">Cтворіть власний обліковий запис.</p>
                        <form class="register-form outer-top-xs" role="form" method="post" name="register"
                            onSubmit="return valid();">
                            <div class="form-group">
                                <label class="info-title" for="firstname">Iм'я. <span>*</span></label>
                                <input type="text" class="form-control unicase-form-control text-input" id="firstname"
                                    name="firstname" required="required">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="midlename">По батьковi.</label>
                                <input type="text" class="form-control unicase-form-control text-input" id="midlename"
                                    name="midlename">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="lastname">Прiзвище.</label>
                                <input type="text" class="form-control unicase-form-control text-input" id="lastname"
                                    name="lastname">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail2">Адреса електронної пошти.
                                    <span>*</span></label>
                                <input type="email" class="form-control unicase-form-control text-input" id="email"
                                    onBlur="userAvailability()" name="emailid" required>
                                <span id="user-availability-status1" style="font-size:12px;"></span>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="contactno">Контактний номер. <span>*</span></label>
                                <input type="text" class="form-control unicase-form-control text-input nomer"
                                    placeholder="+38(___)_______" id="contactno" name="contactno" maxlength="12"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Пароль. <span>*</span></label>
                                <div
                                    style=" height: 43px; margin-bottom: 20px; margin-right: 12px; position: relative; width: 100%;">
                                    <span class="show-pass"><img src="img/show-pass.png"></span>
                                    <input type="password" class="form-control unicase-form-control text-input pass"
                                        id="password" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="confirmpassword">Підтвердьте пароль.
                                    <span>*</span></label>
                                <div
                                    style=" height: 43px; margin-bottom: 20px; margin-right: 12px; position: relative; width: 100%;">
                                    <span class="show-pass3"><img src="img/show-pass.png"></span>
                                    <input type="password" class="form-control unicase-form-control text-input pass3"
                                        id="confirmpassword" name="confirmpassword" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <p>
                                    <label name="reg_yes" id="check_text" style="padding-left:10px;color:#666666;">
                                        <input type="checkbox" id="check" name="reg_yes" data="0" required
                                            style="pointer-events: visible;  position: relative; left: 0px; opacity: 1; margin-right: 10px;">
                                        Даю згоду на отримання сповіщень про новинки та спеціальні пропозиції.
                                    </label>
                                </p>
                                <p style="padding-top:20px;">
                                    *Натискаючи зареєструватись, Ви даєте згоду на обробку ваших персональних даних.
                                </p>
                            </div>
                            <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button"
                                id="submit">Зареєструватися</button>
                        </form>
                        <span class="checkout-subtitle outer-top-xs">Зареєструйтеся сьогодні, і Ви зможете: </span>
                        <div class="checkbox">
                            <label class="checkbox">
                                Прискорить час на оплату за товар.
                            </label>
                            <label class="checkbox">
                                Легко відстежуйте свої замовлення.
                            </label>
                            <label class="checkbox">
                                Переглядайте історію покупок.
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include('includes/footer.php');?>
    <script>
        $(document).ready(function () {
            $(".nomer").mask("+38 (999) 99-99-999");
            $(".show-pass").click(function () {
                if ($(".pass").attr("type") == 'password') {
                    $(".pass").attr("type", "text");
                } else {
                    $(".pass").attr("type", "password");
                }
            });
            $(".show-pass2").click(function () {
                if ($(".pass2").attr("type") == 'password') {
                    $(".pass2").attr("type", "text");
                } else {
                    $(".pass2").attr("type", "password");
                }
            });
            $(".show-pass3").click(function () {
                if ($(".pass3").attr("type") == 'password') {
                    $(".pass3").attr("type", "text");
                } else {
                    $(".pass3").attr("type", "password");
                }
            });
        });

        function valid() {
            if (document.register.password.value != document.register.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match  !!");
                document.register.confirmpassword.focus();
                return false;
            }
            return true;
        }

        function userAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "small_php_func/check_availability.php",
                data: 'email=' + $("#email").val(),
                type: "POST",
                success: function (data) {
                    $("#user-availability-status1").html(data);
                    $("#loaderIcon").hide();
                },
                error: function () {}
            });
        }
    </script>
</body>

</html>