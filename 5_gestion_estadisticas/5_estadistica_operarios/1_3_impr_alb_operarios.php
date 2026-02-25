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
}


$where="and";


$cliente="";
if ($cod_cliente)
{
$cliente="$where albaranes.cod_cliente = '$cod_cliente'";
}


$operario="";
if ($cod_operario)
{
$operario="$where op_alb.cod_operario = '$cod_operario'";
}


if ($cod_empresa)
{
$empres="$where albaranes.cod_empresa = '$cod_empresa'";

conectar_base($base_datos_conta);
$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa = '$cod_empresa'");
conectar_base($base_datos);
}

// Control periodo:
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
	
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);


if ($fecha_i && $fecha_f)
	$periodo="$where (albaranes.fecha >= '$fecha_ini' and albaranes.fecha <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (albaranes.fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (albaranes.fecha <= '$fecha_fin')";



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
	$orden="albaranes.cod_albaran,albaranes.fecha,albaranes.nombre_cliente";

else if ($clasificacion=="FECHA")
	$orden="albaranes.fecha,albaranes.cod_albaran,albaranes.nombre_cliente";

else if ($clasificacion=="NOMBRE")
	$orden="albaranes.nombre_cliente,albaranes.cod_albaran,albaranes.fecha";


// Realizamos la consulta: 
$albaranes="SELECT op_alb.cod_operario
FROM albaranes,op_alb
WHERE op_alb.cod_albaran = albaranes.cod_albaran and op_alb.cod_empresa = albaranes.cod_empresa
$cliente $operario $empres $periodo $facturado and horas != 0
";

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
    <td colspan="10">RESUMEN OPERARIOS EN &Oacute;RDENES: <? echo "$busqueda";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2" align="right"><strong>Fecha Inicio:</strong><? echo $fecha_i; ?></td>
    <td colspan="3"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><strong>B&uacute;squeda:</strong> <? echo "$busqueda";?></td>
    <td colspan="2" align="right"><strong>Fecha Final: </strong> <? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="6%"><strong>Orden</strong></td>
    <td width="10%"><strong>Fecha</strong></td>
    <td width="21%"><strong>Operario</strong></td>
    <td width="14%"><strong>Cliente</strong></td>
    <td width="20%">&nbsp;</td>
    <td><div align="right"><strong>Horas</strong></div></td>
    <td><div align="right"><strong>Precio/Hora</strong></div></td>
    <td width="10%"><div>
      <div align="right"><strong>Importe</strong></div>
    </div></td>
    <td width="1%">&nbsp;</td>
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


if ($result_alb)
{
$albaranes="SELECT albaranes.cod_albaran,albaranes.fecha,albaranes.cod_cliente,albaranes.nombre_cliente,op_alb.cod_operario,op_alb.horas
FROM albaranes,op_alb
WHERE op_alb.cod_albaran = albaranes.cod_albaran and op_alb.cod_empresa = albaranes.cod_empresa
$cliente $operario $empres $periodo $facturado and horas != 0
ORDER BY $orden
";

//echo "$albaranes";
$result_alb=mysql_query($albaranes, $link);

while($alb=mysql_fetch_array($result_alb))
{
$cod_albaran=$alb["cod_albaran"];
$fecha=fecha_esp($alb["fecha"]);
$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=$alb["nombre_cliente"];
$operario=$alb["operario"];
$horas=$alb["horas"];

$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$operario'");
$precio_hora=sel_campo("precio_hora","","operarios","cod_operario='$operario'");
$importe=redondear($horas*$precio_hora);


$cont++;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td><? printf("%06d",$cod_albaran); ?></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo $operario." ".$nombre_op; ?></td>
    <td colspan="2"><? echo $cod_cliente." ".substr($nombre_cliente, 0, 25); ?></td>
    <td width="7%"><div align="right"><? echo "$horas"; ?></div></td>
    <td width="10%"><div align="right"><? echo "$precio_hora"; ?></div></td>
    <td><div align="right"><? echo formatear($importe); ?></div></td>
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
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><div align="right"><strong>Total Importe: <? echo formatear($total); ?></strong></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>