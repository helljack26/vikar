<?require_once '../config.php';
include '../../function.php';


if(isset($_POST['menu'])){
    $cat = $_POST['cat'];
    $sub = $_POST['sub'];
    $product = $_POST['product'];
    $sql = mysqli_query($con,"SELECT * from product_subspec where category_id='$cat' and subcategoryid='$sub' and product_category_id='$product'");

    while($row_sub_product_mob = mysqli_fetch_array($sql)){
?>
<li class="mobile_parent_child_item mobile_parent_sub_child_item">
    <a href="product-subspec/<?=transliterate($row_sub_product['subspecname'])?>">
        <?=$row_sub_product_mob['subspecname']?>
    </a>
</li>
<?} }?>

