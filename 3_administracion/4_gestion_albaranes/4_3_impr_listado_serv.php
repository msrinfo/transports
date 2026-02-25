<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resum de Serveis</title>


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


$where="WHERE";


// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";
if ($cod_cliente)
{
$cliente="$where cod_cliente = '$cod_cliente'";
$where="and";
}

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
$empres="$where cod_empresa = '$cod_empresa'";
conectar_base($base_datos_conta);
$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa = '$cod_empresa'");
conectar_base($base_datos);
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


// En principio la variable $facturado está vacía para mostrar todos los servicios, pero según lo que valga $ver, mostrará los servicios pendientes o facturados:
$facturado="";
if ($ver=="PENDENTS")
{
$facturado="$where estado like ''";
$where="and";
}
		
else if ($ver=="FACTURATS")
{
$facturado="$where estado like 'f'";
$where="and";
}


// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CODI")
	$orden="cod_servicio,fecha"; //nombre_cliente

else if ($clasificacion=="DATA") 
 	$orden="fecha,cod_servicio"; //nombre_cliente

else if ($clasificacion=="NOM")
	$orden="nombre_cliente,cod_servicio,fecha";


// Realizamos la consulta: 
$servicios="SELECT * FROM servicios $cliente $empres $periodo $facturado";
//echo "<br />$servicios";
$result_ord=mysql_query($servicios, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $servicios <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?></head>

<body>
<table width="712">
  <tr>
    <td colspan="9"><div align="center"><strong>RESUM DE SERVEIS </strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" align="left"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td align="right"><strong>Data  inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td colspan="2" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
    <td colspan="2" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="7"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="8%"><strong>Servei</strong></td>
    <td width="6%"><strong>Data</strong></td>
    <td width="8%"><strong>Client</strong></td>
    <td width="23%"><strong>Nom</strong></td>
    <td width="33%">&nbsp;</td>
    <td width="10%"><strong>Matr&iacute;cula</strong></td>
    <td width="10%"><div align="right"><strong>Import</strong></div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="7"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los servicios mostrados:
$total_importe=sel_campo("SUM(base)","total_importe","servicios","$cliente $empres $periodo $facturado");


$servicios="SELECT * FROM servicios $cliente $empres $periodo $facturado ORDER BY $orden";
//echo "<br />$servicios";
$result_ord=mysql_query($servicios, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $servicios <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_servicio=$ord["cod_servicio"];
$fecha=fecha_esp($ord["fecha"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$base=$ord["base"];
$matricula=$ord["matricula"];
?>
  <tr> 
    <td>&nbsp;</td>
    <td><? echo "$cod_servicio"; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_cliente"; ?></td>
    <td colspan="2"><? echo "$nombre_cliente"; ?></td>
    <td><? echo "$matricula"; ?></td>
    <td><div align="right"><? echo formatear($base); ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
} // Fin de if ($total_filas > 0)
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="7"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7" align="right"><strong>Total Import: <? echo formatear($total_importe); ?></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>