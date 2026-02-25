<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Albarans Desc&agrave;rregues</title>


<? echo $archivos; ?>
<link href="/comun/css/impresion_conta.css" rel="stylesheet" type="text/css" />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_descarga=$_GET["cod_descarga"];
$cod_desc=$cod_descarga;
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$clasificacion=$_GET["clasificacion"];
$poblacion=$_GET["poblacion"];
}

$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$descarg="";
if ($cod_descarga)
{
$descarg="$where cod_descarga = '$cod_descarga'";
$where="and";
}

if ($poblacion)
{
$descarg="$where descargas.poblacion like '%$poblacion%'";
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


// Si no recibimos fecha_descarga inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_descarga BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_descarga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_descarga <= '$fecha_fin')";

$where="and";
}


// En principio la variable $facturado está vacía para mostrar todos los albaranes, pero según lo que valga $ver, mostrará los albaranes pendientes o facturados:
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
	$orden="albaranes.cod_albaran,albaranes.fecha_descarga,albaranes.nombre_cliente"; 

else if ($clasificacion=="DATA") 
 	$orden="albaranes.fecha_descarga,albaranes.cod_albaran,albaranes.nombre_cliente"; 

else if ($clasificacion=="NOM")
	$orden="albaranes.nombre_cliente,albaranes.cod_albaran,albaranes.fecha_descarga";


// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes,descargas $cliente $descarg $empres $periodo $facturado $where albaranes.cod_descarga=descargas.cod_descarga";
//echo "<br />ALB: $albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>

</head>

<body>
<table width="98%">
  <tr>
    <td colspan="13"><div align="center"><strong>ALBARANS DESC&Agrave;RREGUES </strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" align="left"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="5" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
    <td width="7%" align="right">&nbsp;</td>
    <td width="7%" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="5" align="right"><strong>Data  inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="5" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="11"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="7%"><strong>Albar&agrave;</strong></td>
    <td width="9%"><strong>Data</strong></td>
    <td colspan="2"><strong>Client</strong></td>
    <td width="15%"><strong>Desc&agrave;rrega</strong></td>
    <td width="9%" align="right"><strong>Kms</strong></td>
    <td width="11%" align="right"><strong>Lts. Servits</strong></td>
    <td width="9%"><div align="right"><strong>Preu Client </strong></div></td>
    <td width="1%">&nbsp;</td>
    <td width="12%"><strong>Cond.</strong></td>
    <td width="11%"><strong>Tarj.</strong></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="11"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los albaranes mostrados:
$total_servidos=sel_campo("SUM(suma_servidos)","total_servidos","albaranes,descargas","$cliente $descarg $empres $periodo $facturado $where albaranes.cod_descarga=descargas.cod_descarga");
$total_preuclient=sel_campo("SUM(albaranes.precio_cli)","precio_cli","albaranes,descargas","$cliente $descarg $empres $periodo $facturado and albaranes.cod_descarga=descargas.cod_descarga");	

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

// calculamos kms totales	
$suma="SELECT albaranes.cod_albaran, albaranes.cod_descarga,albaranes.cod_empresa, SUM(descargas.total_kms) as suma_kms
FROM albaranes,descargas
$cliente $descarg $empres $periodo $facturado and albaranes.cod_descarga = descargas.cod_descarga ";
	
$result_sum=mysql_query($suma, $link);

while($albsuma=mysql_fetch_array($result_sum))
{
$suma_kms+=$albsuma["suma_kms"];
}	

$albaranes="SELECT * FROM albaranes,descargas $descarg $empres $periodo $facturado $where albaranes.cod_descarga=descargas.cod_descarga ORDER BY $orden";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$fecha_descarga=fecha_esp($ord["fecha_descarga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$cod_operario=$ord["cod_operario"];
$cod_tarjeta=$ord["cod_tarjeta"];
$base=$ord["base"];

$cod_descarga=$ord["cod_descarga"];

$precio_cli=$ord["precio_cli"];

$precio_cli=sel_campo("precio_cli","","albaranes","cod_albaran='$cod_albaran'");


$suma_servidos=$ord["suma_servidos"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
$total_kms=sel_campo("total_kms","","descargas","cod_descarga='$cod_descarga'");	
}

if($cod_operario)
{
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

if($cod_tarjeta)
{
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$mat2=sel_campo("mat2","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$matriculas=$mat1."-".$mat2;
}

?>
  <tr> 
    <td>&nbsp;</td>
    <td><? echo "$cod_albaran"; ?></td>
    <td><? echo "$fecha_descarga"; ?></td>
    <td colspan="2"><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
    <td><? echo "$poblacion"; ?></td>
    <td align="right"><? echo "$total_kms"; ?></td>
    <td align="right"><? echo "$suma_servidos"; ?></td>
    <td><div align="right"><? echo "$precio_cli"; ?></div></td>
    <td>&nbsp;</td>
    <td><? echo "$nombre_op"; ?></td>
    <td><? echo "$matriculas"; ?></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
} // Fin de if ($total_filas > 0)
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="11"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>Total Kms: <? echo formatear($suma_kms); ?></strong></td>
    <td align="right"><strong>Total Servits: <? echo formatear($total_servidos); ?></strong></td>
    <td align="right"><strong>Total Preu: <? echo formatear($total_preuclient); ?></strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>