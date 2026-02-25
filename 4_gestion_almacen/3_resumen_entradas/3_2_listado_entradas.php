<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de Entradas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_proveedor=$_GET["cod_proveedor"];
$cod_prov=$cod_proveedor;
$cod_empresa=$_GET["cod_empresa"];
$cod_emp=$cod_empresa;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$tipo_iva=$_GET["tipo_iva"];
$clasificacion=$_GET["clasificacion"];
$ver=$_GET["ver"];
}

if ($_POST)
{
$cod_proveedor=$_POST["cod_proveedor"];
$cod_prov=$cod_proveedor;
$cod_empresa=$_POST["cod_empresa"];
$cod_emp=$cod_empresa;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$tipo_iva=$_POST["tipo_iva"];
$clasificacion=$_POST["clasificacion"];
$ver=$_POST["ver"];
}


if ($cod_proveedor || $fecha_i || $fecha_f || $tipo_iva)
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);
// Variable que utilizaremos en la variable $periodo:
$where="and";
// Si no recibimos proveedor, dejamos la variable vacía:
$proveedor="WHERE cod_proveedor = '$cod_proveedor'";
if (!$cod_proveedor)
{
	$proveedor="";
	// Si proveedor está vacío, el contenido de la variable cambia:
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

$empr="AND cod_empresa = '$cod_empresa'";

//En principio la variable $facturado está vacía para mostrar todos los entradas, pero según lo que valga $ver, mostrará los entradas pendientes o facturados:
/*$facturado="";
if ($ver=="PENDIENTES")
{
	if (!$cod_proveedor && !$fecha_i && !$fecha_f && !$num_iva)
		$facturado="WHERE estado like ''";
	else
		$facturado="and estado like ''";
}

if ($ver=="FACTURADOS")
{
	if (!$cod_proveedor && !$fecha_i && !$fecha_f && !$num_iva)
		$facturado="WHERE estado like 'f'";
	else
		$facturado="and estado like 'f'";
}*/


// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
//if ($clasificacion=="CÓDIGO")
	$orden="cod_entrada,fecha,nombre_prov";

if ($clasificacion=="FECHA")
	$orden="fecha,cod_entrada,nombre_prov";

if ($clasificacion=="NOMBRE")
	$orden="nombre_prov,cod_entrada,fecha";


// Realizamos la consulta: 
$entradas="SELECT * FROM entradas $proveedor $periodo $num_iva $facturado $empr ORDER BY $orden";
//echo "$entradas";
$result_alb=mysql_query($entradas, $link);
} // Fin de if ($cod_proveedor || $fecha_i || $fecha_f || $tipo_iva)

// Número de filas:
$total_filas = mysql_num_rows($result_alb);

?>
</head>

<body>
<table>
<form name="resumen_ent" method="post" action="">
  <tr class="titulo"> 
       <td colspan="12">Resumen de Entradas</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td>&nbsp;</td>
    <td width="142" align="right"><strong>Fecha inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td width="47">&nbsp;</td>
    <td align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><strong>Fecha Final: </strong><? echo "$fecha_f"; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><hr /></td>
    </tr>
  <tr>
    <td width="53"><strong>Entrada</strong></td>
    <td width="100"><strong>Fecha</strong></td>
    <td width="72"><strong>Proveedor</strong></td>
    <td colspan="2"><strong>Nombre</strong></td>
    <td width="105"><div align="right"><strong>Importe</strong></div></td>
    </tr>
  <tr>
    <td colspan="6"><hr /></td>
    </tr>
  <tr>
<?
if($result_alb)
{
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$entradas="SELECT * FROM entradas $proveedor $periodo $num_iva $facturado $empr ORDER BY $orden $limit";
$result_ent=mysql_query($entradas, $link);

while($ent=mysql_fetch_array($result_ent))
{
// En caso de que sean movimientos:
$cod_entrada=$ent["cod_entrada"];
$cod_empresa=$ent["cod_empresa"];
$fecha=$ent["fecha"];
$cod_proveedor=$ent["cod_proveedor"];
$nombre_prov=$ent["nombre_prov"];
$total=formatear($ent["total"]);

$total_importe+=$total;
?>
	<td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/4_gestion_almacen/2_entradas_compras/1_entradas_compras.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_entrada','<? echo $cod_entrada; ?>', 'cod_proveedor','<? echo "$cod_proveedor"; ?>','','','','','','','','','','','','','','');"><? echo $cod_entrada; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_proveedor"; ?></td>
    <td colspan="2"><? echo "$nombre_prov"; ?></td>
    <td><div align="right"><? echo "$total"; ?></div></td>
    </tr>
  <? 
} // Fin while($ent=mysql_fetch_array($result_ent))
} // Fin if($result_alb)

// Rellenamos con filas:
paginar("rellenar");

?>
  <tr>
    <td colspan="6"><hr /></td>
    </tr>
  <tr>
    <td colspan="3">
<?
$campo_pag[1]="cod_proveedor"; $valor_pag[1]=$cod_prov;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="tipo_iva"; $valor_pag[4]=$tipo_iva;
$campo_pag[5]="clasificacion"; $valor_pag[5]=$clasificacion;
$campo_pag[6]="ver"; $valor_pag[6]=$ver;

// Paginamos:
paginar("paginar");
?>
    </td>
    <td colspan="3" align="right"><strong>Total Importe: <? echo formatear($total_importe); ?></strong></td>
    </tr>
  <tr>
    <td colspan="6">
	<div align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'3_3_impr_listado_ent.php','cod_proveedor','<? echo "$cod_prov"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','cod_empresa','<? echo "$cod_emp"; ?>','clasificacion','<? echo "$clasificacion"; ?>','','','','','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='3_1_resumen_entradas.php'">
    </div></td>
    </tr>
</form>
</table>
</body>
</html>