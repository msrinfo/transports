<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Albarans Incid&egrave;ncies</title>


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
$incidencias=$_GET["incidencias"];
$incid=$incidencias;
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

if ($cod_empresa)
{
$empresa="$where cod_empresa = '$cod_empresa'";
$where="AND";
}


$inc="";
if ($incidencias)
{
	$inc="$where incidencias like '%$incidencias%'";
	$where="AND";
}else{
	
	$inc="$where incidencias!=''";
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
	$periodo="$where (fecha >= '$fecha_ini' and fecha <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha <= '$fecha_fin')";
}

$where="and";
} //FIN if (!$fecha_i && !$fecha_f)

// Establecemos el orden:
$orden="fecha,cod_albaran";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 
$albaranes="SELECT * FROM albaranes $empresa $inc $periodo ORDER BY $orden";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");
$total_filas=mysql_num_rows($result_fact);



$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f,$incidencias;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="12">ALBARANS INCID&Egrave;NCIES </td>
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
    <td><strong>Albar&agrave;</strong></td>
    <td width="9%"><strong>Data</strong></td>
    <td width="26%"><strong>Client</strong></td>
    <td colspan="2"><strong>Conductor</strong></td>
    <td width="9%" align="left"><strong>Incid&egrave;ncia</strong></td>
    <td width="3%" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td width="9%" align="left">&nbsp;</td>
    <td width="9%" align="left">&nbsp;</td>
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



//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $empresa $inc $periodo ORDER BY $orden $limit";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");
$total_filas=mysql_num_rows($result_fact);


if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$cod_operario=$alb["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente='$cod_cliente'");
$fecha=fecha_esp($alb["fecha_carga"]);
$incidencias=$alb["incidencias"];




?>
  <tr> 
    <td></td>
    <td><? echo "$cod_albaran"; ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo "$cod_cliente"; ?> <? echo substr($nombre_cliente,0,28); ?></td>
    <td colspan="2"><? echo "$cod_operario"; ?> <? echo "$nombre_op"; ?></td>
    <td colspan="5" align="left"><? echo "$incidencias"; ?>      <div align="right"></div></td>
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
    <td></td>
    <td width="6%"></td>
    <td colspan="2"></td>
    <td colspan="2"></td>
    <td colspan="2" align="right">&nbsp;</td>
    <td width="8%" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td></td>
  </tr>
</table>
</body>
</html>