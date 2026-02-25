<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inventario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>



<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


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

$nombre_familia=sel_campo("descripcion","","familias","cod_familia = '$cod_familia'");

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

$total_filas = mysql_num_rows($result_art);

//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------

?>
<body>
<table>
<form action="result_inventario.php" method="post" name="result_inventario" id="result_inventario">
 <tr class="titulo"> 
    <td colspan="14">Inventario</td>
 </tr>
  <tr>
    <td width="1"></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="5" align="right"><strong>Resultados:<strong><? echo "$total_filas"; ?></strong></td>
    <td width="15"></td>
  </tr>
  <tr>
    <td></td>
    <td valign="bottom"><strong>Familia:</strong></td>
    <td valign="bottom"><? echo "$cod_familia"; ?> - <? echo "$nombre_familia"; ?></td>
    <td width="81" valign="bottom"></td>
    <td width="69" valign="bottom"></td>
    <td width="100" valign="bottom"></td>
    <td colspan="2" align="right" valign="bottom"><strong>Fecha: </strong><? echo "$fecha"; ?></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7" valign="bottom"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td valign="bottom"><strong>Art&iacute;culo</strong></td>
    <td valign="bottom"><strong>Descripci&oacute;n</strong></td>
    <td align="right" valign="bottom"><strong>Precio coste</strong></td>
    <td align="right" valign="bottom"><strong>PVP</strong></td>
    <td align="right" valign="bottom"><strong>Existencias</strong></td>
    <td width="64" align="right" valign="bottom"><strong>Valor Coste</strong></td>
    <td width="79" align="right" valign="bottom"><strong>Valor Venta </strong></td>

    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7" valign="top"><hr /></td>
    <td></td>
  </tr>
  <?
if ($result_art)
{
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$articulos="SELECT * FROM articulos WHERE cod_familia = '$cod_familia' ORDER BY cod_articulo $limit";
$exist="SELECT SUM(existencias) as total FROM articulos WHERE cod_familia = '$cod_familia'";
$result_art=mysql_query($articulos, $link);
$result_exis=mysql_query($exist, $link);

$i=0;

//While para sacar datos del articulo
while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cod_familia=$art["cod_familia"];
$existencias=$art["existencias"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];

	
?>
  <tr>
    <td height="19">&nbsp;</td>
    <td width="94"><? echo "$cod_articulo"; ?></td>
    <td width="224"><? echo "$descr_art"; ?></td>
    <td align="right"><? echo "$precio_coste"; ?></td>
    <td align="right"><? echo "$precio_venta"; ?></td>
    <td align="right"><? echo "$existencias"; ?></td>
    <td align="right"><? $valor= $precio_coste * $existencias; echo "$valor"; //$valor_tot=($valor_tot + $valor);?></td>
    <td align="right"><? $valor_vta= $precio_venta * $existencias; echo "$valor_vta"; 
//$valor_tot=($valor_tot + $valor);?></td>
    <td></td>
  </tr>
  <?
} //Fin While Datos de articulo

//While para sumar existencias
while($art=mysql_fetch_array($result_exis))
{
	$total=$art["total"];
} //Fin while*/


} // Fin de if ($result_art)

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="7"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5" align="right"><strong>Total Existencias: <? echo "$total"; ?></strong></td>
    <td align="right"><strong>Total Coste: <?  echo "$valor_tot"; ?></strong></td>
    <td align="right"><strong>Total Venta:<?  echo "$valor_vta_tot"; ?></strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4">
      <?
$campo_pag[1]="cod_familia"; $valor_pag[1]=$cod_fam;

// Paginamos:
paginar("paginar");


?>
    </td>
    <td></td>
    <td colspan="2"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7" align="center">
	  <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='art_inventario.php'">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'impr_listado_invent.php','cod_familia','<? echo "$cod_fam"; ?>','fecha','<? echo "$fecha"; ?>','','','','','','','','','','','','','','','','');">	</td>
    <td></td>
  </tr>
   </form>
</table>
</body>
</html>
