<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package GeneratePress
 */
?>
	</div><!-- #content -->

<?php if (is_front_page()){ ?>
		

<div style="    margin-top: -80px;" class="zag site-content"><blockquote>Услуги</blockquote></div>
<!-- Контейнер с адаптиными блоками -->
<div class="masonry site-content">
    <!-- Адаптивные блоки с содержанием -->
   <div class="item">
       <img src="http://placehold.it/350x200">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
   <div class="item">
       <img src="http://placehold.it/250x250">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
   <div class="item">
       <img src="http://placehold.it/470x320">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
   <div class="item">
       <img src="http://placehold.it/250x150">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
   <div class="item">
       <img src="http://placehold.it/300x250">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
   <div class="item">
       <img src="http://placehold.it/450x300">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
    <div class="item">
       <img src="http://placehold.it/250x200">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
   <div class="item">
       <img src="http://placehold.it/250x150">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
    <div class="item">
       <img src="http://placehold.it/280x190">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
 
    <div class="item">
       <img src="http://placehold.it/500x400">
           <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>
    <!-- Конец адаптивных блоков с содержанием -->
 
</div>
    <!-- Конец контейнера с адаптивными блоками -->



<div class="zag site-content"><blockquote>Партнеры</blockquote></div>
<div class="site-content">
<div id="owl-demo" class="owl-carousel">
</div>
</div>


<?php } ?>



</div><!-- #page -->
<?php do_action('generate_before_footer'); ?>
<div <?php generate_footer_class(); ?>>
	<?php 
	do_action('generate_before_footer_content');
	
	// Get how many widgets to show
	$widgets = generate_get_footer_widgets();
	
	if ( !empty( $widgets ) && 0 !== $widgets ) : 
	
		// Set up the widget width
		$widget_width = '';
		if ( $widgets == 1 ) $widget_width = '100';
		if ( $widgets == 2 ) $widget_width = '50';
		if ( $widgets == 3 ) $widget_width = '33';
		if ( $widgets == 4 ) $widget_width = '25';
		if ( $widgets == 5 ) $widget_width = '20';
		?>
		<div id="footer-widgets" class="site footer-widgets">
			<div class="inside-footer-widgets grid-container grid-parent">
				<?php if ( $widgets >= 1 ) : ?>
					<div class="footer-widget-1 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_1_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_1_tablet_width', '50' ); ?>">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1')): ?>
							<aside class="widget inner-padding widget_text">
								<n4 class="widget-title"><?php _e('Footer Widget 1','generate');?></n4>			
								<div class="textwidget">
									<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 1.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
									<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
								</div>
							</aside>
						<?php endif; ?>
					</div>
				<?php endif;
				
				if ( $widgets >= 2 ) : ?>
				<div class="footer-widget-2 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_2_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_2_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2')): ?>
						<aside class="widget inner-padding widget_text">
							<n4 class="widget-title"><?php _e('Footer Widget 2','generate');?></n4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 2.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif;
				
				if ( $widgets >= 3 ) : ?>
				<div class="footer-widget-3 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_3_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_3_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3')): ?>
						<aside class="widget inner-padding widget_text">
							<n4 class="widget-title"><?php _e('Footer Widget 3','generate');?></n4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 3.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif;
				
				if ( $widgets >= 4 ) : ?>
				<div class="footer-widget-4 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_4_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_4_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-4')): ?>
						<aside class="widget inner-padding widget_text">
							<n4 class="widget-title"><?php _e('Footer Widget 4','generate');?></n4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 4.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif;
				
				if ( $widgets >= 5 ) : ?>
				<div class="footer-widget-5 grid-parent grid-<?php echo apply_filters( 'generate_footer_widget_5_width', $widget_width ); ?> tablet-grid-<?php echo apply_filters( 'generate_footer_widget_5_tablet_width', '50' ); ?>">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-5')): ?>
						<aside class="widget inner-padding widget_text">
							<n4 class="widget-title"><?php _e('Footer Widget 5','generate');?></n4>			
							<div class="textwidget">
								<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into Footer Area 5.','generate' ), admin_url( 'widgets.php' ) ); ?></p>
								<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generate' ), admin_url( 'customize.php' ) ); ?></p>
							</div>
						</aside>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	<?php
	endif;
	do_action('generate_after_footer_widgets');
	?>
	<footer class="site-info" itemtype="http://schema.org/WPFooter" itemscope="itemscope" role="contentinfo">
		<div class="inside-site-info grid-container grid-parent">
<div class="row">
<div class="aacc col-lg-3">
                            <a href="http://www.aaccent.ru/sozdanie-saitov/" target="_blank">Создание сайтов</a>                    <br>и <a href="http://www.aaccent.ru/" target="_blank">продвижение сайтов Казань</a>
                        </div>			
<div class="foot_rec col-lg-3">
				г.Казань, ул.Николая Ершова 35-А,
+7 (843) 272-72-99, +7 (843) 272-40-93
ОАО "ВНИИУС" © 2013 - 2015
			</div>
			<div class="smenu col-lg-3">
                            <a href="/">Главная</a> | <a href="/cart/">Cart</a> | <a href="/shop/">Shop</a>
                        </div>
<div class="col-lg-3" style="text-align: right;"><a href="#" class="ww_form_window" data-form="callback" data-type="popover" data-title="Заказ звонка">Заказать звонок</a></div>
			
		</div>
	</footer><!-- .site-info -->
	<?php do_action( 'generate_after_footer_content' ); ?>
</div><!-- .site-footer -->

<?php wp_footer(); ?>

<!-- Library web-widget -->
<script type="text/javascript" src="/web-widget/assets/web-widget.min.js"></script>
<!-- Instances -->
<script type="text/javascript" src="/web-widget/assets/instances.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
<script>
$(document).ready(function() {
 
  $("#owl-demo").owlCarousel({
    items : 4,
    jsonPath : '/data.json',
    jsonSuccess : customDataSuccess
  });
 
  function customDataSuccess(data){
    var content = "";
    for(var i in data["items"]){
       
       var img = data["items"][i].img;
       var alt = data["items"][i].alt;
 	console.log(content)
       content += "<div><img src=\"" +img+ "\" alt=\"" +alt+ "\"><br><p>"+ alt +"</p></div>"
    }
    $("#owl-demo").html(content);
  }
 
 
});
</script>
</body>
</html>