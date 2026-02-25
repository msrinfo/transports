<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Crear Remesa</title>
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
$rem=$_POST["rem"];
$venc=$_POST["venc"];
$concepto=$_POST["concepto"];
$cod_banco=$_POST["cod_banco"];
$norma=$_POST["norma"];
$fecha_emision=fecha_ing($_POST["fecha_emision"]);

/*
echo "tabla: $tabla<br/>";
echo "venc: $venc<br/>";
echo "cod_banco: $cod_banco<br/>";
echo "norma: $norma<br/>";
echo "fecha_emision: $fecha_emision<br/>";
var_dump($concepto); echo 'isarray: '.is_array($rem).'.'; exit();
*/

// Si recibimos datos para generar remesa:
if ($concepto && $cod_banco && $fecha_emision && is_array($rem) && count($rem) > 0)
{
if ($tabla=='clientes')
{
$campo1="cod_cliente";
}

else if ($tabla=='socios')
{
$campo1="cod_socio";
}

else if ($tabla=='jugadores')
{
$campo1="cod_jugador";
}

//$concept=implode(' ',$concepto);

$emp['fecha_emision']=$fecha_emision;

// Obtenemos remesa:
$c=sel_sql("SELECT MAX(cod_remesa) as cod_remesa FROM remesas WHERE cod_empresa = '$cod_empresa'");
$cod_remesa=$c[0]['cod_remesa'] + 1;
$emp['cod_remesa']=$cod_remesa;

// Obtenemos datos de empresa:
$emp['cod_empresa']=$cod_empresa;

conectar_base($base_datos_conta);
$c=sel_sql("SELECT * FROM empresas WHERE cod_empresa = '$cod_empresa'");

$emp['nom_empresa']=$c[0]['nom_empresa'];
$emp['nif_cif']=$c[0]['nif_cif'];
//$emp['iban']=$c[0]['iban'];

// Obtenemos datos de banco:
$c=sel_sql("SELECT * FROM bancos WHERE cod_banco = '$cod_banco'");
conectar_base($base_datos);

$emp['sufijo_cobro']=$c[0]['sufijo_cobro'];
$emp['cod_ine']=$c[0]['cod_ine'];
$emp['num_cuenta']=$c[0]['cc_banco'];
$emp['iban']=$c[0]['iban'];

$cod_cuenta=$c[0]['cod_cuenta'];

conectar_base_i($base_datos);

$ii=0;
$num=count($rem);
for($i=0; $i < $num; $i++)
{
// Obtenemos datos:
$c=sel_sql("SELECT * FROM facturas WHERE cod_factura = '".$rem[$i]."'");
$d=sel_sql("SELECT num_cuenta FROM $tabla WHERE $campo1 = '".$c[0]['cod_cliente']."'");
$e=sel_sql("SELECT bic FROM $tabla WHERE $campo1 = '".$c[0]['cod_cliente']."'");

$lin[$ii]['cant']=$c[0]['fac_total'];



if ($venc[$rem[$i]])
	$venci=fecha_ing($venc[$rem[$i]]);
else
	$venci=$fecha_emision;

$lin[$ii]['venc']=$venci;
$lin[$ii]['cod']=$c[0]['cod_cliente'];
$lin[$ii]['nom']=$c[0]['nombre_cliente'];
$lin[$ii]['num_cuenta']=$d[0]['num_cuenta'];
$lin[$ii]['bic']=$e[0]['bic'];

// Si es jugador, adaptamos importe:
if ($tabla=='jugadores')
{
$a=sel_sql("SELECT cod_servicio FROM albaranes WHERE cod_empresa = '$cod_empresa' AND cod_factura = '".$rem[$i]."'");

// Si la factura tiene solamente un albarán y corresponde a servicio 1:
if (count($a)==1 && $a[0]['cod_servicio']==1)
{
$debe=act_pago_jug($lin[$ii]['cod']);

	if ($debe < $lin[$ii]['cant'])
		$lin[$ii]['cant']=$debe;

	// Si cantidad es 0, eliminamos último elemento y continuamos:
	if ($debe==0)
	{
	array_pop($lin);
	continue;
	}
} // Fin de: Si la factura tiene solamente un albarán y corresponde a servicio 1.
} // Fin de: Si es jugador.

// Actualizamos factura:


mod_sql("UPDATE facturas SET cod_remesa = '$cod_remesa' WHERE cod_empresa = '$cod_empresa' AND cod_factura = '".$rem[$i]."'");

// Creamos cobro:
$cod_cobro=obtener_max_con("cod_cobro","cobros","cod_empresa = '$cod_empresa'") + 1;

// Definimos fecha y hora de creación:
$h=getdate();
$fecha_emision=$h['year'].'-'.$h['mon'].'-'.$h['mday'];
$hora_creacion=sprintf("%02s", $h[hours]).":".sprintf("%02s", $h[minutes]).":".sprintf("%02s", $h[seconds]);

mod_sql("
INSERT INTO cobros
(cod_empresa,cod_cobro,cod_cliente,nombre_cliente,cod_factura,fecha_cobro,hora_cobro,total_cobro,cod_cuenta,desc_cobro,cod_remesa)
VALUES
('$cod_empresa','$cod_cobro','".$lin[$ii]['cod']."','".addslashes($lin[$ii]['nom'])."','".$c[0]['cod_factura']."','$venci','".$hora_creacion."','".$lin[$ii]['cant']."','$cod_cuenta','".addslashes($concept)."','".$emp['cod_remesa']."')");

// Insertamos asiento:
//insertar_asiento("cobros",$cod_empresa,$cod_cobro);

// Actualizamos estado pago socio:
/*if ($tabla=='socios')
{
//act_socio($lin[$ii]['cod']);
act_pago_socio($lin[$ii]['cod']);
} // Fin de if

// Actualizamos servicio 1 jugador:
if ($tabla=='jugadores')
{
act_pago_jug($lin[$ii]['cod']);
//act_serv_jug($lin[$ii]['cod']);
} // Fin de if
*/
$ii++;
} // Fin de for

/*
var_dump($emp);
var_dump($lin);
echo "$concepto";
echo "$carpeta";

exit();
*/
// Guardamos remesa:
if ($norma=='19')
	n19($emp,$lin,$concepto,$carpeta);
/*else if ($norma=='58')
	n58($emp,$lin,$concepto);
*/
// Insertamos asiento de remesa:
asi_rem($cod_empresa,$emp['cod_remesa'], $tabla);
} // Fin de: Si recibimos datos para generar remesa.

else
{
?>
<script type="text/javascript">
alert('NO se han recibido datos para generar remesa.');
history.back();
</script>
<?
} // Fin de else
} // Fin de if ($_POST)


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET['cod_empresa'];
$tabla=$_GET['tabla'];
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN GET
//--------------------------------------------------------------------------------------------

$where='AND';

// Si NO recibimos empresa, elegimos por defecto:
if (!$cod_empresa)
{
$cod_empresa='01';
}

// Si NO recibimos tabla, elegimos por defecto:
if (!$tabla)
{
$tabla='clientes';
$campo1="cod_cliente";
$campo2="nombre_cliente";
}

// Tabla:
if ($tabla)
{
$tabl="$where tabla = '$tabla' AND $tabla.cod_forma = 'REMESA'";
$where='AND';

	if ($tabla=='clientes')
	{
	$campo1="cod_cliente";
	$campo2="nombre_cliente";
	}
	if ($tabla=='socios')
	{
	$campo1="cod_socio";
	$campo2="nombre_socio";
	}
	else if ($tabla=='jugadores')
	{
	$campo1="cod_jugador";
	$campo2="nombre";

	$tabl .= " $where jugadores.pagado = 'NO'";
	}
} // Fin de: Tabla.


// Fechas:
if (!$fecha_emision)
	$fecha_emision=sprintf("%02s-%02s-%04s", $hoy['mday'],$hoy['mon'],$hoy['year']);
else
	$fecha_emision=fecha_esp($fecha_emision);
?>
<script type="text/javascript">
//--------------------------------------------------------------------------------------------
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="concepto0";
ser_no_vacio[1]="cod_banco";
ser_no_vacio[2]="fecha_emision";

ser_ambos[0]="norma";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
{
document.forms[0].submit();
}
} // Fin de function
//--------------------------------------------------------------------------------------------

function imp_rem()
{
var e = document.getElementsByTagName('input');
var total=0;
var num_dom=0;

for (var i=0; i < e.length; i++)
{
	if (e[i].type=='checkbox' && e[i].checked==true && !isNaN(e[i].value))
	{
	//alert(e[i].value);
	total += parseFloat(document.getElementById('imp['+e[i].value+']').value);
	num_dom++;
	} // Fin de if
} // Fin de for

document.getElementById('total_rem').value=redondear_js(total);
document.getElementById('num_dom').value=num_dom;
} // Fin de function
//--------------------------------------------------------------------------------------------

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

imp_rem();
} // Fin de function
//--------------------------------------------------------------------------------------------

function copiar_f_venci(event)
{
var fecha_emision = document.getElementById('fecha_emision').value;
var e = document.getElementsByTagName('input');

for (var i=0; i < e.length; i++)
{
	if (e[i].type=='text' && e[i].id.substring(0,4)=='venc')
	{
	e[i].value=fecha_emision;
	} // Fin de if
} // Fin de for
} // Fin de function
</script>
<style type="text/css">
.scroll
{
height:345px;
overflow:auto;
/**/
}
</style>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('concepto0')">
<form name="form1" method="post" action="">
<table>
          <tr class="titulo"> 
            <td colspan="10">Crear Remesa</td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td width="144">&nbsp;</td>
            <td width="56">&nbsp;</td>
            <td width="72">&nbsp;</td>
            <td width="73">&nbsp;</td>
            <td width="87">&nbsp;</td>
            <td width="121">&nbsp;</td>
            <td width="110">&nbsp;</td>
            <td width="283">&nbsp;</td>
            <td width="5">&nbsp;</td>
          </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><div align="right">Empresa:</div></td>
    <td colspan="4">
<select name="cod_empresa" id="cod_empresa" onChange="location.href='?cod_empresa='+this.value+'&tabla='+document.getElementById('tabla').value">
<? mostrar_lista("empresas",$cod_empresa); ?>
</select>
	</td>
    <td><div align="right">Receptor:</div></td>
    <td colspan="2"><select name="tabla" id="tabla" onChange="location.href='?cod_empresa='+document.getElementById('cod_empresa').value+'&tabla='+this.value">
      <?
$mat_tabl1[]='clientes';		$mat_tabl2[]='CLIENTES';

opciones_select($mat_tabl1,$mat_tabl2,$tabla,'');
?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Concepto:</div></td>
            <td colspan="4"><input type="text" name="concepto" id="concepto" title="Concepto" size="50" maxlength="40" value=""></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Cuenta Bancaria:</div></td>
            <td colspan="4"><select name="cod_banco" id="cod_banco">
    <? mostrar_lista('bancos',$cod_banco); ?>
    </select></td>
            <td><div align="right">Norma:</div></td>
            <td><select name="norma" id="norma">
              <option value="sepa">SEPA</option>
              <option value="19">19</option>
              <option value="58">58</option>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Fecha Emisi&oacute;n:</div></td>
            <td colspan="4"><input name="fecha_emision" title="Fecha Emisión" type="text" id="fecha_emision" size="11" maxlength="10" value="<? echo $fecha_emision; ?>" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" alt="" title="Calendario" onClick="muestraCalendario('','','fecha_emision')">&nbsp;<span class="vinculo" onClick="copiar_f_venci(event)">Copiar fecha a Vencimientos</span></td>
            <td><div align="center">
              <input type="button" name="generar" value="Generar" onClick="enviar(event);" onMouseOver="window.top.focus();">
            </div></td>
            <td colspan="2"><input type="hidden" name="cod_empresa" id="cod_empresa" value="<? echo $cod_empresa; ?>">
              Total Remesa:
              <input type="text" id="total_rem" size="13" maxlength="11" readonly class="readonly">&nbsp;&euro;
            &nbsp;&nbsp;&nbsp;
Nº Dom.: <input type="text" id="num_dom" size="3" maxlength="3" readonly class="readonly"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="8"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input type="checkbox" onClick="marcar_todos(event)" />
              Todos</td>
            <td><div align="left">Recibo</div></td>
            <td><div align="left">Fecha</div></td>
            <td><div align="right">Importe</div></td>
            <td colspan="2"><div align="left">&nbsp;&nbsp;Receptor</div></td>
            <td>&nbsp;</td>
            <td><div align="left">Concepto</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="8"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<!---->
          <tr>
            <td colspan="10">
<div class="scroll">
<table>
          <tr> 
            <td width="1">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="58">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="69">&nbsp;</td>
            <td width="94">&nbsp;</td>
            <td width="155">&nbsp;</td>
            <td width="280">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
<?
$sql="
SELECT facturas.*
FROM facturas,$tabla
WHERE facturas.cod_empresa = '$cod_empresa' AND facturas.cod_cliente = $tabla.$campo1 
AND facturas.cod_remesa = '' AND facturas.fac_total > 0 AND $tabla.num_cuenta != '' AND cod_factura NOT IN
	(
	SELECT DISTINCT(cod_factura)
	FROM cobros
	WHERE cod_empresa = '$cod_empresa' AND cobros.cod_factura = facturas.cod_factura
	)
ORDER BY nombre_cliente,cod_cliente,fac_fecha,cod_factura";

/*
echo $sql;
  AND facturas.fac_fecha <= '2012-11-01'
*/

$c=sel_sql($sql);
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
$cod_factura=$c[$i]['cod_factura'];
$fac_fecha=$c[$i]['fac_fecha'];
$fac_total=$c[$i]['fac_total'];
$concepto=$c[$i]['concepto'];
$cod_remesa=$c[$i]['cod_remesa'];

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
            <td><input type="checkbox" name="rem[]" value="<? echo $cod_factura; ?>" <? echo $checked; ?> onClick="imp_rem()">
              <input type="text" name="venc[<? echo $cod_factura; ?>]" id="venc[<? echo $cod_factura; ?>]" title="Vencimiento" size="11" maxlength="10" value="<? echo $fecha_emision; ?>" onBlur="control_fechas_conta(event)">
              <img src="/comun/imgs/calendario.gif" alt="" title="Calendario" onClick="muestraCalendario('','','venc[<? echo $cod_factura; ?>]')">
<input type="hidden" id="imp[<? echo $cod_factura; ?>]" value="<? echo $fac_total; ?>">
			</td>
            <td><span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/5_2_impr_recibos.php','cod_empresa','<? echo $cod_empresa; ?>','cod_factura_ini','<? echo $cod_factura; ?>','cod_factura_fin','<? echo $cod_factura; ?>','','','','','','','','','','','','','','');"><? echo $cod_factura; ?></span></td>
            <td><? echo fecha_esp($fac_fecha); ?></td>
            <td width="76"><div align="right"><? echo $fac_total; ?></div></td>
            <td colspan="3">&nbsp;&nbsp;<? echo substr($c[$i]['cod_cliente'].' '.$c[$i]['nombre_cliente'], 0, 25); ?></td>
            <td><? echo substr($concepto, 0, 25); ?></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de for
?>
</table>
</div>
			</td>
          </tr>
<!---->
</table>
</form>
</body>
</html>