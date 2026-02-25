<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listado de Stocks</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<?
//$=$_GET[""];
$cod_familia=$_GET["cod_familia"];
$cod_fam=$cod_familia;
$descripcion=$_GET["descripcion"];
$stock_min=$_GET["stock_min"];
$stock_max=$_GET["stock_max"];
$orden=$_GET["orden"];
$clasificacion=$_GET["clasificacion"];


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
// Especificamos la consulta: 
$sql="SELECT * FROM articulos $cliente $periodo";
//$articulos="SELECT * FROM art_alb WHERE cod_albaran IN ($sql) $articulo ORDER BY $orden";
$result_art=mysql_query($sql, $link);
$total_filas = mysql_num_rows($result_art);

$exist="SELECT SUM(existencias) as total FROM articulos $cliente $periodo";
$result_exis=mysql_query($exist, $link);

while($art=mysql_fetch_array($result_exis))
{
	$total=$art["total"];
} //Fin while

$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_empresa,$nom_empresa,$fecha_i,$fecha_f;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="14">LISTADO DE STOCKS</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7" align="right"><strong>Resultados: <? echo "$total_filas"; ?></strong></td>
    <td></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
    <td></td>
  </tr>
  <tr> 
    <td width="1%"></td>
    <td width="20%"><strong>ART&Iacute;CULO</strong></td>
    <td colspan="3"><strong>DESCRIPCI&Oacute;N</strong></td>
    <td colspan="2"><strong>FAMILIA</strong></td>
    <td width="24%" align="right"><strong>EXISTENCIAS</strong></td>
    <td width="2%"></td>
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


if ($result_art)
{
while($art=mysql_fetch_array($result_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cod_familia=$art["cod_familia"];
$existencias=$art["existencias"];

$descripcion=sel_campo("descripcion","","familias","cod_familia='$cod_familia'");

$cont++;
cabecera();
?>
  <tr> 
    <td></td>
    <td><? echo "$cod_articulo"; ?></td>
    <td colspan="3"><? echo "$descr_art"; ?></td>
    <td><? echo "$cod_familia"; ?></td>
    <td><? echo "$descripcion"; ?></td>
    <td align="right"><? echo "$existencias"; ?></td>
    <td></td>
  </tr>
<?
} // Fin de while($alb=mysql_fetch_array($result_fact)
} // Fin de if ($result_fact)

$cont+=2;
cabecera();
?>
  <tr> 
    <td></td>
    <td></td>
    <td width="3%"></td>
    <td width="12%"></td>
    <td width="12%"></td>
    <td width="26%" colspan="2"></td>
    <td></td>
    <td></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="7"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7" align="right"><strong>Total Existencias: <? echo "$total"; ?></strong></td>
    <td></td>
  </tr>
</table>
</body>
</html>