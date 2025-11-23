@extends('layouts.pdf')

@section("titulo")
    {{-- <h4> COMPROBANTE DE SERVICIOS </h4> --}}
@endsection

@section("contenido")
<div style="font-family: Sans-serif;">
    <div class="mtn-80">
        <h4 class="">REGISTRO DE SERVICIO SOCIAL</h4>
    </div>
    <br>

    <table width="100%">
        <thead class="font-size-13 text-center">
            <tr>
                <td class="py-1" bgcolor="#E6E6E6" colspan="4"><b>DATOS PERSONALES</b></td>
            </tr>
        </thead>
        <tbody class="font-size-12">
            <tr class="py-2">
                <td width="25%"><b>Nombre:</b></td>
                <td width="25%"><b>Teléfono:</b></td>
                <td width="25%"><b>Correo:</b></td>
                <td width="25%"><b>Matrícula:</b></td>
            </tr>
            <tr>
                <td>{{ $servicioSocial->prestador->nombre_prestador_completo }}</td>
                <td>{{ $servicioSocial->prestador->telefono }}</td>
                <td>{{ $servicioSocial->prestador->email }}</td>
                <td>{{ $servicioSocial->prestador->matricula }}</td>
            </tr>
            <tr>
                <td colspan="4"><b>Institución:</b></td>
            </tr>
            <tr>
                <td colspan="4">{{ $servicioSocial->prestador->escuela->institucion->nombre_institucion }}</td>
            </tr>

            <tr>
                <td colspan="3"><b>Escuela:</b></td>
                <td><b>Acronimo:</b></td>
            </tr>
            <tr>
                <td colspan="3">{{ $servicioSocial->prestador->escuela->nombre_escuela }}</td>
                <td>{{ $servicioSocial->prestador->escuela->acronimo_escuela }}</td>
            </tr>
            <tr>
                <td colspan="2"><b>Programa:</b></td>
                <td colspan="2"><b>Carrera:</b></td>
            </tr>
            <tr>
                <td>{{ $servicioSocial->prestador->programa->nombre_programa }}</td>
                <td>{{ $servicioSocial->prestador->carrera }}</td>
            </tr>
            <tr>
                <td colspan="4"><b>Domicilio:</b></td>
            </tr>
            <tr>
                <td colspan="4">
                    C. {{ $servicioSocial->prestador->calle }}, 
                    Nº EXT. {{ $servicioSocial->prestador->numero_exterior }}, 
                    COL. {{ $servicioSocial->prestador->colonia }},
                    {{ $servicioSocial->prestador->municipio->nombre }}, 
                    {{ $servicioSocial->prestador->municipio->entidad->nombre ?? '' }}, 
                    C.P. {{ $servicioSocial->prestador->cp }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <thead class="font-size-13 text-center">
            <tr>
                <td class="py-1" bgcolor="#E6E6E6" colspan="4"><b>DATOS DE ADSCRIPCIÓN</b></td>
            </tr>
        </thead>
        <tbody class="font-size-12">
            <tr class="py-2">
                <td width="50%" colspan="2"><b>Área de adscripción:</b></td>
                <td width="50%" colspan="2"><b>Subdirección:</b></td>
            </tr>
            <tr>
                <td colspan="2">{{ $servicioSocial->areaAdscripcion->nombre_area_adscripcion }}</td>
                <td colspan="2">{{ $servicioSocial->subdireccion_ua }}</td>
            </tr>
            <tr>
                <td colspan="2"><b>Unidad Departamental:</b></td>
                <td colspan="2"><b>Domicilio de adscripción:</b></td>
            </tr>
            <tr>
                <td colspan="2">{{ $servicioSocial->unidad_departamental_ua }}</td>
                <td colspan="2">{{ $servicioSocial->areaAdscripcion->direccion_area_adscripcion }}</td>
            </tr>

            <tr>
                <td><b>Jefe Inmediato:</b></td>
                <td colspan="2"><b>Puesto:</b></td>
                <td><b>Télefono:</b></td>
            </tr>
            <tr>
                <td>{{ $servicioSocial->jefe }}</td>
                <td colspan="2">{{ $servicioSocial->puesto_jefe }}</td>
                <td>{{ $servicioSocial->telefono_jefe }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <thead class="font-size-13 text-center">
            <tr>
                <td class="py-1" bgcolor="#E6E6E6" colspan="4"><b>DATOS DE PRESTACIÓN</b></td>
            </tr>
        </thead>
        <tbody class="font-size-12">
            <tr>
                <td width="25%"><b>Inicio de Servicio:</b></td>
                <td width="25%"><b>Fin de Servicio:</b></td>
                <td width="25%"><b>Horario:</b></td>
                <td width="25%"><b>Total de Horas:</b></td>
            </tr>
            <tr>
                <td>{{ $servicioSocial->fecha_inicio }}</td>
                <td>{{ $servicioSocial->fecha_fin }}</td>
                <td>{{ $servicioSocial->horario }}</td>
                <td>{{ $servicioSocial->prestador->total_horas }}</td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td colspan="4"><b>Actividades a Realizar:</b></td>
            </tr>
            <tr>
                <td colspan="4">{{ $servicioSocial->actividades }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%">
        <thead class="font-size-13 text-center">
            <tr>
                <td class="py-1" bgcolor="#E6E6E6" colspan="4"><b>REQUISITOS</b> "ORIGINAL Y COPIA DE LOS DOCUMENTOS"</td>
            </tr>
        </thead>
        <tbody class="font-size-12">
            <tr>
                <ul>
                    <li>Carta de presentación de la escuela</li>
                    <li>Constancia de créditos (70% mínimo)</li>
                    <li>Credencial de la escuela</li>
                    <li>Una fotografía tamaño infantil</li>
                    <li>Copia de INE (mayores de 18 años)</li>
                </ul>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="px-5">
        <h5>LEYENDA</h5>
        <div class="text-justify font-size-12">
            “Los datos personales recabados serán protegidos, incorporados y tratados en el Sistema de Datos Personales, Sistema de
            Administración de Prestadores de Servicio Social y/o Prácticas Profesionales en la Secretaría deAdministración  y  Finanzas.
            El  cual  tiene  su  fundamento  en  el  numeral  2.4  de  la  Circular  Uno  2012  Normatividad  en  Materia  de  Administración
            de  Recursos  para  las  Dependencias,  Unidades  Administrativas,  UnidadesAdministrativas de Apoyo Técnico Operativo, Órganos
            Desconcentrados y Entidades de la Administración Pública dla Ciudad de México, cuya finalidad es Administrar los prestadores de
            servicio social y/o prácticas profesionalesy los recursos financieros destinados a los gastos para el apoyo económico, conforme a
            las políticas, lineamientos, criterios y normas determinadas por la Oficialía Mayor y la Secretaría de Administración y Finanzas,
            así como laintegración de los expedientes personales y podrán ser transmitidos a las instituciones educativas públicas y privadas,
            para la notificación de prestación de servicio social y/o prácticas profesionales, además de otras transmisionesprevistas en la
            Ley de Protección de Datos Personales para la Ciudad de México.
            <br>Los datos marcados con un asterisco (*) son obligatorios y sin ellos no podrán acceder al servicio o completar el trámite de
            Prestación de Servicio Social y/o Practicas Profesionales, así mismo, se le informa que sus datos nopodrán ser difundidos sin su
            consentimiento expreso, salvo las excepciones previstas en la Ley. 
            <br>El responsable del Sistema de Datos Personales es Marcos Manuel Herrería Alamina, Director General de Administración en la
            Secretaría de Administración y Finanzas y la dirección donde podrá ejercer los derechos de acceso,rectificación, cancelación y
            oposición, así como la revocación del consentimiento es Plaza de la Constitución No. 1, Planta Baja, Col, Centro, Delegación
            Cuauhtémoc, C.P. 06080, Ciudad de México.
            <br>El interesado podrá dirigirse al Instituto de Acceso a la Información Pública dla Ciudad de México, donde recibirá asesoría
            sobre los derechos que tutela la Ley de Protección de Datos Personales para la Ciudad de México alteléfono: 5636-4636;
            correo electrónico: datos.personales@infodf.org.mx o www.infodf.org.mx”
        </div>

        <table class="mt-30" width="100%">
            <tr class="font-size-12 text-center">
                <td width="10%"></td>
                <td>
                    <div class="separator separator-solid separator-dark"></div>
                    <b>JEFE INMEDIATO</b> <br>
                    {{ $servicioSocial->jefe }} <br>
                    {{ $servicioSocial->puesto_jefe }}
                </td>
                <td width="10%"></td>
                <td>
                    <div class="separator separator-solid separator-dark"></div>
                    <b>PRESTADOR DE SERVICIO SOCIAL</b> <br>
                    {{ $servicioSocial->nombre_prestador_completo }} <br>
                    Firma de conformidad (*)
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    </div>
</div>
@endsection