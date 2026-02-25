<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de Cobros</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$tabla=$_GET["tabla"];
} // Fin de if($_GET)
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------

$where='WHERE';

// Si NO recibimos tabla, elegimos por defecto:
if (!$tabla)
{
$tabla='jugadores';
}

// Tabla:
if ($tabla=='clientes')
{
$campo1="cod_cliente";
$campo2="nombre_cliente";
}

else if ($tabla=='socios')
{
$campo1="cod_socio";
$campo2="nombre_socio";
}

else if ($tabla=='jugadores')
{
$campo1="cod_jugador";
$campo2="nombre";
}


if (!$fecha_ini)
{
$fecha_ini="01-01-".$hoy['year'];
}

if (!$fecha_fin)
{
$fecha_fin="31-12-".$hoy['year'];
}
?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form action="03_06_list_cobros.php" method="post" name="resumen_fact" id="resumen_fact">
  <tr class="titulo"> 
       <td colspan="4">Resumen de Cobros</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="33%">&nbsp;</td>
    <td width="65%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
    <td align="right"><div align="right">Empresa:</div></td>
    <td><select name="cod_empresa" id="cod_empresa" onChange="location.href='?cod_empresa='+this.value+'&tabla='+document.getElementById('tabla').value">
      <? mostrar_lista("empresas",$cod_empresa); ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td>&nbsp;</td>
    <td align="right"><div align="right">Fichero:</div></td>
    <td><select name="tabla" id="tabla" onChange="location.href='?cod_empresa='+document.getElementById('cod_empresa').value+'&tabla='+this.value">
      <?
$mat_tabl1[]='clientes';		$mat_tabl2[]='SPONSORS';
$mat_tabl1[]='socios';			$mat_tabl2[]='SOCIOS';
$mat_tabl1[]='jugadores';		$mat_tabl2[]='JUGADORES';

opciones_select($mat_tabl1,$mat_tabl2,$tabla,'');
?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><div align="right">Pagador:</div></td>
    <td><input type="text" name="cod_cliente" id="cod_cliente" title="C&oacute;digo" value="<? echo $cod_cliente; ?>" size="6" maxlength="6" onBlur="buscar_conta(event,'<? echo $tabla; ?>',this.value,'<? echo $campo1; ?>',this.value,'','','','','','','','','','','<? echo $tabla; ?>');">
      <img src="/comun/imgs/lupa.gif" name="lupa" onClick="abrir(event,'cod_cliente');">
      <input type="text" name="nombre_cliente" id="nombre_cliente" title="Nombre" size="50" maxlength="100" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" readonly="true" class="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Fecha Inicio:</div></td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo $fecha_ini; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','','fecha_ini')" align="absmiddle"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Fecha Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo $fecha_fin; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','','fecha_fin')" align="absmiddle"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Efectivo/Remesa:</div></td>
    <td><select name="ver" id="ver">
      <option>TODOS</option>
      <option>EFECTIVO</option>
      <option>REMESA</option>
      </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Clasificaci&oacute;n:</div></td>
    <td><select name="clasificacion" id="clasificacion">
      <option>FECHA</option>
      <option>NOMBRE</option>
      <option>CODIGO PRO.</option>
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
    <td colspan="2" align="center">
      <input name="consultar" type="submit" value="Enviar">
      <input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('')"></td>
    <td>&nbsp;</td>
  </tr>
 </form>
</table>
</body>
</html>