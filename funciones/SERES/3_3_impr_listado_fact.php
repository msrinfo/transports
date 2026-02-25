<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------

$cod_cliente='1592';
$cod_empresa='01';


if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
$agrupado=$_GET["agrupado"];
$detallado=$_GET["detallado"];
$estado=$_GET["estado"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------
// Título:
$titulo="";
if ($agrupado=="si")
	$titulo="S/T";
?>
<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de facturas a Clientes <? echo $titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
//echo "<br />detallado: $detallado<br />";

//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
// Empresa:
$cod_empr=$cod_empresa;
$empres="WHERE cod_empresa = '$cod_empresa'";

// Cliente:
$cliente="";
if ($cod_cliente)
	$cliente="AND cod_cliente = '$cod_cliente'";

// Periodo:
$periodo="";
if ($fecha_i || $fecha_f)
{
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="AND (fac_fecha >= '$fecha_ini' and fac_fecha <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="AND (fac_fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="AND (fac_fecha <= '$fecha_fin')";
} // Fin de periodo

$estado='AND estado="t"';


// Clasificación:
if ($clasificacion=="NOMBRE")
	$orden="nombre_cliente,fac_fecha";
else if ($clasificacion=="COD. CLI.")
	$orden="cod_cliente,nombre_cliente,fac_fecha";
else if ($clasificacion=="FECHA")
	$orden="fac_fecha,nombre_cliente";
else if ($clasificacion=="COD. FAC.")
	$orden="cod_factura,fac_fecha,nombre_cliente";

if ($agrupado=="si")
{
if ($clasificacion=="NOMBRE")
	$orden="nombre_cliente";
else if ($clasificacion=="COD. CLI.")
	$orden="cod_cliente";
}
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------

// Agrupado:
$mostrar="si";
if ($agrupado=="si" && $detallado=="no")
{
$mostrar="no";

$facturas="
SELECT SUM(fac_bruto) as fac_bruto, SUM(imp_gastos_finan) as imp_gastos_finan, SUM(imp_descuento_pp) as imp_descuento_pp, SUM(fac_base) as fac_base, SUM(fac_iva) as fac_iva, SUM(imp_recargo_equiv) as imp_recargo_equiv, SUM(fac_total) as fac_total 
FROM facturas 
$empres $cliente $periodo $estado
GROUP BY cod_cliente 
";
}

else
{
$facturas="
SELECT fac_bruto, imp_gastos_finan, imp_descuento_pp, fac_base, fac_iva, imp_recargo_equiv, fac_total
FROM facturas 
$empres $cliente $periodo $estado
";
}

//echo "<br />$facturas<br />";

$result_fact=mysql_query($facturas, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $facturas <br />");

$total_filas=mysql_num_rows($result_fact);

while($total=mysql_fetch_array($result_fact))
{
$total_bruto += $total["fac_bruto"];
$total_gastos_finan += $total["imp_gastos_finan"];
$total_descuento_pp += $total["imp_descuento_pp"];
$total_base += $total["fac_base"];
$total_iva += $total["fac_iva"];
$total_recargo_equiv += $total["imp_recargo_equiv"];
$total_fac += $total["fac_total"];
}


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f,$titulo;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="13">Resumen de Facturas a Clientes <? echo $titulo; ?></td>
  </tr>
  <tr>
    <td width="8">&nbsp;</td>
    <td width="51">&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td width="248">&nbsp;</td>
    <td width="109">&nbsp;</td>
    <td width="64">&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td width="36">&nbsp;</td>
    <td width="64">&nbsp;</td>
    <td width="61">&nbsp;</td>
    <td width="67">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Fecha inicial:</strong></div></td>
    <td><? echo $fecha_i; ?></td>
    <td colspan="4"><div align="right"><strong>Resultados:</strong> <? echo $total_filas; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
	<td colspan="2"><div align="right"><strong>Fecha Final:</strong></div></td>
	<td><? echo $fecha_f; ?></td>
	<td colspan="4">&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11"><hr /></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td><? if ($mostrar=="si") { ?><strong>Factura</strong><? } ?></td>
    <td><? if ($mostrar=="si") { ?><strong>Fecha</strong><? } ?></td>
    <td><strong>Cliente</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Bruto</strong></div></td>
    <td><div align="right"><strong>Base</strong></div></td>
    <td colspan="2"><div align="right"><strong><? echo $nombre_impuesto; ?></strong></div></td>
    <td><div align="right"><strong>R. Eq.</strong></div></td>
    <td><div align="right"><strong>Total</strong></div></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11"><hr /></td>
	<td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


if ($total_filas > 0)
{
// Agrupado:
if ($agrupado=="si" && $detallado=="no")
{
$facturas="
SELECT SUM(fac_bruto) as fac_bruto, SUM(imp_gastos_finan) as imp_gastos_finan, SUM(imp_descuento_pp) as imp_descuento_pp, SUM(fac_base) as fac_base, SUM(fac_iva) as fac_iva, SUM(imp_recargo_equiv) as imp_recargo_equiv, SUM(fac_total) as fac_total, cod_cliente, nombre_cliente 
FROM facturas 
$empres $cliente $periodo $estado
GROUP BY cod_cliente 
";
}

else
{
$facturas="
SELECT * 
FROM facturas 
$empres $cliente $periodo $estado
";
}

$facturas .= "
ORDER BY $orden 
";

$result_fact=mysql_query($facturas, $link) or die ("<br /> No se han seleccionado facturas: ".mysql_error()."<br /> $facturas <br />");

$cont=0;
$cod_client=0;
while($alb=mysql_fetch_array($result_fact))
{
$cod_factura=$alb["cod_factura"];
$cod_empresa=$alb["cod_empresa"];
$fecha=fecha_esp($alb["fac_fecha"]);
$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=$alb["nombre_cliente"];

$fac_bruto=$alb["fac_bruto"];

$gastos_finan=$alb["gastos_finan"];
$imp_gastos_finan=$alb["imp_gastos_finan"];

$descuento_pp=$alb["descuento_pp"];
$imp_descuento_pp=$alb["imp_descuento_pp"];

$fac_base=$alb["fac_base"];

$tipo_iva=$alb["tipo_iva"];
$fac_iva=$alb["fac_iva"];

$recargo_equiv=$alb["recargo_equiv"];
$imp_recargo_equiv=$alb["imp_recargo_equiv"];

$fac_total=$alb["fac_total"];


if ($agrupado=="si" && $detallado=="si" && $cod_client!=$cod_cliente)
{
$cli_fac="
SELECT SUM(fac_bruto) as cli_bruto, SUM(imp_gastos_finan) as cli_gastos_finan, SUM(imp_descuento_pp) as cli_descuento_pp, SUM(fac_base) as cli_base, SUM(fac_iva) as cli_iva, SUM(imp_recargo_equiv) as cli_recargo_equiv, SUM(fac_total) as cli_total 
FROM facturas 
$empres $cliente $periodo $estado and cod_cliente = '$cod_cliente'";

//echo "<br /> $cli_fac <br />";

$query_cli_compras=mysql_query($cli_fac, $link) or die ("No se han consultado facturas: ".mysql_error()."<br /> $cli_fac <br />");

while($cli=mysql_fetch_array($query_cli_compras))
{
$cli_bruto=$cli["cli_bruto"];
$cli_gastos_finan=$cli["cli_gastos_finan"];
$cli_descuento_pp=$cli["cli_descuento_pp"];
$cli_base=$cli["cli_base"];
$cli_iva=$cli["cli_iva"];
$cli_recargo_equiv=$cli["cli_recargo_equiv"];
$cli_total=$cli["cli_total"];
}

$cont++;
cabecera();
?>
  <tr bgcolor="#DDFFFF">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><? echo "<strong>".sprintf("%04s", $cod_cliente)."</strong>"." ".substr($nombre_cliente, 0, 30); ?></td>
    <td><div align="right"><? echo formatear($cli_bruto); ?></div></td>
    <td><div align="right"><? echo formatear($cli_base); ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? echo formatear($cli_iva); ?></div></td>
    <td><div align="right"><? echo formatear($cli_recargo_equiv); ?></div></td>
    <td><div align="right"><? echo formatear($cli_total); ?></div></td>
	<td>&nbsp;</td>
  </tr>
<?
$cod_client=$cod_cliente;
} // Fin de if ($detallado=="si"...


$cont++;
cabecera();
?>
  <tr>
    <td></td>
    <td class="vinculo" onClick="mostrar(event,'/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/2_1_facturas_ver.php','cod_empresa','<? echo $cod_empresa; ?>','cod_factura','<? echo $cod_factura; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_factura; ?></td>
    <td><? echo $fecha; ?></td>
    <td colspan="3"><? if ($detallado!="si") {echo "<strong>".sprintf("%04s", $cod_cliente)."</strong>"." ".substr($nombre_cliente, 0, 30);} ?></td>
    <td><div align="right"><? echo formatear($fac_bruto); ?></div></td>
    <td><div align="right"><? echo formatear($fac_base); ?></div></td>
    <td><div align="right"><? if ($mostrar=="si") {echo $tipo_iva."% ";} ?></div></td>
    <td><div align="right"><? echo formatear($fac_iva); ?></div></td>
    <td><div align="right"><? echo formatear($imp_recargo_equiv); ?></div></td>
    <td><div align="right"><? echo formatear($fac_total); ?></div></td>
	<td></td>
  </tr>
<?
} // Fin de while($alb=mysql_fetch_array($result_fact)
} // Fin de if ($result_fact)

$cont+=2;
cabecera();
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11"><hr /></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Totales:</strong></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong><? echo formatear($total_bruto); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_base); ?></strong></div></td>
    <td colspan="2"><div align="right"><strong><? echo formatear($total_iva); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_recargo_equiv); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_fac); ?></strong></div></td>
    <td></td>
  </tr>
</table>
</body>
</html>