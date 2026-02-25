<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gesti&oacute;n de Facturas </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_factura=$_GET["cod_factura"];
$cod_empresa=$_GET["cod_empresa"];


if ($cod_factura && $cod_empresa)
{
$factura="SELECT * FROM facturas WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'";
//echo "<br /> $factura <br />";
$result_fac=mysql_query($factura, $link) or die ("<br /> No se ha seleccionado factura: ".mysql_error()."<br /> $factura <br />");

while($fac=mysql_fetch_array($result_fac))
{
$cod_cliente=$fac["cod_cliente"];
$nombre_cliente=$fac["nombre_cliente"];
$fac_fecha=fecha_esp($fac["fac_fecha"]);

$cod_forma=$fac["cod_forma"];
$forma_pago=sel_campo("descripcion","","formas_pago","cod_forma = '$cod_forma'");

$cod_tipo=$fac["cod_tipo"];
$tipo_pago=sel_campo("desc_tipo","","tipos_pago","cod_tipo = '$cod_tipo'");

for ($i=1; $i<=$num_vencis; $i++) 
{
$venci[$i]=fecha_esp($fac["venci".$i]);
$imp_venci[$i]=$fac["imp_venci".$i];
}

$fac_coste=$fac["fac_coste"];
$fac_bruto=$fac["fac_bruto"];
$gastos_finan=$fac["gastos_finan"];
$imp_gastos_finan=$fac["imp_gastos_finan"];
$descuento_pp=$fac["descuento_pp"];
$imp_descuento_pp=$fac["imp_descuento_pp"];
$fac_base=$fac["fac_base"];
$tipo_iva=$fac["tipo_iva"];
$fac_iva=$fac["fac_iva"];
$recargo_equiv=$fac["recargo_equiv"];
$imp_recargo_equiv=$fac["imp_recargo_equiv"];
$fac_total=$fac["fac_total"];

$observ_fact=$fac["observ_fact"];

// Obtenemos asiento correspondiente:
conectar_base($base_datos_conta);
$cod_asiento=sel_campo("cod_asiento","","asientos","cod_empresa = '$cod_empresa' and txt_predef = 'VE' and cod_factura = '$cod_factura'");
conectar_base($base_datos);
} // Fin de while($fac=mysql_fetch_array($result_fac))
} // Fin de if ($cod_factura && $cod_empresa)
} // Fin de if ($_GET)



if ($_POST)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_factura=$_GET["cod_factura"];
$observ_fact=$_POST["observ_fact"];

mod_sql("UPDATE facturas SET observ_fact = '$observ_fact' WHERE cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura'");

// Recargamos página:
?>
<script type="text/javascript">
//alert("FIN POST");
enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','cod_factura','<? echo $cod_factura; ?>','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos script:
exit();
} // Fin de if ($_POST)
?>
<script type="text/javascript">
function enviar(event)
{
if (event.target.id=="imprimir")
{
var cod_factura = document.getElementById('cod_factura').value;
var cod_empresa = document.getElementById('cod_empresa').value;

mostrar(event,'3_2_fac_serv_impr.php','cod_factura_ini',cod_factura,'cod_factura_fin',cod_factura,'cod_empresa',cod_empresa,'','','','','','','','','','','','','','');
}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" id="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="20">Ver Facturas</td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td><div align="right"><strong>N&ordm; Factura: </strong></div></td>
            <td width="82"><input name="cod_factura" title="Código Factura" type="text" id="cod_factura" size="6" maxlength="6" value="<? echo "$cod_factura"; ?>" onBlur="buscar_conta(event,'facturas',cod_factura.value,'cod_factura',cod_factura.value,'cod_empresa',cod_empresa.value,'cod_cliente',cod_cliente.value,'','','','','','','refrescar');">
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura');"></td>
            <td colspan="2"><strong>Empresa:</strong>              <select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td><div align="right"><strong>Fecha:</strong></div></td>
            <td><? echo "$fac_fecha"; ?></td>
            <td colspan="11" align="right"><strong>Forma Pago:</strong> <? echo $forma_pago; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"><strong>N&ordm; Cliente:</strong></div></td>
            <td><input name="cod_cliente" title="Código Cliente" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo "$cod_cliente"; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');"></td>
            <td colspan="8"><input name="nombre_cliente" title="Nombre Cliente" type="text" id="nombre_cliente" size="50" maxlength="" value="<? echo "$nombre_cliente"; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="32">&nbsp;</td>
			<td width="3">&nbsp;</td>
            <td colspan="3"><div align="right">
              <? if ($cod_asiento) {echo "<strong>Asiento:</strong> "; ?>
              <span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_asiento;} ?></span></div></td>
			<td>&nbsp;</td>
          </tr>
          
          
<?
$art_alb="SELECT *
FROM servicios
WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'
ORDER BY fecha,cod_servicio";

//echo "<br /> $art_alb <br />";
$result_art_alb=mysql_query($art_alb, $link) or die ("<br /> No se han seleccionado artículos: ".mysql_error()."<br /> $art_alb <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_art_alb);

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

if ($total_filas > 0)
{

if ($result_art_alb)
{
while($alb=mysql_fetch_array($result_art_alb))
{
$cod_servicio=$alb["cod_servicio"];
$fecha=fecha_esp($alb["fecha"]);
$cod_tarifa=$alb["cod_tarifa"];
$vehiculo=$alb["vehiculo"];
$matricula=$alb["matricula"];
$pto_asistencia=$alb["pto_asistencia"];
$hora_aviso=$alb["hora_aviso"];
$hora_llegada=$alb["hora_llegada"];
$suma_servidos=$alb["suma_servidos"];

$cant_salida=$alb["cant_salida"];

$cant_hora=$alb["cant_hora"];
$cant_hora_espera=$alb["cant_hora_espera"];
$cant_cabestrany=$alb["cant_cabestrany"];
$cant_treballs_varis=$alb["cant_treballs_varis"];
$cant_kms=$alb["cant_kms"];
$cant_peajes=$alb["cant_peajes"];

$fuera_horas=$alb["fuera_horas"];
$festivos=$alb["festivos"];
$aseguradora=$alb["aseguradora"];

$tot_fuera_horas=$alb["tot_fuera_horas"];
$tot_festivos=$alb["tot_festivos"];
$tot_aseguradora=$alb["tot_aseguradora"];

$imp_fuera_horas=$alb["imp_fuera_horas"];
$imp_festivos=$alb["imp_festivos"];
$imp_aseguradora=$alb["imp_aseguradora"];

$tot_salida=$alb["tot_salida"];
$tot_hora=$alb["tot_hora"];
$tot_hora_espera=$alb["tot_hora_espera"];
$tot_cabestrany=$alb["tot_cabestrany"];
$tot_treballs_varis=$alb["tot_treballs_varis"];
$tot_kms=$alb["tot_kms"];
$tot_peajes=$alb["tot_peajes"];

$subtotal=$alb["subtotal"];

$select_tarifa="SELECT * FROM tarifas WHERE cod_tarifa = '$cod_tarifa'";

$query_tarifa=mysql_query($select_tarifa, $link) or die ("<br /> No se ha seleccionado tarifa: ".mysql_error()."<br /> $select_tarifa <br />");

$tar=mysql_fetch_array($query_tarifa);

$salida=$tar["salida"];
$hora=$tar["hora"];
$hora_espera=$tar["hora_espera"];
$cabestrany=$tar["cabestrany"];
$fuera_horas=$tar["fuera_horas"];
$kms=$tar["kms"];
$treballs_varis=$tar["treballs_varis"];
$peajes=$tar["peajes"];
    
?>
  <tr>
    <td width="1">&nbsp;</td>
    <td valign="bottom"><strong>Servei</strong></td>
    <td valign="bottom"><strong>Data</strong></td>
    <td width="58" valign="bottom"><strong>Vehicle</strong></td>
    <td width="41" valign="bottom">&nbsp;</td>
    <td colspan="2" valign="bottom"><strong>Matr&iacute;cula</strong></td>
    <td colspan="8" valign="bottom"><strong>Punt Ass.</strong></td>
    <td valign="bottom"><strong>Hora Av&iacute;s</strong></td>
    <td colspan="2" valign="bottom"><strong>Hora Arr.</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="17"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="76"><? echo $cod_servicio; ?></td>
    <td><? echo $fecha; ?></td>
    <td colspan="2"><? echo $vehiculo; ?></td>
    <td colspan="2"><? echo $matricula; ?></td>
    <td colspan="8"><? echo $pto_asistencia; ?></td>
    <td><? echo substr($hora_aviso,0,5); ?></td>
    <td colspan="2"><? echo substr($hora_llegada,0,5); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><strong>Quan.</strong></td>
    <td width="60"><div align="right"><strong>Preu</strong></div></td>
    <td width="1">&nbsp;</td>
    <td width="85"><div align="right"><strong>Import</strong></div></td>
    <td width="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>SORTIDA</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_salida!=0) echo $cant_salida; ?></td>
    <td><div align="right"><? if($cant_salida!=0) echo $salida; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_salida!=0) echo $tot_salida; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>HORA</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_hora!=0) echo $cant_hora; ?></td>
    <td><div align="right"><? if($cant_hora!=0) echo $hora; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_hora!=0) echo $tot_hora; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>HORES D&acute; ESPERA </strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_hora_espera!=0) echo $cant_hora_espera; ?></td>
    <td><div align="right"><? if($cant_hora_espera!=0) echo $hora_espera; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_hora_espera!=0) echo $tot_hora_espera; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>SERVEI CABESTRANY </strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_cabestrany!=0) echo $cant_cabestrany; ?></td>
    <td><div align="right"><? if($cant_cabestrany!=0) echo $cabestrany; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_cabestrany!=0) echo $tot_cabestrany; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>QUIL&Ograve;METRES</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_kms!=0) echo $cant_kms; ?></td>
    <td><div align="right"><? if($cant_kms!=0) echo $kms; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_kms!=0) echo $tot_kms; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>TREBALLS VARIS </strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_treballs_varis!=0) echo $cant_treballs_varis; ?></td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $treballs_varis; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if($cant_treballs_varis!=0) echo $tot_treballs_varis; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>PEATGES</strong></td>
    <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><? if($cant_peajes!=0) echo $cant_peajes; ?></td>
    <td><div align="right"><? if($cant_peajes!=0) echo $peajes; ?></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><? if($cant_peajes!=0) echo $tot_peajes; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="18"><hr /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="12"><div><strong>Concepte</strong></div></td>
    <td colspan="2" align="left"><div align="left"><strong>Quan.</strong></div></td>
    <td><div align="right"><strong>Preu</strong></div></td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Import</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="18"><hr /></td>
    </tr>
<?

//} // Fin de if

//} // Fin de if ($rectificado==0)

// Obtenemos los artículos de ese albarán:
$orden_art="
SELECT cod_articulo,descr_art,cantidad,precio_venta,tipo_descuento,neto
FROM art_serv
WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'
ORDER BY cod_linea";

$query_orden_art=mysql_query($orden_art, $link) or die ("<br /> No se han seleccionado artículos de servicios de factura: ".mysql_error()."<br /> $orden <br />");

while($art=mysql_fetch_array($query_orden_art))
{
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];

$cantidad=$art["cantidad"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];
$neto=$art["neto"];


$cont++;
//cabecera();
?>
  <tr>
    <td></td>
    <td colspan="11"><? /*echo $ii." ";*/ ?><? echo $descr_art; ?></td>
    <td width="1">&nbsp;</td>
    <td colspan="2"><? if ($cantidad!=0) {echo formatear($cantidad);} ?></td>
    <td><div align="right">
      <? if ($precio_venta!=0) {echo formatear($precio_venta);} ?>
    </div></td>
    <td>&nbsp;</td>
    <td align="right"><? if ($neto!=0) {echo formatear($neto);} ?></td>
    <td align="right">&nbsp;</td>
  </tr>
    
<?
//} // Fin de if
//} // Fin de for ($ii = 0; $ii < 4; $ii++)
} // Fin de while($alb=mysql_fetch_array($query_orden))

?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Fora d'Hores </strong><? echo $tot_fuera_horas; ?>% <strong> sobre </strong><? echo $subtotal; ?></td>
    <td>&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="17">&nbsp;</td>
    <td width="56">&nbsp;</td>
    <td width="12">&nbsp;</td>
    <td width="1">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo $imp_fuera_horas; ?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Festius </strong><? echo $tot_festivos; ?>% <strong> sobre </strong><? echo $subtotal; ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo $imp_festivos; ?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><strong>Asseguradores/Tallers </strong><? echo "$tot_aseguradora"; ?>% <strong>sobre </strong><? $subtotal1=redondear($subtotal +  $imp_festivos + $imp_fuera_horas); echo formatear($subtotal1); ?> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo "-".$imp_aseguradora; ?></td>
    <td align="right">&nbsp;</td>
  </tr>
<?
} // Fin de if ($rectificado==0)
}
}
?>
          <tr>
            <td>&nbsp;</td>
            <td colspan="18"><hr /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>Venc. 1:</strong></td>
            <td><? echo $venci[1]; ?></td>
            <td><strong>Venc. 2:</strong></td>
            <td><? echo $venci[2]; ?></td>
            <td><strong>Venc. 3:</strong></td>
            <td><? echo $venci[3]; ?></td>
            <td><strong>Venc. 4:</strong></td>
            <td colspan="2"><? echo $venci[4]; ?></td>
            <td colspan="5"><strong>Venc. 5:</strong></td>
            <td><? echo $venci[5]; ?></td>
			<td>&nbsp;</td>
		 	<td>&nbsp;</td>
			<td>&nbsp;</td> 
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>Imp.  1: </strong></td>
            <td><? echo $imp_venci[1]; ?></td>
            <td><strong>Imp. 2:</strong></td>
            <td><? echo $imp_venci[2]; ?></td>
            <td><strong>Imp.  3:</strong></td>
            <td><? echo $imp_venci[3]; ?></td>
            <td><strong>Imp. 4:</strong></td>
            <td><? echo $imp_venci[4]; ?></td>
            <td>&nbsp;</td>
            <td colspan="5"><strong>Imp. 5:</strong></td>
            <td><? echo $imp_venci[5]; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
	        <td>&nbsp;</td>
	        <td align="right"><strong>Bruto</strong></td>
	        <td colspan="2" align="right"><strong>G.Financ.</strong></td>
	        <td colspan="2" align="right"><strong>Dto. Pr.P.</strong> </td>
	        <td colspan="2" align="right"><strong>Base</strong></td>
	        <td colspan="2" align="right"><strong>IVA</strong></td>
	        <td colspan="2">&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        <td align="right"><strong>Rec.Eq.</strong></td>
	        <td>&nbsp;</td>
	        <td align="right"><strong>Total</strong></td>
	        <td>&nbsp;</td>
    </tr>
		   <tr>
    <td>&nbsp;</td>
    <td><div align="right"><? echo formatear($fac_bruto); ?></div></td>
    <td colspan="2"><div align="right"><? echo formatear($imp_gastos_finan); ?>
    </div></td>
    <td colspan="2"><div align="right"><? echo formatear($imp_descuento_pp); ?></div></td>
    <td colspan="2"><div align="right"><? echo formatear($fac_base); ?></div></td>
    <td colspan="2"><div align="right"><? echo formatear($fac_iva); ?></div></td>
    <td colspan="2"><div align="right"></div></td>
    <td><div align="right"></div></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
 	<td align="right"><? echo formatear($imp_recargo_equiv); ?></td>
	<td align="right">&nbsp;</td> 
	<td align="right"><strong><? echo formatear($fac_total); ?> &euro;</strong></td>
 	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="17">              <div align="center">
                <textarea name="observ_fact" id="observ_fact" title="Observaciones" cols="138" rows="4" onKeyPress="long_max_obs_fac(event)" <? if ($cod_cliente) { ?> <? } ?>><? echo $observ_fact; ?></textarea>              
                <input type="submit" name="mod_obs" value="Modificar Obs.">
              </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
            <td>&nbsp;</td>
            <td colspan="18"><div align="center">
              <input name="reset" type="button" value="Nova Recerca" onClick="location.href=direccion_conta('');">
                <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="enviar(event);"></div></td>
  </tr>
</form>
</table>
</body>
</html>