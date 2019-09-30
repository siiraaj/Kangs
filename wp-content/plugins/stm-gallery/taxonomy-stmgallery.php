<?php

/* 
Archivo para la visualización de la taxonomía stmpili
Versión: 1.0
Autor: Sergio TOCA MORENO
Inicio: 2 / X / 2016
Finalización: 2 / X / 2016
*/

	get_header();
?>
	<section id="main">
<?php
	
	// Determinamos el término de la taxonomía
	$termino = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	// Recuperamos los ajustes de la base de datos
	$t_id = $termino->term_id;
	$tax_meta = get_option( "stmpili_taxonomy_$t_id" );

	// Extraemos los ajustes de la matriz referentes a la taxonomía
	$tax_meta['taxonomia_mostrar_sidebar'] = ( !isset( $tax_meta['taxonomia_mostrar_sidebar'] ) ) ? 'si' : $tax_meta['taxonomia_mostrar_sidebar'];
	$tax_meta['taxonomia_mostrar_footer'] = ( !isset( $tax_meta['taxonomia_mostrar_footer'] ) ) ? 'si' : $tax_meta['taxonomia_mostrar_footer'];
	$tax_meta['taxonomia_mostrar_titulo'] = ( !isset( $tax_meta['taxonomia_mostrar_titulo'] ) ) ? 'no' : $tax_meta['taxonomia_mostrar_titulo'];
	$tax_meta['taxonomia_mostrar_descripcion'] = ( !isset( $tax_meta['taxonomia_mostrar_descripcion'] ) ) ? 'no' : $tax_meta['taxonomia_mostrar_descripcion'];

	// Título
	if ( $tax_meta['taxonomia_mostrar_titulo'] == 'si' ) {
		?>
		<h2><?php echo $termino->name; ?></h2>
		<?php
	}
	// Descripción
	if ( $tax_meta['taxonomia_mostrar_descripcion'] == 'si' ) {
		?>
		<p><?php echo $termino->description; ?></p>
		<?php
	}
	
	// Recordemos lo que había que poner como cuerpo
	?>
	<div class="composicion" id="fondo" style="width:100%;"><p class="nombre"><?php echo $termino->name; ?></p>
		<div id="div1">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
			<div class="bar4"></div>
			<div class="bar5"></div>
			<div class="bar6"></div>
			<div class="bar7"></div>
			<div class="bar8"></div>
		</div>
	</div>
	<?php
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
	
	// La barra lateral
	if ( $tax_meta['taxonomia_mostrar_sidebar'] == 'si' ) {
		get_sidebar();
	}
	// El pie de página
	if ( $tax_meta['taxonomia_mostrar_footer'] == 'si' ) {
		get_footer();
	} else {
		// Si no mostrarmos el footer, por lo menos sí tenemos que hacer las funciones que él hacía
		wp_footer();
		?>
		</body>
		<?php
	}
	
?>