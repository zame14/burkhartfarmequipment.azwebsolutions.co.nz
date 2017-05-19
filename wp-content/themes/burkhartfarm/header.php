<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">
    <section id="header">
        <div class="container">
            <div class="row">
                <div class="top-header">
                    <a href="tel:067520731" class="phone">(06) 752 0731</a>
                    <a href="javascript:;" class="search-link">Search</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 add-padding">
                    <a href="<?=get_home_url()?>" class="logo"><img src="<?=get_stylesheet_directory_uri()?>/images/logo.png" alt="Burkhart Farm Equipment Ltd" /></a>
                    <div id="bfe-menu-wrapper">
                        <div class="main-nav wrapper-fluid wrapper-navbar" id="wrapper-navbar">
                            <nav class="site-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
                                        'menu_class' => 'nav navbar-nav',
                                        'fallback_cb' => '',
                                        'menu_id' => 'main-menu',
                                        'walker' => new wp_bootstrap_navwalker()
                                    )
                                );
                                ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="search-container">
                    <div class="search-inner-container">
                        <form id="search-box" method="post" action="<?=get_page_link($post->ID)?>">
                            <input type="hidden" name="action" value="search">
                            <div><input type="text" name="keyword" class="form-control" placeholder="Search by keyword" value="<?=request('srch')?>" /> <label><input type="checkbox" name="new" value="y" <?=(request('new')=="y" ? 'checked="checked"' : '') ?> /> New Equipment</label> <label><input type="checkbox" name="used" value="y" <?=(request('used')=="y" ? 'checked="checked"' : '') ?> /> Used Equipment</label><input type="submit" class="btn btn-danger" value="Search"></div>
                        </form>
                        <a href="javascript:;" class="close-search">close</a>
                    </div>
                    <div class="slogan-wrapper">Buy direct from Burkhart and Save</div>
                </div>
            </div>
        </div>
    </section>
