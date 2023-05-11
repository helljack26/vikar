<?
require_once '../config.php';
include '../../function.php';

if(isset($_POST['menu'])){
$id = $_POST['id'];
$sql = mysqli_query($con,"SELECT subcategory,subcategory_id,categoryid,id from subcategory where categoryid='$id'");

while($row = mysqli_fetch_array($sql)):
    $sql2 = mysqli_query($con,"SELECT id from product_category where category_id='$row[categoryid]' and subcategoryid='$row[subcategory_id]'");
    $row2 = mysqli_fetch_array($sql2);
    if(!empty($row2['id'])){
        $prod = true;
    }else{
        $prod = false;
    }
?>
<li class="parent">
    <?if($prod):?>
    <a href="sub-category/<?=transliterate($row['subcategory'])?>" data-hide='0' class='prod'
        data-cat='<?=$row['categoryid']?>' data-sub='<?=$row['subcategory_id']?>' data-id='<?=$row['id']?>'>
        <?=$row['subcategory']?>

        <span class="expand"></span>
    </a>
    <?else:?>
    <a href="sub-category/<?=transliterate($row['subcategory'])?>">
        <?=$row['subcategory']?>
    </a>
    <?endif;
    
    if($prod){?>
    <ul class="child">
        <span id="asd<?=$row['id']?>"></span>
    </ul>
    <?}?>
</li>
<?endwhile?>
<script>
    $(".prod").mouseenter(function (e) {
        id = $(this).attr('data-id');
        cat_id = $(this).attr("data-cat");
        sub_id = $(this).attr('data-sub');
        $.ajax({
            type: "POST",
            url: "/includes/header/side-menu-fetch2.php",
            data: {
                'menu': '2',
                'cat': cat_id,
                'sub': sub_id
            },
            success: function (data) {
                $("#asd" + id).html(data);
            }
        });
    });

    $(".prod").click(function (e) {
        $('.prod').next('ul').toogle();
        e.stopPropagation();
        e.preventDefault();
    });
</script>
<? }?>