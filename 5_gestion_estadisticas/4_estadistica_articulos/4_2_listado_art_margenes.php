<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Art&iacute;culos M&aacute;rgenes Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
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
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
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



// CLIENTE:
if ($cod_cliente)
	$cliente="and albaranes.cod_cliente = '$cod_cliente'";


// FAMILIA:
if ($cod_familia)
	$familia="and articulos.cod_familia = '$cod_familia'";


// ARTÍCULO:
if ($cod_articulo && $descr_art)
{
$familia="";

if ($cod_articulo)
	$articulo="and articulos.cod_articulo = '$cod_articulo'";
else if ($descr_art)
	$articulo="and articulos.descr_art like '%$descr_art%'";
}


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


// CLASIFICACIÓN:
if ($clasificacion=="Unidades Vendidas")
	$orden="art_alb.cantidad DESC, art_alb.cod_articulo DESC, art_alb.descr_art DESC";

else if ($clasificacion=="Beneficios")
	$orden="art_alb.beneficio DESC, art_alb.cod_articulo DESC, art_alb.descr_art DESC";


// Obtenemos total_filas y totales:
$articulos="SELECT COUNT(art_alb.cod_articulo) as total_filas, SUM(art_alb.neto) as suma_neto, SUM(art_alb.beneficio) as suma_beneficio, SUM(art_alb.margen) as suma_margen
FROM art_alb,albaranes,articulos
WHERE art_alb.cod_albaran = albaranes.cod_albaran and art_alb.cod_empresa = albaranes.cod_empresa and art_alb.cod_articulo = articulos.cod_articulo
$cliente $familia $articulo $periodo
GROUP BY art_alb.cod_articulo";

$result_art=mysql_query($articulos, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $articulos <br />");

while($res=mysql_fetch_array($result_art))
{
$total_filas += $res["total_filas"];
$suma_neto += $res["suma_beneficio"];
$suma_beneficio += $res["suma_beneficio"];
$suma_margen += $res["suma_margen"];
}


if ($suma_neto > 0)
	$total_margen = ($suma_beneficio / $suma_neto) * 100;
?>
</head>

<body>
<table>
<form name="resumen_benef" method="post" action="">
          <tr class="titulo">
            <td colspan="10">Art&iacute;culos M&aacute;rgenes Clientes</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2"><strong>Empresa: </strong><? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong>Fecha Inicio: </strong></div></td>
            <td><? echo $fecha_i; ?></td>
            <td colspan="2"><div align="right"><strong>Resultados:</strong> <? echo $total_filas; ?></div></td>
            <td>&nbsp;</td>
          </tr>
		    <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong>Fecha Final: </strong></div></td>
            <td><? echo $fecha_f; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="110"><strong>Art&iacute;culo</strong></td>
            <td width="354"><strong>Descripci&oacute;n</strong></td>
            <td width="44"><strong>Cliente</strong></td>
            <td width="65"><div align="right"><strong>Uds. 
                Vend</strong></div></td>
            <td width="95"><p align="right"><strong>Imp. 
                Coste</strong></td>
            <td width="99"><div align="right"><strong>Imp. 
                Venta </strong></div></td>
            <td width="98"><div align="right"><strong>Beneficio</strong></div></td>
            <td width="54"><div align="right"><strong>Margen</strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="8"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
$lineas_mostrar=15;
$limit=paginar("limitar");

$calc_art="SELECT art_alb.cod_articulo, art_alb.descr_art, albaranes.cod_cliente, SUM(art_alb.neto) as neto, SUM(art_alb.coste) as coste, SUM(art_alb.cantidad) as cantidad, SUM(art_alb.beneficio) as beneficio
FROM art_alb,albaranes,articulos
WHERE art_alb.cod_albaran = albaranes.cod_albaran and art_alb.cod_empresa = albaranes.cod_empresa and art_alb.cod_articulo = articulos.cod_articulo
$cliente $familia $articulo $periodo
GROUP BY cod_articulo
ORDER BY $orden
$limit";

$result_calc_art=mysql_query($calc_art, $link) or die ("<br /> No se han seleccionado artículos: ".mysql_error()."<br /> $calc_art <br />");

while($art=mysql_fetch_array($result_calc_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cod_cliente=$art["cod_cliente"];
$coste=$art["coste"];
$neto=$art["neto"];
$cantidad=$art["cantidad"];
$beneficio=$art["beneficio"];


if ($neto > 0)
	$margen = ($beneficio / $neto) * 100;
?>
          <tr> 
            <td>&nbsp;</td>
            <td><? echo $cod_articulo; ?></td>
            <td><? echo substr($descr_art, 0, 30); ?></td>
            <td><? echo $cod_cliente; ?></td>
            <td align="right"><? echo $cantidad; ?></td>
            <td align="right"><? echo formatear($coste); ?></td>
            <td><div align="right"><? echo formatear($neto); ?></div></td>
            <td><div align="right">
                <? echo formatear($beneficio); ?>
              </div></td>
            <td><div align="right"><? echo formatear($margen); ?></div></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de while($art=mysql_fetch_array($result_calc_art))


// Rellenamos con filas:
paginar("rellenar");
?>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="8"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="5">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="cod_articulo"; $valor_pag[3]=$cod_art;
$campo_pag[4]="descr_art"; $valor_pag[4]=$descr_arti;
$campo_pag[5]="cod_familia"; $valor_pag[5]=$cod_fam;
$campo_pag[6]="fecha_ini"; $valor_pag[6]=$fecha_i;
$campo_pag[7]="fecha_fin"; $valor_pag[7]=$fecha_f;
$campo_pag[8]="clasificacion"; $valor_pag[8]=$clasificacion;

// Paginamos:
paginar("paginar");
?>            </td>
            <td><div align="right"><strong>Totales: </strong></div></td>
            <td><div align="right"><strong><? echo formatear($suma_beneficio); ?></strong></div></td>
            <td><div align="right"><strong><? echo formatear($total_margen); ?></strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="8"><div align="center"> 
                <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'4_3_impr_art_margenes.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','<? echo $campo_pag[7]; ?>','<? echo $valor_pag[7]; ?>','<? echo $campo_pag[8]; ?>','<? echo $valor_pag[8]; ?>','','','','')">
                <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='4_1_art_margenes.php';">
              </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>