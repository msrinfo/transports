<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de &Oacute;rdenes a Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
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
$cliente="";
if ($cod_cliente)
{
$cliente="$where cod_cliente = '$cod_cliente'";
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


// En principio la variable $facturado está vacía para mostrar todos los albaranes, pero según lo que valga $ver, mostrará los albaranes pendientes o facturados:
$facturado="";
if ($ver=="OK")
{
$facturado="$where estado like 'OK'";
$where="and";
}
		
else if ($ver=="ERROR")
{
$facturado="$where estado like 'ERROR'";
$where="and";
}

$orden="fecha,hora";


// Realizamos la consulta: 
$albaranes="SELECT * FROM logs_envios $fact $cliente $empres $periodo $facturado";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>
</head>

<body>
<table>
<form name="resumen_ord" method="post" action="">
          <tr class="titulo"> 
            <td colspan="9">Resumen de Env&iacute;os de Facturas</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="347" align="right"><strong>Fecha inicial:</strong> <? echo "$fecha_i"; ?></td>
            <td width="303">&nbsp;</td>
            <td align="right"><strong>Resultados: <? echo "$total_filas"; ?></strong></td>
            <td width="14">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><? if($cod_factura){ echo "<strong>Factura:</strong> $cod_factura";}?></td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong>Fecha Final: </strong><? echo "$fecha_f"; ?></td>
            <td>&nbsp;</td>
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
            <td width="175"><strong>Usuario</strong></td>
            <td width="129"><strong>Fecha</strong></td>
            <td width="138"><strong>Hora</strong></td>
            <td width="402"><strong>Cliente</strong></td>
            <td><strong>Env&iacute;o</strong></td>
            <td><strong>Destinatario</strong></td>
            <td width="330"><div align="right"><strong>Estado</strong></div></td>
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

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$albaranes="SELECT * FROM logs_envios $fact $cliente $periodo $facturado ORDER BY $orden $limit";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

$cont=0;
while($ord=mysql_fetch_array($result_ord))
{
$login=$ord["login"];
$fecha=fecha_esp($ord["fecha"]);
$hora=$ord["hora"];	
$cod_cliente=$ord["cod_cliente"];
	 $nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente='$cod_cliente'");
$accion=$ord["accion"];
$destinatario=$ord["destinatario"];	
$estado=$ord["estado"];	
	
// Decidimos el color de la fila según cont:
$cont++;
if ($cont % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
            <td><? echo $login; ?></td>
            <td><? echo $fecha; ?></td>
            <td><? echo $hora; ?></td>
            <td><? echo $cod_cliente; ?> <? echo $nombre_cliente; ?></td>
            <td><? echo $accion; ?></td>
            <td><? echo $destinatario; ?></td>
            <td><div align="right"><? echo $estado; ?></div></td>
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
            <td colspan="4">&nbsp;</td>
            <td colspan="3" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
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
            <td colspan="3"><div align="right"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="7"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'7_3_impr_listado_env.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_cliente','<? echo "$cod_cli"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','','','','','','','','');">
			  <input name="buscar" type="button" value="Nueva Búsqueda" onClick="location.href='2_1_resumen_alb.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>