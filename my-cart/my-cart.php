<? 
if(empty($_SESSION['cart'])){
    echo "<script type='text/javascript'> document.location ='index.php'; </script>";
}
$user_email = $_SESSION['login'];
$fio = mysqli_query($con,"SELECT name,midle_name,last_name,email,contactno,bonus from users where email='$user_email'");
$row = mysqli_fetch_array($fio);
$user_bonus = $row['bonus'];

if ($user_bonus == 'NULL') {
    $user_bonus = 0;
}
?>
<div class="b-popup" id="popup1">
    <div class="b-popup-content">
        <p class="close_city">X</p>
        <span id="select-city">
            <p style="text-align:center;font-weight:bold;font-size:20px;">Оберіть місто</p>
            <p id="load-getCity" style="display:none;">
                <img width="70" src="/assets/load.gif">
            </p>
            <span id="get_city"></span>
        </span>
        <br />
        <div>
            <div class="serch_row">
                <input type="text" placeholder="Знайти місто" class="input serch_cit" value="" name="lastname">
            </div>

            <p id="load" style="display:none;">
                <img src="img/load.gif" style="width:200px;height:200px;">
            </p>
        </div>
        <span class="res"></span>
    </div>
</div>

<div class="container-fluid">
    <div class="cash">
        <main class="content" style="border-top: 0px;">
            <section class="view container">
                <div class="order">
                    <div class="clear">
                        <div class="order-info left single_order">
                            <!-- Форма Фізичной особи -->
                            <span id="fiz-osoba" style="display:block;">
                                <div class="personal_data">
                                    <h2 class="header_yellow" style="color:#8EC340;">Персональні дані</h2>

                                    <div class="user_city" style='display:none;'>
                                        <div class="left user-info-wrapper clear left">
                                            <span class="js-popup box-signin signin dotted dotted-blue left">
                                                <?=$name?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="order_block">
                                        <div class="person_switcher_container">
                                            <label class="label label-radio left clear">
                                                <input class="input-hidden person" value="natural_person" name="person"
                                                    checked="" type="radio">
                                                <span class="label-radio__icon left radio_fiz"
                                                    style="background:#fff;border:4px solid #8EC340"></span>
                                                <span class="label-radio__text left" id="fiz" style="font-weight:bold;">
                                                    Фіз особа
                                                </span>
                                            </label>
                                            <label class="label label-radio left clear">
                                                <input class="input-hidden person" value="legal_person" name="person"
                                                    type="radio">
                                                <span class="label-radio__icon left radio_fiz"></span>
                                                <span class="label-radio__text left" id="your">
                                                    Юридична особа
                                                </span>
                                            </label>
                                        </div>
                                        <div class="personal_data_container">

                                            <div class="personal_data_input">
                                                <span class="required">*</span>
                                                <input type="text" name="firstname" id="fiz_name" placeholder="Ім'я"
                                                    class="input" placeholder="Имя" value="<?=$_SESSION['username']?>">
                                            </div>

                                            <div class="personal_data_input natural_person_only">
                                                <span class="required changable" style="display: none">*</span>
                                                <input type="text" id="fiz_midlname" name="middlename"
                                                    value="<?=$row['midle_name'];?>" class="input"
                                                    placeholder="По батькові">
                                            </div>
                                            <div class="personal_data_input natural_person_only">
                                                <span class="required">*</span>

                                                <input type="text" name="lastname" id="fiz_lastname"
                                                    value="<?=$row['last_name'];?>" class="input"
                                                    placeholder="Прізвище">
                                            </div>
                                            <div class="personal_data_input">
                                                <span class="required">*</span>
                                                <input type="tel" name="phone" id="fiz_phone"
                                                    placeholder="+38(___)_______" class="input" maxlength="15"
                                                    value="<?=$row['contactno'];?>">
                                            </div>
                                            <div class="personal_data_input">
                                                <span class="required">*</span>
                                                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                    name="email" about="" class="input email" placeholder="e-mail"
                                                    value="<?=$row['email'];?>">
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </span>
                            <!-- Форма Юридичной осбои -->
                            <span id="your-osoba" style="display:none;">
                                <div class="personal_data">
                                    <h2 class="header_yellow" style="color:#8EC340;">Персональні дані</h2>
                                    <div class="user_city">
                                        <div class="left user-info-wrapper clear left">

                                            <span class="js-popup box-signin signin dotted dotted-blue left">
                                                <?=$name?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="order_block">
                                        <div class="person_switcher_container"> <label
                                                class="label label-radio left clear">
                                                <span class="label-radio__icon left"
                                                    style="background:#E6E6E6;border:1px solid #E5E5E5;"></span>
                                                <span class="label-radio__text left" id="fiz"
                                                    style="font-weight:normal;">
                                                    Фіз особа
                                                </span>
                                            </label>
                                            <label class="label label-radio left clear">
                                                <span class="label-radio__icon left"
                                                    style="background:#fff;border:4px solid #8EC340"></span>
                                                <span class="label-radio__text left" id="your"
                                                    style="font-weight:bold;">
                                                    Юридична особа
                                                </span>
                                            </label>
                                        </div>
                                        <div class="personal_data_container">

                                            <div class="personal_data_input legal_person_only new_org_input"
                                                style="display: block;">
                                                <span class="required">*</span>
                                                <input type="text" name="edrpou" class="input" id="yur_code"
                                                    placeholder="Код ЄДРПОУ">
                                            </div>
                                            <div class="personal_data_input legal_person_only new_org_input"
                                                style="display: block;">
                                                <span class="required">*</span>
                                                <input type="text" name="company_name" class="input" id="yur_company"
                                                    placeholder="Найменування організації">
                                            </div>

                                            <div class="personal_data_input"> <span class="required">*</span>
                                                <input type="tel" name="phone" id="yur_phone" value="" class="input"
                                                    placeholder="+38(___)_______" maxlength="15">
                                            </div>

                                            <div class="personal_data_input">
                                                <span class="required">*</span>
                                                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                                                    name="email" about="" value="" class="input email_yur"
                                                    placeholder="e-mail">
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </span>
                            <!-- end Форма Юридичной особи -->

                            <!-- Замовлення -->
                            <div class="order_item order-item-0">
                                <h2 class="header_yellow order_number" style="color:#8EC340;">
                                    Замовлення
                                </h2>
                                <div class="order_block left_border">
                                    <div class="delivery_data_block left">
                                        <div class="city_block city">
                                            <span class="svg svg-placemark"> </span>
                                            <span class="my-city-text"> Моє місто: </span>
                                            <a href="#"
                                                class="js-ordercity-popup dotted dotted-blue choose-city-switch">
                                                <span class="dotted-text openCity" id="city"
                                                    data="8d5a980d-391c-11dd-90d9-001a92567626">
                                                    Київ
                                                </span>
                                            </a>
                                            <div class="choose-other-city-wrapper">
                                                <span class="dotted-text" id="select_city">Обрати інше місто</span>
                                            </div>
                                        </div>

                                        <div class="delivery_target_block">
                                            <h3>Спосіб доставки</h3>

                                            <!-- Самовивіз -->
                                            <div
                                                class="order-row order-row__label targets_container own_targets_container">
                                                <div class="order-row order-row__label switcher_row">
                                                    <label class="label left clear">
                                                        <input name="delivery1" class="input-hidden delivery_radio"
                                                            value="self" required="required" type="radio"
                                                            data-serviceid="10">
                                                        <span class=" left"
                                                            style='display: flex; align-items: center; column-gap: 7px;'>
                                                            <label class="radiobox" id='1'>
                                                                <input class='box' type="radio" name="check" value="0"
                                                                    style="margin: 5px 6px 0 0;" checked>
                                                                Самовивіз із магазину
                                                            </label>
                                                            <label style='color:#666; padding-top: 7px'>(БЕЗКОШТОВНО)
                                                                1-2 дні</label>
                                                        </span>
                                                    </label>
                                                </div>
                                                <span class="pochta-block1">
                                                    <div class="order-row select_row">
                                                        <span
                                                            class="select2-container select2-container--default select2-container--open servicedelivery_targets_dropdown opened adres_pochta"
                                                            style="position: absolute; top: 45.75px; left:1px;display:none;">
                                                            <span class="select2-dropdown select2-dropdown--above"
                                                                dir="ltr" style="width: 350px;">
                                                                <p id="load1" style="display:none;">
                                                                    <img width="70" src="/assets//load.gif">
                                                                </p>
                                                                <span
                                                                    class="select2-search select2-search--dropdown"></span>
                                                                <span class="select2-results">
                                                                    <ul class="select2-results__options" role="tree"
                                                                        style="overflow-y: initial;"
                                                                        id="select2-np_office_target-x5-results">
                                                                        <span id="sel_city1"></span>
                                                                    </ul>
                                                                </span>
                                                            </span>
                                                        </span>
                                                        <span
                                                            class="select2 select2-container select2-container--default"
                                                            dir="ltr" style="width: 351px;" data="0">
                                                            <span class="selection">
                                                                <span
                                                                    class="select2-selection select2-selection--single"
                                                                    role="combobox" tabindex="0">
                                                                    <span class="select2-selection__rendered"
                                                                        id="select2-own_selfdelivery_target-it-container"
                                                                        title="Оберіть звідки забирати">
                                                                        <?php
                                                                            $session_delivery_address = $_SESSION['delivery_address'];
                                                                            if(gettype($session_delivery_address) !== 'NULL'){
                                                                                echo($session_delivery_address);
                                                                            }else{
                                                                                echo('Оберіть звідки забирати');
                                                                            }
                                                                        ?>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="select-desc hidden muted clear">
                                                        <br />
                                                    </div>
                                                </span>
                                            </div>
                                            <!-- Нова пошта -->
                                            <div
                                                class="order-row order-row__label targets_container np_office_targets_container">
                                                <div class="order-row order-row__label switcher_row">
                                                    <label class="label label-radio left clear">
                                                        <input name="delivery2" class="input-hidden delivery_radio"
                                                            value="service" required="required" type="radio"
                                                            data-serviceid="8">
                                                        <span class="left">
                                                            <label class="radiobox" id='2'>
                                                                <input class='box2' type="radio" name="check" value="0"
                                                                    style="margin: 8px 6px 0 0;">
                                                                Самовивіз із відділення Нової Пошти
                                                            </label>
                                                            <label>2-3 дні</label>

                                                            <span class="pochta"></span>
                                                        </span>
                                                    </label>
                                                </div>

                                                <span class="pochta-block">
                                                    <span data="0"
                                                        class="select2 select2-container select2-container--default">
                                                        <span class="selection">
                                                            <span tabindex="0" aria-expanded="false"
                                                                aria-haspopup="true" role="combobox"
                                                                class="select3-selection select2-selection--single"
                                                                style="padding: 8px 10px 8px 10px;height:auto;border: 1px solid #ccc;">

                                                                <span title="звідки забирати (почніть писати...)"
                                                                    id="select2-own_selfdelivery_target-it-container"
                                                                    class="select3-selection__rendered">
                                                                    Оберіть звідки забирати
                                                                </span>

                                                                <span role="presentation"
                                                                    class="select2-selection__arrow">
                                                                    <b role="presentation"></b>
                                                                </span>
                                                            </span>
                                                        </span>

                                                        <span aria-hidden="true" class="dropdown-wrapper"></span>
                                                        <span
                                                            style="position: absolute; top: 30.75px; left: 1px; display: none;"
                                                            class="select2-container select2-container--default select2-container--open servicedelivery_targets_dropdown opened adres_pochta2">
                                                            <span class="select2-dropdown select2-dropdown--above"
                                                                dir="ltr" style="width: 350px;">
                                                                <span class="select2-search select2-search--dropdown">
                                                                    <p id="load2" style="display:none;">
                                                                        <img width="70" src="/assets//load.gif">
                                                                    </p>
                                                                    <input type="text" class="input"
                                                                        placeholder="чи скористайтесь пошуком"
                                                                        style="border-radius:10px" id="serch_otdelenie">
                                                                </span>
                                                                <span class="select2-results">
                                                                    <ul class="select2-results__options" role="tree"
                                                                        id="select2-np_office_target-x5-results"
                                                                        data="pochta">
                                                                        <span id="sel_city2">

                                                                        </span>
                                                                    </ul>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                    <div class="select-desc hidden muted clear">
                                                        <br />
                                                    </div>
                                                </span>
                                            </div>
                                            <!-- Кур'єром VIKAR за адресою -->
                                            <div
                                                class="order-row order-row__label targets_container courier_targets_container">
                                                <div class="order-row order-row__label switcher_row">
                                                    <label class="label label-radio left clear"
                                                        style="text-align: left;">
                                                        <input name="delivery3" class="input-hidden delivery_radio"
                                                            value="courier" required="required" type="radio">
                                                        <label class="radiobox" id='3'>
                                                            <input class='box3' type="radio" name="check" value="0"
                                                                style="margin: 2.5px 6px 0 0;">
                                                            Кур'єром VIKAR за адресою
                                                        </label>
                                                        <label>
                                                            2-3 дні
                                                        </label>
                                                        <div class="courier-target-block">
                                                            <div class="form-address__row clear">
                                                                <div class="order-row clear">
                                                                    <input type="text" name="shipping_street"
                                                                        class="input left delivery_street_autocomplete ui-autocomplete-input ui-autocomplete-loading"
                                                                        id="street" placeholder="Вулиця"
                                                                        autocomplete="off">
                                                                </div>
                                                                <div class="order-row clear">
                                                                    <input type="text" name="shipping_building"
                                                                        class="input input-tiny-delivery left"
                                                                        id="house" placeholder="Будинок">
                                                                </div>

                                                                <div class="order-row clear">
                                                                    <input type="text" name="shipping_remark"
                                                                        class="input left" id="apartment"
                                                                        placeholder="Квартира">
                                                                </div>
                                                            </div>
                                                            <b role="presentation"></b>
                                                            <span class="dropdown-wrapper" aria-hidden="true"></span>
                                                            </span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Оплата готівкою або платіжною карткою Visa/MasterCard -->
                                        <div class="delivery_payment_block">
                                            <h3>Спосіб оплати</h3>

                                            <div class="payment_data_block">
                                                <!--  -->
                                                <div
                                                    class="order-row order-row__label payment_type_block person_only natural_person_only payments-types">
                                                    <label id="payment-type-4"
                                                        class="label label-radio left clear cash-changeable">
                                                        <span class="left">
                                                            <label class="radioboxs" data="1">
                                                                <input type="radio" id="pay2" name="pay" value="0"
                                                                    checked style="margin: 2.5px 6px 0 0;">
                                                                <span class="yur_cart pay">
                                                                    Оплата готівкою або платіжною карткою
                                                                    Visa/MasterCard
                                                                </span>
                                                            </label>
                                                        </span>
                                                    </label>
                                                    <p class='nova_poshta_payment_message'>
                                                        Вартість доставки за тарифами Нової Пошти від 65 грн та
                                                        комісія за післяплату 20 грн. + 2% від суми замовлення
                                                    </p>
                                                    <label id="payment-type-9" class="label label-radio left clear">
                                                        <span class="left">
                                                            <label class="radioboxs" data="2">
                                                                <input type="radio" id="pay" name="pay" value="0"
                                                                    style="margin: 2.5px 6px 0 0;">
                                                                <span class="liq_yur">
                                                                    Онлайн оплата карткою (LiqPay)
                                                                </span>
                                                            </label>
                                                        </span>
                                                    </label>
                                                    <p class='nova_poshta_payment_message'>
                                                        Вартість доставки за тарифами Нової Пошти від 65 грн
                                                    </p>
                                                    <label id="payment-type-9" class="label label-radio left clear">
                                                        <span class="left">
                                                            <label class="radioboxs" data="2">
                                                                <input type="radio" id="pay3" name="pay" value="0"
                                                                    style="margin: 2.5px 6px 0 0;">
                                                                <span class="liq_yur">
                                                                    По безготівковому розрахунку (рахунок-фактура)
                                                                </span>
                                                            </label>
                                                        </span>
                                                    </label>
                                                    <div class="payment_info">
                                                        <span> Найменування одержувача:</span>
                                                        <span> ФОП Дикунець Ярослав Павлович</span>
                                                    </div>
                                                    <div class="payment_info">
                                                        <span> Код одержувача:</span>
                                                        <span> 3301500530</span>
                                                    </div>

                                                    <div class="payment_info">
                                                        <span> Рахунок одержувача у форматі IBAN:</span>
                                                        <span> UA173052990000026005030124921</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Комментар -->
                                        <div class="comment_block">
                                            <span class="dotted-text" style="border: none; padding: 10px 0px;">
                                                Коментар до замовлення
                                            </span>
                                            <textarea name="comment" placeholder="Ваш коментар"
                                                class="input input-textarea cart-comment " id="comment"></textarea>
                                        </div>
                                    </div>

                                    <!-- Product list -->
                                    <div class="pr_price_block left">
                                        <div class="bokeh"></div>
                                        <?
                                            $pdtid=array();
                                            // Trim word price and get poduct code in masive
                                            $i = 0;
                                            foreach($_SESSION['cart'] as $id => $value){
                                                $id ;	 
                                                $ret=mysqli_query($con,"SELECT * from products where organization='Вікар' and c_code='$value[pid]' and characteristic_uuid='$value[char_hash]'");
                                                $num=mysqli_num_rows($ret);
                                                while ($row=mysqli_fetch_array($ret)):
                                                    $c_code_top         = $row['c_code'];
                                                    $c_category_id_top  = $row['category'] ;
                                                    $c_group_key_top    = $row['sub_сategory'];
                                                    $c_product_key_top  = $row['product_category'];
                                                    $c_product_name_top = $row['product_name'];
                                                    $c_description_top  = $row['product_description'];
                                                    $c_main_value_top   = $row['main_value'];
                                                    $c_second_value_top = $row['second_value'];
                                                    $c_price_top	    = $row['product_price'];
                                                    $c_photo1_top		= $row['productImage1'];
                                                    $c_availability_top	= $row['product_availability'];
                                                    $c_organization_top = $row['organization'];
                                                    $c_video_top		= $row['product_video'];
                                                    $c_old_price_top	= $row['product_old_price'];
                                                    $c_second_price_top = $row['product_price_second'];
                                                    $c_promo_top 		= $row['product_promotional'];
                                                    $price_unit= $_SESSION['cart'][$id]['price'];
                                                    $c_characteristic_uuid = $row['characteristic_uuid'];
                                                    $product_spec = $row['product_spec'];
                                                    $productLink = generateProductDetailsUrl($c_product_name_top, $product_spec);
                                                
                                                ?>
                                        <div id="price_per_unit" value="<? $price_unit ?>"></div>
                                        <div class="products" id="prod<?=$i?>" data="<?=$c_code_top?>">
                                            <div class="stuff-order main clear " data-id="<?=$i?>"
                                                data-product-code="<?=$c_code_top?>" data-exclusive-code=""
                                                data-class-name="<?=$c_product_name_top?>" data-stuff-type="main">
                                                <div class="header-row">
                                                    <!-- Видалити -->
                                                    <span class="cart-rm js-cart-rm">
                                                        <i class="icon icon-rm" data="<?=$i?>"
                                                            data-code="<?=$c_code_top?>"
                                                            data-char="<?=$c_characteristic_uuid?>"></i>
                                                    </span>

                                                    <span class='prod<?=$i?>' style="display:none;">
                                                        <?=$c_code_top?>
                                                    </span>
                                                    <a href="#" class="add add-fav" data-code="<?=$c_code_top?>"
                                                        data-id="<?=$i?>" data-name="<?=$c_product_name_top?>"
                                                        data-price="<?=$price_unit?>" title="Отложить">
                                                    </a>
                                                </div>
                                                <div class="header_row">
                                                    <!-- Зображення -->
                                                    <a href="<?=$productLink?>" class="stuff-img left">
                                                        <img style=" object-fit: contain;" width="150" height="100" src="<? if($c_photo1_top=='') {
                                                            echo'categoryImage/no_foto.png'; 
                                                        }else{
                                                            echo 'images/'.$c_photo1_top;}?>"
                                                            alt="<?=$c_product_name_top?>"
                                                            title="<?=$c_product_name_top?>">
                                                    </a>
                                                    <div class="stuff-desc left">
                                                        <!-- Назва -->
                                                        <div class="stuff-caption">
                                                            <a href="<?=$productLink?>"
                                                                title="<?=$c_product_name_top?>">
                                                                <?=$c_product_name_top?>
                                                            </a>
                                                        </div>
                                                        <!-- Код -->
                                                        <div class="stuff-avail">
                                                            <span class="stuff-code muted">
                                                                код: <?=$c_code_top?>
                                                            </span>
                                                        </div>
                                                        <div class="stuff-stock__wrapper"></div>
                                                    </div>
                                                </div>

                                                <div class="stuff-price__row stuff-price__has-sale left">
                                                    <!-- Кількість -->
                                                    <div class="scada">
                                                        <button class="plusmin plusmin-minus minus"
                                                            data-code="<?=$c_code_top?>"
                                                            data-unit="<?= $_SESSION['cart'][$id]['product_unit']?>"
                                                            id="min<?=$i?>" data-char='<?=$c_characteristic_uuid?>'>
                                                            -
                                                        </button>
                                                        <input type="text" class="popup-stuff__count-value quantity"
                                                            value="<?echo $_SESSION['cart'][$id]['quantity'];?>"
                                                            data-price="<?=$price_unit?>" id="val<?=$i?>">

                                                        <button class="plusmin plusmin-plus plus2"
                                                            data-code="<?=$c_code_top?>"
                                                            data-unit="<?= $_SESSION['cart'][$id]['product_unit']?>"
                                                            id="pl<?=$i?>"
                                                            data-char='<?=$c_characteristic_uuid?>'>+</button>
                                                    </div>
                                                    <!-- Вид -->
                                                    <div style="font-size:22px;border:1px solid #a29898;padding:7px;">
                                                        <?
                                                            if($_SESSION['cart'][$id]['product_unit'] == "$c_main_value_top"){
                                                                echo "
                                                                <span id='unit$i' style='width: 0px; height: 0px; opacity: 0;'>
                                                                1
                                                                </span>$c_main_value_top";
                                                            } elseif ( $_SESSION['cart'][$id]['product_unit'] == "$c_second_value_top"){ 
                                                                echo "<span id='unit$i' style='width: 0px; height: 0px; opacity: 0;'>0</span>$c_second_value_top";
                                                            }
                                                        ?>
                                                        .
                                                    </div>
                                                    <!-- Ціна -->
                                                    <span class="stuff-price right">
                                                        <strong class="stuff-price__digits scada"><span
                                                                id="price<?=$i?>" data-old-price="<?=$price_unit?>"
                                                                class="prices">
                                                                <?=$price_unit * $_SESSION['cart'][$id]['quantity'];?>
                                                            </span>
                                                        </strong>
                                                        <span class="stuff-price__currency">грн</span>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                        <? $i++; endwhile; }?>

                                        <div class="promocode_bonuses_row">
                                            <!-- Promocode -->
                                            <div class="user_bonuse_row">
                                                <label for="my-promocode" class="user_bonuse_row_text">
                                                    Промокод:
                                                </label>

                                                <input id="my-promocode" type="text" class="input input-bonus"
                                                    placeholder="Введіть промокод">

                                                <span id="my-promocode_error">Невірний промокод</span>

                                                <button type='button' id='apply_promocode' class='btn apply'>
                                                    Застосувати промокод
                                                </button>
                                            </div>

                                            <!-- Bonuses -->
                                            <div class="user_bonuse_row">
                                                <label for="my-bonuses" class="user_bonuse_row_text">
                                                    Бонусів: <?=intval($user_bonus);?> грн.
                                                </label>

                                                <div class="user_bonuse_row_input_block">
                                                    <input id="my-bonuses" type="number"
                                                        value='<?=intval($user_bonus);?>' min="0"
                                                        max='<?=intval($user_bonus);?>' step="1"
                                                        data-user-mail='<?=$user_email;?>' class="input input-bonus"
                                                        placeholder="<?=$user_bonus?>">
                                                    <span>грн.</span>
                                                </div>

                                                <button type='button' id='apply_bonus' class='btn apply disabled'>
                                                    Застосувати бонуси
                                                </button>
                                            </div>
                                        </div>


                                        <div class="price none" style="display: block;">
                                            <!-- Відображення промокода після застосування -->
                                            <div class="cart-total__sum clear applied_promocode_block">
                                                <span class="left title">
                                                    Знижка за промокодом
                                                </span>

                                                <div class="right ">
                                                    <span class="stuff-price total-price small">
                                                        <strong class="stuff-price__digits scada">
                                                            <span id="applied_promocode"></span>
                                                        </strong>
                                                        <span class="stuff-price__currency">
                                                            %
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Відображення бонусів після застосування -->
                                            <div class="cart-total__sum clear applied_bonuses_block">
                                                <span class="left title">
                                                    Застосовані бонуси
                                                </span>

                                                <div class="right ">
                                                    <span class="stuff-price total-price small">
                                                        <strong class="stuff-price__digits scada">
                                                            <span id="applied_bonuses"></span>
                                                        </strong>
                                                        <span class="stuff-price__currency">
                                                            грн
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Загальна вартість -->
                                            <div class="cart-total__sum clear products_amount">
                                                <span class="left title">
                                                    Загальна вартість
                                                </span>

                                                <div class="right ">
                                                    <span class="stuff-price total-price small">
                                                        <strong class="stuff-price__digits scada">
                                                            <span id="total_price">
                                                                <?=$price?>
                                                            </span>
                                                        </strong>
                                                        <span class="stuff-price__currency">
                                                            грн
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Вартість доставки -->
                                            <div class="cart-total__sum clear products_amount">
                                                <div class="left title">Вартість доставки</div>
                                                <div class="right "> <span class="stuff-price total-price small">
                                                        <strong class="stuff-price__digits scada">
                                                            <span id="delivery"><?=$delivery?></span></strong>
                                                        <?if($delivery>0){?> <span
                                                            class="stuff-price__currency">грн</span>
                                                        <?}?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!--  Натискаючи оформити замовлення -->
                                        <div class="form-group checks">
                                            <p>
                                                <label style="cursor:pointer;">
                                                    *Підтверджуючи замовлення я приймаю умови публічної
                                                    <a style="color:#8ec340;" href="/page/oferta"
                                                        target="_blank">оферти</a>
                                                    та надаю згоду на
                                                    <a style="color:#8ec340;" href="/page/personalDate"
                                                        target="_blank">обробку персональних даних</a>
                                                </label>
                                            </p>
                                        </div>
                                        <p style="margin:15px;">
                                            <button id="cart-add" type="button" class="btn-upper btn">
                                                Оформити замовлення
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>