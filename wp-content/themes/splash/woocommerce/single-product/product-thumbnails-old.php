<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && has_post_thumbnail() ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	<div class="stm-thumnails-single-product-wrapper">
		<div class="stm-thumnails-single-product jcarousel">
			<ul class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

				foreach ( $attachment_ids as $attachment_id ) {

					$classes = array( 'zoom' );

					if ( $loop === 0 || $loop % $columns === 0 )
						$classes[] = 'first';

					if ( ( $loop + 1 ) % $columns === 0 )
						$classes[] = 'last';

					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;

					$imgSize = apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' );

					$image_title 	= esc_attr( get_the_title( $attachment_id ) );
					$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
                $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$image       = wp_get_attachment_image( $attachment_id, $imgSize, 0, $attr = array(
						'title'	=> $image_title,
						'alt'	=> $image_title,
                    'data-src'                => $full_size_image[0],
                    'data-large_image'        => $full_size_image[0],
                    'data-large_image_width'  => $full_size_image[1],
                    'data-large_image_height' => $full_size_image[2],
						) );

					$imgSizePreview = 'shop_single';
					$image_preview = wp_get_attachment_image_src($attachment_id, $imgSizePreview);

					if(!empty($image_preview[0])) {
						$image_preview = $image_preview[0];
					} else {
						$image_preview = '';
					}

					$image_class = esc_attr( implode( ' ', $classes ) );

					?><li data-thumb="<?php esc_url( $thumbnail[0] ) ?>" class="stm-thumb-item woocommerce-product-gallery__image"><?php
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a data-preview="%s" href="%s" class="%s" title="%s" data-lightbox="prettyPhoto[product-gallery]">%s</a>', $image_preview, $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );
					?></li><?php

					$loop++;
				}

			?></ul>
		</div>
		<div class="stm-vertical-arrows">
			<div class="appendArrows">
				<div class="slick-arrow prev jcarousel-control-prev">
					<i class="fa fa-angle-up"></i>
				</div>
				<div class="slick-arrow next jcarousel-control-next">
					<i class="fa fa-angle-down"></i>
				</div>
			</div>
		</div>
	</div>
	<?php
}

?>

<script type="text/javascript">
	(function($) {
		<?php if(!is_layout("sccr")) : ?>
		$(function () {

			$('.jcarousel')
				.jcarousel({
					vertical: false
				});

			$('.jcarousel-control-prev')
				.on('jcarouselcontrol:active', function () {
					$(this).removeClass('inactive');
				})
				.on('jcarouselcontrol:inactive', function () {
					$(this).addClass('inactive');
				})
				.jcarouselControl({
					target: '-=1'
				});

			$('.jcarousel-control-next')
				.on('jcarouselcontrol:active', function () {
					$(this).removeClass('inactive');
				})
				.on('jcarouselcontrol:inactive', function () {
					$(this).addClass('inactive');
				})
				.jcarouselControl({
					target: '+=1'
				});

			$('.jcarousel-pagination')
				.on('jcarouselpagination:active', 'a', function () {
					$(this).addClass('active');
				})
				.on('jcarouselpagination:inactive', 'a', function () {
					$(this).removeClass('active');
				})
				.jcarouselPagination();
		});
		<?php else : ?>
		$(function(){
			var owl = $(".thumbnails");

			$(document).ready(function () {
				owl.owlCarousel({
					items: 3,
					dots: false,
					autoplay: false,
					slideBy: 1,
					loop: false,
					navText: '',
					margin: 5,
					responsive: {
					    560: {
					        items: 4,
						    slideBy: 1
					    },
						768: {
                            items: 3,
                            slideBy: 1
						}
					}
				});
			});
		});
		<?php endif;?>

		$('.stm-thumnails-single-product .thumbnails .stm-thumb-item a').on('mouseover', function () {
			var previewImage = $(this).attr('data-preview');
			if (typeof previewImage !== 'undefined') {
				$('.stm-image-preview-shop').addClass('hovered');
				$('.stm-image-preview-shop').append('<img src="' + previewImage + '" />');
			}
		});

		$('.stm-thumnails-single-product .thumbnails .stm-thumb-item a').on('mouseout', function () {
			$('.stm-image-preview-shop').removeClass('hovered');
			$('.stm-image-preview-shop').empty();
		});
	})(jQuery);
</script>
