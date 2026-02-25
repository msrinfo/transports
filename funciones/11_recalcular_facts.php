<?
// Mostramos hora de inicio:
echo "<br />".mostrar_hora()."<br />";

// Datos para determinar las facturas a recalcular:
$cod_emp=0;
$cod_fac_ini=0;
$cod_fac_fin=0;

if ($cod_emp!=0)
{
$condicion_emp="WHERE cod_empresa = '$cod_emp'";

	if ($cod_fac_ini!=0 || $cod_fac_fin!=0)
	{
	$condicion_fac="";
	
		if ($cod_fac_ini!=0)
			$condicion_fac .= " AND cod_factura >= '$cod_fac_ini'";
		
		if ($cod_fac_fin!=0)		
			$condicion_fac .= " AND cod_factura <= '$cod_fac_fin'";
	}
} // Fin de if ($cod_emp!=0)


// Conectamos con conta:
conectar_base($base_datos_conta);

// Seleccionamos empresas:
$select_emp="SELECT cod_empresa FROM empresas $condicion_emp";
echo "<br /> $select_emp <br />";
$query_emp=mysql_query($select_emp) or die ("<br /> No se han seleccionado empresas: ".mysql_error()."<br /> $select_emp <br />");

while($emp=mysql_fetch_array($query_emp))
{
$cod_empresa=$emp["cod_empresa"];

// Conectamos con cuenta:
conectar_base($base_datos);

// Seleccionamos facturas que NO son rectificativas:
$select_fac="SELECT * FROM facturas WHERE cod_empresa = '$cod_empresa' AND rectificado = '' $condicion_fac";
echo "<br /> $select_fac <br />";
$query_fac=mysql_query($select_fac) or die ("<br /> No se han seleccionado facturas: ".mysql_error()."<br /> $select_fac <br />");
while($fac=mysql_fetch_array($query_fac))
{
$cod_factura=$fac["cod_factura"];
$fac_fecha=$fac["fac_fecha"];
$cod_cliente=$fac["cod_cliente"];

//$fac_coste=sel_campo("SUM(total_coste)","fac_coste","albaranes","cod_factura = '$cod_factura' and cod_empresa='$cod_empresa'");

$fac_bruto=sel_campo("SUM(base)","fac_bruto","albaranes","cod_factura = '$cod_factura' and cod_empresa='$cod_empresa'");
$gastos_finan=$fac["gastos_finan"];
$descuento_pp=$fac["descuento_pp"];
$recargo_equiv=$fac["recargo_equiv"];
$tipo_iva=$fac["tipo_iva"];

// Calculamos totales:
$tot_fac=calcular_totales_fac($fac_bruto,$gastos_finan,$descuento_pp,$recargo_equiv,$tipo_iva);

$imp_gastos_finan=$tot_fac["imp_gastos_finan"];
$imp_descuento_pp=$tot_fac["imp_descuento_pp"];
$fac_base=$tot_fac["fac_base"];
$fac_iva=$tot_fac["fac_iva"];
$imp_recargo_equiv=$tot_fac["imp_recargo_equiv"];
$fac_total=$tot_fac["fac_total"];

// Calculamos vencimientos:
calc_vencis();

$update_fac="UPDATE facturas SET

fac_coste='$fac_coste',
fac_bruto='$fac_bruto',
imp_gastos_finan='$imp_gastos_finan',
imp_descuento_pp='$imp_descuento_pp',
fac_base='$fac_base',
fac_iva='$fac_iva',
imp_recargo_equiv='$imp_recargo_equiv',
fac_total='$fac_total',

venci1='$venci[1]',
venci2='$venci[2]',
venci3='$venci[3]',
venci4='$venci[4]',
venci5='$venci[5]',
imp_venci1='$imp_venci[1]',
imp_venci2='$imp_venci[2]',
imp_venci3='$imp_venci[3]',
imp_venci4='$imp_venci[4]',
imp_venci5='$imp_venci[5]'

WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'";

$query_update_fac=mysql_query($update_fac) or die ("<br /> No se ha actualizado facturas: ".mysql_error()."<br /> $update_fac <br />");

// Insertamos asiento:
insertar_asiento("facturas",$cod_empresa,$cod_factura);
} // Fin de while($fac=mysql_fetch_array($query_fac))
} // Fin de while($emp=mysql_fetch_array($query_emp))

// Mostramos hora de finalización:
echo "<br />".mostrar_hora()."<br />";
?>
<script type='text/javascript'>
alert('Recálculo de facturas completado.');
</script>