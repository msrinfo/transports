<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Inventario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">




<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
$cod_familia=$_GET["cod_familia"];

if ($cod_articulo)
{
// Esta variable decidirá si insertamos o bien modificamos un registro existente:
$existe=1;

$mostrar="SELECT * FROM articulos WHERE cod_articulo = '$cod_articulo'";

$result=mysql_query($mostrar, $link);	

//Mostramos los registros
$fila=mysql_fetch_array($result);

$descripcion=$fila["descripcion"];
}

if ($cod_familia)
{
// Esta variable decidirá si insertamos o bien modificamos un registro existente:
$existe=1;

$mostrar="SELECT * FROM familias WHERE cod_familia = '$cod_familia'";

$result=mysql_query($mostrar, $link);	

//Mostramos los registros
$fila=mysql_fetch_array($result);

$desc_fam=$fila["descripcion"];
}

if (!$fecha)
{
$fecha_hoy=getdate();
$fecha=$fecha_hoy[mday].'-'.$fecha_hoy[mon].'-'.$usuario_any;
}

?>

</head>
<body>
<table>
<form method="post" action="result_inventario.php" name="articulos" id="articulos">
	<tr class="titulo"> 
    <td colspan="14">Inventario</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td width="201" align="right">Fecha:</td>
    <td colspan="2">
	<input name="fecha" type="text" id="fecha" value="<? echo "$fecha"; ?>" size="12" maxlength="15">
   <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','articulos','fecha')"> </td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Familia:</td>
    <td colspan="2"><input name="cod_familia" title="C&oacute;digo Familia" type="text" id="cod_familia" size="4" maxlength="3" value="<? echo "$cod_familia"; ?>" onBlur="buscar_conta(event,'familias',cod_familia.value,'cod_familia',cod_familia.value,'','','','','','','','','','','');">
     <img src="/comun/imgs/lupa.gif" width="15" height="16" align="absmiddle" onClick="abrir(event,'cod_familia');">
     <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="" value="<? echo "$descripcion"; ?>" >
    </td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3" align="center">
      <input name="Submit" type="submit" id="Submit" onClick="" value="Enviar">
      <input name="Reset" type="reset" id="Reset" onClick="location.href='art_inventario.php'" value="Cancelar">
    </td>
    <td></td>
  </tr>
   </form>
</table>
</body>
</html>