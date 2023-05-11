<?
require_once '../config.php';
include '../../function.php';

if(isset($_POST['menu'])){
    $cat = $_POST['cat'];
    $sub = $_POST['sub'];
    $product = $_POST['product'];

    $sql = mysqli_query($con,"SELECT * 
                                from product_subspec 
                                where category_id='$cat'
                                and subcategoryid='$sub' 
                                and product_category_id='$product'
                                ");

    while($row_sub_product = mysqli_fetch_array($sql)){?>
        <li class="three_lvl">
            <a href="product-subspec/<?=transliterate($row_sub_product['subspecname'])?>"
                class="three_lvl_a">
                <?=$row_sub_product['subspecname']?>
            </a>
        </li>
<?} }?>