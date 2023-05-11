<? $product_cat_name = strlen($product_cat_name) > 0 ? $product_cat_name : $subCatName; ?>

<div class="product_category_row">
    <!-- Filters -->
    <? include('includes/product_filters/product_filters.php'); ?>

    <!-- Product results -->
    <div class="product_category_row_results">
        <div class="product_category_row_results_header">
            <div class="product_category_row_results_header_row">
                <h1>
                    <?=$product_cat_name?>
                </h1>
                <!-- Sort buttons -->
                <? include('includes/product_filters/sort_button.php'); ?>
            </div>
        </div>
        <div id="load_more_results" class="product_category_row_results_block">
            <?php
            $isProduct_cat = $product_cat ? "and product_category='$product_cat'" : '';

            $get_max_num=mysqli_query($con,"SELECT c_code
                                                FROM products
                                                WHERE organization='Вікар' 
                                                AND category='$cat' 
                                                AND sub_сategory='$cid' 
                                                $isProduct_cat
                                                $filter_db_query
                                                AND product_price > 1
                                                GROUP BY c_code 
                                                ");
            $max_number=mysqli_num_rows($get_max_num);

            $retDistinct=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_work_name, 
                                                attributes->'$.*.name' AS name, 
                                                attributes->'$.*.value' AS value,
                                                attributes->'$.*' AS obj

                                                FROM products
                                                WHERE organization='Вікар' 
                                                AND category='$cat'
                                                AND sub_сategory='$cid'
                                                $isProduct_cat
                                                
                                                $filter_db_query
                                                AND product_price > 1
                                                ORDER BY product_availability DESC
                                                ");
                                                // LIMIT 10



echo("SELECT c_code, characteristic_uuid, product_work_name,
attributes->'$.*.name' AS name,
attributes->'$.*.value' AS value
FROM products
WHERE organization='Вікар'
AND category='$cat'
AND sub_сategory='$cid'
$isProduct_cat

$filter_db_query
AND product_price > 1
ORDER BY product_availability DESC
LIMIT 10");
                $numDistinct=mysqli_num_rows($retDistinct);

                if($numDistinct>0):
                    $i=0;
                    
                    
                    $existedNames = [];
                    
                    while($rowDisctinct=mysqli_fetch_array($retDistinct)):   

                        $attr = $rowDisctinct['obj'];
                        
                        $attr = json_decode($attr, true);
                        
                        $isBoxChecked = false;
                        foreach ($attr as $attr_name => $attr_values) {

                            $raw_name = cleanName($attr_values['name']);
                            $isExistCatName = $filter_object[$raw_name];
                            
                            
                            if ($isExistCatName != NULL) {
                                $isBoxChecked = array_search($attr_values['value'], $isExistCatName) !== false;
                            }

                            
                            // var_dump($attr);
                            $isExist = array_search($rowDisctinct['product_work_name'], $existedNames); 

                            if ($isBoxChecked == true) {

                                if ($isExist === false) {
                                    echo('$isBoxChecked - ' . $isBoxChecked . '<br />');
                                    echo('$attr_name[value] - ' . $attr_values['value'] . '<br />');
                                
                                    $ret=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_name, product_spec, product_availability, product_count, product_old_price, product_price, productImage1
                                                            FROM products 
                                                            WHERE organization='Вікар'
                                                            AND c_code='$rowDisctinct[c_code]'
                                                            AND characteristic_uuid='$rowDisctinct[characteristic_uuid]'
                                                            ");
                                    $row=mysqli_fetch_array($ret);                                                              
                                    include('includes/display_product_card_item.php');
                                    array_push($existedNames, $rowDisctinct['product_work_name']);
                                }
                            }
                        }
                    endwhile;

                    echo("<input type='hidden' id='max_number' value='$max_number'>");
                else:
                    echo('<h2 class="product_category_row_results_block_empty">За цим запитом товари не знайдені.</h2>');
                endif;
            ?>
        </div>

        <div id='loadMore'>
            <img src="../assets/load.gif">
        </div>
    </div>
</div>