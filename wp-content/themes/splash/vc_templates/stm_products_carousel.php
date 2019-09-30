<?php
$title = $post_categories = '';
$number = 6;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$product_args = array(
	'post_type' => 'product',
	'post_status' => 'publish',
	'posts_per_page' => intval($number),
);

if(!empty($post_categories)) {
	$post_categories = explode(', ', $post_categories);
	if(!empty($post_categories)) {
		$product_args['tax_query'] = array(
			'relation' => 'OR'
		);
		foreach($post_categories as $post_category) {
			$product_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $post_category
			);
		}
	}
}

$id = 'stm-product-carousel-init-'.rand(0,9999);

$id_controls = 'stm-product-carousel-controls-'.rand(0,9999);

$product_query = new WP_Query($product_args);

if($product_query->have_posts()): ?>

	<?php if(!is_layout("sccr")): ?>
		<div class="container">
	<?php endif; ?>
		<div class="clearfix">
			<?php if(!empty($title)): ?>
				<div class="stm-title-left <?php if(is_layout("baseball")) echo "stm-bsb-shop-title"; ?>">
					<<?php echo esc_html(getHTag()); ?> class="stm-main-title-unit"><?php echo esc_attr($title); ?></<?php echo esc_html(getHTag()); ?>>
				</div>
			<?php endif; ?>
            <?php if(!is_layout("baseball")): ?>
                <div class="stm-carousel-controls-right <?php echo esc_attr($id_controls); ?> stm-carousel-nav-af">
                    <div class="stm-carousel-control-prev"><i class="fa fa-angle-left"></i></div>
                    <div class="stm-carousel-control-next"><i class="fa fa-angle-right"></i></div>
                </div>
            <?php endif; ?>
		</div>
	<?php if(!is_layout("sccr")): ?>
		</div>
	<?php endif; ?>

	<div class="clearfix"></div>

	<?php if(!is_layout("sccr") && !is_layout("baseball")): ?>
	<div class="container">
	<?php endif; ?>
		<div class="stm-products-carousel-unit-wrapper" <?php if($atts["stretch_row"] == "disable") echo "style='overflow: hidden; padding: 10px;'"; ?>>
			<div class="stm-products-carousel-unit">
				<div class="stm-products-carousel-init <?php echo esc_attr($id); ?>">
					<?php while($product_query->have_posts()): $product_query->the_post(); ?>
						<?php
						if(is_layout("sccr")) {
							get_template_part('partials/loop/product-carousel-soccer');
						}
						else if(is_layout("soccer_two")) {
							get_template_part('partials/loop/product-carousel-soccer-two');
						}
						else {
							get_template_part('partials/loop/product-carousel');
						}
						?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	<?php if(!is_layout("sccr") && !is_layout("baseball")): ?>
	</div>
	<?php endif; ?>

    <?php if(is_layout("baseball")): ?>
        <div class="stm-visit-shop-btn">
            <a class="button only_border" href="<?php echo esc_url(wc_get_page_permalink( 'shop' )); ?>" ><i class="icon-ico_bsb_cart"></i> <?php echo esc_html__("Visit shop", "splash"); ?></a>
        </div>
    <?php endif; ?>

    <?php if(!is_layout("baseball")): ?>
        <script type="text/javascript">
            (function($) {
                "use strict";

                var unique_class = "<?php echo esc_js($id); ?>";

                var unique_class_controls = "<?php echo esc_js($id_controls); ?>";

                var owl = $('.' + unique_class);

                $(window).load(function () {
                    owl.owlCarousel({
                        items: <?php echo esc_html($atts['visible_items'])?>,
                        dots: true,
                        autoplay: false,
                        loop: true,
                        slideBy: <?php echo esc_html($atts['visible_items'])?>,
                        responsive:{
                            0:{
                                items:1,
                                slideBy:1
                            },
                            450:{
                                items:2,
                                slideBy:2
                            },
                            768:{
                                items:3,
                                slideBy:3
                            },
                            780:{
                                items:<?php echo esc_html($atts['visible_items'])?>,
                                slideBy:<?php echo esc_html($atts['visible_items'])?>
                            }
                        }
                    });

                    $('.' + unique_class_controls + ' .stm-carousel-control-prev').on('click', function(){
                        owl.trigger('prev.owl.carousel');
                    });

                    $('.' + unique_class_controls + ' .stm-carousel-control-next').on('click', function(){
                        owl.trigger('next.owl.carousel');
                    });
                });
            })(jQuery);
        </script>
    <?php endif; ?>
<?php endif; ?>

