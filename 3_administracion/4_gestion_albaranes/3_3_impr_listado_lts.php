<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resum de Llitres</title>


<? echo $archivos; ?>
<link href="/comun/css/impresion_conta.css" rel="stylesheet" type="text/css" />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_tarjeta=$_GET["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_GET["cod_tractora"];
$cod_tra=$cod_tractora;
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$ver_serv=$_GET["ver_serv"];
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

if ($cod_tarjeta)
{
$tarjeta="$where cod_tarjeta = '$cod_tarjeta'";
$where="and";
}

if ($cod_tractora)
{
$tractora="$where cod_tractora = '$cod_tractora'";
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
	$periodo="$where (fecha_carga BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_carga <= '$fecha_fin')";

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

if ($ver_serv=="DEMANATS")
{
$titulo="Lts. Demanats";
}
		
else if ($ver_serv=="SERVITS")
{
$titulo="Lts. Servits";
}


// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CODI")
	$orden="cod_albaran,fecha_carga"; //nombre_cliente

else if ($clasificacion=="DATA") 
 	$orden="fecha_carga,cod_albaran"; //nombre_cliente

else if ($clasificacion=="NOM")
	$orden="nombre_cliente,cod_albaran,fecha_carga";


// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes $cliente $tarjeta $tractora $empres $periodo $facturado";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>
<style type="text/css">
<!--
.Estilo2 {font-size: 8px}
-->
</style>
</head>

<body>
<table width="740">
  <tr>
    <td colspan="18"><div align="center"><strong>RESUM DE LLITRES <? echo "$ver_serv"; ?></strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" align="left"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td align="left">&nbsp;</td>
    <td colspan="4" align="right"><strong>Data  inicial:</strong> <? echo "$fecha_i"; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="3" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="4" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="17"><hr /></td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="9%" class="Estilo2"><strong>Client</strong></td>
    <td width="8%" class="Estilo2"><strong>Pobl.</strong></td>
    <td width="5%" class="Estilo2"><strong>Tarj.</strong></td>
    <td width="7%" class="Estilo2"><strong>Cond.</strong></td>
    <td width="6%" class="Estilo2"><strong>Ope.</strong></td>
    <td width="7%" class="Estilo2"><strong>Ter.</strong></td>
    <td width="5%" align="right" class="Estilo2"><strong>ADITIVAT</strong>
    </td><td width="5%" align="right" class="Estilo2"><strong>SP95</strong></td>
    <td width="5%" align="right" class="Estilo2"><strong>SP98</strong></td>
    <td width="6%" align="right" class="Estilo2"><strong>GO A</strong></td>
    <td width="5%" align="right" class="Estilo2"><strong>B1000 </strong></td>
    <td width="6%" align="right" class="Estilo2"><strong>GO B</strong></td>
    <td width="4%" align="right" class="Estilo2"><strong>GO C</strong></td>
    <td width="4%" align="right" class="Estilo2"><strong>BIO</strong></td>
    <td width="6%" align="right" class="Estilo2"><strong>N&ordm; Com</strong> </td>
    <td width="6%" align="right" class="Estilo2"><strong>Franja</strong></td>
    <td width="5%" align="right" class="Estilo2"><strong>Obs.</strong></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="17"><hr /></td>
  </tr>
<?
if ($total_filas > 0)
{

// Obtenemos la suma de los importes de los albaranes mostrados:
/*$total_lts=sel_campo("SUM($suma_lts)","total_importe","albaranes","$cliente $empres $periodo $facturado");*/


$albaranes="SELECT * FROM albaranes $cliente $tarjeta $tractora $empres $periodo $facturado ORDER BY $orden";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$fecha_carga=fecha_esp($ord["fecha_carga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$cod_descarga=$ord["cod_descarga"];
$base=$ord["base"];
$cod_operadora=$ord["cod_operadora"];
$cod_operario=$ord["cod_operario"];
$cod_tarjeta=$ord["cod_tarjeta"];
$cod_tractora=$ord["cod_tractora"];
$cod_terminal=$ord["cod_terminal"];
$cod_pedido=$ord["cod_pedido"];
$franja=$ord["franja"];
$observ_descarga=$ord["observ_descarga"];


if ($ver_serv=="DEMANATS")
{
$blue=$ord["cant_blue"];
$sp95=$ord["cant_sp95"];
$sp98=$ord["cant_sp98"];
$goa=$ord["cant_go_a"];
$goa1=$ord["cant_go_a1"];
$gob=$ord["cant_go_b"];
$goc=$ord["cant_go_c"];
$bio=$ord["cant_bio"];
$titol="Demanats";
$suma_lts=$ord["suma_pedidos"];

// Obtenemos la suma de los litros pedidos:
$total_litros=sel_campo("SUM(suma_pedidos)","total_litros","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");

}
else if ($ver_serv=="SERVITS")
{
$blue=$ord["serv_blue"];
$sp95=$ord["serv_sp95"];
$sp98=$ord["serv_sp98"];
$goa=$ord["serv_go_a"];
$goa1=$ord["serv_go_a1"];
$gob=$ord["serv_go_b"];
$goc=$ord["serv_go_c"];
$bio=$ord["serv_bio"];
$titol="Servits";
$suma_lts=$ord["suma_servidos"];

// Obtenemos la suma de los litros servidos:
$total_litros=sel_campo("SUM(suma_servidos)","total_litros","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
	
$total_blue=sel_campo("SUM(serv_blue)","total_blue","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_sp95=sel_campo("SUM(serv_sp95)","total_sp95","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_sp98=sel_campo("SUM(serv_sp98)","total_sp98","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_goa=sel_campo("SUM(serv_go_a)","total_goa","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_goa1=sel_campo("SUM(serv_go_a1)","total_goa1","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_gob=sel_campo("SUM(serv_go_b)","total_gob","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_goc=sel_campo("SUM(serv_go_c)","total_goc","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_bio=sel_campo("SUM(serv_bio)","total_bio","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
	
}

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");

if($cod_terminal)
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");

if($cod_tarjeta){

$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$mat2=sel_campo("mat2","","tarjetas","cod_tarjeta='$cod_tarjeta'");
}

if($cod_tractora){

$mat2=sel_campo("mat2","","tractoras","cod_tractora='$cod_tractora'");
}

if($cod_descarga)
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");

if($cod_terminal)
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");

if($cod_operario)
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

?>
  <tr> 
    <td>&nbsp;</td>
    <td><span class="Estilo2"><? echo substr($nombre_cliente,0,10); ?></span></td>
    <td><span class="Estilo2"><? echo substr($poblacion,0,10); ?></span></td>
    <td><span class="Estilo2"><? echo "$cod_tarjeta"; ?></span></td>
    <td><span class="Estilo2"><? echo substr($nombre_op,0,8); ?></span></td>
    <td><span class="Estilo2"><? echo substr($descripcion,0,8); ?></span></td>
    <td><span class="Estilo2"><? echo substr($nombre_terminal,0,6); ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$blue"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$sp95"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$sp98"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$goa"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$goa1"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$gob"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$goc"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$bio"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$cod_pedido"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo "$franja"; ?></span></td>
    <td align="right"><span class="Estilo2"><? echo substr($observ_descarga,0,30); ?></span></td>
  </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17" align="right"><hr /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><? echo $total_blue; ?></strong></td>
    <td align="right"><strong><? echo $total_sp95; ?></strong></td>
    <td align="right"><strong><? echo $total_sp98; ?></strong></td>
    <td align="right"><strong><? echo $total_goa; ?></strong></td>
    <td align="right"><strong><? echo $total_goa1; ?></strong></td>
    <td align="right"><strong><? echo $total_gob; ?></strong></td>
    <td align="right"><strong><? echo $total_goc; ?></strong></td>
    <td align="right"><strong><? echo $total_bio; ?></strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17" align="right"><strong>Total Llitres: <? echo formatear($total_litros); ?></strong></td>
  </tr>
<?
} // Fin de if ($total_filas > 0)
?>
</table>
</body>
</html>