$(document).ready(function() {
	spinnerTablas();
});
$.ajaxSetup({
	global : false
});

function ajaxRequest( params ) {
	var urlNominas = urlRecuperacionNominas;
	$.get(urlNominas + '?' + $.param(params.data)).then(function( res ) {
		params.success(res)
	})
}

function queryParams( params ) {
	var paginas = params.pageNumber;
	var tamanios = params.pageSize;
	var search = params.searchText;
	var params = new Object();
	params.page = paginas;
	params.per_page = tamanios;
	params.search = search;
	return params;
	
}

var tableCatalogos = $('#tablaCatalogosRecuperacionNomina').bootstrapTable({
	pagination : true,
	sidePagination : 'server',
	pageNumber : 1,
	pageSize : 5,
	pageList : [ 5, 10, 15 ],
	queryParamsType : '..',
	icons : {
		detailOpen : 'material-icons',
		detailClose : 'material-icons'
	}

	,
	iconsPrefix : ''

});

function eliminarBoton( value, row ) {
	return [ '<a class="btn btn btn-info btn-sm text-center align-middle my-2 mx-2" href="', row.rutas, '"><i class="material-icons"> cloud_download  </i>  </a>' ].join('');
}

window.operateEvents = {
	'click .editar' : function( e, value, row, index ) {
		
		inicializarModalDatos();
		editar(row);
		ocultarBotones();
	},
	'click .remove' : function( e, value, row, index ) {
		modal.mostrarModal();
		$(".modal-body").addClass("colorLetModal");
		inicializarModalEliminarUsuarios();
		eliminarUsuarios(row);
	}
}
//$('#tablaCatalogosRecuperacionNomina').on('pre-body.bs.table', function( e, arg1, arg2 ) {
//	// ...
//	// var spinner = '<div class="spinner-border" role="status">'
//	// '<span class="sr-only">Loading...</span>'
//	// '</div>';
//	// // tableCatalogos.bootstrapTable('append', spinner)
//	// $('.loading-wrap').empty();
//	// $('.loading-wrap').append(spinner);
//	var spinner = '<tr>' + '<td>' + '<div class="spinner-border" role="status">' + '<span class="sr-only">Loading...</span>' + '</div>' + '</td>' + '</tr>' + '</div>';
//	// tableCatalogos.bootstrapTable('append', spinner)
//	// $('#tablaRevisionFolios thead').empty();
//	$('#tablaRevisionFolios').append(spinner);
//})


function spinnerTablas(){
	var spinner = '<div class="spinner-border" role="status">'
		'<span class="sr-only">Loading...</span>'
		'</div>';
		// tableCatalogos.bootstrapTable('append', spinner)
		$('.loading-wrap').empty();
		$('.loading-wrap').append(spinner);
}