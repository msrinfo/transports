<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de &Oacute;rdenes a Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />

<?
$fecha_hoy=getdate();
$mes=$fecha_hoy[mon];
$ult=ultimo_dia_mes($any,$mes);


if (!$fecha_ini)
{
$fecha_ini="01"."-".$mes."-".$usuario_any;
}

if (!$fecha_fin)
{
$fecha_fin=$ult."-".$mes."-".$usuario_any;
}
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_numero[0]="cod_empresa";
ser_numero[0]="cod_cliente";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
{
document.forms[0].submit();
}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="resumen_alb" method="post" action="7_2_listado_env.php">
  <tr class="titulo">
    <td colspan="4">Resumen de Env&iacute;os de Facturas</td>
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
    <td><div align="right">Cliente: </div></td>
    <td><input name="cod_cliente" type="text" id="cod_cliente" size="4" maxlength="4" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
      <input name="nombre_cliente" type="text" id="nombre_cliente" size="40" maxlength="40"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Fecha Inicio:</div></td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right"><div align="right">Fecha Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Estado:</div></td>
    <td><select name="ver" id="ver">
      <option>TODOS</option>
      <option>OK</option>
      <option>ERROR</option>
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
      <input name="consultar" type="button" value="Enviar" onClick="enviar(event)">
      <input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('');">
    </div></td>
    <td></td>
  </tr>
  </form>
</table>
</body>
</html>