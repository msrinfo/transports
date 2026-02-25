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
$cod_tractora=$_POST["cod_tractora"];
$mat2=$_POST["mat2"];


// Comprobamos si existe:
$comprobar="SELECT * FROM tractoras WHERE cod_tractora = '$cod_tractora'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE tractoras SET

mat2='$mat2'

WHERE cod_tractora='$cod_tractora'";
} // Fin de if ($existe==1)
	
else
{
if (!$cod_tractora)
	$cod_tractora=obtener_max_con("cod_tractora","tractoras","cod_tractora < 999") + 1;

// Insertamos:
$insertar="INSERT INTO tractoras
(cod_tractora,mat2)
VALUES
('$cod_tractora','$mat2')";
} // Fin de else => if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado: ".mysql_error()."<br /> $insertar <br />");


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_tractora','<? echo $cod_tractora; ?>','','','','','','','','','','','','','','','','','','');
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
$cod_tractora=$_GET["cod_tractora"];
$eliminar=$_GET["eliminar"];


//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM tractoras WHERE cod_tractora = '$cod_tractora'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado: ".mysql_error()."<br /> $eliminar <br />");

$cod_tractora="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_tractora)
{
$mostrar="SELECT * FROM tractoras WHERE cod_tractora = '$cod_tractora'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$cod_tractora=$fila["cod_tractora"];
$mat2=$fila["mat2"];
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

ser_numero[0]="cod_tractora";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
}
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_tractora')">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
       <td colspan="10">Tractores</td>
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
    <td align="right">Tractora:</td>
    <td colspan="4">
      <input name="cod_tractora" title="Codi Tractora" type="text" id="cod_tractora" size="3" maxlength="3" value="<? echo $cod_tractora; ?>" onBlur="buscar_conta(event,'tractoras',cod_tractora.value,'cod_tractora',cod_tractora.value,'','','','','','','','','','','refrescar_sin_borrar_buscar');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tractora');">
      <input name="mat2" title="Mat. 2" type="text" id="mat2" size="9" maxlength="7" value="<? echo $mat2; ?>"></td>
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
    <td align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_tractora');"><br />
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