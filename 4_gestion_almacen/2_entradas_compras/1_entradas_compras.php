<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Gesti&oacute;n de Entradas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
// comun:
$cod_entrada=$_POST["cod_entrada"];
$cod_empresa=$_POST["cod_empresa"];

// entradas:
$fecha=fecha_ing($_POST["fecha"]);
$cod_proveedor=$_POST["cod_proveedor"];
$nombre_prov=$_POST["nombre_prov"];
$tipo_iva=$_POST["tipo_iva"];
$observaciones=$_POST["observaciones"];


// art_ent:
$cod_linea=$_POST["cod_linea"];
$cod_articulo=$_POST["cod_articulo"];
$descr_art=$_POST["descr_art"];
$cantidad=$_POST["cantidad"];
$precio_coste=$_POST["precio_coste"];
$precio_venta=$_POST["precio_venta"];
$tipo_descuento=$_POST["tipo_descuento"];


// Si recibimos cod_empresa, continuamos:
if ($cod_empresa)
{
// Comprobamos si existe entrada:
$comprobar_ord="SELECT cod_entrada FROM entradas WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa'";
$consultar_ord=mysql_query($comprobar_ord, $link) or die ("<br /> No se ha comprobado entrada: ".mysql_error()."<br /> $consultar_ord <br />");
$existe_ord=mysql_num_rows($consultar_ord);


// ÓRDENES:
if ($existe_ord==1)
{
// MODIFICAMOS entrada:
$modificar_ord="UPDATE entradas SET

fecha='$fecha',
cod_proveedor='$cod_proveedor',
nombre_prov='$nombre_prov',
tipo_iva='$tipo_iva',
observaciones='$observaciones',

total_coste='$total_coste',
total_bruto='$total_bruto',
total_descuento='$total_descuento',
total_neto='$total_neto',
total_beneficio='$total_beneficio',
total_margen='$total_margen'

WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa'";

$result_ord = mysql_query ($modificar_ord, $link) or die ("<br /> No se ha actualizado entrada: ".mysql_error()."<br /> $modificar_ord <br />");
} // Fin de if ($existe_ord==1)
	
else
{
// INSERTAMOS entrada:
$insertar_ord="INSERT INTO entradas
(cod_entrada,cod_empresa,fecha,cod_proveedor,nombre_prov,tipo_iva,observaciones,total_coste,total_bruto,total_descuento,total_neto,total_beneficio,total_margen)
VALUES ('$cod_entrada','$cod_empresa','$fecha','$cod_proveedor','$nombre_prov','$tipo_iva','$observaciones','$total_coste','$total_bruto','$total_descuento','$total_neto','$total_beneficio','$total_margen')";

$result_ord = mysql_query ($insertar_ord, $link) or die ("<br /> No se ha insertado entrada: ".mysql_error()."<br /> $insertar_ord <br />");

} // Fin de else => if ($existe_ord==1)


// ARTÍCULOS:
// Si recibimos cod_articulo, continuamos:
if ($cod_articulo)
{
// Calculamos totales de artículo:
$tot_art_ent=calcular_totales_art_ent($cantidad,$precio_coste,$precio_venta,$tipo_descuento);

$precio_neto=$tot_art_ent["precio_neto"];
$coste=$tot_art_ent["coste"];
$venta=$tot_art_ent["venta"];
$descuento=$tot_art_ent["descuento"];
$neto=$tot_art_ent["neto"];
$beneficio=$tot_art_ent["beneficio"];
$margen=$tot_art_ent["margen"];

// Comprobamos si el artículo existe:
$comprobar_art="SELECT cantidad as cantidad_anterior FROM art_ent WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea' and cod_articulo = '$cod_articulo'";
$consultar_art=mysql_query($comprobar_art, $link) or die ("No se ha comprobado artículo: ".mysql_error()."<br /> $comprobar_art <br />");
$existe_art=mysql_num_rows($consultar_art);

if ($existe_art==1)
{
// MODIFICAMOS ARTÍCULO:
$modificar_art="UPDATE art_ent SET

descr_art='$descr_art',
cantidad='$cantidad',
precio_coste='$precio_coste',
precio_venta='$precio_venta',
tipo_descuento='$tipo_descuento',
precio_neto='$precio_neto',

coste='$coste',
venta='$venta',
descuento='$descuento',
neto='$neto',
beneficio='$beneficio',
margen='$margen'

WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";

$result_art = mysql_query ($modificar_art, $link) or die ("No se ha actualizado art_ent: ".mysql_error()."<br /> $modificar_art <br />");
} // Fin de if ($existe_art==1)

else
{
if (!$cod_linea)
	$cod_linea=obtener_max_con("cod_linea","art_ent","cod_empresa = '$cod_empresa' and cod_entrada = '$cod_entrada'") + 1;

// INSERTAMOS NUEVO ARTÍCULO:
$insertar_art="INSERT INTO art_ent
(cod_entrada,cod_empresa,cod_linea,cod_articulo,descr_art,cantidad,precio_coste,precio_venta,tipo_descuento,precio_neto,coste,venta,descuento,neto,beneficio,margen)
VALUES
('$cod_entrada','$cod_empresa','$cod_linea','$cod_articulo','$descr_art','$cantidad','$precio_coste','$precio_venta','$tipo_descuento','$precio_neto','$coste','$venta','$descuento','$neto','$beneficio','$margen')";

$result_art = mysql_query ($insertar_art, $link) or die ("No se ha insertado art_ent: ".mysql_error()."<br /> $insertar_art <br />");
} // Fin de else => if ($existe_art==1)
} // Fin de if ($cod_articulo)


// Obtenemos la cantidad anterior y actualizamos existencias:
$exis=mysql_fetch_array($consultar_art);
$cantidad_anterior=$exis["cantidad_anterior"];
actualizar_exis("sumar",$cod_articulo,$cantidad,$cantidad_anterior);


// Actualizamos totales de entrada:
calcular_totales_alb($cod_entrada,$cod_empresa);
} // Fin de if ($cod_empresa)


// Recargamos página:
?>
<script type="text/javascript">
//alert("FIN POST");
enlace(direccion_conta(''),'cod_entrada','<? echo $cod_entrada; ?>','cod_empresa','<? echo $cod_empresa; ?>','','','','','','','','','','','','','','','','');
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
$cod_entrada=$_GET["cod_entrada"];
$cod_empresa=$_GET["cod_empresa"];

$cod_linea=$_GET["cod_linea"];

$cod_articulo=$_GET["cod_articulo"]; // Para actualizar existencias.
$cod_proveedor=$_GET["cod_proveedor"]; // Para establecer la propiedad readonly.
$eliminar=$_GET["eliminar"];



/*
echo "
<br /> cod_entrada: $cod_entrada
<br /> cod_empresa: $cod_empresa
<br /> cod_linea: $cod_linea
<br /> cod_proveedor: $cod_proveedor
<br /> eliminar: $eliminar
<br />";
//*/

// Comprobamos si existe entrada:
$select_ord="SELECT * FROM entradas WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa'";
$query_ord=mysql_query($select_ord, $link) or die ("<br /> No se ha comprobado entrada: ".mysql_error()."<br /> $select_ord <br />");
$existe_ord=mysql_num_rows($query_ord);


// Si existe entrada, continuamos:
if ($existe_ord==1)
{
//---------------------------------------------------------------------------------------------
//                                      ELIMINAR ARTÍCULO
//---------------------------------------------------------------------------------------------
if ($cod_linea && $eliminar==1)
{
		// Obtenemos la cantidad y actualizamos existencias:
		$cantidad=sel_campo("cantidad","","art_ent","cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'");
		actualizar_exis("restar",$cod_articulo,$cantidad,"0");

		// Eliminamos artículo:
		$eliminar_art="DELETE FROM art_ent WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";
		$result=mysql_query($eliminar_art, $link) or die ("No se ha eliminado artículo: ".mysql_error()."<br /> $eliminar_art <br />");

		// Actualizamos totales de entrada:
		calcular_totales_alb($cod_entrada,$cod_empresa);

// Vaciamos variables para evitar errores de introducción de datos:
$cod_linea=$cod_articulo=$precio_coste=$cantidad="";
} // Fin de if ($cod_linea && $eliminar==1)
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR ARTÍCULO
//---------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------
//                                      ELIMINAR ALBARÁN
//---------------------------------------------------------------------------------------------
else if ($eliminar==2)
{
// Obtenemos la suma de las cantidad de un mismo cod_articulo para sumar a existencias y actualizamos existencias:
$consulta="SELECT cod_linea,cantidad,cod_articulo FROM art_ent WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa'";
$query=mysql_query($consulta, $link) or die ("No se han sumado cantidades para actualizar existencias: ".mysql_error()."<br /> $consulta <br />");
while($arti=mysql_fetch_array($query))
{
$cod_linea=$arti["cod_linea"];
$cantidad=$arti["cantidad"];
$cod_articulo=$arti["cod_articulo"];

// Actualizamos existencias:
actualizar_exis("restar",$cod_articulo,$cantidad,"0");


// Eliminamos artículo:
$eliminar_art="DELETE FROM art_ent WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";
$result=mysql_query($eliminar_art, $link) or die ("No se ha eliminado artículo: ".mysql_error()."<br /> $eliminar_art <br />");
} // Fin de while($array=mysql_fetch_array($query))


// Eliminamos albarán:
$eliminar_alb="DELETE FROM entradas WHERE cod_entrada = '$cod_entrada' AND cod_empresa = '$cod_empresa'";
$result_alb=mysql_query($eliminar_alb, $link) or die ("No se ha eliminado la entrada ni sus artículos: ".mysql_error()."<br /> $eliminar_alb <br />");

// Vaciamos variables para evitar errores de introducción de datos:
$cod_entrada=$cod_empresa=$cod_linea=$cantidad=$cod_articulo="";
} // Fin de else if ($eliminar==2)
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR ALBARÁN
//---------------------------------------------------------------------------------------------


if ($existe_ord==1 && $eliminar!=2)
{
// Mostramos entrada:
$result_ord=mysql_query($select_ord, $link) or die ("No se ha mostrado la entrada: ".mysql_error()."<br /> $select_ord <br />");
//echo "<br /> select_ord: $select_ord <br />";
$ord=mysql_fetch_array($result_ord);

$cod_entrada=$ord["cod_entrada"];
$cod_empresa=$ord["cod_empresa"];
$fecha=fecha_esp($ord["fecha"]);
$cod_proveedor=$ord["cod_proveedor"];
$nombre_prov=$ord["nombre_prov"];
$tipo_iva=$ord["tipo_iva"];
$observaciones=$ord["observaciones"];

$total_coste=$ord["total_coste"];
$total_bruto=$ord["total_bruto"];
$total_descuento=$ord["total_descuento"];
$total_neto=$ord["total_neto"];
$total_beneficio=$ord["total_beneficio"];
$total_margen=$ord["total_margen"];


// Si recibimos cod_linea y no hemos eliminado, mostramos artículo:
if ($cod_linea && $eliminar!=1)
{
$mostrar_art="SELECT * FROM art_ent WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa' and cod_linea = '$cod_linea'";

$result_art=mysql_query($mostrar_art, $link) or die ("No se ha seleccionado artículo: ".mysql_error()."<br /> $mostrar_art <br />");
$art=mysql_fetch_array($result_art);

$cod_entrada=$art["cod_entrada"];
$cod_empresa=$art["cod_empresa"];
$cod_linea=$art["cod_linea"];
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];
$precio_neto=$art["precio_neto"];

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
// Si recibimos cod_proveedor, mostramos datos de cliente:
if ($cod_proveedor)
{
$select_cli="SELECT * FROM proveedores WHERE cod_proveedor = '$cod_proveedor'";
$result_cli=mysql_query($select_cli, $link) or die ("No se ha seleccionado cliente: ".mysql_error()."<br /> $select_cli <br />");
$cli=mysql_fetch_array($result_cli);
	
$nombre_prov=$cli["nombre_prov"];
$tipo_iva=$cli["tipo_iva"];
} // Fin de if ($cod_proveedor)
} // Fin de else
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN DE: GET
//--------------------------------------------------------------------------------------------


// Establecemos la propiedad (y la clase) readonly:
if (($existe_ord==1 && $eliminar!=2) || $cod_proveedor)
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


?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="fecha";
ser_no_vacio[1]="cod_entrada";

ser_ambos[0]="cod_proveedor";
ser_ambos[1]="tipo_iva";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);


if (validado)
{
var cod_entrada = document.getElementById('cod_entrada').value;
var cod_empresa = document.getElementById('cod_empresa').value;
var fac_fecha = document.getElementById('fecha').value;

//alert('event.target.id: '+event.target.id);
if (event.target.id=="imprimir")
{
mostrar(event,'1_2_impr_alb.php','cod_entrada',cod_entrada,'cod_empresa',cod_empresa,'','','','','','','','','','','','','','','','');
}

else
{
document.forms[0].submit();
}
} // Fin de if (validado)
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="acciones_cargar('cod_entrada')">
<table>
<form name="entradas" id="entradas" method="post" action="">
          <tr class="titulo"> 
            <td colspan="13">Gesti&oacute;n de Entradas </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Empresa:</div></td>
            <td colspan="3"><select name="cod_empresa" id="cod_empresa">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td align="right">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">N&ordm; Proveedor:</td>
            <td width="104"><input name="cod_proveedor" title="Código Cliente" type="text" id="cod_proveedor" size="4" maxlength="4" value="<? echo $cod_proveedor; ?>" onBlur="buscar_conta(event,'proveedores',cod_proveedor.value,'cod_proveedor',cod_proveedor.value,'cod_entrada',cod_entrada.value,'','','','','','','','','refrescar');" onMouseOut="this.blur()" <? echo $readonly_final; ?>>
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_proveedor');"></td>
            <td colspan="3"><input name="nombre_prov" title="Nombre Cliente" type="text" id="nombre_prov" size="40" maxlength="" value="<? echo $nombre_prov; ?>" readonly="true" class="readonly"></td>
            <td align="right">IVA:</td>
            <td colspan="2" align="left"><input name="tipo_iva" title="Tipo IVA" type="text" id="tipo_iva" size="2" maxlength="2" value="<? if (!$cod_entrada && $cod_proveedor && !$tipo_iva) {$tipo_iva=$val_iva[0];} echo $tipo_iva; ?>" <? echo $readonly_inicial; ?>></td>
            <td colspan="3" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td><div align="right">N&ordm; Entrada:</div></td>
            <td colspan="4"><input name="cod_entrada" title="Código Ent." type="text" id="cod_entrada" size="20" maxlength="15" value="<? echo $cod_entrada; ?>" onBlur="buscar_conta(event,'entradas',cod_entrada.value,'cod_proveedor',cod_proveedor.value,'cod_entrada',cod_entrada.value,'cod_empresa',cod_empresa.value,'','','','','','','refrescar_sin_borrar');" onMouseOut="this.blur()"> 
            <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_entrada');"></td>
            <td><div align="right">Fecha:</div></td>
            <td colspan="2" align="left"><input name="fecha" title="Fecha" type="text" id="fecha" size="11" maxlength="10"  value="<? echo $fecha; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','entradas','fecha')"></td>
            <td colspan="3">&nbsp;</td>
            <td width="6">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Observaciones:</div></td>
            <td colspan="9"><textarea name="observaciones" id="observaciones" title="Observaciones" cols="130" rows="2" <? echo $readonly_inicial; ?>><? echo $observaciones; ?></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right">Existencias: </div></td>
            <td>
              <div align="right">
                <input name="existencias" type="text" id="existencias" size="10" maxlength="11" value="<? echo $existencias; ?>" readonly="true" class="readonly">
                </div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="173">Art&iacute;culo</td>
            <td>Descripci&oacute;n</td>
            <td><input name="cod_linea" type="hidden" id="cod_linea" value="<? echo $cod_linea; ?>" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
            <td><div align="right">P. Coste</div></td>
            <td><div align="right">Cant.</div></td>
            <td width="69"><div align="right">P.V.P.</div></td>
            <td width="74"><div align="center">% Dto.</div></td>
            <td width="66"><div align="right">Precio Neto</div></td>
            <td width="61"><div align="right">Neto</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input name="cod_articulo" title="Código Artículo" type="text" id="cod_articulo" size="26" maxlength="20" value="<? echo $cod_articulo; ?>" onBlur="if (cod_articulo.value!='m' && cod_articulo.value!='M') {buscar_conta(event,'articulos',cod_articulo.value,'cod_articulo',cod_articulo.value,'cod_proveedor',cod_proveedor.value,'','','','','','','','','')} else {var precio_coste = document.getElementById('precio_coste'); precio_coste.readOnly=false; precio_coste.className='';}" <? echo $readonly_inicial; ?>> 
              <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_articulo');"></td>
            <td colspan="3"><input name="descr_art" title="Descripción Art." type="text" id="descr_art" size="50" value="<? echo $descr_art; ?>" <? echo $readonly_inicial; ?>>              
            <div align="right"></div></td>
            <td><div align="right">
              <input name="precio_coste" title="Precio Coste" type="text" id="precio_coste" size="10" maxlength="11" value="<? echo $precio_coste; ?>" onKeyUp="calc_imp_ent2(event)" onBlur="calc_imp_ent2(event)" onMouseOut="calc_imp_ent2(event)" <? echo $readonly_inicial; ?>>
            </div></td>
            <td><div align="right">
              <input name="cantidad" title="Cantidad" type="text" id="cantidad" size="10" maxlength="11" value="<? echo $cantidad; ?>" onKeyUp="calc_imp_ent2(event)" onBlur="calc_imp_ent2(event)" onMouseOut="calc_imp_ent2(event)" <? echo $readonly_inicial; ?>>
            </div></td>
            <td><div align="right">
              <input name="precio_venta" title="PVP" type="text" id="precio_venta" size="10" maxlength="11" value="<? echo $precio_venta; ?>" onKeyUp="calc_imp_ent2(event)" onBlur="calc_imp_ent2(event)" onMouseOut="calc_imp_ent2(event)" <? echo $readonly_inicial; ?>>
            </div></td>
            <td>
              <div align="center">
                <input name="tipo_descuento" title="Descuento Lineal" type="text" id="tipo_descuento" size="5" maxlength="5" value="<? echo $tipo_descuento; ?>" onKeyUp="calc_imp_ent2(event)" onBlur="calc_imp_ent2(event)" onMouseOut="calc_imp_ent2(event)" <? echo $readonly_inicial; ?>>
                </div></td><td><div align="right">
              <input name="precio_neto" title="Precio Neto" type="text" id="precio_neto" value="<? echo $precio_neto; ?>" size="10" maxlength="11" readonly="true" class="readonly">
            </div></td>
            <td><div align="right">
                <input name="neto" title="Importe Neto" type="text" id="neto" value="<? echo $neto; ?>" size="10" maxlength="11" readonly="true" class="readonly">
              </div></td>
            <td><input type="button" name="guardar" id="guardar" title="Guardar" value="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"></td>
            <td>&nbsp;</td>
          </tr>
<?
// Seleccionamos artículos:
$mostrar_art="SELECT * FROM art_ent WHERE cod_entrada = '$cod_entrada' and cod_empresa = '$cod_empresa'";
//echo "<br /> mostrar_art: $mostrar_art <br />";
$result_art=mysql_query($mostrar_art, $link) or die ("No se han seleccionado artículos de órdenes: ".mysql_error()."<br /> $mostrar_art <br />");

$total_filas=mysql_num_rows($result_art);

// Limitamos la consulta:
$lineas_mostrar=5;
$limit=paginar("limitar");


// Si hay uno o más artículos, los mostramos:
if ($total_filas > 0)
{
$mostrar_art .= " ORDER BY cod_linea $limit";

$result_art=mysql_query($mostrar_art, $link) or die ("No se han seleccionado artículos de órdenes: ".mysql_error()."<br /> $mostrar_art <br />");

while($art=mysql_fetch_array($result_art))
{
$cod_linea=$art["cod_linea"];
$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$precio_coste=$art["precio_coste"];
$precio_venta=$art["precio_venta"];
$tipo_descuento=$art["tipo_descuento"];
$precio_neto=$art["precio_neto"];
$neto=$art["neto"];


// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
            <td> <div align="left"><? echo $cod_articulo; ?></div></td>
            <td colspan="3"><? echo $descr_art; ?></td>
            <td><div align="right"><? echo $precio_coste; ?></div></td>
            <td><div align="right"><? echo $cantidad; ?></div></td>
            <td><div align="right"><? echo $precio_venta; ?></div></td>
            <td><div align="center"><? echo $tipo_descuento; ?></div></td>
            <td><div align="right"><? echo $precio_neto; ?></div></td>
            <td><div align="right"><? echo $neto; ?></div></td>
            <td><img src="/comun/imgs/editar.gif" title="Modificar" onClick="enlace(direccion_conta(''),'cod_entrada','<? echo $cod_entrada; ?>','cod_empresa','<? echo $cod_empresa; ?>','cod_linea','<? echo $cod_linea; ?>','','','','','','','','','','','','','','');">
			<img src="/comun/imgs/eliminar2.gif" title="Eliminar" onClick="if(confirm('¿Está seguro de que desea borrar el artículo \'<? echo "$cod_articulo: $descr_art"; ?>\'?')) {enlace(direccion_conta(''),'cod_entrada','<? echo $cod_entrada; ?>','cod_empresa','<? echo $cod_empresa; ?>','cod_linea','<? echo $cod_linea; ?>','cod_articulo','<? echo $cod_articulo; ?>','eliminar','1','','','','','','','','','','')};"></td>
            <td >&nbsp;</td>
          </tr>
<?
} // Fin de while($art=mysql_fetch_array($result_art))
} // Fin de if ($total_filas > 0)


// Rellenamos con filas:
paginar("rellenar");
?>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"> 
<?
$campo_pag[1]="cod_entrada"; $valor_pag[1]=$cod_entrada;
$campo_pag[2]="cod_empresa"; $valor_pag[2]=$cod_empresa;


// Paginamos:
paginar("paginar");
?>          </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">Art. Coste</div></td>
            <td><div align="center">Art. P.V.P. </div></td>
            <td><div align="center">Imp. Dto.</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">Art. Benef.</div></td>
            <td><div align="center">Art. Marg.</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
              <div align="center">
                <input name="coste" title="Importe Coste" type="text" id="coste" size="10" maxlength="11" value="<? echo $coste; ?>" readonly="true" class="readonly">
                </div></td><td><div align="center">
                  <input name="venta" title="Art. P.V.P." type="text" id="venta" size="10" maxlength="11" value="<? echo $venta; ?>" readonly="true" class="readonly">
                </div></td>
                <td><div align="center">
                  <input name="descuento" title="Importe Dto." type="text" id="descuento" size="10" maxlength="11" value="<? echo $descuento; ?>" readonly="true" class="readonly"></div></td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
              <div align="center">
                <input name="beneficio" title="Beneficios" type="text" id="beneficio" size="10" maxlength="11" value="<? echo $beneficio; ?>" readonly="true" class="readonly">
                </div></td><td><div align="center">
                  <input name="margen" type="text" id="margen" size="10" maxlength="11" value="<? echo $margen; ?>" readonly="true" class="readonly">
                </div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">Total Coste</div></td>
            <td><div align="center">Total Bruto</div></td>
            <td width="75"><div align="center">Total Desc.</div></td>
            <td width="66"><div align="center">Total Neto </div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">Beneficio</div></td>
            <td><div align="center">Margen</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>  
                <div align="center">
                  <input name="total_coste" type="text" id="total_coste" size="10" maxlength="11" value="<? echo $total_coste; ?>" readonly="true" class="readonly">
              </div></td>
            <td>
              <div align="center">
                <input name="total_bruto" type="text" id="total_bruto" size="10" maxlength="11" value="<? echo $total_bruto; ?>" readonly="true" class="readonly">
              </div></td>
            <td>
              <div align="center">
                <input name="total_descuento" type="text" id="total_descuento" size="10" maxlength="11" value="<? echo $total_descuento; ?>" readonly="true" class="readonly">
              </div></td>
            <td>
              <div align="center">
                <input name="total_neto" type="text" id="total_neto" size="10" maxlength="11" value="<? echo $total_neto; ?>" readonly="true" class="readonly">
              </div></td>
            <td>&nbsp;</td><td>&nbsp;</td>
            <td>  
                <div align="center">
                  <input name="total_beneficio" type="text" id="total_beneficio" size="10" maxlength="11" value="<? echo $total_beneficio; ?>" readonly="true" class="readonly">
              </div></td>
            <td>  
                <div align="center">
                  <input name="total_margen" type="text" id="total_margen" size="10" maxlength="11" value="<? echo $total_margen; ?>" readonly="true" class="readonly">
              </div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="83"><div align="center"><img src="/comun/imgs/guardar.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"><br />
            Guardar </div></td>
            <td width="73"><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nuevo" onClick="location.href=direccion_conta('');"><br />Nuevo</div></td>
            <td align="center"><img src="/comun/imgs/eliminar.gif" title="Eliminar" onClick="eliminar(event,'cod_entrada');"><br />
Eliminar</td>
            <td align="center"><!--<img src="/comun/imgs/imprimir.gif" title="Imprimir" name="imprimir" id="imprimir" onClick="enviar(event)" onMouseOver="window.top.focus();"><br />
Imprimir--></td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>