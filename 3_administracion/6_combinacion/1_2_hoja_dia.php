<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Full del Dia</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$dia_hoja=fecha_ing($_GET["dia_hoja"]);

//echo "<br /> cod_empresa: $cod_empresa <br /> dia_hoja: $dia_hoja <br />";

// Seleccionamos operarios que trabajan ese día:
$sel_op="
SELECT cod_operario,nombre_op 
FROM operarios 
WHERE cod_operario NOT IN 
(
SELECT DISTINCT (cod_operario) FROM op_fiestas WHERE fecha_ini <= '$dia_hoja' AND fecha_fin >= '$dia_hoja'
)
ORDER BY nombre_op";
$query_sel_op=mysql_query($sel_op, $link) or die ("<br /> No se han seleccionado operarios: ".mysql_error()."<br /> $sel_op <br />");

$cont=0; // Contador para las casillas de los conductores.
while($op=mysql_fetch_array($query_sel_op))
{
$cont++;

$cod_operario=$op["cod_operario"];
$nombre_op[$cont]=$op["nombre_op"];


// Obtenemos albaranes:
$comprobar="SELECT * FROM albaranes WHERE cod_empresa = '$cod_empresa' and cod_operario = '$cod_operario'
 and (fecha_carga = '$dia_hoja' or fecha_descarga='$dia_hoja') ORDER BY viaje,cod_albaran";
$consultar=mysql_query($comprobar, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $comprobar <br />");

//echo "<br /> comprobar: $comprobar <br />";

$cont2=0; // Contador para las líneas de albarán.
$total[$cont]=0; // Si queremos que los que no tienen albaranes, muestren las horas a 0.

while($alb=mysql_fetch_array($consultar))
{
$cont2++;

$cod_albaran[$cont][$cont2]=$alb["cod_albaran"];
$cod_descarga[$cont][$cont2]=$alb["cod_descarga"];
$viaje[$cont][$cont2]=$alb["viaje"];
$cod_tarjeta[$cont][$cont2]=$alb["cod_tarjeta"];
$poblacion[$cont][$cont2]=sel_campo("poblacion","","descargas","cod_descarga = '".$cod_descarga[$cont][$cont2]."'");
$horas[$cont][$cont2]=sel_campo("horas_descarga","","albaranes","cod_albaran = '".$cod_albaran[$cont][$cont2]."'");

// Hacemos el SUM de las horas de todos los albaranes de ese operario.
$total[$cont]+=$horas[$cont][$cont2];

// Elección de color:
$cod_terminal=$alb["cod_terminal"];
$color_terminal[$cont][$cont2]=sel_campo("color","","terminales","cod_terminal = '$cod_terminal'");

$avisador=$alb["avisador"];
$cod_pedido=$alb["cod_pedido"];
$suma_pedidos=$alb["suma_pedidos"];


if ($avisador)
	$color_alb[$cont][$cont2]="#000";

else if ($suma_pedidos == 0 || $cod_tarjeta[$cont][$cont2] == 999 || $cod_terminal == 99 || $cod_terminal == 999 || $cod_operario == 99 || $cod_operario == 999 || $cod_pedido=="")
{
	$color_alb[$cont][$cont2]="#FF8204";
}
else
	$color_alb[$cont][$cont2]=""; // $color_terminal[$cont][$cont2];
	

} // Fin de while($alb=mysql_fetch_array($consultar))
} // Fin de while($op=mysql_fetch_array($query_sel_op))
} // Fin de if ($_GET)


/*
echo "
<br /> cod_albaran[$cont][$cont2]: ".$cod_albaran[$cont][$cont2]."
<br /> cod_descarga[$cont][$cont2]: ".$cod_descarga[$cont][$cont2]."
<br /> viaje[$cont][$cont2]: ".$viaje[$cont][$cont2]."
<br /> cod_tarjeta[$cont][$cont2]: ".$cod_tarjeta[$cont][$cont2]."
<br /> poblacion[$cont][$cont2]: ".$poblacion[$cont][$cont2]."
<br /> horas[$cont][$cont2]: ".$horas[$cont][$cont2]."
<br /> total: ".$total."
<br />";
//*/


$num_conduc=4; // Nº de conductores a mostrar en horizontal.
$ancho=redondear(100/$num_conduc); // Ancho de las celdas.
?>
</head>

<body onKeyPress="tabular(event);">
<table>
          <tr class="titulo"> 
            <td colspan="<? echo $num_conduc + 2; ?>">Programaci&oacute; del Dia <? echo fecha_esp($dia_hoja); ?></td>
          </tr>
<?
// Recorremos el total de conductores para mostrar resultados:
for ($i=1; $i <= $cont; $i += $num_conduc)
{
?>
		  <tr  bgcolor="#C8C8C8"> 
            <td></td>
<? for ($b=0; $b < $num_conduc; $b++) { 

?>
            <td width="<? echo $ancho; ?>%"><strong><? echo $nombre_op[$i+$b]; if($total[$i+$b]>12){ echo "<font color='#FF0000'>"." (".$total[$i+$b]."h)</font>"; } else{ echo "<font color='#009900'>"." (".$total[$i+$b]."h)</font>"; }?></strong></td>
<? } // Fin de for ?>
            <td></td>
          </tr>
<?
$sep="-"; // Separador de datos a mostrar.
$lineas=15; // Nº máximo de líneas a mostrar por conductor.
for ($a=1; $a <= $lineas; $a++)
{
// Si alguno de los conductores mostrados tiene línea de albarán a mostrar, la mostramos:
$mostrar_lin="";
for ($b=0; $b < $num_conduc; $b++)
{
	if ($cod_albaran[$i+$b][$a])
	{
	$mostrar_lin="si";
	break;
	}
} // Fin de for

if ($mostrar_lin=="si")
{
?>
<tr bgcolor="#E1E1E1" style="font-size:11px;">
	<td></td>
<? for ($b=0; $b < $num_conduc; $b++) { ?>
	<td><strong><? echo "<font color='".$color_alb[$i+$b][$a]."'>".$cod_albaran[$i+$b][$a]."</font>".$sep.$viaje[$i+$b][$a].$sep.$cod_tarjeta[$i+$b][$a].$sep."<font color='".$color_terminal[$i+$b][$a]."'>".strtoupper(substr($poblacion[$i+$b][$a], 0, 12))."</font>".$sep.$horas[$i+$b][$a]; ?></strong></td>
<? } // Fin de for ?>
	<td></td>
</tr>
<?
} // Fin de if ($mostrar_lin=="si")
} // Fin de for ($a=1; $a <= $lineas; $a++)
} // Fin de for ($i=1; $i <= $cont; $i += $num_conduc)
?>
</table>
<?
// Si la fecha recibida corresponde con el día de hoy, refrescamos pasado cierto lapso temporal:
$hoy=getdate();
$fecha_hoy=$hoy[year].'-'.$hoy[mon].'-'.$hoy[mday]; // Fecha en inglés para comparación.

/*if (comparar_fechas($fecha_hoy,$dia_hoja) == 0)
{*/
?>
<script type="text/javascript">
window.onbeforeunload=null;
setTimeout("location.href='?cod_empresa=<? echo $cod_empresa; ?>&dia_hoja=<? echo fecha_esp($dia_hoja); ?>'", 3000);
</script>
<? //} ?>
</body>
</html>