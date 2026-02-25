<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resum d'Albarans</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_factura=$_GET["cod_factura"];
$cod_fact=$cod_factura;
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$clasificacion=$_GET["clasificacion"];
$bomba=$_GET["bomba"];
}

if ($_POST)
{
$cod_factura=$_POST["cod_factura"];
$cod_fact=$cod_factura;
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_empresa=$_POST["cod_empresa"];
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$ver=$_POST["ver"];
$clasificacion=$_POST["clasificacion"];
$bomba=$_POST["bomba"];
}


$where="WHERE";

// Si no recibimos cliente, dejamos la variable vacía:
$fact;
if ($cod_factura)
{
$fact="$where cod_factura = '$cod_factura'";
$where="and";
$orden="cod_albaran,fecha,nombre_cliente";
}


// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";
if ($cod_cliente)
{
$cliente="$where cod_cliente = '$cod_cliente'";
$where="and";
}

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
$empres="$where cod_empresa = '$cod_empresa'";
conectar_base($base_datos_conta);
$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa = '$cod_empresa'");
conectar_base($base_datos);
$where="and";
}


// Si no recibimos fecha_descarga inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_descarga BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_descarga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_descarga <= '$fecha_fin')";

$where="and";
}


if ($bomba=="SI")
{
$bomb="$where descarga_bomba = '1' ";
$where="and";
}
else if ($bomba=="NO")
{
$bomb="$where descarga_bomba = '' ";
$where="and";
}
else if ($bomba=="TOTS")
{
$bomb="";
$where="and";
}

// En principio la variable $facturado está vacía para mostrar todos los albaranes, pero según lo que valga $ver, mostrará los albaranes pendientes o facturados:
$facturado="";
if ($ver=="PENDENTS")
{
$facturado="$where estado like ''";
$where="and";
}
		
else if ($ver=="FACTURATS")
{
$facturado="$where estado like 'f'";
$where="and";
}


// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CODI")
	$orden="cod_albaran,fecha_descarga,nombre_cliente"; 

else if ($clasificacion=="DATA") 
 	$orden="fecha_descarga,cod_albaran,nombre_cliente"; 

else if ($clasificacion=="NOM")
	$orden="nombre_cliente,cod_albaran,fecha_descarga";



// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes $fact $cliente $empres $periodo $bomb $facturado";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>
</head>

<body>
<table>
<form name="resumen_ord" method="post" action="">
          <tr class="titulo"> 
            <td colspan="18">Resum d'Albarans</td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td colspan="6" align="right"><strong>Data inicial:</strong> <? echo "$fecha_i"; ?></td>
            <td colspan="7" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
            <td width="12">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><? if($cod_factura){ echo "<strong>Factura:</strong> $cod_factura";}?></td>
            <td colspan="6" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
            <td colspan="7">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="16"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="45"><strong>Albar&agrave;</strong></td>
            <td width="31"><strong>Data</strong></td>
            <td width="192"><strong>Client</strong></td>
            <td width="205" align="right"><strong>Red.</strong></td>
            <td colspan="2" align="right">&nbsp;</td>
            <td width="168" align="right"><strong>Servits</strong></td>
            <td width="54" align="right"><strong>Preu Cli </strong></td>
            <td width="46" align="right"><strong>A Fac.</strong> </td>
            <td width="53" align="right"><div align="right"><strong>Lts. D.B </strong></div></td>
            <td width="56" align="right"><strong>Des.B.Cli</strong></td>
            <td width="33" align="right"><strong>DCCli</strong></td>
            <td width="49" align="right"><strong>DDesCli</strong></td>
            <td width="42" align="right"><strong>Hores</strong></td>
            <td width="44" align="right"><strong>Preu H </strong></td>
            <td width="44" align="right"><strong>Base</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="16"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los albaranes mostrados:
$total_importe=sel_campo("SUM(base)","total_importe","albaranes","$fact $cliente $empres $periodo $bomb $facturado");

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$albaranes="SELECT * FROM albaranes $fact $cliente $empres $periodo $bomb $facturado ORDER BY $orden $limit";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$fecha_descarga=fecha_esp($ord["fecha_descarga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$precio_cli=$ord["precio_cli"];
$cod_tarjeta=$ord["cod_tarjeta"];
$cod_tractora=$ord["cod_tractora"];

/*$mat1=$ord["mat1"];
$mat2=$ord["mat2"];
*/

$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$mat2=sel_campo("mat2","","tarjetas","cod_tractora='$cod_tractora'");
/**/

$suma_servidos=$ord["suma_servidos"];
$a_cobrar=$ord["a_cobrar"];
$descarga_bomba=$ord["descarga_bomba"];
$lts_desc_bomba=$ord["lts_desc_bomba"];
$prec_desc_bomba_cli=$ord["prec_desc_bomba_cli"];
$prec_doble_carga_cli=$ord["prec_doble_carga_cli"];
$prec_doble_desc_cli=$ord["prec_doble_desc_cli"];

$serv_redon=$ord["serv_redon"];

$horas_espera=$ord["horas_espera"];
$prec_horas_espera=$ord["prec_horas_espera"];

$base=$ord["base"];



$serv_blue=$ord["serv_blue"];
$serv_sp95=$ord["serv_sp95"]; 	
$serv_sp98=$ord["serv_sp98"];	
$serv_go_a=$ord["serv_go_a"];
$serv_go_a1=$ord["serv_go_a1"];
$serv_go_b=$ord["serv_go_b"];
$serv_go_c=$ord["serv_go_c"];
$serv_bio=$ord["serv_bio"];

/*if($serv_blue != 0 || $serv_sp95 != 0 || $serv_sp98 != 0 || $serv_go_a != 0 || $serv_go_a1 != 0 || $serv_go_b != 0 || $serv_go_c != 0 || $serv_bio != 0)
{
//$color_fila="#E7FEE0";
$color_fila="#CCCCCC";
}*/

if($descarga_bomba == "1")
	$color_fila="#CCCCCC";
else
	$color_fila="";
 

?>
          <tr bgcolor="<? echo $color_fila; ?>">
            <td>&nbsp;</td>
			 <td bgcolor="<? echo $color_fila; ?>" class="vinculo" onClick="mostrar(event,direccion_conta('1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
            <td><? echo "$fecha_descarga"; ?></td>
            <td><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
            <td align="right"><? if($serv_redon!=0) echo "$serv_redon"; ?></td>
            <td width="119" align="right">&nbsp;</td>
            <td width="171" align="left"><? if($descarga_bomba=='1') echo "$cod_tarjeta $mat1 - $cod_tractora $mat2"; ?></td>
            <td align="right"><? echo "$suma_servidos"; ?></td>
            <td align="right"><? echo "$precio_cli"; ?>&nbsp;</td>
            <td align="right"><? echo "$a_cobrar"; ?></td>
            <td align="right"><div align="right"><? echo "$lts_desc_bomba"; ?></div></td>
            <td align="right"><? echo "$prec_desc_bomba_cli"; ?></td>
            <td align="right"><? echo "$prec_doble_carga_cli"; ?></td>
            <td align="right"><? echo "$prec_doble_desc_cli"; ?></td>
            <td align="right"><? echo "$horas_espera"; ?></td>
            <td align="right"><? echo "$prec_horas_espera"; ?></td>
            <td align="right"><? echo "$base"; ?></td>
            <td>&nbsp;</td>
          </tr>
<?
} // Fin de while($ord=mysql_fetch_array($result_ord))
} // Fin de if ($total_filas > 0)

// Rellenamos con filas:
paginar("rellenar");
?>
<tr>
  <td>&nbsp;</td>
  <td colspan="16"><hr /></td>
  <td>&nbsp;</td>
</tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="13" align="right"><strong>Total Import: <? echo formatear($total_importe); ?></strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="16">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="fecha_ini"; $valor_pag[3]=$fecha_i;
$campo_pag[4]="fecha_fin"; $valor_pag[4]=$fecha_f;
$campo_pag[5]="ver"; $valor_pag[5]=$ver;
$campo_pag[6]="clasificacion"; $valor_pag[6]=$clasificacion;

// Paginamos:
paginar("paginar");
?>            <div align="right"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="16"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'2_3_impr_listado_alb.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_cliente','<? echo "$cod_cli"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','bomba','<? echo "$bomba"; ?>','','','','','','');">
			  <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='2_1_resumen_alb.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>