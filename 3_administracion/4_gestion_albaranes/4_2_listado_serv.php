<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resum de Serveis</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_factura=$_GET["cod_factura"];
$cod_fact=$cod_factura;
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$clasificacion=$_GET["clasificacion"];
}

if ($_POST)
{
$cod_factura=$_POST["cod_factura"];
$cod_fact=$cod_factura;
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_empresa=$_POST["cod_empresa"];
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$ver=$_POST["ver"];
$clasificacion=$_POST["clasificacion"];
}


$where="WHERE";

// Si no recibimos cliente, dejamos la variable vacía:
$fact;
if ($cod_factura)
{
$fact="$where cod_factura = '$cod_factura'";
$where="and";
$orden="cod_servicio,fecha,nombre_cliente";
}

// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";
if ($cod_cliente)
{
$cliente="$where cod_cliente = '$cod_cliente'";
$where="and";
}

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
$empres="$where cod_empresa = '$cod_empresa'";
conectar_base($base_datos_conta);
$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa = '$cod_empresa'");
conectar_base($base_datos);
$where="and";
}


// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha <= '$fecha_fin')";

$where="and";
}


// En principio la variable $facturado está vacía para mostrar todos los servicios, pero según lo que valga $ver, mostrará los servicios pendientes o facturados:
$facturado="";
if ($ver=="PENDENTS")
{
$facturado="$where estado like ''";
$where="and";
}
		
else if ($ver=="FACTURATS")
{
$facturado="$where estado like 'f'";
$where="and";
}


// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CODI")
	$orden="cod_servicio,fecha"; //nombre_cliente

else if ($clasificacion=="DATA") 
 	$orden="fecha,cod_servicio"; //nombre_cliente

else if ($clasificacion=="NOM")
	$orden="nombre_cliente,cod_servicio,fecha";


// Realizamos la consulta: 
$servicios="SELECT * FROM servicios $fact $cliente $empres $periodo $facturado";
//echo "<br />$servicios";
$result_ord=mysql_query($servicios, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $servicios <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>
</head>

<body>
<table>
<form name="resumen_ord" method="post" action="">
          <tr class="titulo"> 
            <td colspan="9">Resum de Serveis</td>
          </tr>
          <tr>
            <td width="4">&nbsp;</td>
            <td colspan="4"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td colspan="2" align="right"><strong>Data inicial:</strong> <? echo "$fecha_i"; ?></td>
            <td align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
            <td width="11">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><? if($cod_factura){ echo "<strong>Factura:</strong> $cod_factura";}?></td>
            <td colspan="3" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="7"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="47"><strong>Servei</strong></td>
            <td width="38"><strong>Data</strong></td>
            <td width="46"><strong>Client</strong></td>
            <td width="279"><strong>Nom</strong></td>
            <td width="91">&nbsp;</td>
            <td width="93"><strong>Matr&iacute;cula</strong></td>
            <td width="90"><div align="right"><strong>Import</strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="7"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los servicios mostrados:
$total_importe=sel_campo("SUM(base)","total_importe","servicios","$fact $cliente $empres $periodo $facturado");

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$servicios="SELECT * FROM servicios $fact $cliente $empres $periodo $facturado ORDER BY $orden $limit";
//echo "<br />$servicios";
$result_ord=mysql_query($servicios, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $servicios <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_servicio=$ord["cod_servicio"];
$fecha=fecha_esp($ord["fecha"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$base=$ord["base"];
$matricula=$ord["matricula"];
?>
          <tr>
            <td>&nbsp;</td>
			 <td class="vinculo" onClick="mostrar(event,direccion_conta('1_1_servicios_gondola.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_servicio','<? echo $cod_servicio; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_servicio; ?></td>
            <td><? echo "$fecha"; ?></td>
            <td><? echo "$cod_cliente"; ?></td>
            <td colspan="2"><? echo "$nombre_cliente"; ?>&nbsp;</td>
            <td><? echo "$matricula"; ?></td>
            <td><div align="right"><? echo formatear($base); ?></div></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
} // Fin de if ($total_filas > 0)

// Rellenamos con filas:
paginar("rellenar");
?>
<tr>
  <td>&nbsp;</td>
  <td colspan="7"><hr /></td>
  <td>&nbsp;</td>
</tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="3">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="fecha_ini"; $valor_pag[3]=$fecha_i;
$campo_pag[4]="fecha_fin"; $valor_pag[4]=$fecha_f;
$campo_pag[5]="ver"; $valor_pag[5]=$ver;
$campo_pag[6]="clasificacion"; $valor_pag[6]=$clasificacion;

// Paginamos:
paginar("paginar");
?>            </td>
            <td colspan="4"><div align="right"><strong>Total Import: <? echo formatear($total_importe); ?></strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="7"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'4_3_impr_listado_serv.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_cliente','<? echo "$cod_cli"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','','','','','','','','');">
			  <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='4_1_resumen_serv.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>