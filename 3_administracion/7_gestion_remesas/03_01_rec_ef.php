<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Recibos en Efectivo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?
//--------------------------------------------------------------------------------------------
//                                POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{

} // Fin de if ($_POST)
//--------------------------------------------------------------------------------------------
//                                FIN POST
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$tabla=$_GET["tabla"];

// Tabla:
if ($tabla=='clientes')
{
$campo1="cod_cliente";
$campo2="nombre_cliente";
}

else if ($tabla=='socios')
{
$campo1="cod_socio";
$campo2="nombre_socio";
}

else if ($tabla=='jugadores')
{
$campo1="cod_jugador";
$campo2="nombre";
}
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN GET
//--------------------------------------------------------------------------------------------
?>
<script type="text/javascript">
function sel(event)
{
/*
var e = document.getElementsByTagName('input');

var checked=false;
if (accion)
	checked=accion;
else if (event.target.checked==true)
	checked=true;

for (var i=0; i < e.length; i++)
{
	if (e[i].type=='checkbox')
	{
	e[i].checked=checked;
	} // Fin de if
} // Fin de for
//*/

var disp=obt_disp(event);

opener.document.getElementById('cod_factura').value=disp.value;
opener.document.getElementById('fac_total').value=document.getElementById('fac_total').value;
opener.document.getElementById('pagado').value=document.getElementById('pagado').value;
close();
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="9">Recibos en Efectivo</td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td width="37">&nbsp;</td>
            <td width="46">&nbsp;</td>
            <td width="81">&nbsp;</td>
            <td width="292">&nbsp;</td>
            <td width="311">&nbsp;</td>
            <td width="101">&nbsp;</td>
            <td width="103">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="left">Recibo</div></td>
            <td><div align="left">Fecha</div></td>
            <td><div align="left">Cliente</div></td>
            <td><div align="left">Concepto</div></td>
            <td><div align="right">Importe</div></td>
            <td><div align="right">Pagado</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="7"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
$sql="
SELECT facturas.*
FROM facturas,$tabla
WHERE facturas.cod_cliente = $tabla.$campo1 AND cod_empresa = '$cod_empresa'
AND facturas.cod_remesa = '' AND $tabla.num_cuenta = ''
ORDER BY fac_fecha,cod_factura";
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
$cod_factura=$c[$i]['cod_factura'];
$fac_fecha=$c[$i]['fac_fecha'];
$cod_cliente=$c[$i]['cod_cliente'];
$nombre_cliente=$c[$i]['nombre_cliente'];
$fac_total=$c[$i]['fac_total'];
$concepto=$c[$i]['concepto'];

$d=sel_sql("SELECT SUM(total_cobro) AS total_cobro FROM cobros WHERE cod_empresa = '$cod_empresa' AND cod_factura = '$cod_factura'");
$pagado=$d[0]['total_cobro'];
?>
          <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" value="<? echo $cod_factura; ?>" fac_total="<? echo $fac_total; ?>" pagado="<? echo $pagado; ?>" onClick="sel(event)"></td>
            <td><? echo $cod_factura; ?></td>
            <td><? echo fecha_esp($fac_fecha); ?></td>
            <td><? echo substr($cod_cliente.' '.$nombre_cliente, 0, 25); ?></td>
            <td><? echo substr($concepto, 0, 25); ?></td>
            <td><div align="right">
              <input type="text" name="fac_total" id="fac_total" title="Imp. Fac." size="13" maxlength="11" value="<? echo $fac_total; ?>" readonly="true" class="readonly">
            </div></td>
            <td><div align="right">
              <input type="text" name="pagado" id="pagado" title="Pagado" size="13" maxlength="11" value="<? echo $pagado; ?>" readonly="true" class="readonly">
            </div></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de for
?>
</form>
</table>
</body>
</html>