<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Operaris Festes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if (!$fecha_ini)
{
$fecha_hoy=getdate();
$fecha_ini="01-01-".$usuario_any;
}

if (!$fecha_fin)
{
$fecha_hoy=getdate();
$fecha_fin="31-12-".$usuario_any;
}
?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form action="5_2_listado_op_festes.php" method="post" name="resumen_fact" id="resumen_fact">
  <tr class="titulo"> 
       <td colspan="14">Operaris Festes</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Conductor:</div></td>
    <td><input name="cod_operario" title="C&oacute;digo Conductor" type="text" id="cod_operario" size="2" maxlength="2" value="<? echo "$cod_operario"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
      <input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="40" maxlength="40" value="<? echo "$nombre_op"; ?>" readonly="true" class="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Concepto:</div></td>
    <td><input name="observaciones" title="observaciones" type="text" id="observaciones" size="50" maxlength="40"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Data Inici:</div></td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_fact','fecha_ini')"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Data Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_fact','fecha_fin')"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Ordre:</div></td>
    <td><select name="clasificacion" id="clasificacion">
	<option>OPERARI</option>
	<option>DATA</option>
	</select>	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center">
      <input name="Submit" type="submit" value="Enviar">
      <input name="Submit2" type="submit" value="Cancelar"></td>
    <td>&nbsp;</td>
  </tr>
  </form>
</table>
</body>
</html>