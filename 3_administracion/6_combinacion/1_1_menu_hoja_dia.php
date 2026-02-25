<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Full del Dia</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if (!$dia_hoja)
{
$dia_hoja_hoy=getdate();
$dia_hoja=$dia_hoja_hoy[mday].'-'.$dia_hoja_hoy[mon].'-'.$usuario_any;
}
?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="6">Programaci&oacute; del Dia </td>
          </tr>
		  <tr> 
            <td width="0%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="0%">&nbsp;</td>
          </tr>		  
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">Empresa: 
              <select name="cod_empresa" id="cod_empresa">
                <? mostrar_lista("empresas",$cod_empresa); ?>
              </select></td>
            <td colspan="2">Dia:
              <input name="dia_hoja" title="Fecha" type="text" id="dia_hoja" size="11" maxlength="10"  value="<? echo $dia_hoja; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','form1','dia_hoja')">
</td>
            <td>&nbsp;</td>
          </tr>
		  <tr> 
            <td>&nbsp;</td>
            <td colspan="4" align="center">
			<input name="ver" type="button" value="Veure" onClick="mostrar(event,'1_2_hoja_dia.php','cod_empresa',cod_empresa.value,'dia_hoja',dia_hoja.value,'','','','','','','','','','','','','','','','');"></td>
            <td>&nbsp;</td>
          </tr>	
</form>
</table>
</body>
</html>