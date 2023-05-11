<!-- Brand slider -->
<div class="brand_slider_container wow fadeInUp">
    <div class="brand_slider_container_header">
        <h3>
            Наші партнери
        </h3>
    </div>
    <div id="brand-slider">
        <?$sqlSlider = mysqli_query($con,"SELECT * from brends");?>
        <?while($rowSlider = mysqli_fetch_array($sqlSlider)):?>
        <div class="brand-slider_item">
            <a href="<?=$rowSlider['banner_url']?>" class="image">
                <img src="assets/images/<?=$rowSlider['image']?>" loading="lazy" width="351px" height="70px">
            </a>
        </div>
        <?endwhile;?>
    </div>
</div>

<!-- Footer -->
<footer id="footer" class="wow fadeInUp">
    <div class="footer_container">
        <!-- CONTACT INFO -->
        <div class="footer_container_info">
            <h5>www.<?=footer_name($con,"logo")?></h5>
            <span>
                <?=footer_name($con,"adress")?>
            </span>
            <div>
                <a href="tel:<?=footer_name($con,"number")?>">
                    <?=footer_name($con,"number")?>
                </a>
                <span>
                    (пн — пт: <?=footer_name($con,"time1")?>)
                </span>
            </div>
            <a href="mailto:sales@vikar.center">
                <?=footer_name($con,"email")?>
            </a>
            <div class="footer_container_info_social">
                <span class="footer_container_info_social_title">Наші соцмережі:</span>
                <div class="footer_container_info_social_block">
                    <a target="_blank" href="https://www.facebook.com/vikar.metall/?ref=notif_textonly&paipv=1">
                        <span class="footer_container_info_social_fb"></span>
                    </a>
                    <a target="_blank" href="https://www.instagram.com/vikar.center/?igshid=YmMyMTA2M2Y=">
                        <span class="footer_container_info_social_instagram"></span>
                    </a>
                    <a target="_blank" href="https://t.me/Vikar_center_channel">
                        <span class="footer_container_info_social_telegram"></span>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/channel/UCUmKo-k6IRfL_tBV16BulRw">
                        <span class="footer_container_info_social_youtube"></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- CONTACT TIMIN -->
        <div class="footer_container_stores">
            <div class="footer_container_stores_address">
                <h5><?=footer_name($con,"title")?></h5>
                <span><?=footer_name($con,"adres1")?></span>
                <span><?=footer_name($con,"adres2")?></span>
                <span><?=footer_name($con,"adres3")?></span>
                <span><?=footer_name($con,"adres4")?></span>
            </div>
            <div class="footer_container_stores_schedule">
                <h6>
                    Графiк роботи
                </h6>
                <span>
                    пн — пт: <?=footer_name($con,"time1")?>
                </span>
                <span>
                    cб: <?=footer_name($con,"time2")?>
                </span>
                <span>
                    нд: <?=footer_name($con,"time3")?>
                </span>
            </div>
        </div>

        <!-- INFORMATION -->
        <div class="footer_container_information">
            <h5>Інформація</h5>
            <ul>
                <li>
                    <a href="page/aboutus"><?=info_name($con,1)?></a>
                </li>
                <li>
                    <a href='page/contact'><?=info_name($con,2)?></a>
                </li>
                <li>
                    <a href='page/blog'><?=info_name($con,3)?></a>
                </li>
                <li>
                    <a href='page/delivery'><?=info_name($con,4)?></a>
                </li>
                <li>
                    <a href='page/payment'><?=info_name($con,5)?></a>
                </li>
                <li>
                    <a href='page/services'><?=info_name($con,6)?></a>
                </li>
                <li>
                    <a href='page/questions'><?=info_name($con,7)?></a>
                </li>
                <li>
                    <a href='page/job'><?=info_name($con,8)?></a>
                </li>
                <li>
                    <a href='page/oferta'><?=info_name($con,9)?></a>
                </li>
                <li>
                    <a href='page/personalDate'><?=info_name($con,10)?></a>
                </li>
                <li>
                    <a href='page/certificates'><?=info_name($con,11)?></a>
                </li>
            </ul>
        </div>

        <!-- SUBSCRIBE -->
        <div class="footer_container_subscribe">
            <h5>Підписатись на розсилку</h5>
            <div class="footer_container_subscribe_form">
                <input type="email" placeholder="Email" class="footer_container_subscribe_input" />
                <button type="button" class="footer_container_subscribe_button">
                    <span></span>
                </button>
            </div>
            <span class="footer_container_subscribe_success"></span>
            <span>Будьте в курсі наших новинок та акцій</span>

            <span class="footer_container_subscribe_linkToOnix">Розроблено onixlab.com.ua</span>
        </div>

    </div>
</footer>


<?php include('order_calling.php');?>



<!-- Slider -->
<script type="text/javascript" src="assets/js/slick-1.8.1/slick/slick.min.js"></script>

<!-- Libs -->
<script type="text/javascript" src="assets/js/lib/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/lib/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="assets/js/lib/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/js/lib/echo.min.js"></script>

<script src="assets/js/lib/jquery.maskedinput.js"></script>

<script type="text/javascript" src="assets/js/lib/jquery.easing-1.3.min.js"></script>
<script type="text/javascript" src="assets/js/lib/wow.min.js"></script>

<!-- Main script -->
<script type="text/javascript" src="assets/js/scripts.js"></script>
<script type="text/javascript" src="assets/js/product_details_popup.js"></script>

<style>
#bingc-passive {
    top: 10% !important;
    z-index: 99900000909999 !important;
}
</style>