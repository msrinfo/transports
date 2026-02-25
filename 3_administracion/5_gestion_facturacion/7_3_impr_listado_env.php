<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resumen de &Oacute;rdenes a Clientes</title>


<? echo $archivos; ?>
<link href="/comun/css/impresion_conta.css" rel="stylesheet" type="text/css" />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$clasificacion=$_GET["clasificacion"];

}

	//echo $clasificacion;

$where="WHERE";


// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";
if ($cod_cliente)
{
$cliente="$where cod_cliente = '$cod_cliente'";
$where="and";
}


// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha <= '$fecha_fin')";

$where="and";
}


// En principio la variable $facturado está vacía para mostrar todos los albaranes, pero según lo que valga $ver, mostrará los albaranes pendientes o facturados:
$facturado="";
if ($ver=="OK")
{
$facturado="$where estado like 'OK'";
$where="and";
}
		
else if ($ver=="ERROR")
{
$facturado="$where estado like 'ERROR'";
$where="and";
}

	
$orden="fecha,hora";


// Realizamos la consulta: 
$albaranes="SELECT * FROM logs_envios $fact $cliente $empres $periodo $facturado";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");
// Número de filas:
$total_filas = mysql_num_rows($result_ord);

?>
</head>

<body>
<table>
  <tr>
    <td colspan="10"><div align="center"><strong>RESUMEN DE ENV&Iacute;O DE FACTURAS
    A CLIENTES</strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="left"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td align="right">&nbsp;</td>
    <td width="2%" align="right">&nbsp;</td>
    <td width="16%" align="right"><strong>Fecha inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td colspan="2" align="right"><strong>Resultados: <? echo "$total_filas"; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>Fecha Final: </strong><? echo "$fecha_f"; ?></td>
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
    <td width="8%"><strong>Usuario</strong></td>
    <td width="8%"><strong>Fecha</strong></td>
    <td width="8%"><strong>Hora</strong></td>
    <td width="32%"><strong>Cliente</strong></td>
    <td colspan="2"><strong>Env&iacute;o</strong></td>
    <td width="17%"><strong>Destinatario</strong></td>
    <td width="7%"><div align="right"><strong>Estado</strong></div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
if ($total_filas > 0)
{

$albaranes="SELECT * FROM logs_envios $fact $cliente $empres $periodo $facturado";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$login=$ord["login"];
$fecha=fecha_esp($ord["fecha"]);
$hora=$ord["hora"];	
$cod_cliente=$ord["cod_cliente"];
	 $nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente='$cod_cliente'");
$accion=$ord["accion"];
$destinatario=$ord["destinatario"];	
$estado=$ord["estado"];
?>
  <tr> 
    <td>&nbsp;</td>
    <td><? echo "$login"; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo $hora; ?></td>
    <td><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
    <td colspan="2"><? echo $accion; ?></td>
    <td><? echo $destinatario; ?></td>
    <td><div align="right"><? echo $estado; ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
} // Fin de if ($total_filas > 0)
?>
</table>
</body>
</html>