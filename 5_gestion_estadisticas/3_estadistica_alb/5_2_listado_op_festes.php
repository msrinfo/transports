<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Operaris Festes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_operario=$_GET["cod_operario"];
$cod_cli=$cod_operario;
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
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_operario=$_POST["cod_operario"];
$cod_cli=$cod_operario;
$observaciones=$_POST["observaciones"];
$observa=$observaciones;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
}
//--------------------------------------------------------------------------------------------
//                             				FIN POST
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
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
   <tr class="titulo"> 
       <td colspan="8">Operaris Festes</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td><div align="right"><strong>Data Inici: </strong></div></td>
    <td><? echo $fecha_i; ?></td>
    <td align="right"><div align="right"><strong>Resultats:</strong> <? echo $total_filas; ?></div></td>
    <td>&nbsp;</td>
   </tr>
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
    <td width="140"><strong>Conductor</strong></td>
    <td width="149">&nbsp;</td>
    <td width="99"><strong>Data Inici</strong></td>
    <td width="97"><strong>Data Final</strong></td>
    <td width="109"><strong>Observacions</strong></td>
    <td width="132">&nbsp;</td>
    <td width="1"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$albaranes="SELECT * FROM op_fiestas $cliente $obs $periodo $num_iva ORDER BY $orden";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");
$total_filas=mysql_num_rows($result_fact);

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM op_fiestas $cliente $obs $periodo $num_iva ORDER BY $orden $limit";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");
//$total_filas=mysql_num_rows($result_fact);

//Contador para la primera vez que entra
$cont=0;

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
if($clasificacion=='OPERARI' && $cod_client!=$cod_operario)
{
?>
  <tr bgcolor='#F1F7EE'>
    <td>&nbsp;</td>
    <td colspan="5"><strong><? echo $cod_operario." ".$nombre_op; ?></strong></td>
    <td align="right"><strong></strong></td>
    <td>&nbsp;</td>
  </tr>
<?
$cod_client=$cod_operario;
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
} //Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)


// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">
<?
$campo_pag[1]="cod_operario"; $valor_pag[1]=$cod_cli;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="clasificacion"; $valor_pag[4]=$clasificacion;
$campo_pag[5]="observaciones"; $valor_pag[5]=$observa;



// Paginamos:
paginar("paginar");


?>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'5_3_impr_listado_op_festes.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','','','','','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='5_1_op_festes.php'"></td>
    <td>&nbsp;</td>
  </tr>
</form>
</table>
</body>
</html>