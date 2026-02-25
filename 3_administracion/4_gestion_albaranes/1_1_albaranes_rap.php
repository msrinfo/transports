<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gesti&oacute; d'Albarans R&agrave;pid</title>
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
$cod_factura=$_POST["cod_factura"];
$fecha=fecha_ing($_POST["fecha"]);
$cod_cliente=$_POST["cod_cliente"];
$nombre_cliente=$_POST["nombre_cliente"];
$tipo_iva=$_POST["tipo_iva"];

$cod_descarga=$_POST["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
//$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
}

$fecha_descarga=fecha_ing($_POST["fecha_descarga"]);
$fecha_carga=fecha_ing($_POST["fecha_carga"]);
$viaje=$_POST["viaje"];
$franja=$_POST["franja"];

$cod_operadora=$_POST["cod_operadora"];

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");


$cant_blue=$_POST["cant_blue"];
$cant_sp95=$_POST["cant_sp95"];
$cant_sp98=$_POST["cant_sp98"];
$cant_go_a=$_POST["cant_go_a"];
$cant_go_a1=$_POST["cant_go_a1"];
$cant_go_b=$_POST["cant_go_b"];
$cant_go_c=$_POST["cant_go_c"];
$cant_bio=$_POST["cant_bio"];




// Si recibimos cod_empresa, continuamos:
if ($cod_empresa)
{
// Comprobamos si existe orden:
$comprobar_ord="SELECT estado FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";
$consultar_ord=mysql_query($comprobar_ord, $link) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $consultar_ord <br />");
$existe_ord=mysql_num_rows($consultar_ord);


/*if($doble_carga!=1){
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
}*/



$suma_pedidos= $cant_blue + $cant_sp95 + $cant_sp98 + $cant_go_a + $cant_go_a1 + $cant_go_b + $cant_go_c + $cant_bio;

/*
$suma_servidos = $serv_blue + $serv_sp95 + $serv_sp98 + $serv_go_a + $serv_go_a1 + $serv_go_b + $serv_go_c + $serv_bio;

$base=redondear( ($prec_desc_bomba_cli * $lts_desc_bomba) + ($suma_servidos * $precio_cli) + $prec_doble_carga_cli + $prec_doble_desc_cli);
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

// MODIFICAMOS ORDEN:
$modificar_ord="UPDATE albaranes SET

fecha='$fecha',
cod_cliente='$cod_cliente',
nombre_cliente='$nombre_cliente',
tipo_iva='$tipo_iva',
cod_descarga='$cod_descarga',
fecha_descarga='$fecha_descarga',
fecha_carga='$fecha_carga',
viaje='$viaje',
franja='$franja',
cod_operadora='$cod_operadora',

cant_blue='$cant_blue',
cant_sp95='$cant_sp95',
cant_sp98='$cant_sp98',
cant_go_a='$cant_go_a',
cant_go_a1='$cant_go_a1',
cant_go_b='$cant_go_b',
cant_go_c='$cant_go_c',
cant_bio='$cant_bio',
suma_pedidos='$suma_pedidos'

WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";

$result_ord = mysql_query ($modificar_ord, $link) or die ("<br /> No se ha actualizado orden: ".mysql_error()."<br /> $modificar_ord <br />");
} // Fin de if ($existe_ord==1)
	
else
{
$cod_albaran=obtener_max_con("cod_albaran","albaranes","cod_empresa = '$cod_empresa'")+ 1;

// INSERTAMOS ORDEN:
$insertar_ord="INSERT INTO albaranes
(cod_albaran,cod_empresa,fecha,cod_cliente,nombre_cliente,tipo_iva,cod_descarga,fecha_descarga,
fecha_carga,viaje,franja,cod_operadora,cod_operario, cant_blue,cant_sp95,cant_sp98,cant_go_a,
cant_go_a1,cant_go_b,cant_go_c,cant_bio, suma_pedidos)
VALUES ('$cod_albaran','$cod_empresa','$fecha','$cod_cliente','$nombre_cliente','$tipo_iva','$cod_descarga','$fecha_descarga','$fecha_carga','$viaje','$franja','$cod_operadora','99','$cant_blue','$cant_sp95','$cant_sp98','$cant_go_a','$cant_go_a1','$cant_go_b','$cant_go_c','$cant_bio', '$suma_pedidos')";

$result_ord = mysql_query ($insertar_ord, $link) or die ("<br /> No se ha insertado orden: ".mysql_error()."<br /> $insertar_ord <br />");


// Como es autoincremental, seleccionamos máximo:
//$cod_albaran=obtener_max_con("cod_albaran","albaranes","");
//$cod_albaran=obtener_max_con("cod_albaran","albaranes","cod_empresa = '$cod_empresa' and cod_albaran < 8000 ") + 1;
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
$estado=$ord["estado"];
$cod_factura=$ord["cod_factura"];
$fecha=fecha_esp($ord["fecha"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$tipo_iva=$ord["tipo_iva"];

$cod_descarga=$ord["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
}


$fecha_descarga=fecha_esp($ord["fecha_descarga"]);
$fecha_carga=fecha_esp($ord["fecha_carga"]);

$viaje=$ord["viaje"];
$franja=$ord["franja"];


$cod_terminal=$ord["cod_terminal"];

if($cod_terminal)
$nombre_terminal=sel_campo("nombre_terminal","","terminales","cod_terminal='$cod_terminal'");


$cod_operadora=$ord["cod_operadora"];

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");



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

// Obtenemos asiento correspondiente:
if ($estado=="f")
{
conectar_base($base_datos_conta);
$cod_asiento=sel_campo("cod_asiento","","asientos","cod_empresa = '$cod_empresa' and txt_predef = 'VE' and cod_factura = $cod_factura");
conectar_base($base_datos);
}
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
	alert("Seleccione orden y empresa antes de introducir operarios.");
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

enviar_alb_js(event,validado,estado,"1_2_impr_alb.php","1_1_fac_alb_crear.php");
} // Fin de function
//--------------------------------------------------------------------------------------------
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="albaranes" id="albaranes" method="post" action="">
          <tr class="titulo"> 
            <td colspan="14">Gesti&oacute; d'Albarans R&agrave;pid </td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td><div align="right">N&ordm; Albar&agrave;:</div></td>
            <td width="81"><input name="cod_albaran" title="Código Orden" type="text" id="cod_albaran" size="6" maxlength="6" value="<? echo "$cod_albaran"; ?>" onBlur="buscar_conta(event,'albaranes',cod_albaran.value,'cod_cliente',cod_cliente.value,'cod_albaran',cod_albaran.value,'cod_empresa',cod_empresa.value,'','','','','','','refrescar');" onMouseOut="this.blur()"> 
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_albaran');"></td>
            <td colspan="3">Empresa:
              <select name="cod_empresa" id="cod_empresa">
                <? mostrar_lista("empresas",$cod_empresa); ?>
              </select></td>
            <td width="71" align="right"><strong>
              <input name="fecha" type="hidden" id="fecha" value="<? echo $fecha; ?>" readonly class="readonly">
            </strong>            Viatge</td>
            <td colspan="3" align="left"><input name="viaje" title="Tipo IVA" type="text" id="viaje" size="2" maxlength="2" value="<? echo "$viaje"; ?>"></td>
            <td colspan="3" align="right"><? if ($cod_asiento) {echo "Asiento: "; ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_asiento;} ?></span></td>
            <td width="6">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">N&ordm; Client:</div></td>
            <td colspan="4"><input name="cod_cliente" title="Código Cliente" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo "$cod_cliente"; ?>" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'cod_albaran',cod_albaran.value,'','','','','','','','','refrescar');" onMouseOut="this.blur()" <? echo $readonly_final; ?>> 
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">              <input name="nombre_cliente" title="Nombre Cliente" type="text" id="nombre_cliente" size="40" maxlength="" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" readonly class="readonly"></td>
            <td align="right">IVA:</td>
            <td colspan="2"><input name="tipo_iva" type="text" readonly class="readonly" id="tipo_iva" title="tipo_iva"  value="<? echo "$tipo_iva"; ?>" size="2" maxlength="4"></td>
            <td colspan="4" align="right">
              <input name="estado" type="hidden" id="estado" value="<? echo $estado; ?>" readonly class="readonly">
            <strong>Estado:</strong> 
<? if ($estado!="f") {echo "No Facturado.";} else {echo "Factura: "; ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/3_2_fac_alb_impr.php'),'cod_empresa','<? echo $cod_empresa; ?>','cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','','','','','','','','','','','','','','');"><? echo sprintf("%06s", $cod_factura);} ?></span>
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">N&ordm; Desc&agrave;rrega:</td>
            <td colspan="4"><input name="cod_descarga" title="C&oacute;digo Descarga" type="text" id="cod_descarga" size="8" maxlength="7" value="<? echo "$cod_descarga"; ?>" onBlur="buscar_descarga_cli(event)" onMouseOut="this.blur()">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_descarga');">                   
			  <input name="poblacion" title="Poblacion" type="text" id="poblacion" size="40" maxlength="" value="<? echo a_html($poblacion,"bd->input"); ?>" readonly class="readonly"></td>
            <td align="right">Franja:</td>
            <td colspan="2"><input name="franja" title="Franja" type="text" id="franja" size="11" maxlength="10"  value="<? echo "$franja"; ?>"></td>
            <td colspan="4" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Operadora:</td>
            <td colspan="4"><input name="cod_operadora" title="C&oacute;digo Operadora" type="text" id="cod_operadora" size="2" maxlength="2" value="<? echo "$cod_operadora"; ?>" onBlur="buscar_conta(event,'operadoras',cod_operadora.value,'cod_operadora',cod_operadora.value,'','','','','','','','','','','');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operadora');"> <input name="descripcion" title="Descripci&oacute;n" type="text" id="descripcion" size="40" maxlength="40" value="<? echo a_html($descripcion,"bd->input"); ?>" readonly class="readonly"></td>
            <td align="right">&nbsp;</td>
            <td colspan="6">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Data C&agrave;rrega:</td>
            <td colspan="4"><input name="fecha_carga" title="Fecha Carga" type="text" id="fecha_carga" size="11" maxlength="10"  value="<? echo "$fecha_carga"; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','albaranes','fecha_carga')"></td>
            <td align="right">Data Desc&agrave;rrega:</td>
            <td colspan="6"><input name="fecha_descarga" title="Fecha Descarga" type="text" id="fecha_descarga" size="11" maxlength="10"  value="<? echo "$fecha_descarga"; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','albaranes','fecha_descarga')"></td>
            <td>&nbsp;</td>
          </tr>
          

          <tr>
            <td>&nbsp;</td>
            <td colspan="12"><hr /></td>
            <td></td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td align="right"><strong>Quantitats:</strong></td>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td width="58">&nbsp;</td>
            <td>&nbsp;</td>
			
			<? if($conectar_toma_terra==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td width="25">&nbsp;</td>
            <td width="41">&nbsp;</td>
            <td width="26">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr> 
            <td>&nbsp;</td>
            <td align="right">ADITIVAT:</td>
            <td><input name="cant_blue" title="ADITIVAT" type="text" id="cant_blue" size="8" maxlength="8" value="<? echo "$cant_blue"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<? if($treure_mostres==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="114" align="right">SP95:</td>
            <td><input name="cant_sp95" title="sp95" type="text" id="cant_sp95" size="8" maxlength="8" value="<? echo "$cant_sp95"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<? if($doble_carga==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="83">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="right">SP98:</td>
            <td><input name="cant_sp98" title="sp98" type="text" id="cant_sp98" size="8" maxlength="8" value="<? echo "$cant_sp98"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<? if($doble_descarga==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">GO A:</td>
            <td><input name="cant_go_a" title="go_a" type="text" id="cant_go_a" size="8" maxlength="8" value="<? echo "$cant_go_a"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<? if($avisar_antes_cargar==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">B1000:</td>
            <td><input name="cant_go_a1" title="go_a1" type="text" id="cant_go_a1" size="8" maxlength="8" value="<? echo "$cant_go_a1"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			
			<? if($avisar_salir_cargado==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">GO B:</td>
            <td><input name="cant_go_b" title="go_b" type="text" id="cant_go_b" size="8" maxlength="8" value="<? echo "$cant_go_b"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			
			<? if($pedir_muestra==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">GO C:</td>
            <td><input name="cant_go_c" title="go_c" type="text" id="cant_go_c" size="8" maxlength="8" value="<? echo "$cant_go_c"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
	
			<? if($descarga_bomba==1){
				$seleccionado="checked";
				}else{
			  	$seleccionado="";
			  }
			?>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">BIO:</td>
            <td><input name="cant_bio" title="bio" type="text" id="cant_bio" size="8" maxlength="8" value="<? echo "$cant_bio"; ?>"></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td colspan="12"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td >&nbsp;</td>
            <td></td>
            <td>&nbsp;</td>
            <td width="84"><? if ($estado!="f") { ?>
			<div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />Guardar</div>
			<? } ?></td>
            <td width="63"><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nou" onClick="location.href=direccion_conta('');"><br />Nou</div></td>
            <td align="center"><? if ($estado!="f") { ?>
			<img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_albaran');"><br />Eliminar
			<? } ?></td>
            <td align="center"><? if ($cod_albaran) { ?>
			<img src="/comun/imgs/imprimir.gif" title="Imprimir" name="imprimir" id="imprimir" onClick="enviar(event)" onMouseOver="window.top.focus();"><br />Imprimir
			<? } ?></td>
            <td colspan="2" align="center"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>