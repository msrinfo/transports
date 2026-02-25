<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Dietes</title>
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
$prec_dieta=$_GET["prec_dieta"];
$prec_diet=$prec_dieta;
$dies_reals=$_GET["dies_reals"];
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
$prec_dieta=$_POST["prec_dieta"];
$prec_diet=$prec_dieta;
$dies_reals=$_POST["dies_reals"];

}
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------


if($prec_dieta=="")
	{
	$prec_dieta=0;
	}


//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";

if ($cod_operario)
{
	$cliente="$where cod_operario = '$cod_operario'";
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
$orden="cod_operario, fecha_carga";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 
$albaranes="SELECT COUNT(cod_albaran) as total_filas FROM albaranes $cliente $empres $periodo $num_iva";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $albaranes <br />");
$total=mysql_fetch_array($result_fact);
$total_filas=$total["total_filas"];

// Obtenemos suma de dias por conductor de todos los conductores:
//$fechas="SELECT DISTINCT(fecha_carga) FROM albaranes $cliente $empres $periodo $num_iva";
$fechas="SELECT COUNT(DISTINCT(fecha_carga)) AS cli_dias FROM albaranes $cliente $empres $periodo $num_iva GROUP BY cod_operario";
$result_fechas=mysql_query($fechas, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");

while ($ft=mysql_fetch_assoc($result_fechas))
{
$fechas_tot += $ft["cli_dias"];
}
//echo "<br />fechas_tot $fechas_tot <br />";
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
   <tr class="titulo"> 
       <td colspan="12">Albarans Dietes</td>
   </tr>
   <tr>
    <td></td>
    <td colspan="4"><strong>Empresa: </strong><? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Data Inici: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td colspan="2" align="right"><div align="right"><strong>Resultats:</strong> <? echo $total_filas; ?></div></td>
    <td></td>
   <tr>
     <td>&nbsp;</td>
     <td colspan="4"><strong>Conductor:</strong> <? echo $cod_operario." ".$nombre_op; ?></td>
     <td colspan="2"><div align="right"><strong>Data Final: </strong></div></td>
     <td colspan="2"><? echo $fecha_f; ?></td>
     <td colspan="2">&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td><strong>Dies:</strong> <? echo $fechas_tot; ?></td>
     <td>&nbsp;</td>
     <td><strong>Preu:</strong> <? echo $prec_dieta; ?> &euro; </td>
     <td><strong>Total:</strong> <? echo formatear($fechas_tot * $prec_diet); ?> &euro;</td>
     <td colspan="2"><strong>Reals:</strong> <? echo $dies_reals; ?></td>
     <td colspan="2">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
     <td>&nbsp;</td>
   </tr> 
   <tr>
     <td>&nbsp;</td>
     <td colspan="10"><hr /></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td width="4"></td>
    <td width="53"><strong>Albarà</strong></td>
    <td width="57"><strong>Data</strong></td>
    <td width="120">&nbsp;</td>
    <td width="142" align="left"><strong>Desc&agrave;rrega</strong></td>
    <td width="60" align="right">&nbsp;</td>
    <td width="60" align="right">&nbsp;</td>
    <td width="51" align="right">&nbsp;</td>
    <td width="34" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td width="9"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="10"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $cliente $empres $periodo $num_iva ORDER BY $orden $limit";

$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");


if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$cod_empresa=$alb["cod_empresa"];
$cod_operario=$alb["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");


$precio_chof=$alb["precio_chof"];
$cod_descarga=$alb["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
}



//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_cli!=$cod_operario)
{
$totcli="SELECT COUNT(DISTINCT(fecha_carga)) AS cli_dias FROM albaranes $cliente $empres $periodo $num_iva $where cod_operario = '$cod_operario' ORDER BY cod_operario";

/*
echo "<br /> totcli: $totcli <br />";
*/
$result_cli=mysql_query($totcli, $link) or die ("<br /> No se han seleccionado totales de albaranes: ".mysql_error()."<br /> $totcli <br />");

$clie=mysql_fetch_array($result_cli);

$cli_dias=$clie["cli_dias"];

$total_dies = $dies_reals - $cli_dias;

/*echo "reals $dies_reals<br/>";
echo "$total_dies<br/>";*/
?>
  <tr bgcolor="#F1F7EE">
    <td></td>
    <td colspan="3"><? echo $cod_operario." ".$nombre_op; ?></td>
    <td>&nbsp;</td>
    <td colspan="3"><div align="right"><? echo $cli_dias; ?> dies * <? echo $prec_dieta; ?> € = <? echo formatear($cli_dias * $prec_dieta); ?> €</div></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td></td>
  </tr>
<?
$cod_cli=$cod_operario;
} // Fin if($cod_cli!=$cod_operario)
?>
  <tr >
    <td></td>
     <td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');">
<? echo $cod_albaran; ?></td>
     
    <td><? echo "$fecha_carga"; ?></td>
    <td>&nbsp;</td>
    <td colspan="5" align="left"><? echo "$poblacion"; ?></td>
    <td width="70" align="right">&nbsp;</td>
    <td width="52" align="right">&nbsp;</td>
    <td></td>
  </tr>
<?
} //Fin while($alb=mysql_fetch_array($result_fact))
} // Fin de if ($result_fact)


// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="10">
<?
$campo_pag[1]="cod_operario"; $valor_pag[1]=$cod_oper;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="cod_empresa"; $valor_pag[4]=$cod_empr;
$campo_pag[5]="prec_dieta"; $valor_pag[5]=$prec_diet;
$campo_pag[6]="fechas_tot"; $valor_pag[6]=$fechas_tot;

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
    <td colspan="2" align="right">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'4_3_impr_dietas.php','cod_operario','<? echo "$cod_oper"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','cod_empresa','<? echo "$cod_empr"; ?>','clasificacion','<? echo "$clasificacion"; ?>','prec_dieta','<? echo $prec_diet; ?>','fechas_tot','<? echo "$fechas_tot"; ?>','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='4_1_alb_dietas.php'">
      <input name="exportar" type="button" value="Exportar" onClick="mostrar(event,'4_4_export_alb_dietas.php','cod_operario','<? echo "$cod_oper"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','cod_empresa','<? echo "$cod_empr"; ?>','clasificacion','<? echo "$clasificacion"; ?>','prec_dieta','<? echo $prec_diet; ?>','fechas_tot','<? echo "$fechas_tot"; ?>','dies_reals','<? echo $dies_reals; ?> ','','','','');""></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>