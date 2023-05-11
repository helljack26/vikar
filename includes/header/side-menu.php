<?require_once 'includes/config.php';?>

<div class="header_side_menu">
    <ul class="header_side_menu_block">
        <?
            $sql = mysqli_query($con,"SELECT id,categoryName from category");  
            while($row4 = mysqli_fetch_array($sql)){   
        ?>
        <li  data="<?=$row4['id']?>">
                <a class='cat' href="/category/<?=transliterate($row4['categoryName'])?>" data="#<?=$row4['id']?>">
                    <?echo $row4['categoryName']?>
                </a>
                <span class="expand">
                </span>
            </a>
            <ul class="child">
                <span id="cat<?=$row4['id']?>">
                </span>
            </ul>
        </li>
        <?}?>
    </ul>
</div>

<script>
$(document).ready(function() {
    $(".cat").mouseenter(function() {
        id = $(this).attr("data").slice(1);
        $.ajax({
            type: "POST",
            url: "/includes/header/side-menu-fetch.php",
            data: {
                'id': id,
                'menu': '1'
            },
            success: function(data) {
                $("#cat" + id).html(data);
            },
        });
    });
});
</script>