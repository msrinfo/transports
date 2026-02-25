<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Recibos de Facturas/Rectificativas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />


<script type="text/javascript">
function enviar(event)
{
var cod_empresa = document.getElementById('cod_empresa').value;
var cod_factura_ini = document.getElementById('cod_factura_ini').value;
var cod_factura_fin = document.getElementById('cod_factura_fin').value;

if (cod_factura_ini > cod_factura_fin || isNaN(cod_factura_ini) || isNaN(cod_factura_fin) || !cod_factura_ini || !cod_factura_fin)
	{
	alert("Valores incorrectos. Recuerde:\n - El código inicial no puede ser mayor que el código final.\n - Ninguno de ellos ha de estar vacío.");
	}
else
	{
	mostrar(event,'5_2_impr_recibos.php','cod_empresa',cod_empresa,'cod_factura_ini',cod_factura_ini,'cod_factura_fin',cod_factura_fin,'','','','','','','','','','','','','','');
	}
} // Fin de function

</script>
</head>

<body onKeyPress="tabular(event)">
<table>
<form name="form1" method="post" action="">
  <tr class="titulo"> 
    <td colspan="14">Recibos de Facturas/Rectificativas</td>
  </tr>
  <tr>
    <td width="5"></td>
    <td colspan="2"></td>
    <td width="4"></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Empresa:</td>
    <td>
      <select name="cod_empresa" id="cod_empresa">
        <? mostrar_lista("empresas",$cod_empresa); ?>
      </select>
	</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td width="409" align="right">N&ordm;  Inicial:</td>
    <td width="537">
	<input name="cod_factura_ini" type="text" id="cod_factura_ini" size="7" maxlength="6" onBlur="recibo_buscar_conta(event)">
    <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_ini');"></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">N&ordm;  Final:</td>
    <td>
	<input name="cod_factura_fin" type="text" id="cod_factura_fin" size="7" maxlength="6" onBlur="recibo_buscar_conta(event)">
    <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_fin');"></td>
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
      <input name="imprimir" type="button" id="imprimir" value="Ver" onClick="enviar(event)">
      <input name="nuevo" type="button" value="Nuevo" onClick="location.href=direccion_conta('');">
    </td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>