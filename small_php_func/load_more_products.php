<?php
include('../includes/config.php');
include('../function.php');

$searchQuery= $_POST['searchQuery'];
$startId=$_POST['start'];
$endId=$_POST['end'];

$retDistinct=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_work_name
                                FROM products
                                WHERE organization='Вікар' 
                                and product_price > 1
                                $searchQuery
                                ORDER BY product_availability DESC
                                ");

$numDistinct=mysqli_num_rows($retDistinct);

// For set in scripts max num of rows
if ($_POST['isGetNum'] == 'true') {
    echo($numDistinct);
    exit;
}

if($numDistinct>0):
    $i=0;
    $iLoadMoreItem = 0;
    $existedNames = [];
    
    while($rowDisctinct=mysqli_fetch_array($retDistinct)):   
        $isExist = array_search($rowDisctinct['product_work_name'], $existedNames);
        
        if ($isExist === false):                            
            
            ++$iLoadMoreItem;

            if($iLoadMoreItem > $startId && $iLoadMoreItem <= $endId){
                array_push($existedNames, $rowDisctinct['product_work_name']);
                $ret=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_name, product_spec, product_availability, product_count, product_old_price, product_price, productImage1
                                        FROM products 
                                        WHERE organization='Вікар' 
                                        AND c_code='$rowDisctinct[c_code]' 
                                        AND characteristic_uuid='$rowDisctinct[characteristic_uuid]'
                                        ");
                $row=mysqli_fetch_array($ret);

                include('../includes/display_product_card_item.php');
            };
    endif;
endwhile;
endif;
?>