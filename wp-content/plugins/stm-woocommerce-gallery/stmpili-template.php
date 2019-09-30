<?php 
/* Template Name: STM_Gallery_4_WC */
?>

<?php


	get_header();

	?>
	<section id="principal">
<?php
	
	// Recordemos lo que había que poner como cuerpo
	if (have_posts()) :
		while (have_posts()) :
			the_post();
			?><h2><?php the_title(); ?></h2><?php
			the_content();
		endwhile;
	endif;
	// A continuación creamos las capas ocultas del lightbox
	?>
	<div id="light" class="white_content">	
	</div>
	
	<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='none'; document.getElementById('fade').style.display='none';">
		<div id="fade" class="black_overlay">
		</div>
	</a>

	
	</section> <!-- Fin de la sección main -->
<?php
	
		//get_sidebar();
		get_footer();
		?>
		</body>
		<?php
?>