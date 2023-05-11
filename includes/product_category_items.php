<?php
include('includes/config.php');

$get_scid=intval($_GET['scid']);
$get_cat=intval($_GET['cat']);

?>
<title><?=CategoryName($con,'product',intval($_GET['product']),intval($_GET['cat']))?> | Vikar.center</title>

<div class="sub_category_row">
    <h1>
        <?=CategoryName($con,'product',intval($_GET['product']),intval($_GET['cat']))?>
    </h1>

    <!-- Category results -->
    <div class="sub_category_row_results wow fadeInUp">
        <?php
        if($num_sub_product_row>0):
        while ($row_sub=mysqli_fetch_array($get_sub_product_row)): ?>

        <div class="sub_category_row_results_item ">
            <!-- Image -->
            <a class="sub_category_row_results_item_image"
                href="product-subspec.php?scid=<?=$row_sub['category_id']?>&cat=<?=$row_sub['subcategoryid']?>&product=<?=$row_sub['product_category_id']?>&sub_product=<?= $row_sub['product_subspec_id']?>">
                <img src="categoryImage/<?=$row_sub['sub_product_image']?>" width="200" height="200">
            </a>

            <!-- Name -->
            <?php
                $get_sub_category=mysqli_query($con,"SELECT * from product_subspec where subcategoryid='$row_sub[subcategoryid]' and category_id='$row_sub[category_id]' and product_category_id='$row_sub[product_category_id]' ");
                $num_get_sub_category=mysqli_num_rows($get_sub_category);
            ?>
            <div class="sub_category_row_results_item_name">
                <a
                    href="product-subspec.php?scid=<?=$row_sub['category_id']?>&cat=<?=$row_sub['subcategoryid']?>&product=<?=$row_sub['product_category_id']?>&sub_product=<?= $row_sub['product_subspec_id']?>">
                    <?php echo htmlentities($row_sub['subspecname']);?>
                </a>
            </div>
        </div>
        <? endwhile; endif;
      ?>
    </div>
</div>