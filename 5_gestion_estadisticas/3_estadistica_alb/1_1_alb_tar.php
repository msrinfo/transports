<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Localitzar Albarans per Targeta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
$fecha_ini="01-01-".$usuario_any;
$fecha_fin="31-12-".$usuario_any;
?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="resumen_alb" method="post" action="1_2_listado_alb_tar.php">
  <tr class="titulo"> 
       <td colspan="4">Localitzar Albarans per Targeta</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="31%">&nbsp;</td>
    <td width="67%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
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
    <td align="right">Client:</td>
    <td><input name="cod_cliente" title="Codi Client" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo "$cod_cliente"; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'cod_albaran',cod_albaran.value,'','','','','','','','','refrescar');" onMouseOut="this.blur()" <? echo $readonly_final; ?>>
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
      <input name="nombre_cliente" title="Nom Client" type="text" id="nombre_cliente" size="40" maxlength="" value="<? echo "$nombre_cliente"; ?>" readonly="true" class="readonly"></td>
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
    <td align="right">Data Inicio:</td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Data Final:</td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
    <td></td>
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
      <input name="Submit" type="submit" value="Enviar">
      &nbsp;<input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('');">    </td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>