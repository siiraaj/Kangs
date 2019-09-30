<?php

/*
Plugin Name: STM Gallery v.0.9
Plugin URI: sergiotoca.com
Description: Plugin para mostrar composiciones de imágenes de la biblioteca de medios
Version: 0.9
Author: Sergio TOCA MORENO
Author URI: sergiotoca.com
Text Domain: stmpili
Domain Path: /idiomas
*/

/////////////////////////////////////////
// STM PILI FOR POSTS & ATTACHMENTS    //
// Fecha inicio: 18 / IX / 16          //
// Inicio esta compilación: 7 / X / 16 //
// Finalización: 20 / XI / 16          //
/////////////////////////////////////////

/*

INDICE DEL CÓDIGO DEL PLUGIN

1. Creación de la taxonomía
2. Shortcode
3. Custom Fields para la taxonomía
   3.1. Función salvado ajustes
4. Indicación a WP de la plantilla y reescritura de reglas
5. Cargar dominio texto
6. Funciones AJAX
   6.1. Función stmpili_funcion_creacion_pila
        6.1.1. Función stmpili_funcion_tipo_pieza
   6.2. Función stmpili_funcion_medidas_matriz
   6.3. Función stmpili_funcion_llenar_matrices
        6.3.1. Función stmpili_funcion_crear_matriz
		6.3.2. Función stmpili_funcion_linea_huecos
		6.3.3. Función stmpili_funcion_hazme_hueco
		6.3.4. Función stmpili_funcion_rellena_hueco
		6.3.5. Función stmpili_funcion_pieza_libre
		6.3.6. Función stmpili_funcion_buscar_pieza
		6.3.7. Función stmpili_funcion_coloca_pieza
   6.4. Función stmpili_funcion_ajustar_matrices
        6.4.1. Función stmpili_horizontal_busco_hueco_hasta_pieza
		6.4.2. Función stmpili_horizontal_busco_siguiente_pieza
		6.4.3. Función stmpili_horizontal_buscar_pieza_hueco_menor
		6.4.4. Función stmpili_vertical_busco_hueco_hasta_pieza
		6.4.5. Función stmpili_vertical_busco_siguiente_pieza
		6.4.6. Función stmpili_vertical_buscar_pieza_hueco_menor
		6.4.7. Función stmpili_funcion_horizontal_busca_huecos_ajusta
		6.4.8. Función stmpili_funcion_vertical_busca_huecos_ajusta
   6.5. Función stmpili_funcion_generacion_resultado
7. Añadir taxonomías a los menús
   
*/

/////////////////////////////////////
//                                 //
// 1. CREACION DE LA TAXONOMIA     //
//                                 //
/////////////////////////////////////

add_action( 'init', 'stmpili_funcion_crear_taxonomia' );

function stmpili_funcion_crear_taxonomia() {
	
	// Primero, la matriz de etiquetas $labels
	$labels = array(
		'name'							=> __( 'Composición', 'stmpili' ),
		'singular_name'					=> __( 'Composición', 'stmpili' ),
		'menu_name'						=> __( 'Composiciones', 'stmpili' ),
		'all_items'						=> __( 'Todas las composiciones', 'stmpili' ),
		'edit_item'						=> __( 'Editar la composición', 'stmpili' ),
		'view_item'						=> __( 'Ver la composición', 'stmpili' ),
		'update_item'					=> __( 'Actualizar la composición', 'stmpili' ),
		'add_new_item'					=> __( 'Añadir nueva composicón', 'stmpili' ),
		'new_item_name'					=> __( 'Nombre de la nueva composición', 'stmpili' ),
		'parent_item'					=> __( 'Nombre composición superior', 'stmpili' ),
		'parent_item_colon'				=> __( 'Nombre composición superior:', 'stmpili' ),
		'search_items'					=> __( 'Buscar composiciones', 'stmpili' ),
		'popular_items'					=> __( 'Composiciones más populares', 'stmpili' ),
		'separate_items_with_commas'	=> __( 'Separar las composiciones con comas', 'stmpili' ),
		'add_or_remove_items'			=> __( 'Añadir o eliminar composiciones', 'stmpili' ),
		'choose_from_most_used'			=> __( 'Elegir entre las composiciones más utilizadas', 'stmpili' ),
		'not_found'						=> __( 'Composición no encontrada', 'stmpili' )
	);
	
	$args = array(
		'label'				=> __( 'Composiciones', 'stmpili' ),
		'labels'			=> $labels,
		'public'			=> true,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'show_in_nav_menus'	=> true,
		'hierarchical'		=> true,
		'query_var'			=> true,
		'show_admin_column'	=> true,
		'rewrite'			=> array( 'slug' => 'composicion' )
	);
	
	register_taxonomy( 'stmpili_txn', array( 'attachment' ), $args );
	
}

///////////////////////////////////////////////////////////////////
//                                                               //
// 2. SHORTCODE                                                  //
// NOTA: Se integra mediante [collage composicion="termino"]     //
//                                                               //
///////////////////////////////////////////////////////////////////

add_shortcode( 'collage', 'stmpili_funcion_shortcode' );

function stmpili_funcion_shortcode( $atts ) {
	
	extract( shortcode_atts(
		array(
			'composicion' => ''
		), $atts)
	);
	return '<div class="composicion" id="fondo" style="width:100%;"><p class="nombre">'.$composicion.'</p>
<div id="div1">
  <div class="bar1"></div>
  <div class="bar2"></div>
  <div class="bar3"></div>
  <div class="bar4"></div>
  <div class="bar5"></div>
  <div class="bar6"></div>
  <div class="bar7"></div>
  <div class="bar8"></div>
</div></div>	<div id="light" class="white_content">	
	</div>
	
	<a href="javascript:void(0)" onclick="document.getElementById(\'light\').style.display=\'none\'; document.getElementById(\'fade\').style.display=\'none\';">
		<div id="fade" class="black_overlay">
		</div>
	</a>
';
	
}

////////////////////////////////////////
//                                    //
// 3. CUSTOM FIELDS PARA LA TAXONOMIA //
//                                    //
////////////////////////////////////////

add_action( 'stmpili_txn_add_form_fields', 'stmpili_funcion_vinculo_compra' );

function stmpili_funcion_vinculo_compra() {

	?>
	<table class="form-table">
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="update"><h2>
					<?php echo __( 'Características mejoradas en STM Gallery v.1.1.', 'stmpili' ); ?>
				</h2></label>
			</th>
			<td>
				<ul>
					<li><?php echo __( 'Opciones de fondo de la composicion ( color, transparencia, imagen)', 'stmpili' ); ?></li>
					<li><?php echo __( 'Inserción logo personal en huecos entre imágenes', 'stmpili' ); ?></li>
					<li><?php echo __( 'Campo personalización CSS', 'stmpili' ); ?></li>
					<li><?php echo __( 'Campo ajuste final imagen', 'stmpili' ); ?></li>
					<li><?php echo __( 'Diseño adaptativo "responsive"', 'stmpili' ); ?></li>
					<li><?php echo __( 'Desplazamiento entre imágenes en el lightbox', 'stmpili' ); ?></li>
					<li><?php echo __( 'Ajuste de la altura de la última matriz', 'stmpili' ); ?></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="http://sergiotoca.com/producto/stm-gallery-v-1-1/" class="button"><?php echo __( 'Actualiza ya a STM Gallery v.1.1.', 'stmpili' ); ?></a><br>
			</td>
		</tr>
	</table>
	<br>
	<?php
}

add_action( 'stmpili_txn_edit_form_fields', 'stmpili_funcion_campos_personales' );

function stmpili_funcion_campos_personales( $tag ) {

	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'my-script-handle', plugin_dir_url( __FILE__ ) . 'js/mi-script.js', array( 'wp-color-picker' ), false, true );
	
	$t_id = $tag->term_id;
	$tax_meta = get_option( "stmpili_taxonomy_$t_id" );
	
	$tax_meta['img_margen_color'] = ( !isset( $tax_meta['img_margen_color'] ) ) ? '#fff' : $tax_meta['img_margen_color'];
	$tax_meta['img_margen_grosor'] = ( !isset( $tax_meta['img_margen_grosor'] ) ) ? 0 : $tax_meta['img_margen_grosor'];
	$tax_meta['img_margen_redondeo'] = ( !isset( $tax_meta['img_margen_redondeo'] ) ) ? 0 : $tax_meta['img_margen_redondeo'];
	$tax_meta['img_borde_color'] = ( !isset( $tax_meta['img_borde_color'] ) ) ? '#000' : $tax_meta['img_borde_color'];
	$tax_meta['img_borde_grosor'] = ( !isset( $tax_meta['img_borde_grosor'] ) ) ? 0 : $tax_meta['img_borde_grosor'];
	$tax_meta['img_borde_redondeo'] = ( !isset( $tax_meta['img_borde_redondeo'] ) ) ? 0 : $tax_meta['img_borde_redondeo'];
	$tax_meta['img_sombra_color'] = ( !isset( $tax_meta['img_sombra_color'] ) ) ? '#000' : $tax_meta['img_sombra_color'];
	$tax_meta['img_sombra_grosor'] = ( !isset( $tax_meta['img_sombra_grosor'] ) ) ? 0 : $tax_meta['img_sombra_grosor'];
	$tax_meta['img_aumento'] = ( !isset( $tax_meta['img_aumento'] ) ) ? 'no' : $tax_meta['img_aumento'];
	$tax_meta['img_cantidad_aumento'] = ( !isset( $tax_meta['img_cantidad_aumento'] ) ) ? 0 : $tax_meta['img_cantidad_aumento'];
	$tax_meta['img_girado'] = ( !isset( $tax_meta['img_girado'] ) ) ? 'no' : $tax_meta['img_girado'];
	$tax_meta['composicion_tipo_cambio'] = ( !isset( $tax_meta['composicion_tipo_cambio'] ) ) ? 0 : $tax_meta['composicion_tipo_cambio'];
	$tax_meta['taxonomia_mostrar_sidebar'] = ( !isset( $tax_meta['taxonomia_mostrar_sidebar'] ) ) ? 'si' : $tax_meta['taxonomia_mostrar_sidebar'];
	$tax_meta['taxonomia_mostrar_footer'] = ( !isset( $tax_meta['taxonomia_mostrar_footer'] ) ) ? 'si' : $tax_meta['taxonomia_mostrar_footer'];
	$tax_meta['taxonomia_mostrar_titulo'] = ( !isset( $tax_meta['taxonomia_mostrar_titulo'] ) ) ? 'no' : $tax_meta['taxonomia_mostrar_titulo'];
	$tax_meta['taxonomia_mostrar_descripcion'] = ( !isset( $tax_meta['taxonomia_mostrar_descripcion'] ) ) ? 'no' : $tax_meta['taxonomia_mostrar_descripcion'];
	$tax_meta['img_separacion'] = ( !isset( $tax_meta['img_separacion'] ) ) ? 0 : $tax_meta['img_separacion'];
	
	?>
	<table class="form-table">
	<tr class="form-field">
		<th scope="row" valign="top" colspan="2">
			<label for="update">
				<?php echo __( 'Características mejoradas en STM Gallery v.1.1.', 'stmpili' ); ?>
			</label>
		</th>
		<td colspan="2">
			<ul>
				<li><?php echo __( 'Opciones de fondo de la composicion ( color, transparencia, imagen)', 'stmpili' ); ?></li>
				<li><?php echo __( 'Inserción logo personal en huecos entre imágenes', 'stmpili' ); ?></li>
				<li><?php echo __( 'Campo personalización CSS', 'stmpili' ); ?></li>
				<li><?php echo __( 'Campo ajuste final imagen', 'stmpili' ); ?></li>
				<li><?php echo __( 'Diseño adaptativo "responsive"', 'stmpili' ); ?></li>
				<li><?php echo __( 'Desplazamiento entre imágenes en el lightbox', 'stmpili' ); ?></li>
				<li><?php echo __( 'Ajuste de la altura de la última matriz', 'stmpili' ); ?></li>
			</ul>
		</td>
		<td colspan="2">
			<a href="http://sergiotoca.com/producto/stm-gallery-v-1-1/" class="button"><?php echo __( 'Actualiza ya a STM Gallery v.1.1.', 'stmpili' ); ?></a>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_img_margen_color">
				<?php echo __( 'Color margen imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_margen_color]" class="my-color-field" value="<?php echo $tax_meta['img_margen_color']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_margen_grosor">
				<?php echo __( 'Grosor margen imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_margen_grosor]" value="<?php echo $tax_meta['img_margen_grosor']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_margen_redondeo">
				<?php echo __( 'Redondeo margen imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_margen_redondeo]" value="<?php echo $tax_meta['img_margen_redondeo']; ?>">
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_img_borde_color">
				<?php echo __( 'Color borde imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" class="my-color-field" name="tax_meta[img_borde_color]" value="<?php echo $tax_meta['img_borde_color']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_borde_grosor">
				<?php echo __( 'Grosor borde imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_borde_grosor]" value="<?php echo $tax_meta['img_borde_grosor']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_borde_redondeo">
				<?php echo __( 'Redondeo borde imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_borde_redondeo]" value="<?php echo $tax_meta['img_borde_redondeo']; ?>">
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_img_sombra_color">
				<?php echo __( 'Color sombra imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" class="my-color-field" name="tax_meta[img_sombra_color]" value="<?php echo $tax_meta['img_sombra_color']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_sombra_grosor">
				<?php echo __( 'Grosor sombra imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_sombra_grosor]" value="<?php echo $tax_meta['img_sombra_grosor']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_separacion">
				<?php echo __( 'Separación entre imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_separacion]" value="<?php echo $tax_meta['img_separacion']; ?>">
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_img_aumento">
				<?php echo __( 'Aumento imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['img_aumento'] == 'no' ) {
				?>
			<input type="checkbox" name="tax_meta[img_aumento]" value="si">
				<?php
			} else {
				?>
			<input type="checkbox" name="tax_meta[img_aumento]" value="si" checked>
				<?php
			}
			?>
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_cantidad_aumento">
				<?php echo __( 'Porcentaje de aumento', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<input type="text" name="tax_meta[img_cantidad_aumento]" value="<?php echo $tax_meta['img_cantidad_aumento']; ?>">
		</td>
		<th scope="row" valign="top">
			<label for="tax_img_girado">
				<?php echo __( 'Girado imágenes', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['img_girado'] == 'no' ) {
				?>
			<input type="checkbox" name="tax_meta[img_girado]" value="si">
				<?php
			} else {
				?>
			<input type="checkbox" name="tax_meta[img_girado]" value="si" checked>
				<?php
			}
			?>
		</td>
	</tr>
	
	
	
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_composicion_tipo_cambio">
				<?php echo __( 'Tipo cambio composición', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['composicion_tipo_cambio'] == 0 ) {
				?>
			<input type="radio" name="tax_meta[composicion_tipo_cambio]" value="0" checked>
				<?php echo __( 'Cambio', 'stmpili' ); ?>
			<input type="radio" name="tax_meta[composicion_tipo_cambio]" value="1">
				<?php echo __( 'Transición', 'stmpili' ); ?>
				<?php
			} else {
				?>
			<input type="radio" name="tax_meta[composicion_tipo_cambio]" value="0">
				<?php echo __( 'Cambio', 'stmpili' ); ?>
			<input type="radio" name="tax_meta[composicion_tipo_cambio]" value="1" checked>
				<?php echo __( 'Transición', 'stmpili' ); ?>
				<?php
			}
			?>
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_taxonomia_mostrar_sidebar">
				<?php echo __( 'Mostrar barra lateral en taxonomía', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['taxonomia_mostrar_sidebar'] == 'no' ) {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_sidebar]" value="si">
				<?php
			} else {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_sidebar]" value="si" checked>
				<?php
			}
			?>
		</td>
		<th scope="row" valign="top">
			<label for="tax_taxonomia_mostrar_footer">
				<?php echo __( 'Mostrar pie de página en taxonomía', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['taxonomia_mostrar_footer'] == 'no' ) {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_footer]" value="si">
				<?php
			} else {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_footer]" value="si" checked>
				<?php
			}
			?>
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="tax_taxonomia_mostrar_titulo">
				<?php echo __( 'Mostrar título de la taxonomía', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['taxonomia_mostrar_titulo'] == 'no' ) {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_titulo]" value="si">
				<?php
			} else {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_titulo]" value="si" checked>
				<?php
			}
			?>
		</td>
		<th scope="row" valign="top">
			<label for="tax_taxonomia_mostrar_descripcion">
				<?php echo __( 'Mostrar descripción de la taxonomía', 'stmpili' ); ?>
			</label>
		</th>
		<td>
			<?php
			if ( $tax_meta['taxonomia_mostrar_descripcion'] == 'no' ) {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_descripcion]" value="si">
				<?php
			} else {
				?>
			<input type="checkbox" name="tax_meta[taxonomia_mostrar_descripcion]" value="si" checked>
				<?php
			}
			?>
		</td>
	</tr>
	
	</table>

	<?php
	
}

////////////////////////////////////////////////////////////////////////////////
//                                                                            //
// 3.1. FUNCION SALVADO AJUSTES CUSTOM FIELDS                                 //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

add_action( 'edited_stmpili_txn', 'stmpili_funcion_guardar_datos' );

function stmpili_funcion_guardar_datos( $term_id ) {
	
	if ( isset( $_POST['tax_meta'] ) ) {
		
		$t_id = $term_id;
		$tax_meta = get_option( "stmpili_taxonomy_$t_id" );
		$tax_keys = array_keys( $_POST['tax_meta'] );
		
		foreach ( $tax_keys as $key ) {
			
			$tax_meta['img_aumento'] = ( !empty( $_POST['tax_meta']['img_aumento'] ) ) ? 'si' : 'no';
			$tax_meta['img_girado'] = ( !empty( $_POST['tax_meta']['img_girado'] ) ) ? 'si' : 'no';
			$tax_meta['taxonomia_mostrar_sidebar'] = ( !empty( $_POST['tax_meta']['taxonomia_mostrar_sidebar'] ) ) ? 'si' : 'no';
			$tax_meta['taxonomia_mostrar_footer'] = ( !empty( $_POST['tax_meta']['taxonomia_mostrar_footer'] ) ) ? 'si' : 'no';
			$tax_meta['taxonomia_mostrar_titulo'] = ( !empty( $_POST['tax_meta']['taxonomia_mostrar_titulo'] ) ) ? 'si' : 'no';
			$tax_meta['taxonomia_mostrar_descripcion'] = ( !empty( $_POST['tax_meta']['taxonomia_mostrar_descripcion'] ) ) ? 'si' : 'no';
			
			if ( isset( $_POST['tax_meta'][$key] ) ) {
				$tax_meta[$key] = $_POST['tax_meta'][$key];
			}
			
		}
		
		update_option( "stmpili_taxonomy_$t_id", $tax_meta );
		
	}
	
}

/////////////////////////////////////////////////////////////////////////////
//                                                                         //
// 4. INDICACION A WP DE LA PLANTILLA taxonomy.php Y REESCRITURA DE REGLAS //
//                                                                         //
/////////////////////////////////////////////////////////////////////////////

add_filter( 'taxonomy_template', 'stmpili_funcion_plantilla_taxonomia' );

function stmpili_funcion_plantilla_taxonomia( $taxonomy_template ) {
	
	$tipo_consulta = get_query_var( 'taxonomy' );
	
	if ( $tipo_consulta == 'stmpili_txn' ) {
		
		$taxonomy_template = dirname( __FILE__ ) . '/taxonomy-stmgallery.php';
	
	}
	
	return $taxonomy_template;
	
}

register_activation_hook( __FILE__, 'stmpili_funcion_reescribir_reglas' );

function stmpili_funcion_reescribir_reglas() {
	
	stmpili_funcion_crear_taxonomia();
	flush_rewrite_rules();
	
}

//////////////////////////////////////////////////////////////////////
//                                                                  //
// 5. CARGAR DOMINIO TEXTO                                          //
//                                                                  //
//////////////////////////////////////////////////////////////////////

add_action( 'plugins_loaded', 'stmpili_funcion_dominio_texto' );

function stmpili_funcion_dominio_texto() {
	
	load_plugin_textdomain( 'stmpili', FALSE, basename( dirname( __FILE__ ) ) . '/idiomas/' );
	
}

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// 6. FUNCIONES AJAX                                                     //
//    6.1. Función stmpili_funcion_creacion_pila                         //
//         6.1.1. Función stmpili_funcion_tipo_pieza                     //
//    6.2. Función stmpili_funcion_medidas_matriz                        //
//    6.3. Función stmpili_funcion_llenar_matrices                       //
//         6.3.1. Función stmpili_funcion_crear_matriz                   //
//         6.3.2. Función stmpili_funcion_linea_huecos                   //
// 		   6.3.3. Función stmpili_funcion_hazme_hueco                    //
// 		   6.3.4. Función stmpili_funcion_rellena_hueco                  //
// 		   6.3.5. Función stmpili_funcion_pieza_libre                    //
// 		   6.3.6. Función stmpili_funcion_buscar_pieza                   //
// 		   6.3.7. Función stmpili_funcion_coloca_pieza                   //
//    6.4. Función stmpili_funcion_ajustar_matrices                      //
//         6.4.1. Función stmpili_horizontal_busco_hueco_hasta_pieza     //
// 		   6.4.2. Función stmpili_horizontal_busco_siguiente_pieza       //
// 		   6.4.3. Función stmpili_horizontal_buscar_pieza_hueco_menor    //
// 		   6.4.4. Función stmpili_vertical_busco_hueco_hasta_pieza       //
// 		   6.4.5. Función stmpili_vertical_busco_siguiente_pieza         //
// 		   6.4.6. Función stmpili_vertical_buscar_pieza_hueco_menor      //
// 		   6.4.7. Función stmpili_funcion_horizontal_busca_huecos_ajusta //
// 		   6.4.8. Función stmpili_funcion_vertical_busca_huecos_ajusta   //
//    6.5. Función stmpili_funcion_generacion_resultado                  //
//    6.6. Función stmpili_funcion_estilos_css                           //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////
//                                       //
// 6. FUNCIONES AJAX                     //
//    6.0. Funciones principales de AJAX //
//                                       //
///////////////////////////////////////////

add_action( 'init', 'stmpili_funcion_enqueue_scripts' );

function stmpili_funcion_enqueue_scripts() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ) . 'js/mi_ajax.js' );
	$title_nonce = wp_create_nonce( 'devolucion_matriz' );
	wp_localize_script( 'ajax-script', 'mi_objeto_ajax', array(
		'ajax_url'	=> admin_url( 'admin-ajax.php' ),
		'nonce'		=> $title_nonce
	));
	
}
	
add_action( 'wp_ajax_nopriv_devuelve_composicion', 'stmpili_funcion_devolver_matriz' );
add_action( 'wp_ajax_devuelve_composicion', 'stmpili_funcion_devolver_matriz' );

function stmpili_funcion_devolver_matriz() {
	
	check_ajax_referer( 'devolucion_matriz' );
	
	$ancho_div = $_POST['ancho'];
	$alto_ventana = $_POST['alto'];
	$termino = $_POST['termino'];
	
	$stmpili_pila = array();
	$stmpili_matriz = array();
	$stmpili_filas;
	$stmpili_columnas;
	$stmpili_matriz_actual;
	
	stmpili_funcion_creacion_pila( $termino );
	stmpili_funcion_medidas_matriz( $ancho_div, $alto_ventana, $termino );
	$matrices_creadas = stmpili_funcion_llenar_matrices();
	$matrices_ajustadas = stmpili_funcion_ajustar_matrices();
	$resultado_final = stmpili_funcion_generacion_resultado( $matrices_creadas[1], $matrices_ajustadas, $termino, $ancho_div );
	$estilos = stmpili_funcion_estilos_css( $termino, $ancho_div );
	echo $estilos . $resultado_final;
	wp_die();
	
}

///////////////////////////////////////////////////////
//                                                   //
// 6. FUNCIONES AJAX                                 //
//    6.1. Función stmpili_funcion_creacion_pila     //
//         6.1.1. Función stmpili_funcion_tipo_pieza //
//                                                   //
///////////////////////////////////////////////////////

function stmpili_funcion_creacion_pila( $composicion ) {
	
	$auxiliar = array();
	global $stmpili_pila;

	query_posts( array(
		'posts_per_page'	=> -1,
		'post_type'		=> 'attachment',
		'post_status'	=> 'any',
		'tax_query'		=> array(
			array(
				'taxonomy'	=> 'stmpili_txn',
				'field'		=> 'name',
				'terms'		=> $composicion
				)
		)
	));
	
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			$attachment = get_post();
			$fichero = wp_get_attachment_url();
			$tecnicos = stmpili_funcion_tipo_pieza( $fichero );
			$auxiliar[] = array(
				'URL'			=> urlencode( $fichero ),
				'Title'			=> $attachment->post_title,
				'Link'			=> '',
				'tipo'			=> $tecnicos[0],
				'ancho'			=> $tecnicos[1],
				'alto'			=> $tecnicos[2],
				'colocada'		=> false,
				'ajustada-h'	=> false,
				'ajustada-v'	=> false,
				'visualizada'	=> false
			);
		}
	}

	shuffle( $auxiliar );
		
	$contador = 0;
	foreach ( $auxiliar as $pieza ) {
		$contador++;
		$stmpili_pila[$contador]['URL'] = $pieza['URL'];
		$stmpili_pila[$contador]['Title'] = $pieza['Title'];
		$stmpili_pila[$contador]['Link'] = $pieza['Link'];
		$stmpili_pila[$contador]['tipo'] = $pieza['tipo'];
		if ( mt_rand( 1, 10 ) > 5 ) {
			$stmpili_pila[$contador]['ancho'] = $pieza['ancho'] * 2;
			$stmpili_pila[$contador]['alto'] = $pieza['alto'] * 2;
		} else {
			$stmpili_pila[$contador]['ancho'] = $pieza['ancho'];
			$stmpili_pila[$contador]['alto'] = $pieza['alto'];
		}
		$stmpili_pila[$contador]['colocada'] = $pieza['colocada'];
		$stmpili_pila[$contador]['ajustada-h'] = $pieza['ajustada-h'];
		$stmpili_pila[$contador]['ajustada-v'] = $pieza['ajustada-v'];
		$stmpili_pila[$contador]['visualizada'] = $pieza['visualizada'];
	}

}

function stmpili_funcion_tipo_pieza( $imagen ) {
	
	$medidas = array();
	$medidas = getimagesize( $imagen );
	$ancho = $medidas[0];
	$alto = $medidas[1];
	$proporcion = $ancho / $alto;
	
	$minimo = min( abs( $proporcion - 0.66 ), abs( $proporcion - 1.5 ), abs( $proporcion - 1.33 ), abs( $proporcion - 0.75 ), abs( $proporcion - 1 ) );
	switch ( $minimo ) {
		case abs( $proporcion - 0.66 ):
			$tipo = 1;
			$ancho_pieza = 2;
			$alto_pieza = 3;
			break;
		case abs( $proporcion - 1.5 ):
			$tipo = 2;
			$ancho_pieza = 3;
			$alto_pieza = 2;
			break;
		case abs( $proporcion - 1.33 ):
			$tipo = 3;
			$ancho_pieza = 4;
			$alto_pieza = 3;
			break;
		case abs( $proporcion - 0.75 ):
			$tipo = 4;
			$ancho_pieza = 3;
			$alto_pieza = 4;
			break;
		case abs( $proporcion - 1 ):
			$tipo =5;
			$ancho_pieza = 3;
			$alto_pieza = 3;
			break;
	}
	
	return array( $tipo, $ancho_pieza, $alto_pieza );
	
}

////////////////////////////////////////////////////
//                                                //
// 6. FUNCIONES AJAX                              //
//    6.2. Función stmpili_funcion_medidas_matriz //
//                                                //
////////////////////////////////////////////////////

function stmpili_funcion_medidas_matriz( $anchura_pantalla, $altura_ventana, $termino ) {
	
	$term = get_term_by( 'name', $composicion, 'stmpili_txn' );
	$id = $term->term_id;
	$tax_meta = get_option( "stmpili_taxonomy_$id" );
	$tax_meta['composicion_tipo_cambio'] = ( !isset( $tax_meta['composicion_tipo_cambio'] ) ) ? 0 : $tax_meta['composicion_tipo_cambio'];
	
	global $stmpili_columnas, $stmpili_filas, $proporcion;
	
	if ( $anchura_pantalla >= 1200 ) { $modulo = 50; $proporcion = 1; }
	if ( $anchura_pantalla < 1200 && $anchura_pantalla >= 992 ) { $modulo = 40; $proporcion = 0.8; }
	if ( $anchura_pantalla < 992 && $anchura_pantalla >= 768 ) { $modulo = 30; $proporcion = 0.6;}
	if ( $anchura_pantalla < 768 ) { $modulo = 20; $proporcion = 0.4;}
	
	$stmpili_columnas = ( $anchura_pantalla - $anchura_pantalla % $modulo ) / $modulo;
	if ( $tax_meta['composicion_tipo_cambio'] == 0 ) {
	}
	$stmpili_filas = ( ( $altura_ventana - $altura_ventana % $modulo ) / $modulo ) - 3;
	?><script>console.log('Ancho div: <?php echo $anchura_pantalla; ?>. Altura ventana: <?php echo $altura_ventana; ?>. Matriz: <?php echo $stmpili_columnas . ' x ' . $stmpili_filas; ?>.');</script><?php
	
}

//////////////////////////////////////////////////////////
//                                                      //
// 6. FUNCIONES AJAX                                    //
//    6.3. Función stmpili_funcion_llenar_matrices      //
//         6.3.1. Función stmpili_funcion_crear_matriz  //
//         6.3.2. Función stmpili_funcion_linea_huecos  //
// 		   6.3.3. Función stmpili_funcion_hazme_hueco   //
// 		   6.3.4. Función stmpili_funcion_rellena_hueco //
// 		   6.3.5. Función stmpili_funcion_pieza_libre   //
// 		   6.3.6. Función stmpili_funcion_buscar_pieza  //
// 		   6.3.7. Función stmpili_funcion_coloca_pieza  //
//                                                      //
//////////////////////////////////////////////////////////

function stmpili_funcion_llenar_matrices() {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_columnas, $stmpili_filas, $stmpili_matriz_actual;
	
	$stmpili_matriz_actual = 1;
	stmpili_funcion_crear_matriz( $stmpili_matriz_actual );
	$linea_actual=1;

	while ( stmpili_funcion_pieza_libre() != false ) {
		
		$linea_actual = stmpili_funcion_linea_huecos( $stmpili_matriz_actual );
		if ( $linea_actual != false && $linea_actual < $stmpili_filas + 1) {
			
		} else {
			
			$stmpili_matriz_actual++;
			stmpili_funcion_crear_matriz( $stmpili_matriz_actual );
			$linea_actual = 1;
			continue;
			
		}
		
		if ( stmpili_funcion_hazme_hueco( $linea_actual ) != false ) {
			
			$hueco = stmpili_funcion_hazme_hueco( $linea_actual );
			$posx_hueco = $hueco[0];
			$largo_hueco = $hueco[1];

		}
		
		if ( $largo_hueco == 1 ) {
			stmpili_funcion_rellena_hueco( $stmpili_matriz_actual, $posx_hueco, $linea_actual, $largo_hueco );
			continue;
		}
		
		$pieza_libre = stmpili_funcion_pieza_libre_ancho_mayor();
		$ancho_pieza_libre = $stmpili_pila[$pieza_libre]['ancho'];
		
		if ( $largo_hueco < $ancho_pieza_libre ) {
			
			for ( $ancho_buscado = $largo_hueco; $ancho_buscado > 1; $ancho_buscado-- ) {
				$colocada = false;
				if ( stmpili_funcion_buscar_pieza( $ancho_buscado, $stmpili_filas - $linea_actual + 1 ) != 0 ) {
					
					$pieza_entra = stmpili_funcion_buscar_pieza( $ancho_buscado, $stmpili_filas - $linea_actual + 1 );
					stmpili_funcion_coloca_pieza( $pieza_entra, $posx_hueco, $linea_actual );
					$colocada = true;
					continue 2;
					
				}
				
			}
			
			if ( $colocada == false ) {
				
				stmpili_funcion_rellena_hueco( $stmpili_matriz_actual, $posx_hueco, $linea_actual, $largo_hueco );
				
			}
			
		}
		
		if ( $largo_hueco >= $ancho_pieza_libre ) {
			
			if ( $stmpili_pila[$pieza_libre]['alto'] <= $stmpili_filas - $linea_actual + 1 ) {
				
				stmpili_funcion_coloca_pieza( $pieza_libre, $posx_hueco, $linea_actual );
				
			} else {
				
				$largo_inicial = ( $largo_hueco > 8 ) ? 8 : $largo_hueco;
				
				for ( $ancho_buscado = $largo_inicial; $ancho_buscado > 1; $ancho_buscado-- ) {
				
					$colocada = false;
					$pieza_entra = stmpili_funcion_buscar_pieza( $ancho_buscado, $stmpili_filas - $linea_actual + 1 );
					if ( $pieza_entra != 0 && $colocada == false ) {
						
						stmpili_funcion_coloca_pieza( $pieza_entra, $posx_hueco, $linea_actual );
						$colocada = true;
						continue 2;
						
					}
					
				}
			
				if ( $colocada == false ) {
					
					stmpili_funcion_rellena_hueco( $stmpili_matriz_actual, $posx_hueco, $linea_actual, $largo_hueco );
					
				}
			
			}			

		}
					
	}
	
	return array( $stmpili_pila, $stmpili_matriz);
}
		
function stmpili_funcion_crear_matriz( $numero_matriz ) {
	
	global $stmpili_matriz;
	global $stmpili_matriz_actual;
	global $stmpili_filas, $stmpili_columnas;
	
	for ( $contador_y = 1; $contador_y < $stmpili_filas + 1; $contador_y++ ) {
		for ( $contador_x = 1; $contador_x < $stmpili_columnas + 1; $contador_x++ ) {
			$stmpili_matriz[$numero_matriz][$contador_x][$contador_y] = 0;
		}
	}
	
}

function stmpili_funcion_linea_huecos() {
	
	global $stmpili_matriz, $stmpili_matriz_actual, $stmpili_filas, $stmpili_columnas;
	
	for ( $contador_y = 1; $contador_y < $stmpili_filas + 1; $contador_y++ ) {
		for ( $contador_x = 1; $contador_x < $stmpili_columnas + 1; $contador_x++ ) {
			if ( $stmpili_matriz[$stmpili_matriz_actual][$contador_x][$contador_y] == 0 ) {
				
				return $contador_y;
				
			}
		}
	}
	
	return false;
	
}

function stmpili_funcion_hazme_hueco( $fila ) {

	global $stmpili_matriz, $stmpili_matriz_actual, $stmpili_filas, $stmpili_columnas;

	for ( $contador_x = 1; $contador_x < $stmpili_columnas + 1; $contador_x++ ) {
		if ( $stmpili_matriz[$stmpili_matriz_actual][$contador_x][$fila] == 0 ) {
			
			for ( $contador_xx = $contador_x + 1; $contador_xx < $stmpili_columnas + 1; $contador_xx++ ) {
				
				if ( $stmpili_matriz[$stmpili_matriz_actual][$contador_xx][$fila] != 0 ) {
					
					return array( $contador_x, $contador_xx - $contador_x );
					
				}
				
			}
			
			return array( $contador_x, $contador_xx - $contador_x );
			
		}
	}
	
	return false;
	
}

function stmpili_funcion_rellena_hueco ( $num, $x, $y, $largo ) {

	global $stmpili_matriz;

	for ( $contador = 0; $contador < $largo; $contador++ ) {
		$stmpili_matriz[$num][$x+$contador][$y] = -1;
	}
}

function stmpili_funcion_pieza_libre( $actual = 0 ) {
	
	global $stmpili_pila;

	$alto_pila = count( $stmpili_pila );
	
	for ( $contador = $actual + 1; $contador < $alto_pila + 1; $contador++ ) {
		if ( $stmpili_pila[$contador]['colocada'] == false ) {
			
			return $contador;
			
		}
	}
	
	return false;
	
}

function stmpili_funcion_buscar_pieza( $ancho, $alto ) {

	global $stmpili_pila;
	
	$alto_pila = count( $stmpili_pila );
	for ( $contador = 1; $contador < $alto_pila + 1; $contador++ ) {
		if ( $stmpili_pila[$contador]['colocada'] == false && $stmpili_pila[$contador]['ancho'] == $ancho && $stmpili_pila[$contador]['alto'] < $alto +1 ) {
			return $contador;
		}
	}
	
	return 0;
	
}

function stmpili_funcion_coloca_pieza( $id, $x, $y ) {

	global $stmpili_pila, $stmpili_matriz, $stmpili_matriz_actual;
	
	$ancho = $stmpili_pila[$id]['ancho'];
	$alto = $stmpili_pila[$id]['alto'];
	
	for ( $contador_y = $y; $contador_y < $y + $alto; $contador_y++ ) {
		for ( $contador_x = $x; $contador_x < $x + $ancho; $contador_x++ ) {
			
			$stmpili_matriz[$stmpili_matriz_actual][$contador_x][$contador_y] = $id;
			
		}
	}
	
	$stmpili_pila[$id]['colocada'] = true;

}

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// 6. FUNCIONES AJAX                                                     //
//    6.4. Función stmpili_funcion_ajustar_matrices                      //
//         6.4.1. Función stmpili_horizontal_busco_hueco_hasta_pieza     //
// 		   6.4.2. Función stmpili_horizontal_busco_siguiente_pieza       //
// 		   6.4.3. Función stmpili_horizontal_buscar_pieza_hueco_menor    //
// 		   6.4.4. Función stmpili_vertical_busco_hueco_hasta_pieza       //
// 		   6.4.5. Función stmpili_vertical_busco_siguiente_pieza         //
// 		   6.4.6. Función stmpili_vertical_buscar_pieza_hueco_menor      //
// 		   6.4.7. Función stmpili_funcion_horizontal_busca_huecos_ajusta //
// 		   6.4.8. Función stmpili_funcion_vertical_busca_huecos_ajusta   //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

function stmpili_funcion_ajustar_matrices() {

	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;
	
	$ultima_matriz = $stmpili_matriz_actual;
	$matriz = 0;
	
	while ( $ultima_matriz > $matriz ) {
		
		$matriz++;
		
		for ($contador_y = 1; $contador_y < $stmpili_filas + 1; $contador_y++ ) {
			$resultado = stmpili_horizontal_busco_hueco_hasta_pieza( $matriz, $contador_y );
			$hueco = $resultado[0];
			$pieza = $resultado[1];
			if ( $hueco != 0 && $hueco != $stmpili_columnas ) {
				if ( stmpili_horizontal_busco_siguiente_pieza( $matriz, $contador_y, $hueco, $pieza ) != false ) {
					stmpili_horizontal_buscar_pieza_hueco_menor( $matriz, $hueco, $pieza );
				}
			}
		}
		
		for ($contador_x = 1; $contador_x < $stmpili_columnas + 1; $contador_x++ ) {
			$resultado = stmpili_vertical_busco_hueco_hasta_pieza( $matriz, $contador_x );
			$hueco = $resultado[0];
			$pieza = $resultado[1];
			if ( $hueco != 0 && $hueco != $stmpili_filas ) {
				if ( stmpili_vertical_busco_siguiente_pieza( $matriz, $contador_x, $hueco, $pieza ) != false ) {
					stmpili_vertical_buscar_pieza_hueco_menor( $matriz, $hueco, $pieza );
				}
			}
		}
		
		for ( $y=1; $y < $stmpili_filas + 1; $y++ ) {
			$auxiliar = $stmpili_matriz[$matriz][1][$y];
			if ( $auxiliar != -1 && $auxiliar !=0 && $stmpili_pila[$auxiliar]['ajustada-h'] != true ) {
				$stmpili_pila[$auxiliar]['ajustada-h'] = true;
			}
		}
		$x = $stmpili_columnas + 1;
		$y = $stmpili_filas;
		while ( $x > 0 && $y > 0 ) {
			$x--;
			if ( $x == 0 ) {
				$x = $stmpili_columnas;
				$y--;
			}
		
			$pieza = $stmpili_matriz[$matriz][$x][$y];
			if ( $pieza != -1 && $pieza != 0 && $stmpili_pila[$pieza]['ajustada-h'] != true ) {
			
				stmpili_funcion_horizontal_busca_huecos_ajusta( $pieza, $matriz, $x, $y );
				$stmpili_pila[$pieza]['ajustada-h'] = true;
			}
		}
		
		for ( $x=1; $x < $stmpili_columnas + 1; $x++ ) {
			$auxiliar = $stmpili_matriz[$matriz][$x][1];
			if ( $auxiliar != -1 && $auxiliar !=0 && $stmpili_pila[$auxiliar]['ajustada-v'] != true ) {
				$stmpili_pila[$auxiliar]['ajustada-v'] = true;
			}
		}

		$x = $stmpili_columnas;
		$y = $stmpili_filas + 1;
		while ( $x > 0 && $y > 0 ) {
			$y--;
			if ( $y == 0 ) {
				$y = $stmpili_filas;
				$x--;
			}
		
			$pieza = $stmpili_matriz[$matriz][$x][$y];
			if ( $pieza != -1 && $pieza !=0 && $stmpili_pila[$pieza]['ajustada-v'] == false ) {
			
				stmpili_funcion_vertical_busca_huecos_ajusta( $pieza, $matriz, $x, $y );
				$stmpili_pila[$pieza]['ajustada-v'] = true;
			
			}

		}
		
	}
	return $stmpili_matriz;
}

function stmpili_horizontal_busco_hueco_hasta_pieza ( $matriz, $linea ) {

	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;
	
	$contador_x = $stmpili_columnas;
	while ( $contador_x > 0 && $stmpili_matriz[$matriz][$contador_x][$linea] == -1 ) {
		$contador_x--;
	}
	
	return array( $stmpili_columnas - $contador_x, $stmpili_matriz[$matriz][$contador_x][$linea] );

}

function stmpili_horizontal_busco_siguiente_pieza( $matriz, $linea, $hueco, $pieza ) {
	
	$contador_x = $stmpili_columnas;
	$unica_pieza = true;
	
	while ( $contador_x > 0 && $stmpili_matriz[$matriz][$contador_x][$linea] == -1 || $stmpili_matriz[$matriz][$contador_x][$linea] == $pieza ) {
		$contador_x--;
	}
	
	if ( $contador_x != 0 ) {
		$unica_pieza = false;
	}
	return $unica_pieza;
	
}

function stmpili_horizontal_buscar_pieza_hueco_menor( $matriz, $hueco, $pieza ) {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;
	
	$x = 1;
	$y = 1;
	while ( $stmpili_matriz[$matriz][$x][$y] != $pieza ) {
		$x++;
		if ( $x > $stmpili_columnas ) {
			$x = 1;
			$y++;
		}
	}
	
	$hueco_mayor = $stmpili_columnas;
	for ( $altura = $y; $altura < $y + $stmpili_pila[$pieza]['alto']; $altura++ ) {
		$hueco_menor = 0;
		$contador_x = $x + $stmpili_pila[$pieza]['ancho'];
		while ( $stmpili_matriz[$matriz][$contador_x][$altura] == -1 && $contador_x < $stmpili_columnas + 1 ) {
			$contador_x++;
			$hueco_menor++;
		}
		
		if ( $hueco_mayor > $hueco_menor ) {
			
			$hueco_mayor = $hueco_menor;
			
		}
	}
	$stmpili_pila[$pieza]['ajustada-h'] = true;

	if ( $hueco_mayor > 0 ) {
		
		for ($contador_y = $y; $contador_y < $y + $stmpili_pila[$pieza]['alto']; $contador_y++ ) {
			for ( $contador_x = $x; $contador_x < $x + $hueco_mayor; $contador_x++ ) {
				$stmpili_matriz[$matriz][$contador_x][$contador_y] = -1;
			}
			for ($contador_x = $x + $hueco_mayor; $contador_x < $x + $hueco_mayor + $stmpili_pila[$pieza]['ancho']; $contador_x++ ) {
				$stmpili_matriz[$matriz][$contador_x][$contador_y] = $pieza;
			}
		}

	}
	
}

function stmpili_vertical_busco_hueco_hasta_pieza ( $matriz, $columna ) {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;
	
	$contador_y = $stmpili_filas;
	while ( $contador_y > 0 && $stmpili_matriz[$matriz][$columna][$contador_y] == -1 ) {
		$contador_y--;
	}
	
	return array( $stmpili_filas - $contador_y, $stmpili_matriz[$matriz][$columna][$contador_y] );
}

function stmpili_vertical_busco_siguiente_pieza( $matriz, $columna, $hueco, $pieza ) {
	
	$contador_y = $stmpili_filas;
	$unica_pieza = true;
	
	while ( $contador_y > 0 && $stmpili_matriz[$matriz][$columna][$contador_y] == -1 || $stmpili_matriz[$matriz][$columna][$contador_y] == $pieza ) {
		$contador_y--;
	}
	
	if ( $contador_y != 0 ) {
		$unica_pieza = false;
	}
	
	return $unica_pieza;
	
}

function stmpili_vertical_buscar_pieza_hueco_menor( $matriz, $hueco, $pieza ) {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;
	
	$x = 1;
	$y = 1;
	while ( $stmpili_matriz[$matriz][$x][$y] != $pieza ) {
		$y++;
		if ( $y > $stmpili_filas ) {
			$y = 1;
			$x++;
		}
	}
	
	$hueco_mayor = $stmpili_filas;
	for ( $anchura = $x; $anchura < $x + $stmpili_pila[$pieza]['ancho']; $anchura++ ) {
		$hueco_menor = 0;
		$contador_y = $y + $stmpili_pila[$pieza]['alto'];
		while ( $stmpili_matriz[$matriz][$anchura][$contador_y] == -1 && $contador_y < $stmpili_filas + 1 ) {
			$contador_y++;
			$hueco_menor++;
		}
		
		if ( $hueco_mayor > $hueco_menor ) {
			
			$hueco_mayor = $hueco_menor;
			
		}
		
	}
	
	if ( $hueco_mayor > 0 ) {
			
		for ($contador_x = $x; $contador_x < $x + $stmpili_pila[$pieza]['ancho']; $contador_x++ ) {
			for ( $contador_y = $y; $contador_y < $y + $hueco_mayor; $contador_y++ ) {
				$stmpili_matriz[$matriz][$contador_x][$contador_y] = -1;
			}
			for ($contador_y = $y + $hueco_mayor; $contador_y < $y + $hueco_mayor + $stmpili_pila[$pieza]['alto']; $contador_y++ ) {
				$stmpili_matriz[$matriz][$contador_x][$contador_y] = $pieza;
			}
		}

		$stmpili_pila[$pieza]['ajustada-v'] = true;

	}
	
}

function stmpili_funcion_horizontal_busca_huecos_ajusta( $pieza, $matriz, $x, $y ) {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;

	$altura = $stmpili_pila[$pieza]['alto'];
	$anchura = $stmpili_pila[$pieza]['ancho'];
	
	$hueco_anterior = $stmpili_columnas;
	$hueco_posterior = $stmpili_columnas;
	
	for ( $contador_y = $y; $contador_y > $y - $altura; $contador_y-- ) {
		
		$hueco = 0;
		$pos_x = $x - $anchura;
		
		while ( $stmpili_matriz[$matriz][$pos_x][$contador_y] == -1 && $pos_x > 0 ) {
			
			$hueco++;
			$pos_x--;
			
		}
		if ( $hueco < $hueco_anterior ) {
			
			$hueco_anterior = $hueco;
		}
		
	}
	
	for ( $contador_y = $y; $contador_y > $y - $altura; $contador_y-- ) {
		
		$hueco = 0;
		$pos_x = $x + 1;
		
		while ( $stmpili_matriz[$matriz][$pos_x][$contador_y] == -1 && $pos_x < $stmpili_columnas + 1 ) {
			
			$hueco++;
			$pos_x++;
			
		}
		
		if ( $hueco < $hueco_posterior ) {
			
			$hueco_posterior = $hueco;
			
		}
		
	}
	
	$hueco_total = $hueco_anterior + $hueco_posterior;
	$mitad = ( $hueco_total - ($hueco_total % 2) ) / 2;
	if ( $mitad != 0 && $mitad != $hueco_posterior ) {
		$desplazamiento = abs($hueco_posterior - $mitad);
		if ( $hueco_posterior > $hueco_anterior ) {
			for ( $contador_y = $y - $altura + 1; $contador_y < $y + 1; $contador_y++ ) {
				for ( $contador_x = $x - $anchura + 1; $contador_x < $x - $anchura + $desplazamiento + 1; $contador_x++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = -1;
				}
				for ( $contador_x = $x - $anchura + $desplazamiento + 1; $contador_x < $x + $desplazamiento +1; $contador_x++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = $pieza;
				}
			
			}
		} else {
			for ( $contador_y = $y - $altura + 1; $contador_y < $y + 1; $contador_y++ ) {
				for ( $contador_x = $x - $desplazamiento + 1; $contador_x < $x + 1; $contador_x++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = -1;
				}
				for ( $contador_x = $x - $anchura - $desplazamiento + 1; $contador_x < $x - $desplazamiento +1; $contador_x++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = $pieza;
				}
			
			}
		}
	}
	
	$stmpili_pila[$pieza]['ajustada-h'] = true;
	
}

function stmpili_funcion_vertical_busca_huecos_ajusta( $pieza, $matriz, $x, $y ) {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual;

	$altura = $stmpili_pila[$pieza]['alto'];
	$anchura = $stmpili_pila[$pieza]['ancho'];
	
	$hueco_superior = $stmpili_filas;
	$hueco_inferior = $stmpili_filas;
	
	for ( $contador_x = $x; $contador_x > $x - $anchura; $contador_x-- ) {
		
		$hueco = 0;
		$pos_y = $y - $altura;
		
		while ( $stmpili_matriz[$matriz][$contador_x][$pos_y] == -1 && $pos_y > 0 ) {
			
			$hueco++;
			$pos_y--;
			
		}
		if ( $hueco < $hueco_superior ) {
			
			$hueco_superior = $hueco;
		}
		
	}
	
	for ( $contador_x = $x; $contador_x > $x - $anchura; $contador_x-- ) {
		
		$hueco = 0;
		$pos_y = $y + 1;
		
		while ( $stmpili_matriz[$matriz][$contador_x][$pos_y] == -1 && $pos_y < $stmpili_filas + 1 ) {
			
			$hueco++;
			$pos_y++;
			
		}
		
		if ( $hueco < $hueco_inferior ) {
			
			$hueco_inferior = $hueco;
			
		}
		
	}
	
	$hueco_total = $hueco_superior + $hueco_inferior;
	$mitad = ( $hueco_total - ( $hueco_total % 2 ) ) / 2;
	
	if ( $mitad != 0 && $mitad != $hueco_inferior ) {
		$desplazamiento = abs($hueco_inferior - $mitad);
		if ( $hueco_inferior > $hueco_superior ) {
			for ( $contador_x = $x - $anchura + 1; $contador_x < $x + 1; $contador_x++ ) {
			
				for ( $contador_y = $y - $altura + 1; $contador_y < $y - $altura + $desplazamiento + 1; $contador_y++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = -1;
				}
				for ( $contador_y = $y - $altura + $desplazamiento + 1; $contador_y < $y + $desplazamiento + 1; $contador_y++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = $pieza;
				}
			
			}
		} else {
			for ( $contador_x = $x - $anchura + 1; $contador_x < $x + 1; $contador_x++ ) {
			
				for ( $contador_y = $y - $desplazamiento + 1; $contador_y < $y + 1; $contador_y++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = -1;
				}
				for ( $contador_y = $y - $altura - $desplazamiento + 1; $contador_y < $y - $desplazamiento + 1; $contador_y++ ) {
					$stmpili_matriz[$matriz][$contador_x][$contador_y] = $pieza;
				}
			
			}
		}
	}
	
	$stmpili_pila[$pieza]['ajustada-v'] = true;
	
}

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// 6. FUNCIONES AJAX                                                     //
//    6.5. Función stmpili_funcion_generacion_resultado                  //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

function stmpili_funcion_generacion_resultado( $matrices_rellenas, $matrices_ajustadas, $composicion, $ancho_total ) {
	
	global $stmpili_pila, $stmpili_matriz, $stmpili_filas, $stmpili_columnas, $stmpili_matriz_actual, $proporcion;

	// Recuperamos los ajustes de la base de datos
	$term = get_term_by( 'name', $composicion, 'stmpili_txn' );
	$id = $term->term_id;
	$tax_meta = get_option( "stmpili_taxonomy_$id" );

	$tax_meta['img_margen_color'] = ( !isset( $tax_meta['img_margen_color'] ) ) ? '#fff' : $tax_meta['img_margen_color'];
	$tax_meta['img_margen_grosor'] = ( !isset( $tax_meta['img_margen_grosor'] ) ) ? 0 : $tax_meta['img_margen_grosor'];
	$tax_meta['img_margen_redondeo'] = ( !isset( $tax_meta['img_margen_redondeo'] ) ) ? 0 : $tax_meta['img_margen_redondeo'];
	$tax_meta['img_borde_color'] = ( !isset( $tax_meta['img_borde_color'] ) ) ? '#000' : $tax_meta['img_borde_color'];
	$tax_meta['img_borde_grosor'] = ( !isset( $tax_meta['img_borde_grosor'] ) ) ? 0 : $tax_meta['img_borde_grosor'];
	$tax_meta['img_borde_redondeo'] = ( !isset( $tax_meta['img_borde_redondeo'] ) ) ? 0 : $tax_meta['img_borde_redondeo'];
	$tax_meta['composicion_tipo_cambio'] = ( !isset( $tax_meta['composicion_tipo_cambio'] ) ) ? 0 : $tax_meta['composicion_tipo_cambio'];
	$tax_meta['img_aumento'] = ( !isset( $tax_meta['img_aumento'] ) ) ? 'no' : $tax_meta['img_aumento'];
	$tax_meta['img_cantidad_aumento'] = ( !isset( $tax_meta['img_cantidad_aumento'] ) ) ? 0 : $tax_meta['img_cantidad_aumento'];
	$tax_meta['img_separacion'] = ( !isset( $tax_meta['img_separacion'] ) ) ? 0 : $tax_meta['img_separacion'];

	$tabla_pila = '<table class="pila"><tr><td>Pieza</td><td>Ancho</td><td>Alto</td><tr>';
	$contador = 0;
	foreach ( $stmpili_pila as $pieza ) {
		$contador++;
		$tabla_pila .= '<tr><td>' . $contador . '</td><td>' . $stmpili_pila[$contador]['ancho'] . '</td><td>' . $stmpili_pila[$contador]['alto'] . '</td></tr>';
	}
	$tabla_pila .= '</table><br>';
	
	$tabla_rellena = 'TABLAS RELLENAS<br>';
	for ( $matriz = 1; $matriz < $stmpili_matriz_actual + 1; $matriz++ ) {
		$tabla_rellena .= 'Matriz: ' . $matriz . '<br>';
		$tabla_rellena .= '<table class="matriz_rellena">';
		for ( $y = 1; $y < $stmpili_filas + 1; $y++ ) {
			$tabla_rellena .= '<tr>';
			for ( $x = 1; $x < $stmpili_columnas + 1; $x++ ) {
				$tabla_rellena .= '<td>' . $matrices_rellenas[$matriz][$x][$y] . '</td>';
			}
			$tabla_rellena .= '</tr>';
		}
		$tabla_rellena .= '</table><br>';
	}
		
	$tabla_ajustada = 'TABLAS AJUSTADAS<br>';
	for ( $matriz = 1; $matriz < $stmpili_matriz_actual + 1; $matriz++ ) {
		$tabla_ajustada .= 'Matriz: ' . $matriz . '<br>';
		$tabla_ajustada .= '<table class="matriz_ajustada">';
		for ( $y = 1; $y < $stmpili_filas + 1; $y++ ) {
			$tabla_ajustada .= '<tr>';
			for ( $x = 1; $x < $stmpili_columnas + 1; $x++ ) {
				$tabla_ajustada .= '<td>' . $matrices_ajustadas[$matriz][$x][$y] . '</td>';
			}
			$tabla_ajustada .= '</tr>';
		}
		$tabla_ajustada .= '</table><br>';
	}
	
	
	$tabla_visual = '';
	$alto_acumulado = 0;
	for ( $matriz = 1; $matriz < $stmpili_matriz_actual + 1; $matriz++ ) {
		if ( $tax_meta['composicion_tipo_cambio'] == 0 ) {
			$ancho_columna = ( $matriz == 1 || $matriz == $stmpili_matriz_actual ) ? $ancho_total / ( $stmpili_columnas + 1 ) : $ancho_total / ( $stmpili_columnas + 2 );
			$ancho_tabla = ( $matriz == 1 || $matriz == $stmpili_matriz_actual ) ? $ancho_columna * ( $stmpili_columnas + 1 ) : $ancho_columna * ( $stmpili_columnas + 2 ); 
			$alto_tabla = $ancho_columna * $stmpili_filas;
		} else {
			$ancho_columna = $ancho_total / $stmpili_columnas;
			$ancho_tabla = $ancho_columna * $stmpili_columnas;
			$alto_tabla = $ancho_columna * ( $stmpili_filas + 1 );
			$alto_acumulado = ( $ancho_columna * $stmpili_filas +20) * ( $matriz + 1 ) + $ancho_columna;
		}

		$tabla_visual .= '<div class="matriz visual" style="width: ' . $ancho_tabla . 'px; height: '. $alto_tabla . 'px; position: relative;" id="tabla-' . $matriz . '">';
		for ( $y=1; $y < $stmpili_filas + 1; $y++ ) {
			for ( $x = 1; $x < $stmpili_columnas + 1; $x++ ) {
				if ( $y == 1 && $x == 1 && $tax_meta['composicion_tipo_cambio'] == 0 && $matriz != 1 ) {
					$anterior = $matriz - 1;
					$tabla_visual .= '<div style="width: '.$ancho_columna . 'px; height: '.$stmpili_filas * $ancho_columna.'px; position: absolute; top: 0; left: 0;" class="cambio" onclick="document.getElementById(\'tabla-'. $anterior .'\').style.display=\'block\';document.getElementById(\'tabla-'. $matriz .'\').style.display=\'none\';"><span class="icono icon-left-open" style="font-size: '.$ancho_columna.'px;position:relative;left:-'.($ancho_columna/2).'px;top:'.($stmpili_filas * $ancho_columna / 2).'px;"></span></div>';
				}
				$pieza = $matrices_ajustadas[$matriz][$x][$y];
				if ($pieza == 0 ) {
					$posicion_x = ( $tax_meta['composicion_tipo_cambio'] == 0 && $matriz != 1 ) ? $x * $ancho_columna : ($x - 1) * $ancho_columna; // Varía en funcion de barra izquierda 'anterior'
					$posicion_y = ($y - 1) * $ancho_columna;
					$ancho_pieza = $ancho_columna;
					$alto_pieza = $ancho_columna;
					$tabla_visual .='<div style="width: '. $ancho_pieza .'px; height: '.$alto_pieza.'px; position: absolute; left: '. $posicion_x .'px; top: '.$posicion_y . 'px;"></div>';
				} else {
					if ( $pieza == -1 ) {
						$posicion_x = ( $tax_meta['composicion_tipo_cambio'] == 0 && $matriz != 1 ) ? $x * $ancho_columna : ($x - 1) * $ancho_columna; // Varía en funcion de barra izquierda 'anterior'
						$posicion_y = ($y - 1) * $ancho_columna;
						$ancho_pieza = $ancho_columna;
						$alto_pieza = $ancho_columna;
						$tabla_visual .='<div style="width: '. $ancho_pieza .'px; height: '. $alto_pieza. 'px; position: absolute; left: '.$posicion_x . 'px; top: '.$posicion_y. 'px;"></div>';
					} else {
						if ( $stmpili_pila[$pieza]['visualizada'] != true ) {
							$tecnicos = getimagesize( str_replace( ' ', '\/', urldecode( $stmpili_pila[$pieza]['URL'] ) ) );
							$ancho = $tecnicos[0];
							$alto = $tecnicos[1];
							
							$posicion_x = ( $tax_meta['composicion_tipo_cambio'] == 0 && $matriz != 1 ) ? $x * $ancho_columna : ($x - 1) * $ancho_columna; // Varía en funcion de barra izquierda 'anterior'
							$posicion_y = ($y - 1) * $ancho_columna;
							$ancho_pieza = $ancho_columna * $stmpili_pila[$pieza]['ancho'];
							$alto_pieza = $ancho_columna * $stmpili_pila[$pieza]['alto'];
							
							if ( ( $ancho / $ancho_pieza ) > ( $alto / $alto_pieza ) ) {
								$proporcion_imagen = $ancho / $ancho_pieza;
								$desplazamiento_vertical = ($alto_pieza - ($alto / $proporcion_imagen)) / 2;
								$desplazamiento_horizontal = 0;
								$alto_pieza = $alto / $proporcion_imagen;
							} else {
								$proporcion_imagen = $alto / $alto_pieza;
								$desplazamiento_horizontal = ($ancho_pieza - ($ancho / $proporcion_imagen)) / 2;
								$desplazamiento_vertical = 0;
								$ancho_pieza = $ancho / $proporcion_imagen;
							}
							
							$ancho_marco = $ancho_pieza;
							$alto_marco = $alto_pieza;
							$ancho_imagen = $ancho_pieza;
							$alto_imagen = $alto_pieza;
							
							$separacion = $tax_meta['img_separacion'] * $proporcion;
							$ancho_marco = $ancho_marco - $separacion;
							$alto_marco = $alto_marco - $separacion;
							$ancho_imagen = $ancho_imagen - $separacion;
							$alto_imagen = $alto_imagen - $separacion;
							$desplazamiento_horizontal = $desplazamiento_horizontal + $separacion / 2;
							$desplazamiento_vertical = $desplazamiento_vertical + $separacion / 2;
							
							$margen = $tax_meta['img_margen_grosor'] * $proporcion;
							$borde = $tax_meta['img_borde_grosor'] * $proporcion;
							$ancho_imagen = $ancho_marco - 2 * $margen - 2 * $borde;
							$alto_imagen = $alto_marco - 2 * $margen - 2 * $borde;
							$top_imagen = $margen;
							$left_imagen = $margen;
							
							if ( $tax_meta['img_aumento'] == 'si' ) {
								$aumento = ( 100 + $tax_meta['img_cantidad_aumento'] ) / 100;
								$ancho_imagen = $ancho_imagen * $aumento;
								$alto_imagen = $alto_imagen * $aumento;
								$ancho_marco = $ancho_marco * $aumento;
								$alto_marco = $alto_marco * $aumento;
								$top_imagen = $top_imagen * $aumento;
								$left_imagen = $left_imagen * $aumento;
							}
							
							$ancho_interior = $ancho_total / $stmpili_columnas * $stmpili_pila[$pieza]['ancho'] - 10;
							$final_x = $posicion_x + $desplazamiento_horizontal;
							$final_y = $posicion_y + $desplazamiento_vertical;
							$tabla_visual .='<div class="imagen pieza-' . $pieza . '" style="width: ' . $ancho_marco . 'px; height: ' . $alto_marco . 'px; position: absolute; left: ' . $final_x . 'px; top: ' . $final_y . 'px;" onclick="stmpili_funcion_crear_lightbox(\''. str_replace( ' ', '\/', urldecode( $stmpili_pila[$pieza]['URL'] ) ) . '\',' . $ancho . ', ' . $alto . ', \'' . $stmpili_pila[$pieza]['Title'] . '\', \'' .  str_replace( ' ', '\/', urldecode( $stmpili_pila[$pieza]['Link'] ) ) . '\', \'' . plugin_dir_url( __FILE__ ) . 'cierre.gif\', \'' . $tax_meta['img_margen_color'] . '\', ' . $tax_meta['img_margen_grosor'] . ', ' . $tax_meta['img_margen_redondeo'] . ', \'' . $tax_meta['img_borde_color'] . '\', ' . $tax_meta['img_borde_grosor'] . ', ' . $tax_meta['img_borde_redondeo'] . ');">';
							$tabla_visual .='<img style="width: ' . $ancho_imagen . 'px; height: ' . $alto_imagen . 'px; position: relative; left: ' . $left_imagen . 'px; top: ' . $top_imagen . 'px;" src="' . str_replace( ' ', '\/', urldecode( $stmpili_pila[$pieza]['URL'] ) ) . '">';
							$tabla_visual .='</div>';
							$stmpili_pila[$pieza]['visualizada'] = true;
						}
					}
				}
				if ( $y == 1 && $x == $stmpili_columnas && $tax_meta['composicion_tipo_cambio'] == 0 && $matriz != $stmpili_matriz_actual ) {
					$siguiente = $matriz + 1;
					$posicion_x = ( $matriz == 1 ) ? $stmpili_columnas * $ancho_columna : ($stmpili_columnas +1) * $ancho_columna;
					$tabla_visual .= '<div style="width: '.$ancho_columna . 'px; height: '.$stmpili_filas * $ancho_columna.'px; position: absolute; top: 0; left: '. $posicion_x .'px;" class="cambio" onclick="document.getElementById(\'tabla-'. $siguiente .'\').style.display=\'block\';document.getElementById(\'tabla-'. $matriz .'\').style.display=\'none\';"><span class="icono icon-right-open" style="font-size: '.$ancho_columna.'px;position:relative;top:'.($stmpili_filas * $ancho_columna / 2).'px;"></span></div>';
				}
			}
		}
		if ( $tax_meta['composicion_tipo_cambio'] == 1 && $matriz < $stmpili_matriz_actual ) {
			$proxima = $matriz + 1;
			$tabla_visual .='<div id="transicion-'.$matriz.'" class="continuacion" style="width: '. $stmpili_columnas * $ancho_columna . 'px; height: ' . $ancho_columna . 'px; position: absolute; left: 0; top: '. $stmpili_filas * $ancho_columna.'px;" colspan="24" onclick="document.getElementById(\'tabla-'. $proxima .'\').style.display=\'inline-table\'; elemento = document.getElementById(\'transicion-'.$matriz.'\');document.getElementById(\'fondo\').style.height=\''.$alto_acumulado.'px\';elemento.parentNode.removeChild(elemento);"><span class="icono icon-down-open" style="font-size: '.$ancho_columna.'px;"></span></div>';
		}
		$tabla_visual .= '</div>';
	}
	
	return $tabla_visual;
	
}

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// 6. FUNCIONES AJAX                                                     //
//    6.6. Función stmpili_funcion_estilos_css                           //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

function stmpili_funcion_estilos_css( $composicion, $ancho ) {

	global $stmpili_pila, $stmpili_matriz_actual, $stmpili_columnas, $proporcion;
	
	$term = get_term_by( 'name', $composicion, 'stmpili_txn' );
	$id = $term->term_id;
	$tax_meta = get_option( "stmpili_taxonomy_$id" );

	$tax_meta['img_margen_color'] = ( !isset( $tax_meta['img_margen_color'] ) ) ? '#fff' : $tax_meta['img_margen_color'];
	$tax_meta['img_margen_grosor'] = ( !isset( $tax_meta['img_margen_grosor'] ) ) ? 0 : $tax_meta['img_margen_grosor'];
	$tax_meta['img_margen_redondeo'] = ( !isset( $tax_meta['img_margen_redondeo'] ) ) ? 0 : $tax_meta['img_margen_redondeo'];
	$tax_meta['img_borde_color'] = ( !isset( $tax_meta['img_borde_color'] ) ) ? '#000' : $tax_meta['img_borde_color'];
	$tax_meta['img_borde_grosor'] = ( !isset( $tax_meta['img_borde_grosor'] ) ) ? 0 : $tax_meta['img_borde_grosor'];
	$tax_meta['img_borde_redondeo'] = ( !isset( $tax_meta['img_borde_redondeo'] ) ) ? 0 : $tax_meta['img_borde_redondeo'];
	$tax_meta['img_sombra_color'] = ( !isset( $tax_meta['img_sombra_color'] ) ) ? '#000' : $tax_meta['img_sombra_color'];
	$tax_meta['img_sombra_grosor'] = ( !isset( $tax_meta['img_sombra_grosor'] ) ) ? 0 : $tax_meta['img_sombra_grosor'];
	$tax_meta['img_aumento'] = ( !isset( $tax_meta['img_aumento'] ) ) ? 'no' : $tax_meta['img_aumento'];
	$tax_meta['img_cantidad_aumento'] = ( !isset( $tax_meta['img_cantidad_aumento'] ) ) ? 0 : $tax_meta['img_cantidad_aumento'];
	$tax_meta['img_girado'] = ( !isset( $tax_meta['img_girado'] ) ) ? 'no' : $tax_meta['img_girado'];
	$tax_meta['composicion_tipo_cambio'] = ( !isset( $tax_meta['composicion_tipo_cambio'] ) ) ? 0 : $tax_meta['composicion_tipo_cambio'];
	$tax_meta['taxonomia_mostrar_sidebar'] = ( !isset( $tax_meta['taxonomia_mostrar_sidebar'] ) ) ? 'si' : $tax_meta['taxonomia_mostrar_sidebar'];
	$tax_meta['taxonomia_mostrar_footer'] = ( !isset( $tax_meta['taxonomia_mostrar_footer'] ) ) ? 'si' : $tax_meta['taxonomia_mostrar_footer'];
	$tax_meta['taxonomia_mostrar_titulo'] = ( !isset( $tax_meta['taxonomia_mostrar_titulo'] ) ) ? 'no' : $tax_meta['taxonomia_mostrar_titulo'];
	$tax_meta['taxonomia_mostrar_descripcion'] = ( !isset( $tax_meta['taxonomia_mostrar_descripcion'] ) ) ? 'no' : $tax_meta['taxonomia_mostrar_descripcion'];

	$estilo = '<style>';
	
	$estilo .='.matriz {border: none; width: ' . $ancho . 'px; height: ' . $ancho * $stmpili_filas . 'px; margin: 0px}';
	$celda = ( $tax_meta['composicion_tipo_cambio'] == 0 ) ? $ancho / ( $stmpili_columnas + 2 ) : $ancho / $stmpili_columnas;
	$estilo .='.matriz tr{ height:' . $celda . 'px; vertical-align: middle;}';
	$estilo .='.matriz th, .matriz td{border: none; padding: 5px; vertical-align: inherit;}';
	
	for ( $matriz=2; $matriz < $stmpili_matriz_actual + 1; $matriz++ ) {
		$estilo .='#tabla-' . $matriz . ' { display: none;';
		if ( $tax_meta['composicion_tipo_cambio'] == 1 ) {
			$subir = $celda * ( $matriz - 1 );
			$estilo .='top: -'. $subir . 'px;';
		}
		$estilo .='}';
	}
	
	$estilo .='.imagen {
		background: ' . $tax_meta['img_margen_color'] . '; 
		border: ' . $tax_meta['img_borde_color'] . ' solid ' . $tax_meta['img_borde_grosor'] * $proporcion . 'px;
		border-radius: ' . $tax_meta['img_borde_redondeo'] * $proporcion . 'px;';
		if ( $tax_meta['img_sombra_grosor'] != 0 ) {
		$estilo .='-webkit-box-shadow: ' . $tax_meta['img_sombra_grosor'] . 'px ' . $tax_meta['img_sombra_grosor'] . 'px 20px 0px '. $tax_meta['img_sombra_color'] . ';
		-moz-box-shadow: ' . $tax_meta['img_sombra_grosor'] . 'px ' . $tax_meta['img_sombra_grosor'] . 'px 20px 0px '. $tax_meta['img_sombra_color'] . ';
		box-shadow: ' . $tax_meta['img_sombra_grosor'] . 'px ' . $tax_meta['img_sombra_grosor'] . 'px 20px 0px '. $tax_meta['img_sombra_color'] . ';';
		}
		if ( $tax_meta['img_aumento'] == 'si' ) {
			$total = 100 + $tax_meta['img_cantidad_aumento'];
			$estilo .='width: ' . $total . '%;';
		}
		
	$estilo .= '}';
		
	$estilo .='.imagen img {';
		$estilo .='border-radius: ' . $tax_meta['img_margen_redondeo'] . 'px;';
	$estilo .='}';
	
	if ( $tax_meta['img_girado'] == 'si' ) {
		for ( $contador = 1; $contador <= count( $stmpili_pila ); $contador++ ) {
			$giro = mt_rand( -5, 5 );
			$estilo .= '.pieza-' . $contador . ' {-webkit-transform: rotate(' . $giro . 'deg); -moz-transform: rotate(' . $giro . 'deg);}';
		}
	}

	$estilo .='.cambio, .continuacion {
		background: ' . $tax_meta['img_margen_color'] . '; 
		border: ' . $tax_meta['img_borde_color'] . ' solid ' . $tax_meta['img_borde_grosor'] . 'px;
		border-radius: ' . $tax_meta['img_borde_redondeo'] . 'px;';
		if ( $tax_meta['img_sombra_grosor'] != 0 ) {
		$estilo .='-webkit-box-shadow: ' . $tax_meta['img_sombra_grosor'] . 'px ' . $tax_meta['img_sombra_grosor'] . 'px 20px 0px '. $tax_meta['img_sombra_color'] . ';
		-moz-box-shadow: ' . $tax_meta['img_sombra_grosor'] . 'px ' . $tax_meta['img_sombra_grosor'] . 'px 20px 0px '. $tax_meta['img_sombra_color'] . ';
		box-shadow: ' . $tax_meta['img_sombra_grosor'] . 'px ' . $tax_meta['img_sombra_grosor'] . 'px 20px 0px '. $tax_meta['img_sombra_color'] . ';';
		}
	$estilo .='}';
	
	$estilo .='.cambio {
		width: ' . $celda . 'px;		
		cursor: pointer;}';
		
	$estilo .='.continuacion {text-align: center; cursor: pointer;}';
	
	$tamanyo = $proporcion * $celda;
	$estilo .='.icon-cancel-circled { font-size: '.$tamanyo.'px; }';
	switch ( $proporcion ) {
		case 0.8:
			$estilo .= '.titulo-enlace { font-size: medium; }';
			break;
		case 0.6:
			$estilo .= '.titulo-enlace { font-size: small; }';
			break;
		case 0.4:
			$estilo .= '.titulo-enlace { font-size: xx-small; }';
			break;
	}
	
	$estilo .='</style>';
	
	return $estilo;
	
}

////////////////////////////////////////////////////
//                                                //
// 7. VINCULACIONES JAVASCRIPT Y ESTILOS          //
//                                                //
////////////////////////////////////////////////////

function stmpili_funcion_enqueue2_scripts () {

	wp_enqueue_style ( 'espera', plugin_dir_url( __FILE__ ) . '/css/espera.css', false );
	wp_enqueue_style ( 'lightbox', plugin_dir_url( __FILE__ ) . '/css/lightbox.css', false );
	wp_enqueue_style ( 'iconos', plugin_dir_url( __FILE__ ) . '/css/iconos.css', false );

	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js', false );
	wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . '/js/espera.js', false );
	wp_enqueue_script( 'lightbox', plugin_dir_url( __FILE__ ) . '/js/lightbox.js', false );
}
	
add_action( 'wp_enqueue_scripts', 'stmpili_funcion_enqueue2_scripts' );

////////////////////////////////////////////////////////////////////////////////////
//                                                                                //
// 8, AÑADIR TAXONOMIAS A LOS MENUS                                               //
//                                                                                //
////////////////////////////////////////////////////////////////////////////////////

 function add_menu_atributos_box() {
    $screen = get_current_screen();
    if ($screen->base == 'nav-menus') {
      $taxs = array('stmpili_txn'=>'Composiciones');
      foreach($taxs as $t=>$titulo) {
        $tax = get_taxonomy($t);
          add_meta_box( "add-$t", $titulo, 'wp_nav_menu_item_taxonomy_meta_box', 'nav-menus', 'side', 'default', $tax );
      }
    }
  }
  add_action('admin_head', 'add_menu_atributos_box');
  
  
function stmpili_funcion_pieza_libre_ancho_mayor( ) {
	
	global $stmpili_pila;

	$alto_pila = count( $stmpili_pila );
	$pieza = 0;
	$area_mayor = 0;
	
	for ( $contador = 1; $contador < $alto_pila + 1; $contador++ ) {
		if ( $stmpili_pila[$contador]['colocada'] == false && $stmpili_pila[$contador]['ancho']*$stmpili_pila[$contador]['alto'] > $area_mayor ) {
			
			$pieza = $contador;
			$area_mayor = $stmpili_pila[$contador]['ancho']*$stmpili_pila[$contador]['alto'];
			
		}
	}
	
	if ( $pieza != 0 ) {
		return $pieza;
	} else {
		return false;
	}
	
}
