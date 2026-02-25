<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Desc&agrave;rregues</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_cliente=$_POST["cod_cliente"];
$porcentaje=$_POST["porcentaje"];
$porcentaje_chof=$_POST["porcentaje_chof"];

$usr_modif=$_COOKIE["03_login"]; 
$hoy = getdate();
$fecha_modif=$hoy[year]."-".$hoy[mon]."-".$hoy[mday]." ".$hoy[hours].":".$hoy[minutes].":".$hoy[seconds];

if($cod_cliente)
{
	$comprobar="SELECT * FROM descargas WHERE cod_cliente = '$cod_cliente'";
}
else
{
	$comprobar="SELECT * FROM descargas";
}

$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado descarga: ".mysql_error()."<br /> $comprobar <br />");
$total_filas=mysql_num_rows($consultar);

$cont=1;
while($desc=mysql_fetch_array($consultar))
{
$cod_descarga=$desc["cod_descarga"];

if($cont==1)
	$cod_descarga_ini=$cod_descarga;
else if ($cont==$total_filas)
	$cod_descarga_fin=$cod_descarga;
	
$precio_cli=$desc["precio_cli"];
$precio_chof=$desc["precio_chof"];

$precio_cli = $precio_cli + ($precio_cli * ($porcentaje/100));
$precio_chof = $precio_chof + ($precio_chof * ($porcentaje_chof/100));


// Modificamos:
$insertar="UPDATE descargas SET

precio_cli='$precio_cli',
precio_chof='$precio_chof',
usr_modif='$usr_modif',
fecha_modif='$fecha_modif'

WHERE cod_descarga='$cod_descarga'";

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado descarga: ".mysql_error()."<br /> $insertar <br />");

$cont++;
} // Fin de while($desc=mysql_fetch_array($consultar))
	


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">

<? if ($cod_cliente){ ?>

alert("Descàrregues <? echo $cod_descarga_ini; ?> a <? echo $cod_descarga_fin; ?> del client <? echo $cod_cliente; ?> actualitzades.");

<? } else { ?>

alert("Descàrregues <? echo $cod_descarga_ini; ?> a <? echo $cod_descarga_fin; ?> actualitzades.");

<? } ?>

enlace(direccion_conta(''),'','','','','','','','','','','','','','','','','','','','');

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
$cod_cliente=$_GET["cod_cliente"];

if ($cod_cliente)
	$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");

} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------
?>
<script type="text/javascript">
function enviar(event)
{

var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_ambos[0]="porcentaje";
ser_numero[0]="porcentaje_chof";

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
  <form name="form1" method="post" action="" >
  	<tr class="titulo"> 
       <td colspan="14">Actualitzar Preus Desc&agrave;rregues</td>
    </tr>
  <tr>
    <td width="6"></td>
    <td width="309"></td>
    <td></td>
    <td width="65"></td>
    <td width="98"></td>
    <td width="78"></td>
    <td width="333"></td>
    <td width="8"></td>
  </tr>
  
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="5" align="right">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">N&ordm; Client:</div></td>
    <td colspan="5"><input name="cod_cliente" type="text" id="cod_cliente" title="Codi Client" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','refrescar');" value="<? echo "$cod_cliente"; ?>" size="6" maxlength="4">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
      <input name="nombre_cliente" type="text" class="readonly" readonly="true" id="nombre_cliente" title="Nom Client" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" size="40" maxlength="40"></td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td align="right">% Aplicar Client:</td>
    <td colspan="5"><input name="porcentaje" title="Porcentaje" type="text" id="porcentaje" size="8" maxlength="8" value="<? echo "$porcentaje"; ?>"></td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td align="right">% Aplicar Xofer:</td>
    <td colspan="5"><input name="porcentaje_chof" title="Porcentaje Chof." type="text" id="porcentaje_chof" size="8" maxlength="8" value="<? echo "$porcentaje_chof"; ?>"></td>
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
    <td>&nbsp;</td>
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