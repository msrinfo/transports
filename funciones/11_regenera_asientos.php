<?
// Mostramos hora de inicio:
echo "<br />".mostrar_hora()."<br />";

// Datos para determinar las facturas a recalcular:
$cod_emp=01;
$cod_fac_ini=1105;
$cod_fac_fin=1818;

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

$cont=0;

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
$cod_empresa=$fac["cod_empresa"];
$rectificado=$fac["rectificado"];
$motivo=$fac["motivo"];
$fac_fecha=$fac["fac_fecha"];
$cod_cliente=$fac["cod_cliente"];
$nombre_cliente=$fac["nombre_cliente"];

$cod_forma=$fac["cod_forma"];
$cod_tipo=$fac["cod_tipo"];

$fac_total=$fac["fac_total"];
	
$venci1=$fac["venci1"];
$venci2=$fac["venci2"];
$venci3=$fac["venci3"];
$venci4=$fac["venci4"];
$venci5=$fac["venci5"];
	
$imp_venci1=$fac["imp_venci1"];
$imp_venci2=$fac["imp_venci2"];
$imp_venci3=$fac["imp_venci3"];
$imp_venci4=$fac["imp_venci4"];
$imp_venci5=$fac["imp_venci5"];	


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

// Obtenemos los datos del cliente de la tabla clientes:
$selec_cliente="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$consulta_cli=mysql_query($selec_cliente, $link) or die ("<br /> No se ha seleccionado cliente: ".mysql_error()."<br /> $selec_cliente <br />");
$fila=mysql_fetch_array($consulta_cli);

$razon_social=$fila["razon_social"];
$nif_cif=$fila["nif_cif"];

$domicilio=addslashes($fila["domicilio"]);
$c_postal=$fila["c_postal"];
$poblacion=addslashes($fila["poblacion"]);
$provincia=addslashes($fila["provincia"]);

$domicilio_corresp=addslashes($fila["domicilio_corresp"]);
$c_postal_corresp=$fila["c_postal_corresp"];
$poblacion_corresp=addslashes($fila["poblacion_corresp"]);
$provincia_corresp=addslashes($fila["provincia_corresp"]);

// Adapatamos datos de cliente:
//datos_cli();

$telefono=$fila["telefono"];
$num_cuenta=$fila["num_cuenta"];
$copias_fac=$fila["copias_fac"];


/*	
	
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
	
	*/

// Insertamos asiento:
insertar_asiento("facturas",$cod_empresa,$cod_factura);
$cont++;	
} // Fin de while($fac=mysql_fetch_array($query_fac))
} // Fin de while($emp=mysql_fetch_array($query_emp))

// Mostramos hora de finalización:
echo "<br />".mostrar_hora()."<br />";
?>
<script type='text/javascript'>
alert('Asientos regenerados <? echo $cont; ?>.');
</script>