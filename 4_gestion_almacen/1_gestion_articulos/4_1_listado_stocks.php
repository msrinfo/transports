<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>	

<title>Listado de Stocks</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">



<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />

</head>
<body>

<?
$cod_articulo=$_GET["cod_articulo"];
$cod_familia=$_GET["cod_familia"];
$clasificacion=$_GET["clasificacion"];


$cod_articulo=$_POST["cod_articulo"];
$cod_familia=$_POST["cod_familia"];
$clasificacion=$_POST["clasificacion"];


?>
<table>
<form name="articulos" method="post" action="4_2_listado_stocks.php">
  <tr class="titulo"> 
    <td colspan="14">Listado de Stocks</td>
  </tr>
  <tr>
  <td width="10"></td>
  </tr>
  <tr>
    <td></td>
    <td width="103"></td>
    <td width="207"></td>
    <td colspan="2"></td>
    <td width="11"></td>
    <td colspan="2"></td>
    <td width="129"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>Familia:</td>
    <td colspan="5"><input name="cod_familia" title="C&oacute;digo Familia" type="text" id="cod_familia" size="4" maxlength="3" value="<? echo "$cod_familia"; ?>" onBlur="buscar_conta(event,'familias',cod_familia.value,'cod_familia',cod_familia.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" width="15" height="16" align="absmiddle" onClick="abrir(event,'cod_familia');">
      <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="" value="<? echo "$descripcion"; ?>" >
    </td>
    <td width="35"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="left">Existencia m&aacute;x.:</td>
    <td>
	<input name="stock_max" type="text" id="stock_max" size="15" maxlength="15" value="<? echo "$stock_max"; ?>" onBlur="comprueba(this.value, 'stock_max')" onMouseMove="comprueba(this.value, 'desc_habitual')">
    </td>
    <td colspan="4"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>Existencia m&iacute;n.: </td>
    <td>
	<input name="stock_min" type="text" id="stock_min" size="15" maxlength="15" value="<? echo "$stock_min"; ?>" onBlur="comprueba(this.value, 'desc_habitual')" onMouseMove="comprueba(this.value, 'desc_habitual')"></td>
    <td width="16"></td>
    <td width="87"></td>
    <td></td>
    <td width="88"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>Clasificaci&oacute;n:</td>
    <td colspan="3"><select name="clasificacion">
      <option>C&Oacute;DIGO</option>
      <option>DESCRIPCI&Oacute;N</option>
    </select></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8" align="center">
      <input name="Submit" type="submit" value="Enviar">
	  <input name="Submit2" type="submit" value="Cancelar"></td>
    <td></td>
  </tr>
  </form>
</table>
</body>
</html>