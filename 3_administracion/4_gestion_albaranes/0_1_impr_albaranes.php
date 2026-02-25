<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Impressi&oacute; d'Albarans</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />
<style type="text/css">
<!--
.Estilo3 {
	font-size: 11px;
	font-weight: bold;
}
.Estilo4 {font-size: 11px}
-->
</style>
</head>

<body>

<?

//$lineas_pag=4;

$cod_empresa=$_GET["cod_empresa"];
$cod_operario=$_GET["cod_operario"];
$fecha_ini=fecha_ing($_GET["fecha_ini"]);


//echo "<br /> EMP: $cod_empresa <br /> OP: $cod_operario <br /> FEC: $fecha_ini";

if ($fecha_ini && $cod_empresa)
{
// Seleccionamos albaranes:
$select_fac="SELECT * FROM albaranes WHERE fecha_carga='$fecha_ini' AND cod_empresa = '$cod_empresa' ORDER BY cod_operario, fecha_carga, cod_albaran";
}

if($fecha_ini && $cod_empresa && $cod_operario)
{
$select_fac="SELECT * FROM albaranes WHERE fecha_carga='$fecha_ini' AND cod_empresa = '$cod_empresa' AND cod_operario = '$cod_operario'";
}


//echo "<br /><br />SS: $select_fac";

if($cod_empresa)
{

$result_fac=mysql_query($select_fac, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $select_fac <br />");

$cont=0;

while($ord=mysql_fetch_array($result_fac))
{
$cod_albaran=$ord["cod_albaran"];
$cod_empresa=$ord["cod_empresa"];
$estado=$ord["estado"];
$cod_factura=$ord["cod_factura"];
$fecha_carga=fecha_esp($ord["fecha_carga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$tipo_iva=$ord["tipo_iva"];

$cod_descarga=$ord["cod_descarga"];
$observ_descarga=$ord["observ_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
$precio_chof=sel_campo("precio_chof","","descargas","cod_descarga='$cod_descarga'");
}


$fecha_descarga=fecha_esp($ord["fecha_descarga"]);
$fecha_carga=fecha_esp($ord["fecha_carga"]);

$viaje=$ord["viaje"];
$franja=$ord["franja"];

$cod_tarjeta=$ord["cod_tarjeta"];

if($cod_tarjeta)
{
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
}

$cod_tractora=$ord["cod_tractora"];

if($cod_tractora)
{
$mat2=sel_campo("mat2","","tractoras","cod_tractora='$cod_tractora'");
}

$cod_terminal=$ord["cod_terminal"];

if($cod_terminal)
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");


$cod_operadora=$ord["cod_operadora"];

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");


$cod_operario=$ord["cod_operario"];

if($cod_operario)
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

$cod_conjunto=$ord["cod_conjunto"];

if($cod_conjunto)
$desc_conjunto=sel_campo("desc_conjunto","","conjuntos","cod_conjunto='$cod_conjunto'");

$avisador=$ord["avisador"];
$franja=$ord["franja"];
$precio_chof=$ord["precio_chof"];
$precio_cli=$ord["precio_cli"];

$cod_pedido=$ord["cod_pedido"];

$cant_blue=$ord["cant_blue"];
$cant_sp95=$ord["cant_sp95"];
$cant_sp98=$ord["cant_sp98"];
$cant_go_a=$ord["cant_go_a"];
$cant_go_a1=$ord["cant_go_a1"];
$cant_go_b=$ord["cant_go_b"];
$cant_go_c=$ord["cant_go_c"];
$cant_bio=$ord["cant_bio"];

$suma_pedidos=$ord["suma_pedidos"];

$serv_blue=$ord["serv_blue"];
$serv_sp95=$ord["serv_sp95"]; 	
$serv_sp98=$ord["serv_sp98"];	
$serv_go_a=$ord["serv_go_a"];
$serv_go_a1=$ord["serv_go_a1"];
$serv_go_b=$ord["serv_go_b"];
$serv_go_c=$ord["serv_go_c"];
$serv_bio=$ord["serv_bio"];

$suma_servidos=$ord["suma_servidos"];

$cant_comp1=$ord["cant_comp1"];
$cant_comp2=$ord["cant_comp2"]; 	
$cant_comp3=$ord["cant_comp3"]; 	
$cant_comp4=$ord["cant_comp4"]; 	
$cant_comp5=$ord["cant_comp5"]; 	
$cant_comp6=$ord["cant_comp6"]; 	
$cant_comp7=$ord["cant_comp7"]; 	
$cant_comp8=$ord["cant_comp8"]; 	
$prod_comp1=$ord["prod_comp1"];	
$prod_comp2=$ord["prod_comp2"]; 	
$prod_comp3=$ord["prod_comp3"]; 	
$prod_comp4=$ord["prod_comp4"]; 	
$prod_comp5=$ord["prod_comp5"]; 
$prod_comp6=$ord["prod_comp6"]; 	
$prod_comp7=$ord["prod_comp7"]; 
$prod_comp8=$ord["prod_comp8"];

$observaciones=$ord["observaciones"];
$base=$ord["base"];

$cambiar_papel=$ord["cambiar_papel"];
$conectar_toma_terra=$ord["conectar_toma_terra"];
$conectar_man_gasos=$ord["conectar_man_gasos"];
$treure_mostres=$ord["treure_mostres"];
$doble_carga=$ord["doble_carga"];

$prec_doble_carga_cli=$ord["prec_doble_carga_cli"];
$prec_doble_carga_chof=$ord["prec_doble_carga_chof"];

$doble_descarga=$ord["doble_descarga"];

$prec_doble_desc_cli=$ord["prec_doble_desc_cli"];
$prec_doble_desc_chof=$ord["prec_doble_desc_chof"];

$avisar_antes_cargar=$ord["avisar_antes_cargar"];
$avisar_salir_cargado=$ord["avisar_salir_cargado"];
$pedir_muestra=$ord["pedir_muestra"];

$descarga_bomba=$ord["descarga_bomba"];

$prec_desc_bomba_cli=$ord["prec_desc_bomba_cli"];
$prec_desc_bomba_chof=$ord["prec_desc_bomba_chof"];
$lts_desc_bomba=$ord["lts_desc_bomba"];  	

$planos_id=$ord["planos_id"];

$horas_espera=$ord["horas_espera"];

$cont++;
//echo "CONT1: $cont";
?>

<?
if ($cont==5)
	$salto="style='page-break-before:always;'";
?>
<table <? echo $salto;?> >  
  <tr>
    <td>&nbsp;</td>
    <td colspan="14" align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14" align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14" align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="14" align="center"><strong><font size="2">TRANSPORTS SEG&Uacute; </font></strong></td>
    <td width="1%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="15%" align="left"><div align="left" class="Estilo3">Data C&agrave;rrega: </div></td>
    <td colspan="2" align="left"><div align="left" class="Estilo4"><? echo "$fecha_carga"; ?></div></td>
    <td colspan="2"><div align="right"><span class="Estilo4"></span></div></td>
    <td width="2%"><div align="right"><span class="Estilo4"></span></div></td>
    <td colspan="8"><span class="Estilo4"><strong>Data Desc&agrave;rrega: </strong> <? echo "$fecha_descarga" ; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><div align="left" class="Estilo4"><strong>Conductor:</strong></div></td>
    <td colspan="13" align="left"><div align="left" class="Estilo4"><? echo $cod_operario." ".$nombre_op; ?></div>
    <div align="right" class="Estilo4"></div>      <div align="right" class="Estilo4"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"><strong>Viatge:</strong></span></td>
    <td colspan="2"><span class="Estilo4"><? echo $viaje; ?></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="8"><span class="Estilo4"><strong>Franja:</strong> <? echo $franja; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14" align="left"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><div align="left" class="Estilo4"><strong>Client</strong>:</div></td>
    <td colspan="12"><span class="Estilo4"><? echo $cod_cliente." ".$nombre_cliente; ?></span></td>
    <td width="9%" align="left"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"><strong>Desc&agrave;rrega:</strong></span></td>
    <td colspan="12"><div align="left" class="Estilo4"><? echo $cod_descarga." ".$poblacion; ?></div></td>
    <td align="left"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" class="Estilo4"><span class="Estilo4"><strong>Observ. Desc.:</strong></span></td>
    <td colspan="13" align="left" class="Estilo4"><span class="Estilo4 Estilo4"><? echo $observ_descarga; ?></span></td>
    <td>&nbsp;</td>
  </tr>
<?

$orden="
SELECT *
FROM albaranes
WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'
ORDER BY cod_operario, fecha_carga, cod_albaran";

$query_orden=mysql_query($orden, $link) or die ("<br /> No se han seleccionado albaranes de factura: ".mysql_error()."<br /> $orden <br />");

$alb=mysql_fetch_array($query_orden);

$cod_albaran=$alb["cod_albaran"];
$cod_empresa=$alb["cod_empresa"];
$estado=$alb["estado"];
$cod_factura=$alb["cod_factura"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=$alb["nombre_cliente"];
$tipo_iva=$alb["tipo_iva"];

$cod_descarga=$alb["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
$precio_chof=sel_campo("precio_chof","","descargas","cod_descarga='$cod_descarga'");
}


$fecha_descarga=fecha_esp($alb["fecha_descarga"]);
$fecha_carga=fecha_esp($alb["fecha_carga"]);

$viaje=$alb["viaje"];
$franja=$alb["franja"];

$cod_tarjeta=$alb["cod_tarjeta"];

if($cod_tarjeta)
{
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
}

$cod_tractora=$alb["cod_tractora"];

if($cod_tractora)
{
$mat2=sel_campo("mat2","","tractoras","cod_tractora='$cod_tractora'");
}

$cod_terminal=$alb["cod_terminal"];

if($cod_terminal)
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");


$cod_operadora=$alb["cod_operadora"];

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");


$cod_operario=$alb["cod_operario"];

if($cod_operario)
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

$cod_conjunto=$alb["cod_conjunto"];

if($cod_conjunto)
$desc_conjunto=sel_campo("desc_conjunto","","conjuntos","cod_conjunto='$cod_conjunto'");

$avisador=$alb["avisador"];
$precio_chof=$alb["precio_chof"];
$precio_cli=$alb["precio_cli"];

$cod_pedido=$alb["cod_pedido"];

$cant_blue=$alb["cant_blue"];
$cant_sp95=$alb["cant_sp95"];
$cant_sp98=$alb["cant_sp98"];
$cant_go_a=$alb["cant_go_a"];
$cant_go_a1=$alb["cant_go_a1"];
$cant_go_b=$alb["cant_go_b"];
$cant_go_c=$alb["cant_go_c"];
$cant_bio=$alb["cant_bio"];

$suma_pedidos=$alb["suma_pedidos"];

$serv_blue=$alb["serv_blue"];
$serv_sp95=$alb["serv_sp95"]; 	
$serv_sp98=$alb["serv_sp98"];	
$serv_go_a=$alb["serv_go_a"];
$serv_go_a1=$alb["serv_go_a1"];
$serv_go_b=$alb["serv_go_b"];
$serv_go_c=$alb["serv_go_c"];
$serv_bio=$alb["serv_bio"];

$suma_servidos=$alb["suma_servidos"];

$cant_comp1=$alb["cant_comp1"];
$cant_comp2=$alb["cant_comp2"]; 	
$cant_comp3=$alb["cant_comp3"]; 	
$cant_comp4=$alb["cant_comp4"]; 	
$cant_comp5=$alb["cant_comp5"]; 	
$cant_comp6=$alb["cant_comp6"]; 	
$cant_comp7=$alb["cant_comp7"]; 	
$cant_comp8=$alb["cant_comp8"]; 	
$prod_comp1=$alb["prod_comp1"];	
$prod_comp2=$alb["prod_comp2"]; 	
$prod_comp3=$alb["prod_comp3"]; 	
$prod_comp4=$alb["prod_comp4"]; 	
$prod_comp5=$alb["prod_comp5"]; 
$prod_comp6=$alb["prod_comp6"]; 	
$prod_comp7=$alb["prod_comp7"]; 
$prod_comp8=$alb["prod_comp8"];

$observaciones=$alb["observaciones"];
$base=$alb["base"];

$cambiar_papel=$alb["cambiar_papel"];
$observ_cambiar_papel=$alb["observ_cambiar_papel"];

$conectar_toma_terra=$alb["conectar_toma_terra"];
$conectar_man_gasos=$alb["conectar_man_gasos"];
$treure_mostres=$alb["treure_mostres"];
$doble_carga=$alb["doble_carga"];

$prec_doble_carga_cli=$alb["prec_doble_carga_cli"];
$prec_doble_carga_chof=$alb["prec_doble_carga_chof"];

$doble_descarga=$alb["doble_descarga"];

$prec_doble_desc_cli=$alb["prec_doble_desc_cli"];
$prec_doble_desc_chof=$alb["prec_doble_desc_chof"];

$avisar_antes_cargar=$alb["avisar_antes_cargar"];
$avisar_salir_cargado=$alb["avisar_salir_cargado"];
$pedir_muestra=$alb["pedir_muestra"];

$descarga_bomba=$alb["descarga_bomba"];

$prec_desc_bomba_cli=$alb["prec_desc_bomba_cli"];
$prec_desc_bomba_chof=$alb["prec_desc_bomba_chof"];
$lts_desc_bomba=$alb["lts_desc_bomba"];  	

$planos_id=$alb["planos_id"];

if($planos_id==0)
{
	$planos_id="Sense P.";
} 
else if($planos_id==1)
{
	$planos_id="30/1202";
} else
{
	$planos_id="33/1203";
}
	
$horas_espera=$alb["horas_espera"];
$observ_horas_espera=$alb["observ_horas_espera"];

$observaciones=$alb["observaciones"];

if($cambiar_papel==1){
	$cambiar_papel="S";
}else{
	$cambiar_papel="N";
}

if($conectar_toma_terra==1){
	$conectar_toma_terra="S";
}else{
	$conectar_toma_terra="N";
}

if($conectar_man_gasos==1){
	$conectar_man_gasos="S";
}else{
	$conectar_man_gasos="N";
}

if($treure_mostres==1){
	$treure_mostres="S";
}else{
	$treure_mostres="N";
}
if($doble_carga==1){
	$doble_carga="S";
}else{
	$doble_carga="N";
}

if($doble_descarga==1){
	$doble_descarga="S";
}else{
	$doble_descarga="N";
}

if($avisar_antes_cargar==1){
	$avisar_antes_cargar="S";
}else{
	$avisar_antes_cargar="N";
}

if($avisar_salir_cargado==1){
	$avisar_salir_cargado="S";
}else{
	$avisar_salir_cargado="N";
}

if($pedir_muestra==1){
	$pedir_muestra="S";
}else{
	$pedir_muestra="N";
}

if($descarga_bomba==1){
	$descarga_bomba="S";
}else{
	$descarga_bomba="N";
}

if($horas_espera==1){
	$horas_espera="S";
}else{
	$horas_espera="N";
}


// Mostramos cabecera por primera vez:
/*$num_pags=0; // Contador de páginas impresas.
 // Contador de líneas.
cabecera();*/$cont++;

//echo "CONT2: $cont";
?>

  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"><strong>Targeta:</strong></span></td>
    <td colspan="8"><span class="Estilo4"><? echo $cod_tarjeta.' '.$mat1.' - '.$cod_tractora.' '.$mat2; ?></span></td>
    <td width="4%"><span class="Estilo4"></span></td>
    <td width="6%"><span class="Estilo4"></span></td>
    <td width="2%"><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"><strong>Terminal:</strong></span></td>
    <td colspan="8"><span class="Estilo4"><? echo $cod_terminal." ".$nombre_terminal; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"><strong>Operadora:</strong></span></td>
    <td colspan="8"><span class="Estilo4"><? echo $cod_operadoral." ".$descripcion; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"></span></td>
    <td width="17%"><span class="Estilo4"></span></td>
    <td colspan="7"><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><span class="Estilo4"><strong>N&ordm; Comanda:</strong> </span></td>
    <td colspan="8"><span class="Estilo4"><? echo $cod_pedido; ?>&nbsp;</span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td width="10%"><span class="Estilo4">Demanades</span></td>
    <td width="3%" align="right"><span class="Estilo4"></span></td>
    <td width="5%"><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="3"><span class="Estilo4">Compartim.</span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>ADITIVAT</strong></span>
    </td><td align="right"><span class="Estilo4">
      <? if($cant_blue!=0) echo "$cant_blue"; ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td width="2%"><span class="Estilo4"><strong>1</strong></span></td>
    <td width="2%" align="right"><span class="Estilo4">
      <? if($cant_comp1!=0) echo "$cant_comp1";  ?>
    </span></td>
    <td width="12%"><span class="Estilo4"><? echo "$prod_comp1";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>SP95</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_sp95!=0) echo "$cant_sp95";  ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>2</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp2!=0) echo "$cant_comp2";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp2";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>SP98</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_sp98!=0) echo "$cant_sp98"; ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>3</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp3!=0) echo "$cant_comp3";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp3";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>GO A </strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_go_a!=0) echo "$cant_go_a";  ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>4</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp4!=0) echo "$cant_comp4";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp4";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>B1000</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_go_a1!=0) echo "$cant_go_a1";  ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>5</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp5!=0) echo "$cant_comp5";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp5";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>GO B </strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_go_b!=0) echo "$cant_go_b";  ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>6</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp6!=0) echo "$cant_comp6";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp6";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>GO C </strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_go_c!=0) echo "$cant_go_c";  ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>7</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp7!=0) echo "$cant_comp7";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp7";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>BIO</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_bio!=0) echo "$cant_bio";  ?>
    </span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"><strong>8</strong></span></td>
    <td align="right"><span class="Estilo4">
      <? if($cant_comp8!=0) echo "$cant_comp8";  ?>
    </span></td>
    <td><span class="Estilo4"><? echo "$prod_comp8";  ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="7"><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><span class="Estilo4"><strong>Puntualitzacions del Transport</strong> </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Canviar papers </span></td>
    <td><span class="Estilo4"><? echo $cambiar_papel; ?></span></td>
    <td colspan="8"><span class="Estilo4"><? echo $observ_cambiar_papel; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td width="9%"><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Conectar toma terra </span></td>
    <td><span class="Estilo4"><? echo $conectar_toma_terra; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Conectar m&agrave;nega gasos</span></td>
    <td><span class="Estilo4"><? echo $conectar_man_gasos; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Treure mostres abans desc&agrave;rrega</span></td>
    <td><span class="Estilo4"><? echo $treure_mostres; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
<?
/*$cont++;
cabecera();*/
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Doble c&agrave;rrega</span></td>
    <td><span class="Estilo4"><? echo $doble_carga; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td colspan="2"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Doble desc&agrave;rrega </span></td>
    <td><span class="Estilo4"><? echo $doble_descarga; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Avisar abans carregar </span></td>
    <td><span class="Estilo4"><? echo $avisar_antes_cargar; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Avisar al sortir carregat </span></td>
    <td><span class="Estilo4"><? echo $avisar_salir_cargado; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Demanar mostra </span></td>
    <td><span class="Estilo4"><? echo $pedir_muestra; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Desc&agrave;rrega amb bomba </span></td>
    <td><span class="Estilo4"><? echo $descarga_bomba; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Planells d'identificaci&oacute;</span></td>
    <td><span class="Estilo4"><? echo $planos_id; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><span class="Estilo4">Hores d'espera</span></td>
    <td><span class="Estilo4"><? echo $horas_espera; ?></span></td>
    <td colspan="7"><span class="Estilo4"><? echo $observ_horas_espera; ?></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><span class="Estilo4"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><span class="Estilo4"><strong>Observacions:</strong></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><span class="Estilo4"><? echo $observaciones; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><strong class="Estilo3">Signatura C&agrave;rrega </strong><span class="recibo">(<? echo "$cod_albaran"; ?>)</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5"><strong class="Estilo4">Signatura Desc&agrave;rrega </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="13">   </td>
    <td>&nbsp;</td>
  </tr>
 
  <?
//echo "LIN:$lineas_pag";
// Rellenamos con líneas en blanco:
/**/for ($i=$cont+1; $i <= $lineas_pag; $i++)
{
?>
    <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?
} // Fin de for ($i=$cont+1; $i <= $lineas_pag; $i++)
 ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="13">   </td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="14">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
<?
} // Fin de while($fac=mysql_fetch_array($result_fac))
} // Fin de if ($cod_albaran_ini && $cod_albaran_fin && $cod_empresa)
?>
</table>
</body>
</html>