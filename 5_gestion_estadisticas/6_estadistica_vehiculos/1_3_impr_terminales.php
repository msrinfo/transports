<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resumen de Albaranes por Ch&oacute;feres</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_operario=$_GET["cod_operario"];
$cod_oper=$cod_operario;
$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
$ver=$_GET["ver"];
$cod_operadora=$_GET["cod_operadora"];
$cod_terminal=$_GET["cod_terminal"];
}


$where="WHERE";


$terminal="";
if ($cod_terminal)
{
$terminal="$where cod_terminal = '$cod_terminal'";
$where="and";
}

$operad="";
if ($cod_operadora)
{
$operad="$where cod_operadora = '$cod_operadora'";
$where="and";
}


if ($cod_empresa)
{
$empres="$where albaranes.cod_empresa = '$cod_empresa'";

conectar_base($base_datos_conta);
$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa = '$cod_empresa'");
conectar_base($base_datos);
$where="and";
}

$operario="";
if ($cod_operario)
{
$operario="$where cod_operario = '$cod_operario' or cod_operario2='$cod_operario'";
}
	
	
// Control periodo:
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
	
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);


if ($fecha_i && $fecha_f)
	$periodo="$where (albaranes.fecha_carga >= '$fecha_ini' and albaranes.fecha_carga <= '$fecha_fin' or albaranes.fecha_descarga >= '$fecha_ini' and albaranes.fecha_descarga <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (albaranes.fecha_carga >= '$fecha_ini' or albaranes.fecha_descarga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (albaranes.fecha_carga <= '$fecha_fin' or albaranes.fecha_descarga <= '$fecha_fin')";



$facturado="";
if ($ver=="PENDIENTES")
{
$busqueda="PENDIENTES";
$facturado="and estado like ''";
}

else if ($ver=="FACTURADOS")
{
$busqueda="FACTURADOS";
$facturado="and estado like 'f'";
}

else if ($ver=="TODOS")
{
$busqueda="TODOS";
}

// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CÓDIGO")
	$orden="albaranes.cod_albaran,albaranes.fecha_carga,albaranes.nombre_cliente";

else if ($clasificacion=="FECHA")
	$orden="albaranes.fecha_carga,albaranes.cod_albaran,albaranes.nombre_cliente";

else if ($clasificacion=="NOMBRE")
	$orden="albaranes.nombre_cliente,albaranes.cod_albaran,albaranes.fecha_carga";


// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes $terminal $operad $empres $operario $periodo $facturado";

//echo "<br /> $albaranes <br />";

$result_alb=mysql_query($albaranes, $link) or die("<br /> No se han consultado albaranes por operario: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_alb);


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f,$busqueda;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="11">Resumen de Terminales en Albaranes</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="3" align="right"><strong>Fecha Inicio:</strong><? echo $fecha_i; ?></td>
    <td colspan="3"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><strong>B&uacute;squeda:</strong> <? echo "$busqueda";?></td>
    <td colspan="3" align="right"><strong>Fecha Final: </strong> <? echo $fecha_f; ?></td>
    <td width="4%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="9"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="6%"><strong>Albar&aacute;n</strong></td>
    <td width="12%"><strong>Fecha</strong></td>
    <td width="20%"><strong>Terminal</strong></td>
    <td width="14%"><strong>Operadora</strong></td>
    <td width="11%"><strong>Matr&iacute;cula</strong></td>
    <td width="11%"><strong>Conductor</strong></td>
    <td><strong>Clliente</strong></td>
    <td>&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="9"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


if ($result_alb)
{
$albaranes="SELECT * FROM albaranes $terminal $operad $empres $operario $periodo $facturado";
//echo "$albaranes";
$result_alb=mysql_query($albaranes, $link);

while($alb=mysql_fetch_array($result_alb))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$fecha_descarga=fecha_esp($alb["fecha_descarga"]);
	
$cod_terminal=$alb["cod_terminal"];
$cod_operadora=$alb["cod_operadora"];
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");

$cod_operario=$alb["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=$alb["nombre_cliente"];
	
$cod_tarjeta=$alb["cod_tarjeta"];
	
if($cod_tarjeta)
{
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
}

$cod_tractora=$alb["cod_tractora"];

if($cod_tractora)
{
$mat2=sel_campo("mat2","","tractoras","cod_tractora='$cod_tractora'");
}	
	

$cont++;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td><? printf("%06d",$cod_albaran); ?></td>
    <td><? echo "$fecha_carga"." / ".$fecha_descarga; ?></td>
    <td><? echo $cod_terminal." ".$nombre_terminal; ?></td>
    <td><? echo $cod_operadora." ".substr($descripcion, 0, 25); ?></td>
    <td><? echo $mat1." ".$mat2; ?></td>
    <td><? echo $cod_operario." ".substr($nombre_op, 0, 25); ?></td>
    <td colspan="3"><? echo $cod_cliente." ".substr($nombre_cliente, 0, 25); ?></td>
    <td>&nbsp;</td>
  </tr>
<?
$total += $importe;
}
} // Fin de if ($result_alb)


$cont+=2;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="9"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>