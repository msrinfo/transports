<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Recibos Manuales</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />


<?
// Mostramos la fecha actual:
$fecha_hoy=getdate();
$fecha=$fecha_hoy[mday].'-'.$fecha_hoy[mon].'-'.$usuario_any;
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_no_vacio[0]="fac_fecha";
ser_no_vacio[1]="fecha_ven";

ser_ambos[0]="cod_factura";
ser_ambos[1]="cod_cliente";
ser_ambos[2]="fac_total";

ser_numero[0]="num_cuenta";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	var cod_empresa = document.getElementById("cod_empresa").value;
	var cod_factura = document.getElementById("cod_factura").value;
	var fac_fecha = document.getElementById("fac_fecha").value;
	var cod_cliente = document.getElementById("cod_cliente").value;
	var fac_total = document.getElementById("fac_total").value;
	var fecha_ven = document.getElementById("fecha_ven").value;
	var num_cuenta = document.getElementById("num_cuenta").value;

	mostrar(event,'5_2_impr_recibos.php','cod_empresa',cod_empresa,'cod_factura',cod_factura,'fac_fecha',fac_fecha,'cod_cliente',cod_cliente,'fac_total',fac_total,'fecha_ven',fecha_ven,'num_cuenta',num_cuenta,'','','','','','');
	}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
    <td colspan="14">Recibos Manuales</td>
  </tr>
  <tr>
    <td width="8"></td>
    <td width="401"></td>
    <td width="543"></td>
    <td width="3"></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Empresa:</td>
    <td><select name="cod_empresa" id="cod_empresa">
      <? mostrar_lista("empresas",$cod_empresa); ?>
    </select></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Recibo N&ordm;:</td>
    <td><input name="cod_factura" title="C&oacute;digo Recibo" type="text" id="cod_factura" size="6" maxlength="6"></td>
    <td></td>
    </tr>
  <tr>
    <td></td>
    <td align="right">Fecha Expedici&oacute;n:</td>
    <td>
	<input name="fac_fecha" title="Fecha Expedici&oacute;n" type="text" id="fac_fecha" size="11" maxlength="10" value="<? echo "$fecha"; ?>" onBlur="control_fechas_conta(event)">
    <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','form1','fac_fecha')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Cliente:</td>
    <td>
	<input name="cod_cliente" title="C&oacute;digo Cliente" type="text" id="cod_cliente" size="6" maxlength="6" onBlur="buscar_conta(event,'clientes',cod_cliente.value,'cod_cliente',cod_cliente.value,'','','','','','','','','','','');">
   <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_cliente');">
   <input name="nombre_cliente" type="text" id="nombre_cliente" size="40" maxlength="40">    </td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Importe:</td>
    <td>
	<input name="fac_total" title="Importe" type="text" id="fac_total" size="11" maxlength="9"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Fecha Vto:</td>
    <td><input name="fecha_ven" title="Fecha Vencimiento" type="text" id="fecha_ven" size="11" maxlength="10" value="<? echo "$fecha"; ?>" onBlur="control_fechas_conta(event)">
        <img src="/comun/imgs/calendario.gif" onClick="muestraCalendario('','form1','fecha_ven')"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Domiciliaci&oacute;n Bancaria:</td>
    <td><input name="num_cuenta" title="Domiciliaci&oacute;n Bancaria" type="text" id="num_cuenta" size="26" maxlength="20"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Crear" onClick="enviar(event)">
      <input name="nuevo" type="button" value="Nuevo Recibo" onClick="location.href=direccion_conta('')"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>