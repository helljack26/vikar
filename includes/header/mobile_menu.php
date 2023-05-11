<?require_once 'function.php';?>
<div class="mobile_menu_padding"></div>
<div class="mobile_menu">
    <!-- Header -->
    <div class="mobile-navbar-header">
        <button class="mobile-navbar-toggle" type="button">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="mobile-navbar-header_logo">
            <a href="/" class="mobile-navbar-logo_link">
                <img src="assets/logo_vikar.png" class="mobile-navbar-logo" height="35px" width="190px"
                    alt="Vikar logo">
            </a>
        </div>
        <!-- Search -->
        <form class="mobile_search_form mobile_search_form_tablet" method="get" action="search-result.php">
            <input class="mobile_search_form_input search-field" placeholder="Шукати товар..." name="search" />
            <button class="mobile_search_form_button"></button>
            <div class="mobile_search_wrapper search_wrapper"></div>
        </form>
        <div class="mobile-navbar-header_links">
            <button class="mobile-navbar-phones_btn" type="button">
                <img src="assets/icon/phone_icon.svg" height="24px">
            </button>
            <?
            $user_email = $_SESSION['login'];
            if(gettype($user_email) !== 'NULL'){?>
                <a class="header_wish_count_mobile_button" href="wishlist">
                    <img src="assets/icon/heart_icon.svg" height="25px" alt="">
                    <?php
                        $get_wishCount=mysqli_query($con,"SELECT * from wishlist where userid='$_SESSION[id]'");
                        $wishCountNum=mysqli_num_rows($get_wishCount);
                        if ($wishCountNum > 0) {
                            echo("
                                <span class='wish_count header_wish_count'>$wishCountNum</span>
                            ");
                        }
                        ?>
                </a>
            <? } ?>
            <a href="my-cart.php" class="mobile-navbar-header_links_basket">
                <img src="assets/icon/basket_white_icon.svg" height="25px" alt="">
                <span class='count' style="display:
                    <?
                    if($get_basketCountItems == 0) {
                        echo(" none"); } ?>;">
                    <? echo($get_basketCountItems);?>
                </span>
            </a>
            <?
            $user_email = $_SESSION['login'];
            if(gettype($user_email) === 'NULL'){?>
                <a href="login">
                    <img src="assets/icon/user_icon.svg" height="25px" alt="">
                </a>
            <?} else{ ?>

                <a href="my-account">
                    <img src="assets/icon/user_icon.svg" height="25px" alt="">
                </a>
                <a href="logout">
                    <img src="assets/icon/exit_icon.svg" height="25px" alt="">
                </a>
            <? } ?>
        </div>
    </div>
    <!-- Phones popup -->
    <div class="mobile-navbar-phones">
        <button class="mobile-navbar-phones_close" type='button'></button>
        <span class="mobile-navbar-phones_header">
            Iнтернет магазин "Vikar"
        </span>
        <div class="mobile-navbar-phones_links">
            <div class="mobile-navbar-phones_links_link">
                <span class="mobile-navbar-phones_icon_phone"></span>
                <a href="tel:0 800 330 098" class="mobile-navbar-phones_text">
                    0 800 330 098
                </a>
            </div>
            <div class="mobile-navbar-phones_links_link">
                <span class="mobile-navbar-phones_icon lifecell_logo"></span>
                <a href="tel:+38 063 408 83 08" class="mobile-navbar-phones_text">
                    +38 063 408 83 08
                </a>
            </div>
            <div class="mobile-navbar-phones_links_link">
                <span class="mobile-navbar-phones_icon kievstar_logo"></span>
                <a href="tel:+38 067 008 83 04" class="mobile-navbar-phones_text">
                    +38 067 008 83 04
                </a>
            </div>
            <div class="mobile-navbar-phones_links_link">
                <span class="mobile-navbar-phones_icon vodafon_logo"></span>
                <a href="tel:+38 095 008 83 04" class="mobile-navbar-phones_text">
                    +38 095 008 83 04
                </a>
            </div>
        </div>
        <span class="mobile-navbar-phones_header">
            Телефони магазинiв "Vikar"
        </span>
        <div class="mobile_navbar_phones_stores">
            <?$sql = mysqli_query($con,"select * from stores");
                $i = 0;
                while($row = mysqli_fetch_array($sql)):
                $i++;
                ?>
            <div class="mobile_navbar_phones_stores_item">
                <a class="mobile_navbar_phones_stores_item_img" 
                href="stores/<?=transliterate($row['adres'])?>">
                    <img src="<?=$row['logo']?>" width="50px">
                </a>
                <div class="mobile_navbar_phones_stores_item_info">
                    <span class="mobile_navbar_phones_stores_item_info_adress">
                        <?=$row['adres']?>
                    </span>
                    <a class="mobile_navbar_phones_stores_item_info_number" href="tel:<?=$row['phone']?>">
                        <span>
                            <?=$row['phone']?>
                        </span>
                    </a>
                </div>
            </div>
            <?endwhile;?>
        </div>
    </div>
    <div class="mobile-navbar-phones_bg"></div>
    <!-- Mobile menu -->
    <div class="mobile-navbar-collapse" data='0'>
        <ul class="mobile-navbar-nav">
            <!-- Всi товари -->
            <li class="mobile-navbar-item mobile-navbar-item_allproducts">
                <button class="allproduct_header">
                    <div class="allproduct_header_button">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    Всі товари
                </button>
            </li>
            <div class="allproduct_collapsed">
                <? $sql1 = mysqli_query($con,"select id,categoryName from category");  
                        while($row = mysqli_fetch_array($sql1)){   
                        ?>
                <div class="allproduct_parent">
                    <span id="allproduct_category<?=$row['id']?>" class='allproduct_category'>
                        <a href="category/<?=transliterate($row['categoryName'])?>">
                            <?echo $row['categoryName']?>
                        </a>
                        <span class="allproduct_category_arrow" data-id="<?=$row['id']?>" data="<?=$row['id']?>"></span>
                    </span>
                </div>
                <ul id="allproduct_child<?=$row['id']?>" class="allproduct_child">
                    <span id="category<?=$row['id']?>">
                    </span>
                </ul>
                <?}
        ?>
            </div>
            <li id="shares" class="mobile-navbar-item">
                <a href="shares">АКЦІЇ</a>
            </li>
            <li id="stores" class="mobile-navbar-item">
                <a href="stores">НАШІ МАГАЗИНИ</a>
            </li>
            <li class="mobile-navbar-item">
                <button type="button" class="mobile-navbar-item_more_btn">ІНФОРМАЦІЯ &#8595;
                    <i class="uil uil-arrow-down"></i>
                </button>
            </li>
            <div class="mobile-navbar-item_more_block">
                <a href="page/aboutus"><?=info_name($con,1)?></a>
                <a href='page/contact'><?=info_name($con,2)?></a>
                <a href='page/blog'><?=info_name($con,3)?></a>
                <a href='page/delivery'><?=info_name($con,4)?></a>
                <a href='page/payment'><?=info_name($con,5)?></a>
                <a href='page/services'><?=info_name($con,6)?></a>
                <a href='page/questions'><?=info_name($con,7)?></a>
                <a href='page/job'><?=info_name($con,8)?></a>
                <a href='page/oferta'><?=info_name($con,9)?></a>
                <a href='page/personalDate'><?=info_name($con,10)?></a>
                <a href='page/certificates'><?=info_name($con,11)?></a>
            </div>
            <li id="price" class="mobile-navbar-item">
                <button type="button" class="price_link">ПРАЙС</button>
            </li>
        </ul>
    </div>
    <div class="mobile_menu_bg"></div>
</div>
<!-- Search -->
<div class="mobile_search_container">
    <form class="mobile_search_form mobile_search_form_mobile" method="get" action="search-result.php">
        <input class="mobile_search_form_input search-field" placeholder="Шукати товар..." name="search" />
        <button class="mobile_search_form_button"></button>
        <div class="mobile_search_wrapper search_wrapper"></div>
    </form>
    <a href="my-cart.php" class="mobile_search_container_basket">
        <img src="assets/icon/basket_white_icon.svg" height="25px" alt="">
        <span class='search_count count' style="display:
            <?
            if($get_basketCountItems == 0) {
                echo(" none"); } ?>;"
            >
            <? echo($get_basketCountItems);?>
        </span>
    </a>
</div>