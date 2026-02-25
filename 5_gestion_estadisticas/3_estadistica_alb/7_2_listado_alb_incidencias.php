<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Incid&egrave;ncies</title>
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
$cod_empr=$cod_empresa;
$incidencias=$_GET["incidencias"];
$incid=$incidencias;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
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
$cod_empr=$cod_empresa;
$incidencias=$_POST["incidencias"];
$incid=$incidencias;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
}
//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------




//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";

if ($cod_empresa)
{
$empresa="$where cod_empresa = '$cod_empresa'";
$where="AND";
}


$inc="";
if ($incidencias)
{
	$inc="$where incidencias like '%$incidencias%'";
	$where="AND";
}else{
	
	$inc="$where incidencias!=''";
	$where="AND";
}


if ($fecha_i || $fecha_f )
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i && $fecha_f)
	$periodo="$where (fecha >= '$fecha_ini' and fecha <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha <= '$fecha_fin')";
}

$where="and";
} //FIN if (!$fecha_i && !$fecha_f)

// Establecemos el orden:
$orden="fecha,cod_albaran";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------


// OBTENEMOS TOTALES: 
$albaranes="SELECT * FROM albaranes $empresa $inc $periodo ORDER BY $orden";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");
$total_filas=mysql_num_rows($result_fact);

?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
   <tr class="titulo"> 
       <td colspan="12">Albarans Incid&egrave;ncies</td>
   </tr>
   <tr>
    <td></td>
    <td colspan="4"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
    <td colspan="2"><div align="right"><strong>Data Inici: </strong></div></td>
    <td colspan="2"><? echo $fecha_i; ?></td>
    <td colspan="2" align="right"><div align="right"><strong>Resultats:<? echo "$total_filas"; ?></strong></div></td>
    <td></td>
   <tr>
     <td>&nbsp;</td>
     <td colspan="4">&nbsp;</td>
     <td colspan="2"><div align="right"><strong>Data Final: </strong></div></td>
     <td colspan="2"><? echo $fecha_f; ?></td>
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
    <td width="65"><strong>Albar&agrave;</strong></td>
    <td width="86"><strong>Data</strong></td>
    <td width="200"><strong>Client</strong></td>
    <td colspan="2" align="left"><strong>Conductor</strong></td>
    <td colspan="5" align="left"><strong>Incid&egrave;ncia</strong></td>
    <td width="11"></td>
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
$albaranes="SELECT * FROM albaranes $empresa $inc $periodo ORDER BY $orden $limit";
//echo "<br />albaranes: $albaranes <br />";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");
$total_filas=mysql_num_rows($result_fact);

//Contador para la primera vez que entra
$cont=0;

if ($result_fact)
{
while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$cod_empresa=$alb["cod_empresa"];
$cod_operario=$alb["cod_operario"];
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
$cod_cliente=$alb["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente='$cod_cliente'");
$fecha=fecha_esp($alb["fecha_carga"]);
$incidencias=$alb["incidencias"];


?>
  <tr >
    <td></td>
     <td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>
     <td><? echo "$fecha"; ?></td>
     <td><? echo "$cod_cliente"; ?> <? echo substr($nombre_cliente,0,28); ?></td>
    <td colspan="2" align="left"><? echo "$cod_operario"; ?> <? echo "$nombre_op"; ?></td>
    <td colspan="5" align="left"><? echo "$incidencias"; ?></td>
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
    <td colspan="10">
<?
$campo_pag[1]="incidencias"; $valor_pag[1]=$incid;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="clasificacion"; $valor_pag[4]=$clasificacion;
$campo_pag[5]="empresa"; $valor_pag[5]=$empresa;




// Paginamos:
paginar("paginar");


?>	</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3"></td>
    <td width="100" align="right">&nbsp;</td>
    <td width="88" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td width="58" align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="10" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'7_3_impr_listado_alb_incidencias.php','cod_empresa','<? echo "$cod_empr"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','','','clasificacion','<? echo "$clasificacion"; ?>','incidencias','<? echo "$incid"; ?>','','','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='7_1_alb_incidencies.php'"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>