<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Targetes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
$fecha_hoy=getdate();
$fecha_actual=$fecha_hoy[mday].'-'.$fecha_hoy[mon].'-'.$fecha_hoy[year];




//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_tarjeta=$_POST["cod_tarjeta"];
$mat1=$_POST["mat1"];
$gps=$_POST["gps"];
$itv_mat1=fecha_ing($_POST["itv_mat1"]);
$adr_mat1=fecha_ing($_POST["adr_mat1"]);
$tacograf_mat1=fecha_ing($_POST["tacograf_mat1"]);
$tarjet_mat1=fecha_ing($_POST["tarjet_mat1"]);
$extint_mat1=fecha_ing($_POST["extint_mat1"]);
$seguro_mat1=fecha_ing($_POST["seguro_mat1"]);
$adr_rev_mat1=fecha_ing($_POST["adr_rev_mat1"]);


$cod_tractora=$_POST["cod_tractora"];
$mat2=$_POST["mat2"];

$itv_mat2=fecha_ing($_POST["itv_mat2"]);
$adr_mat2=fecha_ing($_POST["adr_mat2"]);
$cbrac_mat2=fecha_ing($_POST["cbrac_mat2"]);
$extint_mat2=fecha_ing($_POST["extint_mat2"]);
$seguro_mat2=fecha_ing($_POST["seguro_mat2"]);
$varilla_mat2=fecha_ing($_POST["varilla_mat2"]);



// Comprobamos si existe:
$comprobar="SELECT * FROM tarjetas WHERE cod_tarjeta = '$cod_tarjeta'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado tarjeta: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE tarjetas SET

mat1='$mat1',
gps ='$gps',
itv_mat1 ='$itv_mat1',
adr_mat1='$adr_mat1',
tacograf_mat1='$tacograf_mat1',
tarjet_mat1='$tarjet_mat1',
extint_mat1='$extint_mat1',
seguro_mat1='$seguro_mat1',
adr_rev_mat1='$adr_rev_mat1',
cod_tractora='$cod_tractora',
mat2='$mat2',
itv_mat2='$itv_mat2',
adr_mat2='$adr_mat2',
cbrac_mat2='$cbrac_mat2',
extint_mat2='$extint_mat2',
seguro_mat2='$seguro_mat2',
varilla_mat2='$varilla_mat2',
cod_tractora='$cod_tractora'

WHERE cod_tarjeta='$cod_tarjeta'";
} // Fin de if ($existe==1)
	
else
{
if (!$cod_tarjeta)
	$cod_tarjeta=obtener_max_con("cod_tarjeta","tarjetas","cod_tarjeta < 999") + 1;

// Insertamos:
$insertar="INSERT INTO tarjetas
(cod_tarjeta,mat1,gps,itv_mat1,adr_mat1,tacograf_mat1,tarjet_mat1,extint_mat1,seguro_mat1,adr_rev_mat1,cod_tractora,mat2,itv_mat2,adr_mat2,cbrac_mat2,extint_mat2,seguro_mat2,varilla_mat2)
VALUES
('$cod_tarjeta','$mat1','$gps','$itv_mat1','$adr_mat1','$tacograf_mat1','$tarjet_mat1','$extint_mat1','$seguro_mat1','$adr_rev_mat1','$cod_tractora','$mat2','$itv_mat2','$adr_mat2','$cbrac_mat2','$extint_mat2','$seguro_mat2','$varilla_mat2')";
} // Fin de else => if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado tarjeta: ".mysql_error()."<br /> $insertar <br />");


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
$eliminar="DELETE FROM tarjetas WHERE cod_tarjeta = '$cod_tarjeta'";

$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado forma_pago: ".mysql_error()."<br /> $eliminar <br />");

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
$mostrar="SELECT * FROM tarjetas WHERE cod_tarjeta = '$cod_tarjeta'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha seleccionado tarjeta: ".mysql_error()."<br /> $mostrar <br />");

//Mostramos los registros
$fila=mysql_fetch_array($result);

$mat1=$fila["mat1"];
$cod_tractora=$fila["cod_tractora"];
$mat2=$fila["mat2"];

$gps=$fila["gps"];
$itv_mat1=$fila["itv_mat1"];
$adr_mat1=$fila["adr_mat1"];
$tacograf_mat1=$fila["tacograf_mat1"];
$tarjet_mat1=$fila["tarjet_mat1"];
$extint_mat1=$fila["extint_mat1"];
$seguro_mat1=$fila["seguro_mat1"];
$adr_rev_mat1=$fila["adr_rev_mat1"];

$itv_mat2=$fila["itv_mat2"];
$adr_mat2=$fila["adr_mat2"];
$cbrac_mat2=$fila["cbrac_mat2"];
$extint_mat2=$fila["extint_mat2"];
$seguro_mat2=$fila["seguro_mat2"];
$varilla_mat2=$fila["varilla_mat2"];


// COMPRACIONES FECHAS TRACTORAS:
$dias_itv1	= (strtotime($fecha_actual)-strtotime($itv_mat1))/86400;
$dias_itv1	= abs($dias_itv1); $dias_itv1 = floor($dias_itv1);	

$dias_adr1	= (strtotime($fecha_actual)-strtotime($adr_mat1))/86400;
$dias_adr1 	= abs($dias_adr1); $dias_itv = floor($dias_adr1);		

$dias_tacog1 = (strtotime($fecha_actual)-strtotime($tacograf_mat1))/86400;
$dias_tacog1 = abs($dias_tacog1); $dias_itv = floor($dias_tacog1);

$dias_tarj1	= (strtotime($fecha_actual)-strtotime($tarjet_mat1))/86400;
$dias_tarj1 = abs($dias_tarj1); $dias_tarj1 = floor($dias_tarj1);		

$dias_ext1	= (strtotime($fecha_actual)-strtotime($extint_mat1))/86400;
$dias_ext1 = abs($dias_ext1); $dias_tarj1 = floor($dias_ext1);

$dias_seg1	= (strtotime($fecha_actual)-strtotime($seguro_mat1))/86400;
$dias_seg1 = abs($dias_seg1); $dias_seg1 = floor($dias_seg1);

$dias_adr_rev1	= (strtotime($fecha_actual)-strtotime($adr_rev_mat1))/86400;
$dias_adr_rev1 = abs($dias_adr_rev1); $dias_adr_rev1 = floor($dias_adr_rev1);


// COMPARACIONES FECHAS CISTERNAS:
$dias_itv2	= (strtotime($fecha_actual)-strtotime($itv_mat2))/86400;
$dias_itv2	= abs($dias_itv2); $dias_itv2 = floor($dias_itv2);	

$dias_adr2	= (strtotime($fecha_actual)-strtotime($adr_mat2))/86400;
$dias_adr2 	= abs($dias_adr2); $dias_adr2 = floor($dias_adr2);		

$dias_cebrac2 = (strtotime($fecha_actual)-strtotime($cbrac_mat2))/86400;
$dias_cebrac2 = abs($dias_cebrac2); $dias_cebrac2 = floor($dias_cebrac2);

$dias_ext2	= (strtotime($fecha_actual)-strtotime($extint_mat2))/86400;
$dias_ext2 = abs($dias_ext2); $dias_ext2 = floor($dias_ext2);		

$dias_seg2	= (strtotime($fecha_actual)-strtotime($seguro_mat2))/86400;
$dias_seg2 = abs($dias_ext1); $dias_seg2 = floor($dias_seg2);

$dias_var2	= (strtotime($fecha_actual)-strtotime($varilla_mat2))/86400;
$dias_var2 = abs($dias_seg1); $dias_var2 = floor($dias_var2);


if($dias_itv1 <= 31)
	$color_itv='#F00';
else 
	$color_itv='#fff';
	
if($dias_adr1 <= 31)
	$color_adr='#F00';
else 
	$color_adr='#fff';

if($dias_tacog1 <= 31)
	$color_tacog='#F00';
else 
	$color_tacog='#fff';

if($dias_tarj1 <= 31)
	$color_tarj='#F00';
else 
	$color_tarj='#fff';	

if($dias_ext1 <= 31)
	$color_ext='#F00';
else 
	$color_ext='#fff';

if($dias_seg1 <= 31)
	$color_seg='#F00';
else 
	$color_seg='#fff';	

if($dias_adr_rev1 <= 31)
	$color_adr_rev='#F00';
else 
	$color_adr_rev='#fff';	

//--------

if($dias_itv2 <= 31)
	$color_itv2='#F00';
else 
	$color_itv2='#fff';
	
if($dias_adr2 <= 31)
	$color_adr2='#F00';
else 
	$color_adr2='#fff';
	
if($dias_cebrac2 <= 31)
	$color_cebrac2='#F00';
else 
	$color_cebrac2='#fff';
	
if($dias_ext2 <= 31)
	$color_ext2='#F00';
else 
	$color_ext2='#fff';	

if($dias_seg2 <= 31)
	$color_seg2='#F00';
else 
	$color_seg2='#fff';	

if($dias_var2 <= 31)
	$color_var2='#F00';
else 
	$color_var2='#fff';		
//$cod_tarjeta=$fila["cod_tarjeta"];
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
ser_numero[1]="cod_tractora";

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
       <td colspan="16">Targetes</td>
  </tr>
  <tr>
    <td width="1"></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="69">&nbsp;</td>
    <td width="70">&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="122">&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="166"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="396" align="right">Tractora:</td>
    <td width="121"><input name="cod_tractora" title="Codi Tractora" type="text" id="cod_tractora" size="3" maxlength="3" value="<? echo $cod_tractora; ?>" onBlur="buscar_conta(event,'tractoras',cod_tractora.value,'cod_tractora',cod_tractora.value,'','','','','','','','','','','');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tractora');">
      <input name="mat2" title="Mat. 2" type="text" id="mat2" size="9" maxlength="7" value="<? echo $mat2; ?>"></td>
    <td width="53">&nbsp;</td>
    <td width="83">&nbsp;</td>
    <td width="79">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Tarjeta:</td>
    <td><input name="cod_tarjeta" title="Codi Tarjeta" type="text" id="cod_tarjeta" size="3" maxlength="3" value="<? echo "$cod_tarjeta"; ?>" onBlur="buscar_conta(event,'tarjetas',cod_tarjeta.value,'cod_tarjeta',cod_tarjeta.value,'','','','','','','','','','','refrescar_sin_borrar_buscar');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tarjeta');">
      <input name="mat1" title="Mat. 1" type="text" id="mat1" size="9" maxlength="7" value="<? echo "$mat1"; ?>"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3" align="center">&nbsp;</td>
    <td colspan="3" align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
Guardar</td>
    <td colspan="3" align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
      Nou</td>
    <td colspan="3" align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_tarjeta');"><br />
      Eliminar</td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11"></td>
    <td>&nbsp;</td>
  </tr>
</form>
</table>
</body>
</html>