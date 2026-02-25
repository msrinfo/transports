<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de albaranes por Ch&oacute;feres</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


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

if ($_POST)
{
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_operario=$_POST["cod_operario"];
$cod_oper=$cod_operario;
$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
$ver=$_POST["ver"];
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
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
  <tr class="titulo"> 
       <td colspan="15">Resumen de Operarios en &Oacute;rdenes</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td>&nbsp;</td>
    <td align="right"><strong>Fecha Inicio:</strong> <? echo $fecha_i; ?></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"><strong>B&uacute;squeda:</strong> <? echo "$busqueda";?></td>
    <td>&nbsp;</td>
    <td align="right"><strong>Fecha Final:</strong> <? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td width="0"></td>
    <td width="50"><strong>Orden</strong></td>
    <td width="79"><strong>Fecha</strong></td>
    <td width="196"><strong>Operario</strong></td>
    <td width="152"><strong>Cliente</strong></td>
    <td width="201">&nbsp;</td>
    <td width="59" align="right"><strong>Horas</strong></td>
    <td width="74" align="right"><div align="right"><strong>Precio/Hora</strong></div></td>
    <td width="115"><div align="right"><strong>Importe</strong></div></td>
    <td width="5"></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
<?
if ($result_alb)
{
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

$albaranes="SELECT albaranes.cod_albaran,albaranes.fecha,albaranes.cod_cliente,albaranes.nombre_cliente,op_alb.cod_operario,op_alb.horas
FROM albaranes,op_alb
WHERE op_alb.cod_albaran = albaranes.cod_albaran and op_alb.cod_empresa = albaranes.cod_empresa
$cliente $operario $empres $periodo $facturado and horas != 0
ORDER BY $orden
$limit";

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
?>
  <tr>
    <td></td>
    <td><a href="javascript:mostrar(event,'1_1_albaranes.php','cod_albaran','<? echo "$cod_albaran"; ?>','cod_cliente','<? echo "$cod_cliente"; ?>','','','','','','','','','','','','','','','','');"><? printf("%06d",$cod_albaran); ?></a></td>
    <td><? echo "$fecha"; ?></td>
    <td><? echo $operario." ".$nombre_op; ?></td>
    <td colspan="2"><? echo $cod_cliente." ".substr($nombre_cliente, 0, 25); ?></td>
    <td align="right"><? echo "$horas"; ?></td>
    <td align="right"><? echo "$precio_hora"; ?></td>
    <td><div align="right"><? echo formatear($importe); ?></div></td>
    <td></td>
  </tr>
<?
$total += $importe;
}
} // Fin de if ($result_alb)

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
    <td colspan="5">
<?
$campo_pag[1]="cod_cliente"; $valor_pag[1]=$cod_cli;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="cod_empresa"; $valor_pag[4]=$cod_empr;
$campo_pag[5]="cod_operario"; $valor_pag[5]=$cod_oper;
$campo_pag[6]="clasificacion"; $valor_pag[6]=$clasificacion;
$campo_pag[7]="ver"; $valor_pag[7]=$ver;

// Paginamos:
paginar("paginar");
?>	</td>
    <td colspan="3"><div align="right"><strong>Total Importe: <? echo formatear($total); ?></strong></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'1_3_impr_alb_operarios.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','<? echo $campo_pag[7]; ?>','<? echo $valor_pag[7]; ?>','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='1_1_albaranes_operarios.php'"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>