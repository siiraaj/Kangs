function stmpili_funcion_crear_lightbox( fichero, ancho, alto, titulo, enlace, cierre, margenColor, margenGrosor, margenRedondeo, bordeColor, bordeGrosor, bordeRedondeo ) {
	
	// Primero, las medidas de la pantalla
	anchoTotal = window.innerWidth;
	altoTotal = window.innerHeight;
	
	console.log('Totales: ' + anchoTotal + ' x ' + altoTotal + '. Imagen: ' + ancho + ' x ' + alto + '.');
	
	// Ajustamos la medida horizontal y vertical
	if ( ancho > anchoTotal * 0.8 ) {
		proporcion = ( anchoTotal * 0.8 ) / ancho;
		ancho = ancho * proporcion;
		alto = alto * proporcion;
	}
	
	// Ajustamos la medida vertical y horizontal
	if ( alto > altoTotal * 0.8 ) {
		proporcion = ( altoTotal * 0.8 ) / alto;
		alto = alto * proporcion;
		ancho = ancho * proporcion;
	}
	
	// Una vez hemos ajustado las medidas de la imagen, buscamos la posición
	arriba = ( altoTotal - alto ) / 2;
	izquierda = ( anchoTotal - ancho ) / 2;
	
	// Seleccionamos el elemento sobre el que vamos a trabajar
	var capa = document.getElementById('light');
	
	// Establecemos los estilos que le vamos a dar
	capa.style.width = ancho + "px";
	capa.style.height = alto + "px";
	capa.style.top = arriba + "px";
	capa.style.left = izquierda + "px";
	capa.style.backgroundImage = "url(" + fichero + ")";
	capa.style.backgroundSize = ( ancho - margenGrosor * 3 ) + "px " + ( alto - margenGrosor * 3) + "px";
	capa.style.backgroundPosition = "center center";
	capa.style.backgroundRepeat = "no-repeat";
	capa.style.backgroundColor = margenColor;
	capa.style.padding = margenGrosor + "px";
	capa.style.border = bordeGrosor + "px solid " + bordeColor;
	capa.style.borderRadius = bordeRedondeo + "px";
	
	// Generamos el código que vamos a introducir en el elemento
	texto = '<a href="javascript:void(0)" onclick="document.getElementById(\'light\').style.display = \'none\';' + 
			' document.getElementById(\'fade\').style.display = \'none\';"><span class="icon-cancel-circled"></span></a>' +
			'<div class="titulo-enlace">';
			if ( enlace != '' ) {
				texto = texto + '<a href="' + enlace + '">' + titulo + '</a></div>';
			} else {
				texto = texto + titulo + '</div>';
			}
			
	capa.innerHTML = texto;
	
	// Visualizamos las dos capas
	document.getElementById('fade').style.display="block";
	capa.style.display="block";

}