<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resumen de Cobros</title>


<? echo $archivos; ?>
<link href="/comun/css/impresion_conta.css" rel="stylesheet" type="text/css" />


<?
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$tabla=$_GET["tabla"];
$cod_cliente=$_GET["cod_cliente"];
$cod_client=$cod_cliente;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$ve=$ver;
$clasificacion=$_GET["clasificacion"];
}


// Tabla:
if ($tabla=='clientes')
{
$campo1="cod_cliente";
$campo2="nombre_cliente";
}
else if ($tabla=='socios')
{
$campo1="cod_socio";
$campo2="nombre_socio";
}
else if ($tabla=='jugadores')
{
$campo1="cod_jugador";
$campo2="nombre";
}


$where="AND";


// Cliente:
$cliente="";
if ($cod_cliente)
{
$cliente="$where cobros.cod_cliente = '$cod_cliente'";
$where="AND";
}

// Período:
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_cobro BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_cobro >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_cobro <= '$fecha_fin')";

$where="AND";
}

// Ver:
$efec="";
if ($ver!='TODOS')
{
	if ($ver=='EFECTIVO')
		$efec="$where cobros.cod_remesa = 0";
	if ($ver=='REMESA')
		$efec="$where cobros.cod_remesa != 0";

$where="AND";
}

// Clasificación:
if ($clasificacion=="FECHA")
	$orden="fecha_cobro,cod_cobro";
else if ($clasificacion=="NOMBRE")
	$orden="nombre_cliente,fecha_cobro,cod_cobro";
else if ($clasificacion=="CODIGO PRO.")
	$orden="cod_cliente,fecha_cobro,cod_cobro";


// Realizamos la consulta: 
$cobros="
SELECT *
FROM cobros
WHERE cod_empresa = '$cod_empresa'
$cliente $periodo $efec";
//echo "<br />$cobros";
$result_ord=mysql_query($cobros) or die ("No se han seleccionado: ".mysql_error()."<br /> $cobros <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);

while($ord=mysql_fetch_array($result_ord))
{
$suma_importe += $ord["total_cobro"];
}


$lineas_pag=50; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$fecha_i,$fecha_f;


// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="11">Resumen de Cobros</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" align="left">&nbsp;</td>
    <td><div align="right"><strong>Fecha inicial:</strong></div></td>
    <td><? echo $fecha_i; ?></td>
    <td colspan="2" align="right"><strong>Resultados:</strong> <? echo $total_filas; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td><div align="right"><strong>Fecha Final: </strong></div></td>
    <td><? echo $fecha_f; ?></td>
    <td colspan="2" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="9"><hr /></td>
    <td>&nbsp;</td>
  </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td width="65"><strong>Cobro</strong></td>
            <td width="87"><strong>Fecha</strong></td>
            <td width="88"><strong>Pagador</strong></td>
            <td width="245">&nbsp;</td>
            <td width="122"><strong>Concepto</strong></td>
            <td width="78">&nbsp;</td>
            <td width="101">&nbsp;</td>
            <td width="101"><div align="right"><strong>Importe</strong></div></td>
            <td width="76"><div align="right"><strong>Factura</strong></div></td>
            <td width="1">&nbsp;</td>
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


if ($total_filas > 0)
{
$cobros .= " ORDER BY $orden";
//echo "<br />$cobros";
$result_ord=mysql_query($cobros) or die ("No se han seleccionado: ".mysql_error()."<br /> $cobros <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_cobro=$ord["cod_cobro"];
$fecha_cobro=fecha_esp($ord["fecha_cobro"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$cod_factura=$ord["cod_factura"];
$total_cobro=$ord["total_cobro"];
$desc_cobro=$ord["desc_cobro"];

if ($cod_factura!=0)
{
$d=sel_sql("SELECT fac_total FROM facturas WHERE cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura'");
$fac_total=$d[0]['fac_total'];

$cobrado = sel_campo("SUM(total_cobro)","alias","cobros","cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura'");
}

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par_impr;
else
	$color=$color_impr;

$cont++;
cabecera();
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
         	<td><? echo $cod_cobro; ?></td>
            <td><? echo $fecha_cobro; ?></td>
            <td colspan="2"><? echo $cod_cliente.' '.substr($nombre_cliente, 0, 30); ?></td>
            <td colspan="3"><? echo substr($desc_cobro, 0, 30); ?></td>
            <td><div align="right"><? echo formatear($total_cobro); ?></div></td>
            <td><? if ($cod_factura!=0) { ?><div align="right"><? echo $cod_factura; ?></div><? } ?></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de while
} // Fin de: Si hay resultados.

$cont += 2;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="9"><hr /></td>
    <td>&nbsp;</td>
  </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong>Total:</strong></div></td>
            <td><div align="right"><strong><? echo formatear($suma_importe); ?></strong></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
</table>
</body>
</html>