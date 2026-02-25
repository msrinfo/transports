<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Llistat Albarans per Targeta</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


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
    <td colspan="10">Llistat Albarans per Targeta</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td><div align="right"><strong>Data Inici: </strong></div></td>
    <td><? echo $fecha_i; ?></td>
    <td colspan="2"><div align="right"><strong>Resultats:</strong> <? echo "$total_filas"; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4">&nbsp;</td>
    <td><div align="right"><strong>Data Final: </strong></div></td>
    <td><? echo $fecha_f; ?></td>
    <td colspan="2">&nbsp;</td>
    <td></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%"></td>
    <td width="6%"><strong>Albar&agrave;</strong></td>
    <td width="10%"><strong>Data C. </strong></td>
    <td width="14%"><strong>Client</strong></td>
    <td width="21%"><strong>Targeta - Tractora</strong></td>
    <td width="12%"><strong>Poblaci&oacute; </strong></td>
    <td width="16%">&nbsp;</td>
    <td width="13%"><strong>Conductor</strong></td>
    <td width="6%"><div align="right"><strong>Base</strong></div></td>
    <td width="1%"></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


$select_alb="SELECT * FROM albaranes $empresa $cliente $tarjeta $tractora $periodo";

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

$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td><? echo $cod_albaran; ?></td>
    <td><? echo fecha_esp($fecha_carga); ?></td>
    <td><? echo $cod_cliente. " ".substr($nombre_cliente, 0, 10); ?></td>
    <td><? if ($cod_tarjeta) {echo $cod_tarjeta.' '.$mat1;} if ($cod_tractora) {echo ' - '.$cod_tractora.' '.$mat2;} ?></td>
    <td colspan="2"><? echo $poblacion; ?></td>
    <td><? echo $nombre_op; ?></td>
    <td><div align="right"><? echo formatear($base); ?></div></td>
    <td></td>
  </tr>
<?
}

$cont+=2;
cabecera();
?>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="right"><strong>Total:</strong></td>
    <td align="right"><strong><? echo formatear($total_base); ?></strong></td>
    <td></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="8">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>