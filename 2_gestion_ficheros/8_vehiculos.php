<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Vehicles</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$matricula=$_POST["matricula"];
$cod_cliente=$_POST["cod_cliente"];
$bastidor=$_POST["bastidor"];
$marca=$_POST["marca"];
$modelo=$_POST["modelo"];

// Comprobamos si existe:
$comprobar="SELECT matricula FROM vehiculos WHERE matricula = '$matricula'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado vehiculo: ".mysql_error()."<br /> $comprobar <br />");

$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$modificar="UPDATE vehiculos SET

cod_cliente='$cod_cliente',
bastidor='$bastidor',
marca='$marca',
modelo='$modelo'

WHERE matricula = '$matricula'";
} // Fin de if ($existe==1)
	
else
{
// Insertamos:
$modificar="INSERT INTO vehiculos
(matricula,cod_cliente,bastidor,marca,modelo)
VALUES
('$matricula','$cod_cliente','$bastidor','$marca','$modelo')";
} // Fin de else => if ($existe==1)
	
$result = mysql_query($modificar, $link) or die ("<br /> No se ha actualizado vehiculo: ".mysql_error()."<br /> $modificar <br />");

// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'matricula','<? echo $matricula; ?>','','','','','','','','','','','','','','','','','','');
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
$matricula=$_GET["matricula"];
$eliminar=$_GET["eliminar"];


// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM vehiculos WHERE matricula = '$matricula'";
$result=mysql_query($eliminar, $link) or die ("No se ha eliminado vehiculo: ".mysql_error()."<br /> $eliminar <br />");
}


// Mostramos datos de vehiculo:
if ($matricula && !$eliminar)
{
$mostrar="SELECT * FROM vehiculos WHERE matricula = '$matricula'";

$result=mysql_query($mostrar, $link) or die ("No se ha seleccionado vehiculo: ".mysql_error()."<br /> $comprobar <br />");

$fila=mysql_fetch_array($result);

$cod_cliente=$fila["cod_cliente"];
$bastidor=$fila["bastidor"];
$marca=$fila["marca"];
$modelo=$fila["modelo"];

$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
} // Fin de if ($matricula && !$eliminar)
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="matricula";

ser_ambos[0]="cod_cliente";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
  <form name="form1" method="post" action="">
  	<tr class="titulo"> 
       <td colspan="13">Vehicles</td>
    </tr>
  <tr>
    <td width="4"></td>
    <td></td>
    <td></td>
    <td width="65"></td>
    <td width="64"></td>
    <td width="382"></td>
    <td width="4"></td>
  </tr>
  <tr>
    <td></td>
    <td width="346"><div align="right">Matricula:</div></td>
    <td colspan="4"><input name="matricula" title="Matricula" type="text" id="matricula" size="25" maxlength="20" value="<? echo a_html($matricula,"bd->input"); ?>" onBlur="buscar_conta(event,'vehiculos',matricula.value,'matricula',matricula.value,'','','','','','','','','','','refrescar_sin_borrar_buscar');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'matricula');"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Cliente:</div></td>
    <td colspan="4"><input name="cod_cliente" title="Codi Client" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo $cod_cliente; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
      <input name="nombre_cliente" title="Nom Client" type="text" id="nombre_cliente" size="40" maxlength="" value="<? echo $nombre_cliente; ?>" readonly="true" class="readonly"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">N&ordm; Bastidor:</div></td>
    <td colspan="4"><input name="bastidor" title="Nº Bastidor" type="text" id="bastidor" size="60" maxlength="50" value="<? echo a_html($bastidor,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Marca:</div></td>
    <td colspan="4"><input name="marca" title="Marca" type="text" id="marca" size="60" maxlength="50" value="<? echo a_html($marca,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Modelo:</div></td>
    <td colspan="4"><input name="modelo" title="Model" type="text" id="modelo" size="60" maxlength="50" value="<? echo a_html($modelo,"bd->input"); ?>"></td>
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
    <td width="78"><div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
      Guardar</div></td>
    <td><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
      Nou</div></td>
    <td><div align="center">
      <img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'matricula');"><br />
        Eliminar
    </div></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>