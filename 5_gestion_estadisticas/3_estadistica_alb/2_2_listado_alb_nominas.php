<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans N&ograve;mines</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_empresa=$_GET["cod_empresa"];
$cod_operario=$_GET["cod_operario"];
$cod_op=$cod_operario;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_empresa=$_POST["cod_empresa"];
$cod_operario=$_POST["cod_operario"];
$cod_op=$cod_operario;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
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

if ($cod_operario)
{
	$cliente="$where cod_operario = '$cod_operario' or cod_operario2 = '$cod_operario' ";
	// Si cliente está vacío, el contenido de la variable cambia:
	$where="AND";
	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
	$empres="$where cod_empresa = '$cod_empresa'";
	$where="AND";
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
$orden="cod_operario, precio_chof";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


$albaranes="
SELECT cod_operario, precio_chof, prec_doble_carga_chof, prec_doble_desc_chof, COUNT(precio_chof) as num_alb 
FROM albaranes 
$cliente $empres $periodo $num_iva
GROUP BY cod_operario, precio_chof, prec_doble_carga_chof, prec_doble_desc_chof";

//echo "<br />albaranes: $albaranes<br />";

$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

$total_filas=mysql_num_rows($result_fact);

while($alb=mysql_fetch_array($result_fact))
{
$precio_chof=$alb["precio_chof"];
$prec_doble_carga_chof=$alb["prec_doble_carga_chof"];
$prec_doble_desc_chof=$alb["prec_doble_desc_chof"];
$num_alb=$alb["num_alb"];

$total_alb += ($precio_chof * $num_alb) + ($prec_doble_carga_chof + $prec_doble_desc_chof);

}
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
   <tr class="titulo"> 
       <td colspan="10">Albarans N&ograve;mines</td>
   </tr>
   <tr>
    <td></td>
    <td colspan="3"><strong>Empresa: </strong><? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Data Inici: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td align="right"><div align="right"><strong>Resultats:</strong> <? echo $total_filas; ?></div></td>
    <td></td>
   <tr>
     <td>&nbsp;</td>
     <td colspan="3">&nbsp;</td>
     <td colspan="2"><div align="right"><strong>Data Final: </strong></div></td>
     <td colspan="2"><? echo $fecha_f; ?></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr> 
   <tr>
     <td>&nbsp;</td>
     <td colspan="8"><hr /></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td width="2"></td>
    <td width="110"><strong>Conductor</strong></td>
    <td width="221">&nbsp;</td>
    <td width="138" align="left"><div align="right"><strong>Total Conductor </strong></div></td>
    <td width="47">&nbsp;</td>
    <td width="99" align="left"><strong>Albarans</strong></td>
    <td align="left"><strong>P.C.</strong></td>
    <td align="left"><strong>P.D.</strong></td>
    <td width="128" align="right">&nbsp;</td>
    <td width="1"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  
<?
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$albaranes="
SELECT cod_operario, precio_chof, prec_doble_carga_chof, prec_doble_desc_chof, COUNT(precio_chof + prec_doble_carga_chof + prec_doble_desc_chof) as num_alb 
FROM albaranes 
$cliente $empres $periodo $num_iva
GROUP BY cod_operario, precio_chof, prec_doble_carga_chof, prec_doble_desc_chof
ORDER BY $orden 
$limit";

//echo "<br />albaranes: $albaranes<br />";

$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

$num_albaranes=mysql_num_rows($result_fact);


$cont_oper=0;
$cod_oper="";
while($alb=mysql_fetch_array($result_fact))
{
$cont_oper++;

$cod_operario=$alb["cod_operario"];

if ($cod_oper!=$cod_operario)
{
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");
$suma_alb=sel_campo("SUM(precio_chof + prec_doble_carga_chof + prec_doble_desc_chof)","","albaranes","$cliente $empres $periodo $num_iva $where cod_operario = '$cod_operario'");

//$total_alb +=$suma_alb;

$cod_oper=$cod_operario;
$color="#A8C695";
}

else
{
$cod_operario="";
$nombre_op="";
$suma_alb=0;
$color="";
}
$cod_albaran=$alb["cod_albaran"];
$precio_chof=$alb["precio_chof"];
$prec_doble_carga_chof=$alb["prec_doble_carga_chof"];
$prec_doble_desc_chof=$alb["prec_doble_desc_chof"];
$num_alb=$alb["num_alb"];
?>
  <tr>
    <td></td>
    <td bgcolor="<? echo $color; ?>" colspan="2"><? echo $cod_operario." ".$nombre_op; ?></td>
    <td bgcolor="<? echo $color; ?>" align="left"><div align="right">
      <? if ($suma_alb!=0) {echo $suma_alb;} ?>
    </div></td>
    <td bgcolor="" align="left">&nbsp;</td>
    <td align="left"><? echo $num_alb; ?> x <? echo $precio_chof; ?></td>
    <td width="75" align="left"><? if($prec_doble_carga_chof!=0) echo $prec_doble_carga_chof; ?></td>
    <td width="110" align="left"><? if($prec_doble_desc_chof!=0) echo $prec_doble_desc_chof; ?></td>
    <td align="right">&nbsp;</td>
    <td></td>
  </tr>
<?
} // Fin while($alb=mysql_fetch_array($result_fact))


// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="8">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_operario"; $valor_pag[2]=$cod_op;
$campo_pag[3]="fecha_ini"; $valor_pag[3]=$fecha_i;
$campo_pag[4]="fecha_fin"; $valor_pag[4]=$fecha_f;


// Paginamos:
paginar("paginar");
?>	</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="right"><strong>Total:</strong></td>
    <td><div align="right"><? echo formatear($total_alb); ?></div></td>
    <td>&nbsp;</td>
    <td colspan="3" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'2_3_impr_alb_nominas.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','','','','','','','','','','','','');">&nbsp;
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='2_1_alb_nominas.php'"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>