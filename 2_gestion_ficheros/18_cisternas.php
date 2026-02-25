<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Targetes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_tarjeta=$_POST["cod_tarjeta"];
$mat1=$_POST["mat1"];


// Comprobamos si existe:
$comprobar="SELECT * FROM cisternes WHERE cod_tarjeta = '$cod_tarjeta'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE cisternes SET

mat1='$mat1'

WHERE cod_tarjeta='$cod_tarjeta'";
} // Fin de if ($existe==1)
	
else
{
if (!$cod_tarjeta)
	$cod_tarjeta=obtener_max_con("cod_tarjeta","cisternes","cod_tarjeta < 999") + 1;

// Insertamos:
$insertar="INSERT INTO cisternes
(cod_tarjeta,mat1)
VALUES
('$cod_tarjeta','$mat1')";
} // Fin de else => if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado: ".mysql_error()."<br /> $insertar <br />");


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_tarjeta','<? echo $cod_tarjeta; ?>','','','','','','','','','','','','','','','','','','');
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
$cod_tarjeta=$_GET["cod_tarjeta"];
$eliminar=$_GET["eliminar"];


//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM cisternes WHERE cod_tarjeta = '$cod_tarjeta'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado: ".mysql_error()."<br /> $eliminar <br />");

$cod_tarjeta="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_tarjeta)
{
$mostrar="SELECT * FROM cisternes WHERE cod_tarjeta = '$cod_tarjeta'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$cod_tarjeta=$fila["cod_tarjeta"];
$mat1=$fila["mat1"];
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

ser_numero[0]="cod_tarjeta";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
}
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_tarjeta')">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
       <td colspan="10">Cisternes</td>
  </tr>
  <tr>
    <td width="2"></td>
    <td width="299">&nbsp;</td>
    <td colspan="2"></td>
    <td width="85"></td>
    <td>&nbsp;</td>
    <td width="7"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Targeta:</td>
    <td colspan="4">
      <input name="cod_tarjeta" title="Codi Targeta" type="text" id="cod_tarjeta" size="3" maxlength="3" value="<? echo $cod_tarjeta; ?>" onBlur="buscar_conta(event,'cisternes',cod_tarjeta.value,'cod_tarjeta',cod_tarjeta.value,'','','','','','','','','','','refrescar_sin_borrar_buscar');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tarjeta');">
      <input name="mat1" title="Mat. 2" type="text" id="mat1" size="9" maxlength="7" value="<? echo $mat1; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
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
    <td align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_tarjeta');"><br />
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