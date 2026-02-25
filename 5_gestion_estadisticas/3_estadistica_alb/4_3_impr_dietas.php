<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Albarans Dietes</title>


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
$prec_dieta=$_GET["prec_dieta"];
$prec_diet=$prec_dieta;
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_operario=$_POST["cod_operario"];
$cod_oper=$cod_operario;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$clasificacion=$_POST["clasificacion"];
$prec_dieta=$_POST["prec_dieta"];
$prec_diet=$prec_dieta;
}
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------


if($prec_dieta=="")
	{
	$prec_dieta=0;
	}


//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";

if ($cod_operario)
{
	$cliente="$where cod_operario = '$cod_operario'";
	// Si cliente está vacío, el contenido de la variable cambia:
	$where="AND";
	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
	$empres="$where cod_empresa = '$cod_empresa'";
	$where="AND";
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
$orden="cod_operario, fecha_carga";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 
$albaranes="SELECT COUNT(cod_albaran) as total_filas FROM albaranes $cliente $empres $periodo $num_iva";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $albaranes <br />");
$total=mysql_fetch_array($result_fact);
$total_filas=$total["total_filas"];

// Obtenemos suma de dias por conductor de todos los conductores:
//$fechas="SELECT DISTINCT(fecha_carga) FROM albaranes $cliente $empres $periodo $num_iva";
$fechas="SELECT COUNT(DISTINCT(fecha_carga)) AS cli_dias FROM albaranes $cliente $empres $periodo $num_iva GROUP BY cod_operario";
$result_fechas=mysql_query($fechas, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");

while ($ft=mysql_fetch_assoc($result_fechas))
{
$fechas_tot += $ft["cli_dias"];
}
//echo "<br />fechas_tot $fechas_tot <br />";


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f,$cod_operario,$prec_dieta, $fechas_tot, $nombre_op;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="12">Albarans Dietes</td>
  </tr>
   <tr>
    <td></td>
    <td colspan="4"><strong>Empresa: </strong><? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Data Inici: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td colspan="2" align="right"><div align="right"><strong>Resultats:</strong> <? echo $total_filas; ?></div></td>
    <td></td>
   <tr>
     <td>&nbsp;</td>
     <td colspan="4"><strong>Conductor:</strong> <? echo $cod_operario." ".$nombre_op; ?></td>
     <td colspan="2"><div align="right"><strong>Data Final: </strong></div></td>
     <td colspan="2"><? echo $fecha_f; ?></td>
     <td colspan="2">&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td colspan="2"><strong>Dies:</strong> <? echo $fechas_tot; ?></td>
     <td><strong>Preu:</strong> <? echo $prec_dieta; ?> &euro; </td>
     <td><strong>Total:</strong> <? echo formatear($fechas_tot * $prec_diet); ?> &euro;</td>
     <td colspan="2">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
     <td>&nbsp;</td>
   </tr> 
   <tr>
     <td>&nbsp;</td>
     <td colspan="10"><hr /></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td width="4"></td>
    <td width="53"><strong>Albarà</strong></td>
    <td width="57"><strong>Data</strong></td>
    <td width="120">&nbsp;</td>
    <td width="142" align="left"><strong>Desc&agrave;rrega</strong></td>
    <td width="60" align="right">&nbsp;</td>
    <td width="60" align="right">&nbsp;</td>
    <td width="51" align="right">&nbsp;</td>
    <td width="34" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td width="9"></td>
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


//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $cliente $empres $periodo $num_iva ORDER BY $orden";

$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");


if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$cod_empresa=$alb["cod_empresa"];
$cod_operario=$alb["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");


$precio_chof=$alb["precio_chof"];
$cod_descarga=$alb["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
}



//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_cli!=$cod_operario)
{
$totcli="SELECT COUNT(DISTINCT(fecha_carga)) AS cli_dias FROM albaranes $cliente $empres $periodo $num_iva $where cod_operario = '$cod_operario' ORDER BY cod_operario";
//echo "<br /> totcli: $totcli <br />";
$result_cli=mysql_query($totcli, $link) or die ("<br /> No se han seleccionado totales de albaranes: ".mysql_error()."<br /> $totcli <br />");

$clie=mysql_fetch_array($result_cli);

$cli_dias=$clie["cli_dias"];


$cont++;
cabecera();
?>
  <tr bgcolor="#F1F7EE">
    <td></td>
    <td colspan="3"><? echo $cod_operario." ".$nombre_op; ?></td>
    <td>&nbsp;</td>
    <td colspan="3"><div align="right"><? echo $cli_dias; ?> dies * <? echo $prec_dieta; ?> € = <? echo formatear($cli_dias * $prec_dieta); ?> €</div></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td></td>
  </tr>
<?
$cod_cli=$cod_operario;
} // Fin if($cod_cli!=$cod_operario)

$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td><? echo $cod_albaran; ?></td>
    <td><? echo $fecha_carga; ?></td>
    <td><? echo $cod_operario." ".$nombre_op; ?></td>
    <td colspan="6" align="left"><? echo $poblacion; ?></td>
    <td align="right"><div align="right"></div></td>
    <td></td>
  </tr>
<?
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
    <td width="60">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td width="34" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td></td>
  </tr>
</table>
</body>
</html>