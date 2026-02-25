<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<?
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$cod_remesa=$_POST["cod_remesa"];
$ruta_descarga=$_POST["ruta_descarga"];

$salto_linea_win="\r\n";

// Descargamos archivo:
if ($ruta_descarga=='descargar')
{
$c=sel_sql("SELECT texto
FROM remesas
WHERE cod_empresa = '$cod_empresa' AND cod_remesa = '$cod_remesa'
ORDER BY cod_empresa,cod_remesa,cod_linea");

foreach ($c as $i => $v)
{
$a[$i]=$v['texto'];
//echo $i.': '.strlen($v['texto']).'<br />'.$v['texto'].'<br />';
} // Fin de foreach

$contenido=implode($salto_linea_win,$a);

/*
echo "CONT: TOTAL: ".strlen($contenido);
exit();*/
//$contenido=$a;

descargar_arch('remesa_'.$cod_remesa.'.txt',$contenido);
} // Fin de: Descargamos archivo.
} // Fin de if ($_POST)


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_remesa=$_GET["cod_remesa"];
$eliminar=$_GET["eliminar"];

//---------------------------------------------------------------------------------------------
//                                      ELIMINAR
//---------------------------------------------------------------------------------------------
// Si recibimos eliminar = 2, eliminamos:
if ($eliminar==2)
{
// Actualizamos cobros asociados a facturas:
$c=sel_sql("SELECT * FROM cobros WHERE cod_empresa = '$cod_empresa' AND cod_remesa = '$cod_remesa'");

foreach ($c as $i => $v)
{
$cod_cobro=$v['cod_cobro'];
$cod_cliente=$v['cod_cliente'];
$tabla=$v['tabla'];

// Eliminamos cobro:
mod_sql("DELETE FROM cobros WHERE cod_empresa = '$cod_empresa' AND cod_cobro = '$cod_cobro'");

// Eliminamos asiento de cobro:
eliminar_asiento("cobros",$cod_empresa,$cod_cobro);

// Actualizamos estado pago socio:
if ($tabla=='socios')
{
act_pago_socio($cod_cliente);
} // Fin de if

// Actualizamos servicio 1 jugador:
if ($tabla=='jugadores')
{
act_pago_jug($cod_cliente);
} // Fin de if
} // Fin de foreach

// Actualizamos facturas:
mod_sql("UPDATE facturas SET cod_remesa = '' WHERE cod_empresa = '$cod_empresa' AND cod_remesa = '$cod_remesa'");

// Eliminamos asiento de remesa:
conectar_base_i($base_datos_conta);
$cod_factura='REM '.sprintf("%06s", $cod_remesa);
$d=sel_sql("SELECT * FROM asientos WHERE cod_empresa = '$cod_empresa' AND txt_predef = 'DG' AND cod_factura = '$cod_factura'");
$cod_asiento=$d[0]['cod_asiento'];
mod_sql("DELETE FROM asientos WHERE cod_empresa = '$cod_empresa' AND cod_asiento = '$cod_asiento'");
mod_sql("DELETE FROM lin_asientos WHERE cod_empresa = '$cod_empresa' AND cod_asiento = '$cod_asiento'");
$cod_asiento='';
conectar_base_i($base_datos);

// Eliminamos remesa:
mod_sql("DELETE FROM remesas WHERE cod_empresa = '$cod_empresa' AND cod_remesa = '$cod_remesa'");

?>
<script type="text/javascript">
alert('Remesa <? echo $cod_remesa; ?> eliminada.');
</script>
<?
$cod_remesa=$cod_factura=$cod_cobro=$tabla=$cod_cliente='';
}
//---------------------------------------------------------------------------------------------
//                                      FIN DE: ELIMINAR
//---------------------------------------------------------------------------------------------
} // Fin de if ($_GET)
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Remesas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<script type="text/javascript">
function descargar_rem(cod_remesa)
{
document.getElementById('cod_remesa').value=cod_remesa;
document.getElementById('ruta_descarga').value='descargar';

document.forms[0].submit();

document.getElementById('cod_remesa').value=document.getElementById('ruta_descarga').value='';
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="9">Remesas</td>
          </tr>
          <tr> 
            <td width="1">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="77">&nbsp;</td>
            <td width="90">&nbsp;</td>
            <td width="471">&nbsp;</td>
            <td width="81">&nbsp;</td>
            <td width="84">&nbsp;</td>
            <td width="68">&nbsp;</td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><div align="left">Empresa:</div></td>
            <td colspan="3"><select name="cod_empresa" id="cod_empresa" onChange="location.href='?cod_empresa='+this.value">
              <? mostrar_lista("empresas",$cod_empresa); ?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><strong>N&ordm; Remesa</strong></td>
            <td><strong>F. Emisi&oacute;n</strong></td>
            <td><div align="right"><strong>Imp. Rem.</strong></div></td>
            <td>&nbsp;&nbsp;<strong>Concepto
                <input type="hidden" name="cod_remesa" id="cod_remesa" />
                <input type="hidden" name="ruta_descarga" id="ruta_descarga" />
            </strong></td>
            <td><div align="center"><strong>Ver Cobros</strong></div></td>
            <td><div align="center"><strong></strong></div></td>
            <td><div align="center"><strong>Eliminar</strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="7"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
if (!$cod_empresa)
{
$cod_empresa='01';
}

$sql="SELECT *
FROM remesas
WHERE cod_empresa = '$cod_empresa' AND cod_linea = 1
ORDER BY fecha_emision,cod_remesa";
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
$cod_remesa=$c[$i]['cod_remesa'];
$cod_linea=$c[$i]['cod_linea'];
$norma=$c[$i]['norma'];
$fecha_emision=$c[$i]['fecha_emision'];
$concepto=$c[$i]['concepto'];
$total_rem=$c[$i]['total_rem'];

$archivo='remesa'.$cod_remesa.'.txt';

//echo "$archivo";

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td>&nbsp;</td>
            <td><? echo $cod_remesa,' N',$norma; ?></td>
            <td><? echo fecha_esp($fecha_emision); ?></td>
            <td><div align="right"><? echo formatear($total_rem); ?></div></td>
            <td>&nbsp;&nbsp;<? echo substr($concepto, 0, 40); ?></td>
            <td><div align="center"><img src="/comun/imgs/listado.gif" onClick="mostrar(event,'03_04_rem_impr.php','cod_empresa','<? echo $cod_empresa; ?>','cod_remesa','<? echo $cod_remesa; ?>','','','','','','','','','','','','','','','','');"></div></td>
            <td><!--<div align="center"><img src="/comun/imgs/descargar.gif" title="Descargar" onClick="mostrar(event,'/<? echo $carpeta_comun.'/'.$carpeta_basicos; ?>/19_00_abrir_archivo.php','a','<? echo base64_encode('/'.$carpeta_datos.'/'.$archivo); ?>','','','','','','','','','','','','','','','','','','');"></div>--></td>
            <td><div align="center"><img src="/comun/imgs/eliminar2.gif" title="Eliminar" onClick="if(confirm('&iquest;Est&aacute; seguro de que desea borrar la remesa <? echo $cod_remesa; ?> de la empresa <? echo $cod_empresa; ?>?')) {enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','cod_remesa','<? echo $cod_remesa; ?>','eliminar','2','','','','','','','','','','','','','','')};"></div></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de for
?>
</form>
</table>
</body>
</html>