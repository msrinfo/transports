<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Pagos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$tabla=$_POST["tabla"];
$cod_pago=$_POST["cod_pago"];
$cod_cliente=$_POST["cod_cliente"];
$nombre_cliente=$_POST["nombre_cliente"];



$cod_factura=$_POST["cod_factura"];
$fecha_pago=fecha_ing($_POST["fecha_pago"]);
$total_pago=$_POST["total_pago"];
$cod_banco=$_POST["cod_banco"];
$desc_pago=$_POST["desc_pago"];
$cod_cuenta_pago=$_POST["cod_cuenta"];
$cod_cuenta_pago=$cod_empresa.$cod_cuenta_pago;
$cod_factura=$_POST["cod_factura"];

/*echo "<br />cod_banco: '$cod_banco'<br />";
echo "<br />cod_cuenta: '$cod_cuenta'<br />";
exit();*/
// Si recibimos factura:
if ($cod_factura)
{

$existe_factura = sel_campo("COUNT(cod_compra)","","compras","cod_compra = '$cod_factura' and cod_empresa = '$cod_empresa'");

if($existe_factura==0)
{
	$mensaje="NO existe esta factura";	
}
else
{
// Si la suma del total de todos los pagos asociados a esa factura sumado al total cobro recibido supera el total de la factura, no continuamos:
$suma_pagos = sel_campo("SUM(total_pago)","alias","pagos","cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura' AND cod_pago != '$cod_pago'");
$fac_total = sel_campo("total","","compras","cod_compra = '$cod_factura' and cod_empresa = '$cod_empresa'");

if (($suma_pagos + $total_pago) > $fac_total)
{
$mensaje="No se guardará el pago:\\nLa suma de pagos asociados a la factura $cod_factura, incluyendo el total_pago ahora recibido, (".($suma_pagos + $total_pago).") supera el total de factura (".$fac_total.").";
}
}
if ($mensaje)
{
?>
<script type="text/javascript">
alert("<? echo $mensaje; ?>");
history.back();
</script>
<?
exit();
}

// Obtenemos el cliente de factura:
$c=sel_sql("SELECT * FROM compras WHERE cod_empresa = '$cod_empresa' AND cod_compra = '$cod_factura'");

if($tabla=='proveedores')
{
$cod_cliente=$c[0]['cod_proveedor'];
$nombre_cliente=$c[0]['nombre_prov'];
}

if($tabla=='acreedores')
{
$cod_cliente=$c[0]['cod_acreedor'];
$nombre_cliente=$c[0]['nombre_acre'];
}

/*
$cod_banco=$c[0]['cod_banco'];
if (!$cod_banco)
{
conectar_base($base_datos_conta);
$c=sel_sql("SELECT cod_banco FROM bancos WHERE SUBSTRING(cod_cuenta,1,2) = '$cod_empresa' ORDER BY cod_banco LIMIT 1");
$cod_banco=$c[0]['cod_banco'];
conectar_base($base_datos);
}
//*/
$desc_pago='PAGO DE FACTURA '.$cod_factura;
} // Fin de: Si recibimos factura.



// Comprobamos si existe:
$c=sel_sql("SELECT * FROM pagos WHERE cod_pago = '$cod_pago' and cod_empresa = '$cod_empresa'");
$existe=count($c);

// Obtenemos cuenta:
if ($cod_banco=='caja')
{
$cod_cuenta=$cod_empresa.'5700000';
}
else
{
conectar_base($base_datos_conta);
$c=sel_sql("SELECT cod_cuenta FROM bancos WHERE cod_banco = '$cod_banco'");
$cod_cuenta=$c[0]['cod_cuenta'];
conectar_base($base_datos);
} // Fin de else


$cod_cuenta_cli=$cod_empresa.'400'.$cod_cliente;

// Obtenemos hora:
$h=getdate();
$hora_pago=sprintf("%02s", $h[hours]).":".sprintf("%02s", $h[minutes]).":".sprintf("%02s", $h[seconds]);


if ($existe==1)
{
$modificar="UPDATE pagos SET

tabla='$tabla',
cod_cliente='$cod_cliente',
nombre_cliente='$nombre_cliente',
cod_factura='$cod_factura',
fecha_pago='$fecha_pago',
hora_pago='$hora_pago',
total_pago='$total_pago',
cod_cuenta_cli='$cod_cuenta_cli',
cod_cuenta='$cod_cuenta',
desc_pago='$desc_pago',
cod_cuenta_pago='$cod_cuenta_pago'

WHERE cod_pago = '$cod_pago' AND cod_empresa = '$cod_empresa'";

$result = mysql_query ($modificar, $link) or die ("No se ha modificado cobro: ".mysql_error()."<br /> $modificar <br />");
} // Fin de if ($existe==1)
	
else
{
if (!$cod_pago)
	$cod_pago=obtener_max_con("cod_pago","pagos","cod_empresa = '$cod_empresa'") + 1;

$insertar="INSERT INTO pagos
(cod_empresa,cod_pago,tabla,cod_cliente,nombre_cliente,cod_factura,fecha_pago,hora_pago,total_pago,cod_cuenta_cli,cod_cuenta,desc_pago,cod_cuenta_pago)
VALUES
('$cod_empresa','$cod_pago','$tabla','$cod_cliente','$nombre_cliente','$cod_factura','$fecha_pago','$hora_pago','$total_pago','$cod_cuenta_cli','$cod_cuenta','$desc_pago','$cod_cuenta_pago')";

$result=mysql_query($insertar, $link) or die ("No se ha insertado el cobro: ".mysql_error()."<br /> $insertar <br />");

conectar_base($base_datos_conta);

$cod_asiento_factura=sel_campo("cod_asiento","","asientos","txt_predef='CO' and cod_factura='$cod_factura'");
//echo "ASTO. FACT: $cod_asiento_factura";

$select_lin_asi="
SELECT *
FROM asientos,lin_asientos
WHERE asientos.cod_asiento = lin_asientos.cod_asiento AND asientos.cod_empresa = lin_asientos.cod_empresa AND asientos.cod_empresa = '$cod_empresa' AND asientos.cod_asiento = '$cod_asiento_factura' AND lin_asientos.cod_cuenta='$cod_cuenta_cli'";

$query_lin_asi=mysql_query($select_lin_asi) or die ("<br /> No se han seleccionado líneas de asiento: ".mysql_error()."<br /> $select_lin_asi <br />");
$lin=mysql_fetch_array($query_lin_asi);

// Revisamos vencimientos para actualizar su estado:
for($i=1; $i<=5; $i++)
{
$pendiente[$i]=$lin["pendiente".$i];


if($pendiente[$i]=="pa" || $pendiente[$i]=="ap" || $pendiente[$i]=="")
{
	echo "el venci esta pagado ";
}
if($pendiente[$i]=='pe')
	{
		//echo "el venci esta pendietne ";
		
		$imp_venci[$i]=$lin["imp_venci".$i];
		
		if($imp_venci[$i]==$total_pago)
			{
				//echo "importe y pagos igual";
				mod_sql("UPDATE lin_asientos SET pendiente".$i."='pa' WHERE cod_asiento='".$cod_asiento_factura."' and cod_cuenta='".$cod_cuenta_cli."'");
				break;
				//exit();
			}
	
	}
} // Fin de for vencimientos

conectar_base($base_datos);

} // Fin de else => if ($existe==1)

// Insertamos asiento:
insertar_asiento("pagos",$cod_empresa,$cod_pago);




// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
if (opener && (opener.location.href.search(/03_01_socios.php/)!=-1 || opener.location.href.search(/01_04_jugadores_econ.php/)!=-1))
{
opener.location.href=opener.location.href;
}

enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','tabla','<? echo $tabla; ?>','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos el script:
exit();
} // Fin de if ($_POST)


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$tabla=$_GET["tabla"];
$cod_pago=$_GET["cod_pago"];
$eliminar=$_GET["eliminar"];

$cod_cliente=$_GET["cod_cliente"];
$nombre_cliente=$_GET["nombre_cliente"];
$total_pago=$_GET["total_pago"];
/*
echo "<br /> tabla: $tabla <br />";
exit();
*/
// Obtenemos factura asociada al cobro:
$cod_factura = sel_campo("cod_factura","","pagos","cod_pago = '$cod_pago' and cod_empresa = '$cod_empresa'");

// Obtenemos total factura asociada al cobro:
$fac_total = sel_campo("total","","compras","cod_compra = '$cod_factura' and cod_empresa = '$cod_empresa'");


// Obtenemos total pago:
$total_pago = sel_campo("total_pago","","pagos","cod_pago = '$cod_pago' and cod_empresa = '$cod_empresa'");

$cod_cuenta_cli = sel_campo("cod_cuenta_cli","","pagos","cod_pago = '$cod_pago' and cod_empresa = '$cod_empresa'");

//---------------------------------------------------------------------------------------------
//                                      ELIMINAR COBRO
//---------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
$eliminar="DELETE FROM pagos WHERE cod_pago = '$cod_pago' and cod_empresa = '$cod_empresa'";
$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado el cobro: ".mysql_error()."<br /> $eliminar <br />");


conectar_base($base_datos_conta);

$cod_asiento_factura=sel_campo("cod_asiento","","asientos","txt_predef='CO' and cod_factura='$cod_factura'");
//echo "ASTO. FACT: $cod_asiento_factura";

$select_lin_asi="
SELECT *
FROM asientos,lin_asientos
WHERE asientos.cod_asiento = lin_asientos.cod_asiento AND asientos.cod_empresa = lin_asientos.cod_empresa AND asientos.cod_empresa = '$cod_empresa' AND asientos.cod_asiento = '$cod_asiento_factura' AND lin_asientos.cod_cuenta='$cod_cuenta_cli'";

$query_lin_asi=mysql_query($select_lin_asi) or die ("<br /> No se han seleccionado líneas de asiento: ".mysql_error()."<br /> $select_lin_asi <br />");
$lin=mysql_fetch_array($query_lin_asi);

// Revisamos vencimientos para actualizar su estado:
for($i=5; $i>=1; $i--)
{
$pendiente[$i]=$lin["pendiente".$i];


if($pendiente[$i]=='pa')
	{
		
		$imp_venci[$i]=$lin["imp_venci".$i];
		
		if($imp_venci[$i]==$total_pago)
			{
				//echo "importe y pagos igual: lo ponemos como pendiente";
				mod_sql("UPDATE lin_asientos SET pendiente".$i."='pe' WHERE cod_asiento='".$cod_asiento_factura."' and cod_cuenta='".$cod_cuenta_cli."'");
				break;
				//exit();
			}
			
				//echo "<br/>UPDATE lin_asientos SET pendiente1='pa' WHERE cod_asiento=$cod_asiento_factura and cod_cuenta=$cod_cuenta_cli";
	
	}
} // Fin de for vencimientos

conectar_base($base_datos);


// Eliminamos asiento de cobro:
eliminar_asiento("pagos",$cod_empresa,$cod_pago);

//mod_sql("UPDATE lin_asientos SET pendiente".$i."='pa' WHERE cod_asiento='".$cod_asiento_factura."' and cod_cuenta='".$cod_cuenta_cli."'");

?>
<script type="text/javascript">
if (opener && (opener.location.href.search(/03_01_socios.php/)!=-1 || opener.location.href.search(/01_04_jugadores_econ.php/)!=-1))
{
opener.location.href=opener.location.href;
}
</script>
<?
$cod_cliente=$cod_pago=$total_pago=$cod_factura=$fac_total="";
}
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR COBRO
//---------------------------------------------------------------------------------------------


// Mostramos datos del cobro:
if ($cod_pago)
{

?>
<script type='text/javascript'>
alert('entramos en pago.');
</script>
<?
/**/
$mostrar="SELECT * FROM pagos WHERE cod_empresa = '$cod_empresa' AND cod_pago = '$cod_pago'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha mostrado el cobro: ".mysql_error()."<br /> $mostrar <br />");	

$fila=mysql_fetch_array($result);

$cod_pago=$fila["cod_pago"];
$tabla=$fila["tabla"];
$cod_cliente=$fila["cod_cliente"];
$nombre_cliente=$fila["nombre_cliente"];
$cod_factura=$fila["cod_factura"];
$fecha_pago=$fila["fecha_pago"];
$hora_pago=$fila["hora_pago"];
$total_pago=$fila["total_pago"];
$cod_cuenta=$fila["cod_cuenta"];
$desc_pago=$fila["desc_pago"];
$cod_cuenta_pago=$fila["cod_cuenta_pago"];

conectar_base($base_datos_conta);
$d=sel_sql("SELECT cod_banco FROM bancos WHERE cod_cuenta = '$cod_cuenta'");
$cod_banco=$d[0]['cod_banco'];
conectar_base($base_datos);

if ($cod_factura!=0)
{

}
else
{
$cod_factura='';
}
} // Fin de if ($cod_pago)
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------

// Si NO recibimos empresa, elegimos por defecto:
if (!$cod_empresa)
{
$cod_empresa='01';
}

// Si NO recibimos tabla, elegimos por defecto:
if (!$tabla)
{
$tabla='proveedores';
}

if (!$cod_cuenta_pago)
{
$cod_cuenta_pago='6000000';
}


// Tabla:
if ($tabla=='proveedores')
{
$campo1="cod_proveedor";
$campo2="nombre_prov";
}

else if ($tabla=='acreedores')
{
$campo1="cod_acreedor";
$campo2="nombre_acre";
}


// Si no recibimos fecha_pago, mostramos la fecha actual:
if ($fecha_pago)
	$fecha_pago=fecha_esp($fecha_pago);
else
{
$fecha_hoy=getdate();
$fecha_pago=sprintf("%02s-%02s-%04s", $hoy['mday'],$hoy['mon'],$hoy['year']);
}
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="fecha_pago";

ser_ambos[0]="total_pago";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
{

	if (document.getElementById('tabla').value=='proveedores' && document.getElementById('cod_cliente').value==0)
	{
		alert('Introduzca proveedor.');
	}
	else if (document.getElementById('tabla').value=='acreedores' && document.getElementById('cod_cliente').value==0)
	{
		alert('Introduzca acreedor.');
	}
	else
	{
	document.forms[0].submit();
	}
	
}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_cliente')">
<table>
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="11">PAGOS</td>
          </tr>
          <tr> 
            <td width="3">&nbsp;</td>
            <td width="134">&nbsp;</td>
            <td width="118">&nbsp;</td>
            <td width="145">&nbsp;</td>
            <td width="174">&nbsp;</td>
            <td width="116">&nbsp;</td>
            <td width="128">&nbsp;</td>
            <td width="36">&nbsp;</td>
            <td width="469">&nbsp;</td>
            <td width="113">&nbsp;</td>
            <td width="16">&nbsp;</td>
          </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><div align="right">Empresa:</div></td>
    <td>
<select name="cod_empresa" id="cod_empresa" onChange="location.href='?cod_empresa='+this.value+'&tabla='+document.getElementById('tabla').value">
<? mostrar_lista("empresas",$cod_empresa); ?>
</select>
	</td>
    <td align="right">Fecha:</td>
    <td><input name="fecha_pago" title="Fecha" type="text" id="fecha_pago" size="11" maxlength="" value="<? echo $fecha_pago; ?>" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','form1','fecha_pago')"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Fichero:</div></td>
            <td colspan="4"><select name="tabla" id="tabla" onChange="location.href='?cod_empresa='+document.getElementById('cod_empresa').value+'&tabla='+this.value">
              <?

$mat_tabl1[]='proveedores';		$mat_tabl2[]='PROVEEDORES';
$mat_tabl1[]='acreedores';		$mat_tabl2[]='ACREEDORES';

opciones_select($mat_tabl1,$mat_tabl2,$tabla,'');
?>
            </select></td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Destinatario:</div></td>
            <td colspan="8">
              <input type="text" name="cod_cliente" id="cod_cliente" title="Código" value="<? echo $cod_cliente; ?>" size="6" maxlength="6" onBlur="buscar_conta(event,'<? echo $tabla; ?>',this.value,'<? echo $campo1; ?>',this.value,'','','','','','','','','','','<? echo $tabla; ?>');">
              <img src="/comun/imgs/lupa.gif" name="lupa" onClick="abrir(event,'cod_cliente');">
              <input type="text" name="nombre_cliente" id="nombre_cliente" title="Nombre" size="50" maxlength="100" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" class="readonly"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Asignar a cta:</td>
            <td colspan="8"><input name="cod_cuenta" type="text" id="cod_cuenta" title="C&oacute;digo Cuenta" size="8" maxlength="7" value="<? echo $cod_cuenta_pago; ?>" onBlur="buscar_cuenta(event)">
              <img src="/comun/imgs/lupa.gif" title="Buscar" onClick="abrir(event,'cod_cuenta')">
            <input name="desc_cuenta" type="text" id="desc_cuenta" value="<? echo a_html($desc_cuenta,"bd->input"); ?>" size="50" maxlength="100" title="Descripci&oacute;n Cuenta" readonly="true" class="readonly"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">C. Bancaria:</div></td>
            <td colspan="4"><select name="cod_banco" id="cod_banco" title="Cuenta Bancaria">
              <? mostrar_lista("bancos",$cod_banco); ?>
            </select></td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Imp. Pago</td>
            <td colspan="4"><input type="text" name="total_pago" id="total_pago" title="Total Cobro" size="13" maxlength="11" value="<? echo $total_pago; ?>">
            &euro;</td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Factura:</td>
            <td colspan="4"><input type="text" name="cod_factura" id="cod_factura" title="cod_factura" size="13" maxlength="11" value="<? echo $cod_factura; ?>"> 
            <em>* Cancela Vtos.</em></td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;Concepto</td>
            <td colspan="4"><input name="desc_pago" title="Concepto" type="text" id="desc_pago" size="45" maxlength="100" value="<? echo a_html($desc_pago,"bd->input"); ?>">
            <input type="hidden" name="cod_empresa2" id="cod_empresa2" value="<? echo $cod_empresa; ?>"></td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td><input type="button" name="guardar" id="guardar" title="Guardar" value="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();"></td>
            <td><div align="center"><img src="/comun/imgs/nuevo.gif" title="Nuevo" onClick="location.href=direccion_conta('');"><br />
            Nuevo</div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
            <td>&nbsp;</td>
            <td><div align="left"><strong>N&ordm; Pago</strong></div></td>
            <td><div align="left"><strong>Fecha</strong></div></td>
            <td><div align="left"><strong>N&ordm; Asiento</strong></div></td>
            <td><strong>Pago de Factura:</strong></td>
            <td><div align="right">
              <!---->
            <strong>Importe</strong></div></td>
            <td>&nbsp;</td>
            <td><div align="left"><strong>Concepto</strong></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="9"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
$cliente='';
if ($cod_cliente)
{
$cliente="AND cod_cliente = '$cod_cliente'";
}

$c=sel_sql("
SELECT *
FROM pagos
WHERE cod_empresa = '$cod_empresa' AND tabla = '$tabla'
$cliente
ORDER BY fecha_pago,cod_pago");
$total_filas=count($c);

$mat_mostrar=$total_filas;
$inicial=0;
/*
$lineas_mostrar=15;
paginar("limitar");

// Obtenemos el número de elementos de la matriz a mostrar:
$mat_mostrar = $inicial + $lineas_mostrar;
if ($mat_mostrar > $total_filas)
	$mat_mostrar = $total_filas;
//echo "<br />inicial: '$inicial'<br />mat_mostrar: '$mat_mostrar'<br />";
//*/

for ($i=$inicial; $i < $mat_mostrar; $i++)
{
$cod_pago=$c[$i]['cod_pago'];
$fecha_pago=$c[$i]['fecha_pago'];
$tabla=$c[$i]['tabla'];
$cod_cliente=$c[$i]['cod_cliente'];
$cod_factura=$c[$i]['cod_factura'];
$total_pago=$c[$i]['total_pago'];
$desc_pago=$c[$i]['desc_pago'];

conectar_base($base_datos_conta);

$cod_asiento=sel_campo("cod_asiento","","asientos","txt_predef='PA' and cod_factura='$cod_pago'");

conectar_base($base_datos);
// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><span class="vinculo" onClick="mostrar(event,'03_08_recibo_cobro.php','cod_empresa','<? echo $cod_empresa; ?>','cod_pago_ini','<? echo $cod_pago; ?>','cod_pago_fin','<? echo $cod_pago; ?>','','','','','','','','','','','','','','');"><? echo sprintf("%04s", $cod_pago); ?></span></td>
            <td><? echo fecha_esp($fecha_pago); ?></td>
            <td><? if($cod_asiento){ ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo "$cod_asiento"; ?></span> <? } ?></td>
            <td><? if ($cod_factura!=0) { ?><span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta; ?>/3_entrada_datos/01_04_impr_recibos.php','cod_empresa','<? echo $cod_empresa; ?>','cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','','','','','','','','','','','','','','');"><? echo $cod_factura; ?></span><? }?>&nbsp;</td>
            <td><div align="right"><? echo $total_pago; ?></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;<? echo $desc_pago; ?></td>
            <td><img src="/comun/imgs/editar.gif" title="Modificar" onClick="enlace(direccion_conta(''),'cod_pago','<? echo $cod_pago; ?>','cod_empresa','<? echo $cod_empresa; ?>','','','','','','','','','','','','','','','','');"><img src="/comun/imgs/eliminar2.gif" title="Eliminar" onClick="if(confirm('&iquest;Est&aacute; seguro de que desea eliminar el pago <? echo $cod_pago; ?>?')) {enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','cod_pago','<? echo $cod_pago; ?>','eliminar','2','tabla','<? echo $tabla; ?>','cod_cliente','<? echo $cod_cliente; ?>','','','','','','','','','','')};"></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de for
?>
</form>
</table>
</body>
</html>