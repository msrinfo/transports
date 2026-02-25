<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Localizar Art&iacute;culos en &Oacute;rdenes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_articulo=$_GET["cod_articulo"];
$cod_art=$cod_articulo;
}

if ($_POST)
{
$cod_articulo=$_POST["cod_articulo"];
$cod_art=$cod_articulo;
}


// Si recibimos cod_articulo y/o descr_art:
$articulo="";
if ($cod_articulo)
{
$articulo="$where art_alb.cod_articulo = '$cod_articulo'";
$where="and";
}

else if ($descr_art)
{
$articulo="$where art_alb.descr_art like '%$descr_art%'";
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
	$periodo="$where (albaranes.fecha BETWEEN '$fecha_ini' AND '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (albaranes.fecha >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (albaranes.fecha <= '$fecha_fin')";

$where="and";
}
	
// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CÓDIGO")
	$orden="cod_articulo,descr_art";

else if ($clasificacion=="DESCRIPCIÓN")
	$orden="descr_art,cod_articulo";


// Especificamos la consulta: 
$articulos="SELECT art_alb.cod_articulo FROM art_alb,albaranes $cliente $empres $periodo AND art_alb.cod_albaran=albaranes.cod_albaran";
echo "<br />AR: $articulos <br />";

$result_art=mysql_query($articulos, $link) or die ("No se han seleccionado artículos: ".mysql_error()."<br /> $articulos <br />");

conectar_base($base_datos_conta);
$nom_empresa=sel_campo("nom_empresa","","empresas","cod_empresa='$cod_empresa'");
conectar_base($base_datos);
// Número de filas:
$total_filas = mysql_num_rows($result_art);
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post">
		  <tr class="titulo">
            <td colspan="9">Localizar Art&iacute;culos en &Oacute;rdenes y Entradas </td>
          </tr>
          <tr>
            <td width="4">&nbsp;</td>
            <td><strong>Empresa:</strong></td>
            <td colspan="3"><? echo "$cod_empresa - ";  echo "$nom_empresa";?></td>
            <td colspan="3"><div align="right"><strong>Total Art&iacute;culos: <? echo "$total_filas"; ?></strong></div></td>
            <td width="19">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="57"><strong>Orden</strong></td>
            <td width="61"><strong>Fecha</strong></td>
            <td width="166"><strong>Cliente</strong></td>
            <td width="148"><strong>Art&iacute;culo </strong></td>
            <td width="307"><strong>Descripci&oacute;n</strong></td>
            <td width="73"><div align="right"><strong>Cantidad</strong></div></td>
            <td width="100"><div align="right"><strong>Importe Neto </strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="7"><hr /></td>
            <td>&nbsp;</td>
          </tr>
<?
if ($total_filas > 0)
{
// Obtenemos la suma de los importes de los artículos mostrados:
$total_importe=sel_campo("SUM(neto)","total_importe","art_alb,albaranes","$cliente $empres $periodo AND art_alb.cod_albaran=albaranes.cod_albaran");

$lineas_mostrar=15;
$limit=paginar("limitar");


$articulos="SELECT art_alb.*,albaranes.fecha,albaranes.cod_cliente,albaranes.nombre_cliente FROM art_alb,albaranes $cliente $empres $periodo AND art_alb.cod_albaran=albaranes.cod_albaran ORDER BY $orden $limit";

$result_art=mysql_query($articulos, $link) or die ("No se han seleccionado artículos: ".mysql_error()."<br /> $articulos <br />");

while($art=mysql_fetch_array($result_art))
{
$cod_albaran=$art["cod_albaran"];
$cod_empresa=$art["cod_empresa"];
$fecha=fecha_esp($art["fecha"]);
$cod_cliente=$art["cod_cliente"];
$nombre_cliente=$art["nombre_cliente"];

$cod_articulo=$art["cod_articulo"];
$descr_art=$art["descr_art"];
$cantidad=$art["cantidad"];
$neto=$art["neto"];
?>
          <tr>
            <td>&nbsp;</td>
            <td><a href="javascript:mostrar(event,'1_1_albaranes.php','cod_albaran','<? echo "$cod_albaran"; ?>','cod_empresa','<? echo "$cod_empresa"; ?>','','','','','','','','','','','','','','','','');"><? echo "$cod_albaran"; ?>
			</a>			</td>
            <td><? echo "$fecha"; ?></td>
            <td><? echo $cod_cliente." ".substr($nombre_cliente, 0, 18); ?></td>
            <td><? echo "$cod_articulo"; ?></td>
            <td><? echo substr($descr_art, 0, 35); ?></td>
            <td><div align="right"><? echo "$cantidad"; ?></div></td>
            <td><div align="right"><? echo "$neto"; ?></div></td>
            <td>&nbsp;</td>
          </tr>
<?
} // while($art=mysql_fetch_array($result_art))
} // Fin de if ($total_filas > 0)

// Rellenamos con filas:
paginar("rellenar");
?>
<tr>
  <td>&nbsp;</td>
  <td colspan="7"><hr /></td>
  <td>&nbsp;</td>
</tr>

          <tr>
            <td>&nbsp;</td>
            <td colspan="5">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="cod_cliente"; $valor_pag[2]=$cod_cli;
$campo_pag[3]="cod_articulo"; $valor_pag[3]=$cod_art;
$campo_pag[4]="descr_art"; $valor_pag[4]=$descr_arti;
$campo_pag[5]="fecha_ini"; $valor_pag[5]=$fecha_i;
$campo_pag[6]="fecha_fin"; $valor_pag[6]=$fecha_f;
$campo_pag[7]="clasificacion"; $valor_pag[7]=$clasificacion;

// Paginamos:
paginar("paginar");
?>            </td>
            <td colspan="2"><div align="right"><strong>Total Importe: <? echo "$total_importe"; ?></strong></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="7"><div align="center">
              <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'3_3_impr_listado_art.php','cod_empresa','<? echo "$cod_empresa"; ?>','cod_articulo','<? echo "$cod_art"; ?>','descr_art','<? echo "$descr_arti"; ?>','cod_cliente','<? echo "$cod_cli"; ?>','fecha_ini','<? echo "$fecha_i"; ?>','fecha_fin','<? echo "$fecha_f"; ?>','tipo_iva','<? echo "$tipo_iva"; ?>','clasificacion','<? echo "$clasificacion"; ?>','','','','');">
              <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='3_1_art_alb.php'">
            </div></td>
            <td>&nbsp;</td>
          </tr>
</form>
</table>
</body>
</html>