<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Historial de Ventas y Compras por Art&iacute;culos y Familias</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
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
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_articulo=$_POST["cod_articulo"];
$cod_art=$cod_articulo;
$descr_art=$_POST["descr_art"];
$descr_arti=$descr_art;
$cod_familia=$_POST["cod_familia"];
$cod_fam=$cod_familia;
$descripcion=$_POST["descripcion"]; // Descripción de la familia
$descr=$descripcion;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$tipo_iva=$_POST["tipo_iva"];
$clasificacion=$_POST["clasificacion"];
$ver=$_POST["ver"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN POST
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
	$titulo="Ventas"; 
	$titulo2="Cliente";  
	}

if ($ver=="COMPRAS")
	{
	$uni_ent_total=$uni_alb_total;
	$uni_alb_total="";
	$titulo="Compras"; 
	$titulo2="Proveedor";  
	}
	
if ($ver=="AMBAS")
	{
	$uni_ent_total=$uni_alb_total;
	$uni_alb_total=$uni_total-$uni_alb_total;
	$titulo="Ventas y Compras";  
	$titulo2="Cliente/Proveedor";  
	}

?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
  <tr class="titulo"> 
       <td colspan="12">Historial de <? echo "$titulo"; ?> por Art&iacute;culos y  Familias</td>
  </tr>
  <tr>
    <td width="7"></td>
    <td colspan="3"><strong>Ver:</strong> <? echo $ver; ?></td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Fecha Inicio: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td colspan="3"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td width="8"></td>
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
    <td></td>
    <td width="87"><strong>Fecha</strong></td>
    <td width="129"><strong>Art&iacute;culo</strong></td>
    <td width="181"><strong>Descripci&oacute;n</strong></td>
    <td width="43"><strong>Familia</strong></td>
    <td width="139"><strong><? echo "$titulo2"; ?></strong></td>
    <td width="56"><div align="right"><strong>Uds. Ord. </strong></div></td>
    <td width="57"><div align="right"><strong>Uds. Ent.</strong></div></td>
    <td width="83"><div align="right"><strong>P. Venta </strong></div></td>
    <td width="41"><div align="right"><strong>% Dto. </strong></div></td>
    <td width="92"><div align="right"><strong>Neto</strong></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10"><hr /></td>
    <td></td>
  </tr>
<?
if ($result_art)
{
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

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
ORDER BY e.fecha
$limit";
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

ORDER BY fecha
$limit";
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
?>
  <tr>
    <td></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_articulo"; ?></td>
    <td><? echo substr($descr_art, 0, 15); ?></td>
    <td><? echo "$cod_familia"; ?></td>
    <td><? echo $cod_cliente." ".substr($nombre_cliente, 0, 5); ?></td>
    <td><div align="right"><? if(is_numeric($cod_albaran)) echo "$cantidades"; ?></div></td>
    <td><div align="right"><? if(!is_numeric($cod_albaran)) echo "$cantidades";  ?></div></td>
    <td><div align="right"><? echo "$precio_venta"; ?></div></td>
    <td><div align="right"><? echo "$descuento"; ?></div></td>
    <td><div align="right"><? echo "$neto"; ?></div></td>
    <td></td>
  </tr>
  <?
}
} // Fin de if ($result_art)

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="10"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4">
<?
$campo_pag[1]="cod_familia"; $valor_pag[1]=$cod_fam;
$campo_pag[2]="descripcion"; $valor_pag[2]=$descr;
$campo_pag[3]="fecha_ini"; $valor_pag[3]=$fecha_i;
$campo_pag[4]="fecha_fin"; $valor_pag[4]=$fecha_f;
$campo_pag[5]="clasificacion"; $valor_pag[5]=$clasificacion;
$campo_pag[6]="cod_articulo"; $valor_pag[6]=$cod_articulo;
$campo_pag[7]="descr_art"; $valor_pag[7]=$descr_arti;
$campo_pag[8]="ver"; $valor_pag[8]=$ver;

// Paginamos:
paginar("paginar");
?></td>
    <td align="right"><strong>Totales:</strong></div></td>
    <td align="right"><strong><? echo "$uni_alb_total"; ?></strong></td>
    <td align="right"><strong><? echo "$uni_ent_total"; ?></strong></td>
    <td align="right"></td>
    <td align="right"></td>
    <td align="right"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'1_3_impr_listado_art_historial.php','cod_familia','<? echo "$cod_fam"; ?>','descripcion','<? echo "$descr"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','cod_articulo','<? echo "$cod_art"; ?>','descr_art','<? echo "$descr_arti"; ?>','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='1_1_art_historial.php'">    </td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>