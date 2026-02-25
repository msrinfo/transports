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
$cod_tractora=$_POST["cod_tractora"];
//$mat2=$_POST["mat2"];
$rem=$_POST["rem"];

$i=0;

$num=count($rem);

echo $num;

for($i=0; $i < $num; $i++)
{
	$mat2=$rem[$i]['mat2'];
	$itv=fecha_ing($rem[$i]['itv']);
	$adr=fecha_ing($rem[$i]['adr']);
	$tacograf=fecha_ing($rem[$i]['tacograf']);
	$extint=fecha_ing($rem[$i]['extint']);
	$seguro=fecha_ing($rem[$i]['seguro']);
	$adr_rev=fecha_ing($rem[$i]['adr_rev']);
	$mto=fecha_ing($rem[$i]['mto']);
	$mto_rev=fecha_ing($rem[$i]['mto_rev']);



// Comprobamos si existe:
$comprobar="SELECT * FROM tractoras WHERE mat2 = '$mat2'";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se ha comprobado: ".mysql_error()."<br /> $comprobar <br />");
$existe=mysql_num_rows($consultar);

if($existe==1)
{
// Modificamos:
$insertar="UPDATE tractoras SET

itv='$itv',
adr='$adr',
tacograf='$tacograf',
extint='$extint',
seguro='$seguro',
adr_rev='$adr_rev',
mto='$mto',
mto_rev='$mto_rev'

WHERE mat2='$mat2'";
} // Fin de if ($existe==1)

$result = mysql_query ($insertar, $link) or die ("<br /> No se ha actualizado: ".mysql_error()."<br /> $insertar <br />");

/*
echo "<br/>INS: $insertar";
exit();
*/
}

// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
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
       <td colspan="15">Tractores</td>
  </tr>
  
  <tr>
    <td width="1"></td>
    <td width="386">&nbsp;</td>
    <td colspan="3"></td>
    <td colspan="4"></td>
    <td colspan="2">&nbsp;</td>
    <td width="258"></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td align="right"></td>
    <td><strong>TRACTORA</strong></td>
    <td><strong>ITV</strong></td>
    <td><strong>ADR</strong></td>
    <td><strong>TACOGRAF</strong></td>
    <td><strong>EXTINTOR</strong></td>
    <td><strong>SEGURO</strong></td>
    <td><strong>TTS</strong></td>
    <td><strong>MTO</strong></td>
    <td><strong>MTO.REV</strong></td>
    <td colspan="4">&nbsp;</td>
  </tr>
 <?
$sql="
SELECT *
FROM tractoras
ORDER BY mat2";
//echo $sql;
$c=sel_sql($sql);
$total_filas=count($c);

$mat_mostrar=$total_filas;
$inicial=0;

for ($i=$inicial; $i < $mat_mostrar; $i++)
{
$mat2=$c[$i]['mat2'];
$itv=$c[$i]['itv'];
$adr=$c[$i]['adr'];
$tacograf=$c[$i]['tacograf'];
$extint=$c[$i]['extint'];
$seguro=$c[$i]['seguro'];
$adr_rev=$c[$i]['adr_rev'];
$mto=$c[$i]['mto'];
$mto_rev=$c[$i]['mto_rev'];


// COMPRACIONES FECHAS TRACTORAS:
$dias_itv = (strtotime($fecha_actual)-strtotime($itv))/86400;
$dias_itv = abs($dias_itv); $dias_itv = floor($dias_itv);	

$dias_adr = (strtotime($fecha_actual)-strtotime($adr))/86400;
$dias_adr = abs($dias_adr); $dias_adr = floor($dias_adr);		

$dias_tacog = (strtotime($fecha_actual)-strtotime($tacograf))/86400;
$dias_tacog = abs($dias_tacog); $dias_tacog = floor($dias_tacog);

$dias_extint = (strtotime($fecha_actual)-strtotime($extint))/86400;
$dias_extint = abs($dias_extint); $dias_extint = floor($dias_extint);		

$dias_segur = (strtotime($fecha_actual)-strtotime($seguro))/86400;
$dias_segur = abs($dias_segur); $dias_segur = floor($dias_segur);

$dias_adr_rev = (strtotime($fecha_actual)-strtotime($adr_rev))/86400;
$dias_adr_rev = abs($dias_adr_rev); $dias_adr_rev = floor($dias_adr_rev);

$dias_mto = (strtotime($fecha_actual)-strtotime($mto))/86400;
$dias_mto = abs($dias_mto); $dias_mto = floor($dias_mto);

$dias_mto_rev = (strtotime($fecha_actual)-strtotime($mto_rev))/86400;
$dias_mto_rev = abs($dias_mto_rev); $dias_mto_rev = floor($dias_mto_rev);



if($dias_itv <= 31)
	$color_itv='#F00';
else 
	$color_itv='#fff';
	
if($dias_adr <= 31)
	$color_adr='#F00';
else 
	$color_adr='#fff';

if($dias_tacog <= 31)
	$color_tacog='#F00';
else 
	$color_tacog='#fff';

if($dias_extint <= 31)
	$color_ext='#F00';
else 
	$color_ext='#fff';

if($dias_segur <= 31)
	$color_seg='#F00';
else 
	$color_seg='#fff';	

if($dias_adr_rev <= 31)
	$color_adr_rev='#F00';
else 
	$color_adr_rev='#fff';

if($dias_mto <= 31)
	$color_mto='#F00';
else 
	$color_mto='#fff';

if($dias_mto_rev <= 31)
	$color_mto_rev='#F00';
else 
	$color_mto_rev='#fff';



// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>


  <tr>
    <td>&nbsp;</td>
    <td align="right"></td>
    <td>
    <input type="text" name="rem[<? echo $i; ?>][mat2]" id="rem[<? echo $i; ?>][mat2]" value="<? echo $mat2; ?>" size="11"></td>
    <td width="67"><input type="text" name="rem[<? echo $i; ?>][itv]" id="rem[<? echo $i; ?>][itv]"  style="background-color:<? echo $color_itv; ?>" maxlength="10" size="9" value="<? echo fecha_esp($itv); ?>"></td>
    <td width="67"><input type="text" name="rem[<? echo $i; ?>][adr]" id="rem[<? echo $i; ?>][adr]" style="background-color:<? echo $color_adr; ?>" maxlength="10" size="9" value="<? echo fecha_esp($adr); ?>"> </td>
    <td width="68"><input type="text" name="rem[<? echo $i; ?>][tacograf]" id="rem[<? echo $i; ?>][tacograf]" style="background-color:<? echo $color_tacog; ?>" maxlength="10" size="9" value="<? echo fecha_esp($tacograf); ?>"></td>
    <td width="73"><input type="text" name="rem[<? echo $i; ?>][extint]" id="rem[<? echo $i; ?>][extint]" style="background-color:<? echo $color_ext; ?>" maxlength="10" size="9" value="<? echo fecha_esp($extint); ?>"></td>
    <td width="61"><input type="text" name="rem[<? echo $i; ?>][seguro]" id="rem[<? echo $i; ?>][seguro]" style="background-color:<? echo $color_seg; ?>" maxlength="10" size="9" value="<? echo fecha_esp($seguro); ?>"></td>
    <td width="60"><input type="text" name="rem[<? echo $i; ?>][adr_rev]" id="rem[<? echo $i; ?>][adr_rev]" style="background-color:<? echo $color_adr_rev; ?>" maxlength="10" size="9" value="<? echo fecha_esp($adr_rev); ?>"></td>
    <td width="56"><input type="text" name="rem[<? echo $i; ?>][mto]" id="rem[<? echo $i; ?>][mto]" style="background-color:<? echo $color_mto; ?>" maxlength="10" size="9" value="<? echo fecha_esp($mto); ?>"></td>
    <td width="209"><input type="text" name="rem[<? echo $i; ?>][mto_rev]" id="rem[<? echo $i; ?>][mto_rev]" style="background-color:<? echo $color_mto_rev; ?>" maxlength="10" size="9" value="<? echo fecha_esp($mto_rev); ?>"></td>
    <td colspan="4">&nbsp;</td>
  </tr>
 <?
}
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
    <td colspan="4" align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="120" align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
Guardar</td>
    <td colspan="2" align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
Nou</td>
    <td colspan="4" align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_tractora');"><br />
      Eliminar</td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10"></td>
    <td>&nbsp;</td>
  </tr>
</form>
</table>
</body>
</html>