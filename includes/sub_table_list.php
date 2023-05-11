<!-- Table list -->
<div class="product_table_container">
    <h1>
        <?=$subCatName?>
    </h1>
    <table class="tb">
        <tr align="center">
            <td>
                <b>НАЗВА</b>
            </td>
            <td>
                <span class="product_table_container_table_header_desktop">
                    <b>ОДИНИЦЯ</b>
                </span>
                <span class="product_table_container_table_header_mobile">
                    <b>Од.</b>
                </span>
            </td>
            <td>
                <span class="product_table_container_table_header_desktop">
                    <b>КІЛЬКІСТЬ</b>
                </span>
                <span class="product_table_container_table_header_mobile">
                    <b>КІЛ.</b>
                </span>
            </td>
            <td>
                <b>ЦІНА</b>
            </td>
        </tr>
        <?php
            $retDistinct=mysqli_query($con,"SELECT c_code, characteristic_uuid, product_work_name
                                                FROM products
                                                WHERE organization='Вікар' 
                                                AND category='$cat' 
                                                AND sub_сategory='$cid' 
                                                AND product_price > 1 
                                                ORDER BY product_availability DESC, product_article");
                $numDistinct=mysqli_num_rows($retDistinct);
                $existedNames = [];
                if($numDistinct>0):
                    $i=0;
                    while($rowDisctinct=mysqli_fetch_array($retDistinct)):   
                        $isExist = array_search($rowDisctinct['product_work_name'], $existedNames); 
                        if ($isExist === false):
                        $ret=mysqli_query($con,"SELECT * 
                                                FROM products 
                                                WHERE organization='Вікар' 
                                                and c_code='$rowDisctinct[c_code]' 
                                                and characteristic_uuid='$rowDisctinct[characteristic_uuid]'
                                                ");
                        $row=mysqli_fetch_array($ret); 
                    
                        $c_product_name = $row['product_name'];
                        $c_product_spec = $row['product_spec'];
                        $productLink = generateProductDetailsUrl($c_product_name, $c_product_spec);
                        
                        ?>
        <div>
            <tr align="center">
                <td>
                    <a class="table_name" href="<?=$productLink?>">
                        <?=$row['product_name'] ?>
                    </a>
                </td>
                <td>
                    <select class="select_tb data-id<?=$i?>" data="<?=$row['c_code']?>"
                        id="product_unit<?=$row['c_code']?>" name="product_unit">
                        <option value="<?=$row['product_price_second'], $row['main_value']?>">
                            <?=$row['main_value']?>
                        </option>
                        <option value="<?=$row['product_price'], $row['second_value']?>">
                            <?=$row['second_value']?>
                        </option>
                    </select>
                </td>
                <td>
                    <div class="product_table_container_table_buttons">
                        <button type="button" class="plusmin plusmin-minus minus" id="min<?=$row['c_code']?>">
                            <span>
                                -
                            </span>
                        </button>
                        <input type="text" class="popup-stuff__count-value quantity" data-num="<?=$i?>" value="1"
                            data-price="<?=$row['product_price']?>" id="val<?=$row['c_code']?>" name="quantity">
                        <button type="button" class="plusmin plusmin-plus plus2" id="pl<?=$row['c_code']?>">
                            <span>
                                +
                            </span>
                        </button>
                    </div>
                </td>
                <td class="button_td">
                    <span class="price<?=$row['c_code']?> price-all" id="price<?=$i?>"
                        data-price="<?=$row['product_price_second']?>">
                        <?=$row['product_price_second']?>
                    </span>

                    <div class="table_buttons_row">
                        <?php if($row['product_availability'] >=1 || $row['product_count'] >=1){?>

                        <button type="button" id="table_product_buy<?=$row['c_code']?>"
                            data-code="<?php echo $row['c_code']?>" data-char='<?=$row['characteristic_uuid']?>' class="table_buttons_row_basket table_buttons_row_btn 
                                <? if (isExistInBasket($row['c_code'], $row['characteristic_uuid']) != 'Купити') {
                                    echo('table_buttons_row_basket_active');
                                }?>">
                            <? echo(isExistInBasket($row['c_code'], $row['characteristic_uuid']));?>
                        </button>

                        <?php } else {?>
                        <button type="button" class="table_buttons_row_btn product_info_isAvailable"
                            data-product-code="<?php echo $row['c_code']?>"
                            data-char='<?=$row['characteristic_uuid']?>'>
                            Уточнити наявність
                        </button>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        </div>
        <? endif; endwhile; endif; ?>
    </table>
</div>

<script src="assets/js/sub_table_list.js"></script>