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
<form name="resumen_alb" method="post" action="1_2_listado_alb_operarios.php">
		  <tr class="titulo"> 
       		<td colspan="14">Resumen de Operarios en &Oacute;rdenes</td>
		  </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td align="right">Cliente:</td>
            <td>
			<input name="cod_cliente" type="text" id="cod_cliente" size="4" maxlength="4" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
            <input name="nombre_cliente" type="text" id="nombre_cliente" size="40" maxlength="40"></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td align="right">Operario:</td>
            <td><input name="cod_operario" title="C&oacute;digo Ch&oacute;fer" type="text" id="cod_operario" value="<? echo "$cod_operario"; ?>" size="4" maxlength="4" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'cod_cliente',cod_cliente.value,'','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
              <input name="nombre" title="Nombre" type="text" id="nombre" size="50" maxlength="100" value="<? echo "$nombre"; ?>"></td>
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
            <td align="right">Empresa:</td>
            <td><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td align="right">Clasificaci&oacute;n:</td>
            <td>
			<select name="clasificacion">
			<option>CÓDIGO</option>
			<option>FECHA</option>
			<option>NOMBRE</option>
			</select></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td><div align="right">Todas/Pendientes:</div></td>
            <td><select name="ver">
                <option>TODOS</option>
                <option>PENDIENTES</option>
				<option>FACTURADOS</option>
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
            </div></td>
            <td></td>
          </tr>
</form>
</table>
</body>
</html>