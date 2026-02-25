<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Localitzar Albarans per Targeta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_tarjeta=$_GET["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_GET["cod_tractora"];
$cod_tra=$cod_tractora;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_tarjeta=$_POST["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_POST["cod_tractora"];
$cod_tra=$cod_tractora;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN POST
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";

if ($cod_empresa)
{
$empresa="$where cod_empresa = '$cod_empresa'";
$where="and";
}

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


if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
	
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini' and fecha_carga <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where fecha_carga >= '$fecha_ini'";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where fecha_carga <= '$fecha_fin'";

$where="and";
}
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// ORDEN:
$orden="fecha_carga,cod_tarjeta";
	
// Especificamos la consulta:
$select_alb="SELECT cod_albaran FROM albaranes $empresa $cliente $tarjeta $tractora $periodo";
//echo "<br /> select_alb: $select_alb <br />";


$query_alb=mysql_query($select_alb, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $select_alb <br />");

$total_filas=mysql_num_rows($query_alb);
?>
</head>

<body>
<table width="94%">
<form name="resumen_alb" method="post" action="">
  <tr class="titulo"> 
       <td colspan="15">Llistat Albarans per Targeta</td>
  </tr>
  <tr>
    <td width="1%"></td>
    <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td width="19%"><div align="right"><strong>Data Inici: </strong></div></td>
    <td width="8%"><? echo $fecha_i; ?></td>
    <td width="16%">&nbsp;</td>
    <td colspan="2"><div align="right"><strong>Resultats:</strong> <? echo $total_filas; ?></div></td>
    <td width="1%"></td>
  </tr>
  <tr>
    <td width="1%"></td>
    <td colspan="3">&nbsp;</td>
    <td><div align="right"><strong>Data Final: </strong></div></td>
    <td><? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="1%"></td>
  </tr>
  <tr>
    <td></td>
    <td width="7%"><strong>Albar&agrave;</strong></td>
    <td width="9%"><strong>Data C. </strong></td>
    <td width="22%"><strong>Client</strong></td>
    <td><strong>Targeta - Tractora</strong></td>
    <td><strong>Poblaci&oacute;</strong></td>
    <td>&nbsp;</td>
    <td width="10%"><strong>Conductor</strong></td>
    <td width="7%"><div align="right"><strong>Base</strong></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
<?
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

if ($total_filas > 0)
{
$select_alb="SELECT * FROM albaranes $empresa $cliente $tarjeta $tractora $periodo $limit";
//echo "<br /> $select_alb <br />";

$query_alb=mysql_query($select_alb, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $select_alb <br />");


while($art=mysql_fetch_array($query_alb))
{
$cod_albaran=$art["cod_albaran"];
$fecha_carga=$art["fecha_carga"];
$cod_cliente=$art["cod_cliente"];
$cod_operario=$art["cod_operario"];

$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");

$cod_tarjeta=$art["cod_tarjeta"];
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta = '$cod_tarjeta'");

$cod_tractora=$art["cod_tractora"];
$mat2=sel_campo("mat2","","tractoras","cod_tractora = '$cod_tractora'");

$cod_descarga=$art["cod_descarga"];
$poblacion=sel_campo("poblacion","","descargas","cod_descarga = '$cod_descarga'");

$base=$art["base"];
$total_base=sel_campo("SUM(base)","total_base","albaranes","$empresa $cliente $tarjeta $tractora $periodo");
?>
  <tr>
    <td></td>
     <td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
    <td><? echo fecha_esp($fecha_carga); ?></td>
    <td><? echo $cod_cliente. " ".substr($nombre_cliente, 0, 25); ?></td>
    <td><? if ($cod_tarjeta) {echo $cod_tarjeta.' '.$mat1;} if ($cod_tractora) {echo ' - '.$cod_tractora.' '.$mat2;} ?></td>
    <td colspan="2"><? echo $poblacion; ?></td>
    <td><? echo $nombre_op; ?></td>
    <td><div align="right"><? echo formatear($base); ?></div></td>
    <td></td>
  </tr>
<?
} // while($art=mysql_fetch_array($query_alb))
} // Fin de if ($total_filas > 0)

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4" align="left"><?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="cod_tarjeta"; $valor_pag[3]=$cod_tar;
$campo_pag[4]="cod_tractora"; $valor_pag[4]=$cod_tra;
$campo_pag[5]="fecha_ini"; $valor_pag[5]=$fecha_i;
$campo_pag[6]="fecha_fin"; $valor_pag[6]=$fecha_f;

// Paginamos:
paginar("paginar");
?></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><strong>Total:</strong></td>
    <td align="right"><strong><? echo formatear($total_base); ?></strong></td>
    <td ></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8" align="center">
	  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'1_3_impr_listado_alb_tar.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','','','','','','','','');">
	 <input name="buscar" type="button" value="Nova Recerca" onClick="location.href=direccion_conta('1_1_alb_tar.php')"></td>
    <td ></td>
  </tr>
</form>
</table>
</body>
</html>