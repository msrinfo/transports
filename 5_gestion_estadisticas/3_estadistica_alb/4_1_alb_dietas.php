<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Dietes</title>
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
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_numero[0]="cod_operario";


var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	document.forms[0].submit();
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form action="4_2_dietas.php" method="post" name="resumen_fact" id="resumen_fact">
  <tr class="titulo"> 
       <td colspan="14">Albarans Dietes</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td align="right">Conductor:</td>
    <td><input name="cod_operario" title="C&oacute;digo Conductor" type="text" id="cod_operario" size="2" maxlength="2" value="<? echo "$cod_operario"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
      <input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="40" maxlength="40" value="<? echo "$nombre_op"; ?>" readonly="true" class="readonly"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Preu:</td>
    <td><input name="prec_dieta" title="Preu Dieta" type="text" id="prec_dieta" value="<? echo "$prec_dieta"; ?>" size="5" maxlength="5">
&euro;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Dies:</td>
    <td><input name="dies_reals" title="dies_reals" type="text" id="dies_reals" value="<? echo "$dies_reals"; ?>" size="5" maxlength="5"></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td colspan="2" align="center">
      <input name="listar" id="listar" type="button" value="Enviar" onClick="enviar(event)">
      <input name="cancelar" type="button" value="Cancelar" onClick="direccion_conta('')"></td>
    <td></td>
  </tr>
  </form>
</table>
</body>
</html>