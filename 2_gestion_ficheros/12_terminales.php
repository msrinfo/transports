<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Terminals</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_terminal=$_POST["cod_terminal"];
$nombre_terminal=$_POST["nombre_terminal"];
$color=$_POST["color"];


// Comprobamos si existe:
$comprobar="SELECT * FROM terminales WHERE cod_terminal = '$cod_terminal'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado operario: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE terminales SET

nombre_terminal='$nombre_terminal',
color='$color'

WHERE cod_terminal='$cod_terminal'";

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado terminal: ".mysql_error()."<br /> $insertar <br />");
} // Fin de if ($existe==1)

else
{
if (!$cod_terminal)
	$cod_terminal=obtener_max_con("cod_terminal","terminales","cod_terminal < 99") + 1;

// Insertamos:
$insertar="INSERT INTO terminales (cod_terminal,nombre_terminal,color) VALUES ('$cod_terminal','$nombre_terminal','$color')";

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado terminal: ".mysql_error()."<br /> $insertar <br />");
} // Fin de: insertar


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_terminal','<? echo $cod_terminal; ?>','','','','','','','','','','','','','','','','','','');
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
$cod_terminal=$_GET["cod_terminal"];
$eliminar=$_GET["eliminar"];


//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------


// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM terminales WHERE cod_terminal = '$cod_terminal'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado operario: ".mysql_error()."<br /> $eliminar <br />");

$cod_terminal="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_terminal)
{
$mostrar="SELECT * FROM terminales WHERE cod_terminal = '$cod_terminal'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$cod_terminal=$fila["cod_terminal"];
$nombre_terminal=$fila["nombre_terminal"];
$color=$fila["color"];
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

ser_no_vacio[0]="nombre_terminal";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
}

function guardar_color(color)
{
document.getElementById("color").value=color;
document.getElementById("muestra").bgColor=color;
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_terminal')">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
       <td colspan="8">Terminals</td>
  </tr>
  <tr>
    <td width="8">&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td width="29">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td width="268" align="right">Codi:</td>
    <td colspan="5">
	<input name="cod_terminal" title="Codi" type="text" id="cod_terminal" size="2" maxlength="2" value="<? echo $cod_terminal; ?>" onBlur="buscar_conta(event,'terminales',cod_terminal.value,'cod_terminal',cod_terminal.value,'','','','','','','','','','','refrescar');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_terminal');"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Nom:</td>
    <td colspan="5">
	<input name="nombre_terminal" title="Nom Terminal" type="text" id="nombre_terminal" size="40" maxlength="40" value="<? echo a_html($nombre_terminal,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Color:</td>
    <td colspan="2">
	<input name="color" title="Color" type="text" id="color" size="8" maxlength="7" value="<? echo $color; ?>" readonly="true" class="readonly"></td>
    <td colspan="3">
	<img src="/tt/imgs/pixels/000000.gif" width="1" height="1" onClick="guardar_color('#000000')">
	<img src="/tt/imgs/pixels/00FF00.gif" width="1" height="1" onClick="guardar_color('#00FF00')">
	<img src="/tt/imgs/pixels/0000FF.gif" width="1" height="1" onClick="guardar_color('#0000FF')">
	<img src="/tt/imgs/pixels/00FFFF.gif" width="1" height="1" onClick="guardar_color('#00FFFF')">
	<img src="/tt/imgs/pixels/CCFFFF.gif" width="1" height="1" onClick="guardar_color('#CCFFFF')">	</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">
	<img src="/tt/imgs/pixels/006600.gif" width="1" height="1" onClick="guardar_color('#006600')">
	<img src="/tt/imgs/pixels/9933FF.gif" width="1" height="1" onClick="guardar_color('#9933FF')">
	<img src="/tt/imgs/pixels/663300.gif" width="1" height="1" onClick="guardar_color('#663300')">
	<img src="/tt/imgs/pixels/999999.gif" width="1" height="1" onClick="guardar_color('#999999')">
	<img src="/tt/imgs/pixels/3399FF.gif" width="1" height="1" onClick="guardar_color('#3399FF')">
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Color Actual:</td>
    <td width="50" bgcolor="<? echo $color; ?>" id="muestra">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td colspan="3">
	<img src="/tt/imgs/pixels/FF0000.gif" width="1" height="1" onClick="guardar_color('#FF0000')">
	<img src="/tt/imgs/pixels/FF00FF.gif" width="1" height="1" onClick="guardar_color('#FF00FF')">
	<img src="/tt/imgs/pixels/FFCCFF.gif" width="1" height="1" onClick="guardar_color('#FFCCFF')">
	<img src="/tt/imgs/pixels/FF9900.gif" width="1" height="1" onClick="guardar_color('#FF9900')">
	<img src="/tt/imgs/pixels/990000.gif" width="1" height="1" onClick="guardar_color('#990000')">
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2"><div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
      Guardar</div></td>
    <td width="73"><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
      Nou</div></td>
    <td width="74"><div align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_terminal');"><br />
      Eliminar</div></td>
    <td width="426">&nbsp;</td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>