<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control Dia Conductors</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_albaran=$_GET["cod_albaran"];
$cod_empresa=$_GET["cod_empresa"];
$dia=$_GET["dia"];


/*
echo "
<br /> cod_albaran: $cod_albaran
<br /> cod_empresa: $cod_empresa
<br /> dia: $dia
";*/


if ($cod_albaran)
{
$select_lin="SELECT * FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa' GROUP BY cod_operario";

$query_lin=mysql_query($select_lin) or die ("<br /> No se ha seleccionado albarán: ".mysql_error()."<br /> $select_lin <br />");

$lin=mysql_fetch_array($query_lin);

$cod_cliente=$lin["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
$precio_cli=$lin["precio_cli"];

$cod_operario=$lin["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");

$serv_blue=$lin["serv_blue"];
$serv_sp95=$lin["serv_sp95"]; 	
$serv_sp98=$lin["serv_sp98"];	
$serv_go_a=$lin["serv_go_a"];
$serv_go_a1=$lin["serv_go_a1"];
$serv_go_b=$lin["serv_go_b"];
$serv_go_c=$lin["serv_go_c"];
$serv_bio=$lin["serv_bio"];
} // Fin de if ($cod_albaran)
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN DE: GET
//--------------------------------------------------------------------------------------------


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$dia;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="12">CONTROL DIA CONDUCTORS </td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td><div align="right"><strong>Dia: </strong></div></td>
    <td colspan="2"><? echo $dia; ?></td>
    <td><div align="right"></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%"></td>
    <td width="10%"><strong>Ch&oacute;fer</strong></td>
    <td width="10%"><strong>Albar&agrave;</strong></td>
    <td colspan="2"><strong>Client</strong></td>
    <td width="9%" align="right"><strong>Lts. Serv</strong></td>
    <td width="10%" align="right"><strong>Preu Cond.</strong></td>
    <td width="7%" align="right"><strong>DCarga</strong></td>
    <td align="right"><strong>D Desc</strong></td>
    <td align="right"><strong>Des Bom</strong></td>
    <td width="9%" align="right"><div align="right"><strong>Total</strong></div></td>
    <td width="1%"></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


if ($cod_empresa && $dia)
{
$dia=fecha_ing($dia);

$cont_oper==0;

// SELECCIONAR LOS DIFERENTES CLIENTES QUE HAY Y LUEGO RESTARLO EN EL CONTADOR DE FILAS:
$cuenta="SELECT DISTINCT cod_operario FROM albaranes WHERE cod_empresa = '$cod_empresa' and (fecha_carga = '$dia' or fecha_descarga = '$dia') ORDER BY cod_operario";
$result_cuenta=mysql_query($cuenta, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");

while($ba=mysql_fetch_array($result_cuenta))
{
$cod_operario=$ba["cod_operario"];


// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

$mostrar_art="SELECT * FROM albaranes WHERE cod_empresa = '$cod_empresa' and (fecha_carga = '$dia' or fecha_descarga = '$dia') and cod_operario='$cod_operario' ORDER BY cod_operario $limit";

$result_fact=mysql_query($mostrar_art, $link) or die ("<br /> No se han seleccionado alb: ".mysql_error()."<br /> $mostrar_art <br />");


//Contador para la primera vez que entra
$cont=0;

if ($result_fact)
{
while($art=mysql_fetch_array($result_fact))
{
$cod_albaran=$art["cod_albaran"];
$cod_cliente=$art["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
$cod_operario=$art["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");
$precio_chof=$art["precio_chof"];
$suma_servidos=$art["suma_servidos"];

$prec_doble_carga_chof=$art["prec_doble_carga_chof"];
$prec_doble_desc_chof=$art["prec_doble_desc_chof"];
$prec_desc_bomba_chof=$art["prec_desc_bomba_chof"];


$total_precios=$precio_chof+$prec_doble_carga_chof+$prec_doble_desc_chof+$prec_desc_bomba_chof;

//$total_op+=$total_precios;
//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_oper!=$cod_operario)
{

?>
  <tr bgcolor="#F1F7EE"> 
    <td></td>
    <td colspan="6"><strong><? echo $cod_operario." ".substr($nombre_op, 0, 20); ?></strong></td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right"><div align="right"><strong><? echo $total_op; ?></strong></div></td>
	<td></td>
  </tr>
<?

$cod_oper=$cod_operario;
$cont++;
} // Fin if($cod_cli!=$cod_cliente)


$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td>&nbsp;</td>
    <td><span class="vinculo"><? echo $cod_albaran; ?></span></td>
    <td colspan="2"><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
    <td align="right"><? echo formatear($suma_servidos); ?></td>
    <td align="right"><? echo formatear($precio_chof); ?></td>
    <td align="right"><? echo formatear($prec_doble_carga_chof); ?></td>
    <td width="8%" align="right"><? echo formatear($prec_doble_desc_chof); ?></td>
    <td width="10%" align="right"><? echo formatear($prec_desc_bomba_chof); ?></td>
    <td align="right"><div align="right"><? echo formatear($total_precios); ?></div></td>
    <td></td>
  </tr>
  <?
} // Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)
} // Fin de if ($cod_empresa && $dia)
} // Fin de while($ba=mysql_fetch_array($result_cuenta))

$cont+=2;
cabecera();
?>
  
  <tr> 
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="3" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
  </tr>
</table>
</body>
</html>