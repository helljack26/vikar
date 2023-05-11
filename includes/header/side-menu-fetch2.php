<?
require_once '../config.php';
include '../../function.php';

if(isset($_POST['menu'])){
$cat2 = $_POST['cat'];
$sub2 = $_POST['sub'];
$sql = mysqli_query($con,"SELECT * 
                            from product_category 
                            where category_id='$cat2' 
                            and subcategoryid='$sub2'
                            ");

while($product_row = mysqli_fetch_array($sql)){
    $sql2 = mysqli_query($con,"SELECT id 
                                from product_subspec 
                                where category_id='$product_row[category_id]' 
                                and subcategoryid='$product_row[subcategoryid]' 
                                and product_category_id='$product_row[product_category_id]'
                                ");
                                
    $row2 = mysqli_fetch_array($sql2);
    if(!empty($row2['id'])){
        $prod = true;
    }else{
        $prod = false;
    }
?>
<li class="parent">
    <?if($prod):?>
        <a
            href="product-category/<?=transliterate($product_row['productcategoryname'])?>"
            class='prod2' 
            data-hide='0' 
            data-cat='<?=$product_row['category_id']?>' 
            data-sub='<?=$product_row['subcategoryid']?>'
            data-product='<?=$product_row['product_category_id']?>'
            data-id='<?=$product_row['id']?>'
        >
            <?=$product_row['productcategoryname']?>

            <span class="expand"></span>
        </a>
    <? else: ?>
        <a href="product-category/<?=transliterate($product_row['productcategoryname'])?>">
            <?=$product_row['productcategoryname']?>
        </a>
    <? endif; ?>

    <?if($prod){?>
        <ul class="child">
            <span id="asd2<?=$product_row['id']?>"></span>
        </ul>
    <?}?>
</li>
<?}?>

<script>
    $(".prod2").mouseenter(function (e) {
        id = $(this).attr('data-id');
        cat_id = $(this).attr("data-cat");
        sub_id = $(this).attr('data-sub');
        product_id = $(this).attr('data-product');
        $.ajax({
            type: "POST",
            url: "/includes/header/side-menu-fetch3.php",
            data: {
                'menu': '3',
                'cat': cat_id,
                'sub': sub_id,
                'product': product_id,
            },
            success: function (data) {
                $("#asd2" + id).html(data);
            }
        });
    });

    $(".prod2").click(function (e) {
        $('.prod2').next('ul').toogle();
        e.stopPropagation();
        e.preventDefault();
    });
</script>
<? }?>