<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) {   
header('location:.php');
} else {
// code for billing address updation
// code for Shipping address updation
	if(isset($_POST['shipupdate']))
	{
		$saddress=$_POST['shippingaddress'];
		$sstate=$_POST['shippingstate'];
		$scity=$_POST['shippingcity'];
		$spincode=$_POST['shippingpincode'];
		$query=mysqli_query($con,"update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='".$_SESSION['id']."'");
		if($query){
            echo "<script>alert('Shipping Address has been updated');</script>";
		}
	}
?>
<!DOCTYPE html>
<html  lang="uk">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>Адреса доставки | Vikar.center</title>
    <?php include('includes/links.php');?>
</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>
     
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="#">Головна</a></li>
                    <li class='active'>Адреса доставки</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->
    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="checkout-box inner-bottom-sm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel-group checkout-steps" id="accordion">
                            <!-- checkout-step-02  -->
                            <div class="panel panel-default checkout-step-02">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="collapsed" data-parent="#accordion"
                                            href="#collapseTwo">
                                            <span>1</span>Адеса доставки
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php
                                            $query=mysqli_query($con,"SELECT * from users where id='".$_SESSION['id']."'");
                                            while($row=mysqli_fetch_array($query)){?>

                                        <form class="register-form" role="form" method="post">
                                            <div class="form-group">
                                                <label class="info-title" for="Shipping Address">Адеса
                                                    доставки<span>*</span></label>
                                                <?if($row['shippingAddress']=='0'):?>
                                                <textarea class="form-control unicase-form-control text-input"
                                                    name="shippingaddress" required="required"></textarea>
                                                <?else:?>
                                                <textarea class="form-control unicase-form-control text-input"
                                                    name="shippingaddress"
                                                    required="required"><?=$row['shippingAddress']?>
                                                </textarea>
                                                <?endif;?>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title" for="Billing State ">Область доставки
                                                    <span>*</span></label>
                                                <?if($row['shippingState']=='0'):?>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="shippingstate" name="shippingstate" value="" required />
                                                <?else:?>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="shippingstate" name="shippingstate"
                                                    value="<?=$row['shippingState']?>" required />
                                                <?endif;?>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title" for="Billing City">Місто доставки
                                                    <span>*</span></label>
                                                <?if($row['shippingCity']=='0'):?>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="shippingcity" name="shippingcity" value="" required />
                                                <?else:?>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="shippingcity" name="shippingcity"
                                                    value="<?=$row['shippingCity']?>" required />
                                                <?endif;?>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title" for="Billing Pincode">
                                                    Поштовий індекс доставки<span>*</span>
                                                </label>
                                                <?if($row['shippingpincode']=='0'):?>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="shippingpincode" name="shippingpincode" value="" required />
                                                <?else:?>
                                                <input type="text" class="form-control unicase-form-control text-input"
                                                    id="shippingpincode" name="shippingpincode"
                                                    value="<?=$row['shippingpincode']?>" required />
                                                <?endif;?>
                                            </div>
                                            <button type="submit" name="shipupdate"
                                                class="btn-upper btn btn-primary checkout-page-button">
                                                Оновити
                                            </button>
                                        </form>
                                        <?php } ?>
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
</body>

</html>
<?php } ?>