<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------

$cod_cliente='1592';
$cod_empresa='01';

if ($_GET)
{
//$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
$agrupado=$_GET["agrupado"];
$detallado=$_GET["detallado"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
//$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
$agrupado=$_POST["agrupado"];
$detallado=$_POST["detallado"];
$graf_concepto=$_POST["graf_concepto"];
}
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------

$graf_concepto='Total';

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
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


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
SELECT SUM(fac_bruto) as fac_bruto, SUM(imp_gastos_finan) as imp_gastos_finan, SUM(imp_descuento_pp) as imp_descuento_pp, SUM(fac_base) as fac_base, SUM(fac_iva) as fac_iva, SUM(imp_recargo_equiv) as imp_recargo_equiv, SUM(fac_total) as fac_total, fac_fecha 
FROM facturas 
$empres $cliente $periodo $estado
GROUP BY cod_cliente 
";
}

else
{
$facturas="
SELECT fac_bruto, imp_gastos_finan, imp_descuento_pp, fac_base, fac_iva, imp_recargo_equiv, fac_total, fac_fecha 
FROM facturas 
$empres $cliente $periodo $estado
";
}

//echo "<br />$facturas<br />";

$result_fact=mysql_query($facturas, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $facturas <br />");

$total_filas=mysql_num_rows($result_fact);

// Matrices para gráfica:
$inicio_mes[0]=$usuario_any."-01-01"; $fin_mes[0]=$usuario_any."-01-31";
$inicio_mes[1]=$usuario_any."-02-01"; $fin_mes[1]=$usuario_any."-02-29";
$inicio_mes[2]=$usuario_any."-03-01"; $fin_mes[2]=$usuario_any."-03-31";
$inicio_mes[3]=$usuario_any."-04-01"; $fin_mes[3]=$usuario_any."-04-30";
$inicio_mes[4]=$usuario_any."-05-01"; $fin_mes[4]=$usuario_any."-05-31";
$inicio_mes[5]=$usuario_any."-06-01"; $fin_mes[5]=$usuario_any."-06-30";
$inicio_mes[6]=$usuario_any."-07-01"; $fin_mes[6]=$usuario_any."-07-31";
$inicio_mes[7]=$usuario_any."-08-01"; $fin_mes[7]=$usuario_any."-08-31";
$inicio_mes[8]=$usuario_any."-09-01"; $fin_mes[8]=$usuario_any."-09-30";
$inicio_mes[9]=$usuario_any."-10-01"; $fin_mes[9]=$usuario_any."-10-31";
$inicio_mes[10]=$usuario_any."-11-01"; $fin_mes[10]=$usuario_any."-11-30";
$inicio_mes[11]=$usuario_any."-12-01"; $fin_mes[11]=$usuario_any."-12-31";

$graf_eje[0]="Ene";
$graf_eje[1]="Feb";
$graf_eje[2]="Mar";
$graf_eje[3]="Abr";
$graf_eje[4]="May";
$graf_eje[5]="Jun";
$graf_eje[6]="Jul";
$graf_eje[7]="Ago";
$graf_eje[8]="Sep";
$graf_eje[9]="Oct";
$graf_eje[10]="Nov";
$graf_eje[11]="Dic";

$mat_total=array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0, 9=>0, 10=>0, 11=>0);
$mat_bruto=array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0, 9=>0, 10=>0, 11=>0);
$mat_base=array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0, 9=>0, 10=>0, 11=>0);
$mat_iva=array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0, 9=>0, 10=>0, 11=>0);

while($total=mysql_fetch_array($result_fact))
{
$total_bruto += $total["fac_bruto"];
$total_gastos_finan += $total["imp_gastos_finan"];
$total_descuento_pp += $total["imp_descuento_pp"];
$total_base += $total["fac_base"];
$total_iva += $total["fac_iva"];
$total_recargo_equiv += $total["imp_recargo_equiv"];
$total_fac += $total["fac_total"];

$fac_fecha=$total["fac_fecha"];

// Obtención de valores para gráfica:
for ($i=0; $i < count($inicio_mes); $i++)
{
	if (comparar_fechas($fac_fecha,$inicio_mes[$i]) >= 0 && comparar_fechas($fac_fecha,$fin_mes[$i]) <= 0)
	{
	if ($graf_concepto=="Total")
		$mat_total[$i]+=$total["fac_total"];
	else if ($graf_concepto=="Bruto")
		$mat_bruto[$i]+=$total["fac_bruto"];
	else if ($graf_concepto=="Base Imp.")
		$mat_base[$i]+=$total["fac_base"];
	else if ($graf_concepto==$nombre_impuesto)
		$mat_iva[$i]+=$total["fac_iva"];
	
	break;
	} // Fin de if: comparar fechas.
} // Fin de for
} // Fin de while
?>
<script type="application/javascript" src="/charts/awesomechart.js"></script>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
   <tr class="titulo"> 
       <td colspan="13">Resumen de Facturas a Clientes <? echo $titulo; ?></td>
  </tr>
  <tr>
    <td width="8">&nbsp;</td>
    <td width="51">&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td width="248">&nbsp;</td>
    <td width="109">&nbsp;</td>
    <td width="67">&nbsp;</td>
    <td width="59">&nbsp;</td>
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
    <td><div align="right"><strong>Bruto</strong></div></td>
    <td><div align="right"><strong><? if($carpeta=="cp62") echo "Seg. Flete"; else { ?> G.Fin. <? } ?></strong></div></td>
    <td><div align="right"><strong>Dto.PP</strong></div></td>
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
// Limitamos la consulta:
$lineas_mostrar=10;

if ($agrupado=="si" && $detallado=="si")
{
$lineas_mostrar=10;
$adicionales=10;
}

$limit=paginar("limitar");

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
$limit";

$result_fact=mysql_query($facturas, $link) or die ("<br /> No se han seleccionado facturas: ".mysql_error()."<br /> $facturas <br />");


$cont=0;
$cod_client=0;
while($alb=mysql_fetch_array($result_fact))
{
$cod_factura=$alb["cod_factura"];
$cod_empresa=$alb["cod_empresa"];
$fac_fecha=$alb["fac_fecha"];
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
$empres $cliente $periodo and cod_cliente = '$cod_cliente'";

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
?>
  <tr bgcolor="#DDFFFF">
    <td bgcolor="#F4F8F1">&nbsp;</td>
    <td bgcolor="#F4F8F1">&nbsp;</td>
    <td bgcolor="#F4F8F1">&nbsp;</td>
    <td bgcolor="#F4F8F1"><? echo "<strong>".sprintf("%04s", $cod_cliente)."</strong>"." ".substr($nombre_cliente, 0, 25); ?></td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_bruto); ?></div></td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_gastos_finan);?></div></td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_descuento_pp); ?></div></td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_base); ?></div></td>
    <td bgcolor="#F4F8F1">&nbsp;</td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_iva); ?></div></td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_recargo_equiv); ?></div></td>
    <td bgcolor="#F4F8F1"><div align="right"><? echo formatear($cli_total); ?></div></td>
	<td bgcolor="#F4F8F1">&nbsp;</td>
  </tr>
<?
$cod_client=$cod_cliente;
} // Fin de if ($detallado=="si"...


$cont++;

// Decidimos el color de la fila según cont:
if ($cont % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;

// Establecemos nombre archivo impresión factura según carpeta:
if ($carpeta=="tt")
	$nom_arch_impr_fac="3_2_fac_alb_impr";
else
	$nom_arch_impr_fac="3_2_ver_fac";
?>
  <tr bgcolor="<? echo $color; ?>">
    <td></td>
    <td class="vinculo" onClick="mostrar(event,'/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/<? echo $nom_arch_impr_fac; ?>.php','cod_empresa','<? echo $cod_empresa; ?>','cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','','','','','','','','','','','','','','');"><? echo $cod_factura; ?></td>
    <td><? echo fecha_esp($fac_fecha); ?></td>
    <td><? if ($detallado!="si") {echo "<strong>".sprintf("%04s", $cod_cliente)."</strong>"." ".substr($nombre_cliente, 0, 25);} ?></td>
    <td><div align="right"><? echo formatear($fac_bruto); ?></div></td>
    <td><div align="right"><? echo formatear($imp_gastos_finan);?></div></td>
    <td><div align="right"><? echo formatear($imp_descuento_pp); ?></div></td>
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


// Rellenamos con filas:
paginar("rellenar");
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
    <td><div align="right"><strong><? echo formatear($total_bruto); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_gastos_finan); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_descuento_pp); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_base); ?></strong></div></td>
    <td colspan="2"><div align="right"><strong><? echo formatear($total_iva); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_recargo_equiv); ?></strong></div></td>
    <td><div align="right"><strong><? echo formatear($total_fac); ?></strong></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="11" align="left">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empr;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="fecha_ini"; $valor_pag[3]=$fecha_i;
$campo_pag[4]="fecha_fin"; $valor_pag[4]=$fecha_f;
$campo_pag[5]="clasificacion"; $valor_pag[5]=$clasificacion;
$campo_pag[6]="agrupado"; $valor_pag[6]=$agrupado;
$campo_pag[7]="detallado"; $valor_pag[7]=$detallado;
$campo_pag[8]="graf_concepto"; $valor_pag[8]=$graf_concepto;
$campo_pag[9]="estado"; $valor_pag[9]=$estado;


// Paginamos:
paginar("paginar");
?></td>
<td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="11" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'3_3_impr_listado_fact.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','<? echo $campo_pag[7]; ?>','<? echo $valor_pag[7]; ?>','','','','','','');">
      <input name="buscar" type="button" value="Nueva B&uacute;squeda" onClick="location.href='3_1_resumen_facturas.php?<? echo "agrupado=".$agrupado."&detallado=".$detallado; ?>'">&nbsp;
<input name="graf" type="button" value="Ver Gráfica" onClick="mostrar(event,'/<? echo $carpeta_comun; ?>/07_graf/01_grafica.html','','','','','','','','','','','','','','','','','','','','');">
<?
// Definimos variables necesarias para crear gráfica:
$graf['hori']=700;
$graf['vert']=600;
$graf['titu']=substr($nom_empresa, 0, 18)." ".$usuario_any."Resumen Facturas - ".$graf_concepto;
$graf['eje']=$graf_eje;
$graf['campo'][0]['nom']=$graf_concepto;

if ($graf_concepto=="Total")
{
$graf['campo'][0]['val']=$mat_total;
}
else if ($graf_concepto=="Bruto")
{
$graf['campo'][0]['val']=$mat_bruto;
}
else if ($graf_concepto=="Base Imp.")
{
$graf['campo'][0]['val']=$mat_base;
}
else if ($graf_concepto==$nombre_impuesto)
{
$graf['campo'][0]['val']=$mat_iva;
}

//var_dump($graf['campo'][0]['val']);

// Creamos gráficas:
mostrar_graf();
?>
	  </td>
	<td></td>
    </tr>
</form>
</table>
<script type="application/javascript">
graf_titulo = '<? echo substr($nom_empresa, 0, 18)." ".$usuario_any.": Resumen Fact. - ".$graf_concepto; ?>';
graf_columnas = ['<? echo implode("','", $graf_eje); ?>'];
graf_datos = [<? echo implode(',', $graf['campo'][0]['val']); ?>];
</script>
</body>
</html>