<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Albarans N&ograve;mines Detallat</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_operario=$_GET["cod_operario"];
$cod_oper=$cod_operario;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$clasificacion=$_GET["clasificacion"];
$detallado=$_GET["detallado"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";
// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
	$empres="$where cod_empresa = '$cod_empresa'";
	$where="AND";
}

if ($cod_operario)
{
	$cliente="$where (cod_operario = '$cod_operario' or cod_operario2 = '$cod_operario')";
	// Si cliente está vacío, el contenido de la variable cambia:

	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
	
	$texto_operario="<strong>Conductor:</strong> $cod_operario $nombre_op";
}


if ($fecha_i || $fecha_f )
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

// Si no recibimos fecha_carga inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini' and fecha_carga <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_carga <= '$fecha_fin')";
}

$where="and";
} //FIN if (!$fecha_i && !$fecha_f)

// Establecemos el orden:
$orden="cod_operario, fecha_carga, precio_chof";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 
$albaranes="SELECT COUNT(cod_albaran) as total_filas FROM albaranes $empres $cliente $periodo $num_iva";
//echo "<br /> $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $albaranes <br />");
$total=mysql_fetch_array($result_fact);
$total_filas=$total["total_filas"];


$toti=sel_campo("SUM(precio_chof) + SUM(prec_doble_carga_chof) + SUM(prec_doble_desc_chof)","toti","albaranes","$empres $cliente $periodo $num_iva ORDER BY cod_operario");

$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?></head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f,$tot_cond;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="12">ALBARANS N&Ograve;MINES DETALLAT </td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Data Inici:</strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td colspan="2"><div align="right"><strong>Resultats:</strong> <? echo "$total_filas"; ?></div></td>
    <td></td>
  </tr>
    <tr> 
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="2"><div align="right"><strong>Data Final:</strong></div></td>
    <td colspan="2"><? echo $fecha_f; ?></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%"></td>
    <td width="6%"><strong>Albar&agrave;</strong></td>
    <td width="7%"><strong>Data</strong></td>
    <td><strong>Conductor</strong></td>
    <td align="left"><strong>Desc&agrave;rrega</strong></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left"><strong>Targeta</strong></td>
    <td align="left">&nbsp;</td>
    <td width="12%" align="right"><strong>Preu C/D.C./D.D.</strong></td>
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


// SELECCIONAR LOS DIFERENTES CLIENTES QUE HAY Y LUEGO RESTARLO EN EL CONTADOR DE FILAS:
$cuenta="SELECT DISTINCT cod_operario FROM albaranes $empres $cliente $periodo $num_iva";
$result_cuenta=mysql_query($cuenta, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");
$conta=mysql_num_rows($result_cuenta);

$total_filas=$conta;

//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $empres $cliente $periodo $num_iva ORDER BY $orden";
$result_albaranes=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");
$total_filas = mysql_num_rows($result_albaranes);



//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $empres $cliente $periodo $num_iva ORDER BY $orden $limit";
$color="bgcolor='#F1F7EE'";

//echo "$albaranes";
$result_fact=mysql_query($albaranes) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");


if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$cod_empresa=$alb["cod_empresa"];
$cod_operario=$alb["cod_operario"];
$cod_tarjeta=$alb["cod_tarjeta"];
$cod_tractora=$alb["cod_tractora"];

if($cod_operario)
{
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

$precio_chof=$alb["precio_chof"];
$prec_doble_carga_chof=$alb["prec_doble_carga_chof"];
$prec_doble_desc_chof=$alb["prec_doble_desc_chof"];

$cod_descarga=$alb["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
}

$cod_tarjeta=$alb["cod_tarjeta"];
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta = '$cod_tarjeta'");

$cod_tractora=$alb["cod_tractora"];
$mat2=sel_campo("mat2","","tractoras","cod_tractora = '$cod_tractora'");

//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_cli!=$cod_operario)
{

$tot_cond=sel_campo("SUM(precio_chof) + SUM(prec_doble_carga_chof) + SUM(prec_doble_desc_chof)","","albaranes","$empres $periodo $num_iva $where cod_operario = '$cod_operario' ORDER BY cod_operario");


$cont++;
cabecera();
?>
  <tr <? echo "$color";?>> 
    <td></td>
    <td></td>
    <td></td>
    <td width="23%"><strong><? echo $cod_operario." ".$nombre_op; ?></strong></td>
    <td width="9%"></td>
    <td width="9%"></td>
    <td width="10%"></td>
    <td width="1%" align="right">&nbsp;</td>
    <td width="16%" align="right">&nbsp;</td>
    <td width="5%" align="right"><div align="right"></div></td>
    <td align="right"><div align="right"><strong><? echo formatear($tot_cond); ?></strong></div></td>
	<td></td>
  </tr>
<?
$cod_cli=$cod_operario;
$cont++;
} // Fin if($cod_cli!=$cod_operario)


?>
  <tr> 
    <td></td>
    <td><? echo "$cod_albaran"; ?></td>
    <td><? echo "$fecha_carga"; ?></td>
    <td>&nbsp;</td>
    <td colspan="4" align="left"><? echo "$poblacion"; ?></td>
    <td align="left"><? echo $mat1."-".$mat2; ?></td>
    <td align="left">&nbsp;</td>
    <td align="right"><div align="right"><? echo "$precio_chof"; if($prec_doble_carga_chof!=0) echo " + $prec_doble_carga_chof"; if($prec_doble_desc_chof!=0) echo " + $prec_doble_desc_chof"; ?></div></td>
    <td></td>
  </tr>
<?
$cont++;
cabecera();
} //Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)

$cont+=2;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right"><strong><? echo formatear($toti); ?></strong></td>
    <td></td>
  </tr>
</table>
</body>
</html>