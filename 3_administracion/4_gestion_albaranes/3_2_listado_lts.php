<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Resum de Llitres</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_tarjeta=$_GET["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_GET["cod_tractora"];
$cod_tra=$cod_tractora;
$cod_empresa=$_GET["cod_empresa"];
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$ver=$_GET["ver"];
$ver_serv=$_GET["ver_serv"];
$clasificacion=$_GET["clasificacion"];
}

if ($_POST)
{
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_tarjeta=$_POST["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_POST["cod_tractora"];
$cod_tra=$cod_tractora;
$cod_empresa=$_POST["cod_empresa"];
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$ver=$_POST["ver"];
$ver_serv=$_POST["ver_serv"];
$clasificacion=$_POST["clasificacion"];
}


$where="WHERE";


// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";
if ($cod_cliente)
{
$cliente="$where cod_cliente = '$cod_cliente'";
$where="and";
}

if ($cod_tarjeta)
{
$tarjeta="$where cod_tarjeta = '$cod_tarjeta'";
$where="and";
}

if ($cod_tractora)
{
$tractora="$where cod_tractora = '$cod_tractora'";
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


// Si no recibimos fecha inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_carga BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_carga <= '$fecha_fin')";

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

if ($ver_serv=="DEMANATS")
{
$titulo="Lts. Demanats";
}
		
else if ($ver_serv=="SERVITS")
{
$titulo="Lts. Servits";
}

// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CODI")
	$orden="cod_albaran,fecha_carga,nombre_cliente"; 

else if ($clasificacion=="DATA") 
 	$orden="fecha_carga,cod_albaran,nombre_cliente"; 

else if ($clasificacion=="NOM")
	$orden="nombre_cliente,cod_albaran,fecha_carga";


// Realizamos la consulta: 
$albaranes="SELECT * FROM albaranes $cliente $tarjeta $tractora $empres $periodo $facturado";
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
            <td colspan="18">Resum de Llitres <? echo "$ver_serv"; ?></td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="5"><strong>Empresa:</strong> <? echo $cod_empresa." ".$nom_empresa; ?></td>
            <td colspan="5" align="right"><strong>Data inicial:</strong> <? echo "$fecha_i"; ?></td>
            <td colspan="2">&nbsp;</td>
            <td colspan="4" align="right"><strong>Resultats: <? echo "$total_filas"; ?></strong></td>
            <td width="1">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5" align="right"><strong>Data Final: </strong><? echo "$fecha_f"; ?></td>
            <td colspan="2">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="16"><hr /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><strong>Albar&agrave;</strong></td>
            <td><strong>Fotos</strong></td>
            <td width="176"><strong>Targeta</strong></td>
            <td width="171"><strong>Client</strong></td>
            <td width="126"><strong>Cond.</strong></td>
            <td width="214"><strong>Ope.</strong></td>
            <td width="140" align="right"><strong>ADITIVAT</strong>
            </td><td width="116" align="right"><strong>SP95</strong></td>
            <td width="115" align="right"><strong>SP98</strong></td>
            <td width="94" align="right"><strong>GO A </strong></td>
            <td width="104" align="right"><strong>B1000 </strong></td>
            <td width="82" align="right"><strong>GO B </strong></td>
            <td width="84" align="right"><strong>GO C </strong></td>
            <td width="55" align="right"><strong>BIO</strong></td>
            <td width="81" align="right"><strong>Total</strong></td>
            <td width="76" align="right"><strong>Red.</strong></td>
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
/*$total_lts=sel_campo("SUM($suma_lts)","","albaranes","$cliente $empres $periodo $facturado");*/

// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");


$albaranes="SELECT * FROM albaranes $cliente $tarjeta $tractora $empres $periodo $facturado ORDER BY $orden $limit";
//echo "<br />$albaranes";
$result_ord=mysql_query($albaranes, $link) or die ("No se han seleccionado órdenes: ".mysql_error()."<br /> $albaranes <br />");

while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$fecha_carga=fecha_esp($ord["fecha_carga"]);
$cod_cliente=$ord["cod_cliente"];
$nombre_cliente=$ord["nombre_cliente"];
$base=$ord["base"];
$cod_operadora=$ord["cod_operadora"];
$cod_operario=$ord["cod_operario"];
$cod_tarjeta=$ord["cod_tarjeta"];
$cod_tractora=$ord["cod_tractora"];
$foto=$ord["foto"];
$foto1=$ord["foto1"];
	
if ($ver_serv=="DEMANATS")
{
$blue=$ord["cant_blue"];
$sp95=$ord["cant_sp95"];
$sp98=$ord["cant_sp98"];
$goa=$ord["cant_go_a"];
$goa1=$ord["cant_go_a1"];
$gob=$ord["cant_go_b"];
$goc=$ord["cant_go_c"];
$bio=$ord["cant_bio"];
$titol="Demanats";
$suma_lts=$ord["suma_pedidos"];

// Obtenemos la suma de los litros pedidos:
$total_litros=sel_campo("SUM(suma_pedidos)","total_litros","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
	
	

}
else if ($ver_serv=="SERVITS")
{
$blue=$ord["serv_blue"];
$sp95=$ord["serv_sp95"];
$sp98=$ord["serv_sp98"];
$goa=$ord["serv_go_a"];
$goa1=$ord["serv_go_a1"];
$gob=$ord["serv_go_b"];
$goc=$ord["serv_go_c"];
$bio=$ord["serv_bio"];
$titol="Servits";
$suma_lts=$ord["suma_servidos"];
$serv_redon=$ord["serv_redon"];

// Obtenemos la suma de los litros servidos:
$total_litros=sel_campo("SUM(suma_servidos)","total_litros","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");

$total_litros_redon=sel_campo("SUM(serv_redon)","total_litros_redon","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
	
$total_blue=sel_campo("SUM(serv_blue)","total_blue","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_sp95=sel_campo("SUM(serv_sp95)","total_sp95","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_sp98=sel_campo("SUM(serv_sp98)","total_sp98","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_goa=sel_campo("SUM(serv_go_a)","total_goa","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_goa1=sel_campo("SUM(serv_go_a1)","total_goa1","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_gob=sel_campo("SUM(serv_go_b)","total_gob","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_goc=sel_campo("SUM(serv_go_c)","total_goc","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
$total_bio=sel_campo("SUM(serv_bio)","total_bio","albaranes","$cliente $tarjeta $tractora $empres $periodo $facturado");
	
	
}

if($cod_operadora)
$descripcion=sel_campo("descripcion","","operadoras","cod_operadora='$cod_operadora'");

if($cod_tarjeta){

$mat1=sel_campo("mat1","","tarjetas","cod_tarjeta='$cod_tarjeta'");
$mat2=sel_campo("mat2","","tarjetas","cod_tarjeta='$cod_tarjeta'");
}

if($cod_tractora){

$mat2=sel_campo("mat2","","tractoras","cod_tractora='$cod_tractora'");
}

if($cod_operario)
$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

?>
          <tr>
            <td>&nbsp;</td>
			 <td width="71"><span class="vinculo" onClick="mostrar(event,direccion_conta('1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','')";><? echo $cod_albaran; ?></span></td>
			 <td width="98"><? if ($foto) { ?>
               <span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta_data.'/fotos/'.$usuario_any.'/'.$foto; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo $foto; } if ($foto1) { ?> <br>
             <span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta_data.'/fotos/'.$usuario_any.'/'.$foto1; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo $foto1; }?></td>
            <td><? echo "$mat1 - $mat2"; ?></td>
            <td><? echo "$nombre_cliente"; ?></td>
            <td><? echo "$nombre_op"; ?></td>
            <td><? echo "$descripcion"; ?></td>
            <td align="right"><? echo "$blue"; ?></td>
            <td align="right"><? echo "$sp95"; ?></td>
            <td align="right"><? echo "$sp98"; ?></td>
            <td align="right"><? echo "$goa"; ?></td>
            <td align="right"><? echo "$goa1"; ?></td>
            <td align="right"><? echo "$gob"; ?></td>
            <td align="right"><div align="right">
			<? echo "$goc"; ?></div></td>
            <td align="right"><? echo "$bio"; ?></td>
            <td align="right"><? echo "$suma_lts"; ?></td>
            <td align="right"><? echo "$serv_redon"; ?></td>
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
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong><? echo $total_blue; ?></strong></td>
            <td align="right"><strong><? echo $total_sp95; ?></strong></td>
            <td align="right"><strong><? echo $total_sp98; ?></strong></td>
            <td align="right"><strong><? echo $total_goa; ?></strong></td>
            <td align="right"><strong><? echo $total_goa1; ?></strong></td>
            <td align="right"><strong><? echo $total_gob; ?></strong></td>
            <td align="right"><strong><? echo $total_goc; ?></strong></td>
            <td align="right"><strong><? echo $total_bio; ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td colspan="11">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td colspan="11"><div align="right"><strong>Total Lts: <? echo $total_litros; ?></strong> <strong> 
			<? if ($ver_serv=="SERVITS"){ ?>
			Total Red: <? echo $total_litros_redon; } ?></strong></div>
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="16"><?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="fecha_ini"; $valor_pag[3]=$fecha_i;
$campo_pag[4]="fecha_fin"; $valor_pag[4]=$fecha_f;
$campo_pag[5]="ver"; $valor_pag[5]=$ver;
$campo_pag[6]="clasificacion"; $valor_pag[6]=$clasificacion;
$campo_pag[7]="ver_serv"; $valor_pag[7]=$ver_serv;

$campo_pag[8]="cod_tarjeta"; $valor_pag[8]=$cod_tar;
$campo_pag[9]="cod_tractora"; $valor_pag[9]=$cod_tra;

// Paginamos:
paginar("paginar");
?></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="16"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'3_3_impr_listado_lts.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_cliente','<? echo "$cod_cli"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','ver','<? echo "$ver"; ?>','clasificacion','<? echo "$clasificacion"; ?>','ver_serv','<? echo "$ver_serv"; ?>','cod_tarjeta','<? echo $cod_tar; ?>','cod_tractora','<? echo $cod_tra; ?>','','');">
			  <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='3_1_resumen_lts.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>