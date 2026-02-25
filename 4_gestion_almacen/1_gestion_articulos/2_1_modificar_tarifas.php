<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Modificar Tarifas de Art&iacute;culos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_familia=$_POST["cod_familia"];
$incremento=$_POST["incremento"];

// Si recibimos familia, modificamos la tarifa de los artículos de esa familia exclusivamente:
$familia="";
if ($cod_familia)
	$familia="WHERE cod_familia = '$cod_familia'";

$consulta_fam="SELECT * FROM articulos $familia";
$query_fam=mysql_query($consulta_fam, $link) or die ("<br /> No se han obtenido artículos: ".mysql_error()."<br /> $consulta_fam <br />");

while($fam=mysql_fetch_array($query_fam))
{
$cod_articulo=$fam["cod_articulo"];
$precio_venta=$fam["precio_venta"];

$precio_venta = $precio_venta + ($precio_venta * ($incremento/100));

$update_art="UPDATE articulos SET precio_venta = '$precio_venta' WHERE cod_articulo = '$cod_articulo'";
$query_art=mysql_query($update_art, $link) or die ("<br /> No se han actualizado artículos: ".mysql_error()."<br /> $update_art <br />");
}

// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
alert("TARIFA MODIFICADA.");
location.href=direccion_conta('');
</script>
<?
} // Fin de if ($_POST)

//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------


?>
<script type="text/javascript">
function enviar(event)
{
var incremento = document.getElementById('incremento').value;

//if(imprime && incremento!="")
if (event.target.id=="imprimir")
{
var cod_familia = document.getElementById('cod_familia').value;

mostrar(event,'2_2_impr_tarifas.php','cod_familia',cod_familia,'','','','','','','','','','','','','','','','','','');
} // Fin de if (event.target.id=="imprimir")



else if (incremento=="" || isNaN(incremento) || incremento < -99 || incremento > 99)
	{
	alert ('% Incremento ha de ser un nº comprendido entre -99 y 99.');
	return false;
	}

else if (document.getElementById('cod_familia').value=='')
	{
	if (confirm('¿REALMENTE desea modificar las tarifas de TODAS las familias?'))
		document.forms[0].submit();
	}

else
	{
	document.forms[0].submit();
	}
	
	
	
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="cli_fam" id="cli_fam" method="post" action="">
  <tr class="titulo"> 
    <td colspan="14">Modificar Tarifas de Art&iacute;culos</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td width="103" align="right">Familia</td>
    <td width="135">
	<input name="cod_familia" title="C&oacute;digo Familia" type="text" id="cod_familia" size="4" maxlength="3" value="<? echo "$cod_familia"; ?>" onBlur="buscar_conta(event,'familias',cod_familia.value,'cod_familia',cod_familia.value,'','','','','','','','','','','');">
   <img src="/comun/imgs/lupa.gif" width="15" height="16" align="absmiddle" onClick="abrir(event,'cod_familia');"></td>
    <td colspan="3">
	<input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="" value="<? echo "$descripcion"; ?>"></td>
    <td width="96"></td>
    <td width="81"></td>
    <td width="81"></td>
    <td width="82"></td>
    <td width="61"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">% Incremento</td>
    <td>
	<input name="incremento" title="% Incremento" type="text" id="incremento" size="4" maxlength="3" value="<? echo "$incremento"; ?>"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10"></td>
    <td></td>
  </tr>
  <tr>
    <td ></td>
    <td></td>
    <td></td>
    <td width="72"></td>
    <td width="94" align="center"> 
	<img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar()" onMouseOver="window.top.focus();"><br />
	Guardar</td>
    <td width="90" align="center">
	<img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
      Nou</td>
    <td align="center">
 	<img src="/comun/imgs/imprimir.gif" title="Imprimir" id="imprimir" onClick="enviar(event);"><br />
      Imprimir</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td ></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>