<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Operarios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_operario=$_POST["cod_operario"];
$nombre_op=$_POST["nombre_op"];
$precio_hora=$_POST["precio_hora"];


// Comprobamos si existe:
$comprobar="SELECT * FROM operarios WHERE cod_operario = '$cod_operario'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado operario: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE operarios SET

nombre_op='$nombre_op',
precio_hora='$precio_hora'

WHERE cod_operario='$cod_operario'";

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado operario: ".mysql_error()."<br /> $insertar <br />");
} // Fin de if ($existe==1)

else
{
// Insertamos:
$insertar="INSERT INTO operarios (cod_operario,nombre_op,precio_hora) VALUES ('$cod_operario','$nombre_op','$precio_hora')";

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado operario: ".mysql_error()."<br /> $insertar <br />");

// Como es autoincremental, seleccionamos máximo:
$cod_terminal=obtener_max_con("cod_operario","operarios","");
} // Fin de else => if ($existe==1)




// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_operario','<? echo "$cod_operario"; ?>','','','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos script:
exit();
} // Fin de if ($_POST)
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_operario=$_GET["cod_operario"];
$eliminar=$_GET["eliminar"];


//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------


// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM operarios WHERE cod_operario = '$cod_operario'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado operario: ".mysql_error()."<br /> $eliminar <br />");

$cod_operario="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_operario)
{
// Esta variable decidirá si insertamos o bien modificamos un registro existente:
$existe=1;

$mostrar="SELECT * FROM operarios WHERE cod_operario = '$cod_operario'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado operario: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$cod_operario=$fila["cod_operario"];
$nombre_op=$fila["nombre_op"];
$precio_hora=$fila["precio_hora"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN SELECT
//--------------------------------------------------------------------------------------------
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="nombre_op";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
}
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_operario')">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
       <td colspan="7">Operaris</td>
  </tr>
  <tr>
    <td width="9">&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td width="12">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td width="290" align="right">Codi:</td>
    <td colspan="4">
	<input name="cod_operario" title="C&oacute;digo" type="text" id="cod_operario" size="2" maxlength="2" value="<? echo "$cod_operario"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'','','','','','','','','','','refrescar_sin_borrar_buscar');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Nom:</td>
    <td colspan="4">
	<input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="40" maxlength="40" value="<? echo a_html($nombre_op,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Preu/Hora:</td>
    <td colspan="4">
	<input name="precio_hora" title="Comisi&oacute;n" type="text" id="precio_hora" size="5" maxlength="5" value="<? echo $precio_hora; ?>">
	&euro;</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td width="70"><div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
      Guardar</div></td>
    <td width="69"><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
      Nou</div></td>
    <td width="65"><div align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_operario');"><br />
      Eliminar</div></td>
    <td width="428">&nbsp;</td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>