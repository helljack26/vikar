<?php
include('../../includes/config.php');
include('../../function.php');

$sqlQuery = $_POST['sqlQuery'];
$isPopularSort = $_POST['isPopularSort'];
$current_filter_url = $_POST['current_filter_url'];

$category = $_POST['category'];
$sub_сategory = $_POST['sub_сategory'];
$product_category = "and product_category='$_POST[product_category]'";
$product_subspec = "and product_subspec='$_POST[product_subspec]'";

$isLoadMoreScrollQuery = $_POST['isLoadMoreScrollQuery'];

$start = $isLoadMoreScrollQuery == 'false' ? 0 : intval($isLoadMoreScrollQuery['start']);
$end = $isLoadMoreScrollQuery == 'false' ? 10 : intval($isLoadMoreScrollQuery['end']);

if ($_POST['product_category'] == '') {
    $product_category = '';
    $product_subspec = '';
}

if ($_POST['product_subspec'] == '') {
    $product_subspec = '';
}

$filterClause = filter_db_query_from_url($current_filter_url);

$filter_db_query = $filterClause['filter_db_query'];

$get_products=mysqli_query($con, "SELECT c_code, characteristic_uuid, product_name, product_spec, product_availability, product_count, product_old_price, product_price, productImage1 
                                    FROM products 
                                    WHERE organization='Вікар' 
                                    AND category='$category' 
                                    AND sub_сategory='$sub_сategory' 
                                    $product_category 
                                    $product_subspec 
                                    $filter_db_query
                                    $sqlQuery
                                ");

$num_products=mysqli_num_rows($get_products);
// New array with field reviewsCount  
$popularSortedItems = [];

if($num_products>0){
    $iLoadMoreItem = 0;
    $existedNames = [];

    if ($isPopularSort == 'true') { 
        while ($row=mysqli_fetch_array($get_products)): 
            
            // Get reviews count from productreviews
            $reviewRow = mysqli_query($con,"SELECT * 
                                            FROM productreviews 
                                            WHERE productId='$row[c_code]'");
            $numReview = mysqli_num_rows($reviewRow);
            if($numReview > 0){
                $newRow = $row ;
                $newRow += ["reviewsCount" => $numReview];
                array_push($popularSortedItems, $newRow);
            }else{
                $newRow = $row;
                $newRow += ["reviewsCount" => 0];
                array_push($popularSortedItems, $newRow);
            }
        endwhile; 
        usort($popularSortedItems, function($a, $b){
            return ($b['reviewsCount'] - $a['reviewsCount']);
        });
        $i = 0;
        while ($i < count($popularSortedItems)): 
            
            $row = $popularSortedItems[$i];
            $isExist = array_search($row['product_work_name'], $existedNames);
            if ($isExist === false):
                ++$iLoadMoreItem;
                if($iLoadMoreItem > $start && $iLoadMoreItem < $end){
                    include('../../includes/display_product_card_item.php');
                    $i++;
                }
            endif;
        endwhile; 

    // Not popular query
    } else {
        $iLoadMoreItem = 0;
        $existedNames = [];

        while ($row=mysqli_fetch_array($get_products)): 
            $isExist = array_search($rowDisctinct['product_work_name'], $existedNames);

            if ($isExist === false):
                ++$iLoadMoreItem;
                if($iLoadMoreItem > $start && $iLoadMoreItem <= $end){
                    include('../../includes/display_product_card_item.php');
                };
            endif;
        endwhile; 

        echo("<input type='hidden' id='max_number' value='$num_products'>");
    }
    echo mysqli_error($con);
} else {
    echo('<h2 class="product_category_row_results_block_empty">За цим запитом товари не знайдені.</h2>');
} 
?>