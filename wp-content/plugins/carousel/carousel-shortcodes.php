<?php

/*
Plugin Name:Carousels Ultimate
Plugin URI: http://themepoints.com
Description: Carousels ultimate allows you to use shortcode to display carousel post or page.
Version: 1.0
Author: themepoints
Author URI: http://themepoints.com
License URI: http://themepoints.com/copyright/
*/
if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );
	
define('THEMEPOINTS_CAROUSEL_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );



/* carousels ultimate stylesheet */
function tp_ultimate_carousel_script()
	{
	wp_enqueue_script('jquery');
	wp_enqueue_script('tp-carousel-js', plugins_url( '/js/owl.carousel.js', __FILE__ ), array('jquery'), '1.0', false);
	wp_enqueue_style('tp-carousel-css', THEMEPOINTS_CAROUSEL_PLUGIN_PATH.'css/owl.carousel.css');	
	wp_enqueue_style('tp-carousel-theme-css', THEMEPOINTS_CAROUSEL_PLUGIN_PATH.'css/owl.theme.css');
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('tp-carousel-wp-color-picker', plugins_url(), array( 'wp-color-picker' ), false, true );
	}
add_action('init', 'tp_ultimate_carousel_script');






function tp_ultimate_carousel_js_active(){?>

    <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery("#owl-demo").owlCarousel({
        autoPlay: true,
        items : 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,3]
      });

    });
    </script>
<?php
	}
add_action('wp_head', 'tp_ultimate_carousel_js_active');


function tp_ultimate_carousel_images($atts, $content = null) {
	return ('<div class="item">
				<img src="'.$content.'" alt=""/>
			</div>	
			');
}
add_shortcode ("carouselsimages", "tp_ultimate_carousel_images");


/* carousels ultimate Shortcode */
function tp_ultimate_carousel_shortcodes($atts, $content = null) {
	return ('
			<div id="demo">
				<div class="container">
					<div class="row">
						<div class="span12">
							<div id="owl-demo" class="owl-carousel">
								'.do_shortcode($content).'
							</div>
						</div>
					</div>
				</div>
			</div>
		');
}
add_shortcode ("ultimatecarousels", "tp_ultimate_carousel_shortcodes");



/* Add Slider Shortcode Button on Post Visual Editor */
function themepoints_button_function() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   if ( get_user_option('rich_editing') == 'true') {
	add_filter ("mce_external_plugins", "themepoints_button_js");
	add_filter ("mce_buttons", "themepoints_button");
   }
	
	
	
	

}

function themepoints_button_js($plugin_array) {
	$plugin_array['pointscarousels'] = plugins_url('inc/shortcode.js', __FILE__);
	return $plugin_array;
}

function themepoints_button($buttons) {
	array_push ($buttons, 'ultimatecarousels');
	return $buttons;
}
add_action ('init', 'themepoints_button_function'); 







?>