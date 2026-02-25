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

$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$cod_operario=$_GET["cod_operario"];
$cod_operari=$cod_operario;	
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
$ver=$_GET["ver"];
$cod_operadora=$_GET["cod_operadora"];
$cod_oper=$cod_operadora;
$cod_terminal=$_GET["cod_terminal"];
$cod_term=$cod_terminal;
}

if ($_POST)
{

$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
$ver=$_POST["ver"];

$cod_operario=$_POST["cod_operario"];
$cod_operari=$cod_operario;	
$cod_operadora=$_POST["cod_operadora"];
$cod_oper=$cod_operadora;
$cod_terminal=$_POST["cod_terminal"];
$cod_term=$cod_terminal;

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
$empres="$where cod_empresa = '$cod_empresa'";

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
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
  <tr class="titulo"> 
       <td colspan="17">Resumen de Terminales en Albaranes</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="right"><strong>Fecha Inicio:</strong> <? echo $fecha_i; ?></td>
    <td width="56">&nbsp;</td>
    <td colspan="2"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"><strong>B&uacute;squeda:</strong> <? echo "$busqueda";?></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="right"><strong>Fecha Final:</strong> <? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td width="112">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td width="24"></td>
    <td width="124"><strong>Albar&aacute;n</strong></td>
    <td width="188"><strong>Fecha Carga/Descarga</strong></td>
    <td width="193"><strong>Terminal</strong></td>
    <td width="233"><strong>Operadora</strong></td>
    <td width="234"><strong>Matr&iacute;cula</strong></td>
    <td width="325"><strong>Conductor</strong></td>
    <td colspan="4"><strong>Client</strong></td>
    <td width="20"></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10"><hr /></td>
    <td></td>
  </tr>
<?
if ($result_alb)
{
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

$albaranes="SELECT * FROM albaranes $terminal $operad $empres $operario $periodo $facturado $limit";
//echo "$albaranes";

$result_alb=mysql_query($albaranes, $link);

while($alb=mysql_fetch_array($result_alb))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$fecha_descarga=fecha_esp($alb["fecha_descarga"]);
$cod_terminal=$alb["cod_terminal"];
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");

$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=$alb["nombre_cliente"];

$cod_operadora=$alb["cod_operadora"];
$desc_operadora=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");

$cod_operario=$alb["cod_operario"];
	
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
	

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

?>
  <tr>
    <td></td>
    <td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
    <td><? echo "$fecha_carga"." / ".$fecha_descarga; ?></td>
    <td><? echo $cod_terminal." ".$nombre_terminal; ?></td>
    <td><? echo $cod_operadora." ".substr($desc_operadora, 0, 25); ?></td>
    <td><? echo $mat1." ".$mat2; ?></td>
    <td><? echo $cod_operario." ".substr($nombre_op, 0, 25); ?></td>
    <td colspan="4"><? echo $cod_cliente." ".substr($nombre_cliente, 0, 25); ?></td>
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
    <td colspan="10"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7">
<?
$campo_pag[1]="cod_operadora"; $valor_pag[1]=$cod_oper;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="cod_empresa"; $valor_pag[4]=$cod_empr;
$campo_pag[5]="cod_terminal"; $valor_pag[5]=$cod_term;
$campo_pag[6]="clasificacion"; $valor_pag[6]=$clasificacion;
$campo_pag[7]="ver"; $valor_pag[7]=$ver;
$campo_pag[8]="cod_operario"; $valor_pag[8]=$cod_operari;		

// Paginamos:
paginar("paginar");
?>	</td>
    <td colspan="3">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'1_3_impr_terminales.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','<? echo $campo_pag[7]; ?>','<? echo $valor_pag[7]; ?>','<? echo $campo_pag[8]; ?>','<? echo $valor_pag[8]; ?>','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='1_1_terminales.php'"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>