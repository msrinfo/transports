<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inventario</title>
</head>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------

$fecha=$_GET["fecha"];
$cod_familia=$_GET["cod_familia"];
$cod_fam=$cod_familia; 

//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------

if ($_POST)
{
$fecha=$_POST["fecha"];
$cod_familia=$_POST["cod_familia"];
$cod_fam=$cod_familia;
}

// Especificamos la consulta: 
$sql="SELECT * FROM articulos WHERE cod_familia = '$cod_familia'";
$result_art=mysql_query($sql, $link);

while($art=mysql_fetch_array($result_art))
{
$existencias=$art["existencias"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];

$valorA= $precio_coste * $existencias; 
$valorB= $precio_venta * $existencias;  
$valor_tot=($valor_tot + $valorA);
$valor_vta_tot=($valor_vta_tot + $valorB);

}

$nombre_familia=sel_campo("descripcion","","familias","cod_familia = '$cod_familia'");
$total_filas = mysql_num_rows($result_art);


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_familia,$fecha,$nombre_familia;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="14">INVENTARIO</td>
  </tr>
  <tr>
    <td></td>
    <td><strong>Familia:</strong></td>
    <td colspan="4"><? echo "$cod_familia"; ?> - <? echo "$nombre_familia"; ?></td>
    <td colspan="2" align="right"><strong>Fecha: </strong><? echo "$fecha"; ?></td>
    <td></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
    <td></td>
  </tr>
  <tr> 
    <td width="1%"></td>
    <td width="10%"><strong>Art&iacute;culo</strong></td>
    <td width="27%"><strong>Descripci&oacute;n</strong></td>
    <td align="right"><strong>Precio coste</strong></td>
    <td align="right"><strong>PVP</strong></td>
    <td align="right"><strong>Existencias</strong></td>
    <td width="13%" align="right"><strong>Valor Coste</strong></td>
    <td width="13%" align="right"><strong>Valor Venta </strong></td>
    <td width="1%"></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
    <td></td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();

$articulos="SELECT * FROM articulos WHERE cod_familia = '$cod_familia' ORDER BY cod_articulo";
//echo "<br />$articulos";

$exist="SELECT SUM(existencias) as total FROM articulos WHERE cod_familia = '$cod_familia'";
//echo "$articulos";
//echo "<br />$exist";
$result_art=mysql_query($articulos, $link);
$result_exis=mysql_query($exist, $link);
while($art=mysql_fetch_array($result_exis))
{
	$total=$art["total"];
} //Fin while

if ($result_art)
{
while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cod_familia=$art["cod_familia"];
$existencias=$art["existencias"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];

$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td><? echo "$cod_articulo"; ?></td>
    <td><? echo "$descr_art"; ?></td>
    <td align="right"><? echo "$precio_coste"; ?></td>
    <td align="right"><? echo "$precio_venta"; ?></td>
    <td align="right"><? echo "$existencias"; ?></td>
    <td align="right"><? $valor= $precio_coste * $existencias; echo "$valor"; ?> </td>
    <td align="right"><? $valor_vta= $precio_venta * $existencias;  echo "$valor_vta";//$valor_tot=($valor_tot + $valor);?>	</td>
    <td></td>
  </tr>
<?
} // Fin de while($alb=mysql_fetch_array($result_fact)
} // Fin de if ($result_fact)

$cont+=2;
cabecera();


$exist="SELECT SUM(existencias) as total FROM articulos $cliente $periodo";
//echo "$exist";
$result_exis=mysql_query($exist, $link);

?>
  <tr> 
    <td></td>
    <td></td>
    <td></td>
    <td width="17%"></td>
    <td width="7%"></td>
    <td width="11%"></td>
    <td colspan="2"></td>
    <td></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
    <td></td>
  </tr>
  <tr> 
    <td></td>
    <td align="right"></td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="2" align="right"><strong>Total Existencias: <? echo "$total"; ?></strong></td>
    <td align="right"><strong>Total Coste: <? echo "$valor_tot"; ?></strong></td>
    <td align="right"><strong>Total Venta: <?  echo "$valor_vta_tot"; ?></strong></td>
    <td></td>
  </tr>
</table>
</body>
</html>