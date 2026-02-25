<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Control Vehiculos</title>
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
<form name="resumen_alb" method="post" action="2_2_listado_control_vehiculos.php">
		  <tr class="titulo"> 
       		<td colspan="14">Control Vehiculos</td>
		  </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
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
            <td align="right">Targeta:</td>
            <td><input name="cod_tarjeta" title="Targeta" type="text" id="cod_tarjeta" size="10" maxlength="7" value="<? echo "$cod_tarjeta"; ?>" onBlur="buscar_conta(event,'tarjetas',cod_tarjeta.value,'cod_tarjeta',cod_tarjeta.value,'','','','','','','','','','','');" onMouseOut="this.blur()">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tarjeta');">
              <input name="mat1" title="mat1" type="text" id="mat1" size="10" maxlength="10" value="<? echo "$mat1"; ?>" readonly="true" class="readonly">
&nbsp;&nbsp;&nbsp;Tractora:
<input name="cod_tractora" title="Codi Tractora" type="text" id="cod_tractora" size="3" maxlength="3" value="<? echo $cod_tractora; ?>" onBlur="buscar_conta(event,'tractoras',cod_tractora.value,'cod_tractora',cod_tractora.value,'','','','','','','','','','','');">
<img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tractora');">
<input name="mat2" title="mat2" type="text" id="mat2" size="10" maxlength="10" value="<? echo "$mat2"; ?>" readonly="true" class="readonly"></td>
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