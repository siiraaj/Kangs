jQuery(document).ready(function($) {
	$(".composicion").ready(function() {
		var this2=this;
		$.post( mi_objeto_ajax.ajax_url, {
			_ajax_nonce: mi_objeto_ajax.nonce,
			action: "devuelve_composicion",
			ancho: $(".composicion").width(),
			alto: $(window).height(),
			termino: $(".nombre").html(),
			indice: 0
			}, function(data) {
				$(".composicion").html(data);
		});
	});
});

function appendSueltos(valor) {
	var this2=this;
	jQuery.post( mi_objeto_ajax.ajax_url, {
		_ajax_nonce: mi_objeto_ajax.nonce,
		action: "incorporar_articulo",
		truco: jQuery(".truco").html(),
		nuevo: valor
	}, function(data) {
		jQuery(".cuadro-admin").html(data);
	});
}

function todas() {
	var this2=this;
	jQuery.post( mi_objeto_ajax.ajax_url, {
		_ajax_nonce: mi_objeto_ajax.nonce,
		action: "incorporar_todas",
		truco: jQuery(".truco").html(),
		// nuevo: valor
	}, function(data) {
		jQuery(".cuadro-admin").html(data);
	});
}

function appendEtiquetas(valor) {
	var this2=this;
	jQuery.post( mi_objeto_ajax.ajax_url, {
		_ajax_nonce: mi_objeto_ajax.nonce,
		action: "incorporar_etiqueta",
		truco: jQuery(".truco").html(),
		nuevo: valor
	}, function(data) {
		jQuery(".cuadro-admin").html(data);
	});
}

function elimina(valor) {
	var this2=this;
	jQuery.post( mi_objeto_ajax.ajax_url, {
		_ajax_nonce: mi_objeto_ajax.nonce,
		action: "eliminar_articulo",
		truco: jQuery(".truco").html(),
		articulo: valor,
		}, function(data) {
			jQuery(".cuadro-admin").html(data);
	});
}

function destaca(valor) {
	var this2=this;
	jQuery.post( mi_objeto_ajax.ajax_url, {
		_ajax_nonce: mi_objeto_ajax.nonce,
		action: "destacar_articulo",
		truco: jQuery(".truco").html(),
		articulo: valor,
		}, function(data) {
			jQuery(".cuadro-admin").html(data);
	});
}

jQuery(document).ready(function($) {
	$(".cuadro-admin").ready(function() {
		var this2=this;
		$.post( mi_objeto_ajax.ajax_url, {
			_ajax_nonce: mi_objeto_ajax.nonce,
			action: "mostrar_pila",
			truco: $(".truco").html(),
			}, 
			function(data) {
				$(".cuadro-admin").html(data);
		});
	});
});
