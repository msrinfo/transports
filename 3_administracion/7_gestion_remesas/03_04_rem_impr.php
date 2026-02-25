<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listado Cobros</title>


<? echo $archivos; ?>
<link href="/comun/css/impresion_conta.css" rel="stylesheet" type="text/css" />


<?
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_remesa=$_GET["cod_remesa"];
}

$c=sel_sql("
SELECT *
FROM cobros
WHERE cod_empresa = '$cod_empresa' AND cod_remesa = '$cod_remesa'
ORDER BY cod_cliente,fecha_cobro,cod_cobro");

$total_filas=count($c);

$lineas_pag=50; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$fecha,$hora;


// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
            <td colspan="11">Listado Cobros</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
            <td width="63"><div align="right"><strong><!--Fecha:--></strong></div></td>
            <td width="86"><? //echo fecha_esp($fecha); ?></td>
            <td align="right"><strong>Resultados:</strong> <? echo $total_filas; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
            <td><div align="right"><strong><!--Hora:--></strong></div></td>
            <td><? //echo $hora; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="9"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td width="73"><strong>N&ordm; Cobro</strong></td>
            <td width="85"><div align="left"><strong>Fecha </strong></div></td>
            <td width="76"><strong>N&ordm; Factura</strong></td>
            <td width="89"><div align="right"><strong>Importe</strong></div></td>
            <td width="12">&nbsp;</td>
            <td width="297"><strong>Pagador</strong></td>
            <td colspan="2">&nbsp;</td>
            <td width="182">&nbsp;</td>
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
for ($i=0; $i < count($c); $i++)
{
$cont++;
cabecera();

if ($c[$i]['tabla']=='socios')
{
$d=sel_sql("SELECT referencia FROM socios WHERE cod_socio = '".$c[$i]['cod_cliente']."'");
}

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par_impr;
else
	$color=$color_impar_impr;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
         	<td><div align="left"><? echo $c[$i]['cod_cobro']; ?></div></td>
         	<td><div align="left"><? echo fecha_esp($c[$i]['fecha_cobro']); ?></div></td>
         	<td><div align="left"><? if ($c[$i]['cod_factura']!=0) {echo $c[$i]['cod_factura'];} ?></div></td>
         	<td><div align="right"><? echo formatear($c[$i]['total_cobro']); ?></div></td>
            <td>&nbsp;</td>
            <td colspan="4"><? echo $c[$i]['cod_cliente'],' '; if ($c[$i]['tabla']=='socios') {echo '(',$d[0]['referencia'],') ';} echo $c[$i]['nombre_cliente']; ?></td>
            <td>&nbsp;</td>
          </tr>
<?
$total += $c[$i]['total_cobro'];
} // Fin de for
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong>Total: </strong></div></td>
            <td><div align="right"><strong><? echo formatear($total); ?></strong></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
</table>
</body>
</html>