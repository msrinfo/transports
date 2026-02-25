<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Art&iacute;culos M&aacute;rgenes Clientes</title>
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
<form action="4_2_listado_art_margenes.php" method="post" name="resumen_benef" id="resumen_benef">
          <tr class="titulo"> 
            <td colspan="4">Art&iacute;culos M&aacute;rgenes Clientes</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr> 
            <td width="17"></td>
            <td width="358"><div align="right">Empresa:</div></td>
            <td width="568"><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td width="12"></td>
          </tr>
          <tr>
            <td></td>
            <td><div align="right">Cliente:</div></td>
            <td><input name="cod_cliente" type="text" id="cod_cliente" size="4" maxlength="4" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
              <input name="nombre_cliente" type="text" id="nombre_cliente" size="40" maxlength="40"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td><div align="right">Art&iacute;culo:</div></td>
            <td><input name="cod_articulo" type="text" id="cod_articulo" size="13" maxlength="13" onBlur="buscar_conta(event,'articulos',cod_articulo.value,'cod_articulo',cod_articulo.value,'','','','','','','','','','','');" <? echo "$habilitar_art"; ?>> 
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_articulo');"> 
              <input name="descr_art" type="text" id="descr_art" size="40" maxlength="40"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td><div align="right">Familia:</div></td>
            <td><input name="cod_familia" type="text" id="cod_familia" size="4" maxlength="4" onBlur="buscar_conta(event,'familias',cod_familia.value,'','','','','','','','','','','','','');"> 
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_familia');"> 
              <input name="descripcion" type="text" id="descripcion" size="30"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td><div align="right">Fecha 
                Inicio:</div></td>
            <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_benef','fecha_ini')"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td><div align="right">Fecha 
                Final:</div></td>
            <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_benef','fecha_fin')"></td>
            <td></td>
          </tr>
          <tr> 
            <td></td>
            <td><div align="right">Clasificaci&oacute;n:</div></td>
            <td><select name="clasificacion">
                <option>Unidades Vendidas</option>
                <option>Beneficios</option>
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