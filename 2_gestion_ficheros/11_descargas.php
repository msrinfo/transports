<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Desc&agrave;rregues</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
	
if(!$mts3 || $mts3==0) $mts3='32';	
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_descarga=$_POST["cod_descarga"];
$cod_cliente=$_POST["cod_cliente"];
$poblacion=$_POST["poblacion"];
$gln=$_POST["gln"];
$precio_cli=$_POST["precio_cli"];
$precio_chof=$_POST["precio_chof"];
$horas_descarga=$_POST["horas_descarga"];
	
$mts3=$_POST["mts3"];
$total_kms=$_POST["total_kms"];	
$preu_total_viaje=$_POST["preu_total_viaje"];		
$preu_km=$_POST["preu_km"];		

$usr_modif=$_COOKIE["03_login"]; 
$hoy = getdate();
$fecha_modif=$hoy[year]."-".$hoy[mon]."-".$hoy[mday]." ".$hoy[hours].":".$hoy[minutes].":".$hoy[seconds];

// Comprobamos si existe:
$comprobar="SELECT * FROM descargas WHERE cod_descarga = '$cod_descarga'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado descarga: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE descargas SET

cod_cliente='$cod_cliente',
poblacion='$poblacion',
gln='$gln',
precio_cli='$precio_cli',
precio_chof='$precio_chof',
usr_modif='$usr_modif',
fecha_modif='$fecha_modif',
horas_descarga='$horas_descarga',
mts3='$mts3',
total_kms='$total_kms',
preu_total_viaje='$preu_total_viaje',	
preu_km='$preu_km'

WHERE cod_descarga='$cod_descarga'";
} // Fin de if ($existe==1)
	
else
{
// Insertamos:
$insertar="INSERT INTO descargas (cod_cliente,poblacion,gln,precio_cli,precio_chof,cod_descarga,usr_modif,fecha_modif,horas_descarga,mts3,total_kms,preu_total_viaje,preu_km) VALUES ('$cod_cliente','$poblacion','$gln','$precio_cli','$precio_chof','$cod_descarga','$usr_modif','$fecha_modif', '$horas_descarga','$mts3','$total_kms','$preu_total_viaje','$preu_km')";
} // Fin de else => if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado descarga: ".mysql_error()."<br /> $insertar <br />");


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_descarga','<? echo "$cod_descarga"; ?>','','','','','','','','','','','','','','','','','','');
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
$cod_descarga=$_GET["cod_descarga"];
$eliminar=$_GET["eliminar"];

$cod_cliente=$_GET["cod_cliente"];

if ($cod_cliente)
	$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");

//--------------------------------------------------------------------------------------------
//                                				ELIMINAR
//--------------------------------------------------------------------------------------------
if ($eliminar==2)
{
$eliminar="DELETE FROM descargas WHERE cod_descarga = '$cod_descarga'";	

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado descarga: ".mysql_error()."<br /> $eliminar <br />");

$cod_descarga="";
}
//--------------------------------------------------------------------------------------------
//                                			FIN ELIMINAR
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                				SELECT
//--------------------------------------------------------------------------------------------
if ($cod_descarga)
{
$mostrar="SELECT * FROM descargas WHERE cod_descarga = '$cod_descarga'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado descarga: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$cod_descarga=$fila["cod_descarga"];
$cod_cliente=$fila["cod_cliente"];

$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");

$poblacion=$fila["poblacion"];
$gln=$fila["gln"];
$precio_cli=$fila["precio_cli"];
$precio_chof=$fila["precio_chof"];
$usr_modif=$fila["usr_modif"];
$fecha_modif=$fila["fecha_modif"];
$horas_descarga=$fila["horas_descarga"];
$mts3=$fila["mts3"];	
$total_kms=$fila["total_kms"];		
$preu_total_viaje=$fila["preu_total_viaje"];		
$preu_km=$fila["preu_km"];	
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
	
function calculo_descargas(event)
{
//var preu_total_km = redondear_js(control_dec(document.getElementById('preu_total_km').value));
var precio_cli = redondear_js(control_dec(document.getElementById('precio_cli').value));
var mts3 = redondear_js(control_dec(document.getElementById('mts3').value));
var total_kms = redondear_js(control_dec(document.getElementById('total_kms').value));


// Calculamos:
//var preu_total_viaje = redondear_js(precio_cli * mts3);
var preu_total_viaje = precio_cli;	
var preu_km = redondear_js(preu_total_viaje/total_kms);

//alert(preu_total_viaje);
if (event.type=="blur")
{
//alert(parseFloat('.'));

document.getElementById('preu_total_viaje').value = preu_total_viaje;
document.getElementById('preu_km').value = preu_km;
} // Fin de if
	
if (event.type=="onkeyup")
{
//alert(parseFloat('.'));

document.getElementById('preu_total_viaje').value = preu_total_viaje;
document.getElementById('preu_km').value = preu_km;
} // Fin de if	

} // Fin de function
//--------------------------------------------------------------------------------------------
	
function enviar(event)
{
var longitud = document.getElementById('cod_descarga').value.length;
if (longitud!=7)
{
alert('El código de descarga ha de constar de 7 dígitos.');
return;
}


var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="poblacion";

ser_ambos[0]="cod_cliente";
ser_ambos[1]="cod_descarga";

ser_numero[0]="precio_cli";
ser_numero[1]="precio_chof";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
} // Fin de function


</script>
	
	
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_cliente')">
<table>
  <form name="form1" method="post" action="" >
  	<tr class="titulo"> 
       <td colspan="14">Desc&agrave;rregues</td>
    </tr>
  <tr>
    <td width="6"></td>
    <td></td>
    <td></td>
    <td width="65"></td>
    <td width="98"></td>
    <td width="78"></td>
    <td></td>
    <td width="8"></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="5" align="right">&Uacute;ltima Actualitzaci&oacute; Usuari: <strong> <? echo "$usr_modif";?> </strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="5" align="right">&Uacute;ltima Actualitzaci&oacute; Data: <strong> <? echo fecha_esp(substr($fecha_modif, 0, 10)).substr($fecha_modif, 10); ?> </strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">N&ordm; Client:</div></td>
    <td colspan="5"><input name="cod_cliente" type="text" id="cod_cliente" title="Codi Client" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','refrescar');" value="<? echo "$cod_cliente"; ?>" size="6" maxlength="4">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
      <input name="nombre_cliente" type="text" id="nombre_cliente" title="Nom Client" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" size="40" maxlength="40"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td width="309"><div align="right">Codi Desc&agrave;rrega:</div></td>
    <td colspan="4"><input name="cod_descarga" title="Codi Descàrrega" type="text" id="cod_descarga" size="8" maxlength="7" value="<? echo "$cod_descarga"; ?>" onBlur="buscar_descarga_cli(event)" onMouseOut="this.blur()">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_descarga');"></td>
    <td width="333"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">Poblaci&oacute;: </div></td>
    <td colspan="5"><input name="poblacion" title="població" type="text" id="poblacion" size="40" maxlength="255" value="<? echo a_html($poblacion,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">GLN:</td>
    <td colspan="5"><input name="gln" title="gln" type="text" id="gln" size="40" maxlength="255" value="<? echo a_html($gln,"bd->input"); ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Preu Client: </td>
    <td colspan="5"><input name="precio_cli" title="Preu Client" type="text" id="precio_cli" size="8" maxlength="8" value="<? echo "$precio_cli"; ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Preu Xofer:</td>
    <td colspan="5"><input name="precio_chof" title="Preu Xofer" type="text" id="precio_chof" size="8" maxlength="8" value="<? echo "$precio_chof"; ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Hores:</td>
    <td colspan="5"><input name="horas_descarga" title="Hores" type="text" id="horas_descarga" size="8" maxlength="8" value="<? echo "$horas_descarga"; ?>"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Total Kms:</td>
    <td colspan="5">
	<input name="total_kms" title="total_kms" type="text" id="total_kms" size="8" maxlength="8" value="<? echo "$total_kms"; ?>" onKeyUp="calculo_descargas(event)" onBlur="calculo_descargas(event)" <? echo $readonly_totales; ?>></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Mts3:</td>
    <td colspan="5"><input name="mts3" title="mts3" type="text" id="mts3" size="8" maxlength="8" value="<? echo "$mts3"; ?>" onKeyUp="calculo_descargas(event)" onBlur="calculo_descargas(event)"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Preu Total Viatge: </td>
    <td colspan="5"><input name="preu_total_viaje" title="preu_total_viaje" type="text" id="preu_total_viaje" size="8" maxlength="8" value="<? echo "$preu_total_viaje"; ?>" class="readonly" readonly></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Preu/Km: </td>
    <td colspan="5"><input name="preu_km" title="preu_km" type="text" id="preu_km" size="8" maxlength="8" value="<? echo "$preu_km"; ?>" class="readonly" readonly></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td width="42"></td>
    <td><div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
      Guardar</div></td>
    <td><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
      Nou</div></td>
    <td><div align="center">
      <img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_descarga');"><br />
        Eliminar
    </div></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>