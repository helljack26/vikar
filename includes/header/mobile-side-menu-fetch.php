<?require_once '../config.php';
include '../../function.php';
if(isset($_POST['menu'])){
$id = $_POST['id'];
$sql = mysqli_query($con,"SELECT subcategory,subcategory_id,categoryid,id from subcategory where categoryid='$id'");

while($row = mysqli_fetch_array($sql)){
    $sql2 = mysqli_query($con,"SELECT id from product_category where category_id='$row[categoryid]' and subcategoryid='$row[subcategory_id]'");
    $row2 = mysqli_fetch_array($sql2);
    if(!empty($row2['id'])){
        $prod = true;
    }else{
        $prod = false;
    }
?>
<li class="mobile_parent">
    <?if($prod):?>
    <div class="mobile_parent_item prod_container">
        <a href="sub-category/<?=transliterate($row['subcategory'])?>">
            <?=$row['subcategory']?>
        </a>
        <span class="mobile_parent_arrow prod" data-hide='0' data-cat='<?=$row['categoryid']?>'
            data-sub='<?=$row['subcategory_id']?>' data-id='<?=$row['id']?>'>
        </span>
    </div>
    <?else:?>
        <a href="sub-category/<?=transliterate($row['subcategory'])?>"><?=$row['subcategory']?></a>
    <?endif;?>

    <?if($prod){?>
    <ul class="mobile_parent_child">
        <span id="asd<?=$row['id']?>"></span>
    </ul>
    <?}?>
</li>
<?}?>

<script>
    $(document).ready(function () {
        $(".prod").click(function (e) {
            id = $(this).attr('data-id');
            cat_id = $(this).attr("data-cat");
            sub_id = $(this).attr('data-sub');
            $.ajax({
                type: "POST",
                url: "/includes/header/mobile-side-menu-fetch2.php",
                data: {
                    'menu': '2',
                    'cat': cat_id,
                    'sub': sub_id
                },
                success: function (data) {
                    $("#asd" + id).html(data);
                },
            });
        });

        $(".prod").click(function (e) {
            const isOpened = $(this).attr("class").split(/\s+/).join(' ').includes(
                'arrow_rotate');
            e.stopPropagation();
            e.preventDefault();

            if (!isOpened) {
                $(".prod_container").next('ul').slideUp();
                setTimeout(() => {
                    $(this).parent().next('ul').slideDown();
                }, 200);

                // Arrow rotate
                $('.mobile_parent_arrow').removeClass('arrow_rotate');
                $(this).addClass('arrow_rotate');
            } else {
                $('.mobile_parent_arrow').removeClass('arrow_rotate');
                $(".prod_container").next('ul').slideUp();
            }
        });
    })
</script>
<? }?>