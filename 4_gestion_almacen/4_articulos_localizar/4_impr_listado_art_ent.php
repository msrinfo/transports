<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listado Art&iacute;culos en Entradas</title>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />



<? echo $archivos; ?>

<?
//$=$_GET[""];
$cod_articulo=$_GET["cod_articulo"];
$cod_art=$cod_articulo;
$cod_empresa=$_GET["cod_empresa"];
$descr_art=$_GET["descr_art"];
$descr_arti=$descr_art;
$cod_proveedor=$_GET["cod_proveedor"];
$cod_prov=$cod_proveedor;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$tipo_iva=$_GET["tipo_iva"];
$clasificacion=$_GET["clasificacion"];


// Si recibimos alguna variable de búsqueda, especificamos la consulta:
if ($cod_articulo || $descr_art || $cod_proveedor || $fecha_i || $fecha_f || $tipo_iva)
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

$articulo="";
// Si recibimos cod_articulo y/o descr_art:
if ($cod_articulo && $descr_art)
{
$articulo="and cod_articulo = '$cod_articulo' or descr_art like '%$descr_art%'";
}

if ($cod_articulo && !$descr_art)
{
$articulo="and cod_articulo = '$cod_articulo'";
}

if (!$cod_articulo && $descr_art)
{
$articulo="and descr_art like '%$descr_art%'";
}

// Variable que utilizaremos en la variable $periodo:
$where="and";

// Si no recibimos cliente, dejamos la variable vacía:
$cliente="WHERE cod_proveedor = '$cod_proveedor'";
if (!$cod_proveedor)
{
	$cliente="";
	// Si cliente está vacío, el contenido de la variable cambia:
	$where="WHERE";
}

// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i && $fecha_f)
	$periodo="$where fecha >= '$fecha_ini' and fecha <= '$fecha_fin'";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where fecha >= '$fecha_ini'";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where fecha <= '$fecha_fin'";
}

// Especificamos el valor de IVA:
$num_iva="";
if ($tipo_iva)
{
$num_iva="and tipo_iva = '$tipo_iva'";
if (!$cod_proveedor && !$fecha_i && !$fecha_f)
$num_iva="WHERE tipo_iva = '$tipo_iva'";
}

if ($cod_empresa)
{
	$empr="AND cod_empresa = '$cod_empresa'";
	$where="AND";
	
	conectar_base($base_datos_conta);
	
	$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa = '$cod_empresa'");
	
	conectar_base($base_datos);
}

// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
//if ($clasificacion=="CÓDIGO")
	$orden="cod_articulo,descr_art";

if ($clasificacion=="DESCRIPCIÓN")
	$orden="descr_art,cod_articulo";

// Especificamos la consulta: 
$entradas="SELECT cod_entrada FROM entradas $cliente $periodo $num_iva $empr";
$articulos="SELECT * FROM art_ent WHERE cod_entrada IN ($entradas) $articulo ORDER BY $orden";
$result_art=mysql_query($articulos, $link);
$total_filas = mysql_num_rows($result_art);
} // Fin de if ($cod_articulo || $descr_art || $cod_proveedor || $fecha_i || $fecha_f || $tipo_iva)

$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="12">LISTADO ART&Iacute;CULOS EN ENTRADAS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>Fecha Inicio: </strong><? echo "$fecha_i"; ?></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>Resultados: </strong><? echo "$total_filas"; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>Fecha Final:</strong> <? echo "$fecha_f"; ?></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="8%"><strong>Entrada</strong></td>
    <td width="8%"><strong>Fecha</strong></td>
    <td width="9%"><strong>Prov.</strong>.</td>
    <td width="13%"><strong>Art&iacute;culo</strong></td>
    <td width="22%"><strong>Descripci&oacute;n</strong></td>
    <td width="12%"><strong>Cantidad</strong></td>
    <td width="8%" align="right"><strong>Precio</strong></td>
    <td width="10%"><div align="right"><strong>Importe</strong></div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();

// Obtenemos la suma de los importes de los art&iacute;culos mostrados:
$suma_netos="SELECT SUM(neto) as total_importe FROM art_ent WHERE cod_entrada IN ($entradas) $articulo";
$consulta_netos=mysql_query($suma_netos, $link);
$total_importe=formatear(mysql_result($consulta_netos, 'total_importe'));

if ($result_art)
{
while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$precio=$art["precio"];
$neto=$art["neto"];
$cod_entrada=$art["cod_entrada"];

	$entradas="SELECT * FROM entradas WHERE cod_entrada = '$cod_entrada'";
	//echo "$entradas";
	$result_alb=mysql_query($entradas, $link);

	// Mientras no llegue al total de artiulos mostrados:
	// < $total_filas
	$alb=mysql_fetch_array($result_alb); //)
	//{
	$cod_entrada=$alb["cod_entrada"];
	$cod_empresa=$alb["cod_empresa"];
	$fecha=fecha_esp($alb["fecha"]);
	$cod_proveedor=$alb["cod_proveedor"];

$cont++;
cabecera();

?>
  <tr>
    <td>&nbsp;</td>
    <td><? echo "$cod_entrada"; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_proveedor"; ?></td>
    <td><? echo "$cod_articulo"; ?></td>
    <td><? echo "$descr_art"; ?></td>
    <td><? echo "$cantidad"; ?></td>
    <td align="right"><? echo "$precio"; ?></td>
    <td><div align="right"><? echo "$neto"; ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de while($alb=mysql_fetch_array($result_fact)
} // Fin de if ($result_fact)

$cont+=2;
cabecera();
?>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8" align="right"><strong>TOTAL IMPORTE: <? echo "$total_importe"; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
