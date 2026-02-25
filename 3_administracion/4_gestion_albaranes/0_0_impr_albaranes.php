<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Impressi&oacute; d'Albarans</title>
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
<form name="form1" method="post" action="0_1_impr_albaranes.php">
          <tr class="titulo"> 
            <td colspan="4">Impressi&oacute; d'Albarans</td>
          </tr>
          <tr> 
            <td width="7">&nbsp;</td>
            <td width="407">&nbsp;</td>
            <td width="520">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Empresa:</div></td>
            <td><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Data :</div></td>
            <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','form1','fecha_ini')"></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Conductor: </div></td>
            <td><input name="cod_operario" title="C&oacute;digo Conductor" type="text" id="cod_operario" size="2" maxlength="2" value="<? echo "$cod_operario"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
              <input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="40" maxlength="40" value="<? echo "$nombre_op"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2"><div align="center"> 
           <input name="ver" type="button" value="Veure" onClick="mostrar(event,'0_1_impr_albaranes.php','cod_empresa',cod_empresa.value,'fecha_ini',fecha_ini.value,'','','cod_operario',cod_operario.value,'','','','','','','','','','','','');">
            <input name="Nou" type="button" value="Nou" onClick="location.href=direccion_conta('');">
              </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>