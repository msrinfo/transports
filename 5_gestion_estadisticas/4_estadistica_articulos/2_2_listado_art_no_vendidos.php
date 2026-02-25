<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Art&iacute;culos No Vendidos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


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

if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$cod_articulo=$_POST["cod_articulo"];
$cod_art=$cod_articulo;
$descr_art=$_POST["descr_art"];
$descr_arti=$descr_art;
$cod_familia=$_POST["cod_familia"];
$cod_fam=$cod_familia;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
}


if ($cod_articulo)
	$articulo="and articulos.cod_articulo = '$cod_articulo'";
else if ($descr_art)
	$articulo="and articulos.descr_art like '%$descr_art%'";


if ($cod_familia)
	$familia="and familias.cod_familia = '$cod_familia'";
else if ($descripcion)
	$familia="and familias.descripcion like '%$descripcion%'";


// PERÍODO:
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
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
		  <tr class="titulo">
            <td colspan="9">Art&iacute;culos No Vendidos</td>
          </tr>
		  <tr>
            <td width="1">&nbsp;</td>
            <td colspan="2"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td width="100"><div align="right"><strong>Fecha Inicio: </strong></div></td>
            <td colspan="2"><? echo $fecha_i; ?></td>
            <td colspan="2"><div align="right"><strong>Resultados:</strong> <? echo $total_filas; ?></div></td>
            <td width="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong>Fecha Final: </strong></div></td>
            <td colspan="2"><? echo $fecha_f; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="126"><strong>Art&iacute;culo</strong></td>
            <td colspan="2"><strong>Descripci&oacute;n</strong></td>
            <td width="69">&nbsp;</td>
            <td width="78"><div align="right"><strong>Existencias</strong></div></td>
            <td width="93"><div align="right"><strong> 
                Precio Coste</strong></div></td>
            <td width="104"><div align="right"><strong>Imp. 
                Existencias </strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="7"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
if ($result_art)
{
$lineas_mostrar=15;
$limit=paginar("limitar");

$articulos="
SELECT articulos.cod_articulo,articulos.descr_art,articulos.existencias,articulos.precio_coste
FROM articulos,familias
WHERE articulos.cod_familia = familias.cod_familia
AND cod_articulo NOT IN ($articulos_ord)
$articulo $familia
ORDER BY $orden $limit";

$result_art=mysql_query($articulos, $link);

while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$existencias=$art["existencias"];
$precio_coste=$art["precio_coste"];

$importe = $existencias * $precio_coste;
?>
          <tr>
            <td>&nbsp;</td>
            <td><? echo $cod_articulo; ?></td>
            <td colspan="3"><? echo substr($descr_art, 0, 40); ?></td>
            <td><div align="right"><? echo $existencias; ?></div></td>
            <td><div align="right"><? echo formatear($precio_coste); ?></div></td>
            <td><div align="right"><? echo formatear($importe); ?></div></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de while($art=mysql_fetch_array($result_art))
} // Fin de if ($result_art)

// Rellenamos con filas:
paginar("rellenar");
?>
<tr>
  <td>&nbsp;</td>
  <td colspan="7"><hr /></td>
  <td>&nbsp;</td>
</tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_articulo"; $valor_pag[2]=$cod_art;
$campo_pag[3]="descr_art"; $valor_pag[3]=$descr_arti;
$campo_pag[4]="cod_familia"; $valor_pag[4]=$cod_fam;
$campo_pag[5]="fecha_ini"; $valor_pag[5]=$fecha_i;
$campo_pag[6]="fecha_fin"; $valor_pag[6]=$fecha_f;
$campo_pag[7]="clasificacion"; $valor_pag[7]=$clasificacion;

// Paginamos:
paginar("paginar");
?>            </td>
            <td><div align="right"><strong>Total:</strong></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong><? echo formatear($suma_coste); ?></strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="7"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'2_3_impr_listado_art_no_vendidos.php','cod_empresa','<? echo $cod_empresa; ?>','cod_articulo','<? echo $cod_art; ?>','descr_art','<? echo $descr_arti; ?>','cod_familia','<? echo $cod_fam; ?>','fecha_ini','<? echo $fecha_i; ?>','fecha_fin','<? echo $fecha_f; ?>','clasificacion','<? echo $clasificacion; ?>','','','','','','');">
              <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='2_1_art_no_vendidos.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>