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

mostrar(event,'3_2_fac_alb_impr.php','cod_factura_ini',cod_factura,'cod_factura_fin',cod_factura,'cod_empresa',cod_empresa,'','','','','','','','','','','','','','');
}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" id="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="12">Ver Facturas</td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td width="93"><div align="right"><strong>N&ordm; Factura: </strong></div></td>
            <td width="75"><input name="cod_factura" title="Código Factura" type="text" id="cod_factura" size="6" maxlength="6" value="<? echo "$cod_factura"; ?>" onBlur="buscar_conta(event,'facturas',cod_factura.value,'cod_factura',cod_factura.value,'cod_empresa',cod_empresa.value,'cod_cliente',cod_cliente.value,'','','','','','','refrescar');">
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura');"></td>
            <td colspan="2"><strong>Empresa:</strong>              <select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td width="134"><div align="right"><strong>Fecha:</strong></div></td>
            <td width="76"><? echo "$fac_fecha"; ?></td>
            <td colspan="4" align="right"><strong>Forma Pago:</strong> <? echo $forma_pago; ?></td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"><strong>N&ordm; Cliente:</strong></div></td>
            <td><input name="cod_cliente" title="Código Cliente" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo "$cod_cliente"; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');"></td>
            <td colspan="4"><input name="nombre_cliente" title="Nombre Cliente" type="text" id="nombre_cliente" size="50" maxlength="" value="<? echo "$nombre_cliente"; ?>" readonly="true" class="readonly"></td>
            <td colspan="4"><div align="right">
              <? if ($cod_asiento) {echo "<strong>Asiento:</strong> "; ?>
              <span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_asiento;} ?></span></div></td>
            <td>&nbsp;</td>
          </tr>       
          <tr>
            <td>&nbsp;</td>
            <td colspan="10"><hr /></td>
            <td>&nbsp;</td>
          </tr>
		    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>Uds.</strong></td>
    <td align="right"><strong>Prec.</strong></td>
    <td align="right"><strong>Imp</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
$art_alb="SELECT *
FROM albaranes
WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'
ORDER BY fecha,cod_albaran";

//echo "<br /> $art_alb <br />";
$result_art_alb=mysql_query($art_alb, $link) or die ("<br /> No se han seleccionado artículos: ".mysql_error()."<br /> $art_alb <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_art_alb);

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

if ($total_filas > 0)
{

while($alb=mysql_fetch_array($result_art_alb))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_descarga=fecha_esp($alb["fecha_descarga"]);
$cod_descarga=$alb["cod_descarga"];
$a_cobrar=$alb["a_cobrar"];
$base=$alb["base"];

$poblacion_desc=sel_campo("poblacion","","descargas","cod_descarga = '$cod_descarga'");
$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga = '$cod_descarga'");


// LITROS SERVIDOS:
$suma_servidos=$alb["suma_servidos"];


if($a_cobrar=="1")
{
$total_servidos=$base;
}
else
{
//$total_servidos=$suma_servidos;
$total_servidos = redondear($suma_servidos * $precio_cli);
}


// LITROS BOMBA:
$lts_desc_bomba=$alb["lts_desc_bomba"];
$prec_desc_bomba_cli=$alb["prec_desc_bomba_cli"];
$total_bomba = redondear($lts_desc_bomba * $prec_desc_bomba_cli);

// DOBLE CARGA:
$prec_doble_carga_cli=$alb["prec_doble_carga_cli"];

// DOBLE DESCARGA:
$prec_doble_desc_cli=$alb["prec_doble_desc_cli"];

// HORAS ESPERA
$horas_espera=$alb["horas_espera"];
$prec_horas_espera=$alb["prec_horas_espera"];
$observ_horas_espera=$alb["observ_horas_espera"];


?>


  <tr>
    <td width="1">&nbsp;</td>
    <td colspan="6"><strong><? /*echo $cont." ";*/ echo "Albarà Nº $cod_albaran amb data $fecha_descarga &nbsp;&nbsp;&nbsp;".strtoupper($poblacion_desc); ?></strong>      <div align="right"></div></td>
    <td width="72" align="right">&nbsp;</td>
	<td width="49" align="right"><strong>
	  <? if ($base!=0) {echo formatear($base);} ?>
	</strong></td>
	<td width="40">&nbsp;</td>
	<td width="38">&nbsp;</td>
	<td width="1">&nbsp;</td>
  </tr>
  
<?

// Mostramos líneas de aquellos conceptos que deban aparecer:
for ($ii = 0; $ii < 5; $ii++)
{

if (($ii == 0 && $suma_servidos > 0) || ($ii == 1 && $lts_desc_bomba > 0) || ($ii == 2 && $prec_doble_carga_cli > 0) || ($ii == 3 && $prec_doble_desc_cli > 0) || ($ii == 4 && $horas_espera > 0))
{

if ($ii == 0)
{
$descrip="TOTAL LITRES SERVITS";
$cantidad=$suma_servidos;

	if($a_cobrar=="1")
		$cantidad=1;
		
$precio=$precio_cli;
$importe=$base;
$total_filas++;
}
else if ($ii == 1)
{
$descrip="TOTAL LITRES AMB BOMBA";
$cantidad=$lts_desc_bomba;
$precio=$prec_desc_bomba_cli;
$importe=$total_bomba;
$total_filas++;
}
else if ($ii == 2)
{
$descrip="DOBLE CÀRREGA";
$cantidad="";
$precio="";
$importe=$prec_doble_carga_cli;
$total_filas++;
}
else if ($ii == 3)
{
$descrip="DOBLE DESCÀRREGA";
$cantidad="";
$precio="";
$importe=$prec_doble_desc_cli;
$total_filas++;
}
else if ($ii == 4)
{
$descrip="HORES ESPERA"." ".$observ_horas_espera;
$cantidad=$horas_espera;
$precio=$prec_horas_espera;
$importe=$horas_espera*$prec_horas_espera;
$total_filas++;
}

?>
  <tr>
    <td></td>
    <td colspan="3"><? /*echo $ii." ";*/ ?><? echo $descrip; ?>      <div align="right"></div>      <div align="right"></div></td>
    <td width="95">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><? if ($cantidad!=0) {echo $cantidad;} ?></td>
    <td width="72" align="right"><? if ($precio!=0) {echo $precio;} ?></td>
	<td width="49" align="right"><? if ($importe!=0) {echo formatear($importe); } ?></td>
	<td width="40">&nbsp;</td>
	<td width="38">&nbsp;</td>
	<td width="1">&nbsp;</td>
  </tr>
<?
} // Fin de if
} // Fin de for ($ii = 0; $ii < 4; $ii++)

        /*  <tr bgcolor="<? echo $color; ?>">
            <? //echo "$color"; ?>
            <td>&nbsp;</td>
            <td><div align="left"><? echo $cod_albaran; ?></div></td>
            <td colspan="2">&nbsp;</td>
            <td colspan="3"><? echo $poblacion_desc; ?></td>
            <td><div align="right"><? echo $cantidad; ?></div></td>
            <td><div align="right"><? echo formatear($precio); ?></div></td>
            <td><div align="right"><? echo formatear($tipo_descuento); ?></div></td>
            <td><div align="right"><? echo formatear($importe); ?></div></td>
            <td >&nbsp;</td>
          </tr>
<?*/
} // Fin de if ($total_filas > 0)
}

// Rellenamos con filas:
paginar("rellenar");
?>

		  <tr>
            <td>&nbsp;</td>
            <td colspan="10">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_emp;
$campo_pag[2]="cod_factura"; $valor_pag[2]=$cod_factura;

// Paginamos:
paginar("paginar");
?>			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td><strong>Venc. 1:</strong></td>
            <td><? echo $venci[1]; ?></td>
            <td width="39"><strong>Venc. 2:</strong></td>
            <td><? echo $venci[2]; ?></td>
            <td><strong>Venc. 3:</strong></td>
            <td><? echo $venci[3]; ?></td>
            <td><strong>Venc. 4:</strong></td>
            <td><? echo $venci[4]; ?></td>
            <td><strong>Venc. 5:</strong></td>
            <td><? echo $venci[5]; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>Imp.  1: </strong></td>
            <td><? echo formatear($imp_venci[1]); ?></td>
            <td><strong>Imp.  2:</strong></td>
            <td><? echo formatear($imp_venci[2]); ?></td>
            <td><strong>Imp.  3:</strong></td>
            <td><? echo formatear($imp_venci[3]); ?></td>
            <td><strong>Imp.  4:</strong></td>
            <td><? echo formatear($imp_venci[4]); ?></td>
            <td><strong>Imp.  5:</strong></td>
            <td><? echo formatear($imp_venci[5]); ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Bruto</strong></td>
            <td><div align="right"></div></td>
            <td><div align="right"><strong>Imp. Gastos F. </strong></div></td>
            <td><div align="right"><strong>Dto. Pr. P.</strong></div></td>
            <td colspan="2"><div align="right"><strong> I.V.A.:</strong></div>              <div align="right"></div></td>
            <td>&nbsp;</td>
            <td><div align="right"><strong>Total:</strong></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td><? echo formatear($fac_bruto); ?></td>
			<td><div align="right"></div></td>
			<td><div align="right"><? echo formatear($imp_gastos_finan); ?></div></td>
            <td><div align="right"><? echo formatear($imp_descuento_pp); ?></div></td>
            <td><div align="right"></div></td>
            <td><div align="right"><? echo $tipo_iva; ?>% <? echo formatear($fac_iva); ?></div></td>
            <td>&nbsp;</td>
            <td><div align="right"><? echo formatear($fac_total); ?></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10">
              <div align="center">
                <textarea name="observ_fact" id="observ_fact" title="Observaciones" cols="138" rows="4" onKeyPress="long_max_obs_fac(event)" <? if ($cod_cliente) { ?> <? } ?>><? echo $observ_fact; ?></textarea>              
                <input type="submit" name="mod_obs" value="Modificar Obs.">
              </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="10"><div align="center">
              <input name="reset" type="button" value="Nova Recerca" onClick="location.href=direccion_conta('');">
                <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="enviar(event);"></div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>