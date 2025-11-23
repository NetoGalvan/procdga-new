<table>
	<tr>
		<td height="30" colspan="6" class="font-size-16"><b> NÓMINA {{mb_strtoupper($nomina->tipo_validacion)}} </b></td>
	</tr>
	<tr>
		<td height="21"><b> FOLIO: </b></td>
		<td> {{$nomina->folio ?? 'S/D'}} </td>
	</tr>
	<tr>
		<td height="21"><b> DESCRIPCIÓN: </b></td>
		<td colspan="2"> {{$nomina->descripcion ?? 'S/D'}} </td>
	</tr>
	<tr>
		<td height="45"><b> OBSERVACIONES: </b></td>
		<td colspan="5"> {{$nomina->observaciones ?? 'S/D'}} </td>
	</tr>
</table>
<table>
	<tr>
		<td width="21" rowspan="2"> <b> FOLIO DE SERVICIO SOCIAL </b> </td>
		<td width="40" rowspan="2"> <b> NOMBRE DEL PRESTADOR </b> </td>
		<td width="50" rowspan="2"> <b> NOMBRE DE LA ESCUELA </b> </td>
		<td width="50" rowspan="2"> <b> CARRERA </b> </td>
		<td colspan="2"> <b> PROGRAMA </b> </td>
        <td width="18" rowspan="2"> <b> TIPO DE PRESTADOR </b> </td>
        <td width="35" rowspan="2"> <b> UNIDAD ADMINISTRATIVA </b> </td>
        <td width="16" rowspan="2"> <b> ESTATUS DE SERVICIO </b> </td>
        <td width="80" rowspan="2"> <b> ACTIVIDADES </b> </td>
        <td colspan="6"> <b> FECHAS </b> </td>
        <td width="16" rowspan="2"> <b> TIPO DE PAGO </b> </td>
        <td width="10" rowspan="2"> <b> MESES A PAGAR </b> </td>
        <td width="16" rowspan="2"> <b> ESTATUS DE PAGO </b> </td>
        <td width="16" rowspan="2"> <b> TOTAL PAGADO </b> </td>
        <td width="16" rowspan="2"> <b> FECHA DE CIERRE </b> </td>
	</tr>
	<tr>
		<td width="20"> <b> CLAVE </b> </td>
		<td width="45"> <b> NOMBRE </b> </td>
		<td width="16"> <b> INICIO DE SERVICIO </b> </td>
        <td width="16"> <b> FIN DE SERVICIO </b> </td>
        <td width="16"> <b> CARTA DE INICIO </b> </td>
        <td width="16"> <b> CARTA FIN </b> </td>
        <td width="16"> <b> PAGO PARCIAL </b> </td>
        <td width="16"> <b> PAGO </b> </td>
	</tr>
	@foreach($nomina_detalle as $detalle)
	<tr>
		<td> {{$detalle->servicioSocial->folio ?? 'S/D'}} </td>
		<td> {{$detalle->servicioSocial->nombre_prestador_completo ?? 'S/D'}} </td>
		<td>
			{{
			( isset($detalle->servicioSocial->nombre_escuela) ) ? $detalle->servicioSocial->nombre_escuela : ($detalle->servicioSocial->prestador->escuela->nombre_escuela ?? 'S/D')
			}}
		</td>
		<td>
			{{
			( isset($detalle->servicioSocial->carrera) ) ? $detalle->servicioSocial->carrera : ($detalle->servicioSocial->prestador->carrera ?? 'S/D')
			}}
		</td>
		<td> {{$detalle->servicioSocial->clave_programa ?? 'S/D'}} </td>
		<td> {{$detalle->servicioSocial->nombre_programa ?? 'S/D'}} </td>
		<td>
			{{
			( isset($detalle->servicioSocial->tipo_prestador) ) ? $detalle->servicioSocial->tipo_prestador : ($detalle->servicioSocial->prestador->tipo_prestador ?? 'S/D')
			}}
		</td>
		<td> {{$detalle->servicioSocial->nombre_unidad_administrativa ?? 'S/D'}} </td>
		<td> {{$detalle->servicioSocial->estatus ?? 'S/D'}} </td>
		<td> {{$detalle->servicioSocial->actividades ?? 'S/D'}} </td>
		<td>
			{{
			(isset($detalle->servicioSocial->fecha_inicio)) ? date_format(\Carbon\Carbon::parse($detalle->servicioSocial->fecha_inicio), 'd/m/Y') : 'S/D'
			}}
		</td>
		<td>
			{{
			(isset($detalle->servicioSocial->fecha_fin)) ? date_format(\Carbon\Carbon::parse($detalle->servicioSocial->fecha_fin), 'd/m/Y') : 'S/D'
			}}
		</td>
		<td>
			{{
			(isset($detalle->servicioSocial->fecha_carta_inicio)) ? date_format(\Carbon\Carbon::parse($detalle->servicioSocial->fecha_carta_inicio), 'd/m/Y') : 'S/D'
			}}
		</td>
		<td>
			{{
			(isset($detalle->servicioSocial->fecha_carta_fin)) ? date_format(\Carbon\Carbon::parse($detalle->servicioSocial->fecha_carta_fin), 'd/m/Y') : 'S/D'
			}}
		</td>
		<td>
			{{
			(isset($detalle->servicioSocial->fecha_pago_parcial)) ? date_format(\Carbon\Carbon::parse($detalle->servicioSocial->fecha_pago_parcial), 'd/m/Y') : 'S/D'
			}}
		</td>
		<td>
			{{
			(isset($detalle->servicioSocial->fecha_pago)) ? date_format(\Carbon\Carbon::parse($detalle->servicioSocial->fecha_pago), 'd/m/Y') : 'S/D'
			}}
		</td>
		<td> {{$detalle->tipo_pago ?? 'S/D'}} </td>
		<td> {{$detalle->meses_pagar ?? 'S/D'}} </td>
		<td>
			{{
			(isset($detalle->servicioSocial->payment_status)) ?	$detalle->servicioSocial->payment_status : ($detalle->servicioSocial->payment_estatus ?? 'S/D')
			}}
		</td>
		<td> {{$detalle->total_pagado ?? 'S/D'}} </td>
		<td>
			{{
			(isset($detalle->fecha_cerrado)) ? date_format(\Carbon\Carbon::parse($detalle->fecha_cerrado), 'd/m/Y') : 'S/D'
			}}
		</td>
	</tr>
	@endforeach
</table>
