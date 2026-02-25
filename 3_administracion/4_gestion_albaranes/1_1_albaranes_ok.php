<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gesti&oacute; d'Albarans</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
// comun:
$cod_albaran=$_POST["cod_albaran"];
$cod_empresa=$_POST["cod_empresa"];


// albaranes:
//$cod_albaran=$_POST["cod_albaran"];
$cod_empresa=$_POST["cod_empresa"];
$cod_factura=$_POST["cod_factura"];
$fecha=fecha_ing($_POST["fecha"]);
$cod_cliente=$_POST["cod_cliente"];
$nombre_cliente=$_POST["nombre_cliente"];


if($tipo_iva==$val_iva[0])
{
$tipo_iva=sel_campo("tipo_iva","","clientes","cod_cliente='$cod_cliente'");
}


$cod_descarga=$_POST["cod_descarga"];
$observ_descarga=$_POST["observ_descarga"];
$horas_descarga=$_POST["horas_descarga"];



$fecha_descarga=fecha_ing($_POST["fecha_descarga"]);
$fecha_carga=fecha_ing($_POST["fecha_carga"]);


$tipo_iva=control_iva($_POST["tipo_iva"],$fecha_carga);




if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
//$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
//$horas_descarga=sel_campo("horas_descarga","","descargas","cod_descarga='$cod_descarga'");
$fecha_modif=sel_campo("fecha_modif","","descargas","cod_descarga='$cod_descarga'");

	// Si la fecha de modificacion de precios de la descarga es más reciente que la de carga guardo, sino la busco en el fichero
	
	if( comparar_fechas($fecha_modif,$fecha_carga)> 0 )
	{
	$precio_cli=$_POST["precio_cli"];
	$precio_chof=$_POST["precio_chof"];
	} else
	{
	$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
	//$precio_chof=sel_campo("precio_chof","","descargas","cod_descarga='$cod_descarga'");
	}
}



$precio_chof=$_POST["precio_chof"];
$viaje=$_POST["viaje"];
$franja=$_POST["franja"];
$cod_tarjeta=$_POST["cod_tarjeta"];
$cod_tractora=$_POST["cod_tractora"];
$cod_terminal=$_POST["cod_terminal"];
$cod_operadora=$_POST["cod_operadora"];

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");

$cod_operario=$_POST["cod_operario"];
$cod_operario2=$_POST["cod_operario2"];


if($cod_operario=="")
{
	$cod_operario="99";
	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

$cod_conjunto=$_POST["cod_conjunto"];
$avisador=$_POST["avisador"];


$cod_pedido=$_POST["cod_pedido"];

$cant_blue=$_POST["cant_blue"];
$cant_sp95=$_POST["cant_sp95"];
$cant_sp98=$_POST["cant_sp98"];
$cant_go_a=$_POST["cant_go_a"];
$cant_go_a1=$_POST["cant_go_a1"];
$cant_go_b=$_POST["cant_go_b"];
$cant_go_c=$_POST["cant_go_c"];
$cant_bio=$_POST["cant_bio"];

$suma_pedidos=$_POST["suma_pedidos"];

$serv_blue=$_POST["serv_blue"];
$serv_sp95=$_POST["serv_sp95"]; 	
$serv_sp98=$_POST["serv_sp98"];	
$serv_go_a=$_POST["serv_go_a"];
$serv_go_a1=$_POST["serv_go_a1"];
$serv_go_b=$_POST["serv_go_b"];
$serv_go_c=$_POST["serv_go_c"];
$serv_bio=$_POST["serv_bio"];

$suma_servidos=$_POST["suma_servidos"];

$cant_comp1=$_POST["cant_comp1"];
$cant_comp2=$_POST["cant_comp2"]; 	
$cant_comp3=$_POST["cant_comp3"]; 	
$cant_comp4=$_POST["cant_comp4"]; 	
$cant_comp5=$_POST["cant_comp5"]; 	
$cant_comp6=$_POST["cant_comp6"]; 	
$cant_comp7=$_POST["cant_comp7"]; 	
$cant_comp8=$_POST["cant_comp8"]; 	
$prod_comp1=$_POST["prod_comp1"];	
$prod_comp2=$_POST["prod_comp2"]; 	
$prod_comp3=$_POST["prod_comp3"]; 	
$prod_comp4=$_POST["prod_comp4"]; 	
$prod_comp5=$_POST["prod_comp5"]; 
$prod_comp6=$_POST["prod_comp6"]; 	
$prod_comp7=$_POST["prod_comp7"]; 
$prod_comp8=$_POST["prod_comp8"];

$cambiar_papel=$_POST["cambiar_papel"];
$observ_cambiar_papel=$_POST["observ_cambiar_papel"];
$conectar_toma_terra=$_POST["conectar_toma_terra"];
$conectar_man_gasos=$_POST["conectar_man_gasos"];
$treure_mostres=$_POST["treure_mostres"];
$doble_carga=$_POST["doble_carga"];

$prec_doble_carga_cli=$_POST["prec_doble_carga_cli"];
$prec_doble_carga_chof=$_POST["prec_doble_carga_chof"];

$doble_descarga=$_POST["doble_descarga"];

$prec_doble_desc_cli=$_POST["prec_doble_desc_cli"];
$prec_doble_desc_chof=$_POST["prec_doble_desc_chof"];

$avisar_antes_cargar=$_POST["avisar_antes_cargar"];
$avisar_salir_cargado=$_POST["avisar_salir_cargado"];
$pedir_muestra=$_POST["pedir_muestra"];

$descarga_bomba=$_POST["descarga_bomba"];

$prec_desc_bomba_cli=$_POST["prec_desc_bomba_cli"];
$prec_desc_bomba_chof=$_POST["prec_desc_bomba_chof"];
$lts_desc_bomba=$_POST["lts_desc_bomba"];  	

$planos_id=$_POST["planos_id"];

$horas_espera=$_POST["horas_espera"];
$prec_horas_espera=$_POST["prec_horas_espera"];
$observ_horas_espera=$_POST["observ_horas_espera"];

$observaciones=$_POST["observaciones"];
$incidencias=$_POST["incidencias"];
$observa_conductor=$_POST["observa_conductor"];

$serv_redon=$_POST["serv_redon"];
$a_cobrar=$_POST["a_cobrar"];

$base=$_POST["base"];

// Si recibimos cod_empresa, continuamos:
if ($cod_empresa)
{
// Comprobamos si existe orden:
$comprobar_ord="SELECT estado FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";
$consultar_ord=mysql_query($comprobar_ord, $link) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $consultar_ord <br />");
$existe_ord=mysql_num_rows($consultar_ord);


if($doble_carga!=1){
	$prec_doble_carga_cli="";
	$prec_doble_carga_chof="";
}

if($doble_descarga!=1){
	$prec_doble_desc_cli="";
	$prec_doble_desc_chof="";
}

if($descarga_bomba!=1){
	$prec_desc_bomba_cli="";
	$prec_desc_bomba_chof="";
	$lts_desc_bomba="";
}

$suma_pedidos= $cant_blue + $cant_sp95 + $cant_sp98 + $cant_go_a + $cant_go_a1 + $cant_go_b + $cant_go_c + $cant_bio;


$suma_servidos = $serv_blue + $serv_sp95 + $serv_sp98 + $serv_go_a + $serv_go_a1 + $serv_go_b + $serv_go_c + $serv_bio;

if($a_cobrar=="1")
{
$total_servidos=1;
}
else if($serv_redon==0)
{
$total_servidos=$suma_servidos;
}
else if($serv_redon!=0)
{
$total_servidos=$serv_redon;
}

$base= (($prec_desc_bomba_cli * $lts_desc_bomba) + ($total_servidos * $precio_cli) + $prec_doble_carga_cli + $prec_doble_desc_cli) + ($horas_espera * $prec_horas_espera);

/*echo "
<br /> cod_albaran: $cod_albaran
<br /> cod_empresa: $cod_empresa
<br /> prec_desc_bomba_cli: $prec_desc_bomba_cli
<br /> lts_desc_bomba: $lts_desc_bomba
<br /> total_servidos: $total_servidos
<br /> precio_cli: $precio_cli
<br /> prec_doble_carga_cli: $prec_doble_carga_cli
<br /> prec_doble_desc_cli: $prec_doble_desc_cli
<br /> horas_espera: $horas_espera
<br /> prec_horas_espera: $prec_horas_espera
<br /> base: $base
";
exit();
*/



// ÓRDENES:
if ($existe_ord==1)
{
$cons=mysql_fetch_assoc($consultar_ord);
$estado=$cons['estado'];
if ($estado=='f')
{
?>
<script type="text/javascript">
alert("NO se modificará albarán porque ya está facturado.");
enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');
</script>
<?
exit();
}

// Controlamos iva:
$tipo_iva=control_iva($tipo_iva,$fecha_carga);


// MODIFICAMOS ORDEN:
$modificar_ord="UPDATE albaranes SET

fecha='$fecha',
cod_cliente='$cod_cliente',
nombre_cliente='$nombre_cliente',
tipo_iva='$tipo_iva',
cod_descarga='$cod_descarga',
observ_descarga='$observ_descarga',
horas_descarga='$horas_descarga',
fecha_descarga='$fecha_descarga',
fecha_carga='$fecha_carga',
viaje='$viaje',
franja='$franja',
cod_tarjeta='$cod_tarjeta',
cod_tractora='$cod_tractora',
cod_terminal='$cod_terminal',
cod_operadora='$cod_operadora',
cod_operario='$cod_operario',
cod_operario2='$cod_operario2',
avisador='$avisador',
precio_chof='$precio_chof',
precio_cli='$precio_cli',

cod_pedido='$cod_pedido',

cant_blue='$cant_blue',
cant_sp95='$cant_sp95',
cant_sp98='$cant_sp98',
cant_go_a='$cant_go_a',
cant_go_a1='$cant_go_a1',
cant_go_b='$cant_go_b',
cant_go_c='$cant_go_c',
cant_bio='$cant_bio',
suma_pedidos='$suma_pedidos',

serv_blue='$serv_blue',
serv_sp95='$serv_sp95', 	
serv_sp98='$serv_sp98',	
serv_go_a='$serv_go_a',
serv_go_a1='$serv_go_a1',
serv_go_b='$serv_go_b',
serv_go_c='$serv_go_c',
serv_bio='$serv_bio',
suma_servidos='$suma_servidos',

cant_comp1='$cant_comp1',
cant_comp2='$cant_comp2', 	
cant_comp3='$cant_comp3', 	
cant_comp4='$cant_comp4', 	
cant_comp5='$cant_comp5', 	
cant_comp6='$cant_comp6', 	
cant_comp7='$cant_comp7', 	
cant_comp8='$cant_comp8', 	
prod_comp1='$prod_comp1',	
prod_comp2='$prod_comp2', 	
prod_comp3='$prod_comp3', 	
prod_comp4='$prod_comp4', 	
prod_comp5='$prod_comp5', 
prod_comp6='$prod_comp6', 	
prod_comp7='$prod_comp7', 
prod_comp8='$prod_comp8',

cambiar_papel='$cambiar_papel',
observ_cambiar_papel='$observ_cambiar_papel',
conectar_toma_terra='$conectar_toma_terra',
conectar_man_gasos='$conectar_man_gasos',
treure_mostres='$treure_mostres',
doble_carga='$doble_carga',

prec_doble_carga_cli='$prec_doble_carga_cli',
prec_doble_carga_chof='$prec_doble_carga_chof',

doble_descarga='$doble_descarga',

prec_doble_desc_cli='$prec_doble_desc_cli',
prec_doble_desc_chof='$prec_doble_desc_chof',

avisar_antes_cargar='$avisar_antes_cargar',
avisar_salir_cargado='$avisar_salir_cargado',
pedir_muestra='$pedir_muestra',

descarga_bomba='$descarga_bomba',

prec_desc_bomba_cli='$prec_desc_bomba_cli',
prec_desc_bomba_chof='$prec_desc_bomba_chof',
lts_desc_bomba='$lts_desc_bomba',  	

planos_id='$planos_id',

horas_espera='$horas_espera',
prec_horas_espera='$prec_horas_espera',
observ_horas_espera='$observ_horas_espera',

serv_redon='$serv_redon',
a_cobrar='$a_cobrar',
base='$base',
observaciones='$observaciones',
observa_conductor='$observa_conductor',
incidencias='$incidencias'

WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";

$result_ord = mysql_query ($modificar_ord, $link) or die ("<br /> No se ha actualizado orden: ".mysql_error()."<br /> $modificar_ord <br />");



} // Fin de if ($existe_ord==1)
	
else
{

// Controlamos iva:
$tipo_iva=control_iva($tipo_iva,$fecha_carga);
//$cod_albaran=obtener_max_con("cod_albaran","albaranes","cod_empresa = '$cod_empresa' and cod_albaran < 8000 ") + 1;
$cod_albaran=obtener_max_con("cod_albaran","albaranes","cod_empresa = '$cod_empresa'") + 1;
/*echo "<br/>$cod_albaran";
exit();*/
// INSERTAMOS ORDEN: OK!!!!!!!!!!!!!!!!
$insertar_ord="INSERT INTO albaranes
(cod_albaran, cod_empresa,fecha,cod_cliente,nombre_cliente,tipo_iva,cod_descarga,observ_descarga, horas_descarga, fecha_descarga, fecha_carga,viaje, franja, cod_tarjeta, cod_tractora, cod_terminal, cod_operadora,cod_operario,cod_operario2,
avisador,precio_chof,precio_cli,cod_pedido,cant_blue,cant_sp95,cant_sp98,cant_go_a,
cant_go_a1,cant_go_b,cant_go_c,cant_bio, suma_pedidos, serv_blue, serv_sp95, serv_sp98, serv_go_a, serv_go_a1, serv_go_b, serv_go_c, serv_bio, suma_servidos, cant_comp1, cant_comp2, cant_comp3, cant_comp4, cant_comp5, cant_comp6, cant_comp7, cant_comp8, prod_comp1,	prod_comp2, prod_comp3, prod_comp4, prod_comp5, 
prod_comp6, prod_comp7, prod_comp8, observaciones, observa_conductor, incidencias, a_cobrar, base, cambiar_papel,  observ_cambiar_papel, conectar_toma_terra, conectar_man_gasos, treure_mostres, doble_carga, prec_doble_carga_cli, prec_doble_carga_chof, doble_descarga, prec_doble_desc_cli, prec_doble_desc_chof, avisar_antes_cargar, avisar_salir_cargado,
pedir_muestra,descarga_bomba,prec_desc_bomba_cli,prec_desc_bomba_chof,lts_desc_bomba,  	planos_id,horas_espera,prec_horas_espera,observ_horas_espera)
VALUES ('$cod_albaran','$cod_empresa','$fecha','$cod_cliente','$nombre_cliente','$tipo_iva','$cod_descarga', '$observ_descarga','$horas_descarga', '$fecha_descarga', '$fecha_carga', '$viaje', '$franja', '$cod_tarjeta', '$cod_tractora', '$cod_terminal', '$cod_operadora', '$cod_operario', '$cod_operario2','$avisador', '$precio_chof', '$precio_cli','$cod_pedido','$cant_blue','$cant_sp95','$cant_sp98','$cant_go_a','$cant_go_a1','$cant_go_b','$cant_go_c','$cant_bio', '$suma_pedidos','$serv_blue', '$serv_sp95', '$serv_sp98', '$serv_go_a', '$serv_go_a1', '$serv_go_b', '$serv_go_c', '$serv_bio', '$suma_servidos',
'$cant_comp1', '$cant_comp2', '$cant_comp3', '$cant_comp4', '$cant_comp5', 	'$cant_comp6', 	'$cant_comp7', '$cant_comp8', '$prod_comp1', '$prod_comp2', '$prod_comp3', '$prod_comp4', '$prod_comp5', '$prod_comp6', '$prod_comp7', '$prod_comp8', '$observaciones', '$observa_conductor', '$incidencias', '$a_cobrar', '$base',  '$cambiar_papel', '$observ_cambiar_papel', '$conectar_toma_terra', '$conectar_man_gasos', '$treure_mostres', '$doble_carga', '$prec_doble_carga_cli', '$prec_doble_carga_chof','$doble_descarga','$prec_doble_desc_cli','$prec_doble_desc_chof','$avisar_antes_cargar',
'$avisar_salir_cargado','$pedir_muestra','$descarga_bomba','$prec_desc_bomba_cli',
'$prec_desc_bomba_chof','$lts_desc_bomba','$planos_id','$horas_espera','$prec_horas_espera','$observ_horas_espera')";

// INSERTAR CON ENVIADO=SI Y DESCARGADO=SI PARA SILVIA PRUEBAS:
/*$insertar_ord="INSERT INTO albaranes
(cod_albaran,cod_empresa,enviado,descargado,fecha,cod_cliente,nombre_cliente,tipo_iva,cod_descarga,observ_descarga, horas_descarga, fecha_descarga, fecha_carga,viaje, franja, cod_tarjeta, cod_tractora, cod_terminal, cod_operadora,cod_operario,cod_operario2,
avisador,precio_chof,precio_cli,cod_pedido,cant_blue,cant_sp95,cant_sp98,cant_go_a,
cant_go_a1,cant_go_b,cant_go_c,cant_bio, suma_pedidos, serv_blue, serv_sp95, serv_sp98, serv_go_a, serv_go_a1, serv_go_b, serv_go_c, serv_bio, suma_servidos, cant_comp1, cant_comp2, cant_comp3, cant_comp4, cant_comp5, cant_comp6, cant_comp7, cant_comp8, prod_comp1,	prod_comp2, prod_comp3, prod_comp4, prod_comp5, 
prod_comp6, prod_comp7, prod_comp8, observaciones, incidencias, a_cobrar, base, cambiar_papel,  observ_cambiar_papel, conectar_toma_terra, conectar_man_gasos, treure_mostres, doble_carga, prec_doble_carga_cli, prec_doble_carga_chof, doble_descarga, prec_doble_desc_cli, prec_doble_desc_chof, avisar_antes_cargar, avisar_salir_cargado,
pedir_muestra,descarga_bomba,prec_desc_bomba_cli,prec_desc_bomba_chof,lts_desc_bomba,  	planos_id,horas_espera,prec_horas_espera,observ_horas_espera)
VALUES ('$cod_albaran','$cod_empresa','si','si','$fecha','$cod_cliente','$nombre_cliente','$tipo_iva','$cod_descarga', '$observ_descarga','$horas_descarga', '$fecha_descarga', '$fecha_carga', '$viaje', '$franja', '$cod_tarjeta', '$cod_tractora', '$cod_terminal', '$cod_operadora', '$cod_operario', '$cod_operario2','$avisador', '$precio_chof', '$precio_cli','$cod_pedido','$cant_blue','$cant_sp95','$cant_sp98','$cant_go_a','$cant_go_a1','$cant_go_b','$cant_go_c','$cant_bio', '$suma_pedidos','$serv_blue', '$serv_sp95', '$serv_sp98', '$serv_go_a', '$serv_go_a1', '$serv_go_b', '$serv_go_c', '$serv_bio', '$suma_servidos',
'$cant_comp1', '$cant_comp2', '$cant_comp3', '$cant_comp4', '$cant_comp5', 	'$cant_comp6', 	'$cant_comp7', '$cant_comp8', '$prod_comp1', '$prod_comp2', '$prod_comp3', '$prod_comp4', '$prod_comp5', '$prod_comp6', '$prod_comp7', '$prod_comp8', '$observaciones', '$incidencias', '$a_cobrar', '$base',  '$cambiar_papel', '$observ_cambiar_papel', '$conectar_toma_terra', '$conectar_man_gasos', '$treure_mostres', '$doble_carga', '$prec_doble_carga_cli', '$prec_doble_carga_chof','$doble_descarga','$prec_doble_desc_cli','$prec_doble_desc_chof','$avisar_antes_cargar',
'$avisar_salir_cargado','$pedir_muestra','$descarga_bomba','$prec_desc_bomba_cli',
'$prec_desc_bomba_chof','$lts_desc_bomba','$planos_id','$horas_espera','$prec_horas_espera','$observ_horas_espera')";*/


$result_ord = mysql_query ($insertar_ord, $link) or die ("<br /> No se ha insertado orden: ".mysql_error()."<br /> $insertar_ord <br />");


// Como es autoincremental, seleccionamos máximo:
//$cod_albaran=obtener_max_con("cod_albaran","albaranes"," ");

//$cod_albaran=obtener_max_con("cod_albaran","albaranes","cod_empresa = '$cod_empresa' and cod_albaran < 8000 ") + 1;
/*
$cod_albaran="select MAX(cod_albaran) from albaranes where cod_albaran<8000";
echo "ALB:$cod_albaran";
exit();*/

} // Fin de else => if ($existe_ord==1)

} // Fin de if ($cod_empresa)


// Recargamos página:
?>
<script type="text/javascript">
//alert("FIN POST");
<? echo enviar_alb(); ?>
enlace(direccion_conta(''),'cod_albaran','<? echo "$cod_albaran"; ?>','cod_empresa','<? echo "$cod_empresa"; ?>','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos script:
exit();
} // Fin de if ($_POST)
//--------------------------------------------------------------------------------------------
//                                FIN DE: POST
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_albaran=$_GET["cod_albaran"];
$cod_empresa=$_GET["cod_empresa"];

$cod_linea=$_GET["cod_linea"];

$cod_cliente=$_GET["cod_cliente"]; // Para establecer la propiedad readonly.
$cod_descarga=$_GET["cod_descarga"];


$precio_cli=$_GET["precio_cli"];
$precio_chof=$_GET["precio_chof"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
$precio_chof=sel_campo("precio_chof","","descargas","cod_descarga='$cod_descarga'");
}

$cod_operadora=$_GET["cod_operadora"];

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");

$eliminar=$_GET["eliminar"];



/*
echo "
<br /> cod_albaran: $cod_albaran
<br /> cod_empresa: $cod_empresa
<br /> cod_linea: $cod_linea
<br /> cod_cliente: $cod_cliente
<br /> eliminar: $eliminar
<br />";
//*/

// Comprobamos si existe orden:
$select_ord="SELECT * FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";
$query_ord=mysql_query($select_ord, $link) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $select_ord <br />");
$existe_ord=mysql_num_rows($query_ord);


// Si existe orden, continuamos:
if ($existe_ord==1)
{
// Si está facturado, no eliminamos nada:
$albe=sel_sql("SELECT estado FROM albaranes WHERE cod_empresa = '$cod_empresa' AND cod_albaran = '$cod_albaran'");
$estado=$albe[0]['estado'];
if ($estado=='f' && $eliminar!='')
{
$eliminar='';
?>
<script type="text/javascript">
alert('NO se modificará albarán porque está facturado.');
</script>
<?
}

//---------------------------------------------------------------------------------------------
//                                      ELIMINAR ALBARÁN
//---------------------------------------------------------------------------------------------
if ($eliminar==2)
{

	if($estado!='f')
	{
// Eliminamos albarán:
$eliminar_alb="DELETE FROM albaranes WHERE cod_albaran = '$cod_albaran' AND cod_empresa = '$cod_empresa'";
$result_alb=mysql_query($eliminar_alb, $link) or die ("No se ha eliminado la orden ni sus artículos: ".mysql_error()."<br /> $eliminar_alb <br />");

// Vaciamos variables para evitar errores de introducción de datos:
$cod_albaran=$cod_empresa=$cod_linea="";

	}
} // Fin de else if ($eliminar==2)
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR ALBARÁN
//---------------------------------------------------------------------------------------------


if ($existe_ord==1 && $eliminar!=2)
{
// Mostramos orden:
$result_ord=mysql_query($select_ord, $link) or die ("No se ha mostrado la orden: ".mysql_error()."<br /> $select_ord <br />");
//echo "<br /> select_ord: $select_ord <br />";
$ord=mysql_fetch_array($result_ord);

$cod_albaran=$ord["cod_albaran"];
$cod_empresa=$ord["cod_empresa"];
$foto=$ord["foto"];
$estado=$ord["estado"];
$cod_factura=$ord["cod_factura"];
$fecha=fecha_esp($ord["fecha"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$tipo_iva=$ord["tipo_iva"];

$cod_descarga=$ord["cod_descarga"];
$observ_descarga=$ord["observ_descarga"];
$horas_descarga=$ord["horas_descarga"];
$precio_chof=$ord["precio_chof"];
$precio_cli=$ord["precio_cli"];
//$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");


if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");

if($horas_descarga==0)
{
	$horas_descarga=sel_campo("horas_descarga","","descargas","cod_descarga='$cod_descarga'");
}
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
$cod_operario2=$ord["cod_operario2"];

if($cod_operario)
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

if($cod_operario2)
$nombre_op2=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario2'");


/*echo "<br>1-$cod_operario";
echo "<br/>2-$cod_operario2";*/


$cod_conjunto=$ord["cod_conjunto"];

if($cod_conjunto)
$desc_conjunto=sel_campo("desc_conjunto","","conjuntos","cod_conjunto='$cod_conjunto'");

$avisador=$ord["avisador"];


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
$observa_conductor=$ord["observa_conductor"];
$incidencias=$ord["incidencias"];

$a_cobrar=$ord["a_cobrar"];
$serv_redon=$ord["serv_redon"];
$base=$ord["base"];

$cambiar_papel=$ord["cambiar_papel"];
$observ_cambiar_papel=$ord["observ_cambiar_papel"];
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
$prec_horas_espera=$ord["prec_horas_espera"];
$observ_horas_espera=$ord["observ_horas_espera"];


$total_coste=$ord["total_coste"];
$total_bruto=$ord["total_bruto"];
$total_descuento=$ord["total_descuento"];
$base=$ord["base"];
$total_beneficio=$ord["total_beneficio"];
$total_margen=$ord["total_margen"];

// Obtenemos asiento correspondiente:
if ($estado=="f")
{
conectar_base($base_datos_conta);
$cod_asiento=sel_campo("cod_asiento","","asientos","cod_empresa = '$cod_empresa' and txt_predef = 'VE' and cod_factura = $cod_factura");
conectar_base($base_datos);
}


// Si recibimos cod_linea y no hemos eliminado, mostramos artículo:
if ($cod_linea && $eliminar!=1)
{
$mostrar_art="SELECT * FROM art_alb WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";

$result_art=mysql_query($mostrar_art, $link) or die ("No se ha seleccionado artículo: ".mysql_error()."<br /> $mostrar_art <br />");
$art=mysql_fetch_array($result_art);

$cod_albaran=$art["cod_albaran"];
$cod_empresa=$art["cod_empresa"];
$cod_linea=$art["cod_linea"];
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];

$coste=$art["coste"];
$venta=$art["venta"];
$descuento=$art["descuento"];
$neto=$art["neto"];
$beneficio=$art["beneficio"];
$margen=$art["margen"];

// Obtenemos las existencias del artículo:
$existencias=sel_campo("existencias","","articulos","cod_articulo = '$cod_articulo'");
} // Fin de if ($cod_linea && $eliminar!=1)
} // Fin de if ($existe_ord==1 && $eliminar!=2)
} // Fin de if ($existe_ord==1)

else 
{
// Si recibimos cod_cliente, mostramos datos de cliente:
if ($cod_cliente)
{
$select_cli="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$result_cli=mysql_query($select_cli, $link) or die ("No se ha seleccionado cliente: ".mysql_error()."<br /> $select_cli <br />");
$cli=mysql_fetch_array($result_cli);
	
$nombre_cliente=$cli["nombre_cliente"];
$tipo_iva=$cli["tipo_iva"];
} // Fin de if ($cod_cliente)
} // Fin de else
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN DE: GET
//--------------------------------------------------------------------------------------------


// Establecemos la propiedad (y la clase) readonly:
if (($existe_ord==1 && $eliminar!=2) || $cod_cliente)
{
$readonly_inicial="";
$readonly_final="readonly class='readonly'";
}
else
{
$readonly_inicial="readonly class='readonly'";
}
//echo "<br /> existe_ord: $existe_ord <br /> existe_ord: $existe_ord <br />";


// Si no se muestra ningún albarán, mostraremos la fecha actual:
if (!$fecha)
{
$fecha_hoy=getdate();
$fecha=$fecha_hoy[mday].'-'.$fecha_hoy[mon].'-'.$usuario_any;
}

/*if (!$fecha_carga)
{
$fecha_hoy=getdate();
$fecha_carga=$fecha_hoy[mday].'-'.$fecha_hoy[mon].'-'.$usuario_any;
}*/

if (!$fecha_descarga || !$fecha_carga)
{
$fecha_hoy=getdate();

$dia=$fecha_hoy[mday]+1;
$mes=$fecha_hoy[mon];
$any=$usuario_any;
$ult_dia=ultimo_dia_mes($usuario_any,$fecha_hoy[mon]);
//echo "<br />ult_dia: $ult_dia";
if($dia>$ult_dia)
{
	$dia=1;
	$mes++;
	
	if($mes>12)
	{
		$mes=1;
		$any++;
	}
}

$fecha_carga=$dia.'-'.$mes.'-'.$any;
$fecha_descarga=$dia.'-'.$mes.'-'.$any;
}

?>
<script type="text/javascript">
function abrir_op()
{
var cod_albaran = document.getElementById('cod_albaran').value;
var cod_empresa = document.getElementById('cod_empresa').value;

if (cod_albaran && cod_empresa)
{
mostrar(event,direccion_conta('1_3_op_albaranes.php'),'cod_albaran',cod_albaran,'cod_empresa',cod_empresa,'','','','','','','','','','','','','','','','');
}

else
	alert("Seleccioni albarà i empresa abans d'introduïr operaris.");
} // Fin de function
//--------------------------------------------------------------------------------------------


function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="fecha";
ser_no_vacio[1]="matricula";

ser_ambos[0]="cod_cliente";

ser_numero[0]="cod_albaran";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

var estado = "<? echo $estado; ?>";

tt_enviar_alb_js(event,validado,estado,"1_2_impr_alb.php","1_1_fac_alb_crear.php");
} // Fin de function
//--------------------------------------------------------------------------------------------
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="cambiar_emp_iva(); cargar_foco('cod_cliente');">
<table>
<form name="albaranes" id="albaranes" method="post" action="">
          <tr class="titulo"> 
            <td colspan="15">Gesti&oacute; d'Albarans</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">N&ordm; Client:</td>
            <td colspan="6"><input name="cod_cliente" title="Código Cliente" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo "$cod_cliente"; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'cod_albaran',cod_albaran.value,'','','','','','','','','refrescar');" onMouseOut="this.blur()" <? echo $readonly_final; ?>>
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
              <? if ($estado!="f") { ?>
              <img src="/comun/imgs/usuario.gif" onClick="buscar_conta(event,'clientes','','','','','','','','','','','','','','cambio_cli_alb');">
              <? } ?>
              <input name="nombre_cliente" title="Nombre Cliente" type="text" id="nombre_cliente" size="40" maxlength="" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" readonly class="readonly"></td>
            <td width="160" align="right">IVA</td>
            <td colspan="2"><input name="tipo_iva" type="text" readonly class="readonly" id="tipo_iva" title="tipo_iva"  value="<? echo "$tipo_iva"; ?>" size="2" maxlength="4"></td>
            <td align="center"><? if ($foto) { ?>
              <img src="/comun/imgs/eliminar2.gif" title="Eliminar" onClick="enlace(direccion_conta(''),'cod_albaran','<? echo $cod_albaran; ?>','eliminar','1','','','','','','','','','','','','','','','','');">&nbsp;<span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta.'/fotos/'.$foto; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo $foto; ?></span>
            <? } ?></td>
            <td colspan="2" align="right"><? if ($cod_asiento) {echo "Asiento: "; ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_asiento;} ?></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td align="left">N&ordm; Albar&agrave;:</td>
            <td width="252"><input name="cod_albaran" title="Código Orden" type="text" id="cod_albaran" size="7" maxlength="6" value="<? echo "$cod_albaran"; ?>" onBlur="buscar_conta(event,'albaranes',cod_albaran.value,'cod_cliente',cod_cliente.value,'cod_albaran',cod_albaran.value,'cod_empresa',cod_empresa.value,'','','','','','','refrescar');" onMouseOut="this.blur()"> 
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_albaran');"></td>
            <td colspan="4">Empresa:
              <select name="cod_empresa" id="cod_empresa">
			   <? mostrar_lista("empresas",$cod_empresa); ?>
              </select></td>
            <td colspan="2" align="left"><strong>
              <input name="fecha" type="hidden" id="fecha" value="<? echo $fecha; ?>" readonly class="readonly">
            </strong>Viatge:</td>
            <td colspan="3" align="left"><input name="viaje" title="Tipo IVA" type="text" id="viaje" size="2" maxlength="2" value="<? echo "$viaje"; ?>"></td>
            <td colspan="2" align="right">
              <input name="estado" type="hidden" id="estado" value="<? echo $estado; ?>" readonly class="readonly">
            <strong>Estado:</strong> 
<? if ($estado!="f") {echo "No Facturado.";} else {echo "Factura: "; ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/3_2_fac_alb_impr.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','','','','','','','','','','','','','','');"><? echo sprintf("%06s", $cod_factura);} ?></span>			</td>
            <td width="24">&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="left">N&ordm; Desc&agrave;rrega:</td>
            <td colspan="5"><input name="cod_descarga" title="C&oacute;digo Descarga" type="text" id="cod_descarga" size="8" maxlength="7" value="<? echo "$cod_descarga"; ?>" onBlur="buscar_descarga_cli(event)" onMouseOut="this.blur()">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_descarga');">              <input name="poblacion" title="Poblacion" type="text" id="poblacion" size="40" maxlength="" value="<? echo a_html($poblacion,"bd->input"); ?>" readonly class="readonly">
              <input name="horas_descarga" type="text" id="horas_descarga" title="horas_descarga" value="<? echo "$horas_descarga"; ?>" size="4" maxlength="5"></td>
            <td colspan="2" align="left">Obs. Desc&agrave;rrega:</td>
            <td colspan="5"><input name="observ_descarga" title="observ_descarga" type="text" id="observ_descarga" size="50" maxlength="60" value="<? echo a_html($observ_descarga,"bd->input"); ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Operadora:</td>
            <td colspan="5"><input name="cod_operadora" title="C&oacute;digo Operadora" type="text" id="cod_operadora" size="2" maxlength="2" value="<? echo "$cod_operadora"; ?>" onBlur="buscar_conta(event,'operadoras',cod_operadora.value,'cod_operadora',cod_operadora.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operadora');"> <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="40" value="<? echo a_html($descripcion,"bd->input"); ?>" readonly class="readonly"></td>
            <td colspan="2" align="left">Avisador:</td>
            <td colspan="2"><input name="avisador" title="avisador" type="text" id="avisador" size="2" maxlength="1"  value="<? echo "$avisador"; ?>"></td>
            <td colspan="3" align="left">Franja
            <input name="franja" title="Franja" type="text" id="franja" size="11" maxlength="10"  value="<? echo "$franja"; ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Data C&agrave;rrega: </td>
            <td colspan="5"><input name="fecha_carga" title="Fecha Carga" type="text" id="fecha_carga" size="11" maxlength="10"  value="<? echo "$fecha_carga"; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','albaranes','fecha_carga')"></td>
            <td colspan="2" align="left">Data Desc&agrave;rrega:</td>
            <td colspan="5"><input name="fecha_descarga" title="Fecha Descarga" type="text" id="fecha_descarga" size="11" maxlength="10"  value="<? echo "$fecha_descarga"; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','albaranes','fecha_descarga')"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Preu Conductor: </td>
            <td colspan="5"><input name="precio_chof" title="precio_chof" type="text" id="precio_chof" size="11" maxlength="10"  value="<? echo "$precio_chof"; ?>"></td>
            <td colspan="2" align="left">Preu Desc: </td>
            <td colspan="2"><input name="precio_cli" title="precio_cli" type="text" id="precio_cli" size="11" maxlength="10"  value="<? echo "$precio_cli"; ?>" readonly class="readonly"></td>
            <td colspan="3" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="13" align="left"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Targeta:</td>
            <td colspan="5"><input name="cod_tarjeta" title="C&oacute;digo Tarjeta" type="text" id="cod_tarjeta" size="4" maxlength="3" value="<? echo "$cod_tarjeta"; ?>" onBlur="buscar_conta(event,'tarjetas',cod_tarjeta.value,'cod_tarjeta',cod_tarjeta.value,'','','','','','','','','','','tarj');" onMouseOut="this.blur()">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tarjeta');">
              <input name="mat1" title="mat1" type="text" id="mat1" size="10" maxlength="10" value="<? echo "$mat1"; ?>" readonly class="readonly">
              <input name="cod_tractora" title="Codi Tractora" type="text" id="cod_tractora" size="3" maxlength="3" value="<? echo $cod_tractora; ?>" onBlur="buscar_conta(event,'tractoras',cod_tractora.value,'cod_tractora',cod_tractora.value,'','','','','','','','','','','trac');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_tractora');">
<input name="mat2" title="mat2" type="text" id="mat2" size="10" maxlength="10" value="<? echo "$mat2"; ?>" readonly class="readonly"></td>
            <td colspan="2" align="left">Conductor 1:</td>
            <td colspan="5"><input name="cod_operario" title="C&oacute;digo Conductor" type="text" id="cod_operario" size="2" maxlength="2" value="<? echo "$cod_operario"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'fecha_carga',fecha_carga.value,'','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
            <input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="40" maxlength="40" value="<? echo a_html($nombre_op,"bd->input"); ?>" readonly class="readonly"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Terminal: </td>
            <td colspan="5"><input name="cod_terminal" title="C&oacute;digo Terminal" type="text" id="cod_terminal" size="2" maxlength="2" value="<? echo "$cod_terminal"; ?>" onBlur="buscar_conta(event,'terminales',cod_terminal.value,'cod_terminal',cod_terminal.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_terminal');">              <input name="nombre_terminal" title="Nombre Terminal" type="text" id="nombre_terminal" size="40" maxlength="40" value="<? echo a_html($nombre_terminal,"bd->input"); ?>" readonly class="readonly"></td>
            <td colspan="2" align="left">Conductor 2:</td>
            <td colspan="5"><input name="cod_operario2" title="C&oacute;digo Conductor" type="text" id="cod_operario2" size="2" maxlength="2" value="<? echo "$cod_operario2"; ?>" onBlur="buscar_conta(event,'operarios',cod_operario2.value,'cod_operario',cod_operario2.value,'fecha_descarga',fecha_descarga.value,'','','','','','','','','cod_operario2');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
            <input name="nombre_op2" title="Nombre Operario" type="text" id="nombre_op2" size="40" maxlength="40" value="<? echo a_html($nombre_op2,"bd->input"); ?>" readonly class="readonly"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="13" align="left"><hr /></td>
            <td></td>
          </tr>
          
          
          <tr> 
            <td>&nbsp;</td>
            <td align="left">Comanda:            </td>
            <td colspan="5" align="left"><input name="cod_pedido" title="Comanda" type="text" id="cod_pedido" size="33" maxlength="30" value="<? echo "$cod_pedido"; ?>"></td>
            <td colspan="2" align="left">Canviar papers </td>
			
			<? if($cambiar_papel==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
			
            <td width="114"><input name="cambiar_papel" type="checkbox" id="cambiar_papel" value="1" <? echo "$seleccionado"; ?>></td>
            <td colspan="4"><input name="observ_cambiar_papel" title="observ_cambiar_papel" type="text" id="observ_cambiar_papel" size="25" maxlength="40" value="<? echo a_html($observ_cambiar_papel,"bd->input"); ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">Serv. Red: </td>
            <td colspan="2"><input name="serv_redon" title="serv_redon" type="text" readonly class="readonly" id="serv_redon" size="8" maxlength="8" value="<? echo "$serv_redon"; ?>"></td>
            <td align="right"><strong>Quantitats:</strong></td>
            <td align="left"><input name="a_cobrar" type="text" readonly class="readonly" id="a_cobrar" title="a_cobrar" value="<? echo "$a_cobrar"; ?>" size="2" maxlength="2"></td>
            <td width="168">&nbsp;</td>
            <td colspan="2" align="left">Conectar toma terra </td>
			
			<? if($conectar_toma_terra==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="conectar_toma_terra" type="checkbox" id="conectar_toma_terra" value="1" <? echo "$seleccionado"; ?>></td>
            <td width="66">&nbsp;</td>
            <td width="72">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="2">Servits</td>
            <td width="83" align="right">Comp.</td>
            <td align="right">Quant.</td>
            <td>Prod.</td>
            <td colspan="2" align="left">Conectar m&agrave;nega gasos </td>
			
			<? if($conectar_man_gasos==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="conectar_man_gasos" type="checkbox" id="conectar_man_gasos" value="1" <? echo "$seleccionado"; ?>></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="167" align="right"><div align="left">ADITIVAT:</div></td>
            <td colspan="2"><input name="cant_blue" title="ADITIVAT" type="text" id="cant_blue" size="8" maxlength="8" value="<? echo "$cant_blue"; ?>">              <input name="serv_blue" title="ADITIVAT" type="text" id="serv_blue" size="8" maxlength="8" value="<? echo "$serv_blue"; ?>" readonly class="readonly"></td>
            <td align="right">1</td>
            <td align="right"><input name="cant_comp1" title="cant_comp1" type="text" id="cant_comp1" size="8" maxlength="8" value="<? echo "$cant_comp1"; ?>"></td>
            <td><input name="prod_comp1" title="prod_comp1" type="text" id="prod_comp1" size="8" maxlength="8" value="<? echo "$prod_comp1"; ?>"></td>
            <td colspan="2" align="left">Treure mostres abans desc. </td>
			<? if($treure_mostres==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="treure_mostres" type="checkbox" id="treure_mostres" value="1" <? echo "$seleccionado"; ?>></td>
            <td colspan="2">Preu Cli</td>
            <td>Preu Chofer </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="right"><div align="left">SP95:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_sp95" title="sp95" type="text" id="cant_sp95" size="8" maxlength="8" value="<? echo "$cant_sp95"; ?>">
              <input name="serv_sp95" title="serv_sp95" type="text" id="serv_sp95" size="8" maxlength="8" value="<? echo "$serv_sp95"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">2</td>
            <td align="right"><input name="cant_comp2" title="cant_comp2" type="text" id="cant_comp2" size="8" maxlength="8" value="<? echo "$cant_comp2"; ?>"></td>
            <td><input name="prod_comp2" title="prod_comp2" type="text" id="prod_comp2" size="8" maxlength="8" value="<? echo "$prod_comp2"; ?>"></td>
            <td colspan="2" align="left">Doble c&agrave;rrega </td>
			<? if($doble_carga==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="doble_carga" type="checkbox" id="doble_carga" value="1" <? echo "$seleccionado"; ?>></td>
            <td colspan="2"><input name="prec_doble_carga_cli" title="prec_doble_carga_cli" type="text" id="prec_doble_carga_cli" size="8" maxlength="8" value="<? echo "$prec_doble_carga_cli"; ?>"></td>
            <td width="91"><input name="prec_doble_carga_chof" title="prec_doble_carga_chof" type="text" id="prec_doble_carga_chof" size="8" maxlength="8" value="<? echo "$prec_doble_carga_chof"; ?>"></td>
            <td width="162">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="right"><div align="left">SP98:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_sp98" title="sp98" type="text" id="cant_sp98" size="8" maxlength="8" value="<? echo "$cant_sp98"; ?>">
              <input name="serv_sp98" title="serv_sp98" type="text" id="serv_sp98" size="8" maxlength="8" value="<? echo "$serv_sp98"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">3</td>
            <td align="right"><input name="cant_comp3" title="cant_comp3" type="text" id="cant_comp3" size="8" maxlength="8" value="<? echo "$cant_comp3"; ?>"></td>
            <td><input name="prod_comp3" title="prod_comp3" type="text" id="prod_comp3" size="8" maxlength="8" value="<? echo "$prod_comp3"; ?>"></td>
            <td colspan="2" align="left">Doble desc&agrave;rrega </td>
			<? if($doble_descarga==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="doble_descarga" type="checkbox" id="doble_descarga" value="1" <? echo "$seleccionado"; ?>></td>
            <td colspan="2"><input name="prec_doble_desc_cli" title="prec_doble_desc_cli" type="text" id="prec_doble_desc_cli" size="8" maxlength="8" value="<? echo "$prec_doble_desc_cli"; ?>"></td>
            <td><input name="prec_doble_desc_chof" title="prec_doble_desc_chof" type="text" id="prec_doble_desc_chof" size="8" maxlength="8" value="<? echo "$prec_doble_desc_chof"; ?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><div align="left">GO A:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_go_a" title="go_a" type="text" id="cant_go_a" size="8" maxlength="8" value="<? echo "$cant_go_a"; ?>">
              <input name="serv_go_a" title="serv_go_a" type="text" id="serv_go_a" size="8" maxlength="8" value="<? echo "$serv_go_a"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">4</td>
            <td align="right"><input name="cant_comp4" title="cant_comp4" type="text" id="cant_comp4" size="8" maxlength="8" value="<? echo "$cant_comp4"; ?>"></td>
            <td><input name="prod_comp4" title="prod_comp4" type="text" id="prod_comp4" size="8" maxlength="8" value="<? echo "$prod_comp4"; ?>"></td>
            <td colspan="2" align="left">Avisar abans carregar </td>
			<? if($avisar_antes_cargar==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="avisar_antes_cargar" type="checkbox" id="avisar_antes_cargar" value="1" <? echo "$seleccionado"; ?>></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><div align="left">B1000:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_go_a1" title="go_a1" type="text" id="cant_go_a1" size="8" maxlength="8" value="<? echo "$cant_go_a1"; ?>">
              <input name="serv_go_a1" title="serv_go_a1" type="text" id="serv_go_a1" size="8" maxlength="8" value="<? echo "$serv_go_a1"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">5</td>
            <td align="right"><input name="cant_comp5" title="cant_comp5" type="text" id="cant_comp5" size="8" maxlength="8" value="<? echo "$cant_comp5"; ?>"></td>
            <td><input name="prod_comp5" title="prod_comp5" type="text" id="prod_comp5" size="8" maxlength="8" value="<? echo "$prod_comp5"; ?>"></td>
            <td colspan="2" align="left">Avisar al sortir carregat </td>
			
			<? if($avisar_salir_cargado==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="avisar_salir_cargado" type="checkbox" id="avisar_salir_cargado" value="1" <? echo "$seleccionado"; ?>></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><div align="left">GO B:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_go_b" title="go_b" type="text" id="cant_go_b" size="8" maxlength="8" value="<? echo "$cant_go_b"; ?>">
              <input name="serv_go_b" title="serv_go_b" type="text" id="serv_go_b" size="8" maxlength="8" value="<? echo "$serv_go_b"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">6</td>
            <td align="right"><input name="cant_comp6" title="cant_comp6" type="text" id="cant_comp6" size="8" maxlength="8" value="<? echo "$cant_comp6"; ?>"></td>
            <td><input name="prod_comp6" title="prod_comp6" type="text" id="prod_comp6" size="8" maxlength="8" value="<? echo "$prod_comp6"; ?>"></td>
            <td colspan="2" align="left">Demanar mostra </td>
			
			<? if($pedir_muestra==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="pedir_muestra" type="checkbox" id="pedir_muestra" value="1" <? echo "$seleccionado"; ?>></td>
            <td colspan="2">Preu Cli</td>
            <td>Preu Chofer</td>
            <td>Litres</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><div align="left">GO C:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_go_c" title="go_c" type="text" id="cant_go_c" size="8" maxlength="8" value="<? echo "$cant_go_c"; ?>">
              <input name="serv_go_c" title="serv_go_c" type="text" id="serv_go_c" size="8" maxlength="8" value="<? echo "$serv_go_c"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">7</td>
            <td align="right"><input name="cant_comp7" title="cant_comp7" type="text" id="cant_comp7" size="8" maxlength="8" value="<? echo "$cant_comp7"; ?>"></td>
            <td><input name="prod_comp7" title="prod_comp7" type="text" id="prod_comp7" size="8" maxlength="8" value="<? echo "$prod_comp7"; ?>"></td>
            <td colspan="2" align="left">Desc&agrave;rrega amb bomba </td>
	
			<? if($descarga_bomba==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td><input name="descarga_bomba" type="checkbox" id="descarga_bomba" value="1" <? echo "$seleccionado"; ?>></td>
            <td colspan="2"><input name="prec_desc_bomba_cli" title="prec_desc_bomba_cli" type="text" id="prec_desc_bomba_cli" size="8" maxlength="8" value="<? echo "$prec_desc_bomba_cli"; ?>"></td>
            <td><input name="prec_desc_bomba_chof" title="prec_desc_bomba_chof" type="text" id="prec_desc_bomba_chof" size="8" maxlength="8" value="<? echo "$prec_desc_bomba_chof"; ?>"></td>
            <td><input name="lts_desc_bomba" title="lts_desc_bomba" type="text" id="lts_desc_bomba" size="8" maxlength="8" value="<? echo "$lts_desc_bomba"; ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><div align="left">BIO:</div></td>
            <td colspan="2" align="right"><div align="left">
              <input name="cant_bio" title="bio" type="text" id="cant_bio" size="8" maxlength="8" value="<? echo "$cant_bio"; ?>">
              <input name="serv_bio" title="serv_bio" type="text" id="serv_bio" size="8" maxlength="8" value="<? echo "$serv_bio"; ?>" readonly class="readonly">
            </div></td>
            <td align="right">8</td>
            <td align="right"><input name="cant_comp8" title="cant_comp8" type="text" id="cant_comp8" size="8" maxlength="8" value="<? echo "$cant_comp8"; ?>"></td>
            <td><input name="prod_comp8" title="prod_comp8" type="text" id="prod_comp8" size="8" maxlength="8" value="<? echo "$prod_comp8"; ?>"></td>
            <td colspan="2" align="left">Planells d'identificaci&oacute; </td>
            <td colspan="3"><select name="planos_id" id="planos_id">
			<? 
			if($planos_id==0)
			{
				$planos_mostrar="Sense P.";
			} 
			else if($planos_id==1)
			{
				$planos_mostrar="30/1202";
				
			} else
			{
				$planos_mostrar="33/1203";
			}
			?>
			<option value="<? echo "$planos_id"; ?>" selected><? echo "$planos_mostrar"; ?></option>
              <option value="1">30/1202</option>
              <option value="2">33/1203</option>
			  <option value="0">Sense P.</option>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="7" align="left">Hores d'espera
              <input name="horas_espera" title="horas_espera" type="text" id="horas_espera" size="4" maxlength="4" value="<? echo "$horas_espera"; ?>">
h
<input name="prec_horas_espera" title="prec_horas_espera" type="text" id="prec_horas_espera" size="13" maxlength="11" value="<? echo "$prec_horas_espera"; ?>">
&euro;
<input name="observ_horas_espera" title="observ_horas_espera" type="text" id="observ_horas_espera" size="50" maxlength="40" value="<? echo a_html($observ_horas_espera,"bd->input"); ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Incid&egrave;ncies:            </td>
            <td colspan="12"><input name="incidencias" title="Incidencias" type="text" id="incidencias" size="100" maxlength="100" value="<? echo a_html($incidencias,"bd->input"); ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Observacions Conduct:</td>
            <td colspan="12"><input name="observa_conductor" title="observa_conductor" type="text" id="observa_conductor" size="100" maxlength="100" value="<? echo a_html($observa_conductor,"bd->input"); ?>"></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td colspan="11"><?
$campo_pag[1]="cod_albaran"; $valor_pag[1]=$cod_albaran;
$campo_pag[2]="cod_empresa"; $valor_pag[2]=$cod_empresa;


// Paginamos:
paginar("paginar");
?></td>
            <td colspan="2" align="right"><strong>TOTAL: <? echo formatear($base);?></strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td >&nbsp;</td>
            <td></td>
            <td>&nbsp;</td>
            <td colspan="2"><? if ($estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />Guardar</div>
			<? } ?></td>
            <td width="54"><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />
            Nou</div></td>
            <td><? if ($estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_albaran');"><br />
Eliminar</div>
			<? } ?></td>
            <td colspan="2"><? if ($cod_albaran && $estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/factura.gif" name="facturar" id="facturar" title="Facturar" onClick="enviar(event)" onMouseOver="window.top.focus();"><br />Facturar</div>
			<? } ?></td>
            <td colspan="2" align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>