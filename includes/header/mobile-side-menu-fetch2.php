<?require_once '../config.php';
include '../../function.php';
?>
<?
if(isset($_POST['menu'])){
    $cat = $_POST['cat'];
    $sub = $_POST['sub'];

    $sql = mysqli_query($con,"SELECT * from product_category where category_id='$cat' and subcategoryid='$sub'");
    while($product_row_mob = mysqli_fetch_array($sql)){
        $sqlIsExistSub = mysqli_query($con,"SELECT id from product_subspec where category_id='$product_row_mob[category_id]' and subcategoryid='$product_row_mob[subcategoryid]' and product_category_id='$product_row_mob[product_category_id]'");
        $isExistSubCategory = mysqli_fetch_array($sqlIsExistSub);

        if(!empty($isExistSubCategory['id'])){
            $prod = true;
        }else{
            $prod = false;
        }
?>
<li class="mobile_parent">
    <?if($prod):?>
    <div class="mobile_parent_item prod_container2">
        <a href="product-category/<?=transliterate($product_row_mob['productcategoryname'])?>">
            <?=$product_row_mob['productcategoryname']?>
        </a>
        <span class="mobile_parent_arrow2 prod2" 
            data-hide='0' 
            data-cat='<?=$product_row_mob['category_id']?>'
            data-sub='<?=$product_row_mob['subcategoryid']?>' 
            data-product='<?=$product_row_mob['product_category_id']?>'
            data-id='<?=$product_row_mob['id']?>'>
        </span>
    </div>
    <?else:?>
    <a href="product-category/<?=transliterate($product_row_mob['productcategoryname'])?>" >
        <?=$product_row_mob['productcategoryname']?>
    </a>
    <?endif;?>

    <?if($prod){?>
    <ul class="mobile_parent_child2">
        <span id="asd2<?=$product_row_mob['id']?>"></span>
    </ul>
    <?}?>
</li>
<?}?>

<script>
    $(document).ready(function () {
        $(".prod2").click(function (e) {
            id = $(this).attr('data-id');
            cat_id = $(this).attr("data-cat");
            sub_id = $(this).attr('data-sub');
            product_id = $(this).attr('data-product');
            $.ajax({
                type: "POST",
                url: "/includes/header/mobile-side-menu-fetch3.php",
                data: {
                    'menu': '3',
                    'cat': cat_id,
                    'sub': sub_id,
                    'product': product_id,
                },
                success: function (data) {
                    $("#asd2" + id).html(data);
                },
            });
        });

        $(".prod2").click(function (e) {
            const isOpened = $(this).attr("class").split(/\s+/).join(' ').includes(
                'arrow_rotate');
            e.stopPropagation();
            e.preventDefault();

            if (!isOpened) {
                $(".prod_container2").next('ul').slideUp();
                setTimeout(() => {
                    $(this).parent().next('ul').slideDown();
                }, 200);

                // Arrow rotate
                $('.mobile_parent_arrow2').removeClass('arrow_rotate');
                $(this).addClass('arrow_rotate');
            } else {
                $('.mobile_parent_arrow2').removeClass('arrow_rotate');
                $(".prod_container2").next('ul').slideUp();
            }
        });
    })
</script>

<?}?>