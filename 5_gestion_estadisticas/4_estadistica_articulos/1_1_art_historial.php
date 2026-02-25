<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Historial de Ventas y Compras por Art&iacute;culos y Familias</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if (!$fecha_ini)
{
$fecha_hoy=getdate();
$fecha_ini="1-1-".$fecha_hoy[year];
}

if (!$fecha_fin)
{
$fecha_hoy=getdate();
$fecha_fin="31-12-".$fecha_hoy[year];
}

?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="resumen_alb" method="post" action="1_2_listado_art_historial.php">
  <tr class="titulo"> 
       <td colspan="14">Historial de Ventas y Compras por Art&iacute;culos y Familias</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">C&oacute;digo Art&iacute;culo:</td>
    <td>
	<input name="cod_articulo" title="C&oacute;digo Art&iacute;culo" type="text" id="cod_articulo" value="<? echo "$cod_articulo"; ?>" size="14" maxlength="14" onBlur="buscar_conta(event,'articulos',cod_articulo.value,'cod_articulo',cod_articulo.value,'','','','','','','','','','','');">
    <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_articulo');">
    <input name="descr_art" title="Descripci&oacute;n Art." type="text" id="descr_art" size="40" maxlength="40" value="<? echo "$descr_art"; ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">C&oacute;digo Familia:</td>
    <td>
	<input name="cod_familia" title="C&oacute;digo Familia" type="text" id="cod_familia" size="6" maxlength="5" value="<? echo "$cod_familia"; ?>" onBlur="buscar_conta(event,'familias',cod_familia.value,'','','','','','','','','','','','','');">
    <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_familia');">
    <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="40" value="<? echo "$descripcion"; ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Fecha Inicio:</td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Fecha Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Ver:</td>
    <td>
	<select name="ver" id="ver">
      <option>COMPRAS</option>
      <option selected>VENTAS</option>
      <option>AMBAS</option>
    </select>
    </td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Clasificaci&oacute;n:</td>
    <td>
	<select name="clasificacion">
      <option>C&Oacute;DIGO</option>
      <option>DESCRIPCI&Oacute;N</option>
    </select></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="center">
      <input name="Submit" type="submit" value="Enviar">
      <input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('');">
    </td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>