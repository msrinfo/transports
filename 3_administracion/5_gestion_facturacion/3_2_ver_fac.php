<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Factura impresa</title>


<? 
	//include $_SERVER['DOCUMENT_ROOT'].'/comun/00_funciones/01_comunes.php';
	echo $archivos; ?>
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
	border-color: blue;
/*border-color: white;*/

/**/
}

.capa_contenido
{
position:relative;
height:118mm; /* 410px; */

/*border:1px;
border-style:solid;
border-color:#FF0000;
/**/
}

.capa_totales
{
position:relative;

height:36mm; /* Antes:42.3mm; 160px; */

/*border:1px;
border-style:solid;
border-color:#FFFF00;
/**/
}

.capa_pie
{
position:relative;
height:22mm; /* Antes:19.4mm; 100px; */
	

/*border:1px;
border-style:solid;
border-color:#33FF00;
*/
}

.logo_pie
{
width:195.8mm; /*740px 195.8mm*/
height:8.4mm;	
/*width:740px;
height:32px;
	
/*width:195.8mm; /*740px 195.8mm*/
/*height:8.4mm; /*32px 8.4mm*/
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
global $cont,$lineas_pag,$nombre_cliente,$razon_social,$domicilio,$c_postal,$poblacion,$provincia,$nombre_cliente_corresp,$razon_social_corresp,$domicilio_corresp,$c_postal_corresp,$poblacion_corresp,$provincia_corresp,$nif_cif,$cod_empresa,$cod_factura,$fac_fecha,$cod_cliente,$num_pags,$carpeta,$logo,$nom_empresa,$emp_domicilio,$emp_c_postal,$emp_poblacion,$emp_provincia,$emp_nif_cif,$emp_telefono,$emp_fax,$emp_web,$emp_email, $base;

//echo "<br />base: $base_datos";

// Aumentamos el contador de páginas:
$num_pags++;
?>
<div class="capa_cabecera">
<table>
  <tr <? echo $salto; ?>>
    <td width="2%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
  </tr>
  <?
if ($logo=="si")
{
$total_blancas=2;
?>
  <tr>
    <td height="40">&nbsp;</td>
    <td colspan="4" rowspan="2"><span class="clase_nombre_emp"><? echo $nom_empresa; ?></span> <br />
      <span class="clase_datos_emp"> <? echo $emp_domicilio; ?> <br />
      <? echo $emp_c_postal." ".$emp_poblacion." (".$emp_provincia.")"; ?> <br />
      NIF: <? echo $emp_nif_cif; ?>  Telf: <? echo $emp_telefono; ?>&nbsp;&nbsp;&nbsp;Fax: <? echo $emp_fax; ?> <br />
E-mail: <? echo $emp_email; ?>&nbsp;&nbsp;&nbsp;Web: <? echo $emp_web; ?> </span></td>
    <td colspan="8" rowspan="2" align="right"><img src="/<? echo $carpeta; ?>/imgs/logo_segu.gif" style="width:256px; height:78px;" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="60">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de if

else if ($logo=="")
{
$total_blancas=4;
}

// Líneas blancas de relleno en la cabecera:
for ($blancas=1; $blancas <= $total_blancas; $blancas++)
{
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de for/**/
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5"><strong><? echo $nombre_cliente_corresp; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><strong><? echo $nombre_cliente; ?></strong></td>
    <td>&nbsp;</td>
    <td colspan="5"><? echo $razon_social_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><? echo $razon_social; ?></td>
    <td>&nbsp;</td>
    <td colspan="5"><? echo substr($domicilio_corresp,0,50); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><? echo substr($domicilio,0,50); ?></td>
    <td>&nbsp;</td>
    <td colspan="5"><? echo substr($domicilio_corresp,50,50); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><? echo substr($domicilio,50,50); ?></td>
    <td>&nbsp;</td>
    <td colspan="5"><? echo $c_postal_corresp." ".$poblacion_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><? echo $c_postal." ".$poblacion; ?></td>
    <td>&nbsp;</td>
    <td colspan="5"><? echo $provincia_corresp; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>N.I.F.: <? echo $nif_cif; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="right"><strong>N&ordm; Factura</strong></div></td>
    <td colspan="2"><div align="right"><strong>Fecha</strong></div></td>
    <td><div align="right"><strong>N&ordm; Cliente</strong></div></td>
    <td><div align="right"><strong>P&aacute;gina </strong></div></td>
    <td colspan="7">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right"><? echo "($cod_empresa) $cod_factura"; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? echo $fac_fecha; ?></div></td>
    <td><div align="right"><? echo $cod_cliente; ?></div></td>
    <td><div align="right"><? echo $num_pags; ?></div></td>
    <td colspan="7"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div><strong>C&oacute;digo</strong></div></td>
    <td>&nbsp;</td>
    <td colspan="6"><div><strong>Descripci&oacute;n</strong></div></td>
    <td><div align="right"><strong>Ud.</strong></div></td>
    <td><div align="right"><strong>PVP</strong></div></td>
    <td><div align="right"></div></td>
    <td><div align="right"><strong>Importe</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><hr /></td>
    <td>&nbsp;</td>
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
    <td width="5%">&nbsp;</td>
    <td colspan="12" align="center">
      <? if ($accion=="final") { ?>
<span style="font-size:10px; font-family:'Courier New', Courier, monospace;">
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
Informamos que los datos personales que puedan constar en este documento, est&aacute;n incorporados en un fichero creado bajo nuestra responsabilidad, para gestionar nuestra relaci&oacute;n comercial. Puede ejercitar sus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n u oposici&oacute;n dirigi&eacute;ndose por escrito a: <? echo $nom_empresa; ?>, <? echo $emp_domicilio; ?>, <? echo $emp_c_postal." ".$emp_poblacion." (".$emp_provincia.")"; ?>. NIF: <? echo $emp_nif_cif; ?>
</div>
<? } ?>
      </td>
    <td width="4%">&nbsp;</td>
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

$lineas_pag=20; // Líneas a mostrar por página.

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
//echo "<br />EMP: $cod_empresa<br />INI: $cod_factura_ini<br />FIN: $cod_factura_fin<br />base_datos_conta: $base_datos_conta";



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
$select_fac="SELECT * FROM facturas WHERE cod_factura BETWEEN '$cod_factura_ini' AND '$cod_factura_fin' and cod_empresa = '$cod_empresa' and origen='A'";

// Si mostramos una factura rectificativa no miramos si el origen es albaran o servicio:
if ($cod_factura_ini>=500000 && $cod_factura_fin>=500000)
	$select_fac="SELECT * FROM facturas WHERE cod_factura BETWEEN '$cod_factura_ini' AND '$cod_factura_fin' and cod_empresa = '$cod_empresa'";


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
if (strpos($pag_origen, "1_1_fac_alb_crear.php")===false)
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
<table>
<?

// Si no es rectificativa, mostramos albaranes y articulos. En caso contrario mostramos el motivo:
if ($rectificado==0)
{
$orden="
SELECT *
FROM albaranes
WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'
ORDER BY fecha,cod_albaran";

$query_orden=mysql_query($orden, $link) or die ("<br /> No se han seleccionado albaranes de factura: ".mysql_error()."<br /> $orden <br />");

while($alb=mysql_fetch_array($query_orden))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_descarga=fecha_esp($alb["fecha_descarga"]);
$cod_descarga=$alb["cod_descarga"];
$a_cobrar=$alb["a_cobrar"];
$base=$alb["base"];

$poblacion_desc=sel_campo("poblacion","","descargas","cod_descarga = '$cod_descarga'");
//$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga = '$cod_descarga'");
$precio_cli=$alb["precio_cli"];

// LITROS SERVIDOS:
$suma_servidos=$alb["suma_servidos"];
$serv_redon=$alb["serv_redon"];

if($a_cobrar=="1")
{
$total_servidos=$base;
}
else
{
//$total_servidos=$suma_servidos;
$total_servidos = redondear($suma_servidos * $precio_cli);
}


// LITROS BOMBA:
$lts_desc_bomba=$alb["lts_desc_bomba"];
$prec_desc_bomba_cli=$alb["prec_desc_bomba_cli"];
$total_bomba = redondear($lts_desc_bomba * $prec_desc_bomba_cli);

// DOBLE CARGA:
$prec_doble_carga_cli=$alb["prec_doble_carga_cli"];

// DOBLE DESCARGA:
$prec_doble_desc_cli=$alb["prec_doble_desc_cli"];

// HORAS ESPERA
$horas_espera=$alb["horas_espera"];
$prec_horas_espera=$alb["prec_horas_espera"];
$observ_horas_espera=$alb["observ_horas_espera"];

$cont++;
nueva_pag();
?>
  <tr>
    <td width="2%">&nbsp;</td>
    <td colspan="2"><strong><? /*echo $cont." ";*/ echo "Albarà Nº $cod_albaran amb data $fecha_descarga &nbsp;&nbsp;&nbsp;"; // .strtoupper($poblacion_desc) ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="11%"><div align="right"><strong><? if ($base!=0) {echo formatear($base);} ?></strong></div></td>
    <td width="4%">&nbsp;</td>
  </tr>
<?


// Mostramos líneas de aquellos conceptos que deban aparecer:
for ($ii = 0; $ii < 5; $ii++)
{

if (($ii == 0 && $suma_servidos > 0) || ($ii == 1 && $lts_desc_bomba > 0) || ($ii == 2 && $prec_doble_carga_cli > 0) || ($ii == 3 && $prec_doble_desc_cli > 0) || ($ii == 4 && $horas_espera!=0))
{

if ($ii == 0)
{
$descrip=strtoupper($poblacion_desc);
$cantidad=$suma_servidos;

if($a_cobrar=="1")
{
	$cantidad=1;
}		
else if($serv_redon!=0)
{
	$cantidad=$serv_redon;
}
		
$precio=$precio_cli;
//$importe=$base;
$importe=redondear($cantidad*$precio);
$cont++;
}
else if ($ii == 1)
{
$descrip="TOTAL LITRES AMB BOMBA";
$cantidad=$lts_desc_bomba;
$precio=$prec_desc_bomba_cli;
$importe=$total_bomba;
$cont++;
}
else if ($ii == 2)
{
$descrip="DOBLE CÀRREGA";
$cantidad="";
$precio="";
$importe=$prec_doble_carga_cli;
$cont++;
}
else if ($ii == 3)
{
$descrip="DOBLE DESCÀRREGA";
$cantidad="";
$precio="";
$importe=$prec_doble_desc_cli;
$cont++;
}
else if ($ii == 4)
{
$descrip=$observ_horas_espera; //"HORES ESPERA"." ".
$cantidad=$horas_espera;
$precio=$prec_horas_espera;
$importe=$horas_espera*$prec_horas_espera;
$cont++;
}

/**/
//$cont++;
nueva_pag();
?>
  <tr>
    <td></td>
    <td width="35%"><? /*echo $ii." "; */?><? echo $descrip; ?></td>
    <td width="35%"><div align="right"><? if ($cantidad!=0) {echo $cantidad;} ?></div></td>
    <td width="9%"><div align="right"><? if ($precio!=0) {echo $precio;} ?></div></td>
    <td width="4%">&nbsp;</td>
    <td><div align="right"><? if ($importe!=0) {echo formatear($importe); } ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de if
} // Fin de for ($ii = 0; $ii < 4; $ii++)
} // Fin de while($alb=mysql_fetch_array($query_orden))
} // Fin de if ($rectificado==0)

else
{
$cont++;
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"><strong>Motivo referente a Factura nº <? echo $rectificado; ?>:</strong> <? echo $motivo; ?></td>
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
    <td colspan="5"><? /*echo $i." ";*/ ?></td>
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
    <td width="2%">&nbsp;</td>
    <td colspan="9">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td width="14%" align="left"><div align="left"><? echo formatear($fac_bruto); ?></div></td>
    <td width="8%"><div align="right"><? echo formatear($imp_descuento_pp); ?></div></td>
    <td width="13%"><div align="right"></div></td>
    <td width="12%"><div align="right"><? echo formatear($fac_base); ?></div></td>
    <td colspan="2"><div align="right"><? echo "$tipo_iva%"; ?> <? echo formatear($fac_iva); ?></div></td>
    <td colspan="2"><div align="right"></div></td>
    <td width="11%"><div align="left"><strong><? echo formatear($fac_total); ?> &euro;</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="9">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Forma Pago:</strong></td>
    <td colspan="2"><? echo $forma_pago." ".$tipo_pago; ?></td>
    <td colspan="3"><strong>Dom. Banc.:</strong> <? echo $num_cuenta; ?></td>
    <td width="6%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Vencimientos:</strong></td>
    <td colspan="8">
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
    <td colspan="8">
<?
for ($i=$num_vencis-1; $i<=$num_vencis; $i++) 
{
if ($venci[$i]!=0)
	echo "<strong>".fecha_esp($venci[$i]).":&nbsp;</strong>".formatear($imp_venci[$i])."€&nbsp;";
} // Fin de for
?>    </td>
    <td>&nbsp;</td>
  </tr>
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