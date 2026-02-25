<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Enviats</title>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--<meta HTTP-EQUIV="REFRESH" content="30">-->


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

conectar_segu($base_datos);


$select_ord="SELECT * FROM albaranes WHERE cod_albaran = '".$rem[$i]."' and descargado=''";
$query_ord=mysql_query($select_ord) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $select_ord <br />");
$existe_ord=mysql_num_rows($query_ord);
$ord=mysql_fetch_array($query_ord);

$cod_albaran=$ord["cod_albaran"];
$cod_empresa=$ord["cod_empresa"];
$estado=$ord["estado"];
$cod_factura=$ord["cod_factura"];
$fecha=fecha_esp($ord["fecha"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$tipo_iva=$ord["tipo_iva"];

$cod_descarga=$ord["cod_descarga"];

$poblacion=addslashes(sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'"));


$observ_descarga=$ord["observ_descarga"];
$horas_descarga=$ord["horas_descarga"];
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
$nombre_operadora=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");


$cod_operario=$ord["cod_operario"];
$cod_operario2=$ord["cod_operario2"];

if($cod_operario)
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

if($cod_operario2)
$nombre_op2=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario2'");

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



//$archivo_remoto = $num_fact.'.txt';


$sql="UPDATE albaranes SET enviado = 'si' WHERE cod_albaran='".$rem[$i]."'";
$result=mysql_query($sql, $link) or die ("<br /> No se ha modificado: ".mysql_error()."<br /> $sql <br />");


// CONEXION  Y ENVIO DEL ARCHIVO:
//conectar_segu_tablets(ttonline);
conectar_serv('46.16.62.77','ttonline','msr523228inf') or die("<br/>error conexion");
conectar_base(ttonline);


// comprobamos si ya existe el albaran o es uno nuevo
$albaranes="SELECT * FROM albaranes WHERE cod_albaran='".$rem[$i]."'and confirmado!='si'";
$result_ord=mysql_query($albaranes) or die ("No se han seleccionado : ".mysql_error()."<br /> $albaranes <br />");
$existe = mysql_num_rows($result_ord);

/*echo "<br/>ALB: $cod_albaran";
echo "<br/>emp: $cod_empresa";*/

$fecha=fecha_ing($fecha);
$fecha_carga=fecha_ing($fecha_carga);
$fecha_descarga=fecha_ing($fecha_descarga);

// Si existe enviamos las modificaciones
if($existe>0)
{

$poblacion=addslashes($poblacion);
//echo "$poblacion";

// MODIFICAMOS ALBARAN:
$modificar_ord="UPDATE albaranes SET

fecha='$fecha',
cod_cliente='$cod_cliente',
nombre_cliente='$nombre_cliente',
cod_descarga='$cod_descarga',
poblacion='$poblacion',
observ_descarga='$observ_descarga',
horas_descarga='$horas_descarga',
fecha_descarga='$fecha_descarga',
fecha_carga='$fecha_carga',
viaje='$viaje',
franja='$franja',
cod_tarjeta='$cod_tarjeta',
mat1='$mat1',
cod_tractora='$cod_tractora',
mat2='$mat2',
cod_terminal='$cod_terminal',
nombre_terminal='$nombre_terminal',
cod_operadora='$cod_operadora',
nombre_operadora='$nombre_operadora',
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

doble_descarga='$doble_descarga',

avisar_antes_cargar='$avisar_antes_cargar',
avisar_salir_cargado='$avisar_salir_cargado',
pedir_muestra='$pedir_muestra',

descarga_bomba='$descarga_bomba',
lts_desc_bomba='$lts_desc_bomba',  	

planos_id='$planos_id',

horas_espera='$horas_espera',
observ_horas_espera='$observ_horas_espera',
observaciones='$observaciones',
incidencias='$incidencias'

WHERE cod_albaran = '".$rem[$i]."' and cod_empresa = '$cod_empresa'";

/*echo "<br/>emp:$cod_empresa";
	echo "<br/>insertar_ord:$insertar_ord";/*
	exit();*/
	
	
$result_ord = mysql_query ($modificar_ord) or die ("<br /> No se ha actualizado orden: ".mysql_error()."<br /> $modificar_ord <br />");
}


$ii++;
} // Fin de for


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
alert("<? echo $ii; ?> Albarans Modificats-Traspassats");
enlace(direccion_conta(''),'','','','','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos el script:
exit();
}

$fecha_ini=fecha_ing($_GET["fecha_ini"]);
$fecha_fin=fecha_ing($_GET["fecha_fin"]);
$ver=$_GET["ver"];

if($ver=='CONFIRMATS')
	$confirmat="and descargado='si'";
else if ($ver=='PENDENTS')
	$confirmat="and descargado=''";
else
	$confirmat='';
// Realizamos la consulta: 

$sql="SELECT *
FROM albaranes
WHERE enviado = 'si' and fecha_carga>='$fecha_ini' and fecha_descarga<='$fecha_fin' $confirmat"; 
//echo $sql;

/*echo "<br/><br/>$sql";
echo "<br/><br/>$ver";
*/
$result=mysql_query($sql, $link) or die ("<br /> No se ha seleccionado: ".mysql_error()."<br /> $mostrar <br />");
$total_filas=mysql_num_rows($result);



?>
<script type="text/javascript">
function enviar(event)
{

/*
var cod_albaran = document.getElementById('cod_albaran').value;

if (cod_albaran)
	mensaje="Ha seleccionado albaranes que quedarán abiertos para volver a enviarlos\n\n¿Está seguro que desea continuar?";

	
if (confirm(mensaje))
*/
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
            <td colspan="9" class="texto_blanco_titulo"> Resum Albarans Enviats</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="6"><? 
if($total_filas==0)
{
echo "<BR/><BR/>NO HI HA ALBARANS ENVIATS AMB AQUESTES DADES.<BR/><BR/>";
exit();
}
?></td>
          </tr>
<?

// Realizamos la consulta: 
/**/
$sql="SELECT *
FROM albaranes
WHERE enviado = 'si' and fecha_carga>='$fecha_ini' and fecha_descarga<='$fecha_fin' $confirmat";

//echo $sql;

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
            Marcar Tots&nbsp;</td>
            <td width="101" class="texto_blanco_peq">&nbsp;</td>
            <td width="94" class="texto_blanco_peq">&nbsp;</td>
            <td width="171" class="texto_blanco_peq"><input type="button" name="guardar" id="guardar" title="Guardar" value="TORNAR A ENVIAR" onClick="enviar(event);" onMouseOver="window.top.focus();"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq"><strong>Resultats:</strong></td>
            <td width="86" class="texto_blanco_peq"><? echo $total_filas; ?>&nbsp;</td>
            <td width="635" class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Albar&agrave;</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Data</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Client</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Conductor</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Conductor</strong></td>
            <td colspan="2" bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Confirmat</strong></td>
    </tr>
    
 
 
     <?

$mat_mostrar=$total_filas;
$inicial=0;

for ($i=$inicial; $i < $mat_mostrar; $i++)
{
$cod_albaran=$c[$i]["cod_albaran"];

// comprobamos que no está confirmado

$cod_empresa=$c[$i]["cod_empresa"];
$fecha_carga=$c[$i]["fecha_carga"];
$fecha_descarga=$c[$i]["fecha_descarga"];
$cod_cliente=$c[$i]["cod_cliente"];
$nombre_cliente=$c[$i]["nombre_cliente"];
$cod_operario=$c[$i]["cod_operario"];

$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

$cod_operario2=$c[$i]["cod_operario2"];
$nombre_op2=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario2'");

$foto=$c[$i]["foto"];
//$fecha_actual=sprintf("%04s-%02s-%02s", $h['year'],$h['mon'],$h['mday']);

// CONEXION ON LINE PARA VER ESTADO ALBARAN:
conectar_segu_tablets(ttonline);
$confirmado=sel_campo("confirmado", "","albaranes","cod_albaran='$cod_albaran'");
$base=$carpeta."_".substr($usuario_any,-2);
conectar_segu($base);


// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td class="texto_blanco_peq"><? if($confirmado!='si'){?><input type="checkbox" name="rem[]" value="<? echo $cod_albaran; ?>" <? echo $checked; ?>><? } ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_albaran','<? echo $cod_albaran; ?>','','','cod_empresa','<? echo $cod_empresa; ?>','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></span> - <? if ($foto) { ?>
              &nbsp;<span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta.'/fotos/'.$usuario_any.'/'.$foto; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo $foto; } ?></span></td>
            <td class="texto_blanco_peq"><? echo fecha_esp($fecha_carga); ?></td>
            <td colspan="3" class="texto_blanco_peq"><? echo $cod_cliente; ?> <? echo $nombre_cliente; ?></td>
            <td class="texto_blanco_peq"><? echo $nombre_op; ?></td>
            <td class="texto_blanco_peq"><? echo $nombre_op2; ?></td>
            <td class="texto_blanco_peq"><? echo $confirmado; if($confirmado=='') echo "no"; ?></td>
            <td class="texto_blanco_peq"><span class="vinculo">
            <input name="cod_albaran" title="Multa;" type="hidden" id="cod_albaran" size="6" maxlength="6" value="<? echo $cod_albaran; ?>">
            </span></td>
          </tr>
          
<?
} // Fin de for

?>
<tr bgcolor="<? echo $color; ?>">
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td colspan="3" class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
</tr>
<tr bgcolor="<? echo $color; ?>">
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td colspan="3" class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq"><input name="buscar" type="button" value="Nueva B&uacute;squeda" onClick="location.href='03_00_albs_resumen.php'"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
    </tr>
</form>
</table>
</body>
</html>