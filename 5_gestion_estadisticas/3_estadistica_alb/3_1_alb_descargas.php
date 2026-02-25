<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Desc&agrave;rregues</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />

<?
$fecha_hoy=getdate();
$any=$usuario_any;
$mes=$fecha_hoy[mon];
$ult=ultimo_dia_mes($any,$mes);


if (!$fecha_ini)
{
$fecha_hoy=getdate();
$fecha_ini="1-".$mes."-".$any;
}

if (!$fecha_fin)
{
$fecha_fin=$ult."-".$mes."-".$any;
}
?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="resumen_alb" method="post" action="3_2_listado_alb_descargas.php">
  <tr class="titulo">
    <td colspan="4">Albarans Desc&agrave;rregues </td>
    </tr>
  <tr>
    <td width="10"></td>
    <td width="390"></td>
    <td width="467"></td>
    <td width="6"></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Empresa:</div></td>
    <td><select name="cod_empresa" id="cod_empresa">
      <? mostrar_lista("empresas",$cod_empresa); ?>
    </select>    </td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td align="right">Desc&agrave;rrega:</td>
    <td><input name="poblacion" title="Poblacion" type="text" id="poblacion" size="40" maxlength="" value="<? echo "$poblacion"; ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Data Inici:</div></td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right"><div align="right">Data Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
    <td></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Classificaci&oacute;:</div></td>
    <td><select name="clasificacion">
      <option>CODI</option>
      <option>DATA</option>
      <option>NOM</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2"><div align="center">
      <input name="Submit" type="submit" value="Enviar">
      <input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('');">
    </div></td>
    <td></td>
  </tr>
  </form>
</table>
</body>
</html>