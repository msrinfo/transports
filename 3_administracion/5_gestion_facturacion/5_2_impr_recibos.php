<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo de Factura</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


</head>

<body>
<table>
<?
$cod_empresa=$_GET["cod_empresa"];

// RECIBOS DE FACTURAS
$cod_factura_ini=$_GET["cod_factura_ini"];
$copia_ini=$cod_factura_ini;
$cod_factura_fin=$_GET["cod_factura_fin"];
$copia_fin=$cod_factura_fin;

//echo "INICIAL: $cod_factura_ini FINAL: $cod_factura_fin";

// RECIBOS MANUALES
$cod_factura=$_GET["cod_factura"];
$cod_fac=$cod_factura;
$fac_fecha=fecha_ing($_GET["fac_fecha"]);
$cod_cliente=$_GET["cod_cliente"];
$fac_total=$_GET["fac_total"];
$fecha_ven=fecha_ing($_GET["fecha_ven"]);
$num_cuenta=$_GET["num_cuenta"];
$n_cuenta=$num_cuenta;

//echo "<br /> $cod_factura <br /> $fac_fecha <br /> $cod_cliente <br /> $fac_total <br /> $fecha_ven <br /> $num_cuenta <br />";

if ($cod_empresa)
{
$empresa="WHERE cod_empresa = '$cod_empresa'";

conectar_base($base_datos_conta);
$emp=sel_sql("SELECT * FROM empresas $empresa");
conectar_base($base_datos);

$emp_poblacion=addslashes($emp[0]["poblacion"]);
}

// Si recibimos factura manual, adaptamos inicial y final:
if ($cod_fac)
{
$cod_factura_ini=$cod_fac;
$cod_factura_fin=$cod_fac;
}

// Seleccionamos facturas:
if ($cod_factura_ini && $cod_factura_fin)
{
for ($a=$cod_factura_ini; $a<=$cod_factura_fin; $a++)
{
// Si hemos recibido originalmente factura inicial y final, entonces mostramos recibos de facturas:
if ($copia_ini && $copia_fin)
{
$factura="SELECT * FROM facturas $empresa and cod_factura = '$a'";
//echo "<br /> $factura <br />";
$consulta_fac=mysql_query($factura, $link) or die ("<br /> No se han seleccionado facturas: ".mysql_error()."<br /> $factura <br />");

$fac=mysql_fetch_array($consulta_fac);

$cod_factura=$fac["cod_factura"];
$cod_empresa=$fac["cod_empresa"];
$fac_fecha=$fac["fac_fecha"];
$cod_cliente=$fac["cod_cliente"];
$fac_total=$fac["fac_total"];
$cod_forma=$fac["cod_forma"];
$cod_tipo=$fac["cod_tipo"];

for ($i=1; $i<=$num_vencis; $i++) 
{
$venci[$i]=$fac["venci".$i];
$imp_venci[$i]=$fac["imp_venci".$i];

}
} // Fin de if ($copia_ini && $copia_fin)


// Obtenemos los datos del cliente de la tabla clientes:
$select_cliente="SELECT * FROM clientes WHERE cod_cliente = '$cod_cliente'";
//echo "<br /> $select_cliente <br />";
$consulta_cli=mysql_query($select_cliente, $link) or die ("<br /> No se ha seleccionado cliente: ".mysql_error()."<br /> $select_cliente <br />");

$fila=mysql_fetch_array($consulta_cli);

$nombre_cliente=$fila["nombre_cliente"];
$razon_social=$fila["razon_social"];
$nif_cif=$fila["nif_cif"];

$domicilio=$fila["domicilio"];
$c_postal=$fila["c_postal"];
$poblacion=$fila["poblacion"];
$provincia=$fila["provincia"];

$domicilio_corresp=$fila["domicilio_corresp"];
$c_postal_corresp=$fila["c_postal_corresp"];
$poblacion_corresp=$fila["poblacion_corresp"];
$provincia_corresp=$fila["provincia_corresp"];

if ($domicilio_corresp=="")
{
$domicilio_corresp=$fila["domicilio"];
$c_postal_corresp=$fila["c_postal"];
$poblacion_corresp=$fila["poblacion"];
$provincia_corresp=$fila["provincia"];

$domicilio=$c_postal=$poblacion=$provincia="";
}

$telefono=$fila["telefono"];


// Si hemos recibido num_cuenta, lo conservamos. Si no, lo obtenemos de la consulta:
if (!$n_cuenta)
	$num_cuenta=$fila["num_cuenta"];


// Obtenemos la forma de pago de la tabla formas_pago:
//$forma_pago=sel_campo("descripcion","","formas_pago","cod_forma = '$cod_forma'");


// Si el recibo es manual, establecemos un solo vencimiento:
if ($cod_fac!="")
{
$venci=array();
$venci[1]=$fecha_ven;
$imp_venci[1]=$fac_total;
}
?>

<!-- Añado dos filas por encima para cuadrar los recibos a la página 
  <tr height="46px">  
    <td></td>
    <td colspan="8"></td>
    <td></td>
  </tr> -->
 
<?
// Generamos tantos recibos como vencimientos tenga la factura:
for ($i=1; $i<=$num_vencis; $i++)
{
//echo "<br /> cod_fac: $cod_fac <br /> venci[$i]: $venci[$i] <br />";
// Si existe vencimiento o es una rectificativa, mostramos recibo:
if ($venci[$i]!=0 || ($i == 1 && $cod_factura >= 500000 && $cod_factura < 900000))
{

// Copias por recibo:
for ($b=1; $b <2; $b++)
{
$salto="style='page-break-before:always'";
?>
  <tr style="height:1px;">
    <td width="1%"></td>
    <td colspan="8"><hr /></td>
    <td width="1%"></td>
  </tr>
  <tr width="26%" style="height:28px; vertical-align:bottom;">
    <td></td>
    <td><strong>Recibo n&ordm;:</strong><br />
    <? echo $cod_factura."&nbsp;&nbsp;&nbsp;(".$cod_empresa.")"; ?></td>
    <td colspan="6" class="recibo"><strong>Localidad de Expedici&oacute;n:</strong><br /><? echo $emp_poblacion; ?></td>
    <td width="25%" class="recibo"><strong>Importe &euro;:</strong><br />
    <? echo "#".formatear($imp_venci[$i])."#"; ?></td>
    <td></td>
  </tr>
  <tr style="height:30px; vertical-align:bottom">
    <td></td>
    <td class="recibo"><strong>Fecha de Expedici&oacute;n:</strong><br />
    <? echo fecha_esp($fac_fecha); ?></td>
    <td colspan="7" class="recibo"><strong>Vencimiento:</strong><br />
    <? echo fecha_esp($venci[$i]); ?></td>
    <td></td>
  </tr>
  <tr style="height:100px; vertical-align:middle; font-size:10px">
    <td></td>
    <td colspan="8" class="recibo"><strong>Pagar&aacute; usted al vencimiento expresado
    la cantidad de Euros:</strong><br /><? echo "#".num_a_letra($imp_venci[$i])."#"; ?></td>
    <td></td>
  </tr>
  <tr style="height:50px; vertical-align:middle">
    <td></td>
    <td colspan="8" class="recibo"><strong>en el domicilio de pago siguiente: </strong><? echo $num_cuenta; ?></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
  <tr style="height:88px; vertical-align:top; font-size:10px">
    <td></td>
    <td colspan="7" class="recibo">
	<strong>Nombre y Domicilio Pagador:</strong><br />
    <br /><? echo $nombre_cliente." (".$cod_cliente.")"; ?>
    <br /><? echo $razon_social; ?>
    <br /><? echo $domicilio_corresp; ?>
    <br /><? echo $c_postal_corresp." - ".$poblacion_corresp; ?>
    <br /><? echo $provincia_corresp; ?></td>
    <td align="right" valign="top"><strong><? //Tel&eacute;fono:</strong><? echo $telefono; ?></td>
    <td></td>
  </tr>
  <tr height="12px">  <!-- Si queremos que imprima un recibo por hoja: style="page-break-after:always" -->
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr> 
  <tr height="20px">  
    <td></td>
    <td colspan="8"></td>
    <td></td>
  </tr> 
<?
} // Fin de for ($b=1; $b <=2; $b++)
} // Fin de for ($i=1; $i<=$num_vencis; $i++)
} // Fin de if ($venci[$i]!=0)
} // Fin de for ($a=$cod_factura_ini; $a<=$cod_factura_fin; $a++)
} // Fin de if ($cod_factura_ini && $cod_factura_fin)
?>

</table>
</body>
</html>