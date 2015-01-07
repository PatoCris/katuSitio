/*VARS*/
var ajax = new Ajax, registros_ar = new Array(), action = 'insCliente', id = 0;
/*END VARS*/
ajax.setUrl('php/servicios/servicio.php');
/*DOCUMENT READY*/
$(document).ready(function(){
	traerServicios( 1 );
});
/*END DOCUMENT READY*/
function getRegistros( _p_actual ){
	traerServicios( _p_actual );
}
function traerServicios( _p_actual ){
	p_actual = _p_actual;
	ajax.go( 
		({
			function_response:crearLista,
			params: ({accion:'traerServicios',
					  p_actual:p_actual
					  
					})
		})
	);
}
function crearLista( data ){
	datos_ar = eval( '(' + data + ')' );
	var bg_row = '';
	var html_listado = '';
	for(var i = 0; i<registros_ar.length; i++){
		if( i%2 == 0 ) bg_row='bgcolor="#dddddd"' ; else bg_row = '';
		html_listado += 	'<tr class="remove" '+bg_row+'>'+
					'<td align="left">'+registros_ar[i]['nombre']+'</td>'+
					'<td align="center">'+registros_ar[i]['fecha']+'</td>'+
					'<td align="left">'+registros_ar[i]['usuario']+'</td>'+
					'<td align="left">'+registros_ar[i]['contenido']+'</td>'+
					'<td align="left">'+
						'<button onclick="editarCliente(\''+registros_ar[i]['codigo']+'\')" class="button pencil">Editar</button>'+
						'<button onclick="delCliente(\''+registros_ar[i]['codigo']+'\')" class="button trash">Eliminar</button>'
					'</td>'+
				'</tr>';
	}
	cargarlista('tblServicios', html_listado);
}




