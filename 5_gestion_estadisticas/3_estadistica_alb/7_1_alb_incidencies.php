<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Incid&egrave;ncies</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if (!$fecha_ini)
{
$fecha_hoy=getdate();
$fecha_ini="1-1-".$usuario_any;
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
<form action="7_2_listado_alb_incidencias.php" method="post" name="resumen_fact" id="resumen_fact">
  <tr class="titulo"> 
       <td colspan="14">Albarans Incid&egrave;ncies</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td align="right">Empresa:</td>
    <td><select name="cod_empresa" id="cod_empresa">
      <? mostrar_lista("empresas",$cod_empresa); ?>
    </select></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Incid&egrave;ncia:</td>
    <td><input name="incidencias" title="incidencias" type="text" id="incidencias" size="50" maxlength="40"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Data Inici:</td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_fact','fecha_ini')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Data Final:</td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_fact','fecha_fin')"></td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right"></td>
    <td></td>
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
      <input name="Submit2" type="submit" value="Cancelar">   </td>
    <td></td>
  </tr>
  </form>
</table>
</body>
</html>