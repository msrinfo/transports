<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Desc&agrave;rregues</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_descarga=$_GET["cod_descarga"];
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$clasificacion=$_GET["clasificacion"];
$poblacion=$_GET["poblacion"];
$pobl=$poblacion;
}

if ($_POST)
{
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_descarga=$_POST["cod_descarga"];
$cod_desc=$cod_descarga;
$cod_empresa=$_POST["cod_empresa"];
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$ver=$_POST["ver"];
$clasificacion=$_POST["clasificacion"];
$poblacion=$_POST["poblacion"];
$pobl=$poblacion;
}


$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$descarg="";
if ($cod_descarga)
{
$descarg="$where cod_descarga = '$cod_descarga'";
$where="and";
}

if ($poblacion)
{
$descarg="$where descargas.poblacion like '%$poblacion%'";
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
	$orden="albaranes.cod_albaran,albaranes.fecha_descarga,albaranes.nombre_cliente"; 

else if ($clasificacion=="DATA") 
 	$orden="albaranes.fecha_descarga,albaranes.cod_albaran,albaranes.nombre_cliente"; 

else if ($clasificacion=="NOM")
	$orden="albaranes.nombre_cliente,albaranes.cod_albaran,albaranes.fecha_descarga";


// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes,descargas $cliente $descarg $empres $periodo $facturado $where albaranes.cod_descarga=descargas.cod_descarga";
//echo "<br />ALB: $albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_ord);
?>
</head>

<body>
<table>
<form name="resumen_ord" method="post" action="">
          <tr class="titulo"> 
            <td colspan="13">Albarans Desc&agrave;rregues</td>
          </tr>
          <tr>
            <td width="7">&nbsp;</td>
            <td colspan="4"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td colspan="3">&nbsp;</td>
            <td colspan="4" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
            <td width="25">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="97">&nbsp;</td>
            <td width="185" align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="4" align="right"><strong>Data inicial:</strong> <? echo "$fecha_i"; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="4" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="127"><strong>Albar&agrave;</strong></td>
            <td width="82"><strong>Data</strong></td>
            <td colspan="2"><strong>Client</strong></td>
            <td width="439"><strong>Desc&agrave;rrega</strong></td>
            <td width="141" align="right"><strong>Kms</strong></td>
            <td width="211" align="right"><strong>Lts. Servits </strong></td>
            <td width="170"><div align="right"><strong>Preu Client </strong></div></td>
            <td width="42">&nbsp;</td>
            <td width="144"><strong>Cond.</strong></td>
            <td width="172"><strong>Tarj.</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los albaranes mostrados:
$total_servidos=sel_campo("SUM(suma_servidos)","total_servidos","albaranes,descargas","$cliente $descarg $empres $periodo $facturado and albaranes.cod_descarga=descargas.cod_descarga");
$total_preuclient=sel_campo("SUM(albaranes.precio_cli)","precio_cli","albaranes,descargas","$cliente $descarg $empres $periodo $facturado and albaranes.cod_descarga=descargas.cod_descarga");
	
/*	
$suma_servidos="SELECT SUM(suma_servidos) as total_servidos
FROM albaranes,descargas
$cliente $descarg $empres $periodo $facturado and albaranes.cod_descarga = descargas.cod_descarga ";
	
$result_sum_serv=mysql_query($suma_servidos, $link);

while($albsumaserv=mysql_fetch_array($result_sum_serv))
{
$total_servidos+=$albsumaserv["total_servidos"];
}	
*/	
	
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

	
// calculamos kms totales	
$suma="SELECT albaranes.cod_albaran, albaranes.cod_descarga,albaranes.cod_empresa, SUM(descargas.total_kms) as suma_kms
FROM albaranes,descargas
$cliente $descarg $empres $periodo $facturado and albaranes.cod_descarga = descargas.cod_descarga ";
	
$result_sum=mysql_query($suma, $link);

while($albsuma=mysql_fetch_array($result_sum))
{
$suma_kms+=$albsuma["suma_kms"];
}
	

$albaranes="SELECT * FROM albaranes,descargas $cliente $descarg $empres $periodo $facturado $where albaranes.cod_descarga=descargas.cod_descarga ORDER BY $orden $limit";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$fecha_descarga=fecha_esp($ord["fecha_descarga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$cod_operario=$ord["cod_operario"];
$cod_tarjeta=$ord["cod_tarjeta"];
$base=$ord["base"];

$cod_descarga=$ord["cod_descarga"];

$precio_cli=$ord["precio_cli"];

$precio_cli=sel_campo("precio_cli","","albaranes","cod_albaran='$cod_albaran'");

$suma_servidos=$ord["suma_servidos"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
$total_kms=sel_campo("total_kms","","descargas","cod_descarga='$cod_descarga'");
}

if($cod_operario)
{
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

if($cod_tarjeta)
{
$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$mat2=sel_campo("mat2","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$matriculas=$mat1."-".$mat2;
}

?>
          <tr>
            <td>&nbsp;</td>
			<td class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></td>			
            <td><? echo "$fecha_descarga"; ?></td>
            <td colspan="2"><? echo "$cod_cliente"; ?> <? echo "$nombre_cliente"; ?></td>
            <td><? echo "$poblacion"; ?></td>
            <td align="right"><? echo "$total_kms"; ?></td>
            <td align="right"><? echo "$suma_servidos"; ?></td>
            <td><div align="right"><? echo "$precio_cli"; ?></div></td>
            <td>&nbsp;</td>
            <td><? echo "$nombre_op"; ?></td>
            <td><? echo "$matriculas"; ?></td>
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
  <td colspan="11"><hr /></td>
  <td>&nbsp;</td>
</tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right"><strong>Total Kms: <? echo formatear($suma_kms); ?></strong></td>
            <td align="right"><strong>Total Servits: <? echo formatear($total_servidos); ?></strong></td>
            <td align="right"><strong>Total Preu: <? echo formatear($total_preuclient); ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="11">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="poblacion"; $valor_pag[2]=$pobl;
$campo_pag[3]="cod_descarga"; $valor_pag[3]=$cod_desc;
$campo_pag[4]="fecha_ini"; $valor_pag[4]=$fecha_i;
$campo_pag[5]="fecha_fin"; $valor_pag[5]=$fecha_f;
$campo_pag[6]="ver"; $valor_pag[6]=$ver;
$campo_pag[7]="clasificacion"; $valor_pag[7]=$clasificacion;


// Paginamos:
paginar("paginar");
?>            <div align="right"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="11"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'3_3_impr_alb_descargas.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_descarga','<? echo "$cod_desc"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','poblacion','<? echo "$pobl"; ?>','','','','','','');">
			  <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='3_1_alb_descargas.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>