<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Facturación de Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$fac_fecha=fecha_ing($_POST["fac_fecha"]);

$cod_servicio=$_POST["cod_servicio"];

$tipo_iva=control_iva($_POST["tipo_iva"],$fac_fecha);
$fecha_ini=$_POST["fecha_ini"]; // Convertimos a inglés más adelante.
$fecha_fin=$_POST["fecha_fin"]; // Convertimos a inglés más adelante.

$cod_cliente=$_POST["cod_cliente"];
$gastos_finan=$_POST["gastos_finan"];
$cod_factura=$_POST["cod_factura"];

$observ_fact=$_POST["observ_fact"];
/*
echo "
<br /> cod_empresa: $cod_empresa
<br /> fac_fecha: $fac_fecha
<br /> cod_servicio: $cod_servicio
<br /> tipo_iva: $tipo_iva
<br /> fecha_ini: $fecha_ini
<br /> fecha_fin: $fecha_fin
<br /> cod_cliente: $cod_cliente
<br /> gastos_finan: $gastos_finan
<br /> cod_factura: $cod_factura
";
*/


// Establecemos numeración:
$ini_num_fac=1;
$fin_num_fac=499999;


// Si no hemos recibido cod_servicio, establecemos condiciones y seleccionamos clientes:
if (!$cod_servicio)
{
// Establecemos el valor de IVA (se tiene en cuenta el iva de la ficha del cliente):
$num_iva="and servicios.tipo_iva = '$tipo_iva'";

// Obtenemos fecha actual:
$fecha_hoy=getdate();
$any=$fecha_hoy[year];

// Si recibimos cod_cliente y el tip ode facturación lo permite, establecemos el cliente:
if ($cod_cliente)
{
$tipo_fac=sel_campo("tipo_fac","","clientes","cod_cliente = '$cod_cliente'");
$cliente="and servicios.cod_cliente = '$cod_cliente'";
} // Fin de if ($cod_cliente)

// Establecemos el tipo de facturación:
/*if ($fecha_hoy[mday] <= 15)
	$tipo_factura="and clientes.tipo_fac = '2'";*/

// Obtenemos fecha inicial:
if ($fecha_ini)
	$fecha_ini=fecha_ing($fecha_ini);
else
	$fecha_ini="$any-01-01";

// Obtenemos fecha final:
if ($fecha_fin)
	$fecha_fin=fecha_ing($fecha_fin);
else
	$fecha_fin="$any-12-31";

$periodo="and fecha BETWEEN '$fecha_ini' AND '$fecha_fin'";
//echo "$periodo";

$clientes_alb="
SELECT DISTINCT servicios.cod_cliente 
FROM servicios, clientes
WHERE servicios.cod_cliente = clientes.cod_cliente and cod_empresa = '$cod_empresa' and estado != 'f'
$tipo_factura $num_iva $cliente $periodo  
ORDER BY servicios.cod_cliente";
}

else
{
$clientes_alb="SELECT cod_cliente FROM servicios WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and estado != 'f'";
}

//echo "<br /> $clientes_alb <br />";

$consulta_cli_alb=mysql_query($clientes_alb, $link) or die ("<br /> No se han seleccionado clientes de servicios: ".mysql_error()."<br /> $clientes_alb <br />");

// Obtenemos el nº de servicios
$num_servicios=mysql_num_rows($consulta_cli_alb);
//echo "<br /> num_servicios: $num_servicios <br />";


// Si NO obtenemos servicios, no continuamos:
if ($num_servicios == 0)
{
?>
<script type="text/javascript">
alert('No se han encontrado servicios pendientes de facturar.');
location.href=direccion_conta('');
</script>
<?
exit();
}

else
{
$cont=0; // Contador de facturas creadas.

// Por cada cliente con servicios pendientes, crearemos una factura con sus servicios:
while($cli=mysql_fetch_array($consulta_cli_alb))
{
$cod_cliente=$cli["cod_cliente"]; //echo "<br /> cod_cliente: $cod_cliente <br />";

// Obtenemos los datos del cliente de la tabla clientes:
$select_cliente="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
$consulta_cli=mysql_query($select_cliente, $link) or die ("<br /> No se ha seleccionado cliente: ".mysql_error()."<br /> $select_cliente <br />");

$fila=mysql_fetch_array($consulta_cli);

$nombre_cliente=$fila["nombre_cliente"];
$razon_social=$fila["razon_social"];
$nif_cif=$fila["nif_cif"];

$domicilio=$fila["domicilio"];
$c_postal=$fila["c_postal"];
$poblacion=$fila["poblacion"];
$provincia=$fila["provincia"];
$domicilio_corresp=$fila["domicilio_corresp"];
$c_postal_corresp=$fila["c_postal_corresp"];
$poblacion_corresp=$fila["poblacion_corresp"];
$provincia_corresp=$fila["provincia_corresp"];

$telefono=$fila["telefono"];
$num_cuenta=$fila["num_cuenta"];

$cod_forma=$fila["cod_forma"];
$forma_pago=sel_campo("descripcion","","formas_pago","cod_forma = '$cod_forma'");

$cod_tipo=$fila["cod_tipo"];
$tipo_pago=sel_campo("desc_tipo","","tipos_pago","cod_tipo = '$cod_tipo'");

$tipo_iva=$fila["tipo_iva"];

// Para calcular totales de facturas:
$descuento_pp=$fila["descuento_pp"];
$recargo_equiv=$fila["recargo_equiv"];

// Para calcular vencimientos:
$num_pagos=$fila["num_pagos"];
$periodo_pago=$fila["periodo_pago"];
$dia_pago=$fila["dia_pago"];
$dia_pago2=$fila["dia_pago2"];
$inicio_giro=$fila["inicio_giro"];
$inicio_giro2=$fila["inicio_giro2"];
$fin_giro=$fila["fin_giro"];
$fin_giro2=$fila["fin_giro2"];
$venci_giro=$fila["venci_giro"];
$venci_giro2=$fila["venci_giro2"];

//echo "<br /><br /><br /> periodo_pago: $periodo_pago <br />";

// Calculamos el bruto de la factura, que es igual a la suma de los brutos de las órdenes:
if (!$cod_servicio)
{
// Establecemos el cliente actual:
$cliente="and cod_cliente = '$cod_cliente'";

$consulta="SELECT SUM(base) as fac_bruto
FROM servicios
WHERE cod_empresa = '$cod_empresa' and estado != 'f'
$tipo_factura $num_iva $cliente $periodo";

// Si no tengo una fecha en concreto, cogemos la de la factura:
$tipo_iva=control_iva($tipo_iva,$fac_fecha);
$fecha=$fac_fecha;
}

else
{
$consulta="SELECT base as fac_bruto, nombre_cliente, tipo_iva, fecha FROM servicios WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and estado != 'f'";
}

$query=mysql_query($consulta, $link) or die ("<br /> No se ha obtenido bruto de factura: ".mysql_error()."<br /> $consulta <br />");

$resultado=mysql_fetch_array($query);

$fac_bruto=$resultado["fac_bruto"];

if ($cod_servicio)
{
$nombre_cliente=$resultado["nombre_cliente"];
$fecha=$resultado["fecha"];
$tipo_iva=$resultado["tipo_iva"];
}


// Controlamos iva:
$tipo_iva=control_iva($tipo_iva,$fecha);

// Calculamos totales de facturas:
$tot_fac=calcular_totales_fac($fac_bruto,$gastos_finan,$descuento_pp,$recargo_equiv,$tipo_iva);

$imp_gastos_finan=$tot_fac["imp_gastos_finan"];
$imp_descuento_pp=$tot_fac["imp_descuento_pp"];
$fac_base=$tot_fac["fac_base"];
$fac_iva=$tot_fac["fac_iva"];
$imp_recargo_equiv=$tot_fac["imp_recargo_equiv"];
$fac_total=$tot_fac["fac_total"];


//--------------------------------------------------------------------------------------------
//                                CALCULAR VENCIMIENTOS
//--------------------------------------------------------------------------------------------
calc_vencis();
//--------------------------------------------------------------------------------------------
//                                FIN DE: CALCULAR VENCIMIENTOS
//--------------------------------------------------------------------------------------------

// Controlamos código factura:
control_facturas();

// Insertamos la factura:
$insertar_fac="INSERT INTO facturas
(cod_factura,cod_empresa,fac_fecha,origen,cod_cliente,nombre_cliente,tipo_iva,cod_forma,cod_tipo,fac_coste,fac_bruto,gastos_finan,imp_gastos_finan,descuento_pp,imp_descuento_pp,fac_base,fac_iva,recargo_equiv,imp_recargo_equiv,fac_total,venci1,venci2,venci3,venci4,venci5,imp_venci1,imp_venci2,imp_venci3,imp_venci4,imp_venci5,observ_fact)
VALUES
('$cod_factura','$cod_empresa','$fac_fecha','S','$cod_cliente','$nombre_cliente','$tipo_iva','$cod_forma','$cod_tipo','$fac_coste','$fac_bruto','$gastos_finan','$imp_gastos_finan','$descuento_pp','$imp_descuento_pp','$fac_base','$fac_iva','$recargo_equiv','$imp_recargo_equiv','$fac_total','$venci[1]','$venci[2]','$venci[3]','$venci[4]','$venci[5]','$imp_venci[1]','$imp_venci[2]','$imp_venci[3]','$imp_venci[4]','$imp_venci[5]','$observ_fact')";

//echo "$insertar_fac <br />";
$result_fac = mysql_query($insertar_fac, $link) or die ("<br /> No se ha insertado factura: ".mysql_error()."<br /> $insertar_fac <br />");

$cont++;

// Obtenemos la primera y la última factura insertada:
if ($cont==1)
	$cod_factura_ini=$cod_factura;

$cod_factura_fin=$cod_factura;
	

// ACTUALIZAMOS ORDENES:
if (!$cod_servicio)
{
$actualizar_alb="UPDATE servicios SET cod_factura = '$cod_factura', estado = 'f' WHERE cod_empresa = '$cod_empresa' and estado = ''
$tipo_factura $num_iva $cliente $periodo";
}

else
{
$actualizar_alb="UPDATE servicios SET cod_factura = '$cod_factura', estado = 'f' WHERE cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' and estado = ''";
}

//echo "<br /> actualizar_alb: $actualizar_alb <br />";
$result_alb = mysql_query($actualizar_alb, $link) or die ("<br /> No se han actualizado servicios: ".mysql_error()."<br /> $actualizar_alb <br />");


// CREAMOS ASIENTO A PARTIR DE FACTURA:
insertar_asiento("facturas",$cod_empresa,$cod_factura);

// Vaciamos arrays:
$venci = array();
$imp_venci = array();

// Vaciamos $cod_factura para insertar nuevas facturas:
$cod_factura="";
} // Fin de while($cli=mysql_fetch_array($consulta_cli_alb))
} // Fin de else => if (!$num_servicios)

if ($cont==1)
	$frase="En empresa $cod_empresa, $cont factura creada: $cod_factura_fin";
else if ($cont > 1)
	$frase="En empresa $cod_empresa, $cont facturas creadas: desde $cod_factura_ini hasta $cod_factura_fin";
?>
<script type="text/javascript">
alert('<? echo $frase; ?>.');

mostrar(sim_clic_impr(),'3_2_fac_serv_impr.php','cod_factura_ini','<? echo $cod_factura_ini; ?>','cod_factura_fin','<? echo $cod_factura_fin; ?>','cod_empresa','<? echo $cod_empresa; ?>','','','','','','','','','','','','','','');

// Si hemos facturado un albarán desde servicios, cerramos ventana y recargamos el interfaz de servicios:
if (opener)
{
window.close();
opener.location.href="/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_servicios_gondola.php?cod_servicio=<? echo $cod_servicio; ?>&cod_empresa=<? echo $cod_empresa; ?>";
}

location.href=direccion_conta('');
</script>
<?
// Finalizamos script:
exit();
} // Fin de if ($_POST)


if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$fac_fecha=$_GET["fac_fecha"];
$cod_servicio=$_GET["cod_servicio"];
$fecha=$_GET["fecha"];
$tipo_iva=$_GET["tipo_iva"];
$cod_cliente=$_GET["cod_cliente"];
$nombre_cliente=$_GET["nombre_cliente"];


// Si recibimos orden, cliente pasa a ser readonly:
if ($cod_servicio)
{
$clase_cli="readonly class='readonly'";
}
// Si recibimos cliente, orden pasa a ser readonly:
else if ($cod_cliente)
{
$clase_alb="readonly class='readonly'";
}
} // Fin de if ($_GET)


// Si no recibimos fechas, mostramos fecha actual:
$fecha_hoy=getdate();
if (!$fac_fecha)
{
	$fac_fecha=$fecha_hoy[mday]."-".$fecha_hoy[mon]."-".$usuario_any;
}

if (!$cod_servicio)
{
$fecha_ini="01-".$fecha_hoy[mon]."-".$usuario_any;
$ultimo_dia_mes=ultimo_dia_mes($usuario_any,$fecha_hoy[mon]);
$fecha_fin=$ultimo_dia_mes."-".$fecha_hoy[mon]."-".$usuario_any;
}
?>
<script type="text/javascript">
function errores()
{
// Si no recibimos los datos obligados de fecha de factura y tipo de IVA, no continuamos:
var fac_fecha = document.getElementById('fac_fecha').value;
var cod_servicio = document.getElementById('cod_servicio').value;

var tipo_iva = document.getElementById('tipo_iva').value;
var fecha_ini = document.getElementById('fecha_ini').value;
var fecha_fin = document.getElementById('fecha_fin').value;

if (!fac_fecha || (cod_servicio && (fecha_ini || fecha_fin)) || (!cod_servicio && (!tipo_iva || !fecha_ini || !fecha_fin)))
{
alert("* Seleccione OBLIGATORIAMENTE una Fecha de Factura y, además, UNA de las siguientes opciones:\n- Código Orden.\n- Tipo I.V.A., Fecha Inicio y Fecha Final.\n\n* OPCIONALMENTE, puede introducir:\n- Código Cliente (Si NO ha especificado Código Orden).\n- Gastos Financieros.\n- Código Factura (cuando necesite especificar un nº de factura concreto).");
return;
}

else
{
document.forms[0].submit();
}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="4">Facturaci&oacute; de Serveis </td>
          </tr>
          <tr> 
            <td width="7">&nbsp;</td>
            <td width="407">&nbsp;</td>
            <td width="520">&nbsp;</td>
            <td width="4">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Empresa:</div></td>
            <td><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">N&ordm; Servei:</div></td>
            <td><input name="cod_servicio" type="text" id="cod_servicio" size="6" maxlength="6" value="<? echo $cod_servicio; ?>" onBlur="buscar_conta(event,'servicios',cod_servicio.value,'cod_servicio',cod_servicio.value,'cod_empresa',cod_empresa.value,'','','','','','','','','alb_fac')" <? echo "$clase_alb"; ?>>
                <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_servicio');">
                <input name="fecha" type="text" id="fecha" size="11" maxlength="11" value="<? echo "$fecha"; ?>" <? echo $clase_alb; ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Client:</td>
            <td><input name="cod_cliente" type="text" id="cod_cliente" size="4" maxlength="4" value="<? echo $cod_cliente; ?>" <? echo "$clase_cli"; ?> onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','cli_fac');">
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
              <input name="nombre_cliente" type="text" id="nombre_cliente" size="40" maxlength="40" value="<? echo $nombre_cliente; ?>" <? echo "$clase_cli"; ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Data Factura:</td>
            <td><input name="fac_fecha" type="text" id="fac_fecha" size="11" maxlength="10" value="<? echo $fac_fecha; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','form1','fac_fecha')"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Tipus I.V.A.:</div></td>
            <td><input name="tipo_iva" type="text" id="tipo_iva" size="2" maxlength="2" value="<? if (!$cod_cliente && !$cod_servicio) {$tipo_iva=$val_iva[0];} echo $tipo_iva; ?>" <? echo "$clase_cli"; ?>></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Data Inici:</div></td>
            <td><input name="fecha_ini" type="text" id="fecha_ini" size="11" maxlength="10" value="<? echo $fecha_ini; ?>" onBlur="control_fechas_conta(event)">
                <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','form1','fecha_ini')"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Data Final:</div></td>
            <td valign="middle"><input name="fecha_fin" type="text" id="fecha_fin" size="11" maxlength="10" value="<? echo $fecha_fin; ?>" onBlur="control_fechas_conta(event)">
                <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','form1','fecha_fin')"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Despeses Financeres:</div></td>
            <td><input name="gastos_finan" type="text" id="gastos_finan" size="8" maxlength="8" value="<? echo $gastos_finan; ?>"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">N&ordm; Factura:</div></td>
            <td><input name="cod_factura" type="text" id="cod_factura" size="6" maxlength="6"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Observaciones:</div></td>
            <td><textarea name="observ_fact" id="observ_fact" title="Observaciones" cols="60" rows="5" onKeyPress="long_max_obs_fac(event)" <? if ($cod_cliente) { ?> <? } ?>></textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2"><div align="center"> 
            <input name="facturar" id="facturar" type="button" value="Facturar" onClick="errores()">&nbsp;
            <input name="Nou" type="button" value="Nou" onClick="location.href=direccion_conta('');">
              </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
<?
if ($cod_servicio)
{
// Si cod_servicio no está facturado y lo hemos recibido desde servicios, lo facturamos:
$estado=sel_campo("estado","","servicios","cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa'");

if ($estado=="f")
{
?>
<script type="text/javascript">
alert("Albarán <? echo $cod_servicio; ?> de la empresa <? echo $cod_empresa; ?> ya facturado.");
location.href=direccion_conta('');
</script>
<?
}

else
{
$direccion=substr($_GET["direccion"], -17);
//echo "<br /> direccion: $direccion <br />";

if ($direccion=="1_1_servicios_gondola.php")
{
?>
<script type="text/javascript">
document.forms[0].submit();
</script>
<?
// Finalizamos script:
//exit();
}
} // Fin de else
} // Fin de if ($cod_servicio)
?>
</body>
</html>