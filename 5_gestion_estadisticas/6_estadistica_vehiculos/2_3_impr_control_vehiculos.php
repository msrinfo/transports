<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Resumen de Albaranes por Ch&oacute;feres</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


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
$cod_operadora=$_GET["cod_operadora"];
$cod_terminal=$_GET["cod_terminal"];
}


$where="WHERE";


$terminal="";
if ($cod_terminal)
{
$terminal="$where cod_terminal = '$cod_terminal'";
$where="and";
}

$operad="";
if ($cod_operadora)
{
$operad="$where cod_operadora = '$cod_operadora'";
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
	$orden="cod_tarjeta";


// Realizamos la consulta: 
$albaranes="SELECT * FROM tarjetas $tarjeta $tractora $periodo order by $orden";

//echo "<br /> $albaranes <br />";
$result_alb=mysql_query($albaranes, $link) or die("<br /> No se han consultado albaranes por operario: ".mysql_error()."<br /> $albaranes <br />");

// Número de filas:
$total_filas = mysql_num_rows($result_alb);


$lineas_pag=45; // Líneas a mostrar por página.
$cont=0; // Contador de líneas.
?>
</head>

<body>
<table>
<?
function cabecera()
{
global $cont,$lineas_pag,$total_filas,$cod_tarjeta,$cod_tractora,$fecha_i,$fecha_f,$busqueda;

// En caso de que superemos las líneas establecidas o sea la primera vez, mostramos cabecera:
if ($cont > $lineas_pag || $cont==0)
{
if ($cont > $lineas_pag)
	$salto="style='page-break-before:always;'";
?>
  <tr class="titulo" <? echo $salto; ?>>
    <td colspan="16">Control Vehiculos</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="5" align="right"><strong>Fecha Inicio:</strong><? echo $fecha_i; ?></td>
    <td colspan="6"><div align="right"><strong>Resultados:</strong> <? echo "$total_filas"; ?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><strong>B&uacute;squeda:</strong> <? echo "$busqueda";?></td>
    <td colspan="5" align="right"><strong>Fecha Final: </strong> <? echo $fecha_f; ?></td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="1%">&nbsp;</td>
    <td width="6%"><strong>Tarjeta</strong></td>
    <td width="6%"><strong>ITV</strong></td>
    <td width="8%"><strong>ADR</strong></td>
    <td width="8%"><strong>Tac&ograve;graf</strong></td>
    <td width="8%"><strong>Tarjeta</strong></td>
    <td width="8%"><strong>Extintor</strong></td>
    <td width="9%"><strong>Seguro</strong></td>
    <td width="9%"><strong>ADR Rev</strong></td>
    <td><strong>ITV2</strong></td>
    <td width="7%"><strong>ADR2</strong></td>
    <td width="6%"><strong>Cbrac</strong></td>
    <td width="6%"><strong>Extintor</strong></td>
    <td width="5%"><strong>Segur</strong></td>
    <td width="5%"><strong>Varilla</strong></td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
<?
$cont=0;
} // Fin de if ($cont > $lineas_pag || $cont==0)
} // Fin de function

// Mostramos cabecera por primera vez:
cabecera();


if ($result_alb)
{
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

$cont++;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td><? echo $cod_tarjeta; ?></td>
    <td><? echo fecha_esp($itv_mat1); ?></td>
    <td><? echo fecha_esp($adr_mat1); ?></td>
    <td><? echo fecha_esp($tacograf_mat1); ?></td>
    <td><? echo fecha_esp($tarjet_mat1); ?></td>
    <td><? echo fecha_esp($extint_mat1); ?></td>
    <td><? echo fecha_esp($seguro_mat1); ?></td>
    <td><? echo fecha_esp($adr_rev_mat1); ?></td>
    <td width="7%"><? echo fecha_esp($itv_mat2); ?></td>
    <td><? echo fecha_esp($adr_mat2); ?></td>
    <td><? echo fecha_esp($cbrac_mat2); ?></td>
    <td><? echo fecha_esp($extint_mat2); ?></td>
    <td><? echo fecha_esp($seguro_mat2); ?></td>
    <td><? echo fecha_esp($varilla_mat2); ?></td>
    <td>&nbsp;</td>
  </tr>
<?
$total += $importe;
}
} // Fin de if ($result_alb)


$cont+=2;
cabecera();
?>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="14"><hr /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>