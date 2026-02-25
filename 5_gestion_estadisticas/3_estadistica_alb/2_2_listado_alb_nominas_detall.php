<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans N&ograve;mines Detallat</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_operario=$_GET["cod_operario"];
$cod_oper=$cod_operario;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$clasificacion=$_GET["clasificacion"];
$detallado=$_GET["detallado"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_operario=$_POST["cod_operario"];
$cod_oper=$cod_operario;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$clasificacion=$_POST["clasificacion"];
$detallado=$_POST["detallado"];
}
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------




//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
	$empres="$where cod_empresa = '$cod_empresa'";
	$where="AND";
}

if ($cod_operario)
{
	$cliente="$where (cod_operario = '$cod_operario' or cod_operario2 = '$cod_operario')";
	// Si cliente está vacío, el contenido de la variable cambia:

	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario' ");
	
	$texto_operario="<strong>Conductor:</strong> $cod_operario $nombre_op";
}


if ($fecha_i || $fecha_f )
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

// Si no recibimos fecha_carga inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini' and fecha_carga <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_carga <= '$fecha_fin')";
}

$where="and";
} //FIN if (!$fecha_i && !$fecha_f)

// Establecemos el orden:
$orden="cod_operario, cod_operario2, fecha_carga, precio_chof";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 

$albaranes="SELECT COUNT(cod_albaran) as total_filas FROM albaranes $empres $cliente $periodo $num_iva";
//echo "<br /> $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $albaranes <br />");
$total=mysql_fetch_array($result_fact);
$total_filas=$total["total_filas"];



$toti=sel_campo("SUM(precio_chof) + SUM(prec_doble_carga_chof) + SUM(prec_doble_desc_chof)","toti","albaranes","$empres $cliente $periodo $num_iva ORDER BY cod_operario");


$cuenta="SELECT SUM(precio_chof) + SUM(prec_doble_carga_chof) + SUM(prec_doble_desc_chof) FROM albaranes $empres $cliente $periodo $num_iva ORDER BY cod_operario";
$result_cuenta=mysql_query($cuenta, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $albaranes <br />");
$tot=mysql_fetch_array($result_cuenta);

//echo "<br />toti: $toti";

/*$total=bcadd($total, $toti, 2);/*$tot_total=$total["tot_total"];
$totiv=$total["totiv"];
$totalb=$total["totalb"];*/
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
   <tr class="titulo"> 
       <td colspan="11">Albarans Nòmines Detallat</td>
   </tr>
   <tr>
    <td></td>
    <td colspan="4"><strong>Empresa: </strong><? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Data Inici: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td width="126" align="right"><div align="right"><strong>Resultats:<? echo "$total_filas"; ?></strong></div></td>
    <td></td>
   <tr>
     <td>&nbsp;</td>
     <td colspan="4"><? echo "$texto_operario"; ?></td>
     <td colspan="2"><div align="right"><strong>Data Final: </strong></div></td>
     <td colspan="2"><? echo $fecha_f; ?></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr> 
   <tr>
     <td>&nbsp;</td>
     <td colspan="9"><hr /></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td width="4"></td>
    <td width="54"><strong>Albarà</strong></td>
    <td width="56"><strong>Data C.</strong></td>
    <td width="189"><strong>Conductor</strong></td>
    <td width="80" align="left"><strong>Desc&agrave;rrega</strong></td>
    <td width="59" align="right">&nbsp;</td>
    <td width="59" align="right">&nbsp;</td>
    <td width="49" align="right">&nbsp;</td>
    <td width="202" align="left"><strong>Targeta</strong></td>
    <td align="right"><strong>Preu C/D.C./D.D. </strong></td>
    <td width="11"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="9"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?

//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $empres $cliente $periodo $num_iva ORDER BY $orden";
$result_albaranes=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");
$total_filas = mysql_num_rows($result_albaranes);



// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $empres $cliente $periodo $num_iva ORDER BY $orden  $limit";

$color="bgcolor='#F1F7EE'";

//echo "<br/>$albaranes";

$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");


//Contador para la primera vez que entra
$cont=0;

if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$cod_empresa=$alb["cod_empresa"];
$cod_operario=$alb["cod_operario"];
$cod_tarjeta=$alb["cod_tarjeta"];
$cod_tractora=$alb["cod_tractora"];

if($cod_operario)
{
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

$precio_chof=$alb["precio_chof"];
$prec_doble_carga_chof=$alb["prec_doble_carga_chof"];
$prec_doble_desc_chof=$alb["prec_doble_desc_chof"];

$cod_descarga=$alb["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
}

$cod_tarjeta=$alb["cod_tarjeta"];
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta = '$cod_tarjeta'");

$cod_tractora=$alb["cod_tractora"];
$mat2=sel_campo("mat2","","tractoras","cod_tractora = '$cod_tractora'");


$totcli="SELECT SUM(precio_chof) + SUM(prec_doble_carga_chof) + SUM(prec_doble_desc_chof) as toti FROM albaranes $empres $cliente $periodo $num_iva ORDER BY cod_operario";
//echo "<br /> totcli: $totcli <br />";
/*echo "<br /> total_cond: $total_cond <br />";*/
$result_cli=mysql_query($totcli, $link) or die ("<br /> No se han seleccionado totales de albaranes: ".mysql_error()."<br /> $totcli <br />");
$clie=mysql_fetch_array($result_cli);
$toti=$clie["toti"];


//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_cli!=$cod_operario)
{

$tot_cond=sel_campo("SUM(precio_chof) + SUM(prec_doble_carga_chof) + SUM(prec_doble_desc_chof)","","albaranes","$empres $periodo $num_iva $where cod_operario = '$cod_operario' ORDER BY cod_operario");
?>
  <tr <? echo "$color";?> >
    <td></td>
    <td></td>
    <td></td>
    <td width="189"><strong><? echo $cod_operario." ".$nombre_op; ?></strong></td>
    <td colspan="2" align="right"></td>
    <td align="right"></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><? echo formatear($tot_cond); ?></strong></td>
    <td></td>
  </tr>
<?
$cod_cli=$cod_operario;
$cont++;

} // Fin if($cod_cli!=$cod_operario)

?>
  <tr >
    <td></td>
     <td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
    <td><? echo "$fecha_carga"; ?></td>
    <td>&nbsp;</td>
    <td colspan="4" align="left"><? echo "$poblacion"; ?></td>
    <td align="left"><? echo $mat1."-".$mat2; ?></td>
    <td align="right"><? echo "$precio_chof"; if($prec_doble_carga_chof!=0) echo " + $prec_doble_carga_chof"; if($prec_doble_desc_chof!=0) echo " + $prec_doble_desc_chof"; ?></td>
    <td></td>
  </tr>
<?
$cont++;

} //Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)


// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="9">
<?
$campo_pag[1]="cod_operario"; $valor_pag[1]=$cod_oper;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="cod_empresa"; $valor_pag[4]=$cod_empr;
$campo_pag[5]="clasificacion"; $valor_pag[5]=$clasificacion;
$campo_pag[6]="detallado"; $valor_pag[6]=$detallado;



// Paginamos:
paginar("paginar");


?>	</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><? echo formatear($toti); ?></strong></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="9" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'2_3_impr_listado_alb_nominas_detall.php','cod_operario','<? echo "$cod_oper"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','cod_empresa','<? echo "$cod_empr"; ?>','clasificacion','<? echo "$clasificacion"; ?>','detallado','<? echo "$detallado"; ?>','','','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='2_1_alb_nominas_detall.php'"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>