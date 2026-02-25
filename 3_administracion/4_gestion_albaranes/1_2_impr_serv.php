<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Servei impr&egrave;s</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' /></head>

<body>
<table>
<?
$lineas_pag=10; // Líneas a mostrar por página.

//---------------------------------------------------------------------------------------------
//---------------------------- CABECERA -------------------------------------------------------
//---------------------------------------------------------------------------------------------
function cabecera()
{
global $cont,$lineas_pag,$nombre_cliente,$razon_social,$domicilio,$c_postal,$poblacion,$provincia,$domicilio_corresp,$c_postal_corresp,$poblacion_corresp,$provincia_corresp,$nif_cif,$cod_empresa,$cod_servicio,$fecha,$cod_cliente,$num_pags,$vehiculo,$matricula,$hora_aviso,$hora_llegada,$pto_asistencia, $cant_salida, $cant_hora, $cant_hora_espera, $cant_cabestrany, $cant_kms, $cant_treballs_varis, $cant_peajes, $tot_salida, $tot_hora, $tot_hora_espera, $tot_cabestrany, $tot_kms, $tot_treballs_varis, $salida, $hora, $hora_espera, $cabestrany, $fuera_horas, $kms, $treballs_varis, $peajes;



// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
// Aumentamos el contador de páginas:
$num_pags++;

if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr <? echo $salto; ?>>
    <td width="1%">&nbsp;</td>
    <td colspan="2"></td>
    <td width="7%"></td>
    <td width="8%"></td>
    <td width="9%"></td>
    <td width="8%"></td>
    <td width="8%"></td>
    <td width="4%"></td>
    <td width="8%"></td>
    <td width="6%"></td>
    <td width="7%"></td>
    <td width="6%"></td>
    <td colspan="2"></td>
    <td width="1%">&nbsp;</td>
  </tr>
<?
// Líneas blancas de relleno en la cabecera:
for ($blancas=1; $blancas <= 8; $blancas++)
{
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<? } ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="7"><strong><? echo $nombre_cliente; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="7"><? echo $razon_social; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><? echo substr($domicilio,0,50); ?></td>
    <td colspan="7"><? echo substr($domicilio_corresp,0,50); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><? echo substr($domicilio,50,50); ?></td>
    <td colspan="7"><? echo substr($domicilio_corresp,50,50); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><? echo $c_postal." - ".$poblacion; ?></td>
    <td colspan="7"><? echo $c_postal_corresp." - ".$poblacion_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><? echo $provincia; ?></td>
    <td colspan="7"><? echo $provincia_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">N.I.F.: <? echo $nif_cif; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"><strong>N&ordm; Servei </strong></div></td>
    <td colspan="2"><div align="right"><strong>Data</strong></div></td>
    <td><div align="right"><strong>N&ordm; Client</strong></div></td>
    <td><div align="right"><strong>P&agrave;gina </strong></div></td>
    <td colspan="8">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"><? echo "($cod_empresa) $cod_servicio"; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? echo $fecha; ?></div></td>
    <td><div align="right"><? echo $cod_cliente; ?></div></td>
    <td><div align="right"><? echo $num_pags; ?></div></td>
    <td colspan="8"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>Vehicle</strong></td>
    <td>&nbsp;</td>
    <td align="right"><strong>Matr&iacute;cula</strong></td>
    <td>&nbsp;</td>
    <td><strong>Hora Av. </strong></td>
    <td><strong>Hora Ar.</strong></td>
    <td>&nbsp;</td>
    <td colspan="3"><strong>Pto. Asist </strong></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><? echo $vehiculo; ?></td>
    <td>&nbsp;</td>
    <td align="right"><? echo $matricula; ?></td>
    <td>&nbsp;</td>
    <td><? echo substr($hora_aviso,0,5); ?></td>
    <td><? echo substr($hora_llegada,0,5); ?></td>
    <td>&nbsp;</td>
    <td colspan="6"><? echo $pto_asistencia; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="7%" align="right">&nbsp;</td>
    <td width="11%" align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>SORTIDA</strong></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_salida!=0) echo $cant_salida; ?></td>
    <td align="right"><? if($cant_salida!=0) echo $salida; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_salida!=0) echo $tot_salida; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>HORA</strong></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_hora!=0) echo $cant_hora; ?></td>
    <td align="right"><? if($cant_hora!=0) echo $hora; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_hora!=0) echo $tot_hora; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>HORES D&acute; ESPERA </strong></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_hora_espera!=0) echo $cant_hora_espera; ?></td>
    <td align="right"><? if($cant_hora_espera!=0) echo $hora_espera; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_hora_espera!=0) echo $tot_hora_espera; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>SERVEI CABESTRANY </strong></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_cabestrany!=0) echo $cant_cabestrany; ?></td>
    <td align="right"><? if($cant_cabestrany!=0) echo $cabestrany; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_cabestrany!=0) echo $tot_cabestrany; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>QUIL&Ograve;METRES</strong></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_kms!=0) echo $cant_kms; ?></td>
    <td align="right"><? if($cant_kms!=0) echo $kms; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_kms!=0) echo $tot_kms; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>TREBALLS VARIS</strong> </td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $cant_treballs_varis; ?></td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $treballs_varis; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $tot_treballs_varis; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>PEATGES</strong></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? if($cant_peajes!=0) echo $cant_peajes; ?></td>
    <td align="right"><? if($cant_peajes!=0) echo $peajes; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_peajes!=0) echo $tot_peajes; ?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="9"><div><strong>Concepte</strong><strong></strong></div>      </td>
    <td><div align="right"><strong>Quan</strong></div></td>
    <td><div align="right"><strong>Preu</strong></div></td>
    <td><div align="right"><strong>% Dte.</strong></div></td>
    <td colspan="2"><div align="right"><strong>Import</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function
//---------------------------------------------------------------------------------------------
//---------------------------- FIN DE: CABECERA -----------------------------------------------
//---------------------------------------------------------------------------------------------


$cod_servicio=$_GET["cod_servicio"];
$cod_empresa=$_GET["cod_empresa"];

if ($cod_servicio && $cod_empresa)
{
// Seleccionamos facturas:
$select_fac="SELECT * FROM servicios WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'";

$result_fac=mysql_query($select_fac, $link) or die ("<br /> No se ha seleccionado albarán: ".mysql_error()."<br /> $select_fac <br />");

$alb=mysql_fetch_array($result_fac);

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
$subtotal=$alb["subtotal"];
$base=$alb["base"];
$observaciones_serv=$alb["observaciones_serv"];


// Obtenemos los datos del cliente de la tabla clientes:
$selec_cliente="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$consulta_cli=mysql_query($selec_cliente, $link) or die ("<br /> No se ha seleccionado cliente: ".mysql_error()."<br /> $selec_cliente <br />");
$fila=mysql_fetch_array($consulta_cli);

$razon_social=$fila["razon_social"];
$nif_cif=$fila["nif_cif"];

$domicilio=$fila["domicilio"];
$c_postal=$fila["c_postal"];
$poblacion=$fila["poblacion"];
$provincia=$fila["provincia"];

$domicilio_corresp=$fila["domicilio_corresp"];
$c_postal_corresp=$fila["c_postal_corresp"];
$poblacion_corresp=$fila["poblacion_corresp"];
$provincia_corresp=$fila["provincia_corresp"];

if ($domicilio_corresp=="")
{
$domicilio_corresp=$domicilio;
$c_postal_corresp=$c_postal;
$poblacion_corresp=$poblacion;
$provincia_corresp=$provincia;

$domicilio=$c_postal=$poblacion=$provincia="";
}

$telefono=$fila["telefono"];
$num_cuenta=$fila["num_cuenta"];
$copias_fac=$fila["copias_fac"];


// Mostramos cabecera por primera vez:
$num_pags=0; // Contador de páginas impresas.
$cont=0; // Contador de líneas.
cabecera();


// Obtenemos los artículos de ese albarán:
$orden_art="
SELECT cod_articulo,descr_art,cantidad,precio_venta,tipo_descuento,neto
FROM art_serv
WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'
ORDER BY cod_linea";

$query_orden_art=mysql_query($orden_art, $link) or die ("<br /> No se han seleccionado artículos de servicios: ".mysql_error()."<br /> $orden <br />");

while($art=mysql_fetch_array($query_orden_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];

$cantidad=$art["cantidad"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];
$neto=$art["neto"];


$cont++;
cabecera();
?>
  <tr>
    <td></td>
    <td colspan="2"><? /*echo $cont." ";*/ echo $cod_articulo; ?></td>
    <td>&nbsp;</td>
    <td colspan="6"><? echo substr($descr_art, 0, 50); ?></td>
    <td><div align="right"><? if ($cantidad!=0) {echo formatear($cantidad);} ?></div></td>
    <td><div align="right"><? if ($precio_venta!=0) {echo formatear($precio_venta);} ?></div></td>
    <td><div align="right"><? if ($tipo_descuento!=0) {echo formatear($tipo_descuento);} ?></div></td>
    <td colspan="2"><div align="right"><? if ($neto!=0) {echo formatear($neto);} ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de while($art=mysql_fetch_array($query_orden_art))


// Rellenamos con líneas en blanco:
for ($i=$cont+1; $i <= $lineas_pag; $i++)
{
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
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
 <?
} // Fin de for ($i=$cont; $i < $lineas_pag; $i++)
?>
    <td>&nbsp;</td>
    <td colspan="5"><strong>Fora d'Hores </strong><? echo $tot_fuera_horas; ?>% <strong> sobre </strong><? echo $subtotal; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo $imp_fuera_horas; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><strong>Festius </strong><? echo $tot_festivos; ?>% <strong> sobre </strong><? echo $subtotal; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo $imp_festivos; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><strong>Asseguradores/Tallers </strong><? echo "$tot_aseguradora"; ?>% <strong>sobre </strong>
      <? $subtotal1=redondear($subtotal +  $imp_festivos + $imp_fuera_horas); echo formatear($subtotal1); ?>
      <? /*echo $i." ";*/ ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo "-".$imp_aseguradora; ?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2"><strong>Total</strong></td>
    <td colspan="2"><div align="right"><strong><? echo formatear($base); ?> &euro;</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  
<?
} // Fin de if ($cod_servicio && $cod_empresa)
?>
</table>
</body>
</html>