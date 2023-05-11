<?php include('includes/config.php');?>

<div class="sub_category_row">
   <h1>
      <?= $subCatName ?>
   </h1>

   <!-- Category results -->
   <div class="sub_category_row_results wow fadeInUp">
      <?php
      $ret_sub=mysqli_query($con,"SELECT * from product_category where subcategoryid='$cid' and category_id='$cat'");
      $num=mysqli_num_rows($ret_sub);
      if($num>0):
      while ($row_sub=mysqli_fetch_array($ret_sub)):?>

      <div class="sub_category_row_results_item ">
         <!-- Image -->
         <a class="sub_category_row_results_item_image"
            href="product-category/<?=transliterate($row_sub['productcategoryname'])?>">
            <img src="categoryImage/<?=$row_sub['product_image']?>" width="200" height="200">
         </a>

         <!-- Name -->
         <?php
            $get_sub_category=mysqli_query($con,"SELECT * from product_subspec where subcategoryid='$row_sub[subcategoryid]' and category_id='$row_sub[category_id]' and product_category_id='$row_sub[product_category_id]' ");
            $num_get_sub_category=mysqli_num_rows($get_sub_category);
         ?>
         <div class="sub_category_row_results_item_name
         <? if($num_get_sub_category > 0){
                  echo('sub_category_row_results_item_name_padding_right');
               }?> 
         ">
            <a 
               href="product-category/<?=transliterate($row_sub['productcategoryname'])?>">
               <?php echo htmlentities($row_sub['productcategoryname']);?>
            </a>
            <!-- Show arrow only if sub category exist -->
               <? if($num_get_sub_category > 0):?> 
            <!-- Mobile arrow -->
            <button type="button" class="category_row_results_item_name_mob_arrow"
               data-dropdown="<? echo('mobile_dropdown' . $row['subcategory_id']);?>">
            </button>
            <? endif; ?>
         </div>
         
         <? $i = 0; ?>
               <div class="category_row_results_item_list_container"
                  id="<? echo('mobile_dropdown'.$row['subcategory_id']);?>">
                  <div class ="category_row_results_item_list">
                     <!-- Visible product category -->
                     <?php
                     $ret2=mysqli_query($con,"SELECT * from product_subspec where subcategoryid='$row_sub[subcategoryid]' and category_id='$row_sub[category_id]' and product_category_id='$row_sub[product_category_id]'");
                     $num_sub_product=mysqli_num_rows($ret2);
                     while ($row2=mysqli_fetch_array($ret2)):
                        ++$i;
                        if($i < 5): ?>
                     <a
                        href="product-subspec/<?= transliterate($row2['subspecname']);?>">
                        <? echo($row2['subspecname']);?>
                     </a>

                     <? endif; endwhile;?>

                     <?php $get_sub_product=mysqli_query($con,"SELECT * from product_subspec where subcategoryid='$row_sub[subcategoryid]' and category_id='$row_sub[category_id]' and product_category_id='$row_sub[product_category_id]'");
                        $num_sub_product_row=mysqli_num_rows($get_sub_product);
                        if($num_sub_product_row > 4 ): ?>
                           <button type="button" class="category_row_results_item_list_visible_button"
                              data-dropdown="<? echo('dropdown'.$row2['product_category_id']);?>">
                              Бiльше товарiв
                           </button>
                     <? endif; ?>
                  </div>
                  <!-- Hidden product category -->
                  <div class="category_row_results_item_list_dropdown_container">
                     <div class="category_row_results_item_list_dropdown"
                        id="<? echo('dropdown'.$row2['product_category_id']);?>">
                        <?php
                        $i2 = 0;
                        while ($row3=mysqli_fetch_array($get_sub_product)) { ?>
                        <?php 
                        ++$i2;
                        if($num_sub_product > 4 && $i2 > 4): ?>
                        <a
                           href="product-subspec/<?= transliterate($row3['subspecname']);?>">
                           <? echo($row3['subspecname']);?>
                        </a>
                        <? endif; ?>
                        <?};?>
                     </div>
                  </div>
               </div>
      </div>
      <? endwhile; endif;  ?>
   </div>
</div>

<script>
      $(document).ready(function () {
         // Desktop dropdowns
         $(".category_row_results_item_list_visible_button").click(function (e) {
            const buttonClass = 'category_row_results_item_list_visible_button';
            const activeButtonClass = 'category_row_results_item_list_visible_button_rotate';

            const isOpened = e.target.classList.value.includes(activeButtonClass);
            const dataDropdown = e.target.attributes[2].value;

            if (!isOpened) {
               $(`.${buttonClass}`).removeClass(activeButtonClass)
               $(this).addClass(activeButtonClass)

               $('.category_row_results_item_list_dropdown').fadeOut();
               $(`#${dataDropdown}`).fadeIn();
            } else {
               $(`.${buttonClass}`).removeClass(activeButtonClass);
               $(`#${dataDropdown}`).fadeOut();
            }
         });

         // Mobile dropdowns
         $(".category_row_results_item_name_mob_arrow").click(function (e) {
            const buttonClass = 'category_row_results_item_name_mob_arrow';
            const activeButtonClass = 'category_row_results_item_name_mob_arrow_rotate';

            const isOpened = e.target.classList.value.includes(activeButtonClass);
            const dataDropdown = e.target.attributes[2].value;

            if (!isOpened) {
               $(`.${buttonClass}`).removeClass(activeButtonClass)
               $(this).addClass(activeButtonClass)

               $('.category_row_results_item_list_container').slideUp();
               $(`#${dataDropdown}`).slideDown();
            } else {
               $(`.${buttonClass}`).removeClass(activeButtonClass);
               $(`#${dataDropdown}`).slideUp();
            }
         });
      });
   </script>