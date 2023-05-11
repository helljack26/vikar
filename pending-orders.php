<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:login.php');
}
else{
	if (isset($_GET['id'])) {
		mysqli_query($con,"delete from orders  where userId='".$_SESSION['id']."' and paymentMethod is null and id='".$_GET['id']."' ");
		;
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
    <title>Історія очікуваних замовлень | Vikar.center</title>
    <?php include('includes/links.php');?>

</head>

<body class="cnt-home">
    <!-- Header -->
    <?php include('includes/main-header.php');?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled" style="text-align: left;">
                    <li><a href="/">Головна</a></li>
                    <li class='active'>Історія очікуваних замовлень</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row inner-bottom-sm">
                <div class="shopping-cart">
                    <div class="col-md-12 col-sm-12 shopping-cart-table ">
                        <div class="table-responsive">
                            <form name="cart" method="post">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="cart-romove item">#</th>
                                            <th class="cart-description item">Зображення</th>
                                            <th class="cart-product-name item">Назва товару</th>
                                            <th class="cart-qty item">Кількість</th>
                                            <th class="cart-sub-total item">Ціна за одиницю</th>
                                            <th class="cart-sub-total item">Вартість доставки</th>
                                            <th class="cart-total">Усього</th>
                                            <th class="cart-total item">Спосіб оплати</th>
                                            <th class="cart-description item">Дата замовлення</th>
                                            <th class="cart-total last-item">Дія</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query=mysqli_query($con,"select products.productImage1 as pimg1,products.productName as pname,products.id as c,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as oid from orders join products on orders.productId=products.id where orders.userId='".$_SESSION['id']."' and orders.paymentMethod is null");
                                            $cnt=1;
                                            $num=mysqli_num_rows($query);
                                            if($num>0)
                                            {
                                            while($row=mysqli_fetch_array($query))
                                            {
                                            ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td class="cart-image">
                                                <a class="entry-thumbnail" href="detail.html">
                                                    <img src="admin/productimages/<?php echo $row['proid'];?>/<?php echo $row['pimg1'];?>"
                                                        alt="" width="84" height="146">
                                                </a>
                                            </td>
                                            <td class="cart-product-name-info">
                                                <h4 class='cart-product-description'>
                                                    <?php echo $row['pname'];?>
                                                </h4>
                                            </td>
                                            <td class="cart-product-quantity"><?php echo $qty=$row['qty']; ?> </td>
                                            <td class="cart-product-sub-total"><?php echo $price=$row['pprice']; ?>
                                            </td>
                                            <td class="cart-product-sub-total">
                                                <?php echo $shippcharge=$row['shippingcharge']; ?> </td>
                                            <td class="cart-product-grand-total">
                                                <?php echo (($qty*$price)+$shippcharge);?></td>
                                            <td class="cart-product-sub-total"><?php echo $row['paym']; ?> </td>
                                            <td class="cart-product-sub-total"><?php echo $row['odate']; ?> </td>
                                            <td><a href="pending-orders.php?id=<?php echo $row['oid']; ?> ">Delete</td>
                                        </tr>
                                        <?php $cnt=$cnt+1;} ?>
                                        <tr>
                                            <td colspan="9">
                                                <div class="cart-checkout-btn pull-right">
                                                    <button type="submit" name="ordersubmit" class="btn btn-primary"><a
                                                            href="payment-method.php">PROCCED To Payment</a></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } else {?>
                                        <tr>
                                            <td colspan="10" align="center">
                                                <h4>Результатів не знайдено</h4>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php');?>

</body>

</html>
<?php } ?>