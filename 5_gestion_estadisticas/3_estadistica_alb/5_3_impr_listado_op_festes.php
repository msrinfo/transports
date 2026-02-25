<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Operaris Festes</title>


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
$observaciones=$_GET["observaciones"];
$observa=$observaciones;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
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


if ($cod_operario)
{
	$cliente="$where cod_operario = '$cod_operario'";
	// Si cliente está vacío, el contenido de la variable cambia:

	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
	
	$texto_operario="<strong>Conductor:</strong> $cod_operario $nombre_op";
	$where="AND";
}


$obs="";
if ($observaciones)
{
	$obs="$where observaciones like '%$observaciones%'";
	$where="AND";
}


if ($fecha_i || $fecha_f )
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i && $fecha_f)
	$periodo="$where ((fecha_ini >= '$fecha_ini' or fecha_fin >= '$fecha_ini') and (fecha_ini <= '$fecha_fin' or fecha_fin <= '$fecha_fin'))";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_ini >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_fin <= '$fecha_fin')";
}

$where="and";
} //FIN if (!$fecha_i && !$fecha_f)

// Establecemos el orden:
if ($clasificacion=='OPERARI')
	$orden="cod_operario,fecha_ini";
if ($clasificacion=='DATA')
	$orden="fecha_ini,cod_operario";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 
$cuenta="SELECT * FROM op_fiestas $cliente $obs $periodo $num_iva";
$result_cuenta=mysql_query($cuenta, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");
$total_filas=mysql_num_rows($result_cuenta);


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f,$observaciones;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
       <td colspan="8">Operaris Festes</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td><div align="right"><strong>Data Inici: </strong></div></td>
    <td><? echo $fecha_i; ?></td>
    <td align="right"><div align="right"><strong>Resultats:</strong> <? echo $total_filas; ?></div></td>
    <td>&nbsp;</td>
   <tr>
     <td>&nbsp;</td>
     <td colspan="3">&nbsp;</td>
     <td><div align="right"><strong>Data Final: </strong></div></td>
     <td><? echo $fecha_f; ?></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr> 
   <tr>
     <td>&nbsp;</td>
     <td colspan="6"><hr /></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td width="1"></td>
    <td width="190"><strong>Conductor</strong></td>
    <td width="107">&nbsp;</td>
    <td width="99"><strong>Data Inici</strong></td>
    <td width="89"><strong>Data Final</strong></td>
    <td width="109"><strong>Observacions</strong></td>
    <td width="129">&nbsp;</td>
    <td width="4"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();



//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM op_fiestas $cliente $obs $periodo $num_iva ORDER BY $orden $limit";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");


if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_operario=$alb["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
$fecha_ini=fecha_esp($alb["fecha_ini"]);
$fecha_fin=fecha_esp($alb["fecha_fin"]);
$observaciones=$alb["observaciones"];


//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($clasificacion=='OPERARI' && $cod_cli!=$cod_operario)
{
$cont++;
cabecera();
?>
  <tr bgcolor='#F1F7EE'>
    <td>&nbsp;</td>
    <td colspan="5"><strong><? echo $cod_operario." ".$nombre_op; ?></strong></td>
    <td align="right"><strong></strong></td>
    <td>&nbsp;</td>
  </tr>
<?
$cod_cli=$cod_operario;
$cont++;
} // Fin if($cod_cli!=$cod_operario)
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? if ($clasificacion=='DATA') {echo substr($cod_operario." ".$nombre_op, 0, 40);} ?></td>
    <td align="left"><? echo $fecha_ini; ?></td>
    <td align="left"><? echo $fecha_fin; ?></td>
    <td colspan="2" align="left"><? echo $observaciones; ?></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont++;
cabecera();

} //Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)

$cont+=2;
cabecera();
?>
</table>
</body>
</html>