<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Localizar Art&iacute;culos en Entradas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_articulo=$_GET["cod_articulo"];
$cod_art=$cod_articulo;
$descr_art=$_GET["descr_art"];
$descr_arti=$descr_art;
$cod_proveedor=$_GET["cod_proveedor"];
$cod_prov=$cod_proveedor;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$tipo_iva=$_GET["tipo_iva"];
$clasificacion=$_GET["clasificacion"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_articulo=$_POST["cod_articulo"];
$descr_art=$_POST["descr_art"];
$cod_proveedor=$_POST["cod_proveedor"];
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$tipo_iva=$_POST["tipo_iva"];
$clasificacion=$_POST["clasificacion"];
}


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
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------


?>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="resumen_alb" method="post" action="4_listado_art_ent.php">
  <tr class="titulo"> 
       <td colspan="12">Localizar Art&iacute;culos en Entradas</td>
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
    <td><div align="right">Art&iacute;culo:</div></td>
    <td><input name="cod_articulo" type="text" id="cod_articulo" size="13" maxlength="13" onBlur="buscar_conta(event,'articulos',cod_articulo.value,'cod_articulo',cod_articulo.value,'','','','','','','','','','','');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_articulo');">
      <input name="descr_art" type="text" id="descr_art" size="40" maxlength="40"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Proveedor: </div></td>
    <td><input name="cod_proveedor" type="text" id="cod_proveedor" size="4" maxlength="4" onBlur="buscar_conta(event,'proveedores',cod_proveedor.value,'cod_proveedor',cod_proveedor.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_proveedor');">
      <input name="nombre" type="text" id="nombre_prov" size="40" maxlength="40"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Fecha Inicio:</div></td>
    <td><input name="fecha_ini" type="text" id="fecha_ini" value="<? echo "$fecha_ini"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" align="absmiddle" onClick="muestraCalendario('','resumen_alb','fecha_ini')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Fecha Final:</div></td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<? echo "$fecha_fin"; ?>" size="11" maxlength="10" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" align="absmiddle" onClick="muestraCalendario('','resumen_alb','fecha_fin')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Tipo IVA:</div></td>
    <td><input name="tipo_iva" type="text" id="tipo_iva" size="2" maxlength="2"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Clasificaci&oacute;n:</div></td>
    <td><select name="clasificacion">
      <option>C&Oacute;DIGO</option>
      <option>DESCRIPCI&Oacute;N</option>
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
      <input name="cancelar" type="button" value="Cancelar" onClick="location.href=direccion_conta('');">	</td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>