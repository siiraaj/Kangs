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