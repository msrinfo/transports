<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resumen de Entradas</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
$cod_proveedor=$_GET["cod_proveedor"];
$cod_prov=$cod_proveedor;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$cod_empresa=$_GET["cod_empresa"];
$clasificacion=$_GET["clasificacion"];


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

// Especificamos el valor de IVA:
$num_iva="";
if ($cod_empresa)
{
$num_iva="and cod_empresa = '$cod_empresa'";
if (!$cod_proveedor && !$fecha_i && !$fecha_f)
$num_iva="WHERE cod_empresa = '$cod_empresa'";
}

// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
//if ($clasificacion=="CÓDIGO")
	$orden="cod_entrada,fecha,nombre_prov";

if ($clasificacion=="FECHA")
	$orden="fecha,cod_entrada,nombre_prov";

if ($clasificacion=="NOMBRE")
	$orden="nombre_prov,cod_entrada,fecha";

// Realizamso la consulta: 
$entradas="SELECT * FROM entradas $cliente $periodo $num_iva ORDER BY $orden";
//echo "$entradas";
$result_alb=mysql_query($entradas, $link);
$total_filas = mysql_num_rows($result_alb);
//} // Fin de if ($cod_proveedor || $fecha_i || $fecha_f || $cod_empresa)


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
    <td colspan="8">RESUMEN DE ENTRADAS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td>&nbsp;</td>
    <td align="right"><strong>Fecha inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><strong>Fecha Final: </strong><? echo "$fecha_f"; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
  </tr>
  <tr> 
    <td width="2%"></td>
    <td width="11%"><strong>Entrada</strong></td>
    <td width="13%"><strong>Fecha</strong></td>
    <td width="9%"><strong>Proveedor</strong></td>
    <td colspan="3"><strong>Nombre</strong></td>
    <td width="12%"><div align="right"><strong>Importe</strong></div></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
  </tr>
  <?
 $cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();

if ($result_alb)
{
while($alb=mysql_fetch_array($result_alb))
{
$cod_entrada=$alb["cod_entrada"];
$fecha=fecha_esp($alb["fecha"]);
$cod_proveedor=$alb["cod_proveedor"];
$nombre_prov=$alb["nombre_prov"];
$total=formatear($alb["total"]);

$total_importe+=$total;

$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td><? echo "$cod_entrada"; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_proveedor"; ?></td>
    <td colspan="3"><? echo "$nombre_prov"; ?></td>
    <td><div align="right"><? echo "$total"; ?></div></td>
  </tr>
  <?
}
}

$cont+=2;
cabecera();
?>
  <tr> 
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td width="43%"></td>
    <td width="4%"></td>
    <td width="6%"></td>
    <td></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
  </tr>
    <tr> 
    <td></td>
    <td colspan="7" align="right"><strong>Total Importe: <? echo formatear($total_importe); ?></strong></td>
  </tr>

</table>
</body>
</html>