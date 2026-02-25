<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Listado de Stocks</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_familia=$_GET["cod_familia"];
$cod_fam=$cod_familia;
$descripcion=$_GET["descripcion"];
$stock_min=$_GET["stock_min"];
$stock_max=$_GET["stock_max"];
$orden=$_GET["orden"];
$clasificacion=$_GET["clasificacion"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_familia=$_POST["cod_familia"];
$cod_fam=$cod_familia;
$stock_min=$_POST["stock_min"];
$stock_max=$_POST["stock_max"];
$descripcion=$_POST["descripcion"];
$clasificacion=$_POST["clasificacion"];
}
//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------

// Si recibimos alguna variable de búsqueda, especificamos la consulta:
if ($cod_familia || $descripcion || $stock_min || $stock_max)
{

// Variable que utilizaremos en la variable $periodo:
$where="and";

// Si no recibimos cliente, dejamos la variable vacía:
$cliente="WHERE cod_familia = '$cod_familia'";
if (!$cod_familia)
{
	$cliente="";
	// Si cliente está vacío, el contenido de la variable cambia:
	$where="WHERE";
}
// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$stock_min && !$stock_max)
	$periodo="";
else
{
if ($stock_min && $stock_max)
	$periodo="$where stock_min >= '$stock_min' and stock_max <= '$stock_max'";
	
if ($stock_min && !$stock_max)
	$periodo="$where stock_min >= '$stock_min'";
	
if (!$stock_min && $stock_max)
	$periodo="$where stock_max <= '$stock_max'";
}	

} // Fin de if ($cod_articulo || $descr_art || $cod_familia || $stock_min || $stock_max || 

// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="DESCRIPCIÓN"){
	$orden="descr_art,cod_articulo";
}
if ($clasificacion=="CÓDIGO"){
	$orden="cod_articulo,descr_art";
}

//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// Especificamos la consulta: 
$sql="SELECT * FROM articulos $cliente $periodo"; //echo "</br>$sql";
$result_art=mysql_query($sql, $link);
$total_filas = mysql_num_rows($result_art);

//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
 <tr class="titulo"> 
    <td colspan="15">Listado de Stocks</td>
 </tr>
  <tr>
    <td width="0"></td>
    <td colspan="2"></td>
    <td colspan="3"></td>
    <td><div align="right"><strong>Resultados: <? echo "$total_filas"; ?></strong></div></td>
    <td width="0"></td>
  </tr>
  <tr>
    <td></td>
    <td valign="bottom"><strong>Art&iacute;culo</strong></td>
    <td colspan="2" valign="bottom"><strong>Descripci&oacute;n</strong></td>
    <td width="49" valign="bottom"><strong>Familia</strong></td>
    <td width="316" valign="bottom">&nbsp;</td>
    <td align="right" valign="bottom"><strong>Existencias</strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6" valign="top"><hr /></td>
    <td></td>
  </tr>
  <?
if ($result_art)
{

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$articulos="SELECT * FROM articulos $cliente $periodo ORDER BY $orden $limit";
//echo "<br />$articulos";
$exist="SELECT SUM(existencias) as total FROM articulos $cliente $periodo";
//echo "$articulos";
//echo "<br />$exist";
$result_art=mysql_query($articulos, $link);
$result_exis=mysql_query($exist, $link);

//----------------------------        CONDICIONES PAGINADOR        -----------------------------

//While para sacar datos del articulo
while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cod_familia=$art["cod_familia"];
$existencias=$art["existencias"];	

$descripcion=sel_campo("descripcion","","familias","cod_familia='$cod_familia'");
?>
  <tr>
    <td height="19"></td>
    <td width="112"><? echo "$cod_articulo"; ?></td>
    <td colspan="2"><? echo "$descr_art"; ?>
        <div align="center"></div></td>
    <td><? echo "$cod_familia"; ?></td>
    <td><? echo "$descripcion"; ?></td>
    <td width="142" align="right"><? echo "$existencias"; ?></td>
    <td></td>
  </tr>
  <?
} //Fin While Datos de articulo

//While para sumar existencias
while($art=mysql_fetch_array($result_exis))
{
	$total=$art["total"];
} //Fin while

} // Fin de if ($result_art)

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="5">
<?
$campo_pag[1]="cod_articulo"; $valor_pag[1]=$cod_articulo;
$campo_pag[2]="stock_min"; $valor_pag[2]=$stock_min;
$campo_pag[3]="stock_max"; $valor_pag[3]=$stock_max;
$campo_pag[4]="cod_familia"; $valor_pag[4]=$cod_fam;
$campo_pag[5]="clasificacion"; $valor_pag[5]=$clasificacion;

// Paginamos:
paginar("paginar");
?>    </td>
    <td align="center"><strong>Total Existencias: <? echo "$total"; ?></strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6" align="center">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='4_1_listado_stocks.php'">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'4_3_impr_listado_stocks.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','<? echo $campo_pag[7]; ?>','<? echo $valor_pag[7]; ?>','<? echo $campo_pag[8]; ?>','<? echo $valor_pag[8]; ?>','<? echo $campo_pag[9]; ?>','<? echo $valor_pag[9]; ?>','<? echo $campo_pag[10]; ?>','<? echo $valor_pag[10]; ?>');">    </td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>