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



// En principio la variable $facturado está vacía para mostrar todos los albaranes, pero según lo que valga $ver, mostrará los albaranes pendientes o facturados:
$facturado="";
if ($ver=="ENVIATS")
{
$facturado="$where enviado='si' ";
$where="and";
}
		
else if ($ver=="CONFIRMATS")
{
$facturado="$where confirmado='si'";
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
            <td colspan="17">Resum d'Albarans iCloud</td>
          </tr>
          <tr>
            <td width="2">&nbsp;</td>
            <td colspan="3"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td colspan="5" align="right"><strong>Data inicial:</strong> <? echo "$fecha_i"; ?></td>
            <td colspan="7" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
            <td width="38">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3"><? if($cod_factura){ echo "<strong>Factura:</strong> $cod_factura";}?></td>
            <td colspan="5" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
            <td colspan="7">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="15"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="62"><strong>Albar&agrave;</strong></td>
            <td width="92"><strong>Data</strong></td>
            <td width="288"><strong>Client</strong></td>
            <td width="337" align="left"><strong>Desc&agrave;rrega</strong></td>
            <td align="left"><strong>Conductor</strong></td>
            <td width="45" align="right">&nbsp;</td>
            <td width="134" align="left"><strong>Enviat</strong></td>
            <td width="89" align="left"><strong>Confirmat</strong></td>
            <td width="73" align="left">&nbsp;</td>
            <td width="111" align="left"><strong>Descarregat</strong></td>
            <td width="46" align="right">&nbsp;</td>
            <td width="68" align="right">&nbsp;</td>
            <td width="58" align="right">&nbsp;</td>
            <td width="61" align="right">&nbsp;</td>
            <td width="61" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="15"><hr /></td>
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
	
$cod_operario=$ord["cod_operario"];	
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");	
$cod_descarga=$ord["cod_descarga"];	
$nom_descarga=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
	
$enviado=$ord["enviado"];	
$confirmado=$ord["confirmado"];		
$descargado=$ord["descargado"];		

	if($enviado=='')
		$enviado='NO';
	if($confirmado=='')
		$confirmado='NO';
	if($descargado=='')
		$descargado='NO';	
	
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


 

?>
          <tr bgcolor="<? echo $color_fila; ?>">
            <td>&nbsp;</td>
			 <td bgcolor="<? echo $color_fila; ?>" class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
            <td><? echo "$fecha_descarga"; ?></td>
            <td><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
            <td align="left"><? echo "$cod_descarga"; ?> <? echo "$nom_descarga"; ?></td>
            <td width="261" align="left"><? echo "$cod_operario"; ?> <? echo "$nombre_op"; ?></td>
            <td align="right">&nbsp;</td>
            <td align="left"><?  echo "$enviado"; ?></td>
            <td align="left"><? echo "$confirmado"; ?></td>
            <td align="left">&nbsp;</td>
            <td align="left"><?  echo "$descargado"; ?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
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
  <td colspan="15"><hr /></td>
  <td>&nbsp;</td>
</tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="12" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="15">
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
            <td colspan="15"><div align="center">
           <!--   <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'2_3_impr_listado_alb.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_cliente','<? echo "$cod_cli"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','bomba','<? echo "$bomba"; ?>','','','','','','');">-->
			  <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='2_1_resumen_alb.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>