<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */
?>
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="cta-wrapper">
                <p>Buy direct from Burkhart and save</p>
            </div>
        </div>
        <div class="row footer-details-row">
            <div class="col-xs-12 col-sm-4">
                <h4>Burkhart Farm Equipment Ltd</h4>
                <address>
                    510 Manutahi Rd, Lepperton<br />
                    RD 3, New Plymouth
                </address>
                <ul class="footer-contact-details">
                    <li class="ph">
                        <a href="tel:067520731">(06) 752 0731</a>
                    </li>
                    <li class="email">
                        <a href="mailto:burkharts@clear.net.nz">burkharts@clear.net.nz</a>
                    </li>
                    <li class="hrs">
                        Hours 08:00 - 17:00
                    </li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h4>Our Equipment</h4>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => '',
                        'container_class' => '',
                        'menu_class' => 'footer-menu',
                        'fallback_cb' => '',
                        'menu_id' => 'footer-menu',
                        'walker' => new wp_bootstrap_navwalker()
                    )
                );
                ?>
            </div>
            <div class="col-xs-12 col-sm-5 facebook-col-outer-wrapper">
                <div class="facebook-col-inner-wrapper">
                    <h4>Latest pics from our Facebook page</h4>
                    <?=facebook_feed()?>
                </div>
            </div>
        </div>
    </div>
    <div class="container lower-footer">
        <div class="row">
            <div class="col-xs-12 col-sm-6 left-col">
                <ul>
                    <li>&copy; Burkhart Farm Equipment Ltd <?=date('Y')?></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 right-col">
                <ul>
                    <li>Website by: <a href="http://www.azwebsolutions.co.nz" target="_blank">A-Z WEB SOLUTIONS LTD</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php wp_footer(); ?>
</div>
</body>
</html>
