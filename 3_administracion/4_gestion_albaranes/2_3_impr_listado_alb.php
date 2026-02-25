<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resum d'Albarans</title>


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
$bomba=$_GET["bomba"];
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


if ($bomba=="SI")
{
$bomb="$where descarga_bomba = '1' ";
$where="and";
$descarga_bomba=1;
}
else if ($bomba=="NO")
{
$bomb="$where descarga_bomba = '' ";
$where="and";
}
else if ($bomba=="TOTS")
{
$bomb="";
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
	$orden="cod_albaran,fecha_descarga"; //nombre_cliente

else if ($clasificacion=="DATA") 
 	$orden="fecha_descarga,cod_albaran"; //nombre_cliente

else if ($clasificacion=="NOM")
	$orden="nombre_cliente,cod_albaran,fecha_descarga";


// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes $cliente $empres $periodo $bomb $facturado";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 8px;
	font-weight: bold;
}
.Estilo2 {font-size: 8px}
-->
</style>
</head>

<body>
<table width="95%">
  <tr>
    <td colspan="16"><div align="center"><strong>RESUM D'ALBARANS</strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" align="left"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="3" align="right"><strong>Data  inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td colspan="5" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="3" align="right">&nbsp;</td>
    <td colspan="3" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
    <td colspan="5" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="6%"><span class="Estilo1">Albar&agrave;</span></td>
    <td width="7%"><span class="Estilo1">Data</span></td>
    <td width="17%"><span class="Estilo1">Client</span></td>
    <td width="12%">&nbsp;</td>
    <td width="5%" align="right"><span class="Estilo1">Servits</span></td>
    <td width="6%" align="right"><span class="Estilo1">Preu Cli </span></td>
    <td width="5%" align="right"><span class="Estilo1">A Fact </span></td>
    <td width="6%" align="right" class="Estilo1">Lts. D.B </td>
    <td width="6%" align="right"><span class="Estilo1">Des.B.Cli</span></td>
    <td width="4%" align="right"><span class="Estilo1">DCCli</span></td>
    <td width="6%" align="right"><span class="Estilo1">DDesCli</span></td>
    <td width="5%" align="right"><span class="Estilo1">Hores</span></td>
    <td width="6%" align="right"><span class="Estilo1">Preu H</span></td>
    <td width="7%" align="right"><div align="right" class="Estilo1">Base</div></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los albaranes mostrados:
$total_importe=sel_campo("SUM(base)","total_importe","albaranes","$cliente $empres $periodo $bomb $facturado");


$albaranes="SELECT * FROM albaranes $cliente $empres $periodo $bomb $facturado ORDER BY $orden";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$fecha_descarga=fecha_esp($ord["fecha_descarga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$precio_cli=$ord["precio_cli"];

$cod_tarjeta=$ord["cod_tarjeta"];
$cod_tractora=$ord["cod_tractora"];
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$mat2=sel_campo("mat2","","tarjetas","cod_tractora='$cod_tractora'");


$suma_servidos=$ord["suma_servidos"];
$a_cobrar=$ord["a_cobrar"];
$lts_desc_bomba=$ord["lts_desc_bomba"];
$prec_desc_bomba_cli=$ord["prec_desc_bomba_cli"];
$prec_doble_carga_cli=$ord["prec_doble_carga_cli"];
$prec_doble_desc_cli=$ord["prec_doble_desc_cli"];

$horas_espera=$ord["horas_espera"];
$prec_horas_espera=$ord["prec_horas_espera"];

$base=$ord["base"];
?>
          <tr>
            <td>&nbsp;</td>
			 <td><span class="Estilo2"><? echo $cod_albaran; ?></span></td>
            <td><span class="Estilo2"><? echo "$fecha_descarga"; ?></span></td>
            <td><span class="Estilo2"><? echo "$cod_cliente"; ?></span><span class="Estilo2"> <? echo "$nombre_cliente"; ?></span></td>
            <td><span class="Estilo2"><? if($descarga_bomba=='1') echo "$cod_tarjeta $mat1 - $cod_tractora $mat2"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$suma_servidos"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$precio_cli"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$a_cobrar"; ?>&nbsp;</span></td>
            <td align="right"><span class="Estilo2"><? echo "$lts_desc_bomba"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$prec_desc_bomba_cli"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$prec_doble_carga_cli"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$prec_doble_desc_cli"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$horas_espera"; ?>&nbsp;</span></td>
            <td align="right"><span class="Estilo2"><? echo "$prec_horas_espera"; ?></span></td>
            <td align="right"><span class="Estilo2"><? echo "$base"; ?></span></td>
            <td align="right"><div align="right"></div></td>
          </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
} // Fin de if ($total_filas > 0)
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14" align="right"><strong>Total Import: <? echo formatear($total_importe); ?></strong></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>