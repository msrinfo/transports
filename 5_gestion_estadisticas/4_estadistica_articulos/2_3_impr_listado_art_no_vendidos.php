<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Art&iacute;culos No Vendidos</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_articulo=$_GET["cod_articulo"];
$cod_art=$cod_articulo;
$descr_art=$_GET["descr_art"];
$descr_arti=$descr_art;
$cod_familia=$_GET["cod_familia"];
$cod_fam=$cod_familia;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
}


if ($cod_articulo)
	$articulo="and articulos.cod_articulo = '$cod_articulo'";
else if ($descr_art)
	$articulo="and articulos.descr_art like '%$descr_art%'";


if ($cod_familia)
	$familia="and familias.cod_familia = '$cod_familia'";
else if ($descripcion)
	$familia="and familias.descripcion like '%$descripcion%'";


// Si no recibimos fecha inicial, dejamos la variable vacía
if ($fecha_i || $fecha_f)
{
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
	
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="and albaranes.fecha BETWEEN '$fecha_ini' AND '$fecha_fin'";
	
if ($fecha_i && !$fecha_f)
	$periodo="and albaranes.fecha >= '$fecha_ini'";
	
if (!$fecha_i && $fecha_f)
	$periodo="and albaranes.fecha <= '$fecha_fin'";
}

	
// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CÓDIGO")
	$orden="cod_articulo,descr_art";

if ($clasificacion=="DESCRIPCIÓN")
	$orden="descr_art,cod_articulo";


$articulos_ord="SELECT art_alb.cod_articulo 
FROM art_alb,albaranes
WHERE art_alb.cod_albaran = art_alb.cod_albaran and art_alb.cod_empresa = art_alb.cod_empresa $periodo";


// Obtenemos total_filas y totales:
$articulos="
SELECT articulos.existencias,articulos.precio_coste
FROM articulos,familias
WHERE articulos.cod_familia = familias.cod_familia
AND cod_articulo NOT IN ($articulos_ord)
$articulo $familia";

//echo "<br /> $articulos <br />";
$result_art=mysql_query($articulos, $link) or die ("<br /> No se han seleccionado artículos: ".mysql_error()."<br /> $articulos <br />");

$total_filas = mysql_num_rows($result_art);

while($calc=mysql_fetch_array($result_art))
{
$existencias=$calc["existencias"];
$precio_coste=$calc["precio_coste"];

$coste = $existencias * $precio_coste;

$suma_coste += $coste;
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
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="8">ART&Iacute;CULOS NO VENDIDOS</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="2"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td width="21%"><div align="right"><strong>Fecha Inicio: </strong></div></td>
    <td><? echo $fecha_i; ?></td>
    <td colspan="2"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="26%">&nbsp;</td>
    <td><div align="right"><strong>Fecha Final: </strong></div></td>
    <td><? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="17%"><strong>Art&iacute;culo</strong></td>
    <td colspan="2"><strong>Descripci&oacute;n</strong></td>
    <td width="11%"><div align="right"><strong>Existencias</strong></div></td>
    <td width="10%"> <div align="right"><strong> Precio Coste</strong></div></td>
    <td> <div align="right"><strong>Imp. Existencias</strong></div>
      <div align="right"></div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="6"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


if ($result_art)
{
$articulos="
SELECT articulos.cod_articulo,articulos.descr_art,articulos.existencias,articulos.precio_coste
FROM articulos,familias
WHERE articulos.cod_familia = familias.cod_familia
AND cod_articulo NOT IN ($articulos_ord)
$articulo $familia
ORDER BY $orden";

$result_art=mysql_query($articulos, $link);

while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$existencias=$art["existencias"];
$precio_coste=$art["precio_coste"];

$importe = $existencias * $precio_coste;


$cont++;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td><? echo $cod_articulo; ?></td>
    <td colspan="2"><? echo substr($descr_art, 0, 40); ?></td>
    <td><div align="right"><? echo $existencias; ?></div></td>
    <td><div align="right"><? echo formatear($precio_coste); ?></div></td>
    <td><div align="right"><? echo formatear($importe_coste); ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de while($art=mysql_fetch_array($result_art))
} // Fin de if ($result_art)

$cont+=2;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="6"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="3"><div align="right"><strong>Totales:</strong></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="13%"><div align="right"><strong><? echo formatear($suma_coste); ?></strong></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>