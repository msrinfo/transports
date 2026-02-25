<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tarifas de Art&iacute;culos</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_familia=$_GET["cod_familia"];


$mostrar_alb="
SELECT cod_articulo,descr_art,existencias,precio_coste,precio_venta
FROM articulos
WHERE cod_familia = '$cod_familia'
ORDER BY cod_articulo,descr_art";
$result_alb=mysql_query($mostrar_alb, $link) or die ("<br /> No se han obtenido artículos: ".mysql_error()."<br /> $mostrar_alb <br />");
$total_filas=mysql_num_rows($result_alb);


$descripcion=sel_campo("descripcion","","familias","cod_familia='$cod_familia'");
//echo "<br /> cod_familia: $cod_familia <br /> descripcion: $descripcion <br />";

}  // Fin de if ($_GET)
$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_familia,$fecha,$descripcion;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="14">TARIFAS DE ART&Iacute;CULOS</td>
  </tr>
  <tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="2"><strong>Familia:</strong> <? echo $cod_familia ." ". $descripcion; ?></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"><strong>Resultados: </strong><? echo $total_filas; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="7"><hr /></td>
  </tr>
  <tr>
    <td width="0%">&nbsp;</td> 
    <td width="20%"><strong>Art&iacute;culo</strong></td>
    <td width="44%"><strong>Descripci&oacute;n</strong></td>
    <td width="12%"><div align="right"><strong>Stock</strong></div></td>
    <td width="12%"><div align="right"><strong>Precio Coste </strong></div></td>
    <td width="12%"><div align="right"><strong>Precio Venta </strong></div></td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="7"><hr /></td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


if ($cod_familia)
{
$mostrar_alb="
SELECT cod_articulo,descr_art,existencias,precio_coste,precio_venta
FROM articulos
WHERE cod_familia = '$cod_familia'
ORDER BY cod_articulo,descr_art";

//echo "<br /> mostrar_alb: $mostrar_alb <br />";

$result_alb=mysql_query($mostrar_alb, $link) or die ("<br /> No se han obtenido artículos: ".mysql_error()."<br /> $mostrar_alb <br />");


if($result_alb)
{
while($alb=mysql_fetch_array($result_alb))
{
$cod_articulo=$alb["cod_articulo"];
$descr_art=$alb["descr_art"];
$existencias=$alb["existencias"];
$precio_coste=$alb["precio_coste"];
$precio_venta=$alb["precio_venta"];


$cont++;
cabecera();
?>
  <tr>
    <td>&nbsp;</td> 
    <td><? echo $cod_articulo; ?></td>
    <td><? echo $descr_art; ?></td>
    <td><div align="right"><? echo $existencias; ?></div></td>
    <td><div align="right"><? echo $precio_coste; ?></div></td>
    <td><div align="right"><? echo $precio_venta; ?></div></td>
    <td>&nbsp;</td>
  </tr>
<?
}
} // Fin de while($alb=mysql_fetch_array($result_fact)
} // Fin de if ($result_fact)

$cont+=2;
cabecera();

?>
</table>
</body>
</html>