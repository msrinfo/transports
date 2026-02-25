<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Cobro Remesa</title>
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
$concepto=$_POST["concepto"];
$cod_banco=$_POST["cod_banco"];
$norma=$_POST["norma"];
$fecha_emision=fecha_ing($_POST["fecha_emision"]);
$fecha_venc=fecha_ing($_POST["fecha_venc"]);
$rem=$_POST["rem"];



//echo 'Is array: '.is_array($rem).' ==> '; var_dump($rem); exit();

// Si recibimos datos para generar remesa:
if ($concepto && $cod_banco && $fecha_emision && is_array($rem) && count($rem) > 0)
{
//$concept=implode(' ',$concepto);

$concept=$concepto;

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



$i=0;
$num=count($rem);

for($j=0; $j < $num; $j++)
{


// Si cantidad es un número y superior a 0, añadimos a remesa:
if (is_numeric($rem[$j]['cant']) && $rem[$j]['cant'] > 0)
{
$lin[$i]['cant']=$rem[$j]['cant'];
//echo $lin[$i]['cant'];


if ($fecha_venc)
	$venci=$fecha_venc;
else
	$venci=$fecha_emision;

$lin[$i]['venc']=$venci;
$lin[$i]['cod']=$rem[$j]['cod'];
$lin[$i]['nom']=$rem[$j]['nom'];
$lin[$i]['num_cuenta']=$rem[$j]['num_cuenta'];

$e=sel_sql("SELECT bic FROM $tabla WHERE cod_cliente = '".$lin[$i]['cod']."'");
$lin[$ii]['bic']=$e[0]['bic'];

/*
echo $lin[$i]['cod'];
echo $lin[$i]['bic'];
exit();*/

// Creamos cobro:
$cod_cobro=obtener_max_con("cod_cobro","cobros","cod_empresa = '$cod_empresa'") + 1;

// Definimos fecha y hora de creación:
$h=getdate();
$hora_creacion=sprintf("%02s", $h['hours']).":".sprintf("%02s", $h['minutes']).":".sprintf("%02s", $h['seconds']);

mod_sql("
INSERT INTO cobros
(cod_empresa,cod_cobro,cod_cliente,nombre_cliente,fecha_cobro,hora_cobro,total_cobro,cod_cuenta,desc_cobro,cod_remesa)
VALUES
('$cod_empresa','$cod_cobro','".$lin[$i]['cod']."','".addslashes($lin[$i]['nom'])."','".$lin[$i]['venc']."','".$hora_creacion."','".$lin[$i]['cant']."','$cod_cuenta','".addslashes($concept)."','".$emp['cod_remesa']."')");

// Insertamos asiento:
//insertar_asiento("cobros",$cod_empresa,$cod_cobro);

$i++;
} // Fin de: Si cantidad es un número y superior a 0.
} // Fin de for

//echo 'Is array: '.is_array($lin).' ==> '; var_dump($lin); exit();
/*
echo "no: $norma<br/>";
echo "concepto: $concepto<br/>";
echo "carpeta: $carpeta<br/>";
echo "no: $norma<br/>";
exit();*/

// Guardamos remesa:
if ($norma=='19')
	n19($emp,$lin,$concepto,$carpeta); //ANTES: n19($emp,$lin,$concepto);
else if ($norma=='58')
	n58($emp,$lin,$concepto);

// Insertamos asiento de remesa:
asi_rem($cod_empresa,$emp['cod_remesa'],$tabla);
} // Fin de: Si recibimos datos para generar remesa.

else
{
?>
<script type="text/javascript">
alert('NO se han recibido datos para generar remesa.\nRecuerde rellenar los campos obligatorios y confirmar que jugador tiene forma de pago REMESA\ny domiciliación bancaria.');
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
	}
} // Fin de: Tabla.


// Fechas:
if (!$fecha_emision)
	$fecha_emision=sprintf("%02s-%02s-%04s", $hoy['mday'],$hoy['mon'],$hoy['year']);
else
	$fecha_emision=fecha_esp($fecha_emision);

if (!$fecha_venc)
	$fecha_venc=sprintf("%02s-%02s-%04s", $hoy['mday'],$hoy['mon'],$hoy['year']);
else
	$fecha_venc=fecha_esp($fecha_venc);
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
            <td colspan="10">Cobro Remesa</td>
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
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">Fichero:</div></td>
            <td colspan="7"><select name="tabla" id="tabla" onChange="location.href='?cod_empresa='+document.getElementById('cod_empresa').value+'&tabla='+this.value">
              <?
$mat_tabl1[]='clientes';		$mat_tabl2[]='CLIENTES';

opciones_select($mat_tabl1,$mat_tabl2,$tabla,'');
?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
<!--
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right">C&oacute;digo:</div></td>
            <td colspan="7"><input type="text" name="cod_cliente" id="cod_cliente" title="C&oacute;digo" value="<? echo $cod_cliente; ?>" size="6" maxlength="6" onBlur="buscar_conta(event,'<? echo $tabla; ?>',this.value,'<? echo $campo1; ?>',this.value,'','','','','','','','','','','<? echo $tabla; ?>');">
              <img src="/comun/imgs/lupa.gif" alt="" name="lupa" onClick="abrir(event,'cod_cliente');">
            <input type="text" name="nombre_cliente" id="nombre_cliente" title="Nombre" size="50" maxlength="100" value="<? echo a_html($nombre_cliente,"bd->input"); ?>" readonly="true" class="readonly"> 
            (Si se deja en blanco, se tomar&aacute;n todos los registros del fichero)</td>
            <td>&nbsp;</td>
          </tr>
-->
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
            <td colspan="4"><select name="cod_banco" id="cod_banco" title="Cuenta Bancaria">
    		<? mostrar_lista('bancos',$cod_cuenta_banco); ?>
    </select> 
            </td>
            <td><div align="right">Norma:</div></td>
            <td><select name="norma" id="norma">
              <option value="19">19</option>
              <option value="58">58</option>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right">Fecha Emisi&oacute;n:</div></td>
            <td colspan="2"><input name="fecha_emision" title="Fecha Emisión" type="text" id="fecha_emision" size="11" maxlength="10" value="<? echo $fecha_emision; ?>" onBlur="control_fechas_conta(event); document.getElementById('fecha_venc').value=this.value;">
            <img src="/comun/imgs/calendario.gif" alt="" title="Calendario" onClick="muestraCalendario('','','fecha_emision')"></td>
            <td>&nbsp;</td>
            <td><div align="right">Fecha Venc.:</div></td>
            <td><input name="fecha_venc" title="Fecha Venc." type="text" id="fecha_venc" size="11" maxlength="10" value="<? echo $fecha_venc; ?>" onBlur="control_fechas_conta(event)">
            <img src="/comun/imgs/calendario.gif" alt="" title="Calendario" onClick="muestraCalendario('','','fecha_venc')"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="right"></div></td>
            <td colspan="3"></td>
            <td>&nbsp;</td>
            <td><div align="center">
              <input type="button" name="generar" value="Generar" onClick="enviar(event);" onMouseOver="window.top.focus();">
            </div></td>
            <td><input type="hidden" name="cod_empresa2" id="cod_empresa2" value="<? echo $cod_empresa; ?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="8"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Registros Fichero</td>
            <td>Nombre</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="left">Importe</div></td>
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
            <td width="76">&nbsp;</td>
            <td width="69">&nbsp;</td>
            <td width="94">&nbsp;</td>
            <td width="155">&nbsp;</td>
            <td width="280">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
<?
$sql="
SELECT *
FROM $tabla
WHERE cod_forma = '03'
ORDER BY $campo1, $campo2";
//echo $sql;
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
$cod_cliente=$c[$i]['cod_cliente'];
$nombre_cliente=$c[$i]['nombre_cliente'];
$num_cuenta=$c[$i]['num_cuenta'];
$bic=$c[$i]['bic'];

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
            <td colspan="5"><? echo substr($cod_cliente.' '.$nombre_cliente, 0, 50); ?></td>
            <td><? echo $cod_cuenta; if ($saldo==0) echo " <strong> $saldo </strong>"; ?></td>
            <td>
<input type="hidden" name="rem[<? echo $i; ?>][cod]" value="<? echo $cod_cliente; ?>">
<input type="hidden" name="rem[<? echo $i; ?>][nom]" value="<? echo $nombre_cliente; ?>">
<input type="hidden" name="rem[<? echo $i; ?>][num_cuenta]" value="<? echo $num_cuenta; ?>">
<input type="text" name="rem[<? echo $i; ?>][cant]" id="rem[<? echo $i; ?>][cant]" maxlength="7" size="9" value=""></td>
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