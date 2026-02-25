<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Art&iacute;culos No Vendidos</title>
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
<form name="resumen_alb" method="post" action="2_2_listado_art_no_vendidos.php">
		  <tr class="titulo">
            <td colspan="4">Art&iacute;culos No Vendidos</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
    </tr>
          <tr> 
            <td width="6">&nbsp;</td>
            <td width="351"><div align="right">Empresa:</div></td>
            <td width="593"><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td width="5">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Art&iacute;culo:</div></td>
            <td><input name="cod_articulo" title="C&oacute;digo Familia" type="text" id="cod_articulo" size="6" maxlength="5" onBlur="buscar_conta(event,'articulos',cod_articulo.value,'','','','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_articulo');">
              <input name="descr_art" title="Descripci&oacute;n" type="text" id="descr_art" size="40" maxlength="40"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Familia:</div></td>
            <td><input name="cod_familia" title="C&oacute;digo Familia" type="text" id="cod_familia" size="6" maxlength="5" onBlur="buscar_conta(event,'familias',cod_familia.value,'','','','','','','','','','','','','');"> 
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_familia');"> 
              <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="40"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Fecha Inicio:</div></td>
            <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Fecha 
                Final:</div></td>
            <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Clasificaci&oacute;n:</div></td>
            <td><select name="clasificacion">
                <option>CÓDIGO</option>
                <option>DESCRIPCIÓN</option>
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
            <td>&nbsp;</td>
            <td colspan="2"><div align="center"> 
                <input name="Submit" type="submit" value="Enviar">
                <input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('');">
              </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>