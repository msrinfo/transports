<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Factures Albarans Anular</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />


<?
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$cod_factura_ini=$_POST["cod_factura_ini"];
$cod_factura_fin=$_POST["cod_factura_fin"];


anular_fac($cod_empresa,$cod_factura_ini,$cod_factura_fin);
} // Fin de if ($_POST)
?>



<script type="text/javascript">
function enviar()
{
var cod_empresa = document.getElementById("cod_empresa").value;
var cod_factura_ini = document.getElementById("cod_factura_ini").value;
var cod_factura_fin = document.getElementById("cod_factura_fin").value;

//alert("cod_empresa: "+cod_empresa+"\ncod_factura_ini: "+cod_factura_ini+"\ncod_factura_fin: "+cod_factura_fin);

if (isNaN(cod_factura_ini) || cod_factura_ini=="" || isNaN(cod_factura_fin) || cod_factura_fin=="" || cod_factura_ini > cod_factura_fin)
{
alert("Valores incorrectos. Recuerde:\n- Código inicial y código final han de tener valores.\n- El código inicial no puede ser mayor que el código final.");
}
else
{
document.forms[0].submit();
}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event)">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
    <td colspan="11">Factures Albarans Anular</td>
  </tr>
  <tr>
    <td width="1">&nbsp;</td>
    <td width="143">&nbsp;</td>
    <td width="70">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td width="92">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="11">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Empresa:</td>
    <td colspan="5">
	<select name="cod_empresa" id="cod_empresa">
      <? mostrar_lista("empresas",$cod_empresa); ?>
    </select></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Total</td>
    <td>Data Factura</td>
    <td colspan="2">Client</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Factura Inicial:</td>
    <td>
	<input name="cod_factura_ini" type="text" id="cod_factura_ini" size="6" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_ini.value,'cod_factura',cod_factura_ini.value,'cod_empresa',cod_empresa.value,'','','','','','','','','fac_ini');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_ini');"></td>
    <td><input name="fac_total_ini" type="text" id="fac_total_ini" size="12" maxlength="12" readonly="true" class="readonly"></td>
    <td><input name="fac_fecha_ini" type="text" id="fac_fecha_ini" size="11" maxlength="10" readonly="true" class="readonly"></td>
    <td width="220"><input name="nombre_cliente_ini" type="text" id="nombre_cliente_ini" size="40" maxlength="40" readonly="true" class="readonly"></td>
	 <td class="vinculo" onClick="mostrar(event,'/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/2_2_listado_alb.php','cod_factura',cod_factura_ini.value,'cod_empresa',cod_empresa.value,'clasificacion','CODI','','','','','','','','','','','','','','');">Veure Albarans</td>
     <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Factura Final:</td>
    <td><input name="cod_factura_fin" type="text" id="cod_factura_fin" size="6" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_fin.value,'cod_factura',cod_factura_fin.value,'cod_empresa',cod_empresa.value,'','','','','','','','','fac_fin');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_fin');"></td>
    <td><input name="fac_total_fin" type="text" id="fac_total_fin" size="12" maxlength="12" readonly="true" class="readonly"></td>
    <td><input name="fac_fecha_fin" type="text" id="fac_fecha_fin" size="11" maxlength="10" readonly="true" class="readonly"></td>
    <td colspan="2"><input name="nombre_cliente_fin" type="text" id="nombre_cliente_fin" size="40" maxlength="40" readonly="true" class="readonly"></td>
    <td></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="6" align="center">
      <input name="borrar" type="button" value="Borrar" onClick="enviar()"> 
      <input name="nuevo" type="button" value="Nueva B&uacute;squeda" onClick="location.href=direccion_conta('');"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>