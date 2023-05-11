<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0){   
    header('location:login');
} else {
    date_default_timezone_set('Europe/Kiev');// change according timezone
    $currentTime = date( 'd-m-Y h:i:s A', time () );

    if(isset($_POST['update'])){
		$name=$_POST['name'];
		$contactno=$_POST['contactno'];
		$query=mysqli_query($con,"UPDATE users 
                                    set name='$name',contactno='$contactno' 
                                    where id='".$_SESSION['id']."'");
		if($query){
            echo "<script>alert('Ваши данні були оновлені');</script>";
		}
	}

    if(isset($_POST['submit'])){
        $userId=$_SESSION['id'];
        $password=md5($_POST['cpass']);

        $query=mysqli_query($con,"SELECT password 
                                    FROM users
                                    WHERE id='$userId' 
                                    and password='$password'
                                    ");
        $num=mysqli_fetch_array($query);

        if($num>0){
            $passUpdate=mysqli_query($con,"UPDATE users 
                                            SET password='".md5($_POST['newpass'])."', updationDate='$currentTime' 
                                            WHERE id='".$_SESSION['id']."'");
            echo "<script>alert('Пароль успішно змінено!!');</script>";
        } else {
            echo "<script>alert('Паролі не співпадають !!');</script>";
        }   
    }
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>Особистий кабінет | Vikar.center</title>
    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/my-account.css">
</head>

<body>
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="#">Головна</a></li>
                    <li class='active'>Мій кабінет</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="checkout-box inner-bottom-sm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel-group checkout-steps" id="accordion">
                            <div class="panel panel-default checkout-step-01">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            <span>1</span>Мій кабінет
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <?php
                                            $query=mysqli_query($con,"SELECT * from users where email='$_SESSION[login]'");
                                            $row=mysqli_fetch_array($query);

                                            $userBonus = $row['bonus'] !== NULL ? $row['bonus'] : 0;
                                        ?>
                                        <div class="row">
                                            <h3 class="bonus">
                                                Накопичені бонуси: <span><?= $userBonus?></span> грн.
                                            </h3>

                                            <h4>Особиста інформація</h4>
                                            <div class="col-md-12 col-sm-12 already-registered-login">
                                                <form class="register-form" role="form" method="post">
                                                    <div class="form-group">
                                                        <label class="info-title" for="name">Ім'я<span>*</span></label>
                                                        <input type="text"
                                                            class="form-control unicase-form-control text-input"
                                                            value="<?php echo $row['name'];?>" id="name" name="name"
                                                            required="required">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="info-title" for="exampleInputEmail1">
                                                            Адреса електронної пошти<span>*</span>
                                                        </label>
                                                        <input type="email"
                                                            class="form-control unicase-form-control text-input"
                                                            id="exampleInputEmail1" value="<?php echo $row['email'];?>"
                                                            readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="info-title" for="Contact No.">
                                                            Контактний номер.<span>*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control unicase-form-control text-input"
                                                            id="contactno" name="contactno" required="required"
                                                            value="<?php echo $row['contactno'];?>" maxlength="10">
                                                    </div>
                                                    <button type="submit" name="update"
                                                        class="btn-upper btn btn-primary checkout-page-button">
                                                        Оновити
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default checkout-step-02">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="collapsed" data-parent="#accordion"
                                            href="#collapseTwo">
                                            <span>2</span>Змінити пароль
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form class="register-form" role="form" method="post" name="chngpwd"
                                            onSubmit="return valid();">
                                            <div class="form-group">
                                                <label class="info-title" for="Current Password">
                                                    Поточний пароль
                                                    <span>*</span></label>
                                                <input type="password"
                                                    class="form-control unicase-form-control text-input" id="cpass"
                                                    name="cpass" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title" for="New Password">
                                                    Новий пароль
                                                    <span>*</span></label>
                                                <input type="password"
                                                    class="form-control unicase-form-control text-input" id="newpass"
                                                    name="newpass">
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title" for="Confirm Password">
                                                    Підтвердження пароля
                                                    <span>*</span></label>
                                                <input type="password"
                                                    class="form-control unicase-form-control text-input" id="cnfpass"
                                                    name="cnfpass" required="required">
                                            </div>
                                            <button type="submit" name="submit"
                                                class="btn-upper btn btn-primary checkout-page-button">Змінити </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include('includes/account-sidebar.php');?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.cpass.value == "") {
                alert("Поточний пароль пустий !!");
                document.chngpwd.cpass.focus();
                return false;
            } else if (document.chngpwd.newpass.value == "") {
                alert("Новий пароль пустий !!");
                document.chngpwd.newpass.focus();
                return false;
            } else if (document.chngpwd.cnfpass.value == "") {
                alert("Пітвердження пароля пусте !!");
                document.chngpwd.cnfpass.focus();
                return false;
            } else if (document.chngpwd.newpass.value != document.chngpwd.cnfpass.value) {
                alert("Старий і новий пароль не співпадає !!");
                document.chngpwd.cnfpass.focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
<?php } ?>