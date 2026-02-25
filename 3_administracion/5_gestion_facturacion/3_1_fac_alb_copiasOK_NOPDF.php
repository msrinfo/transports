<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Facturas Copias</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<script type="text/javascript">
function errores(event)
{
var cod_empresa = document.getElementById("cod_empresa").value;
var cod_factura_ini = document.getElementById("cod_factura_ini").value;
var cod_factura_fin = document.getElementById("cod_factura_fin").value;

//alert("cod_empresa: "+cod_empresa+"\ncod_factura_ini: "+cod_factura_ini+"\ncod_factura_fin: "+cod_factura_fin);

if (isNaN(cod_factura_ini) || cod_factura_ini=="" || isNaN(cod_factura_fin) || cod_factura_fin=="" || cod_factura_ini > cod_factura_fin)
{
alert("Valores incorrectos. Recuerde:\n- Código inicial y código final han de tener valores.\n- El código inicial no puede ser mayor que el código final.");
}

else if (event.target.id=="imprimir" || event.target.id=="imprimir_logo")
{
var logo="";

	if (event.target.id=="imprimir_logo")
		logo="si";

mostrar(event,'3_2_fac_alb_impr.php','cod_empresa',cod_empresa,'cod_factura_ini',cod_factura_ini,'cod_factura_fin',cod_factura_fin,'logo',logo,'','','','','','','','','','','','');
}

else if	(event.target.id=="gen_pdf" || event.target.id=="enviar_mail" || event.target.id=="pdf_mail")
{
var fac_accion="";

	if (event.target.id=="gen_pdf")
		fac_accion="no_mail";
	else if (event.target.id=="enviar_mail")
		fac_accion="no_pdf";

/*
if (document.getElementById("pdf"))
{
//alert(document.getElementById("pdf"));
document.body.removeChild("pdf");
}
*/
/**/
if (!document.getElementById("pdf"))
{
var pdf = document.createElement("iframe");
pdf.name="pdf";
pdf.id="pdf";
document.body.appendChild(pdf);
pdf.frameBorder="0";
pdf.width="0"; //pdf.width="800";
pdf.height="0"; //pdf.height="400";
}
else
	var pdf = document.getElementById("pdf");

pdf.src='/pdf/public_html/demo/index.php?url_fac=<? echo $servidor_web_js; ?>/<? echo $carpeta_js; ?>/3_administracion/5_gestion_facturacion/3_2_ver_fac.php&carpeta=<? echo $carpeta_js; ?>&usuario_any=<? echo $usuario_any_js; ?>&cod_empresa='+cod_empresa+'&cod_factura_ini='+cod_factura_ini+'&cod_factura_fin='+cod_factura_fin+'&fac_accion='+fac_accion;
} // Fin de else if	(event.target.id=="enviar_mail")
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE: VENTANA COPIAS FACTURAS
//--------------------------------------------------------------------------------------------
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" method="post" action="" onSubmit="">
  <tr class="titulo"> 
    <td colspan="16">Factures d'Albarans C&ograve;pies</td>
  </tr>
  <tr>
    <td width="3"></td>
    <td colspan="4"></td>
    <td width="322"></td>
  </tr>
  <tr>
    <td></td>
    <td width="176" align="right">&nbsp;</td>
    <td colspan="3">Empresa:
      <select name="cod_empresa" id="cod_empresa">
        <? mostrar_lista("empresas",$cod_empresa); ?>
      </select>   </td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">Total</td>
    <td align="left">Data Factura</td>
    <td>Client</td>
  </tr>
  <tr>
    <td></td>
    <td align="right">N&ordm; Factura Inicial:</td>
    <td width="66" align="left">
	<!--<input name="cod_factura_ini" type="text" id="cod_factura_ini" size="7" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_ini.value,'cod_factura',cod_factura_ini.value,'cod_empresa',cod_empresa.value,'','','','','','','','','fac_copias_ini');">-->
	<input name="cod_factura_ini" type="text" id="cod_factura_ini" size="6" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_ini.value,'cod_factura',cod_factura_ini.value,'cod_empresa',cod_empresa.value,'origen','A','','','','','','','fac_ini');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_ini');"></td>
    <td width="80" align="left"><input name="fac_total_ini" type="text" id="fac_total_ini" size="12" maxlength="12" readonly="true" class="readonly"></td>
    <td width="89" align="left"><input name="fac_fecha_ini" type="text" id="fac_fecha_ini" size="11" maxlength="10" readonly="true" class="readonly"></td>
    <td><input name="nombre_cliente_ini" type="text" id="nombre_cliente_ini" size="40" maxlength="40" readonly="true" class="readonly"></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">N&ordm; Factura Final:</td>
    <td>
<input name="cod_factura_fin" type="text" id="cod_factura_fin" size="6" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_fin.value,'cod_factura',cod_factura_fin.value,'cod_empresa',cod_empresa.value,'origen','A','','','','','','','fac_fin');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_fin');">	</td>
    <td><input name="fac_total_fin" type="text" id="fac_total_fin" size="12" maxlength="12" readonly="true" class="readonly"></td>
    <td><input name="fac_fecha_fin" type="text" id="fac_fecha_fin" size="11" maxlength="10" readonly="true" class="readonly"></td>
    <td><input name="nombre_cliente_fin" type="text" id="nombre_cliente_fin" size="40" maxlength="40" readonly="true" class="readonly"></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5" align="center">
       <input name="imprimir" type="button" id="imprimir" value="Veure" onClick="errores(event)">
      <input name="imprimir_logo" type="button" id="imprimir_logo" value="Veure Logo" onClick="errores(event)">
      <input name="Nou" type="button" value="Nou" onClick="location.href=direccion_conta('');">  
	 <!--
	  <input name="imprimir_logo" type="button" id="imprimir_logo" value="Veure Logo" onClick="errores(event)">
	  -->
	  </td>
    </tr>
</form>
</table>
</body>
</html>