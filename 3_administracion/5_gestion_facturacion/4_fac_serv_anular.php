<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Factures Serveis Anular</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />


<?
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$cod_factura_ini=$_POST["cod_factura_ini"];
$cod_factura_fin=$_POST["cod_factura_fin"];



for ($cod_factura=$cod_factura_ini; $cod_factura<=$cod_factura_fin; $cod_factura++)
{
// Comprobamos si la factura tiene cobros asociados:
$num_cobros=sel_campo("COUNT(cod_cobro)","alias","cobros","cod_empresa = '$cod_empresa' and cod_factura = '$cod_factura'");

// Si tiene uno o más cobros asociados, guardamos en matriz de facturas no eliminadas y saltamos al siguiente ciclo:
if ($num_cobros > 0)
{
$fac_no_elim[]=$cod_factura;
continue;

}



// Eliminamos la factura:
$borrar_fac="DELETE FROM facturas WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'";
//echo "<br /> $borrar_fac <br />";
$consulta_borrar=mysql_query($borrar_fac) or die ("No se ha eliminado la factura: ".mysql_error(). "<br /> $borrar_fac <br />");

// Actualizamos los servicios para que vuelvan a estar pendientes de facturar:
$actualizar_alb="UPDATE servicios SET cod_factura = '',estado = '' WHERE cod_factura = '$cod_factura' and cod_empresa = '$cod_empresa'";

$consulta_alb=mysql_query($actualizar_alb) or die ("No han pasado a pendientes: ".mysql_error(). "<br /> $actualizar_alb <br />");

// Eliminamos el asiento:
eliminar_asiento("facturas",$cod_empresa,$cod_factura);
} // Fin de for


if (count($fac_no_elim)==0)
{
?>
<script type="text/javascript">
alert("Facturas <? echo $cod_factura_ini; ?> a <? echo $cod_factura_fin; ?> de la empresa <? echo $cod_empresa; ?> anuladas.");
</script>
<?
} // Fin de: Si todas las facturas han sido eliminadas.

else
{
for ($j=0; $j < count($fac_no_elim); $j++)
{
$texto .= "\\n".sprintf("%06s", $fac_no_elim[$j]);
} // Fin de for

?>
<script type="text/javascript">
alert("Facturas de la empresa <? echo $cod_empresa; ?> NO eliminadas:<? echo $texto; ?>");
</script>
<?
} // Fin de: Si NO todas las facturas han sido eliminadas.

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
    <td colspan="11">Factures Serveis Anular</td>
  </tr>
  <tr>
    <td width="1">&nbsp;</td>
    <td width="143">&nbsp;</td>
    <td width="92">&nbsp;</td>
    <td width="76">&nbsp;</td>
    <td width="96">&nbsp;</td>
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
	<input name="cod_factura_ini" type="text" id="cod_factura_ini" size="6" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_ini.value,'cod_factura',cod_factura_ini.value,'cod_empresa',cod_empresa.value,'origen','S','','','','','','','fac_ini');">
        <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_factura_ini');"></td>
    <td><input name="fac_total_ini" type="text" id="fac_total_ini" size="12" maxlength="12" readonly="true" class="readonly"></td>
    <td><input name="fac_fecha_ini" type="text" id="fac_fecha_ini" size="11" maxlength="10" readonly="true" class="readonly"></td>
    <td width="202"><input name="nombre_cliente_ini" type="text" id="nombre_cliente_ini" size="40" maxlength="40" readonly="true" class="readonly"></td>
	 <td width="283" class="vinculo" onClick="mostrar(event,'/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/4_2_listado_serv.php','cod_factura',cod_factura_ini.value,'cod_empresa',cod_empresa.value,'','','','','','','','','','','','','','','','');">Veure Serveis</td>
     <td></td>
  </tr>
  <tr>
    <td></td>
    <td align="right">Factura Final:</td>
    <td><input name="cod_factura_fin" type="text" id="cod_factura_fin" size="6" maxlength="6" onBlur="buscar_conta(event,'facturas',cod_factura_fin.value,'cod_factura',cod_factura_fin.value,'cod_empresa',cod_empresa.value,'origen','S','','','','','','','fac_fin');">
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