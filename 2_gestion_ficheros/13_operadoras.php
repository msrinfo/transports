<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Operadores</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$descripcion=$_POST["descripcion"];
$cod_operadora=$_POST["cod_operadora"];


// Comprobamos si existe:
$comprobar="SELECT * FROM operadoras WHERE cod_operadora = '$cod_operadora'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado operadora: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE operadoras SET

descripcion='$descripcion',
cod_operadora='$cod_operadora'

WHERE cod_operadora='$cod_operadora'";
} // Fin de if ($existe==1)
	
else
{
if (!$cod_operadora)
	$cod_operadora=obtener_max_con("cod_operadora","operadoras","cod_operadora < 99") + 1;

// Insertamos:
$insertar="INSERT INTO operadoras (descripcion,cod_operadora) VALUES ('$descripcion','$cod_operadora')";
} // Fin de else => if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado operadora: ".mysql_error()."<br /> $insertar <br />");


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_operadora','<? echo $cod_operadora; ?>','','','','','','','','','','','','','','','','','','');
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
$cod_operadora=$_GET["cod_operadora"];
$eliminar=$_GET["eliminar"];


//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM operadoras WHERE cod_operadora = '$cod_operadora'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado forma_pago: ".mysql_error()."<br /> $eliminar <br />");

$cod_operadora="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_operadora)
{
$mostrar="SELECT * FROM operadoras WHERE cod_operadora = '$cod_operadora'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado operadora: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$descripcion=$fila["descripcion"];
$cod_operadora=$fila["cod_operadora"];
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

ser_no_vacio[0]="descripcion";

ser_numero[0]="cod_operadora";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
}
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_operadora')">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
       <td colspan="10">Operadores</td>
  </tr>
  <tr>
    <td width="2"></td>
    <td></td>
    <td colspan="2"></td>
    <td width="85"></td>
    <td></td>
    <td width="7"></td>
  </tr>
  <tr>
    <td></td>
    <td width="299" align="right">Codi:</td>
    <td colspan="4">
	<input name="cod_operadora" title="Codi" type="text" id="cod_operadora" size="2" maxlength="2" value="<? echo "$cod_operadora"; ?>" onBlur="buscar_conta(event,'operadoras',cod_operadora.value,'cod_operadora',cod_operadora.value,'','','','','','','','','','','refrescar_sin_borrar_buscar');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operadora');">	</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Descripci&oacute;:</td>
    <td colspan="4"><input name="descripcion" title="Descripció" type="text" id="descripcion" size="40" maxlength="40" value="<? echo a_html($descripcion,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td align="center"></td>
    <td align="center"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td width="94" align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
Guardar</td>
    <td width="85" align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
Nou</td>
    <td align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_operadora');"><br />
Eliminar</td>
    <td width="371"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>