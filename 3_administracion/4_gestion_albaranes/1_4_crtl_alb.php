<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Control Dia</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?

if ($_POST)
{
$cod_albaran=$_POST["cod_albaran"];
$cod_empresa=$_POST["cod_empresa"];
$dia=$_POST["dia"];


$select_lin="SELECT DISTINCT cod_operario FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";
$query_lin=mysql_query($select_lin) or die ("<br /> No se ha seleccionado albarán: ".mysql_error()."<br /> $select_lin <br />");
$lin=mysql_fetch_array($query_lin);

$cod_operario=$lin["cod_operario"];
$cod_oper=$cod_operario;

}

//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_albaran=$_GET["cod_albaran"];
$cod_empresa=$_GET["cod_empresa"];
$dia=$_GET["dia"];


/*
echo "
<br /> cod_albaran: $cod_albaran
<br /> cod_empresa: $cod_empresa
<br /> dia: $dia
";*/


if ($cod_albaran)
{
$select_lin="SELECT * FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa' GROUP BY cod_operario";

$query_lin=mysql_query($select_lin) or die ("<br /> No se ha seleccionado albarán: ".mysql_error()."<br /> $select_lin <br />");

$lin=mysql_fetch_array($query_lin);

$cod_cliente=$lin["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
$precio_cli=$lin["precio_cli"];

$cod_operario=$lin["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");

$serv_blue=$lin["serv_blue"];
$serv_sp95=$lin["serv_sp95"]; 	
$serv_sp98=$lin["serv_sp98"];	
$serv_go_a=$lin["serv_go_a"];
$serv_go_a1=$lin["serv_go_a1"];
$serv_go_b=$lin["serv_go_b"];
$serv_go_c=$lin["serv_go_c"];
$serv_bio=$lin["serv_bio"];
} // Fin de if ($cod_albaran)
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN DE: GET
//--------------------------------------------------------------------------------------------


if (!$dia)
{
$dia_hoy=getdate();
$dia=$dia_hoy[mday].'-'.$dia_hoy[mon].'-'.$dia_hoy[year];
}
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_ambos[0]="cod_empresa";
ser_ambos[1]="cod_albaran";

ser_numero[0]="serv_blue";
ser_numero[1]="serv_sp95";
ser_numero[2]="serv_sp98";
ser_numero[3]="serv_go_a";
ser_numero[4]="serv_go_a1";
ser_numero[5]="serv_go_b";
ser_numero[6]="serv_go_c";
ser_numero[7]="serv_bio";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	
		if (event.target.id=="imprimir")
		{
	mostrar(event,'1_5_impr_crtl_alb.php','cod_empresa',cod_empresa.value,'dia',dia.value,'','','','','','','','','','','','','','','','');
		}
		else
		{
		document.forms[0].submit();
		}
	}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" id="form1" method="post" action="">
   <tr class="titulo"> 
       <td colspan="11">Control Dia Conductors </td>
  </tr>
   <tr>
     <td height="15" colspan="2">&nbsp;</td>
     <td width="71">&nbsp;</td>
     <td width="107">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
     <td width="48">&nbsp;</td>
     <td width="46">&nbsp;</td>
     <td width="59">&nbsp;</td>
     <td width="18">&nbsp;</td>
     <td width="60">&nbsp;</td>
    </tr>
   <tr>
    <td colspan="3">Empresa:
      <select name="cod_empresa" id="cod_empresa">
        <? mostrar_lista("empresas",$cod_empresa); ?>
      </select></td>
    <td>Dia:
      <input name="dia" title="Dia" type="text" id="dia" size="11" maxlength="10" value="<? echo $dia; ?>" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','form1','dia')"></td>
    <td colspan="2"><input name="ver" type="button" value="Veure" onClick="if (dia.value) {location.href=direccion_conta('?cod_empresa='+cod_empresa.value+'&dia='+dia.value)} else {alert('Introdueixi una data.');}">
      <input name="reset" type="button" value="Nou" onClick="location.href=direccion_conta('')"></td>
    <td colspan="3" align="center"><img src="/comun/imgs/imprimir.gif" title="Imprimir" name="imprimir" id="imprimir" onClick="enviar(event)" onMouseOver="window.top.focus();"><br />
Imprimir</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="11"><hr /></td>
    </tr>
  <tr>
    <td width="55"><strong>Ch&oacute;fer</strong></td>
    <td width="81"><strong>Albar&agrave;</strong></td>
    <td><strong>Client</strong></td>
    <td><div align="right"></div></td>
    <td width="98" align="right"><strong>Lts. Serv</strong> </td>
    <td width="75" align="right"><strong>Preu Cond.</strong></td>
    <td align="right"><strong>DCarga</strong></td>
    <td align="right"><strong>D Desc</strong></td>
    <td align="right"><strong>Des Bom </strong></td>
    <td>&nbsp;</td>
    <td><strong>Total</strong></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
<?
if ($cod_empresa && $dia)
{
$dia=fecha_ing($dia);

$cont_oper==0;

// SELECCIONAR LOS DIFERENTES CLIENTES QUE HAY Y LUEGO RESTARLO EN EL CONTADOR DE FILAS:
$cuenta="SELECT DISTINCT cod_operario FROM albaranes WHERE cod_empresa = '$cod_empresa' and (fecha_carga = '$dia' or fecha_descarga = '$dia') ORDER BY cod_operario";
$result_cuenta=mysql_query($cuenta, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");

while($ba=mysql_fetch_array($result_cuenta))
{
$cod_operario=$ba["cod_operario"];


// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

$mostrar_art="SELECT * FROM albaranes WHERE cod_empresa = '$cod_empresa' and (fecha_carga = '$dia' or fecha_descarga = '$dia') and cod_operario='$cod_operario' ORDER BY cod_operario $limit";

$result_fact=mysql_query($mostrar_art, $link) or die ("<br /> No se han seleccionado alb: ".mysql_error()."<br /> $mostrar_art <br />");


//Contador para la primera vez que entra
$cont=0;

if ($result_fact)
{
while($art=mysql_fetch_array($result_fact))
{
$cod_albaran=$art["cod_albaran"];
$cod_cliente=$art["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
$cod_operario=$art["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");
$precio_chof=$art["precio_chof"];
$suma_servidos=$art["suma_servidos"];

$prec_doble_carga_chof=$art["prec_doble_carga_chof"];
$prec_doble_desc_chof=$art["prec_doble_desc_chof"];
$prec_desc_bomba_chof=$art["prec_desc_bomba_chof"];

$total_precios=$precio_chof+$prec_doble_carga_chof+$prec_doble_desc_chof+$prec_desc_bomba_chof;

//$total_op+=$total_precios;
//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_oper!=$cod_operario)
{

/*$totcli="SELECT SUM(base) as total_op FROM albaranes WHERE cod_empresa = '$cod_empresa' and fecha_descarga = '$dia' and cod_operario='$cod_operario' ORDER BY cod_operario";
//echo "<br /> totcli: $totcli <br />";
$result_cli=mysql_query($totcli, $link) or die ("<br /> No se han seleccionado totales de albaranes: ".mysql_error()."<br /> $totcli <br />");

$clie=mysql_fetch_array($result_cli);

$total_op=$clie["total_op"];*/

?>
  <tr bgcolor="#F1F7EE">
    <td colspan="4"><strong><? echo $cod_operario." ".substr($nombre_op, 0, 20); ?></strong><strong></strong><strong></strong></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong><? echo $total_op; ?></strong></td>
  </tr>
<?
$cod_oper=$cod_operario;

$cont++;
} // Fin if($cod_cli!=$cod_cliente)

?>
  <tr >
    <td>&nbsp;</td>
    <td class="vinculo" onClick="mostrar(event,direccion_conta('1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
    <td colspan="2"><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
    <td align="right"><? echo formatear($suma_servidos); ?></td>
    <td align="right"><? echo formatear($precio_chof); ?></td>
    <td align="right"><? echo formatear($prec_doble_carga_chof); ?></td>
    <td align="right"><? echo formatear($prec_doble_desc_chof); ?></td>
    <td align="right"><? echo formatear($prec_desc_bomba_chof); ?></td>
    <td align="right">&nbsp;</td>
    <td><? echo formatear($total_precios); ?></td>
  </tr>
<?
} // Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)
} // Fin de if ($cod_empresa && $dia)
} // Fin de while($ba=mysql_fetch_array($result_cuenta))

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td colspan="11">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="dia"; $valor_pag[2]=fecha_esp($dia);

// Paginamos:
paginar("paginar");
?>	 </td>
    </tr>
  <tr>
    <td colspan="11" align="center">&nbsp;</td>
  </tr>
</form>
</table>
</body>
</html>