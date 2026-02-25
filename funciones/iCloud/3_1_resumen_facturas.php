<?
$agrupado=$_GET["agrupado"];

// Título:
$titulo="";
if ($agrupado=="si")
	$titulo="S/T";
?>
<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resumen de Facturas a Clientes <? echo $titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?
if (!$fecha_ini)
{
$fecha_ini="01-01-".$usuario_any;
}

if (!$fecha_fin)
{
$fecha_fin="31-12-".$usuario_any;
}
?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form action="3_2_listado_resumen_facturas.php" method="post" name="resumen_fact" id="resumen_fact">
  <tr class="titulo"> 
       <td colspan="4">Resumen de Facturas enviadas a SERES <? echo $titulo; ?></td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="33%">&nbsp;</td>
    <td width="65%"><input name="agrupado" id="agrupado" type="hidden" value="<? echo $agrupado; ?>"></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><!--<div align="right">Cliente: </div></td>
    <td><input name="cod_cliente" type="text" id="cod_cliente" size="4" maxlength="4" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
      <input name="nombre_cliente" type="text" id="nombre_cliente" size="40" maxlength="40"></td>-->
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Fecha Inicio:</div></td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo $fecha_ini; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_fact','fecha_ini')" align="absmiddle"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Fecha Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo $fecha_fin; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','resumen_fact','fecha_fin')" align="absmiddle"></td>
    <td>&nbsp;</td>
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
    <td><div align="right">Clasificaci&oacute;n:</div></td>
    <td><select name="clasificacion" id="clasificacion">
      <option>NOMBRE</option>
      <option>COD. CLI.</option>
<?
if ($agrupado!="si")
{
?>
      <option>FECHA</option>
      <option>COD. FAC.</option>
<? } ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
<?
if ($agrupado=="si")
{
?>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Detallado:</div></td>
    <td><select name="detallado" id="detallado">
      <option value="si">SI</option>
      <option value="no">NO</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
<? } ?>
<?
if ($graf_activar=="si")
{
?>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">Ver en gr&aacute;fica: </div></td>
    <td><select name="graf_concepto" id="graf_concepto">
      <option>Total</option>
      <option>Bruto</option>
      <option>Base Imp.</option>
      <option><? echo $nombre_impuesto; ?></option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de: Si las gráficas están activadas.
?>
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