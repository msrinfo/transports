<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gesti&oacute; de Serveis</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
function calc_totales_serv()
{
global $cod_servicio,$cod_empresa,$tot_salida,$tot_hora,$tot_hora_espera,$tot_cabestrany,$tot_kms,$tot_treballs_varis, $tot_peajes,$tot_fuera_horas,$tot_festivos,$tot_aseguradora;

// INSERCIÓN DE LAS CANTIDADES FINALES EN servicios:
$base=0;
$neto_total=sel_campo("SUM(neto)","neto","art_serv","cod_servicio = '$cod_servicio' and cod_empresa='$cod_empresa'");

$subtotal = $neto_total + $tot_salida + $tot_hora + $tot_hora_espera + $tot_cabestrany + $tot_kms + $tot_treballs_varis + $tot_peajes;

/*echo "<br />neto_total: $neto_total<br />tot_salida: $tot_salida<br />tot_hora: $tot_hora<br />tot_hora_espera: $tot_hora_espera<br />tot_cabestrany: $tot_cabestrany<br />tot_kms: $tot_kms<br />tot_peajes: $tot_peajes<br />tot_fuera_horas: $tot_fuera_horas<br />fuera_horas: $fuera_horas";

exit();*/

$imp_fuera_horas=redondear($tot_fuera_horas*$subtotal/100);

$imp_festivos=redondear($tot_festivos*$subtotal/100);

$base=redondear($subtotal + $imp_fuera_horas + $imp_festivos);

$imp_aseguradora=redondear($tot_aseguradora*$base/100);

$base=redondear($base - $imp_aseguradora);


/*echo "<br />imp_fuera_horas: $imp_fuera_horas<br />fuera_horas: $fuera_horas<br />imp_festivos: $imp_festivos<br />festivos: $festivos<br />imp_aseguradora: $aseguradora<br />tot_kms: $tot_kms<br />tot_peajes: $tot_peajes";

exit();*/

$modificar="UPDATE servicios SET

imp_fuera_horas='$imp_fuera_horas',
imp_festivos='$imp_festivos',
imp_aseguradora='$imp_aseguradora',
subtotal='$subtotal',
base='$base'

WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'";

$result = mysql_query ($modificar) or die ("NO SE HAN ACTUALIZADO LAS CANTIDADES FINALES: ".mysql_error()."<br /> $modificar");
//--------------------------------------------------------------------------------------------
} // Fin de function


//--------------------------------------------------------------------------------------------
//                                POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
// comun:
$cod_servicio=$_POST["cod_servicio"];
$cod_empresa=$_POST["cod_empresa"];

// servicios:
$cod_cliente=$_POST["cod_cliente"];
$nombre_cliente=$_POST["nombre_cliente"];
$tipo_iva=$_POST["tipo_iva"];
$fecha=fecha_ing($_POST["fecha"]);
$vehiculo=$_POST["vehiculo"];
$matricula=$_POST["matricula"];
$hora_aviso=$_POST["hora_aviso"];
$hora_llegada=$_POST["hora_llegada"];
$pto_asistencia=$_POST["pto_asistencia"];
$cod_tarifa=$_POST["cod_tarifa"];



$cod_articulo=$_POST["cod_articulo"];
$descr_art=$_POST["descr_art"];
$cantidades=$_POST["cantidades"];
$precios=$_POST["precios"];
$neto=$_POST["neto"];
$base=$_POST["base"];
$observaciones_serv=$_POST["observaciones_serv"];


$cant_salida=$_POST["cant_salida"];
$cant_hora=$_POST["cant_hora"];
$cant_hora_espera=$_POST["cant_hora_espera"];
$cant_cabestrany=$_POST["cant_cabestrany"];
$cant_kms=$_POST["cant_kms"];
$cant_treballs_varis=$_POST["cant_treballs_varis"];
$cant_peajes=$_POST["cant_peajes"];

$fuera_horas=$_POST["fuera_horas"];
$festivos=$_POST["festivos"];
$aseguradora=$_POST["aseguradora"];

$cant_fuera_horas=$_POST["cant_fuera_horas"];
$cant_festivos=$_POST["cant_festivos"];
$cant_aseguradora=$_POST["cant_aseguradora"];

$tot_fuera_horas=$_POST["tot_fuera_horas"];
$tot_festivos=$_POST["tot_festivos"];
$tot_aseguradora=$_POST["tot_aseguradora"];

$imp_fuera_horas=$_POST["imp_fuera_horas"];
$imp_festivos=$_POST["imp_festivos"];
$imp_aseguradora=$_POST["imp_aseguradora"];

$tot_salida=$_POST["tot_salida"];
$tot_hora=$_POST["tot_hora"];
$tot_hora_espera=$_POST["tot_hora_espera"];
$tot_cabestrany=$_POST["tot_cabestrany"];
$tot_kms=$_POST["tot_kms"];
$tot_treballs_varis=$_POST["tot_treballs_varis"];
$tot_peajes=$_POST["tot_peajes"];


// art_serv:
$cod_linea=$_POST["cod_linea"];
$cod_articulo=$_POST["cod_articulo"];
$descr_art=$_POST["descr_art"];
$cantidad=$_POST["cantidad"];
$precio_coste=$_POST["precio_coste"];
$precio_venta=$_POST["precio_venta"];
$tipo_descuento=$_POST["tipo_descuento"];



// Si recibimos cod_empresa, continuamos:
if ($cod_empresa)
{
// Comprobamos si existe orden:
$comprobar_ord="SELECT cod_servicio FROM servicios WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'";
$consultar_ord=mysql_query($comprobar_ord, $link) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $consultar_ord <br />");
$existe_ord=mysql_num_rows($consultar_ord);


// Controlamos iva:
$tipo_iva=control_iva($tipo_iva,$fecha);


// ÓRDENES:
if ($existe_ord==1)
{

// MODIFICAMOS ORDEN:
$modificar_ord="UPDATE servicios SET

cod_servicio='$cod_servicio',
cod_cliente='$cod_cliente',
nombre_cliente='$nombre_cliente',
tipo_iva='$tipo_iva',
cod_empresa='$cod_empresa',
fecha='$fecha',
vehiculo='$vehiculo',
matricula='$matricula',
hora_aviso='$hora_aviso',
hora_llegada='$hora_llegada',
pto_asistencia='$pto_asistencia',
cod_tarifa='$cod_tarifa',

cant_salida='$cant_salida',
cant_hora='$cant_hora',
cant_hora_espera='$cant_hora_espera',
cant_cabestrany='$cant_cabestrany',

cant_kms='$cant_kms',
cant_treballs_varis='$cant_treballs_varis',
cant_peajes='$cant_peajes',

cant_fuera_horas='$cant_fuera_horas',
cant_festivos='$cant_festivos',
cant_aseguradora='$cant_aseguradora',

tot_fuera_horas='$tot_fuera_horas',
tot_festivos='$tot_festivos',
tot_aseguradora='$tot_aseguradora',

fuera_horas='$fuera_horas',
festivos='$festivos',
aseguradora='$aseguradora',

imp_fuera_horas='$imp_fuera_horas',
imp_festivos='$imp_festivos',
imp_aseguradora='$imp_aseguradora',

tot_salida='$tot_salida',
tot_hora='$tot_hora',
tot_hora_espera='$tot_hora_espera',
tot_cabestrany='$tot_cabestrany',
tot_kms='$tot_kms',
tot_treballs_varis='$tot_treballs_varis',
tot_peajes='$tot_peajes'

WHERE cod_servicio='$cod_servicio' and cod_empresa='$cod_empresa'";


$result_ord = mysql_query ($modificar_ord, $link) or die ("<br /> No se ha actualizado orden: ".mysql_error()."<br /> $modificar_ord <br />");
} // Fin de if ($existe_ord==1)
	
else
{
// INSERTAMOS ORDEN:
$insertar_ord="INSERT INTO servicios 
(cod_servicio,cod_cliente,nombre_cliente,tipo_iva,cod_empresa,fecha,vehiculo,matricula,hora_aviso,hora_llegada,
pto_asistencia,cod_tarifa, cant_salida,cant_hora, cant_hora_espera, cant_cabestrany, cant_kms, cant_treballs_varis, cant_peajes, cant_fuera_horas , cant_festivos ,cant_aseguradora, tot_fuera_horas, tot_festivos, tot_aseguradora, fuera_horas, festivos,aseguradora,imp_fuera_horas,imp_festivos,imp_aseguradora, tot_salida,tot_hora,tot_hora_espera,tot_cabestrany, tot_kms, tot_treballs_varis, tot_peajes)
VALUES ('$cod_servicio','$cod_cliente','$nombre_cliente','$tipo_iva','$cod_empresa','$fecha','$vehiculo','$matricula','$hora_aviso', '$hora_llegada','$pto_asistencia','$cod_tarifa', '$cant_salida', '$cant_hora', '$cant_hora_espera', '$cant_cabestrany', '$cant_kms', '$cant_treballs_varis', '$cant_peajes', '$cant_fuera_horas' , '$cant_festivos' , '$cant_aseguradora', '$tot_fuera_horas', '$tot_festivos', '$tot_aseguradora', '$fuera_horas', '$festivos', '$aseguradora', '$imp_fuera_horas', '$imp_festivos', '$imp_aseguradora', '$tot_salida', '$tot_hora', '$tot_hora_espera', '$tot_cabestrany','$tot_kms', '$tot_treballs_varis', '$tot_peajes')";

//echo "<br />IN: $insertar_ord";

$result_ord = mysql_query ($insertar_ord, $link) or die ("<br /> No se ha insertado servicio: ".mysql_error()."<br /> $insertar_ord <br />");


// Como es autoincremental, seleccionamos máximo:
$cod_servicio=obtener_max_con("cod_servicio","servicios","");
} // Fin de else => if ($existe_ord==1)


// ARTÍCULOS:
// Si recibimos cod_articulo, continuamos:
if ($descr_art || $cod_linea)
{
// Calculamos totales de artículo:
/*$tot_art_serv=calcular_totales_art_serv($cantidad,$precio_coste,$precio_venta,$tipo_descuento);

$coste=$tot_art_serv["coste"];
$venta=$tot_art_serv["venta"];
$descuento=$tot_art_serv["descuento"];
$neto=$tot_art_serv["neto"];
$beneficio=$tot_art_serv["beneficio"];
$margen=$tot_art_serv["margen"];*/

// Comprobamos si el artículo existe:
$comprobar_art="SELECT cantidad as cantidad_anterior FROM art_serv WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";
$consultar_art=mysql_query($comprobar_art, $link) or die ("No se ha comprobado artículo: ".mysql_error()."<br /> $comprobar_art <br />");
$existe_art=mysql_num_rows($consultar_art);

if ($existe_art==1)
{
// MODIFICAMOS ARTÍCULO:
$modificar_art="UPDATE art_serv SET

descr_art='$descr_art',
cantidad='$cantidad',
precio_coste='$precio_coste',
precio_venta='$precio_venta',
tipo_descuento='$tipo_descuento',

coste='$coste',
venta='$venta',
descuento='$descuento',
neto='$neto',
beneficio='$beneficio',
margen='$margen'

WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";

$result_art = mysql_query ($modificar_art, $link) or die ("No se ha actualizado art_serv: ".mysql_error()."<br /> $modificar_art <br />");
} // Fin de if ($existe_art==1)

else
{
// INSERTAMOS Nou ARTÍCULO:
$insertar_art="INSERT INTO art_serv
(cod_servicio,cod_empresa,cod_linea,cod_articulo,descr_art,cantidad,precio_coste,precio_venta,tipo_descuento,coste,venta,descuento,neto,beneficio,margen)
VALUES
('$cod_servicio','$cod_empresa','','$cod_articulo','$descr_art','$cantidad','$precio_coste','$precio_venta','$tipo_descuento','$coste','$venta','$descuento','$neto','$beneficio','$margen')";

$result_art = mysql_query ($insertar_art, $link) or die ("No se ha insertado art_serv: ".mysql_error()."<br /> $insertar_art <br />");
} // Fin de else => if ($existe_art==1)
} // Fin de if ($cod_articulo)


// Actualizamos totales:
calc_totales_serv();
} // Fin de if ($cod_empresa)


// Recargamos página:
?>
<script type="text/javascript">
//alert("FIN POST");
<? echo enviar_alb(); ?>
enlace(direccion_conta(''),'cod_servicio','<? echo "$cod_servicio"; ?>','cod_empresa','<? echo "$cod_empresa"; ?>','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos script:
exit();
} // Fin de if ($_POST)
//--------------------------------------------------------------------------------------------
//                                FIN DE: POST
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_servicio=$_GET["cod_servicio"];
$cod_empresa=$_GET["cod_empresa"];

$cod_linea=$_GET["cod_linea"];

$cod_articulo=$_GET["cod_articulo"]; // Para actualizar existencias.
$cod_cliente=$_GET["cod_cliente"]; // Para establecer la propiedad readonly.
$eliminar=$_GET["eliminar"];

/*echo "
<br /> cod_servicio: $cod_servicio
<br /> cod_empresa: $cod_empresa
<br /> cod_linea: $cod_linea
<br /> cod_cliente: $cod_cliente
<br /> eliminar: $eliminar
<br />";*/
//

// Comprobamos si existe orden:
$select_ord="SELECT * FROM servicios WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'";
$query_ord=mysql_query($select_ord, $link) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $select_ord <br />");
$existe_ord=mysql_num_rows($query_ord);


// Si existe orden, continuamos:
if ($existe_ord==1)
{
// Si está facturado, no eliminamos nada:
$albe=sel_sql("SELECT estado FROM servicios WHERE cod_empresa = '$cod_empresa' AND cod_servicio = '$cod_servicio'");
$estado=$albe[0]['estado'];
if ($estado=='f' && $eliminar!='')
{
$eliminar='';
?>
<script type="text/javascript">
alert('NO se modificará albarán porque está facturado.');
</script>
<?
}

//---------------------------------------------------------------------------------------------
//                                      ELIMINAR ARTÍCULO
//---------------------------------------------------------------------------------------------
if ($cod_linea && $eliminar==1)
{
	if($estado!='f')
	{
		// Obtenemos la cantidad y actualizamos existencias:
		$cantidad=sel_campo("cantidad","","art_serv","cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'");
	//	actualizar_exis("sumar",$cod_articulo,$cantidad,"0");

		// Eliminamos artículo:
		$eliminar_art="DELETE FROM art_serv WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";
		$result=mysql_query($eliminar_art, $link) or die ("No se ha eliminado artículo: ".mysql_error()."<br /> $eliminar_art <br />");


// Actualizamos totales:
calc_totales_serv();


// Vaciamos variables para evitar errores de introducción de datos:
$cod_linea="";
$cod_articulo="";
$precio_coste="";
$cantidad="";
}
else
{
?>
<script language="javascript">
alert ('Este servicio ya está facturado.\nPara modificarlo, anule antes la factura.');
</script>
<?
}
} // Fin de if ($cod_linea && $eliminar==1)
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR ARTÍCULO
//---------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------
//                                      ELIMINAR ALBARÁN
//---------------------------------------------------------------------------------------------
else if ($eliminar==2)
{

	if($estado!='f')
	{
// Obtenemos la suma de las cantidad de un mismo cod_articulo para sumar a existencias y actualizamos existencias:
$consulta="SELECT cod_linea,cantidad,cod_articulo FROM art_serv WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'";
$query=mysql_query($consulta, $link) or die ("No se han sumado cantidades para actualizar existencias: ".mysql_error()."<br /> $consulta <br />");
while($arti=mysql_fetch_array($query))
{
$cod_linea=$arti["cod_linea"];
$cantidad=$arti["cantidad"];
$cod_articulo=$arti["cod_articulo"];

// Actualizamos existencias:
//actualizar_exis("sumar",$cod_articulo,$cantidad,"0");


// Eliminamos artículos:
$eliminar_art="DELETE FROM art_serv WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";
$result=mysql_query($eliminar_art, $link) or die ("No se ha eliminado artículo: ".mysql_error()."<br /> $eliminar_art <br />");
	} //Fin de if($estado!='f')
} // Fin de while($array=mysql_fetch_array($query))


// Eliminamos albarán:
$eliminar_alb="DELETE FROM servicios WHERE cod_servicio = '$cod_servicio' AND cod_empresa = '$cod_empresa'";
$result_alb=mysql_query($eliminar_alb, $link) or die ("No se ha eliminado la orden ni sus artículos: ".mysql_error()."<br /> $eliminar_alb <br />");

// Vaciamos variables para evitar errores de introducción de datos:
$cod_servicio=$cod_empresa=$cod_linea="";
} // Fin de else if ($eliminar==2)
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR ALBARÁN
//---------------------------------------------------------------------------------------------


if ($existe_ord==1 && $eliminar!=2)
{
// Mostramos orden:
$result_ord=mysql_query($select_ord, $link) or die ("No se ha mostrado la orden: ".mysql_error()."<br /> $select_ord <br />");
//echo "<br /> select_ord: $select_ord <br />";
$alb=mysql_fetch_array($result_ord);

$cod_servicio=$alb["cod_servicio"];
$fecha=$alb["fecha"];


$cod_servicio=$alb["cod_servicio"];
$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=$alb["nombre_cliente"];
$tipo_iva=$alb["tipo_iva"];
$cod_empresa=$alb["cod_empresa"];
$fecha=fecha_esp($alb["fecha"]);
$vehiculo=$alb["vehiculo"];
$matricula=$alb["matricula"];
$hora_aviso=$alb["hora_aviso"];
$hora_llegada=$alb["hora_llegada"];
$pto_asistencia=$alb["pto_asistencia"];

$cod_tarifa=$alb["cod_tarifa"];

if($cod_tarifa){
$desc_tarifa=sel_campo("desc_tarifa","","tarifas","cod_tarifa='$cod_tarifa'");
$salida=sel_campo("salida","","tarifas","cod_tarifa='$cod_tarifa'");
$hora=sel_campo("hora","","tarifas","cod_tarifa='$cod_tarifa'");
$hora_espera=sel_campo("hora_espera","","tarifas","cod_tarifa='$cod_tarifa'");
$cabestrany=sel_campo("cabestrany","","tarifas","cod_tarifa='$cod_tarifa'");
$fuera_horas=sel_campo("fuera_horas","","tarifas","cod_tarifa='$cod_tarifa'");
$kms=sel_campo("kms","","tarifas","cod_tarifa='$cod_tarifa'");
$treballs_varis=sel_campo("treballs_varis","","tarifas","cod_tarifa='$cod_tarifa'");
$peajes=sel_campo("peajes","","tarifas","cod_tarifa='$cod_tarifa'");
$festivos=sel_campo("festivos","","tarifas","cod_tarifa='$cod_tarifa'");
$aseguradora=sel_campo("aseguradora","","tarifas","cod_tarifa='$cod_tarifa'");

}


$cant_salida=$alb["cant_salida"];
$cant_hora=$alb["cant_hora"];
$cant_hora_espera=$alb["cant_hora_espera"];
$cant_cabestrany=$alb["cant_cabestrany"];
$cant_kms=$alb["cant_kms"];
$cant_treballs_varis=$alb["cant_treballs_varis"];
$cant_peajes=$alb["cant_peajes"];


$tot_salida=$alb["tot_salida"];
$tot_hora=$alb["tot_hora"];
$tot_hora_espera=$alb["tot_hora_espera"];
$tot_cabestrany=$alb["tot_cabestrany"];

$tot_kms=$alb["tot_kms"];
$tot_treballs_varis=$alb["tot_treballs_varis"];
$tot_peajes=$alb["tot_peajes"];



$cant_fuera_horas=$alb["cant_fuera_horas"];
$cant_festivos=$alb["cant_festivos"];
$cant_aseguradora=$alb["cant_aseguradora"];

$tot_fuera_horas=$alb["tot_fuera_horas"];
$tot_festivos=$alb["tot_festivos"];
$tot_aseguradora=$alb["tot_aseguradora"];

$fuera_horas=$alb["fuera_horas"];
$festivos=$alb["festivos"];
$aseguradora=$alb["aseguradora"];
$imp_fuera_horas=$alb["imp_fuera_horas"];
$imp_festivos=$alb["imp_festivos"];
$imp_aseguradora=$alb["imp_aseguradora"];


$cod_articulo=$alb["cod_articulo"];
$descr_art=$alb["descr_art"];
$cantidades=$alb["cantidades"];
$precios=$alb["precios"];
$neto=$alb["neto"];
$base=$alb["base"];
$observaciones_serv=$alb["observaciones_serv"];

$estado=$alb["estado"];

$cod_factura=$alb["cod_factura"];

// Obtenemos asiento correspondiente:
if ($estado=="f")
{
conectar_base($base_datos_conta);
$cod_asiento=sel_campo("cod_asiento","","asientos","cod_empresa = '$cod_empresa' and txt_predef = 'VE' and cod_factura = $cod_factura");
conectar_base($base_datos);
}


// Si recibimos cod_linea y no hemos eliminado, mostramos artículo:
if ($cod_linea && $eliminar!=1)
{
$mostrar_art="SELECT * FROM art_serv WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";

$result_art=mysql_query($mostrar_art, $link) or die ("No se ha seleccionado artículo: ".mysql_error()."<br /> $mostrar_art <br />");
$art=mysql_fetch_array($result_art);

$cod_servicio=$art["cod_servicio"];
$cod_empresa=$art["cod_empresa"];
$cod_linea=$art["cod_linea"];
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];

$coste=$art["coste"];
$venta=$art["venta"];
$descuento=$art["descuento"];
$neto=$art["neto"];
$beneficio=$art["beneficio"];
$margen=$art["margen"];

// Obtenemos las existencias del artículo:
//$existencias=sel_campo("existencias","","articulos","cod_articulo = '$cod_articulo'");
} // Fin de if ($cod_linea && $eliminar!=1)
} // Fin de if ($existe_ord==1 && $eliminar!=2)
} // Fin de if ($existe_ord==1)

else 
{
// Si recibimos cod_cliente, mostramos datos de cliente:
if ($cod_cliente)
{
$select_cli="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$result_cli=mysql_query($select_cli, $link) or die ("No se ha seleccionado cliente: ".mysql_error()."<br /> $select_cli <br />");
$cli=mysql_fetch_array($result_cli);
	
$nombre_cliente=$cli["nombre_cliente"];
$tipo_iva=$cli["tipo_iva"];
} // Fin de if ($cod_cliente)
} // Fin de else
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN DE: GET
//--------------------------------------------------------------------------------------------


// Establecemos la propiedad (y la clase) readonly:
if (($existe_ord==1 && $eliminar!=2) || $cod_cliente)
{
$readonly_inicial="";
$readonly_final="readonly class='readonly'";
}
else
{
$readonly_inicial="readonly class='readonly'";
}
//echo "<br /> existe_ord: $existe_ord <br /> existe_ord: $existe_ord <br />";


// Si no se muestra ningún albarán, mostraremos la fecha actual:
if (!$fecha)
{
$fecha_hoy=getdate();
$fecha=$fecha_hoy[mday].'-'.$fecha_hoy[mon].'-'.$usuario_any;
}
?>
<script type="text/javascript">
function abrir_op()
{
var cod_servicio = document.getElementById('cod_servicio').value;
var cod_empresa = document.getElementById('cod_empresa').value;

if (cod_servicio && cod_empresa)
{
mostrar(event,direccion_conta('1_3_op_servicios.php'),'cod_servicio',cod_servicio,'cod_empresa',cod_empresa,'','','','','','','','','','','','','','','','');
}

else
	alert("Seleccione orden y empresa antes de introducir operarios.");
} // Fin de function

function calc_imp_serv_gond()
{
var solo_decimal = /^\.|[^0-9\.]|\..+\.|\.{2,}/g;

var cantidad = control_dec(document.getElementById('cantidad').value);
var precio_venta = control_dec(document.getElementById('precio_venta').value);
var tipo_descuento = control_dec(document.getElementById('tipo_descuento').value);


var salida = control_dec(document.getElementById('salida').value);
var cant_salida = control_dec(document.getElementById('cant_salida').value);
var hora = control_dec(document.getElementById('hora').value);
var cant_hora = control_dec(document.getElementById('cant_hora').value);
var hora_espera = control_dec(document.getElementById('hora_espera').value);
var cant_hora_espera = control_dec(document.getElementById('cant_hora_espera').value);
var cabestrany = control_dec(document.getElementById('cabestrany').value);
var cant_cabestrany = control_dec(document.getElementById('cant_cabestrany').value);

var fuera_horas = control_dec(document.getElementById('fuera_horas').value);
var cant_fuera_horas = control_dec(document.getElementById('cant_fuera_horas').value);

var kms = control_dec(document.getElementById('kms').value);
var cant_kms = control_dec(document.getElementById('cant_kms').value);

var treballs_varis = control_dec(document.getElementById('treballs_varis').value);
var cant_treballs_varis = control_dec(document.getElementById('cant_treballs_varis').value);

var peajes = control_dec(document.getElementById('peajes').value);
var cant_peajes = control_dec(document.getElementById('cant_peajes').value);

var festivos = control_dec(document.getElementById('festivos').value);
var cant_festivos = control_dec(document.getElementById('cant_festivos').value);

var aseguradora = control_dec(document.getElementById('aseguradora').value);
var cant_aseguradora = control_dec(document.getElementById('cant_aseguradora').value);

var tot_salida = salida * cant_salida;
document.getElementById('tot_salida').value = tot_salida;

var tot_hora = hora * cant_hora;
document.getElementById('tot_hora').value = tot_hora;

var tot_hora_espera = hora_espera * cant_hora_espera;
document.getElementById('tot_hora_espera').value = tot_hora_espera;

var tot_cabestrany = cabestrany * cant_cabestrany;
document.getElementById('tot_cabestrany').value = tot_cabestrany;

var tot_fuera_horas = fuera_horas * cant_fuera_horas;
document.getElementById('tot_fuera_horas').value = tot_fuera_horas;

var tot_kms = kms * cant_kms;
document.getElementById('tot_kms').value = tot_kms;

var tot_treballs_varis = treballs_varis * cant_treballs_varis;
document.getElementById('tot_treballs_varis').value = tot_treballs_varis;

var tot_peajes = peajes * cant_peajes;
document.getElementById('tot_peajes').value = tot_peajes;


var tot_festivos = festivos * cant_festivos;
document.getElementById('tot_festivos').value = tot_festivos;

var tot_aseguradora = aseguradora * cant_aseguradora;
document.getElementById('tot_aseguradora').value = tot_aseguradora;
/*
if(isNaN(precio_coste)==true || isNaN(cantidad)==true || isNaN(precio_venta)==true || isNaN(tipo_descuento)==true)
	alert("Precio Coste, Cantidad, PVP y Descuento han de ser números.");
*/

//else
//{
var venta = precio_venta * cantidad;
var descuento = venta * (tipo_descuento / 100);
var neto = venta - descuento;

//document.getElementById('venta').value = venta;
//document.getElementById('descuento').value = descuento;
document.getElementById('neto').value = neto;
//} // Fin de else
} // Fin de function
//--------------------------------------------------------------------------------------------

function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="fecha";
//ser_no_vacio[1]="matricula";

ser_ambos[0]="cod_cliente";

//ser_numero[0]="cod_servicio";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

var estado = "<? echo $estado; ?>";

sg_enviar_alb_js(event,validado,estado,"1_2_impr_serv.php","1_1_fac_serv_crear.php");
} // Fin de function
//--------------------------------------------------------------------------------------------
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="servicios" id="servicios" method="post" action="">
          <tr class="titulo"> 
            <td colspan="13">Gesti&oacute; de Serveis </td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td width="90" align="left"><div align="left">N&ordm; Servei:</div></td>
            <td width="85"><input name="cod_servicio" title="Código Servicio" type="text" id="cod_servicio" size="7" maxlength="6" value="<? echo "$cod_servicio"; ?>" onBlur="buscar_conta(event,'servicios',cod_servicio.value,'cod_cliente',cod_cliente.value,'cod_servicio',cod_servicio.value,'cod_empresa',cod_empresa.value,'','','','','','','refrescar');" onMouseOut="this.blur()"> 
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_servicio');"></td>
            <td colspan="3">&nbsp;</td>
            <td width="60"><div align="right">Data</div></td>
            <td colspan="2" align="left"><input name="fecha" title="Fecha" type="text" id="fecha" size="11" maxlength="10"  value="<? echo "$fecha"; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','servicios','fecha')"></td>
            <td colspan="3" align="right"><? if ($cod_asiento) {echo "Asiento: "; ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_asiento;} ?></span></td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left"><div align="left">N&ordm; Client:</div></td>
            <td><input name="cod_cliente" title="Código Cliente" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo "$cod_cliente"; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'cod_servicio',cod_servicio.value,'','','','','','','','','refrescar');" onMouseOut="this.blur()" <? echo $readonly_final; ?>> 
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');"></td>
            <td colspan="3"><input name="nombre_cliente" title="Nombre Cliente" type="text" id="nombre_cliente" size="40" maxlength="" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" readonly="true" class="readonly"></td>
            <td align="right">IVA</td>
            <td width="60"><input name="tipo_iva" type="text" readonly="readonly" class="readonly" id="tipo_iva" title="tipo_iva"  value="<? echo "$tipo_iva"; ?>" size="2" maxlength="4"></td>
            <td colspan="4" align="right">
              <input name="estado" type="hidden" id="estado" value="<? echo $estado; ?>" readonly="true" class="readonly">
            <strong>Estado:</strong> 
<? if ($estado!="f") {echo "No Facturado.";} else {echo "Factura: "; ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/3_2_fac_serv_impr.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','','','','','','','','','','','','','','');"><? echo sprintf("%06s", $cod_factura);} ?></span>
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Empresa: </td>
            <td><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td colspan="3">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11" align="left"><hr align="left" /></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td align="left"><div align="left">Vehicle:</div></td>
            <td colspan="8"><input name="vehiculo" title="Vehiculo" type="text" id="vehiculo" size="40" maxlength="40"  value="<? echo a_html($vehiculo,"bd->input"); ?>">
Matr&iacute;cula:
<input name="matricula" title="matricula" type="text" id="matricula" size="14" maxlength=""  value="<? echo a_html($matricula,"bd->input"); ?>"></td>
            <td></td>
            <td width="32"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left"><div align="left">Hora Av&iacute;s: :</div></td>
            <td colspan="4"><input name="hora_aviso" title="hora_aviso" type="text" id="hora_aviso" size="14" maxlength=""  value="<? echo "$hora_aviso"; ?>">
Hora Arribada:
  <input name="hora_llegada" title="hora_llegada" type="text" id="hora_llegada" size="14" maxlength=""  value="<? echo "$hora_llegada"; ?>"></td>
            <td colspan="4">&nbsp;</td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left"><div align="left">Pto. Asist.: </div></td>
            <td colspan="3"><input name="pto_asistencia" title="pto_asistencia" type="text" id="pto_asistencia" size="40" maxlength="40"  value="<? echo a_html($pto_asistencia,"bd->input"); ?>"></td>
            <td width="72">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10"><hr /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tarifa:</td>
            <td>Descripci&oacute;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="cod_tarifa" title="C&oacute;digo Conjunto" type="text" id="cod_tarifa" size="2" maxlength="2" value="<? echo "$cod_tarifa"; ?>" onBlur="buscar_conta(event,'tarifas',cod_tarifa.value,'cod_tarifa',cod_tarifa.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tarifa');"> </td>
            <td colspan="3"><input name="desc_tarifa" title="Descripci&oacute;n" type="text" id="desc_tarifa" size="40" maxlength="40" value="<? echo a_html($desc_tarifa,"bd->input"); ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Precio</td>
            <td>Cantidad</td>
            <td>Importe</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Sortida:</td>
            <td><input name="salida" title="salida" type="text" id="salida" size="8" maxlength="8" value="<? echo "$salida"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_salida" title="Cantidad Salida" type="text" id="cant_salida" size="10" maxlength="" value="<? echo "$cant_salida"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_salida" title="tot_salida" type="text" id="tot_salida" size="10" maxlength="" value="<? echo "$tot_salida"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Hora:</td>
            <td><input name="hora" title="hora" type="text" id="hora" size="8" maxlength="8" value="<? echo "$hora"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_hora" title="cant_hora" type="text" id="cant_hora" size="10" maxlength="" value="<? echo "$cant_hora"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_hora" title="tot_hora" type="text" id="tot_hora" size="10" maxlength="" value="<? echo "$tot_hora"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Hora Espera: </td>
            <td><input name="hora_espera" title="hora_espera" type="text" id="hora_espera" size="8" maxlength="8" value="<? echo "$hora_espera"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_hora_espera" title="cant_hora_espera" type="text" id="cant_hora_espera" size="10" maxlength="" value="<? echo "$cant_hora_espera"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_hora_espera" title="tot_hora_espera" type="text" id="tot_hora_espera" size="10" maxlength="" value="<? echo "$tot_hora_espera"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Cabestrany:</td>
            <td><input name="cabestrany" title="cabestrany" type="text" id="cabestrany" size="8" maxlength="8" value="<? echo "$cabestrany"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_cabestrany" title="cant_cabestrany" type="text" id="cant_cabestrany" size="10" maxlength="" value="<? echo "$cant_cabestrany"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_cabestrany" title="tot_cabestrany" type="text" id="tot_cabestrany" size="10" maxlength="" value="<? echo "$tot_cabestrany"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Fora Hores: </td>
            <td><input name="fuera_horas" title="fuera_horas" type="text" id="fuera_horas" size="8" maxlength="8" value="<? echo "$fuera_horas"; ?>" readonly="true" class="readonly">
            %</td>
            <td><input name="cant_fuera_horas" title="cant_fuera_horas" type="text" id="cant_fuera_horas" size="10" maxlength="" value="<? echo "$cant_fuera_horas"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_fuera_horas" title="tot_fuera_horas" type="text" id="tot_fuera_horas" size="10" maxlength="" value="<? echo "$tot_fuera_horas"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Kms:</td>
            <td><input name="kms" title="kms" type="text" id="kms" size="8" maxlength="8" value="<? echo "$kms"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_kms" title="cant_kms" type="text" id="cant_kms" size="10" maxlength="" value="<? echo "$cant_kms"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_kms" title="tot_kms" type="text" id="tot_kms" size="10" maxlength="" value="<? echo "$tot_kms"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Treballs Varis: </td>
            <td><input name="treballs_varis" title="treballs_varis" type="text" id="treballs_varis" size="8" maxlength="8" value="<? echo "$treballs_varis"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_treballs_varis" title="cant_treballs_varis" type="text" id="cant_treballs_varis" size="10" maxlength="" value="<? echo "$cant_treballs_varis"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_treballs_varis" title="tot_treballs_varis" type="text" id="tot_treballs_varis" size="10" maxlength="" value="<? echo "$tot_treballs_varis"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Peatges:</td>
            <td><input name="peajes" title="peajes" type="text" id="peajes" size="8" maxlength="8" value="<? echo "$peajes"; ?>" readonly="true" class="readonly"></td>
            <td><input name="cant_peajes" title="cant_peajes" type="text" id="cant_peajes" size="10" maxlength="" value="<? echo "$cant_peajes"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_peajes" title="tot_peajes" type="text" id="tot_peajes" size="10" maxlength="" value="<? echo "$tot_peajes"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Festiu:</td>
            <td><input name="festivos" title="festivos" type="text" id="festivos" size="8" maxlength="8" value="<? echo "$festivos"; ?>" readonly="true" class="readonly">
            %</td>
            <td><input name="cant_festivos" title="cant_festivos" type="text" id="cant_festivos" size="10" maxlength="" value="<? echo "$cant_festivos"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_festivos" title="tot_festivos" type="text" id="tot_festivos" size="10" maxlength="" value="<? echo "$tot_festivos"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Asseguradora:</td>
            <td><input name="aseguradora" title="aseguradora" type="text" id="aseguradora" size="8" maxlength="8" value="<? echo "$aseguradora"; ?>" readonly="true" class="readonly">
            %-</td>
            <td><input name="cant_aseguradora" title="cant_aseguradora" type="text" id="cant_aseguradora" size="10" maxlength="" value="<? echo "$cant_aseguradora"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()"></td>
            <td><input name="tot_aseguradora" title="tot_aseguradora" type="text" id="tot_aseguradora" size="10" maxlength="" value="<? echo "$tot_aseguradora"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">Concepte</td>
            <td><input name="cod_linea" type="hidden" id="cod_linea" value="<? echo $cod_linea; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td><div align="center"></div></td>
            <td><div align="right"></div></td>
            <td><div align="right">Cant.</div></td>
            <td width="60"><div align="right">P.V.P.</div></td>
            <td width="60"><div align="right">Dto.</div></td>
            <td width="60"><div align="right">Net</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="4"><input name="descr_art" title="Descripción Art." type="text" id="descr_art" size="50" value="<? echo a_html($descr_art,"bd->input"); ?>" <? echo "$readonly_inicial"; ?>>              
              <div align="right"></div></td>
            <td>
              
              <div align="center"></div></td>
            <td>
              
              <div align="right"></div></td>
            <td> 
                
              <div align="right">
                <input name="cantidad" title="Cantidad" type="text" id="cantidad" size="10" maxlength="11" value="<? echo "$cantidad"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()" <? echo "$readonly_inicial"; ?>>
              </div></td>
            <td> 
                
              <div align="right">
                <input name="precio_venta" title="PVP" type="text" id="precio_venta" size="10" maxlength="11" value="<? echo "$precio_venta"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()" <? echo "$readonly_inicial"; ?>>
              </div></td>
            <td> 
                
              <div align="right">
                <input name="tipo_descuento" title="Descuento Lineal" type="text" id="tipo_descuento" size="5" maxlength="5" value="<? echo "$tipo_descuento"; ?>" onKeyUp="calc_imp_serv_gond()" onBlur="calc_imp_serv_gond()" <? echo "$readonly_inicial"; ?>>
              </div></td>
            <td> 
                
              <div align="right">
                <input name="neto" title="Importe Neto" type="text" id="neto" value="<? echo "$neto"; ?>" size="10" maxlength="11" readonly="true" class="readonly">
              </div></td>
            <td>
			<? if ($estado!="f") { ?>
			<img src="/comun/imgs/guardar2.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();">
			<? } ?></td>
            <td>&nbsp;</td>
          </tr>
<?
// Seleccionamos artículos:
$mostrar_art="SELECT * FROM art_serv WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'";
//echo "<br /> mostrar_art: $mostrar_art <br />";
$result_art=mysql_query($mostrar_art, $link) or die ("No se han seleccionado artículos de órdenes: ".mysql_error()."<br /> $mostrar_art <br />");

$total_filas=mysql_num_rows($result_art);

// Limitamos la consulta:
$lineas_mostrar=5;
$limit=paginar("limitar");


// Si hay uno o más artículos, los mostramos:
if ($total_filas > 0)
{
$mostrar_art .= " ORDER BY cod_linea $limit";

$result_art=mysql_query($mostrar_art, $link) or die ("No se han seleccionado artículos de órdenes: ".mysql_error()."<br /> $mostrar_art <br />");

while($art=mysql_fetch_array($result_art))
{
//$cod_servicio=$art["cod_servicio"];
//$cod_empresa=$art["cod_empresa"];
$cod_linea=$art["cod_linea"];
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];

//$coste=$art["coste"];
//$venta=$art["venta"];
//$descuento=$art["descuento"];
$neto=$art["neto"];
//$beneficio=$art["beneficio"];
//$margen=$art["margen"];

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
            <td colspan="4"> <div align="left"><? echo "$cod_articulo"; ?></div>              <? echo "$descr_art"; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><? echo "$cantidad"; ?></div></td>
            <td><div align="right"><? echo "$precio_venta"; ?></div></td>
            <td><div align="right"><? echo "$tipo_descuento"; ?></div></td>
            <td><div align="right"><? echo "$neto"; ?></div></td>
            <td>
			<? if ($estado!="f") { ?>
			<img src="/comun/imgs/editar.gif" title="Modificar" onClick="enlace(direccion_conta(''),'cod_servicio','<? echo $cod_servicio; ?>','cod_empresa','<? echo $cod_empresa; ?>','cod_linea','<? echo $cod_linea; ?>','','','','','','','','','','','','','','');">
			<img src="/comun/imgs/eliminar2.gif" title="Eliminar" onClick="if(confirm('¿Está seguro de que desea borrar el artículo <? echo a_html($cod_articulo.": ".$descr_art,"bd->javascript"); ?>?')) {enlace(direccion_conta(''),'cod_servicio','<? echo $cod_servicio; ?>','cod_empresa','<? echo $cod_empresa; ?>','cod_linea','<? echo $cod_linea; ?>','cod_articulo','<? echo a_html($cod_articulo,"bd->javascript"); ?>','eliminar','1','estado','<? echo $estado; ?>','','','','','','','','')};">
			<? } ?></td>
            <td >&nbsp;</td>
          </tr>
<?
} // Fin de while($art=mysql_fetch_array($result_art))
} // Fin de if ($total_filas > 0)


// Rellenamos con filas:
paginar("rellenar");
?>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"> 
<?
$campo_pag[1]="cod_servicio"; $valor_pag[1]=$cod_servicio;
$campo_pag[2]="cod_empresa"; $valor_pag[2]=$cod_empresa;


// Paginamos:
paginar("paginar");
?>          </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="85">&nbsp;</td>
            <td width="75">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><strong>TOTAL: </strong></td>
            <td align="right"><input name="base" type="text" id="base" size="10" maxlength="11" value="<? echo "$base"; ?>" readonly="true" class="readonly"></td>
            <td align="left">&euro;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><? if ($estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />Guardar</div>
			<? } ?></td>
            <td><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nuevo" onClick="location.href=direccion_conta('');"><br />Nuevo</div></td>
            <td><? if ($estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_servicio');"><br />Eliminar</div>
			<? } ?></td>
            <td><? if ($cod_albaran) { ?>
			<div align="center"><img src="/comun/imgs/imprimir.gif" title="Imprimir" name="imprimir" id="imprimir" onClick="enviar(event)" onMouseOver="window.top.focus();"><br />Imprimir</div>
			<? } ?></td>
            <td><? if ($cod_albaran && $estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/factura.gif" name="facturar" id="facturar" title="Facturar" onClick="enviar(event)" onMouseOver="window.top.focus();"><br />Facturar</div>
			<? } ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>