<link rel="stylesheet" href="assets/css/product_filters.css" />

<div class="product_filters_mobile_bg"></div>
<div class="product_filters" data="0">
    <button type="button" class="product_filters_container_header">
        <span>
            Фiльтр
        </span>
        <div class="product_filters_container_header_icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <!-- For mobile header close event -->
        <div class="product_filters_container_header_icon_sidefilters">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <div class="product_filters_container">
        <? 


// Min price
$minValue = 0;

if ($product_category > 0) {
    $stmt = $con->prepare("SELECT product_price 
                            FROM products 
                            WHERE organization='Вікар' 
                            AND category=? 
                            AND sub_сategory=? 
                            AND product_category=? 
                            ORDER BY product_price DESC");
    $stmt->bind_param("sss", $cat, $cid, $product_category);
} else {
    $stmt = $con->prepare("SELECT product_price 
                            FROM products 
                            WHERE organization='Вікар' 
                            AND category=? 
                            AND sub_сategory=? 
                            ORDER BY product_price DESC");
    $stmt->bind_param("ss", $cat, $cid);
}

// Get max price and round to 100
$stmt->execute();
$retMax = $stmt->get_result();
$rowMax = $retMax->fetch_array();
$stmt->close();

$roundMax = round($rowMax[0]);
$bcmod100 =  100 - ($roundMax % 100);
$maxValue = round($rowMax[0]) + $bcmod100;

// Price range step
$priceRangeStep = 50;
?>

        <!-- Price -->
        <section class="product_filters_container_item">
            <button type="button" class="product_filters_container_item_header">
                <p>
                    Ціна, грн
                </p>

                <span class="product_filters_container_item_header_arrow">
                </span>
            </button>

            <div class="product_filters_container_item_hidden">
                <div class="range_slider">
                    <span class="range_slider_row">
                        <input class="range_slider_row_input" id="price_range_min" type="number" value="<?=$minValue?>"
                            min="<?=$minValue?>" max="<?=$maxValue?>" />
                        <span>
                            -
                        </span>
                        <input class="range_slider_row_input" id="price_range_max" type="number" value="<?=$maxValue?>"
                            min="<?=$minValue?>" max="<?=$maxValue?>" />

                        <button type="button" class="range_slider_button range_slider_button_disable">OК</button>
                    </span>

                    <div class="range_slider_row_track">

                        <input value="<?=$minValue?>" min="<?=$minValue?>" max="<?=$maxValue?>"
                            step="<?=$priceRangeStep?>" type="range" />
                        <input value="<?=$maxValue?>" min="<?=$minValue?>" max="<?=$maxValue?>"
                            step="<?=$priceRangeStep?>" type="range" />

                        <svg width="100%" height="5px">
                            <line x1="0" y1="0" x2="100%" y2="0" stroke="#e3e8f3" stroke-width="12"></line>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <? 
            // <!-- Filter for mysql column -->
            $isProduct_cat = $product_cat ? "and product_category='$product_cat'" : '';
            $isSubProduct_cat = $sub_product ? "and product_subspec='$sub_product'" : '';

            $getAllAttributes = mysqli_query($con, "SELECT id, attributes 
                                            FROM products 
                                            WHERE organization ='Вікар' 
                                            AND category='$cat' 
                                            AND sub_сategory='$cid'
                                            $isProduct_cat 
                                            $isSubProduct_cat
                                            AND product_price > 1 
                                            GROUP BY product_work_name");
    
                /// Fetch all the filters that should not be shown
            $excludedFilters = array();
            $getExcludedFilters = mysqli_query($con, "SELECT filter_name FROM filters_dont_show");
            
            while ($rowExcludedFilters = mysqli_fetch_array($getExcludedFilters)) {
                array_push($excludedFilters, $rowExcludedFilters['filter_name']);
            }
            
            // Fetch all the attributes for the given category and sub-category
            $excludedFiltersStr = "'" . implode("', '", $excludedFilters) . "'";
            $query = "SELECT id, attributes->'$.*.name' AS name, attributes->'$.*.value' AS value
                      FROM products 
                      WHERE organization ='Вікар' 
                      AND category='$cat' 
                      AND sub_сategory='$cid'
                      $isProduct_cat 
                      $isSubProduct_cat
                      AND product_price > 1
                      AND attributes IS NOT NULL
                      AND attributes->'$.*.name' NOT IN ($excludedFiltersStr)
                      AND attributes->'$.*.value' != ''
                      GROUP BY product_work_name";
            
            $getAllAttributes = mysqli_query($con, $query);
            // Initialize an empty array to keep track of counts for each attribute value
            $attributeValueCounts = array();
            
            // Loop through each row of the result set
            while ($rowAttributes = mysqli_fetch_array($getAllAttributes)) {
                $names = $rowAttributes['name'];
                $values = $rowAttributes['value'];
            
                // Convert the JSON-encoded names and values to arrays
                $namesArray = json_decode($names, true);
                $valuesArray = json_decode($values, true);
            
                // Loop through each attribute name-value pair
                foreach ($namesArray as $key => $name) {
                    $value = $valuesArray[$key];
                    if (empty($value)) {
                        continue;
                    }
                    // Increment the count for the attribute value
                    if (isset($attributeValueCounts[$name][$value])) {
                        $attributeValueCounts[$name][$value]++;
                    } else {
                        $attributeValueCounts[$name][$value] = 1;
                    }
                }
            }
            
            
            foreach ($attributeValueCounts as $name => $values) {
            $name = cleanName($name);
        ?>
        <section class="product_filters_container_item">
            <button type="button" class="product_filters_container_item_header">
                <p><?=$name?></p>
                <span class="product_filters_container_item_header_arrow"></span>
            </button>
            <div class="product_filters_container_item_hidden">
                <div class="item_hidden_list">
                    <?php
                        // set a counter variable
                        $i = 0; 

                        foreach ($values as $value => $count) {
                            $itemHash = $name . '_' . $value;
                            $isExistCatName = $filter_object[$name];

                            $isBoxChecked = false;

                            if ($isExistCatName != NULL) {
                                $isBoxChecked = array_search($value, $isExistCatName) !== false;
                            }
                    ?>

                    <div class="item_hidden_list_row <?= $i >= 4 ? 'item_hidden_list_row_hidden"' : '';?>">
                        <input type="checkbox" class="item_hidden_list_row_checkbox"
                            <?= $isBoxChecked == true ? 'checked' : ''; ?> id="<?= $value . $itemHash ?>"
                            data-cat="<?= $name ?>" name="<?= $value ?>" />

                        <label class="item_hidden_list_row_label" for="<?= $value . $itemHash ?>">
                            <?= $value . ' (' . $count . ')' ?>
                        </label>
                    </div>
                    <?php $i++; }?>

                    <?if (count($values) > 4) { ?>
                    <button type="button" class="item_hidden_list_more_btn">
                        <span>Ще&nbsp;(<?=count($values) - 4?>)</span>
                        <p>Згорнути</p>
                    </button>
                    <?php } ?>
                </div>
            </div>
        </section>
        <?php } ?>
    </div>
</div>