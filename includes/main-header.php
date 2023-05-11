<?php 
// Get count items from basket
$get_basketCountItems = $_SESSION['cart'] !== NULL ? count($_SESSION['cart']) : 0;

$get_price_link = mysqli_query($con,"SELECT price_file_name FROM price");
$row_price_link = mysqli_fetch_array($get_price_link);
$price_link_name = $row_price_link['price_file_name'];
?>

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MGDQQK4" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Facebook Pixel Code -->
<script>
    ! function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '675598916727838');
    fbq('track', 'PageView');
</script>
<noscript>
    <img height="1" width="1" src="https://www.facebook.com/tr?id=675598916727838&ev=PageView&noscript=1" />
</noscript>
<!-- End Facebook Pixel Code -->

<div id="preloader">
    <img src="assets/loader_screen.svg" width="507px" height="72px">
</div>

<?php include('header/mobile_menu.php');?>
<header>
    <div class="header_first_row animate-dropdown">
        <div class="header_first_row_wrapper">
            <!-- Logo -->
            <a href="/" class="header_first_row_logo">
                <img src="assets/logo_vikar.png" height="50px" width="270px" alt="Vikar logo">
            </a>

            <!-- Links -->
            <ul class="header_first_row_links ">
                <li id="shares">
                    <a href="shares">
                        <span>
                            АКЦІЇ
                        </span>
                    </a>
                </li>
                <li id="stores">
                    <a href="stores">
                        <span>
                            НАШІ МАГАЗИНИ
                        </span>
                    </a>
                </li>
                <li>
                    <button type="button" class="header_drop_btn">
                        <span>
                            ІНФОРМАЦІЯ &#8595;
                        </span>
                        <i class="uil uil-arrow-down"></i>
                    </button>
                </li>
                <div class="header_drop_block">
                    <a href="page/aboutus"><?=info_name($con,1)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/contact'><?=info_name($con,2)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/blog'><?=info_name($con,3)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/delivery'><?=info_name($con,4)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/payment'><?=info_name($con,5)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/services'><?=info_name($con,6)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/questions'><?=info_name($con,7)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/job'><?=info_name($con,8)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/oferta'><?=info_name($con,9)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/personalDate'><?=info_name($con,10)?><i class="uil uil-arrow-right"></i></a>
                    <a href='page/certificates'><?=info_name($con,11)?><i class="uil uil-arrow-right"></i></a>
                </div>
                <li id="price">
                    <a href="price/<?=$price_link_name?>" class="price_link" download>
                        <span>
                            ПРАЙС
                        </span>
                        </button>
                </li>
            </ul>

            <div class='header_first_row_block'>
                <div class="header_first_row_social">
                    <a href="https://www.facebook.com/vikar.metall/?ref=notif_textonly&paipv=1" target='_blank'>
                        <span class="header_first_row_social_fb"></span>
                    </a>
                    <a href="https://www.instagram.com/vikar.center/?igshid=YmMyMTA2M2Y=" target='_blank'>
                        <span class="header_first_row_social_instagram"></span>
                    </a>
                    <a href="https://t.me/Vikar_center_channel" target='_blank'>
                        <span class="header_first_row_social_telegram"></span>
                    </a>
                    <a href="https://www.youtube.com/channel/UCUmKo-k6IRfL_tBV16BulRw" target='_blank'>
                        <span class="header_first_row_social_youtube"></span>
                    </a>
                </div>
                <div class="header_first_row_log_block">
                    <?
                        $user_email = $_SESSION['login'];
                        if(gettype($user_email) === 'NULL'){
                    ?>
                    <a href="login">
                        <span class="header_first_row_log_block_login_icon"></span>
                        <span class="header_first_row_log_block_login_text">Увiйти</span>
                    </a>
                    <? } else{ ?>
                    <a class="header_wish_count_button" href="wishlist">
                        <span class="header_first_row_log_block_favorite"></span>
                        <?php
                        $user_email = $_SESSION['login'];
                        if(gettype($user_email) !== 'NULL'){
                            $get_wishCount=mysqli_query($con,"SELECT * from wishlist where userid='$_SESSION[id]'");
                            $wishCountNum=mysqli_num_rows($get_wishCount);
                            if ($wishCountNum > 0) {?>
                        <span
                            class='header_first_row_log_block_favorite_number header_wish_count'><?=$wishCountNum?></span>
                        <?}
                        }?>
                    </a>
                    <a href="my-account">
                        <span class="header_first_row_log_block_login_icon"></span>
                    </a>
                    <a href="logout">
                        <span class="header_first_row_log_block_login_icon_exit"></span>
                    </a>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="header_second_row">
        <div class="header_second_row_allProduct">

            <button type="button" class="header_side_menu_btn">
                <span>
                    Всі товари
                </span>
                <div class="header_side_menu_btn_icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <?php include('header/side-menu.php');?>
        </div>

        <!-- Search -->
        <form class="header_second_row_form" method="get" action="search-result.php">
            <input class="header_second_row_form_input search-field" placeholder="Шукати товар..." name="search" />
            <button class="header_second_row_form_button"></button>
            <div class="search_wrapper"></div>
        </form>

        <div class="desktop-navbar-phones_wrapper">
            <!-- Phone button -->
            <button class="desktop-navbar-phones_btn" type="button">
                <span class="desktop-navbar-phones_btn_number">0 800 330 098</span>
                <span class="desktop-navbar-phones_btn_title">телефони магазинiв</span>
                <span class="desktop-navbar-phones_btn_arrow"></span>
            </button>

            <!-- Phones dropdown -->
            <div class="desktop-navbar-phones">
                <button class="desktop-navbar-phones_close" type='button'></button>
                <span class="desktop-navbar-phones_header">
                    Iнтернет магазин "Vikar"
                </span>
                <div class="desktop-navbar-phones_links">
                    <div class="desktop-navbar-phones_links_link">
                        <span class="desktop-navbar-phones_icon_phone"></span>
                        <a href="tel:0 800 330 098" class="desktop-navbar-phones_text">
                            0 800 330 098
                        </a>
                    </div>
                    <div class="desktop-navbar-phones_links_link">
                        <span class="desktop-navbar-phones_icon lifecell_logo"></span>
                        <a href="tel:+38 063 408 83 08" class="desktop-navbar-phones_text">
                            +38 063 408 83 08
                        </a>
                    </div>
                    <div class="desktop-navbar-phones_links_link">
                        <span class="desktop-navbar-phones_icon kievstar_logo"></span>
                        <a href="tel:+38 067 008 83 04" class="desktop-navbar-phones_text">
                            +38 067 008 83 04
                        </a>
                    </div>
                    <div class="desktop-navbar-phones_links_link">
                        <span class="desktop-navbar-phones_icon vodafon_logo"></span>
                        <a href="tel:+38 095 008 83 04" class="desktop-navbar-phones_text">
                            +38 095 008 83 04
                        </a>
                    </div>
                </div>
                <span class="desktop-navbar-phones_header">
                    Телефони магазинiв "Vikar"
                </span>
                <div class="desktop_navbar_phones_stores">
                    <?$sql = mysqli_query($con,"SELECT * from stores");
                        $i = 0;
                        while($row = mysqli_fetch_array($sql)):
                        $i++;
                        ?>
                    <div class="desktop_navbar_phones_stores_item">
                        <a class="desktop_navbar_phones_stores_item_img"
                            href="stores/<?=transliterate($row['adres'])?>">
                            <img src="<?=$row['logo']?>" width="50px" loading="lazy" />
                        </a>
                        <div class="desktop_navbar_phones_stores_item_info">
                            <span class="desktop_navbar_phones_stores_item_info_adress">
                                <?=$row['adres']?>
                            </span>
                            <a class="desktop_navbar_phones_stores_item_info_number" href="tel:<?=$row['phone']?>">
                                <span>
                                    <?=$row['phone']?>
                                </span>
                            </a>
                        </div>
                    </div>
                    <?endwhile;?>
                </div>
            </div>
        </div>

        <!-- Basket -->
        <div class="header_second_row_basket">
            <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
            <button class="header_second_row_basket_btn">
                <div class="header_second_row_basket_btn_icon">
                    <span class="basket_btn_icon"></span>
                    <span class='header_second_row_basket_btn_icon_badge count' style="display:
                        <? if($get_basketCountItems == 0) {
                            echo(" none"); } ?>;"
                        >
                        <? echo($get_basketCountItems);?>
                    </span>
                </div>
                <span class="header_second_row_basket_btn_icon_price valuee">0 ₴</span>
            </button>
            <div class="header_second_row_basket_block"></div>
            <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
        </div>
    </div>
</header>

<?php include('header/product_details_popup.php');?>