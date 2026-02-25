<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Control Vehiculos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
if ($_GET)
{
$cod_cliente=$_GET["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_operario=$_GET["cod_operario"];
$cod_oper=$cod_operario;
$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$clasificacion=$_GET["clasificacion"];
$ver=$_GET["ver"];

$cod_tarjeta=$_GET["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_GET["cod_tractora"];
$cod_tra=$cod_tractora;
}

if ($_POST)
{
$cod_cliente=$_POST["cod_cliente"];
$cod_cli=$cod_cliente;
$cod_operario=$_POST["cod_operario"];
$cod_oper=$cod_operario;
$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$clasificacion=$_POST["clasificacion"];
$ver=$_POST["ver"];

$cod_tarjeta=$_POST["cod_tarjeta"];
$cod_tar=$cod_tarjeta;
$cod_tractora=$_POST["cod_tractora"];
$cod_tra=$cod_tractora;

}


$where="WHERE";


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



// Control periodo:
if ($fecha_i)
	$fecha_ini=fecha_ing($fecha_i);
	
if ($fecha_f)
	$fecha_fin=fecha_ing($fecha_f);


if ($fecha_i && $fecha_f)
	$periodo="$where (itv_mat1 >= '$fecha_ini' and itv_mat1 <= '$fecha_fin' || adr_mat1 >= '$fecha_ini' and adr_mat1 <= '$fecha_fin' || tacograf_mat1 >= '$fecha_ini' and tacograf_mat1 <= '$fecha_fin' || tarjet_mat1 >= '$fecha_ini' and tarjet_mat1 <= '$fecha_fin' || extint_mat1 >= '$fecha_ini' and extint_mat1 <= '$fecha_fin' || seguro_mat1 >= '$fecha_ini' and seguro_mat1 <= '$fecha_fin' || adr_rev_mat1 >= '$fecha_ini' and adr_rev_mat1 <= '$fecha_fin' || itv_mat2 >= '$fecha_ini' and itv_mat2 <= '$fecha_fin' || adr_mat2 >= '$fecha_ini' and adr_mat2 <= '$fecha_fin' || cbrac_mat2 >= '$fecha_ini' and cbrac_mat2 <= '$fecha_fin' || extint_mat2 >= '$fecha_ini' and extint_mat2 <= '$fecha_fin' || seguro_mat2 >= '$fecha_ini' and seguro_mat2 <= '$fecha_fin' || varilla_mat2 >= '$fecha_ini' and varilla_mat2 <= '$fecha_fin')";
	





// Dependiendo de la clasificación escogida, daremos cierto valor a la variable:
if ($clasificacion=="CÓDIGO")
	$orden="cod_tarjeta";



// Realizamos la consulta: 
$albaranes="SELECT * FROM tarjetas $tarjeta $tractora $periodo order by $orden";
//echo "<br /> $albaranes <br />";
$result_alb=mysql_query($albaranes, $link) or die("<br /> No se han consultado albaranes por operario: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_alb);
?>
</head>

<body>
<table>
<form name="resumen_alb" method="post" action="">
  <tr class="titulo"> 
       <td colspan="21">Control Vehiculos</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="right"><strong>Fecha Inicio:</strong> <? echo $fecha_i; ?></td>
    <td>&nbsp;</td>
    <td colspan="4"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="5"><strong>B&uacute;squeda:</strong> <? echo "$busqueda";?></td>
    <td>&nbsp;</td>
    <td colspan="3" align="right"><strong>Fecha Final:</strong> <? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="14"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td width="103"><strong>Tarjeta</strong></td>
    <td width="78"><strong>ITV</strong></td>
    <td width="94"><strong>ADR</strong></td>
    <td width="106"><strong>Tac&ograve;graf</strong></td>
    <td width="94"><strong>Tarjeta</strong></td>
    <td width="116"><strong>Extintor</strong></td>
    <td width="116"><strong>Seguro</strong></td>
    <td width="101"><strong>ADR Rev</strong></td>
    <td width="100"><strong>ITV2</strong></td>
    <td width="107"><strong>ADR2</strong></td>
    <td width="105" align="left"><strong>Cbrac</strong></td>
    <td width="79"><strong>Extintor</strong></td>
    <td width="87"><strong>Segur</strong></td>
    <td width="67"><strong>Varilla</strong></td>
    <td width="0"></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="14"><hr /></td>
    <td></td>
  </tr>
<?
if ($result_alb)
{
// Limitamos la consulta:
$lineas_mostrar=15;
$limit=paginar("limitar");

$albaranes="SELECT * FROM tarjetas $tarjeta $tractora $periodo order by $orden";

//echo "$albaranes";
$result_alb=mysql_query($albaranes, $link);

while($fila=mysql_fetch_array($result_alb))
{
$cod_tarjeta=$fila["cod_tarjeta"];

$gps=$fila["gps"];
$itv_mat1=$fila["itv_mat1"];
$adr_mat1=$fila["adr_mat1"];
$tacograf_mat1=$fila["tacograf_mat1"];
$tarjet_mat1=$fila["tarjet_mat1"];
$extint_mat1=$fila["extint_mat1"];
$seguro_mat1=$fila["seguro_mat1"];
$adr_rev_mat1=$fila["adr_rev_mat1"];

$itv_mat2=$fila["itv_mat2"];
$adr_mat2=$fila["adr_mat2"];
$cbrac_mat2=$fila["cbrac_mat2"];
$extint_mat2=$fila["extint_mat2"];
$seguro_mat2=$fila["seguro_mat2"];
$varilla_mat2=$fila["varilla_mat2"];

?>
  <tr>
    <td></td>
    <td><? echo $cod_tarjeta; ?></td>
    <td><? echo fecha_esp($itv_mat1); ?></td>
    <td><? echo fecha_esp($adr_mat1); ?></td>
    <td><? echo fecha_esp($tacograf_mat1); ?></td>
    <td><? echo fecha_esp($tarjet_mat1); ?></td>
    <td><? echo fecha_esp($extint_mat1); ?></td>
    <td><? echo fecha_esp($seguro_mat1); ?></td>
    <td><? echo fecha_esp($adr_rev_mat1); ?></td>
    <td><? echo fecha_esp($itv_mat2); ?></td>
    <td align="left"><? echo fecha_esp($adr_mat2); ?></td> 
    <td align="left"><? echo fecha_esp($cbrac_mat2); ?></td>
    <td><? echo fecha_esp($extint_mat2); ?></td>
    <td><? echo fecha_esp($seguro_mat2); ?></td>
    <td><? echo fecha_esp($varilla_mat2); ?></td>
    <td></td>
  </tr>
<?

}
} // Fin de if ($result_alb)

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td></td>
    <td colspan="14"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="9">
<?
$campo_pag[1]="cod_cliente"; $valor_pag[1]=$cod_cli;
$campo_pag[2]="fecha_ini"; $valor_pag[2]=$fecha_i;
$campo_pag[3]="fecha_fin"; $valor_pag[3]=$fecha_f;
$campo_pag[4]="cod_empresa"; $valor_pag[4]=$cod_empr;
$campo_pag[5]="cod_operario"; $valor_pag[5]=$cod_oper;
$campo_pag[6]="clasificacion"; $valor_pag[6]=$clasificacion;
$campo_pag[7]="ver"; $valor_pag[7]=$ver;

// Paginamos:
paginar("paginar");
?>	</td>
    <td colspan="5">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="14" align="center">
      <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="mostrar(event,'2_3_impr_control_vehiculos.php','<? echo $campo_pag[1]; ?>','<? echo $valor_pag[1]; ?>','<? echo $campo_pag[2]; ?>','<? echo $valor_pag[2]; ?>','<? echo $campo_pag[3]; ?>','<? echo $valor_pag[3]; ?>','<? echo $campo_pag[4]; ?>','<? echo $valor_pag[4]; ?>','<? echo $campo_pag[5]; ?>','<? echo $valor_pag[5]; ?>','<? echo $campo_pag[6]; ?>','<? echo $valor_pag[6]; ?>','<? echo $campo_pag[7]; ?>','<? echo $valor_pag[7]; ?>','','','','','','');">
      <input name="buscar" type="button" value="Nova Recerca" onClick="location.href='2_1_control_vehiculos.php'"></td>
    <td></td>
  </tr>
</form>
</table>
</body>
</html>