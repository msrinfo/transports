<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Historial de Ventas y Compras por Art&iacute;culos y Familias</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
$cod_articulo=$_GET["cod_articulo"];
$cod_art=$cod_articulo;
$descr_art=$_GET["descr_art"];
$descr_arti=$descr_art;
$cod_familia=$_GET["cod_familia"];
$cod_fam=$cod_familia;
$descripcion=$_GET["descripcion"]; // Descripción de la familia
$descr=$descripcion;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$tipo_iva=$_GET["tipo_iva"];
$clasificacion=$_GET["clasificacion"];
$ver=$_GET["ver"];
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------

$where="WHERE";
// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
	
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);


if ($fecha_i && $fecha_f)
	$periodo="$where fecha >= '$fecha_ini' and fecha <= '$fecha_fin'";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where fecha >= '$fecha_ini'";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where fecha <= '$fecha_fin'";
}

$familia="";
// Si recibimos cod_familia y/o descr_art:
if ($cod_familia)
	$familia="and art.cod_familia = '$cod_familia'";

// Si recibimos cod_artículo, buscamos ese artículo:
if ($cod_articulo)
	{
		$artic="and aa.cod_articulo = '$cod_articulo'";
		$artic2="and ae.cod_articulo = '$cod_articulo'";
	}
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// Creamos las variables de búsqueda en las tablas albaranes y entradas:
$albaranes="SELECT cod_albaran FROM albaranes $periodo";
$entradas="SELECT cod_entrada FROM entradas $periodo";

// Dependiendo de lo que quieran visualizar, realizaremos una consulta u otra:
if ($ver=="VENTAS")
	{

	$articulos="SELECT COUNT(*) as total_filas, SUM(aa.cantidad) as uni_alb_total
FROM art_alb aa, albaranes a, articulos art
WHERE aa.cod_albaran=a.cod_albaran and aa.cod_articulo=art.cod_articulo and aa.cod_albaran IN ($albaranes) $familia $artic";
	}

if ($ver=="COMPRAS")
	{
	$articulos="SELECT COUNT(*) as total_filas, SUM(ae.cantidad) as uni_alb_total
FROM art_ent ae, entradas e, articulos art
WHERE ae.cod_entrada=e.cod_entrada and ae.cod_articulo=art.cod_articulo and ae.cod_entrada IN ($entradas) $familia $artic2";
	}

if ($ver=="AMBAS")
	{
	$articulos="SELECT COUNT(*) as total_filas, SUM(aa.cantidad) as uni_alb_total
FROM art_alb aa, albaranes a, articulos art
WHERE aa.cod_albaran=a.cod_albaran and aa.cod_articulo=art.cod_articulo and aa.cod_albaran IN ($albaranes) $familia $artic

UNION ALL

SELECT COUNT(*) as total_filas, SUM(ae.cantidad) as uni_alb_total
FROM art_ent ae, entradas e, articulos art
WHERE ae.cod_entrada=e.cod_entrada and ae.cod_articulo=art.cod_articulo and ae.cod_entrada IN ($entradas) $familia $artic2";
	}

//echo "<br />ARTICULOS CONTAR: $articulos <br />";

// Obtenemos el número de filas:
$result_art=mysql_query($articulos, $link);

while ($calc=mysql_fetch_array($result_art))
{
$total_filas+=$calc["total_filas"];

$uni_total+=$calc["uni_alb_total"];
$uni_alb_total=$calc["uni_alb_total"]; // Unidades de entradas.
}

if ($ver=="VENTAS")
	{ 
	$titulo="VENTAS"; 
	$titulo2="Cliente";  
	}

if ($ver=="COMPRAS")
	{
	$uni_ent_total=$uni_alb_total;
	$uni_alb_total="";
	$titulo="COMPRAS"; 
	$titulo2="Proveedor";  
	}
	
if ($ver=="AMBAS")
	{
	$uni_ent_total=$uni_alb_total;
	$uni_alb_total=$uni_total-$uni_alb_total;
	$titulo="VENTAS Y COMPRAS";  
	$titulo2="Cli./Prov.";  
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
global $cont,$lineas_pag,$total_filas,$titulo,$titulo2,$ver,$fecha_i,$fecha_f;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="12">HISTORIAL DE <? echo "$titulo"; ?> POR ART&Iacute;CULOS Y FAMILIAS</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"><strong>Ver:</strong> <? echo $ver; ?></td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Fecha Inicio: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td colspan="3"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Fecha Final: </strong></div></td>
    <td colspan="2"><? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%"></td>
    <td width="9%"><strong>Fecha</strong></td>
    <td width="15%"><strong>Art&iacute;culo</strong></td>
    <td><strong>Descripci&oacute;n</strong></td>
    <td width="4%"><strong>Fam.</strong></td>
    <td width="15%"><strong><? echo "$titulo2"; ?></strong></td>
    <td width="7%"><div align="right"><strong>Uds. Ord. </strong></div></td>
    <td width="7%"><div align="right"><strong>Uds. Ent. </strong></div></td>
    <td width="9%"><div align="right"><strong>P. Venta </strong></div></td>
    <td width="6%"><div align="right"><strong>% Dto. </strong></div></td>
    <td width="10%"><div align="right"><strong>Neto</strong></div></td>
    <td width="1%"></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
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
// Dependiendo de lo que quieran visualizar, realizaremos uan consulta u otra:
if ($ver=="VENTAS")
	{
	$articulos="SELECT a.cod_albaran, a.cod_empresa, a.fecha, aa.cod_articulo, aa.descr_art, art.cod_familia, a.cod_cliente, a.nombre_cliente, aa.cantidad, aa.precio_venta, aa.descuento, aa.neto
FROM art_alb aa, albaranes a, articulos art
WHERE aa.cod_albaran=a.cod_albaran and aa.cod_articulo=art.cod_articulo and aa.cod_albaran IN ($albaranes) $familia $artic
ORDER BY a.fecha
$limit";
	}

if ($ver=="COMPRAS")
	{	
	$articulos="SELECT e.cod_entrada, e.cod_empresa, e.fecha, ae.cod_articulo, ae.descr_art, art.cod_familia, e.cod_proveedor, e.nombre_prov as nombre_cliente, ae.cantidad, ae.precio as precio_venta, ae.descuento, ae.neto
FROM art_ent ae, entradas e, articulos art
WHERE ae.cod_entrada=e.cod_entrada and ae.cod_articulo=art.cod_articulo and ae.cod_entrada IN ($entradas) $familia $artic2
ORDER BY e.fecha";
	}

if ($ver=="AMBAS")
	{
	$articulos="SELECT a.cod_albaran, a.cod_empresa, a.fecha, aa.cod_articulo, aa.descr_art, art.cod_familia, a.cod_cliente, a.nombre_cliente, aa.cantidad, aa.precio_venta, aa.descuento, aa.neto
FROM art_alb aa, albaranes a, articulos art
WHERE aa.cod_albaran=a.cod_albaran and aa.cod_articulo=art.cod_articulo and aa.cod_albaran IN ($albaranes) $familia $artic

UNION ALL

SELECT e.cod_entrada,  e.cod_empresa, e.fecha, ae.cod_articulo, ae.descr_art, art.cod_familia, e.cod_proveedor, e.nombre_prov,  ae.cantidad, ae.precio, ae.descuento, ae.neto
FROM art_ent ae, entradas e, articulos art
WHERE ae.cod_entrada=e.cod_entrada and ae.cod_articulo=art.cod_articulo and ae.cod_entrada IN ($entradas) $familia $artic2

ORDER BY fecha";
	}
//echo "<br />ARTICULOS LISTAR: $articulos <br />";

$result_art=mysql_query($articulos, $link);

while($art=mysql_fetch_array($result_art))
{
$cod_albaran=$art["cod_albaran"];
$fecha=fecha_esp($art["fecha"]);
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cod_familia=$art["cod_familia"];
$cod_cliente=$art["cod_cliente"];
$nombre_cliente=$art["nombre_cliente"]; // Se utiliza para distinguir en "AMBAS" entre art_alb y art_ent.
$cod_proveedor=$art["cod_proveedor"]; // Se utiliza cuando recogemos el proveedor de compras.
$cantidades=$art["cantidad"];
$precio=$art["precio"];
$precio_venta=$art["precio_venta"];
$descuento=$art["descuento"];
$neto=$art["neto"];
/*
if ($ver=="COMPRAS")
{
$cantidad=$art["uniones"];
$uniones=$art["cantidad"]; // Unidades a mostrar.
}
// Calculamos las unidades totales:
$uni_alb_total+=$cantidad;
$uni_alb_total+=$uniones;
*/
if ($ver=="VENTAS")
{
$nombre_cliente=sel_campo("nombre_cliente","","albaranes","cod_albaran='$cod_albaran' and cod_cliente='$cod_cliente'");
//echo "CLI: $cod_cliente";
}

if ($ver=="COMPRAS")
{
$uniones=$art["uniones"]; // Unidades a mostrar.
$cod_cliente=$cod_proveedor;
}

if ($ver=="AMBAS")
{
	if ($cantidades!=0.00 && $uniones==0.00)
		{
		//$cantidad="--";
		$uniones="";
		}

	if ($cantidades==0.00 && $uniones!=0.00)
		{
		$cantidades="";
		//$uniones="--";
		}

	if ($cantidades==0.00 && $uniones==0.00)
		{
		$consulta_nombre="SELECT cod_proveedor FROM proveedores WHERE cod_proveedor = '$cod_cliente' and nombre_prov = '$nombre_cliente'";
		$result_nombre=mysql_query($consulta_nombre, $link);
		$nombre=mysql_num_rows($result_nombre);

		if ($nombre > 0)
			{
			$cantidades="";
			$uniones="--";
			}
		else
			{
			$cantidades="--";
			$uniones="";
			}
		} // Fin de if ($cantidad==0.00 && $uniones==0.00)
} // Fin de if ($ver=="AMBAS")


$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_articulo"; ?></td>
    <td><? echo substr($descr_art, 0, 15); ?></td>
    <td><? echo "$cod_familia"; ?></td>
    <td><? echo $cod_cliente." ".substr($nombre_cliente, 0, 5); ?></td>
    <td><div align="right"><? if(is_numeric($cod_albaran)) echo "$cantidades"; ?></div></td>
    <td><div align="right"><? if(!is_numeric($cod_albaran)) echo "$cantidades"; ?></div></td>
    <td><div align="right"><? echo "$precio_venta"; ?></div></td>
    <td><div align="right"><? echo "$descuento"; ?></div></td>
    <td><div align="right"><? echo "$neto"; ?></div></td>
    <td></td>
  </tr>
  <?
}
}

$cont+=2;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td></td>
    <td></td>
    <td></td>
    <td width="16%"></td>
    <td></td>
    <td align="right"><strong>TOTALES:</strong></td>
    <td align="right"><strong><? echo "$uni_alb_total"; ?></strong></td>
    <td align="right"><strong><? echo "$uni_ent_total"; ?></strong></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>