<? if (0==1) { ?> <script type="text/javascript"> <? } else { ?>


function buscar_descarga_cli(event)
{
var cod_cliente=document.getElementById('cod_cliente').value;

if (cod_cliente=='')
{
alert('Introduzca primero un código de cliente.');
document.getElementById('cod_descarga').value='';
}

else
{
var cod_descarga=document.getElementById('cod_descarga').value;
var dire=direccion_conta('');
var senyal="";

if (dire.substr(-16)=="11_descargas.php")
	senyal="refrescar_sin_borrar";
else if (dire.substr(-17)=="1_1_albaranes.php" || dire.substr(-21)=="1_1_albaranes_rap.php")
	senyal="descarga_alb";


buscar_conta(event,'descargas',cod_descarga,'cod_descarga',cod_descarga,'cod_cliente',cod_cliente,'','','','','','','','',senyal);
}
} // Fin de funtion



//--------------------------------------------------------------------------------------------
//                                ACCIONES CARGAR ALBARÁN
//--------------------------------------------------------------------------------------------
function tt_enviar_alb_js(event,validado,estado,pag_imp,pag_fac)
{
if (validado)
{
var cod_albaran = document.getElementById('cod_albaran').value;
var cod_empresa = document.getElementById('cod_empresa').value;
var fac_fecha = document.getElementById('fecha_carga').value;

var icono=event.target.id;
//alert("event.target.id: '" + event.target.id + "'");
var accion="";

// Creamos una cadena con la acción a realizar según lo elegido:
if (icono=="facturar")
{
accion=String(mostrar(event,'/<? echo $carpeta_js; ?>/3_administracion/5_gestion_facturacion/'+pag_fac,'cod_albaran',cod_albaran,'cod_empresa',cod_empresa,'fac_fecha',fac_fecha,'direccion',direccion_conta(''),'','','','','','','','','','','',''));
}

else if (icono=="imprimir")
{
accion=String(mostrar(event,'1_2_impr_alb.php','cod_albaran',cod_albaran,'cod_empresa',cod_empresa,'','','','','','','','','','','','','','','',''));
}

// Si no está facturado, creamos un elemento de formulario con la acción a realizar y enviamos:
if (estado!="f")
{
var accion_alb=document.createElement("input");
accion_alb.type="hidden"; accion_alb.name="accion_alb"; accion_alb.id="accion_alb";
document.forms[0].appendChild(accion_alb);
accion_alb.value=accion;

//alert(accion);

document.forms[0].submit();
}

// Si está facturado y se ha elegido imprimir, imprimimos; si no, avisamos:
else
{
	if (icono=="imprimir")
		eval(accion);
	else
		alert("Este documento está facturado y no puede ser modificado.");
}
} // Fin de if (validado)
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                ACCIONES CARGAR ALBARÁN
//--------------------------------------------------------------------------------------------
function sg_enviar_alb_js(event,validado,estado,pag_imp,pag_fac)
{
if (validado)
{
var cod_servicio = document.getElementById('cod_servicio').value;
var cod_empresa = document.getElementById('cod_empresa').value;
var fac_fecha = document.getElementById('fecha').value;

var icono=event.target.id;
//alert("event.target.id: '" + event.target.id + "'");
var accion="";

// Creamos una cadena con la acción a realizar según lo elegido:
if (icono=="facturar")
{
accion=String(mostrar(event,'/<? echo $carpeta_js; ?>/3_administracion/5_gestion_facturacion/'+pag_fac,'cod_servicio',cod_servicio,'cod_empresa',cod_empresa,'fac_fecha',fac_fecha,'direccion',direccion_conta(''),'','','','','','','','','','','',''));
}

else if (icono=="imprimir")
{
accion=String(mostrar(event,'1_2_impr_alb.php','cod_albaran',cod_servicio,'cod_empresa',cod_servicio,'','','','','','','','','','','','','','','',''));
}

// Si no está facturado, creamos un elemento de formulario con la acción a realizar y enviamos:
if (estado!="f")
{
var accion_alb=document.createElement("input");
accion_alb.type="hidden"; accion_alb.name="accion_alb"; accion_alb.id="accion_alb";
document.forms[0].appendChild(accion_alb);
accion_alb.value=accion;

//alert(accion);

document.forms[0].submit();
}

// Si está facturado y se ha elegido imprimir, imprimimos; si no, avisamos:
else
{
	if (icono=="imprimir")
		eval(accion);
	else
		alert("Este documento está facturado y no puede ser modificado.");
}
} // Fin de if (validado)
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                               CARGAR FOCO
//--------------------------------------------------------------------------------------------
function cargar_foco(nombre_campo)
{
var campo = document.getElementById(nombre_campo);

	if (campo.value=='')
		campo.focus();
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                               LONGITUD OBSERVACIONES FACTURAS
//--------------------------------------------------------------------------------------------
function long_max_obs_fac(event)
{
var max=600;
var obs=event.target;

if (obs.value.length > max)
{
//alert('Longitud máxima: ' + max + ' caracteres.');
obs.value=obs.value.substr(0, max);
}
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------
<? } ?>