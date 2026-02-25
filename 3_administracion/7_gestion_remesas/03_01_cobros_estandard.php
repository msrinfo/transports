<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cobros</title>
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
$cod_cobro=$_POST["cod_cobro"];
$cod_cliente=$_POST["cod_cliente"];
$nombre_cliente=$_POST["nombre_cliente"];
$cod_factura=$_POST["cod_factura"];
$fecha_cobro=fecha_ing($_POST["fecha_cobro"]);
$total_cobro=$_POST["total_cobro"];
$cod_banco=$_POST["cod_banco"];
$desc_cobro=$_POST["desc_cobro"];
$cod_cuenta_ingreso=$_POST["cod_cuenta"];
$cod_cuenta_ingreso=$cod_empresa.$cod_cuenta_ingreso;
/*echo "<br />cod_banco: '$cod_banco'<br />";
echo "<br />cod_cuenta: '$cod_cuenta'<br />";
exit();*/
// Si recibimos factura:
if ($cod_factura)
{
// Si la suma del total de todos los cobros asociados a esa factura sumado al total cobro recibido supera el total de la factura, no continuamos:
$suma_cobros = sel_campo("SUM(total_cobro)","alias","cobros","cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura' AND cod_cobro != '$cod_cobro'");

$fac_total = sel_campo("fac_total","","facturas","cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'");

if (($suma_cobros + $total_cobro) > $fac_total)
{
$mensaje="No se guardará el cobro:\\nLa suma de cobros asociados a la factura $cod_factura, incluyendo el total_cobro ahora recibido, (".($suma_cobros + $total_cobro).") supera el total de factura (".$fac_total.").";
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
$c=sel_sql("SELECT * FROM facturas WHERE cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura'");
$cod_cliente=$c[0]['cod_cliente'];
$nombre_cliente=$c[0]['nombre_cliente'];
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
$desc_cobro='COBRO DE FACTURA '.$cod_factura;
} // Fin de: Si recibimos factura.


// Comprobamos si existe:
$c=sel_sql("SELECT * FROM cobros WHERE cod_cobro = '$cod_cobro' and cod_empresa = '$cod_empresa'");
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

// Si es VARIOS
if($tabla=='varios')
{
	//$cod_cuenta=$cod_cuenta_ingreso;
}

// Obtenemos hora:
$h=getdate();
$hora_cobro=sprintf("%02s", $h[hours]).":".sprintf("%02s", $h[minutes]).":".sprintf("%02s", $h[seconds]);


if ($existe==1)
{
$modificar="UPDATE cobros SET

tabla='$tabla',
cod_cliente='$cod_cliente',
nombre_cliente='$nombre_cliente',
cod_factura='$cod_factura',
fecha_cobro='$fecha_cobro',
hora_cobro='$hora_cobro',
total_cobro='$total_cobro',
cod_cuenta='$cod_cuenta',
desc_cobro='$desc_cobro',
cod_cuenta_ingreso='$cod_cuenta_ingreso'

WHERE cod_cobro = '$cod_cobro' AND cod_empresa = '$cod_empresa'";

$result = mysql_query ($modificar, $link) or die ("No se ha modificado cobro: ".mysql_error()."<br /> $modificar <br />");
} // Fin de if ($existe==1)
	
else
{
if (!$cod_cobro)
	$cod_cobro=obtener_max_con("cod_cobro","cobros","cod_empresa = '$cod_empresa'") + 1;

$insertar="INSERT INTO cobros
(cod_empresa,cod_cobro,tabla,cod_cliente,nombre_cliente,cod_factura,fecha_cobro,hora_cobro,total_cobro,cod_cuenta,desc_cobro,cod_cuenta_ingreso)
VALUES
('$cod_empresa','$cod_cobro','$tabla','$cod_cliente','$nombre_cliente','$cod_factura','$fecha_cobro','$hora_cobro','$total_cobro','$cod_cuenta','$desc_cobro','$cod_cuenta_ingreso')";

$result=mysql_query($insertar, $link) or die ("No se ha insertado el cobro: ".mysql_error()."<br /> $insertar <br />");
} // Fin de else => if ($existe==1)




// Insertamos asiento:
insertar_asiento("cobros",$cod_empresa,$cod_cobro);


// Actualizamos estado pago socio:
if ($tabla=='socios')
{
act_pago_socio($cod_cliente);
}

// Actualizamos servicio 1 jugador:
if ($tabla=='jugadores')
{
act_serv_jug($cod_cliente);
}


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
$cod_cobro=$_GET["cod_cobro"];
$eliminar=$_GET["eliminar"];

$cod_cliente=$_GET["cod_cliente"];
$nombre_cliente=$_GET["nombre_cliente"];
$total_cobro=$_GET["total_cobro"];
/*
echo "<br /> tabla: $tabla <br />";
exit();
*/
// Obtenemos factura asociada al cobro:
$cod_factura = sel_campo("cod_factura","","cobros","cod_cobro = '$cod_cobro' and cod_empresa = '$cod_empresa'");

// Obtenemos total factura asociada al cobro:
$fac_total = sel_campo("fac_total","","facturas","cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'");


//---------------------------------------------------------------------------------------------
//                                      ELIMINAR COBRO
//---------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
	
$recibo=sel_campo("recibo","","cobros","cod_cobro = '$cod_cobro' and cod_empresa = '$cod_empresa'");	

if($recibo!=0)
	{
	$eliminar_recibo="DELETE FROM recibos WHERE cod_recibo = '$recibo' and cod_empresa = '$cod_empresa'";
	$result=mysql_query($eliminar_recibo, $link) or die ("<br /> No se ha eliminado el recibo: ".mysql_error()."<br /> $eliminar <br />");
	}

$eliminar="DELETE FROM cobros WHERE cod_cobro = '$cod_cobro' and cod_empresa = '$cod_empresa'";
$result=mysql_query($eliminar, $link) or die ("<br /> No se ha eliminado el cobro: ".mysql_error()."<br /> $eliminar <br />");



// Eliminamos asiento de cobro:
eliminar_asiento("cobros",$cod_empresa,$cod_cobro);


?>
<script type="text/javascript">
if (opener && (opener.location.href.search(/03_01_socios.php/)!=-1 || opener.location.href.search(/01_04_jugadores_econ.php/)!=-1))
{
opener.location.href=opener.location.href;
}
</script>
<?
$cod_cliente=$cod_cobro=$total_cobro=$cod_factura=$fac_total="";
}
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR COBRO
//---------------------------------------------------------------------------------------------


// Mostramos datos del cobro:
if ($cod_cobro)
{
/*
?>
<script type='text/javascript'>
alert('entramos en cobro.');
</script>
<?
*/
$mostrar="SELECT * FROM cobros WHERE cod_empresa = '$cod_empresa' AND cod_cobro = '$cod_cobro'";

$result=mysql_query($mostrar, $link) or die ("<br /> No se ha mostrado el cobro: ".mysql_error()."<br /> $mostrar <br />");	

$fila=mysql_fetch_array($result);

$cod_cobro=$fila["cod_cobro"];
$tabla=$fila["tabla"];
$cod_cliente=$fila["cod_cliente"];
$nombre_cliente=$fila["nombre_cliente"];
$cod_factura=$fila["cod_factura"];
$fecha_cobro=$fila["fecha_cobro"];
$hora_cobro=$fila["hora_cobro"];
$total_cobro=$fila["total_cobro"];
$cod_cuenta=$fila["cod_cuenta"];
$desc_cobro=$fila["desc_cobro"];
$cod_cuenta_ingreso=$fila["cod_cuenta_ingreso"];

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
} // Fin de if ($cod_cobro)
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
$tabla='clientes';
}

// Tabla:
if ($tabla=='clientes')
{
$campo1="cod_cliente";
$campo2="nombre_cliente";
}


// Si no recibimos fecha_cobro, mostramos la fecha actual:
if ($fecha_cobro)
	$fecha_cobro=fecha_esp($fecha_cobro);
else
{
$fecha_hoy=getdate();
$fecha_cobro=sprintf("%02s-%02s-%04s", $hoy['mday'],$hoy['mon'],$hoy['year']);
}
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="fecha_cobro";

ser_ambos[0]="total_cobro";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
{
	if (document.getElementById('tabla').value=='varios' && document.getElementById('cod_cuenta').value==0)
	{ 
	 	alert('Introduzca "Asignar a cta."');
	}
	else if (document.getElementById('tabla').value=='clientes' && document.getElementById('cod_cliente').value==0)
	{
		alert('Introduzca sponsor.');
	}
	else if (document.getElementById('tabla').value=='socios' && document.getElementById('cod_cliente').value==0)
	{
		alert('Introduzca socio.');
	}
	else if (document.getElementById('tabla').value=='jugadores' && document.getElementById('cod_cliente').value==0)
	{
		alert('Introduzca jugador.');
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
            <td colspan="11">Cobros</td>
          </tr>
          <tr> 
            <td width="3">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="123">&nbsp;</td>
            <td width="152">&nbsp;</td>
            <td width="113">&nbsp;</td>
            <td width="295">&nbsp;</td>
            <td width="86">&nbsp;</td>
            <td width="20">&nbsp;</td>
            <td width="185">&nbsp;</td>
            <td width="385">&nbsp;</td>
            <td width="23">&nbsp;</td>
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
    <td><input name="fecha_cobro" title="Fecha" type="text" id="fecha_cobro" size="11" maxlength="" value="<? echo $fecha_cobro; ?>" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','form1','fecha_cobro')"></td>
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
$mat_tabl1[]='clientes';		$mat_tabl2[]='CLIENTES';

opciones_select($mat_tabl1,$mat_tabl2,$tabla,'');
?>
            </select></td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Pagador:</div></td>
            <td colspan="8">
              <input type="text" name="cod_cliente" id="cod_cliente" title="Código" value="<? echo $cod_cliente; ?>" size="6" maxlength="6" onBlur="buscar_conta(event,'<? echo $tabla; ?>',this.value,'<? echo $campo1; ?>',this.value,'','','','','','','','','','','<? echo $tabla; ?>');">
              <img src="/comun/imgs/lupa.gif" name="lupa" onClick="abrir(event,'cod_cliente');">
              <input type="text" name="nombre_cliente" id="nombre_cliente" title="Nombre" size="50" maxlength="100" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" readonly="true" class="readonly"> 
            <em>* S&oacute;lo si es JUGADOR,SOCIO,SPONSOR</em></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Asignar a cta:</td>
            <td colspan="4"><input name="cod_cuenta" type="text" id="cod_cuenta" title="C&oacute;digo Cuenta" size="8" maxlength="7" value="<? echo $cod_cuenta_ingreso; ?>" onBlur="buscar_cuenta(event)">
              <img src="/comun/imgs/lupa.gif" title="Buscar" onClick="abrir(event,'cod_cuenta')">
            <input name="desc_cuenta" type="text" id="desc_cuenta" value="<? echo a_html($desc_cuenta,"bd->input"); ?>" size="50" maxlength="100" title="Descripci&oacute;n Cuenta" readonly="true" class="readonly"></td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">C. Bancaria:</div></td>
            <td colspan="4"><select name="cod_banco" id="cod_banco" title="Cuenta Bancaria">
              <option value="caja">CAJA</option>
              <? mostrar_lista("bancos",$cod_banco); ?>
            </select></td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">Imp. Cobro</td>
            <td colspan="4"><input type="text" name="total_cobro" id="total_cobro" title="Total Cobro" size="13" maxlength="11" value="<? echo $total_cobro; ?>"></td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;Concepto</td>
            <td colspan="4"><input name="desc_cobro" title="Concepto" type="text" id="desc_cobro" size="45" maxlength="100" value="<? echo a_html($desc_cobro,"bd->input"); ?>">
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
            <td><div align="left"><strong>N&ordm; Cobro</strong></div></td>
            <td><div align="left"><strong>Fecha</strong></div></td>
            <td><div align="left"><strong>N&ordm; Asiento</strong></div></td>
            <td><strong>Pagador</strong></td>
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
FROM cobros
WHERE cod_empresa = '$cod_empresa' AND tabla = '$tabla' AND cod_remesa = ''
$cliente
ORDER BY fecha_cobro,cod_cobro");
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
$cod_cobro=$c[$i]['cod_cobro'];
$fecha_cobro=$c[$i]['fecha_cobro'];
$tabla=$c[$i]['tabla'];
$cod_cliente=$c[$i]['cod_cliente'];
$nombre_cliente=$c[$i]['nombre_cliente'];
$cod_factura=$c[$i]['cod_factura'];
$total_cobro=$c[$i]['total_cobro'];
$desc_cobro=$c[$i]['desc_cobro'];

conectar_base($base_datos_conta);

$cod_asiento=sel_campo("cod_asiento","","asientos","txt_predef='CB' and cod_factura='$cod_cobro'");

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
            <td><span class="vinculo" onClick="mostrar(event,'03_08_recibo_cobro.php','cod_empresa','<? echo $cod_empresa; ?>','cod_cobro_ini','<? echo $cod_cobro; ?>','cod_cobro_fin','<? echo $cod_cobro; ?>','','','','','','','','','','','','','','');"><? echo sprintf("%06s", $cod_cobro); ?></span></td>
            <td><? echo fecha_esp($fecha_cobro); ?></td>
            <td><? if($cod_asiento){ ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta_conta; ?>/2_procesos_diarios/2_1_asientos_contables.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_asiento','<? echo $cod_asiento; ?>','','','','','','','','','','','','','','','','');"><? echo "$cod_asiento"; ?></span> <? } ?></td>
            <td><? echo $cod_cliente." ".$nombre_cliente; ?></td>
            <td><div align="right"><? echo $total_cobro; ?></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;<? echo $desc_cobro; ?></td>
            <td><img src="/comun/imgs/editar.gif" title="Modificar" onClick="enlace(direccion_conta(''),'cod_cobro','<? echo $cod_cobro; ?>','cod_empresa','<? echo $cod_empresa; ?>','','','','','','','','','','','','','','','','');"><img src="/comun/imgs/eliminar2.gif" title="Eliminar" onClick="if(confirm('&iquest;Est&aacute; seguro de que desea eliminar el cobro <? echo $cod_cobro; ?>?')) {enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','cod_cobro','<? echo $cod_cobro; ?>','eliminar','2','tabla','<? echo $tabla; ?>','cod_cliente','<? echo $cod_cliente; ?>','','','','','','','','','','')};"></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de for
?>
</form>
</table>
</body>
</html>