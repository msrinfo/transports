<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Factura impresa</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<style type="text/css">
<!--
.clase_titu_emp
{
font-family: Arial, Helvetica, sans-serif;
font-size: 32px;
color: #003366;
font-weight: bold;
}

.clase_nombre_emp
{
font-size: 14px;
font-weight: bold;
}

.clase_datos_emp
{
font-size: 9px;
color: #56583F;
}

.capa_cabecera
{
position:relative;
height:116.5mm; /*440px 116.5mm*/
	
	margin-top: 10px;

/*border:1px;
border-style:solid;
border-color:#0066FF;
*/
}

.capa_contenido
{
position:relative;
height:118mm; /* 390px;*/

/*border:1px;
border-style:solid;
border-color:#FF0000;
*/
}

.capa_totales
{
position:relative;
height:36mm; /* Antes: 47.6mm; */

/*border:1px;
border-style:solid;
border-color:#FFFF00;
*/
}

.capa_pie
{
position:relative;
height:22mm; /* Antes: 26.5mm; */
/*
border:1px;
border-style:solid;
border-color:#33FF00;
*/
}

.logo_pie
{
width:195.8mm; /*740px 195.8mm*/
height:8.4mm; /*32px 8.4mm*/
/*
width:100%;
height:5%;
*/
}

body
{
margin-top:10px;
margin-bottom:0px;
}
-->
</style>
</head>

<body>
<?
//---------------------------------------------------------------------------------------------
//---------------------------- CABECERA -------------------------------------------------------
//---------------------------------------------------------------------------------------------
function cabecera()
{
global $cont,$lineas_pag,$nombre_cliente,$razon_social,$domicilio,$c_postal,$poblacion,$provincia,$nombre_cliente_corresp,$razon_social_corresp,$domicilio_corresp,$c_postal_corresp,$poblacion_corresp,$provincia_corresp,$nif_cif,$cod_empresa,$cod_factura,$fac_fecha,$cod_cliente,$num_pags,$carpeta,$logo, $nom_empresa, $emp_domicilio,$emp_c_postal,$emp_poblacion,$emp_provincia,$emp_nif_cif,$emp_telefono,$emp_fax,$emp_web,$emp_email, $cod_servicio, $fecha, $cod_tarifa , $vehiculo,
$matricula , $pto_asistencia, $hora_aviso, $hora_llegada, $suma_servidos;


// Aumentamos el contador de páginas:
$num_pags++;
?>
<div class="capa_cabecera">
<table>
  <tr <? echo $salto; ?>>
    <td width="1%" align="right">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
<?
if ($logo=="si")
{
$total_blancas=2;
?>
  <tr>
    <td height="40" align="right">&nbsp;</td>
    <td colspan="6" rowspan="2"><span class="clase_nombre_emp"><? echo $nom_empresa; ?></span> <br />
      <span class="clase_datos_emp"> <? echo $emp_domicilio; ?> <br />
      <? echo $emp_c_postal." ".$emp_poblacion." (".$emp_provincia.")"; ?> <br />
NIF: <? echo $emp_nif_cif; ?> Telf: <? echo $emp_telefono; ?>&nbsp;&nbsp;&nbsp;Fax: <? echo $emp_fax; ?> <br />
E-mail: <? echo $emp_email; ?>&nbsp;&nbsp;&nbsp;Web: <? echo $emp_web; ?> </span></td>
    <td colspan="6" rowspan="2" align="right"><img src="/<? echo $carpeta; ?>/imgs/logo_segu.gif" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="60" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de if

else if ($logo=="")
{
$total_blancas=8;
}

// Líneas blancas de relleno en la cabecera:
for ($blancas=0; $blancas <= $total_blancas; $blancas++)
{
?>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de for/**/
?>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="6"><strong><? echo $nombre_cliente; ?></strong></td>
    <td colspan="6"><strong><? echo $nombre_cliente_corresp; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="6"><? echo $razon_social; ?></td>
    <td colspan="6"><? echo $razon_social_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="6"><? echo substr($domicilio,0,50); ?></td>
    <td colspan="6"><? echo substr($domicilio_corresp,0,50); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="6"><? echo substr($domicilio,50,50); ?></td>
    <td colspan="6"><? echo substr($domicilio_corresp,50,50); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="6"><? echo $c_postal." ".$poblacion; ?></td>
    <td colspan="6"><? echo $c_postal_corresp." ".$poblacion_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="6"><? echo $provincia; ?></td>
    <td colspan="6"><? echo $provincia_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="12">N.I.F.: <? echo $nif_cif; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="12"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><div align="right"><strong>N&ordm; Factura</strong></div></td>
    <td colspan="2"><div align="right"><strong>Fecha</strong></div></td>
    <td><div align="right"><strong>N&ordm; Cliente</strong></div></td>
    <td><div align="right"><strong>P&aacute;gina </strong></div></td>
    <td colspan="7">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><div align="right"><? echo "($cod_empresa) $cod_factura"; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? echo $fac_fecha; ?></div></td>
    <td><div align="right"><? echo $cod_cliente; ?></div></td>
    <td><div align="right"><? echo $num_pags; ?></div></td>
    <td colspan="7"></td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td align="right"></td>
    <td colspan="12"><hr /></td>
    <td></td>
  </tr>
</table>
</div>
<?
} // Fin de function
//---------------------------------------------------------------------------------------------
//---------------------------- FIN DE: CABECERA -----------------------------------------------
//---------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------
//---------------------------- PIE ------------------------------------------------------------
//---------------------------------------------------------------------------------------------
function pie($accion)
{
global $dir_raiz,$carpeta, $logo, $nom_empresa,$emp_domicilio,$emp_c_postal,$emp_poblacion,$emp_provincia,$emp_nif_cif,$emp_telefono,$emp_fax,$emp_web,$emp_email,$observ_fact;

$salto_pag="style='page-break-after:always'";
if ($accion=="final")
	$salto_pag="";	
?>
<div class="capa_pie" <? echo $salto_pag; ?>>
<table>
  <tr>
    <td width="1%">&nbsp;</td>
    <td  width="98%" colspan="12">
<? if ($accion=="final") { ?>
<span style="font-size:10px; font-family:'Courier New', Courier, monospace">
<?
if ($observ_fact)
{
// Limitamos la descripción del trabajo realizado:
$lin_observ=5; // Líneas de observaciones.
$long_observ=120; // Longitud de las líneas de trabajo realizado.

for ($i=1; $i<=$lin_observ; $i++)
{
$fila_observ=substr($observ_fact, 0, $long_observ);

$observ[$i]=$fila_observ;
if (strpos($fila_observ, "\r\n")!==false)
{
$observ[$i]=substr($fila_observ, 0, strpos($fila_observ, "\r\n")+1);
}

$observ_fact=substr($observ_fact, strlen($observ[$i]));

echo $observ[$i];

//if ($i!=$lin_observ)
	echo "<br />";
} // Fin de for
} // Fin de if
?>
</span>
<br />
<div align="justify" style="font-size:8px;">
	<BR/>
Informamos que los datos personales que puedan constar en este documento, est&aacute;n incorporados en un fichero creado bajo nuestra responsabilidad, para gestionar nuestra relaci&oacute;n comercial. Puede ejercitar sus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n u oposici&oacute;n dirigi&eacute;ndose por escrito a: <? echo $nom_empresa; ?>, <? echo $emp_domicilio; ?>, <? echo $emp_c_postal." ".$emp_poblacion." (".$emp_provincia.")"; ?>. NIF: <? echo $emp_nif_cif; ?>
</div>
<? } ?>
	</td>
    <td width="1%">&nbsp;</td>
  </tr>
<?
$img_src="/$carpeta/imgs/logo_pie.jpg";
if ($logo=="si" && file_exists($dir_raiz.$img_src))
{
?>
  <tr>
    <td colspan="14"><img class="logo_pie" src="<? echo $img_src; ?>" /></td>
  </tr>
<? } ?>
</table>
</div>
<?
}
//---------------------------------------------------------------------------------------------
//---------------------------- FIN DE: PIE ----------------------------------------------------
//---------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------
//---------------------------- NUEVA PÁGINA ---------------------------------------------------
//---------------------------------------------------------------------------------------------
function nueva_pag()
{
global $cont;

$lineas_pag=19; // Líneas a mostrar por página.

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag)
{
$cont=1;
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">Contin&uacute;a en la p&aacute;gina siguiente...</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div class='capa_totales'></div>
<?
echo "";
pie("");
cabecera();
echo "<div class='capa_contenido'><table>";
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function
//---------------------------------------------------------------------------------------------
//---------------------------- FIN DE: NUEVA PÁGINA -------------------------------------------
//---------------------------------------------------------------------------------------------



$cod_empresa=$_GET["cod_empresa"];
$cod_factura_ini=$_GET["cod_factura_ini"];
$cod_factura_fin=$_GET["cod_factura_fin"];
$logo=$_GET["logo"];
$copias_pdf=$_GET["copias_pdf"];



if ($cod_factura_ini && $cod_factura_fin && $cod_empresa)
{
// Obtenemos datos de la empresa:
conectar_base($base_datos_conta);

$select_emp="SELECT * FROM empresas WHERE cod_empresa = '$cod_empresa'";
$query_select_emp=mysql_query($select_emp, $link) or die ("<br /> No se ha seleccionado empresa: ".mysql_error()."<br /> $select_emp <br />");

$emp=mysql_fetch_array($query_select_emp);

$nom_empresa=addslashes($emp["nom_empresa"]);
$emp_domicilio=addslashes($emp["domicilio"]);
$emp_c_postal=$emp["c_postal"];
$emp_poblacion=addslashes($emp["poblacion"]);
$emp_provincia=addslashes($emp["provincia"]);
$emp_nif_cif=$emp["nif_cif"];
$emp_telefono=$emp["telefono"];
$emp_fax=$emp["fax"];
$emp_web=$emp["web"];
$emp_email=$emp["email"];

conectar_base($base_datos);


// Seleccionamos facturas:
$select_fac="SELECT * FROM facturas WHERE cod_factura BETWEEN '$cod_factura_ini' AND '$cod_factura_fin' and cod_empresa = '$cod_empresa' and origen='S'";

$result_fac=mysql_query($select_fac, $link) or die ("<br /> No se han seleccionado facturas: ".mysql_error()."<br /> $select_fac <br />");
while($fac=mysql_fetch_array($result_fac))
{
$cod_factura=$fac["cod_factura"];

$cod_empresa=$fac["cod_empresa"];
$rectificado=$fac["rectificado"];
$motivo=$fac["motivo"];
$fac_fecha=fecha_esp($fac["fac_fecha"]);
$cod_cliente=$fac["cod_cliente"];
$nombre_cliente=$fac["nombre_cliente"];

$cod_forma=$fac["cod_forma"];
$forma_pago=sel_campo("descripcion","","formas_pago","cod_forma = '$cod_forma'");

$cod_tipo=$fac["cod_tipo"];
$tipo_pago=sel_campo("desc_tipo","","tipos_pago","cod_tipo = '$cod_tipo'");

$fac_total=$fac["fac_total"];

for ($i=1; $i<=$num_vencis; $i++) 
{
$venci[$i]=$fac["venci".$i];
$imp_venci[$i]=$fac["imp_venci".$i];
}

$fac_coste=$fac["fac_coste"];
$fac_bruto=$fac["fac_bruto"];
$gastos_finan=$fac["gastos_finan"];
$imp_gastos_finan=$fac["imp_gastos_finan"];
$descuento_pp=$fac["descuento_pp"];
$imp_descuento_pp=$fac["imp_descuento_pp"];
$fac_base=$fac["fac_base"];
$tipo_iva=$fac["tipo_iva"];
$fac_iva=$fac["fac_iva"];
$recargo_equiv=$fac["recargo_equiv"];
$imp_recargo_equiv=$fac["imp_recargo_equiv"];
$fac_total=$fac["fac_total"];

$observ_fact=$fac["observ_fact"];

// Obtenemos los datos del cliente de la tabla clientes:
$selec_cliente="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$consulta_cli=mysql_query($selec_cliente, $link) or die ("<br /> No se ha seleccionado cliente: ".mysql_error()."<br /> $selec_cliente <br />");
$fila=mysql_fetch_array($consulta_cli);

$razon_social=$fila["razon_social"];
$nif_cif=$fila["nif_cif"];

$domicilio=addslashes($fila["domicilio"]);
$c_postal=$fila["c_postal"];
$poblacion=addslashes($fila["poblacion"]);
$provincia=addslashes($fila["provincia"]);

$domicilio_corresp=addslashes($fila["domicilio_corresp"]);
$c_postal_corresp=$fila["c_postal_corresp"];
$poblacion_corresp=addslashes($fila["poblacion_corresp"]);
$provincia_corresp=addslashes($fila["provincia_corresp"]);

// Adapatamos datos de cliente:
datos_cli();

$telefono=$fila["telefono"];
$num_cuenta=$fila["num_cuenta"];
$copias_fac=$fila["copias_fac"];


// Si mostramos factura desde facturas copias o en pdf, creamos solamente una copia:
//echo "<br />pag_origen: '$pag_origen'<br />";
if (strpos($pag_origen, "1_1_fac_serv_crear.php")===false)
{
$copias_fac=1;
}

if ($copias_pdf!=0)
{
$copias_fac=$copias_pdf;
}


// Realizamos tantas copias como tiene en su ficha el cliente:
for ($c=1; $c <= $copias_fac; $c++)
{
$num_pags=0; // Contador de páginas impresas.
$cont=0; // Contador de líneas.
cabecera(); // Mostramos cabecera por primera vez.

?>
<div class="capa_contenido">
<table width="99%">
<?

// Si no es rectificativa, mostramos albaranes y articulos. En caso contrario mostramos el motivo:
if ($rectificado==0)
{
$orden="
SELECT *
FROM servicios
WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'
ORDER BY fecha,cod_servicio";
//echo "orden: $orden";

$query_orden=mysql_query($orden, $link) or die ("<br /> No se han seleccionado servicios de factura: ".mysql_error()."<br /> $orden <br />");

$alb=mysql_fetch_array($query_orden);

$cod_servicio=$alb["cod_servicio"];
$fecha=fecha_esp($alb["fecha"]);
$cod_tarifa=$alb["cod_tarifa"];
$vehiculo=$alb["vehiculo"];
$matricula=$alb["matricula"];
$pto_asistencia=$alb["pto_asistencia"];
$hora_aviso=$alb["hora_aviso"];
$hora_llegada=$alb["hora_llegada"];
$suma_servidos=$alb["suma_servidos"];

$cant_salida=$alb["cant_salida"];

$cant_hora=$alb["cant_hora"];
$cant_hora_espera=$alb["cant_hora_espera"];
$cant_cabestrany=$alb["cant_cabestrany"];
$cant_treballs_varis=$alb["cant_treballs_varis"];
$cant_kms=$alb["cant_kms"];
$cant_peajes=$alb["cant_peajes"];

$fuera_horas=$alb["fuera_horas"];
$festivos=$alb["festivos"];
$aseguradora=$alb["aseguradora"];

$tot_fuera_horas=$alb["tot_fuera_horas"];
$tot_festivos=$alb["tot_festivos"];
$tot_aseguradora=$alb["tot_aseguradora"];

$imp_fuera_horas=$alb["imp_fuera_horas"];
$imp_festivos=$alb["imp_festivos"];
$imp_aseguradora=$alb["imp_aseguradora"];

$tot_salida=$alb["tot_salida"];
$tot_hora=$alb["tot_hora"];
$tot_hora_espera=$alb["tot_hora_espera"];
$tot_cabestrany=$alb["tot_cabestrany"];
$tot_treballs_varis=$alb["tot_treballs_varis"];
$tot_kms=$alb["tot_kms"];
$tot_peajes=$alb["tot_peajes"];

$subtotal=$alb["subtotal"];

$select_tarifa="SELECT * FROM tarifas WHERE cod_tarifa = '$cod_tarifa'";

$query_tarifa=mysql_query($select_tarifa, $link) or die ("<br /> No se ha seleccionado tarifa: ".mysql_error()."<br /> $select_tarifa <br />");

$tar=mysql_fetch_array($query_tarifa);

$salida=$tar["salida"];
$hora=$tar["hora"];
$hora_espera=$tar["hora_espera"];
$cabestrany=$tar["cabestrany"];
$fuera_horas=$tar["fuera_horas"];
$kms=$tar["kms"];
$treballs_varis=$tar["treballs_varis"];
$peajes=$tar["peajes"];

/*
$cont+=13;
nueva_pag();*/
?>
  <tr>
    <td width="1%">&nbsp;</td>
    <td><strong>Servei</strong></td>
    <td><strong>Data</strong></td>
    <td width="7%"><strong>Vehicle</strong></td>
    <td width="13%">&nbsp;</td>
    <td colspan="2"><strong>Matr&iacute;cula</strong></td>
    <td colspan="8"><strong>Punt Ass.</strong></td>
    <td><strong>Hora Av&iacute;s</strong></td>
    <td colspan="2"><strong>Hora Arr.</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="17"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="7%"><? echo $cod_servicio; ?></td>
    <td><? echo $fecha; ?></td>
    <td colspan="2"><? echo $vehiculo; ?></td>
    <td colspan="2"><? echo $matricula; ?></td>
    <td colspan="8"><? echo $pto_asistencia; ?></td>
    <td><? echo substr($hora_aviso,0,5); ?></td>
    <td colspan="2"><? echo substr($hora_llegada,0,5); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><strong>Quan.</strong></td>
    <td width="9%"><div align="right"><strong>Preu</strong></div></td>
    <td width="1%">&nbsp;</td>
    <td width="14%"><div align="right"><strong>Import</strong></div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>SORTIDA</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_salida!=0) echo $cant_salida; ?></td>
    <td><div align="right"><? if($cant_salida!=0) echo $salida; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_salida!=0) echo $tot_salida; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>HORA</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_hora!=0) echo $cant_hora; ?></td>
    <td><div align="right"><? if($cant_hora!=0) echo $hora; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_hora!=0) echo $tot_hora; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>HORES D&acute; ESPERA </strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_hora_espera!=0) echo $cant_hora_espera; ?></td>
    <td><div align="right"><? if($cant_hora_espera!=0) echo $hora_espera; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_hora_espera!=0) echo $tot_hora_espera; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>SERVEI CABESTRANY </strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_cabestrany!=0) echo $cant_cabestrany; ?></td>
    <td><div align="right"><? if($cant_cabestrany!=0) echo $cabestrany; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_cabestrany!=0) echo $tot_cabestrany; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>QUIL&Ograve;METRES</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_kms!=0) echo $cant_kms; ?></td>
    <td><div align="right"><? if($cant_kms!=0) echo $kms; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_kms!=0) echo $tot_kms; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>TREBALLS VARIS </strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_treballs_varis!=0) echo $cant_treballs_varis; ?></td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $treballs_varis; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $tot_treballs_varis; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>PEATGES</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_peajes!=0) echo $cant_peajes; ?></td>
    <td><div align="right"><? if($cant_peajes!=0) echo $peajes; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_peajes!=0) echo $tot_peajes; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><div><strong>Concepte</strong></div></td>
    <td colspan="2" align="left"><div align="left"><strong>Quan.</strong></div></td>
    <td><div align="right"><strong>Preu</strong></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Import</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?

//} // Fin de if

//} // Fin de if ($rectificado==0)

// Obtenemos los artículos de ese albarán:
$orden_art="
SELECT cod_articulo,descr_art,cantidad,precio_venta,tipo_descuento,neto
FROM art_serv
WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'
ORDER BY cod_linea";

//echo "<b/>O:$orden_art";

$query_orden_art=mysql_query($orden_art, $link) or die ("<br /> No se han seleccionado artículos de servicios de factura: ".mysql_error()."<br /> $orden <br />");

while($art=mysql_fetch_array($query_orden_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];

$cantidad=$art["cantidad"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];
$neto=$art["neto"];


$cont++;
//cabecera();
?>
  <tr>
    <td></td>
    <td colspan="11"><? /*echo $ii." ";*/ ?><? echo $descr_art; ?></td>
    <td width="5%">&nbsp;</td>
    <td colspan="2"><? if ($cantidad!=0) {echo formatear($cantidad);} ?></td>
    <td><div align="right">
      <? if ($precio_venta!=0) {echo formatear($precio_venta);} ?>
    </div></td>
    <td>&nbsp;</td>
    <td align="right"><? if ($neto!=0) {echo formatear($neto);} ?></td>
    <td align="right">&nbsp;</td>
  </tr>
    
<?
//} // Fin de if
//} // Fin de for ($ii = 0; $ii < 4; $ii++)
} // Fin de while($alb=mysql_fetch_array($query_orden))

$cont++;
nueva_pag();
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="18">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Fora d'Hores </strong><? echo $tot_fuera_horas; ?>% <strong> sobre </strong><? echo $subtotal; ?></td>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo $imp_fuera_horas; ?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Festius </strong><? echo $tot_festivos; ?>% <strong> sobre </strong><? echo $subtotal; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo $imp_festivos; ?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Asseguradores/Tallers </strong><? echo "$tot_aseguradora"; ?>% <strong>sobre </strong><? $subtotal1=redondear($subtotal +  $imp_festivos + $imp_fuera_horas); echo formatear($subtotal1); ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo "-".$imp_aseguradora; ?></td>
    <td align="right">&nbsp;</td>
  </tr>
<?
} // Fin de if ($rectificado==0)
else
{
$cont++;
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="15"><strong>Motivo referente a Factura nº <? echo $rectificado; ?>:</strong> <? echo $motivo; ?></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
<?
} // Fin de else

// Rellenamos con líneas en blanco:
for ($i=$cont+1; $i <= $lineas_pag; $i++)
{
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="15"><? /*echo $i." ";*/ ?></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de for ($i=$cont; $i < $lineas_pag; $i++)
?>
</table>
</div>

<div class='capa_totales'>
<table>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="10%"><div align="right"><strong>Bruto</strong></div></td>
    <td width="15%" colspan="2"><div align="right"><strong>Gastos F. <? echo $gastos_finan."%"; ?></strong></div></td>
    <td width="15%" colspan="2"><div align="right"><strong>Dto. Pr. P. <? echo $descuento_pp."%"; ?></strong></div></td>
    <td width="14%" colspan="2"><div align="right"><strong>Base Imp. </strong></div></td>
    <td width="15%" colspan="2"><div align="right"><strong>I.V.A. <? echo $tipo_iva."%"; ?></strong></div></td>
    <td width="15%" colspan="2"><div align="right"><strong>Rec. E. <? echo $recargo_equiv."%"; ?></strong></div></td>
    <td width="14%"><div align="right"><strong>Total Factura</strong></div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right"><? echo formatear($fac_bruto); ?></div></td>
    <td colspan="2"><div align="right"><? echo formatear($imp_gastos_finan); ?>
    </div></td>
    <td colspan="2"><div align="right"><? echo formatear($imp_descuento_pp); ?></div></td>
    <td colspan="2"><div align="right"><? echo formatear($fac_base); ?></div></td>
    <td colspan="2"><div align="right"><? echo formatear($fac_iva); ?></div></td>
    <td colspan="2"><div align="right">
        <? echo formatear($imp_recargo_equiv); ?>
        </div></td>
    <td><div align="right"><strong><? echo formatear($fac_total); ?> &euro;</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Forma Pago:</strong></td>
    <td colspan="11"><? echo $forma_pago." ".$tipo_pago; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Vencimientos:</strong></td>
    <td colspan="11">
<?
for ($i=1; $i<=$num_vencis-2; $i++) 
{
if ($venci[$i]!=0)
	echo "<strong>".fecha_esp($venci[$i]).":&nbsp;</strong>".formatear($imp_venci[$i])."€&nbsp;";
} // Fin de for
?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="11">
<?
for ($i=$num_vencis-1; $i<=$num_vencis; $i++) 
{
if ($venci[$i]!=0)
	echo "<strong>".fecha_esp($venci[$i]).":&nbsp;</strong>".formatear($imp_venci[$i])."€&nbsp;";
} // Fin de for
?>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Dom. Banc.:</strong></td>
    <td colspan="11"><? echo $num_cuenta; ?></td>
    <td>&nbsp;</td>
  </tr>
<!--
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><hr /></td>
    <td>&nbsp;</td>
  </tr>
-->
</table>
</div>
<?
pie("final");
} // Fin de for ($c=1; $c <= $copias_fac; $c++)
} // Fin de while($fac=mysql_fetch_array($result_fac))
} // Fin de if ($cod_factura_ini && $cod_factura_fin && $cod_empresa)

else
{
echo "
<br />No se han recibido uno o más de los siguientes datos:
<br />cod_empresa: '$cod_empresa'
<br />cod_factura_ini: '$cod_factura_ini'
<br />cod_factura_fin: '$cod_factura_fin'
<br />origen: '$origen'
<br />";
} // Fin de else
?>
</body>
</html>