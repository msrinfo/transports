<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tarifes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$desc_tarifa=$_POST["desc_tarifa"];
$cod_tarifa=$_POST["cod_tarifa"];
$salida=$_POST["salida"];
$hora=$_POST["hora"];
$hora_espera=$_POST["hora_espera"];
$cabestrany=$_POST["cabestrany"];
$fuera_horas=$_POST["fuera_horas"];
$kms=$_POST["kms"];
$treballs_varis=$_POST["treballs_varis"];
$peajes=$_POST["peajes"];
$festivos=$_POST["festivos"];
$aseguradora=$_POST["aseguradora"];

// Comprobamos si existe:
$comprobar="SELECT * FROM tarifas WHERE cod_tarifa = '$cod_tarifa'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado tarifa: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE tarifas SET

desc_tarifa='$desc_tarifa',
salida='$salida',
hora='$hora',
hora_espera='$hora_espera',
cabestrany='$cabestrany',
fuera_horas='$fuera_horas',
treballs_varis='$treballs_varis',
kms='$kms',
peajes='$peajes',
festivos='$festivos',
aseguradora='$aseguradora'

WHERE cod_tarifa='$cod_tarifa'";
} // Fin de if ($existe==1)
	
else
{
// Insertamos:
$insertar="INSERT INTO tarifas (desc_tarifa,cod_tarifa,salida,hora,hora_espera,cabestrany,fuera_horas,treballs_varis,kms,peajes,festivos,
aseguradora) VALUES ('$desc_tarifa','$cod_tarifa','$salida','$hora','$hora_espera','$cabestrany','$fuera_horas', '$treballs_varis', '$kms','$peajes','$festivos','$aseguradora')";
} // Fin de else => if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado tarifa: ".mysql_error()."<br /> $insertar <br />");


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_tarifa','<? echo "$cod_tarifa"; ?>','','','','','','','','','','','','','','','','','','');
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
$cod_tarifa=$_GET["cod_tarifa"];
$eliminar=$_GET["eliminar"];


//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM tarifas WHERE cod_tarifa = '$cod_tarifa'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado forma_pago: ".mysql_error()."<br /> $eliminar <br />");

$cod_tarifa="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_tarifa)
{
$mostrar="SELECT * FROM tarifas WHERE cod_tarifa = '$cod_tarifa'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado tarifa: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$desc_tarifa=$fila["desc_tarifa"];
$cod_tarifa=$fila["cod_tarifa"];
$salida=$fila["salida"];
$hora=$fila["hora"];
$hora_espera=$fila["hora_espera"];
$cabestrany=$fila["cabestrany"];
$fuera_horas=$fila["fuera_horas"];
$treballs_varis=$fila["treballs_varis"];
$kms=$fila["kms"];
$peajes=$fila["peajes"];
$festivos=$fila["festivos"];
$aseguradora=$fila["aseguradora"];
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

ser_no_vacio[0]="desc_tarifa";

ser_numero[0]="cod_tarifa";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
}
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="cargar_foco('cod_tarifa');">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
       <td colspan="10">Tarifes</td>
  </tr>
  <tr>
    <td width="2"></td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td width="85"></td>
    <td>&nbsp;</td>
    <td width="7"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="299" align="right">Codi:</td>
    <td colspan="4">
	<input name="cod_tarifa" title="Codi" type="text" id="cod_tarifa" size="2" maxlength="2" value="<? echo "$cod_tarifa"; ?>" onBlur="buscar_conta(event,'tarifas',cod_tarifa.value,'cod_tarifa',cod_tarifa.value,'','','','','','','','','','','refrescar');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tarifa');">	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Descripci&oacute;:</td>
    <td colspan="4"><input name="desc_tarifa" title="Descripció" type="text" id="desc_tarifa" size="40" maxlength="40" value="<? echo a_html($desc_tarifa,"bd->input"); ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Sortida:</td>
    <td colspan="4"><input name="salida" title="Sortida" type="text" id="salida" size="8" maxlength="8" value="<? echo "$salida"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Preu Hora: </td>
    <td colspan="4"><input name="hora" title="Preu Hora" type="text" id="hora" size="8" maxlength="8" value="<? echo "$hora"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Preu Hora Espera: </td>
    <td colspan="4"><input name="hora_espera" title="P. Hora Espera" type="text" id="hora_espera" size="8" maxlength="8" value="<? echo "$hora_espera"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Cabestrany: </td>
    <td colspan="4"><input name="cabestrany" title="Cabestrany" type="text" id="cabestrany" size="8" maxlength="8" value="<? echo "$cabestrany"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Fora Hores: </td>
    <td colspan="4"><input name="fuera_horas" title="Fora Hores" type="text" id="fuera_horas" size="8" maxlength="8" value="<? echo "$fuera_horas"; ?>">
    %</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Preu/Kms.</td>
    <td colspan="4"><input name="kms" title="Preu Kms." type="text" id="kms" size="8" maxlength="8" value="<? echo "$kms"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Treballs Varis: </td>
    <td colspan="4"><input name="treballs_varis" title="Treballs Varis" type="text" id="treballs_varis" size="8" maxlength="8" value="<? echo "$treballs_varis"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Peatges:</td>
    <td colspan="4"><input name="peajes" title="Peatges" type="text" id="peajes" size="8" maxlength="8" value="<? echo "$peajes"; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Festius:</td>
    <td colspan="4"><input name="festivos" title="Festius" type="text" id="festivos" size="8" maxlength="8" value="<? echo "$festivos"; ?>">
    %</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Asseguradora</td>
    <td colspan="4"><input name="aseguradora" title="Asseguradora" type="text" id="aseguradora" size="8" maxlength="8" value="<? echo "$aseguradora"; ?>">
    %</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"></td>
    <td align="center"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="94" align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
Guardar</td>
    <td width="85" align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
Nou</td>
    <td align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_tarifa');"><br />
Eliminar</td>
    <td width="371"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5"></td>
    <td>&nbsp;</td>
  </tr>
</form>
</table>
</body>
</html>