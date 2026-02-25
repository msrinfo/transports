<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Localizar Art&iacute;culos en Entradas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_articulo=$_GET["cod_articulo"];
$cod_art=$cod_articulo;
$cod_empresa=$_GET["cod_empresa"];
$cod_emp=$cod_empresa;
$descr_art=$_GET["descr_art"];
$descr_arti=$descr_art;
$cod_proveedor=$_GET["cod_proveedor"];
$cod_prov=$cod_proveedor;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$tipo_iva=$_GET["tipo_iva"];
$clasificacion=$_GET["clasificacion"];
}

if ($_POST)
{
$cod_articulo=$_POST["cod_articulo"];
$cod_art=$cod_articulo;
$cod_empresa=$_POST["cod_empresa"];
$cod_emp=$cod_empresa;
$descr_art=$_POST["descr_art"];
$descr_arti=$descr_art;
$cod_proveedor=$_POST["cod_proveedor"];
$cod_prov=$cod_proveedor;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$tipo_iva=$_POST["tipo_iva"];
$clasificacion=$_POST["clasificacion"];
}

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

// Número de filas:

?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="4_listado_art_ent.php">
   <tr class="titulo"> 
       <td colspan="13">Localizar Art&iacute;culos en Entradas</td>
  </tr>
   <tr>
     <td></td>
     <td colspan="3" align="left"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
     <td align="right">&nbsp;</td>
     <td align="right">&nbsp;</td>
     <td align="right"><strong>Fecha Inicio: </strong><? echo "$fecha_i"; ?></td>
     <td align="right">&nbsp;</td>
     <td colspan="2" align="right"><strong>Resultados: <? echo "$total_filas"; ?></strong></td>
     <td></td>
   </tr>
   <tr>
    <td width="0%"></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>Fecha Final:</strong> <? echo "$fecha_f"; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td width="0%"></td>
  </tr>
   <tr>
     <td></td>
     <td colspan="9"><hr /></td>
     <td></td>
   </tr>
   <tr>
    <td></td>
    <td width="6%"><strong>Entrada</strong></td>
    <td width="6%"><strong>Fecha</strong></td>
    <td width="5%"><strong>Prov.</strong></td>
    <td width="18%"><strong>Nombre 
      Prov.</strong></td>
    <td width="8%"><strong>Art&iacute;culo </strong></td>
    <td width="22%"><strong>Descripci&oacute;n</strong></td>
    <td width="8%"><div align="right"><strong>Cantidad</strong></div></td>
    <td width="12%"><div align="right"><strong>Precio</strong></div></td>
    <td width="9%" align="right"><strong>Importe</strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="9"><hr /></td>
    <td></td>
  </tr>
<?
if ($result_art)
{
// Obtenemos la suma de los importes de los art&iacute;culos mostrados:
$suma_netos="SELECT SUM(neto) as total_importe FROM art_ent WHERE cod_entrada IN ($entradas) $articulo";
$consulta_netos=mysql_query($suma_netos, $link);
$total_importe=formatear(mysql_result($consulta_netos, 'total_importe'));
//echo "$total_importe";

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$articulos="SELECT * FROM art_ent WHERE cod_entrada IN ($entradas) $articulo ORDER BY $orden $limit";
$result_art=mysql_query($articulos, $link);


while($art=mysql_fetch_array($result_art))
{
$cod_entrada=$art["cod_entrada"];
$cod_articulo=$art["cod_articulo"];
$descr_art=substr($art["descr_art"], 0, 25);
$cantidad=$art["cantidad"];
$precio=$art["precio"];
$neto=$art["neto"];

	$entradas="SELECT * FROM entradas WHERE cod_entrada = '$cod_entrada'";
	$result_alb=mysql_query($entradas, $link);
	$alb=mysql_fetch_array($result_alb);
	
	$cod_entrada=$alb["cod_entrada"];
	$cod_empresa=$alb["cod_empresa"];
	$fecha=fecha_esp($alb["fecha"]);
	$cod_proveedor=$alb["cod_proveedor"];
	$nombre_prov=substr($alb["nombre_prov"], 0, 25);
?>
  <tr>
    <td></td>
	<td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/4_gestion_almacen/2_entradas_compras/1_entradas_compras.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_entrada','<? echo $cod_entrada; ?>', 'cod_proveedor','<? echo "$cod_proveedor"; ?>','','','','','','','','','','','','','','');"><? echo $cod_entrada; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_proveedor"; ?></td>
    <td><? echo "$nombre_prov"; ?></td>
    <td><? echo "$cod_articulo"; ?></td>
    <td><? echo "$descr_art"; ?></td>
    <td><div align="right"><? echo "$cantidad"; ?></div></td>
    <td><div align="right"><? echo "$precio"; ?></div></td>
    <td align="right"><? echo "$neto"; ?></td>
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
    <td colspan="9"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6">
<?
$campo_pag[1]="cod_proveedor"; $valor_pag[1]=$cod_prov;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="tipo_iva"; $valor_pag[4]=$tipo_iva;
$campo_pag[5]="clasificacion"; $valor_pag[5]=$clasificacion;
$campo_pag[6]="ver"; $valor_pag[6]=$ver;

// Paginamos:
paginar("paginar");
?>	</td>
    <td colspan="3"><div align="right"><strong>Total Importe: <? echo "$total_importe"; ?></strong></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="9" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'4_impr_listado_art_ent.php','cod_articulo','<? echo "$cod_art"; ?>','descr_art','<? echo "$descr_arti"; ?>','cod_proveedor','<? echo "$cod_prov"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','tipo_iva','<? echo "$tipo_iva"; ?>','clasificacion','<? echo "$clasificacion"; ?>','cod_empresa','<? echo "$cod_empresa"; ?>','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='4_articulos_localizar_ent.php'">	</td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>