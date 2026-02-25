<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SERES</title>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="REFRESH" content="30">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?

$h=getdate();
$fecha_actual=sprintf("%02s-%02s-%04s", $h['mday'],$h['mon'],$h['year']);
$hora_actual=sprintf("%02s:%02s:%02s", $h['hours'],$h['minutes'],"00");

$dia_semana = date("l",strtotime ($fecha_actual));

//echo "$dia_semana";

/*if($dia_semana!='Monday')
{
	echo "Avui no es poden traspassar Multes.";	
	exit();
}*/ 

$fecha_actual=fecha_ing($fecha_actual);


if ($_POST)
{
$rem=$_POST["rem"];


$ii=0;
$num=count($rem);

for($i=0; $i < $num; $i++)
{
	//echo "I::::".$i;
// Obtenemos datos:
//$c=sel_sql("SELECT * FROM facturas WHERE tabla = '$tabla' AND cod_factura = '".$rem[$i]."'");

//******************************************** CAMPOS PARA ENVIAR A SERES:************************************************//

/**************REGISTRO DE CONTROL RECTL********************/
//1
$tipo_registro = 'RECTL';
$tipo_registro = str_pad($tipo_registro, 6, " ", STR_PAD_RIGHT);

//2
$tipo_mensaje = 'INVOIC';

//3
$cod_emisor = 'B61034104'; // codigo que identifica al emisor
$cod_emisor = str_pad($cod_emisor, 35, " ", STR_PAD_RIGHT);

//4
$cod_receptor = '8422410000005'; // codigo que identifica al receptor
$cod_receptor = str_pad($cod_receptor, 35, " ", STR_PAD_RIGHT);


//5
$id_mensaje = sel_campo("cod_factura","","facturas","cod_factura='".$rem[$i]."'");
$id_mensaje = str_pad($id_mensaje, 40, " ", STR_PAD_RIGHT);

//6
$fecha_mens = $fecha_actual;
list($any, $mes, $dia) = explode("-", $fecha_mens);
$data_new = substr($any,0,4).$mes.$dia;

$hora_mens = $hora_actual;
list($hora, $min, $seg) = explode(":", $hora_mens);
$hora_new = $hora.$min;

$fecha_new=$data_new.$hora_new;


$rectl=$tipo_registro.$tipo_mensaje.$cod_emisor.$cod_receptor.$id_mensaje.$fecha_new."\n";

$cadena=$rectl;
//fputs($file, $rectl) or die("NO");


/**************REGISTRO DE CABECERA DE FACTURA SINCC********************/

//1
$tipo_registro_cab = 'SINCC';
$tipo_registro_cab = str_pad($tipo_registro_cab, 6, " ", STR_PAD_RIGHT);

//2:
$tipo_fact = '380';
$tipo_fact = str_pad($tipo_fact, 6, " ", STR_PAD_RIGHT);

//3:
$num_fact = sel_campo("cod_factura","","facturas","cod_factura='".$rem[$i]."'");
$num_fact = str_pad($num_fact, 17, "0", STR_PAD_LEFT);

//4:
$funcion_mens = '';
$funcion_mens = str_pad($funcion_mens, 6, " ", STR_PAD_RIGHT);

//5:
$fac_fecha = sel_campo("fac_fecha","","facturas","cod_factura='".$rem[$i]."'");
list($any, $mes, $dia) = explode("-", $fac_fecha);
$fac_fecha_new = substr($any,0,4).$mes.$dia;

$fac_fecha_new = str_pad($fac_fecha_new, 8, " ", STR_PAD_RIGHT);

//6: 
$fecha_alb = '';
$fecha_alb = str_pad($fecha_alb, 16, " ", STR_PAD_RIGHT);

//7: 
$mod_pago = '';
$mod_pago = str_pad($mod_pago, 6, " ", STR_PAD_RIGHT);

//8: 
$razon = '';
$razon = str_pad($razon, 3, " ", STR_PAD_RIGHT);

//9: 
$criterio = '';
$criterio = str_pad($criterio, 3, " ", STR_PAD_RIGHT);

//10: 
//$num_pedido = sel_campo("cod_pedido","","albaranes","cod_factura='".$rem[$i]."'");
$num_pedido = '0';
$num_pedido = str_pad($num_pedido, 17, "0", STR_PAD_LEFT);

//11: 
$num_alb = sel_campo("cod_pedido","","albaranes","cod_factura='".$rem[$i]."'");
$num_alb = str_pad($num_alb, 17, " ", STR_PAD_RIGHT);

//12: 
$calificador = '';
$calificador = str_pad($calificador, 3, " ", STR_PAD_RIGHT);

//13: 
$doc_rectif = '';
$doc_rectif = str_pad($doc_rectif, 17, " ", STR_PAD_RIGHT);

//14: 
$num_contra = '';
$num_contra = str_pad($num_contra, 17, " ", STR_PAD_RIGHT);

//15: 
$num_relac = '';
$num_relac = str_pad($num_relac, 17, " ", STR_PAD_RIGHT);

//16: 
$moneda = 'EUR';
$moneda = str_pad($moneda, 6, " ", STR_PAD_RIGHT);

//17: 
$fecha_vto = sel_campo("venci1","","facturas","cod_factura='".$rem[$i]."'");
list($any, $mes, $dia) = explode("-", $fecha_vto);
$fecha_vto_new = substr($any,0,4).$mes.$dia;

//18: 
$importe_fact = sel_campo("fac_base","","facturas","cod_factura='".$rem[$i]."'");

list($entero, $decimal) = explode(".", $importe_fact);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$importe_fact_new = $entero_new.'.'.$decimal_new;

$ini+=strlen($importe_fact_new);



//19
$base_imp =  sel_campo("fac_base","","facturas","cod_factura='".$rem[$i]."'");

list($entero, $decimal) = explode(".", $base_imp);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);

$base_imp_new = $entero_new.'.'.$decimal_new;

//20
$bruto =  sel_campo("fac_bruto","","facturas","cod_factura='".$rem[$i]."'");

list($entero, $decimal) = explode(".", $bruto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);

$bruto_new = $entero_new.'.'.$decimal_new;

//21
$iva = sel_campo("fac_iva","","facturas","cod_factura='".$rem[$i]."'");

list($entero, $decimal) = explode(".", $iva);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);

$iva_new = $entero_new.'.'.$decimal_new;

/*
echo "<br/>entero: $entero";
echo "<br/>decimal: $decimal";
echo "<br/>importe_fact_new: $importe_fact_new";
echo "<br/>base_imp_new: $base_imp_new";
echo "<br/>bruto_new: $bruto_new";
echo "<br/>iva_new: $iva_new";
exit();
*/

//22
$importe_total = $base_imp_new + $iva_new;

list($entero, $decimal) = explode(".", $importe_total);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);

$importe_total = $entero_new.'.'.$decimal_new;

/*
echo "$importe_total";
exit();*/

//23
$subven = '';
$subven = str_pad($subven, 18, "0", STR_PAD_LEFT);

//24
$total_incr = '';
$total_incr = str_pad($total_incr, 18, "0", STR_PAD_LEFT);

//25
$total_min = '';
$total_min = str_pad($total_min, 18, "0", STR_PAD_LEFT);

//26
$periodo_imp = '';
$periodo_imp = str_pad($periodo_imp, 16, " ", STR_PAD_RIGHT);

//27
$fecha_ped = '';
$fecha_ped = str_pad($fecha_ped, 8, "0", STR_PAD_LEFT);

//28
$fecha_efect_serv = '';
$fecha_efect_serv = str_pad($fecha_efect_serv, 12, " ", STR_PAD_RIGHT);

//29
$num_confirm = '';
$num_confirm = str_pad($num_confirm, 17, " ", STR_PAD_RIGHT);


$sincc=$tipo_registro_cab.$tipo_fact.$num_fact.$funcion_mens.$fac_fecha_new.$fecha_alb.$mod_pago.$razon.$criterio.$num_pedido.$num_alb.$calificador.$doc_rectif.$num_contra.$num_relac.$moneda.$fecha_vto_new.$importe_fact_new.$base_imp_new.$bruto_new.$iva_new.$importe_total.$subven.$total_incr.$total_min.$periodo_imp.$fecha_ped.$fecha_efect_serv.$num_confirm."\n";

$cadena.=$sincc;
//fputs($file, $sincc) or die("NO");



/**************REGISTRO DE CABECERA DE FACTURA SINCP- SU (PROVEEDOR)********************/

//1
$tipo_registro_p_su = 'SINCP';
$tipo_registro_p_su = str_pad($tipo_registro_p_su, 6, " ", STR_PAD_RIGHT);

//2 QUIEN FACTURA:
$califica_inter = 'SU';
$califica_inter = str_pad($califica_inter, 3, " ", STR_PAD_RIGHT);


//SACAMOS DATOS DE EMPRESA SEGU:
$codigo_em = sel_campo("cod_empresa","","facturas","cod_factura='".$rem[$i]."'");

conectar_base($base_datos_conta);

$nombre_empresa = sel_campo("nom_empresa","","empresas","cod_empresa='$codigo_em'");
$direcc_empresa = sel_campo("domicilio","","empresas","cod_empresa='$codigo_em'");
$ciudad_empresa = sel_campo("poblacion","","empresas","cod_empresa='$codigo_em'");
$provinc_empresa = sel_campo("provincia","","empresas","cod_empresa='$codigo_em'");
$cp_empresa = sel_campo("c_postal","","empresas","cod_empresa='$codigo_em'");
$id_fiscal_empresa = sel_campo("nif_cif","","empresas","cod_empresa='$codigo_em'");
$id_fiscal_empresa = str_replace("-","",$id_fiscal_empresa);
$tel_empresa = sel_campo("telefono","","empresas","cod_empresa='$codigo_em'");
$fax_empresa = sel_campo("fax","","empresas","cod_empresa='$codigo_em'");
$iban_empresa = sel_campo("iban","","empresas","cod_empresa='$codigo_em'");

conectar_base($base_datos);


//3 CODIGO INTERLOCUTOR: NO SE CUAL ES:
$codigo_inter = $id_fiscal_empresa; // codigo que identifica al proveedor (segu)
$codigo_inter = str_pad($codigo_inter, 17, " ", STR_PAD_RIGHT);

//4
$tipo_inter = '9';
$tipo_inter = str_pad($tipo_inter, 3, " ", STR_PAD_RIGHT);

//5
$nombre_inter = $nombre_empresa;
$nombre_inter = str_pad($nombre_inter, 35, " ", STR_PAD_RIGHT);

//6
$nombre2 = '';
$nombre2 = str_pad($nombre2, 35, " ", STR_PAD_RIGHT);

//7
$nombre3 = '';
$nombre3 = str_pad($nombre3, 35, " ", STR_PAD_RIGHT);

//8
$nombre4 = '';
$nombre4 = str_pad($nombre4, 35, " ", STR_PAD_RIGHT);

//9
$nombre5 = '';
$nombre5 = str_pad($nombre5, 35, " ", STR_PAD_RIGHT);

//10
$direcc1 = $direcc_empresa;
$direcc1 = str_pad($direcc1, 35, " ", STR_PAD_RIGHT);

//11
$direcc2 = '';
$direcc2 = str_pad($direcc2, 35, " ", STR_PAD_RIGHT);

//12
$direcc3 = '';
$direcc3 = str_pad($direcc3, 35, " ", STR_PAD_RIGHT);

//13
$direcc4 = '';
$direcc4 = str_pad($direcc4, 35, " ", STR_PAD_RIGHT);

//14
$ciudad_empresa = $ciudad_empresa;
$ciudad_empresa = str_pad($ciudad_empresa, 35, " ", STR_PAD_RIGHT);

//15
$provinc_empresa = $provinc_empresa;
$provinc_empresa = str_pad($provinc_empresa, 9, " ", STR_PAD_RIGHT);

//16
$cp_empresa = $cp_empresa;
$cp_empresa = str_pad($cp_empresa, 9, " ", STR_PAD_RIGHT);

//17
$cod_pais = '';
$cod_pais = str_pad($cod_pais, 3, " ", STR_PAD_RIGHT);

//18
$id_fiscal_empresa = $id_fiscal_empresa;
$id_fiscal_empresa = str_pad($id_fiscal_empresa, 35, " ", STR_PAD_RIGHT);

//19
$cod_adic = '';
$cod_adic = str_pad($cod_adic, 35, " ", STR_PAD_RIGHT);

//20
$func_contact = '';
$func_contact = str_pad($func_contact, 3, " ", STR_PAD_RIGHT);

//20
$cod_depart = '';
$cod_depart = str_pad($cod_depart, 17, " ", STR_PAD_RIGHT);

//21
$nom_depart = '';
$nom_depart = str_pad($nom_depart, 35, " ", STR_PAD_RIGHT);

//22
$tel_empresa = $tel_empresa;
$tel_empresa = str_pad($tel_empresa, 35, " ", STR_PAD_RIGHT);

//24
$fax_empresa = $fax_empresa;
$fax_empresa = str_pad($fax_empresa, 35, " ", STR_PAD_RIGHT);

//25
$iban_empresa = $iban_empresa;
$iban_empresa = str_pad($iban_empresa, 35, " ", STR_PAD_RIGHT);

//26
$reg_merc = '';
$reg_merc = str_pad($reg_merc, 70, " ", STR_PAD_RIGHT);

//27
$cap_social = '';
$cap_social = str_pad($cap_social, 35, " ", STR_PAD_RIGHT);

//28
$calif = '';
$calif = str_pad($calif, 3, " ", STR_PAD_RIGHT);

//29
$ref_adic = '';
$ref_adic = str_pad($ref_adic, 35, " ", STR_PAD_RIGHT);


$sincp_su=$tipo_registro_p_su.$califica_inter.$codigo_inter.$tipo_inter.$nombre_inter.$nombre2.$nombre3.$nombre4.$nombre5.$direcc1.$direcc2.$direcc3.$direcc4.$ciudad_empresa.$provinc_empresa.$cp_empresa.$cod_pais.$id_fiscal_empresa.$cod_adic.$func_contact.$cod_depart.$nom_depart.$tel_empresa.$fax_empresa.$iban_empresa.$reg_merc.$cap_social.$calif.$ref_adic."\n";

$cadena.=$sincp_su;

/*echo "$sincp_su";
exit();
*/

/**************REGISTRO DE CABECERA DE FACTURA SINCP- II (QUIEN FACTURA)********************/

//1
$tipo_registro_p = 'SINCP';
$tipo_registro_p = str_pad($tipo_registro_p, 6, " ", STR_PAD_RIGHT);

//2 QUIEN FACTURA:
$califica_inter = 'II';
$califica_inter = str_pad($califica_inter, 3, " ", STR_PAD_RIGHT);



//SACAMOS DATOS DE EMPRESA SEGU:
$codigo_em = sel_campo("cod_empresa","","facturas","cod_factura='".$rem[$i]."'");

conectar_base($base_datos_conta);

$nombre_empresa = sel_campo("nom_empresa","","empresas","cod_empresa='$codigo_em'");
$direcc_empresa = sel_campo("domicilio","","empresas","cod_empresa='$codigo_em'");
$ciudad_empresa = sel_campo("poblacion","","empresas","cod_empresa='$codigo_em'");
$provinc_empresa = sel_campo("provincia","","empresas","cod_empresa='$codigo_em'");
$cp_empresa = sel_campo("c_postal","","empresas","cod_empresa='$codigo_em'");
$id_fiscal_empresa = sel_campo("nif_cif","","empresas","cod_empresa='$codigo_em'");
$id_fiscal_empresa = str_replace("-","",$id_fiscal_empresa);
$tel_empresa = sel_campo("telefono","","empresas","cod_empresa='$codigo_em'");
$fax_empresa = sel_campo("fax","","empresas","cod_empresa='$codigo_em'");
$iban_empresa = sel_campo("iban","","empresas","cod_empresa='$codigo_em'");

conectar_base($base_datos);


//3 CODIGO INTERLOCUTOR: NO SE CUAL ES:
$codigo_inter =  $id_fiscal_empresa; // codigo que identifica al receptor
$codigo_inter = str_pad($codigo_inter, 17, " ", STR_PAD_RIGHT);

//4
$tipo_inter = '9';
$tipo_inter = str_pad($tipo_inter, 3, " ", STR_PAD_RIGHT);

//5
$nombre_inter = $nombre_empresa;
$nombre_inter = str_pad($nombre_inter, 35, " ", STR_PAD_RIGHT);

//6
$nombre2 = '';
$nombre2 = str_pad($nombre2, 35, " ", STR_PAD_RIGHT);

//7
$nombre3 = '';
$nombre3 = str_pad($nombre3, 35, " ", STR_PAD_RIGHT);

//8
$nombre4 = '';
$nombre4 = str_pad($nombre4, 35, " ", STR_PAD_RIGHT);

//9
$nombre5 = '';
$nombre5 = str_pad($nombre5, 35, " ", STR_PAD_RIGHT);

//10
$direcc1 = $direcc_empresa;
$direcc1 = str_pad($direcc1, 35, " ", STR_PAD_RIGHT);

//11
$direcc2 = '';
$direcc2 = str_pad($direcc2, 35, " ", STR_PAD_RIGHT);

//12
$direcc3 = '';
$direcc3 = str_pad($direcc3, 35, " ", STR_PAD_RIGHT);

//13
$direcc4 = '';
$direcc4 = str_pad($direcc4, 35, " ", STR_PAD_RIGHT);

//14
$ciudad_empresa = $ciudad_empresa;
$ciudad_empresa = str_pad($ciudad_empresa, 35, " ", STR_PAD_RIGHT);

//15
$provinc_empresa = $provinc_empresa;
$provinc_empresa = str_pad($provinc_empresa, 9, " ", STR_PAD_RIGHT);

//16
$cp_empresa = $cp_empresa;
$cp_empresa = str_pad($cp_empresa, 9, " ", STR_PAD_RIGHT);

//17
$cod_pais = '';
$cod_pais = str_pad($cod_pais, 3, " ", STR_PAD_RIGHT);

//18
$id_fiscal_empresa = $id_fiscal_empresa;
$id_fiscal_empresa = str_pad($id_fiscal_empresa, 35, " ", STR_PAD_RIGHT);

//19
$cod_adic = '';
$cod_adic = str_pad($cod_adic, 35, " ", STR_PAD_RIGHT);

//20
$func_contact = '';
$func_contact = str_pad($func_contact, 3, " ", STR_PAD_RIGHT);

//20
$cod_depart = '';
$cod_depart = str_pad($cod_depart, 17, " ", STR_PAD_RIGHT);

//21
$nom_depart = '';
$nom_depart = str_pad($nom_depart, 35, " ", STR_PAD_RIGHT);

//22
$tel_empresa = $tel_empresa;
$tel_empresa = str_pad($tel_empresa, 35, " ", STR_PAD_RIGHT);

//24
$fax_empresa = $fax_empresa;
$fax_empresa = str_pad($fax_empresa, 35, " ", STR_PAD_RIGHT);

//25
$iban_empresa = $iban_empresa;
$iban_empresa = str_pad($iban_empresa, 35, " ", STR_PAD_RIGHT);

//26
$reg_merc = '';
$reg_merc = str_pad($reg_merc, 70, " ", STR_PAD_RIGHT);

//27
$cap_social = '';
$cap_social = str_pad($cap_social, 35, " ", STR_PAD_RIGHT);

//28
$calif = '';
$calif = str_pad($calif, 3, " ", STR_PAD_RIGHT);

//29
$ref_adic = '';
$ref_adic = str_pad($ref_adic, 35, " ", STR_PAD_RIGHT);


$sincp=$tipo_registro_p.$califica_inter.$codigo_inter.$tipo_inter.$nombre_inter.$nombre2.$nombre3.$nombre4.$nombre5.$direcc1.$direcc2.$direcc3.$direcc4.$ciudad_empresa.$provinc_empresa.$cp_empresa.$cod_pais.$id_fiscal_empresa.$cod_adic.$func_contact.$cod_depart.$nom_depart.$tel_empresa.$fax_empresa.$iban_empresa.$reg_merc.$cap_social.$calif.$ref_adic."\n";

$cadena.=$sincp;

/*
echo "$sincp";
exit();
*/
//fputs($file, $sincp) or die("NO");


/**************REGISTRO DE CABECERA DE FACTURA SINCP- DP (PUNTO DESTINO DE MERCANCIA)********************/
/************************************ DATOS DE BON PREU ************************************************/

//SACAMOS DATOS DE EMPRESA CLIENTE:
$codigo_cli = sel_campo("cod_cliente","","facturas","cod_factura='".$rem[$i]."'");

$nombre_cliente = sel_campo("nombre_cliente","","clientes","cod_cliente='$codigo_cli'");
$domicilio = sel_campo("domicilio","","clientes","cod_cliente='$codigo_cli'");
$poblacion = sel_campo("poblacion","","clientes","cod_cliente='$codigo_cli'");
$provincia = sel_campo("provincia","","clientes","cod_cliente='$codigo_cli'");
$c_postal = sel_campo("c_postal","","clientes","cod_cliente='$codigo_cli'");
$id_fiscal_cli = sel_campo("nif_cif","","clientes","cod_cliente='$codigo_cli'");
$telefono = sel_campo("telefono","","clientes","cod_cliente='$codigo_cli'");
$fax = sel_campo("fax","","clientes","cod_cliente='$codigo_cli'");
$iban = sel_campo("num_cuenta","","clientes","cod_cliente='$codigo_cli'");

$ini=1;

//1
$tipo_registro_p_dp = 'SINCP';
$tipo_registro_p_dp = str_pad($tipo_registro_p_dp, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_registro_p_dp);

//2 QUIEN FACTURA:
$califica_inter = 'DP';
$califica_inter = str_pad($califica_inter, 3, " ", STR_PAD_RIGHT);

$ini+=strlen($califica_inter);

//SACAMOS DATOS DE EMPRESA SEGU:
$codigo_em = sel_campo("cod_empresa","","facturas","cod_factura='".$rem[$i]."'");

$cod_albaran = sel_campo("cod_albaran","","albaranes","cod_factura='".$rem[$i]."'");

$cod_descarga = sel_campo("cod_descarga","","albaranes","cod_albaran='".$cod_albaran."'");
$gln_destino = sel_campo("gln","","descargas","cod_descarga='".$cod_descarga."'");

//3 CODIGO INTERLOCUTOR: NO SE CUAL ES:
$codigo_inter = $gln_destino; // codigo que identifica el punto destino
$codigo_inter = str_pad($codigo_inter, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($codigo_inter);

//4
$tipo_inter = '9';
$tipo_inter = str_pad($tipo_inter, 3, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_inter);


//5
$nombre_inter = $nombre_cliente;
$nombre_inter = str_pad($nombre_inter, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre_inter);

//6
$nombre2 = '';
$nombre2 = str_pad($nombre2, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre2);

//7
$nombre3 = '';
$nombre3 = str_pad($nombre3, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre3);

//8
$nombre4 = '';
$nombre4 = str_pad($nombre4, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre4);

//9
$nombre5 = '';
$nombre5 = str_pad($nombre5, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre5);

//10
$direcc1 = $domicilio;
$direcc1 = str_pad($direcc1, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc1);

//11
$direcc2 = '';
$direcc2 = str_pad($direcc2, 35, " ", STR_PAD_RIGHT);

//12
$direcc3 = '';
$direcc3 = str_pad($direcc3, 35, " ", STR_PAD_RIGHT);

//13
$direcc4 = '';
$direcc4 = str_pad($direcc4, 35, " ", STR_PAD_RIGHT);

//14
$ciudad_empresa = $poblacion;
$ciudad_empresa = str_pad($ciudad_empresa, 35, " ", STR_PAD_RIGHT);

//15
$provinc_empresa = $provincia;
$provinc_empresa = str_pad($provinc_empresa, 9, " ", STR_PAD_RIGHT);

//16
$cp_empresa = $c_postal;
$cp_empresa = str_pad($cp_empresa, 9, " ", STR_PAD_RIGHT);

//17
$cod_pais = '';
$cod_pais = str_pad($cod_pais, 3, " ", STR_PAD_RIGHT);

//18
$id_fiscal_empresa = $id_fiscal_cli;
$id_fiscal_empresa = str_pad($id_fiscal_empresa, 35, " ", STR_PAD_RIGHT);

//19
$cod_adic = '';
$cod_adic = str_pad($cod_adic, 35, " ", STR_PAD_RIGHT);

//20
$func_contact = '';
$func_contact = str_pad($func_contact, 3, " ", STR_PAD_RIGHT);

//20
$cod_depart = '';
$cod_depart = str_pad($cod_depart, 17, " ", STR_PAD_RIGHT);

//21
$nom_depart = '';
$nom_depart = str_pad($nom_depart, 35, " ", STR_PAD_RIGHT);

//22
$tel_empresa = $telefono;
$tel_empresa = str_pad($tel_empresa, 35, " ", STR_PAD_RIGHT);

//24
$fax_empresa = $fax;
$fax_empresa = str_pad($fax_empresa, 35, " ", STR_PAD_RIGHT);

//25
$iban_empresa = $iban;
$iban_empresa = str_pad($iban_empresa, 35, " ", STR_PAD_RIGHT);

//26
$reg_merc = '';
$reg_merc = str_pad($reg_merc, 70, " ", STR_PAD_RIGHT);

//27
$cap_social = '';
$cap_social = str_pad($cap_social, 35, " ", STR_PAD_RIGHT);

//28
$calif = '';
$calif = str_pad($calif, 3, " ", STR_PAD_RIGHT);

//29
$ref_adic = '';
$ref_adic = str_pad($ref_adic, 35, " ", STR_PAD_RIGHT);




$sincp_dp=$tipo_registro_p_dp.$califica_inter.$codigo_inter.$tipo_inter.$nombre_inter.$nombre2.$nombre3.$nombre4.$nombre5.$direcc1.$direcc2.$direcc3.$direcc4.$ciudad_empresa.$provinc_empresa.$cp_empresa.$cod_pais.$id_fiscal_empresa.$cod_adic.$func_contact.$cod_depart.$nom_depart.$tel_empresa.$fax_empresa.$iban_empresa.$reg_merc.$cap_social.$calif.$ref_adic."\n";

$cadena.=$sincp_dp;

/*
echo "$sincp_dp";
exit();
*/

/**************************REGISTRO DE CABECERA DE FACTURA SINCP - BY (COMPRADOR)************************/
/************************************ DATOS DE BON PREU ************************************************/

//SACAMOS DATOS DE EMPRESA CLIENTE:
$codigo_cli = sel_campo("cod_cliente","","facturas","cod_factura='".$rem[$i]."'");

$nombre_cliente = sel_campo("nombre_cliente","","clientes","cod_cliente='$codigo_cli'");
$domicilio = sel_campo("domicilio","","clientes","cod_cliente='$codigo_cli'");
$poblacion = sel_campo("poblacion","","clientes","cod_cliente='$codigo_cli'");
$provincia = sel_campo("provincia","","clientes","cod_cliente='$codigo_cli'");
$c_postal = sel_campo("c_postal","","clientes","cod_cliente='$codigo_cli'");
$id_fiscal_cli = sel_campo("nif_cif","","clientes","cod_cliente='$codigo_cli'");
$telefono = sel_campo("telefono","","clientes","cod_cliente='$codigo_cli'");
$fax = sel_campo("fax","","clientes","cod_cliente='$codigo_cli'");
$iban = sel_campo("num_cuenta","","clientes","cod_cliente='$codigo_cli'");


//1
$tipo_registro_p_by = 'SINCP';
$tipo_registro_p_by = str_pad($tipo_registro_p_by, 6, " ", STR_PAD_RIGHT);

//2 QUIEN FACTURA:
$califica_inter = 'BY';
$califica_inter = str_pad($califica_inter, 3, " ", STR_PAD_RIGHT);


//SACAMOS DATOS DE EMPRESA SEGU:
$codigo_em = sel_campo("cod_empresa","","facturas","cod_factura='".$rem[$i]."'");


//3 CODIGO INTERLOCUTOR: NO SE CUAL ES:
$codigo_inter = '8422410000005'; // codigo que identifica al receptor
$codigo_inter = str_pad($codigo_inter, 17, " ", STR_PAD_RIGHT);

//4
$tipo_inter = '9';
$tipo_inter = str_pad($tipo_inter, 3, " ", STR_PAD_RIGHT);

//5
$nombre_inter = $nombre_cliente;
$nombre_inter = str_pad($nombre_inter, 35, " ", STR_PAD_RIGHT);

//6
$nombre2 = '';
$nombre2 = str_pad($nombre2, 35, " ", STR_PAD_RIGHT);

//7
$nombre3 = '';
$nombre3 = str_pad($nombre3, 35, " ", STR_PAD_RIGHT);

//8
$nombre4 = '';
$nombre4 = str_pad($nombre4, 35, " ", STR_PAD_RIGHT);

//9
$nombre5 = '';
$nombre5 = str_pad($nombre5, 35, " ", STR_PAD_RIGHT);

//10
$direcc1 = $domicilio;
$direcc1 = str_pad($direcc1, 35, " ", STR_PAD_RIGHT);

//11
$direcc2 = '';
$direcc2 = str_pad($direcc2, 35, " ", STR_PAD_RIGHT);

//12
$direcc3 = '';
$direcc3 = str_pad($direcc3, 35, " ", STR_PAD_RIGHT);

//13
$direcc4 = '';
$direcc4 = str_pad($direcc4, 35, " ", STR_PAD_RIGHT);

//14
$ciudad_empresa = $poblacion;
$ciudad_empresa = str_pad($ciudad_empresa, 35, " ", STR_PAD_RIGHT);

//15
$provinc_empresa = $provincia;
$provinc_empresa = str_pad($provinc_empresa, 9, " ", STR_PAD_RIGHT);

//16
$cp_empresa = $c_postal;
$cp_empresa = str_pad($cp_empresa, 9, " ", STR_PAD_RIGHT);

//17
$cod_pais = '';
$cod_pais = str_pad($cod_pais, 3, " ", STR_PAD_RIGHT);

//18
$id_fiscal_empresa = $id_fiscal_cli;
$id_fiscal_empresa = str_pad($id_fiscal_empresa, 35, " ", STR_PAD_RIGHT);

//19
$cod_adic = '';
$cod_adic = str_pad($cod_adic, 35, " ", STR_PAD_RIGHT);

//20
$func_contact = '';
$func_contact = str_pad($func_contact, 3, " ", STR_PAD_RIGHT);

//20
$cod_depart = '';
$cod_depart = str_pad($cod_depart, 17, " ", STR_PAD_RIGHT);

//21
$nom_depart = '';
$nom_depart = str_pad($nom_depart, 35, " ", STR_PAD_RIGHT);

//22
$tel_empresa = $telefono;
$tel_empresa = str_pad($tel_empresa, 35, " ", STR_PAD_RIGHT);

//24
$fax_empresa = $fax;
$fax_empresa = str_pad($fax_empresa, 35, " ", STR_PAD_RIGHT);

//25
$iban_empresa = $iban;
$iban_empresa = str_pad($iban_empresa, 35, " ", STR_PAD_RIGHT);

//26
$reg_merc = '';
$reg_merc = str_pad($reg_merc, 70, " ", STR_PAD_RIGHT);

//27
$cap_social = '';
$cap_social = str_pad($cap_social, 35, " ", STR_PAD_RIGHT);

//28
$calif = '';
$calif = str_pad($calif, 3, " ", STR_PAD_RIGHT);

//29
$ref_adic = '';
$ref_adic = str_pad($ref_adic, 35, " ", STR_PAD_RIGHT);


$sincp_by=$tipo_registro_p_by.$califica_inter.$codigo_inter.$tipo_inter.$nombre_inter.$nombre2.$nombre3.$nombre4.$nombre5.$direcc1.$direcc2.$direcc3.$direcc4.$ciudad_empresa.$provinc_empresa.$cp_empresa.$cod_pais.$id_fiscal_empresa.$cod_adic.$func_contact.$cod_depart.$nom_depart.$tel_empresa.$fax_empresa.$iban_empresa.$reg_merc.$cap_social.$calif.$ref_adic."\n";

$cadena.=$sincp_by;

/*
echo "$sincp_by";
exit();
*/

/****************************REGISTRO DE CABECERA DE FACTURA SINCP - PR (PAGADOR)************************/
/************************************ DATOS DE BON PREU ************************************************/

//SACAMOS DATOS DE EMPRESA CLIENTE:
$codigo_cli = sel_campo("cod_cliente","","facturas","cod_factura='".$rem[$i]."'");

$nombre_cliente = sel_campo("nombre_cliente","","clientes","cod_cliente='$codigo_cli'");
$domicilio = sel_campo("domicilio","","clientes","cod_cliente='$codigo_cli'");
$poblacion = sel_campo("poblacion","","clientes","cod_cliente='$codigo_cli'");
$provincia = sel_campo("provincia","","clientes","cod_cliente='$codigo_cli'");
$c_postal = sel_campo("c_postal","","clientes","cod_cliente='$codigo_cli'");
$id_fiscal_cli = sel_campo("nif_cif","","clientes","cod_cliente='$codigo_cli'");
$telefono = sel_campo("telefono","","clientes","cod_cliente='$codigo_cli'");
$fax = sel_campo("fax","","clientes","cod_cliente='$codigo_cli'");
$iban = sel_campo("num_cuenta","","clientes","cod_cliente='$codigo_cli'");



//1
$tipo_registro_p_pr = 'SINCP';
$tipo_registro_p_pr = str_pad($tipo_registro_p_pr, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_registro_p_pr);

//2 QUIEN FACTURA:
$califica_inter = 'PR';
$califica_inter = str_pad($califica_inter, 3, " ", STR_PAD_RIGHT);

$ini+=strlen($califica_inter);

//SACAMOS DATOS DE EMPRESA SEGU:
$codigo_em = sel_campo("cod_empresa","","facturas","cod_factura='".$rem[$i]."'");


//3 CODIGO INTERLOCUTOR: NO SE CUAL ES:
$codigo_inter = '8422410000005'; // codigo que identifica al receptor
$codigo_inter = str_pad($codigo_inter, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($codigo_inter);

//4
$tipo_inter = '9';
$tipo_inter = str_pad($tipo_inter, 3, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_inter);

//5
$nombre_inter = $nombre_cliente;
$nombre_inter = str_pad($nombre_inter, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre_inter);

//6
$nombre2 = '';
$nombre2 = str_pad($nombre2, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre2);

//7
$nombre3 = '';
$nombre3 = str_pad($nombre3, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre3);

//8
$nombre4 = '';
$nombre4 = str_pad($nombre4, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre4);

//9
$nombre5 = '';
$nombre5 = str_pad($nombre5, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre5);

//10
$direcc1 = $domicilio;
$direcc1 = str_pad($direcc1, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc1);

//11
$direcc2 = '';
$direcc2 = str_pad($direcc2, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc2);

//12
$direcc3 = '';
$direcc3 = str_pad($direcc3, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc3);

//13
$direcc4 = '';
$direcc4 = str_pad($direcc4, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc4);

//14
$ciudad_empresa = $poblacion;
$ciudad_empresa = str_pad($ciudad_empresa, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($ciudad_empresa);

//15
$provinc_empresa = $provincia;
$provinc_empresa = str_pad($provinc_empresa, 9, " ", STR_PAD_RIGHT);

$ini+=strlen($provinc_empresa);

/*
echo $ini;
exit();
*/

//16
$cp_empresa = $c_postal;
$cp_empresa = str_pad($cp_empresa, 9, " ", STR_PAD_RIGHT);

//17
$cod_pais = '';
$cod_pais = str_pad($cod_pais, 3, " ", STR_PAD_RIGHT);

//18
$id_fiscal_empresa = $id_fiscal_cli;
$id_fiscal_empresa = str_pad($id_fiscal_empresa, 35, " ", STR_PAD_RIGHT);

//19
$cod_adic = '';
$cod_adic = str_pad($cod_adic, 35, " ", STR_PAD_RIGHT);

//20
$func_contact = '';
$func_contact = str_pad($func_contact, 3, " ", STR_PAD_RIGHT);

//20
$cod_depart = '';
$cod_depart = str_pad($cod_depart, 17, " ", STR_PAD_RIGHT);

//21
$nom_depart = '';
$nom_depart = str_pad($nom_depart, 35, " ", STR_PAD_RIGHT);

//22
$tel_empresa = $telefono;
$tel_empresa = str_pad($tel_empresa, 35, " ", STR_PAD_RIGHT);

//24
$fax_empresa = $fax;
$fax_empresa = str_pad($fax_empresa, 35, " ", STR_PAD_RIGHT);

//25
$iban_empresa = $iban;
$iban_empresa = str_pad($iban_empresa, 35, " ", STR_PAD_RIGHT);

//26
$reg_merc = '';
$reg_merc = str_pad($reg_merc, 70, " ", STR_PAD_RIGHT);

//27
$cap_social = '';
$cap_social = str_pad($cap_social, 35, " ", STR_PAD_RIGHT);

//28
$calif = '';
$calif = str_pad($calif, 3, " ", STR_PAD_RIGHT);

//29
$ref_adic = '';
$ref_adic = str_pad($ref_adic, 35, " ", STR_PAD_RIGHT);


$sincp_pr=$tipo_registro_p_pr.$califica_inter.$codigo_inter.$tipo_inter.$nombre_inter.$nombre2.$nombre3.$nombre4.$nombre5.$direcc1.$direcc2.$direcc3.$direcc4.$ciudad_empresa.$provinc_empresa.$cp_empresa.$cod_pais.$id_fiscal_empresa.$cod_adic.$func_contact.$cod_depart.$nom_depart.$tel_empresa.$fax_empresa.$iban_empresa.$reg_merc.$cap_social.$calif.$ref_adic."\n";

$cadena.=$sincp_pr;

/*
echo "$sincp_pr";
exit();
*/

/**************REGISTRO DE CABECERA DE FACTURA SINCP- IV (A QUIEN SE FACTURA)********************/
/************************************ DATOS DE BON PREU ************************************************/

$ini=1;

//1
$tipo_registro_p = 'SINCP';
$tipo_registro_p = str_pad($tipo_registro_p, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_registro_p);

//2 A QUIEN FACTURAMOS:
$califica_inter = 'IV';
$califica_inter = str_pad($califica_inter, 3, " ", STR_PAD_RIGHT);

$ini+=strlen($califica_inter);


//SACAMOS DATOS DE EMPRESA CLIENTE:
$codigo_cli = sel_campo("cod_cliente","","facturas","cod_factura='".$rem[$i]."'");

$nombre_cliente = sel_campo("nombre_cliente","","clientes","cod_cliente='$codigo_cli'");
$domicilio = sel_campo("domicilio","","clientes","cod_cliente='$codigo_cli'");
$poblacion = sel_campo("poblacion","","clientes","cod_cliente='$codigo_cli'");
$provincia = sel_campo("provincia","","clientes","cod_cliente='$codigo_cli'");
$c_postal = sel_campo("c_postal","","clientes","cod_cliente='$codigo_cli'");
$id_fiscal_cli = sel_campo("nif_cif","","clientes","cod_cliente='$codigo_cli'");
$telefono = sel_campo("telefono","","clientes","cod_cliente='$codigo_cli'");
$fax = sel_campo("fax","","clientes","cod_cliente='$codigo_cli'");
$iban = sel_campo("num_cuenta","","clientes","cod_cliente='$codigo_cli'");


//3 CODIGO INTERLOCUTOR: NO SE CUAL ES:
$codigo_inter = '8422410000005'; // codigo que identifica al receptor
$codigo_inter = str_pad($codigo_inter, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($codigo_inter);

//4
$tipo_inter = '9';
$tipo_inter = str_pad($tipo_inter, 3, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_inter);

//5
$nombre_inter = $nombre_cliente;
$nombre_inter = str_pad($nombre_inter, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre_inter);

//6
$nombre2 = '';
$nombre2 = str_pad($nombre2, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre2);

//7
$nombre3 = '';
$nombre3 = str_pad($nombre3, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre3);

//8
$nombre4 = '';
$nombre4 = str_pad($nombre4, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre4);

//9
$nombre5 = '';
$nombre5 = str_pad($nombre5, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($nombre5);

//10
$direcc1 = $domicilio;
$direcc1 = str_pad($direcc1, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc1);

//11
$direcc2 = '';
$direcc2 = str_pad($direcc2, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc2);

//12
$direcc3 = '';
$direcc3 = str_pad($direcc3, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc3);

//13
$direcc4 = '';
$direcc4 = str_pad($direcc4, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($direcc4);

//14
$ciudad_empresa = $poblacion;
$ciudad_empresa = str_pad($ciudad_empresa, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($ciudad_empresa);

//15
$provinc_empresa = $provincia;
$provinc_empresa = str_pad($provinc_empresa, 9, " ", STR_PAD_RIGHT);

$ini+=strlen($provinc_empresa);

/*
echo $ini;
exit();
*/
//16
$cp_empresa = $c_postal;
$cp_empresa = str_pad($cp_empresa, 9, " ", STR_PAD_RIGHT);

//17
$cod_pais = '';
$cod_pais = str_pad($cod_pais, 3, " ", STR_PAD_RIGHT);

//18
$id_fiscal_empresa = $id_fiscal_cli;
$id_fiscal_empresa = str_pad($id_fiscal_empresa, 35, " ", STR_PAD_RIGHT);

//19
$cod_adic = '';
$cod_adic = str_pad($cod_adic, 35, " ", STR_PAD_RIGHT);

//20
$func_contact = '';
$func_contact = str_pad($func_contact, 3, " ", STR_PAD_RIGHT);

//20
$cod_depart = '';
$cod_depart = str_pad($cod_depart, 17, " ", STR_PAD_RIGHT);

//21
$nom_depart = '';
$nom_depart = str_pad($nom_depart, 35, " ", STR_PAD_RIGHT);

//22
$tel_empresa = $telefono;
$tel_empresa = str_pad($tel_empresa, 35, " ", STR_PAD_RIGHT);

//24
$fax_empresa = $fax;
$fax_empresa = str_pad($fax_empresa, 35, " ", STR_PAD_RIGHT);

//25
$iban_empresa = $iban;
$iban_empresa = str_pad($iban_empresa, 35, " ", STR_PAD_RIGHT);

//26
$reg_merc = '';
$reg_merc = str_pad($reg_merc, 70, " ", STR_PAD_RIGHT);

//27
$cap_social = '';
$cap_social = str_pad($cap_social, 35, " ", STR_PAD_RIGHT);

//28
$calif = '';
$calif = str_pad($calif, 3, " ", STR_PAD_RIGHT);

//29
$ref_adic = '';
$ref_adic = str_pad($ref_adic, 35, " ", STR_PAD_RIGHT);


$sincp2=$tipo_registro_p.$califica_inter.$codigo_inter.$tipo_inter.$nombre_inter.$nombre2.$nombre3.$nombre4.$nombre5.$direcc1.$direcc2.$direcc3.$direcc4.$ciudad_empresa.$provinc_empresa.$cp_empresa.$cod_pais.$id_fiscal_empresa.$cod_adic.$func_contact.$cod_depart.$nom_depart.$tel_empresa.$fax_empresa.$iban_empresa.$reg_merc.$cap_social.$calif.$ref_adic."\n";

$cadena.=$sincp2;
//fputs($file, $sincp2) or die("NO");


/**************REGISTRO DE CABECERA DE FACTURA SINCL********************/

//1
$tipo_registro_l = 'SINCL';
$tipo_registro_l = str_pad($tipo_registro_l, 6, " ", STR_PAD_RIGHT);

$ini=1;
$ini+=strlen($tipo_registro_l);


//2:
$num_linea = '1';
$num_linea = str_pad($num_linea, 6, "0", STR_PAD_LEFT);

$ini+=strlen($num_linea);


//SACAMOS DATOS DE LA FACTURA:
$codigo_fact = sel_campo("cod_factura","","facturas","cod_factura='".$rem[$i]."'");

//3:
$codi_art = sel_campo("cod_descarga","","albaranes","cod_factura='".$rem[$i]."'");
$codigo_art = str_pad($codi_art, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($codigo_art);

//4:
$desc_arti = sel_campo("poblacion","","descargas","cod_descarga='$codi_art'");
$desc_art = substr($desc_arti,0,35);
$desc_art = str_pad($desc_art, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($desc_art);

//5:
$tipo_art='S';
$tipo_art = str_pad($tipo_art, 1, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_art);


//6:
$cod_int_sa='';
$cod_int_sa = str_pad($cod_int_sa, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_int_sa);


//7:
$cod_int_in='';
$cod_int_in = str_pad($cod_int_in, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_int_in);

//8:
$cod_pv='';
$cod_pv = str_pad($cod_pv, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_pv);


//9:
$cod_en='';
$cod_en = str_pad($cod_en, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_en);


//10:
$num_lote='';
$num_lote = str_pad($num_lote, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($num_lote);

//11:
$cantidad_fact = sel_campo("suma_servidos","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $cantidad_fact);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$cantidad_fact = $entero_new.'.'.$decimal_new;

$ini+=strlen($cantidad_fact);


//12:
$cant_bonif='000000000000.000';  //12,3
list($entero, $decimal) = explode(".", $cant_bonif);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_LEFT);
$cant_bonif = $entero_new.'.'.$decimal_new;

$ini+=strlen($cant_bonif);

/*
echo strlen($cant_bonif);
echo "<br/>$cant_bonif";
exit();
*/

//13:
$un_med='';
$un_med = str_pad($un_med, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($un_med);

//14:
$un_ent = $cantidad_fact;  //12,3

$ini+=strlen($un_ent);

//15:
$un_cons='000000000000.000';  //12,3
list($entero, $decimal) = explode(".", $un_cons);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_LEFT);
$un_cons = $entero_new.'.'.$decimal_new;

$ini+=strlen($un_cons);

/*
echo strlen($un_cons);
echo "<br/>$un_cons";
exit();
*/

//16:
$imp_neto = sel_campo("suma_servidos","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $imp_neto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_neto = $entero_new.'.'.$decimal_new;

$ini+=strlen($imp_neto);

/*
echo "$imp_neto";
exit();
*/

//17:
$prec_bruto = sel_campo("precio_cli","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $prec_bruto);
$entero_new = str_pad($entero, 11, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 4, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$prec_bruto = $entero_new.'.'.$decimal_new;

$ini+=strlen($prec_bruto);

//18:
$precio_neto = sel_campo("precio_cli","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $precio_neto);
$entero_new = str_pad($entero, 11, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 4, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$precio_neto = $entero_new.'.'.$decimal_new;

/*
echo "$imp_neto";
echo "$precio_neto";
echo "$prec_bruto";
exit();*/

$ini+=strlen($precio_neto);

//19:
$un_med_prod='';
$un_med_prod = str_pad($un_med_prod, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($un_med_prod);

//20:
$calific_iva='VAT';
$calific_iva = str_pad($calific_iva, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($calific_iva);

//21:
$tipo_iva = sel_campo("tipo_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $tipo_iva);
$entero_new = str_pad($entero, 3, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 2, "0", STR_PAD_LEFT);
$tipo_iva = $entero_new.'.'.$decimal_new;

$ini+=strlen($tipo_iva);

//22:
$imp_iva = sel_campo("fac_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $imp_iva);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_iva = $entero_new.'.'.$decimal_new;

$ini+=strlen($imp_iva);

//23:
$rec_equiv='000.00';

$ini+=strlen($rec_equiv);

//24:
$imp_rec_equiv='00000000000000.000';

$ini+=strlen($imp_rec_equiv);

//25:
$calif_otro='';
$calif_otro = str_pad($calif_otro, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($calif_otro);


//26:
$otro_imp='000.00';

$ini+=strlen($otro_imp);

//27:
$imp_otro_imp='00000000000000.000';

$ini+=strlen($imp_otro_imp);

//28:
$num_ped = '';
$num_ped = str_pad($num_ped, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_ped);

//29:
$num_alb = '';
$num_alb = str_pad($num_alb, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_alb);

//30:
$num_emb = '';
$num_emb = str_pad($num_emb, 8, "0", STR_PAD_LEFT);

$ini+=strlen($num_emb);

//31:
$tipo_emb = '';
$tipo_emb = str_pad($tipo_emb, 7, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_emb);

//32:
$total_servidos = $precio_neto * $cantidad_fact;
$imp_bruto = redondear($total_servidos);

list($entero, $decimal) = explode(".", $imp_bruto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_bruto = $entero_new.'.'.$decimal_new;
$imp_neto=$imp_bruto; // Igualamos el campo 16 y 32

/*
echo "PREC_NETO: $precio_neto<br/>";
echo "CANT: $cantidad_fact<br/>";
echo "imp_bruto: $imp_bruto<br/>";
echo "imp_neto: $imp_neto<br/>";
exit();
*/

$ini+=strlen($imp_bruto);

//33:
$num_line_sup='000000';

$ini+=strlen($num_line_sup);

//34:
$num_line_ped='000000';

$ini+=strlen($num_line_ped);

//35:
$uni_base_ped='000000.000';

$ini+=strlen($uni_base_ped);

//36:
$id_prod='';
$id_prod = str_pad($id_prod, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($id_prod);

//37:
$cat_prod='';
$cat_prod = str_pad($cat_prod, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cat_prod);

//38:
$num_art_fab='';
$num_art_fab = str_pad($num_art_fab, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($num_art_fab);

//39:
$num_conf_ent='';
$num_conf_ent = str_pad($num_conf_ent, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_conf_ent);

//40:
$num_lin_conf_ent='000000';

$ini+=strlen($num_lin_conf_ent);
/*

$cnt=strlen($num_lin_conf_ent);
echo $cnt;
echo "<br/>";
echo $ini;
exit();*/

/*
echo "<br/>tipo_registro_l: $tipo_registro_l";
echo "<br/>codigo_fact: $codigo_fact";
echo "<br/>codigo_art: $codigo_art";
echo "<br/>desc_art: $desc_art";
echo "<br/>num_linea: $num_linea";
echo "<br/>cantidad_fact: $cantidad_fact";
echo "<br/>prec_bruto: $prec_bruto";
echo "<br/>precio_neto: $precio_neto";
echo "<br/>imp_bruto: $imp_bruto";
echo "<br/>num_line_sup: $num_line_sup";
echo "<br/>imp_iva: $imp_iva";
exit();
*/	

$sincl=$tipo_registro_l.$num_linea.$codigo_art.$desc_art.$tipo_art.$cod_int_sa.$cod_int_in.$cod_pv.$cod_en.$num_lote.$cantidad_fact.$cant_bonif.$un_med.$un_ent.$un_cons.$imp_neto.$prec_bruto.$precio_neto.$un_med_prod.$calific_iva.$tipo_iva.$imp_iva.$rec_equiv.$imp_rec_equiv.$calif_otro.$otro_imp.$imp_otro_imp.$num_ped.$num_alb.$num_emb.$tipo_emb.$imp_bruto.$num_line_sup.$num_line_ped.$uni_base_ped.$id_prod.$cat_prod.$num_art_fab.$num_conf_ent.$num_lin_conf_ent.$num_art_fab.$num_conf_ent.$num_lin_conf_ent."\n";
/*
echo "$sincl<br/>";
echo strlen($sincl);
exit();
*/
$cadena.=$sincl;




//SACAMOS SI LA FACTURA ES DOBLE DESCARGA O NO:
$doble_desc = sel_campo("prec_doble_desc_cli","","albaranes","cod_factura='".$rem[$i]."'");

// si hay doble descarga añadimos linea:
if($doble_desc!=0)
{

//1
$tipo_registro_l = 'SINCL';
$tipo_registro_l = str_pad($tipo_registro_l, 6, " ", STR_PAD_RIGHT);

$ini=1;
$ini+=strlen($tipo_registro_l);


//2:
$num_linea = '2';
$num_linea = str_pad($num_linea, 6, "0", STR_PAD_LEFT);

$ini+=strlen($num_linea);


//SACAMOS DATOS DE LA FACTURA:
$codigo_fact = sel_campo("cod_factura","","facturas","cod_factura='".$rem[$i]."'");

//3:
$codi_art = sel_campo("cod_descarga","","albaranes","cod_factura='".$rem[$i]."'");
$codigo_art = str_pad($codi_art, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($codigo_art);

//4:
$desc_arti = 'DOBLE DESCÀRREGA';
$desc_art = substr($desc_arti,0,35);
$desc_art = str_pad($desc_art, 35, " ", STR_PAD_RIGHT);


$ini+=strlen($desc_art);

//5:
$tipo_art='S';
$tipo_art = str_pad($tipo_art, 1, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_art);


//6:
$cod_int_sa='';
$cod_int_sa = str_pad($cod_int_sa, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_int_sa);


//7:
$cod_int_in='';
$cod_int_in = str_pad($cod_int_in, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_int_in);

//8:
$cod_pv='';
$cod_pv = str_pad($cod_pv, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_pv);


//9:
$cod_en='';
$cod_en = str_pad($cod_en, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_en);


//10:
$num_lote='';
$num_lote = str_pad($num_lote, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($num_lote);

//11:
$cantidad_fact = '1';

list($entero, $decimal) = explode(".", $cantidad_fact);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$cantidad_fact = $entero_new.'.'.$decimal_new;

$ini+=strlen($cantidad_fact);


//12:
$cant_bonif='000000000000.000';  //12,3
list($entero, $decimal) = explode(".", $cant_bonif);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_LEFT);
$cant_bonif = $entero_new.'.'.$decimal_new;

$ini+=strlen($cant_bonif);

/*
echo strlen($cant_bonif);
echo "<br/>$cant_bonif";
exit();
*/

//13:
$un_med='';
$un_med = str_pad($un_med, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($un_med);

//14:
$un_ent = $cantidad_fact;  //12,3

$ini+=strlen($un_ent);

//15:
$un_cons='000000000000.000';  //12,3
list($entero, $decimal) = explode(".", $un_cons);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_LEFT);
$un_cons = $entero_new.'.'.$decimal_new;

$ini+=strlen($un_cons);

/*
echo strlen($un_cons);
echo "<br/>$un_cons";
exit();
*/

//16:
$imp_neto = '1';

list($entero, $decimal) = explode(".", $imp_neto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_neto = $entero_new.'.'.$decimal_new;

$ini+=strlen($imp_neto);

/*
echo "SUMA: $imp_neto";
exit();
*/

//17:
$prec_bruto = sel_campo("prec_doble_desc_cli","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $prec_bruto);
$entero_new = str_pad($entero, 11, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 4, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$prec_bruto = $entero_new.'.'.$decimal_new;

$ini+=strlen($prec_bruto);

/*
echo "prec_bruto: $prec_bruto";
exit();*/


//18:
$precio_neto = sel_campo("prec_doble_desc_cli","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $precio_neto);
$entero_new = str_pad($entero, 11, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 4, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$precio_neto = $entero_new.'.'.$decimal_new;

/*
echo "$imp_neto";
echo "$precio_neto";
echo "$prec_bruto";
exit();*/

$ini+=strlen($precio_neto);

//19:
$un_med_prod='';
$un_med_prod = str_pad($un_med_prod, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($un_med_prod);

//20:
$calific_iva='VAT';
$calific_iva = str_pad($calific_iva, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($calific_iva);

//21:
$tipo_iva = sel_campo("tipo_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $tipo_iva);
$entero_new = str_pad($entero, 3, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 2, "0", STR_PAD_LEFT);
$tipo_iva = $entero_new.'.'.$decimal_new;

$ini+=strlen($tipo_iva);

//22:
$imp_iva = sel_campo("fac_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $imp_iva);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_iva = $entero_new.'.'.$decimal_new;

$ini+=strlen($imp_iva);

//23:
$rec_equiv='000.00';

$ini+=strlen($rec_equiv);

//24:
$imp_rec_equiv='00000000000000.000';

$ini+=strlen($imp_rec_equiv);

//25:
$calif_otro='';
$calif_otro = str_pad($calif_otro, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($calif_otro);


//26:
$otro_imp='000.00';

$ini+=strlen($otro_imp);

//27:
$imp_otro_imp='00000000000000.000';

$ini+=strlen($imp_otro_imp);

//28:
$num_ped = '';
$num_ped = str_pad($num_ped, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_ped);

//29:
$num_alb = '';
$num_alb = str_pad($num_alb, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_alb);

//30:
$num_emb = '';
$num_emb = str_pad($num_emb, 8, "0", STR_PAD_LEFT);

$ini+=strlen($num_emb);

//31:
$tipo_emb = '';
$tipo_emb = str_pad($tipo_emb, 7, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_emb);

//32:
$total_servidos = $precio_neto * $cantidad_fact;
$imp_bruto = redondear($total_servidos);

list($entero, $decimal) = explode(".", $imp_bruto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_bruto = $entero_new.'.'.$decimal_new;
$imp_neto=$imp_bruto; // Igualamos el campo 16 y 32

/*
echo "PREC_NETO: $precio_neto<br/>";
echo "CANT: $cantidad_fact<br/>";
echo "imp_bruto: $imp_bruto<br/>";
echo "imp_neto: $imp_neto<br/>";
exit();
*/

$ini+=strlen($imp_bruto);

//33:
$num_line_sup='000000';

$ini+=strlen($num_line_sup);

//34:
$num_line_ped='000000';

$ini+=strlen($num_line_ped);

//35:
$uni_base_ped='000000.000';

$ini+=strlen($uni_base_ped);

//36:
$id_prod='';
$id_prod = str_pad($id_prod, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($id_prod);

//37:
$cat_prod='';
$cat_prod = str_pad($cat_prod, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cat_prod);

//38:
$num_art_fab='';
$num_art_fab = str_pad($num_art_fab, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($num_art_fab);

//39:
$num_conf_ent='';
$num_conf_ent = str_pad($num_conf_ent, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_conf_ent);

//40:
$num_lin_conf_ent='000000';

$ini+=strlen($num_lin_conf_ent);
/*

$cnt=strlen($num_lin_conf_ent);
echo $cnt;
echo "<br/>";
echo $ini;
exit();*/

/*
echo "<br/>tipo_registro_l: $tipo_registro_l";
echo "<br/>codigo_fact: $codigo_fact";
echo "<br/>codigo_art: $codigo_art";
echo "<br/>desc_art: $desc_art";
echo "<br/>num_linea: $num_linea";
echo "<br/>cantidad_fact: $cantidad_fact";
echo "<br/>prec_bruto: $prec_bruto";
echo "<br/>precio_neto: $precio_neto";
echo "<br/>imp_bruto: $imp_bruto";
echo "<br/>num_line_sup: $num_line_sup";
echo "<br/>imp_iva: $imp_iva";
exit();
*/	

$sincl2=$tipo_registro_l.$num_linea.$codigo_art.$desc_art.$tipo_art.$cod_int_sa.$cod_int_in.$cod_pv.$cod_en.$num_lote.$cantidad_fact.$cant_bonif.$un_med.$un_ent.$un_cons.$imp_neto.$prec_bruto.$precio_neto.$un_med_prod.$calific_iva.$tipo_iva.$imp_iva.$rec_equiv.$imp_rec_equiv.$calif_otro.$otro_imp.$imp_otro_imp.$num_ped.$num_alb.$num_emb.$tipo_emb.$imp_bruto.$num_line_sup.$num_line_ped.$uni_base_ped.$id_prod.$cat_prod.$num_art_fab.$num_conf_ent.$num_lin_conf_ent.$num_art_fab.$num_conf_ent.$num_lin_conf_ent."\n";
/*
echo "$sincl2<br/>";
echo strlen($sincl);
exit();
*/
$cadena.=$sincl2;


}


//SACAMOS SI LA FACTURA TIENE HORAS DE ESPERA:
$horas_espera = sel_campo("horas_espera","","albaranes","cod_factura='".$rem[$i]."'");

// si hay horas_espera añadimos linea:
if($horas_espera!=0)
{

//1
$tipo_registro_l = 'SINCL';
$tipo_registro_l = str_pad($tipo_registro_l, 6, " ", STR_PAD_RIGHT);

$ini=1;
$ini+=strlen($tipo_registro_l);


//2:
$num_linea = $num_linea + 1;
$num_linea = str_pad($num_linea, 6, "0", STR_PAD_LEFT);

$ini+=strlen($num_linea);


//SACAMOS DATOS DE LA FACTURA:
$codigo_fact = sel_campo("cod_factura","","facturas","cod_factura='".$rem[$i]."'");

//3:
$codi_art = sel_campo("cod_descarga","","albaranes","cod_factura='".$rem[$i]."'");
$codigo_art = str_pad($codi_art, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($codigo_art);

//4:
$desc_arti = 'HORES ESPERA';
$desc_art = substr($desc_arti,0,35);
$desc_art = str_pad($desc_art, 35, " ", STR_PAD_RIGHT);


$ini+=strlen($desc_art);

//5:
$tipo_art='S';
$tipo_art = str_pad($tipo_art, 1, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_art);


//6:
$cod_int_sa='';
$cod_int_sa = str_pad($cod_int_sa, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_int_sa);


//7:
$cod_int_in='';
$cod_int_in = str_pad($cod_int_in, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_int_in);

//8:
$cod_pv='';
$cod_pv = str_pad($cod_pv, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_pv);


//9:
$cod_en='';
$cod_en = str_pad($cod_en, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cod_en);


//10:
$num_lote='';
$num_lote = str_pad($num_lote, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($num_lote);

//11:
$cantidad_fact = '1';

list($entero, $decimal) = explode(".", $cantidad_fact);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$cantidad_fact = $entero_new.'.'.$decimal_new;

$ini+=strlen($cantidad_fact);


//12:
$cant_bonif='000000000000.000';  //12,3
list($entero, $decimal) = explode(".", $cant_bonif);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_LEFT);
$cant_bonif = $entero_new.'.'.$decimal_new;

$ini+=strlen($cant_bonif);

/*
echo strlen($cant_bonif);
echo "<br/>$cant_bonif";
exit();
*/

//13:
$un_med='';
$un_med = str_pad($un_med, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($un_med);

//14:
$un_ent = $cantidad_fact;  //12,3

$ini+=strlen($un_ent);

//15:
$un_cons='000000000000.000';  //12,3
list($entero, $decimal) = explode(".", $un_cons);
$entero_new = str_pad($entero, 12, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_LEFT);
$un_cons = $entero_new.'.'.$decimal_new;

$ini+=strlen($un_cons);

/*
echo strlen($un_cons);
echo "<br/>$un_cons";
exit();
*/

//16:
$imp_neto = '1';

list($entero, $decimal) = explode(".", $imp_neto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_neto = $entero_new.'.'.$decimal_new;

$ini+=strlen($imp_neto);

/*
echo "SUMA: $imp_neto";
exit();
*/

//17:
$prec_bruto = sel_campo("prec_horas_espera","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $prec_bruto);
$entero_new = str_pad($entero, 11, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 4, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$prec_bruto = $entero_new.'.'.$decimal_new;

$ini+=strlen($prec_bruto);

/*
echo "prec_bruto: $prec_bruto";
exit();*/


//18:
$precio_neto = sel_campo("prec_horas_espera","","albaranes","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $precio_neto);
$entero_new = str_pad($entero, 11, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 4, "0", STR_PAD_RIGHT); //PQ SEGU HA GUARDADO EL NUM. A SU ROLLO, X ESO RELLENAMOS X LA DERECHA
$precio_neto = $entero_new.'.'.$decimal_new;

/*
echo "$imp_neto";
echo "$precio_neto";
echo "$prec_bruto";
exit();*/

$ini+=strlen($precio_neto);

//19:
$un_med_prod='';
$un_med_prod = str_pad($un_med_prod, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($un_med_prod);

//20:
$calific_iva='VAT';
$calific_iva = str_pad($calific_iva, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($calific_iva);

//21:
$tipo_iva = sel_campo("tipo_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $tipo_iva);
$entero_new = str_pad($entero, 3, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 2, "0", STR_PAD_LEFT);
$tipo_iva = $entero_new.'.'.$decimal_new;

$ini+=strlen($tipo_iva);

//22:
$imp_iva = sel_campo("fac_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $imp_iva);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_iva = $entero_new.'.'.$decimal_new;

$ini+=strlen($imp_iva);

//23:
$rec_equiv='000.00';

$ini+=strlen($rec_equiv);

//24:
$imp_rec_equiv='00000000000000.000';

$ini+=strlen($imp_rec_equiv);

//25:
$calif_otro='';
$calif_otro = str_pad($calif_otro, 6, " ", STR_PAD_RIGHT);

$ini+=strlen($calif_otro);


//26:
$otro_imp='000.00';

$ini+=strlen($otro_imp);

//27:
$imp_otro_imp='00000000000000.000';

$ini+=strlen($imp_otro_imp);

//28:
$num_ped = '';
$num_ped = str_pad($num_ped, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_ped);

//29:
$num_alb = '';
$num_alb = str_pad($num_alb, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_alb);

//30:
$num_emb = '';
$num_emb = str_pad($num_emb, 8, "0", STR_PAD_LEFT);

$ini+=strlen($num_emb);

//31:
$tipo_emb = '';
$tipo_emb = str_pad($tipo_emb, 7, " ", STR_PAD_RIGHT);

$ini+=strlen($tipo_emb);

//32:
$total_servidos = $precio_neto * $cantidad_fact;
$imp_bruto = redondear($total_servidos);

list($entero, $decimal) = explode(".", $imp_bruto);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$imp_bruto = $entero_new.'.'.$decimal_new;
$imp_neto=$imp_bruto; // Igualamos el campo 16 y 32

/*
echo "PREC_NETO: $precio_neto<br/>";
echo "CANT: $cantidad_fact<br/>";
echo "imp_bruto: $imp_bruto<br/>";
echo "imp_neto: $imp_neto<br/>";
exit();
*/

$ini+=strlen($imp_bruto);

//33:
$num_line_sup='000000';

$ini+=strlen($num_line_sup);

//34:
$num_line_ped='000000';

$ini+=strlen($num_line_ped);

//35:
$uni_base_ped='000000.000';

$ini+=strlen($uni_base_ped);

//36:
$id_prod='';
$id_prod = str_pad($id_prod, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($id_prod);

//37:
$cat_prod='';
$cat_prod = str_pad($cat_prod, 15, " ", STR_PAD_RIGHT);

$ini+=strlen($cat_prod);

//38:
$num_art_fab='';
$num_art_fab = str_pad($num_art_fab, 35, " ", STR_PAD_RIGHT);

$ini+=strlen($num_art_fab);

//39:
$num_conf_ent='';
$num_conf_ent = str_pad($num_conf_ent, 17, " ", STR_PAD_RIGHT);

$ini+=strlen($num_conf_ent);

//40:
$num_lin_conf_ent='000000';

$ini+=strlen($num_lin_conf_ent);
/*

$cnt=strlen($num_lin_conf_ent);
echo $cnt;
echo "<br/>";
echo $ini;
exit();*/

/*
echo "<br/>tipo_registro_l: $tipo_registro_l";
echo "<br/>codigo_fact: $codigo_fact";
echo "<br/>codigo_art: $codigo_art";
echo "<br/>desc_art: $desc_art";
echo "<br/>num_linea: $num_linea";
echo "<br/>cantidad_fact: $cantidad_fact";
echo "<br/>prec_bruto: $prec_bruto";
echo "<br/>precio_neto: $precio_neto";
echo "<br/>imp_bruto: $imp_bruto";
echo "<br/>num_line_sup: $num_line_sup";
echo "<br/>imp_iva: $imp_iva";
exit();
*/	

$sincl3=$tipo_registro_l.$num_linea.$codigo_art.$desc_art.$tipo_art.$cod_int_sa.$cod_int_in.$cod_pv.$cod_en.$num_lote.$cantidad_fact.$cant_bonif.$un_med.$un_ent.$un_cons.$imp_neto.$prec_bruto.$precio_neto.$un_med_prod.$calific_iva.$tipo_iva.$imp_iva.$rec_equiv.$imp_rec_equiv.$calif_otro.$otro_imp.$imp_otro_imp.$num_ped.$num_alb.$num_emb.$tipo_emb.$imp_bruto.$num_line_sup.$num_line_ped.$uni_base_ped.$id_prod.$cat_prod.$num_art_fab.$num_conf_ent.$num_lin_conf_ent.$num_art_fab.$num_conf_ent.$num_lin_conf_ent."\n";
/*
echo "$sincl2<br/>";
echo strlen($sincl);
exit();
*/
$cadena.=$sincl3;


}


/**************REGISTRO DE CABECERA DE FACTURA SINCI********************/

//1
$tipo_registro_i = 'SINCI';
$tipo_registro_i = str_pad($tipo_registro_i, 6, " ", STR_PAD_RIGHT);

//2:
$num_linea = '1';
$num_linea = str_pad($num_linea, 2, "0", STR_PAD_LEFT);

//3:
$tipo_imp = 'VAT';
$tipo_imp = str_pad($tipo_imp, 6, " ", STR_PAD_RIGHT);

//4:
$tipo_iva = sel_campo("tipo_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $tipo_iva);
$entero_new = str_pad($entero, 3, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 2, "0", STR_PAD_LEFT);
$tipo_iva = $entero_new.'.'.$decimal_new;

//5:
$importe_iva = sel_campo("fac_iva","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $importe_iva);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$importe_iva = $entero_new.'.'.$decimal_new;

//6:
$base_imp = sel_campo("fac_base","","facturas","cod_factura='$codigo_fact'");

list($entero, $decimal) = explode(".", $base_imp);
$entero_new = str_pad($entero, 14, "0", STR_PAD_LEFT);
$decimal_new = str_pad($decimal, 3, "0", STR_PAD_RIGHT);
$base_imp = $entero_new.'.'.$decimal_new;

/*
echo "base_imp: $base_imp";
echo "importe_iva: $importe_iva";
exit();
*/

$sinci=$tipo_registro_i.$num_linea.$tipo_imp.$tipo_iva.$importe_iva.$base_imp."\n";
$cadena.=$sinci;
/*
echo "$sinci";
exit();*/
//fputs($file, $sincp2) or die("NO");

//******************************************** FIN DE CAMPOS PARA ENVIAR A SERES:************************************************//


// Realizamos la consulta: 
$sql="UPDATE facturas SET estado = 't' WHERE cod_factura='".$rem[$i]."'";
$result=mysql_query($sql, $link) or die ("<br /> No se ha modificado: ".mysql_error()."<br /> $sql <br />");



$archivo_remoto = $num_fact.'.txt';

// CONEXION FTP Y SUBIDA DEL ARCHIVO:

/*
$cid = ftp_connect("connect.seresnet.com");
$resultado = ftp_login($cid, "trareftp","GU0Qvhwa");
*/	
// 2023
$cid = ssh2_connect('connect.seresnet.com', 2222);
$resultado = ssh2_auth_password($cid, 'trareftp', 'GU0Qvhwa');
	
	
if ((!$cid) || (!$resultado)) {
		echo "Fallo en la conexión"; die;
	} else {
		//echo "Conectado.";
	}
ftp_pasv ($cid, true) ;
	//echo "<br> Cambio a modo pasivo<br />";

ftp_chdir($cid, "envio");
ftp_chdir($cid, "invoicd93a");
	//echo "Cambiado al directorio necesario"; 

/*
echo "cad: $cadena";
exit();*/
file_put_contents($archivo_remoto,$cadena);

// upload the file
$upload = ftp_put($cid, $archivo_remoto, $archivo_remoto, FTP_BINARY);

// check upload status
/*
if (!$upload) {
       echo "El ENVIO DEL ARCHIVO HA FALLADO";
   } else {
       echo "ARCHIVO $archivo_remoto ENVIADO CORRECTAMENTE.";
   } 
*/


$ii++;
} // Fin de for


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
alert("<? echo $ii; ?> Factures Traspassades");
enlace(direccion_conta(''),'','','','','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos el script:
$cod_multa='';
exit();
}



// Realizamos la consulta: 

$sql="SELECT *
FROM facturas
WHERE cod_cliente='1592' and estado = ''";
/*
$sql="SELECT *
FROM `multas`
WHERE (fecha_multa <= '2014-01-25'
AND cod_enganche = '-'
and estado='v' and tipo_servicio='1')";

echo "$sql";
*/
$result=mysql_query($sql, $link) or die ("<br /> No se ha seleccionado: ".mysql_error()."<br /> $mostrar <br />");
$total_filas=mysql_num_rows($result);


if($total_filas==0)
{

echo $mens_no_full;
// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("<? //echo $mens_no_matr; ?>");
//top.location.href='/<? echo $carpeta; ?>/acceso/menu_i.php';
</script>
<?
exit();
}// Finalizamos script:
else
{
?>
<script type="text/javascript">
function enviar(event)
{
document.forms[0].submit();

} // Fin de function


function marcar_todos(event,accion)
{
var disp=obt_disp(event);
var e = document.getElementsByTagName('input');

var checked=false;
if (accion)
	checked=accion;
else if (disp.checked==true)
	checked=true;

for (var i=0; i < e.length; i++)
{
	if (e[i].type=='checkbox')
	{
	e[i].checked=checked;
	} // Fin de if
} // Fin de for

} // Fin de function

</script>
</head>

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color:#fff;
}
</style>
<link href="/igruapp/css/interfaz_conta.css" rel="stylesheet" type="text/css">
</head>

<body onKeyPress="tabular(event);">
<table width="915">
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="10" class="texto_blanco_titulo">Enviament a SERES</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
          </tr>
<?

// Realizamos la consulta: 
/**/
$sql="SELECT *
FROM facturas
WHERE cod_cliente='1592' AND estado!='t'";


/*$sql="SELECT *
FROM `multas`
WHERE (fecha_multa <= '2014-01-25'
AND cod_enganche = '-'
and estado='v' and tipo_servicio='1')";

// PROVISIONAL PARA TRASPASAR SOLO LAS QUE FALTAN:
$sql="select * from 
multas
WHERE fecha_multa <= '2014-01-10'
AND cod_enganche = '-'
AND hora <= '14:00' and estado='v' order by cod_multa";
*/
$c=sel_sql($sql);
$total_filas=count($c);

?>
          <tr>
            <td width="124" class="texto_blanco_peq"><input type="checkbox" onClick="marcar_todos(event)" />
            Marcar Totes&nbsp;</td>
            <td width="101" class="texto_blanco_peq">&nbsp;</td>
            <td width="94" class="texto_blanco_peq">&nbsp;</td>
            <td width="171" class="texto_blanco_peq"><input type="button" name="guardar" id="guardar" title="Guardar" value="Traspassar" onClick="enviar(event);" onMouseOver="window.top.focus();"></td>
            <td colspan="2" class="texto_blanco_peq">&nbsp;</td>
            <td width="106" class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq"><strong>Resultats:</strong></td>
            <td width="86" class="texto_blanco_peq"><? echo $total_filas; ?>&nbsp;</td>
            <td width="635" class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td colspan="2" class="texto_blanco_peq"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Factura</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Data</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Client</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td colspan="2" bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Import</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
    </tr>
          <tr>
    <?

$mat_mostrar=$total_filas;
$inicial=0;

for ($i=$inicial; $i < $mat_mostrar; $i++)
{
$cod_factura=$c[$i]["cod_factura"];
$cod_empresa=$c[$i]["cod_empresa"];
$fac_fecha=$c[$i]["fac_fecha"];
$cod_cliente=$c[$i]["cod_cliente"];
$nombre_cliente=$c[$i]["nombre_cliente"];
$fac_total=$c[$i]["fac_total"];
$origen=$c[$i]["origen"];
//$fecha_actual=sprintf("%04s-%02s-%02s", $h['year'],$h['mon'],$h['mday']);

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>

          <tr bgcolor="<? echo $color; ?>">
            <td class="texto_blanco_peq"><input type="checkbox" name="rem[]" value="<? echo $cod_factura; ?>" <? echo $checked; ?>><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/3_2_fac_alb_impr.php'), 'cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','cod_empresa','<? echo $cod_empresa; ?>','origen','<? echo $origen; ?>','','','','','','','','','','','','');"><? echo $cod_factura; ?></span></td>
            <td class="texto_blanco_peq"><? echo fecha_esp($fac_fecha); ?></td>
            <td class="texto_blanco_peq"><? echo $cod_cliente; ?></td>
            <td class="texto_blanco_peq"><? echo $nombre_cliente; ?></td>
            <td colspan="2" class="texto_blanco_peq"><? echo $fac_total; ?></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq"><span class="vinculo">
            <input name="cod_factura" title="Multa;" type="hidden" id="cod_factura" size="6" maxlength="6" value="<? echo $cod_factura; ?>">
            </span></td>
          </tr>
<?
} // Fin de for

} // Fin else
?>
</form>
</table>
</body>
</html>