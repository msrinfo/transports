<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de Albaranes por Ch&oacute;feres</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
$fecha_hoy=getdate();
$any=$fecha_hoy[year];
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
<form name="resumen_alb" method="post" action="1_2_listado_terminales.php">
		  <tr class="titulo"> 
       		<td colspan="14">Resumen de Terminales</td>
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
            <td align="right">Conductor:</td>
            <td><input name="cod_operario" title="C&oacute;digo Conductor" type="text" id="cod_operario" size="2" maxlength="2" value="<? echo "$cod_operario"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
            <input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="40" maxlength="40" value="<? echo "$nombre_op"; ?>" readonly="true" class="readonly"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td align="right">Terminal:</td>
            <td><input name="cod_terminal" title="C&oacute;digo Terminal" type="text" id="cod_terminal" size="2" maxlength="2" value="<? echo "$cod_terminal"; ?>" onBlur="buscar_conta(event,'terminales',cod_terminal.value,'cod_terminal',cod_terminal.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_terminal');">
            <input name="nombre_terminal" title="Nombre Terminal" type="text" id="nombre_terminal" size="40" maxlength="40" value="<? echo a_html($nombre_terminal,"bd->input"); ?>" readonly class="readonly"></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td align="right">Operadora:</td>
            <td><input name="cod_operadora" title="C&oacute;digo Operadora" type="text" id="cod_operadora" size="2" maxlength="2" value="<? echo "$cod_operadora"; ?>" onBlur="buscar_conta(event,'operadoras',cod_operadora.value,'cod_operadora',cod_operadora.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operadora');">
            <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="40" value="<? echo a_html($descripcion,"bd->input"); ?>" readonly class="readonly"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td align="right">Fecha Inicio:</td>
            <td>
	<input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
     <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td align="right">Fecha Final:</td>
            <td>
	<input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
     <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td align="right">Clasificaci&oacute;n:</td>
            <td>
			<select name="clasificacion">
			<option>CÓDIGO</option>
			<option>FECHA</option>
			</select></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            </div></td>
            <td></td>
          </tr>
</form>
</table>
</body>
</html>