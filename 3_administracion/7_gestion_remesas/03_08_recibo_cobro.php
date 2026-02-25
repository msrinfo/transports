<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo de Cobro</title>


<? echo $archivos; ?>
<link href='/comun/css/impresion_conta.css' rel='stylesheet' type='text/css' />


<style type="text/css">
<!--
.clase_datos_emp {font-size: 10px;
color: #56583F;
}
.Estilo5 {font-size: 10px; color: #56583F; font-weight: bold; }
-->
</style>
</head>

<body>
<table>
<?
$cod_empresa=$_GET["cod_empresa"];

// RECIBOS DE cobros
$cod_cobro_ini=$_GET["cod_cobro_ini"];
$copia_ini=$cod_cobro_ini;
$cod_cobro_fin=$_GET["cod_cobro_fin"];
$copia_fin=$cod_cobro_fin;

//echo "INICIAL: $cod_cobro_ini FINAL: $cod_cobro_fin";

if ($cod_empresa)
{
$empresa="WHERE cod_empresa = '$cod_empresa'";

conectar_base($base_datos_conta);
$emp=sel_sql("SELECT * FROM empresas $empresa");
conectar_base($base_datos);

$nom_empresa=addslashes($emp[0]["nom_empresa"]);
$emp_domicilio=addslashes($emp[0]["domicilio"]);
$emp_c_postal=$emp[0]["c_postal"];
$emp_poblacion=addslashes($emp[0]["poblacion"]);
$emp_provincia=addslashes($emp[0]["provincia"]);
$emp_nif_cif=$emp[0]["nif_cif"];
$emp_telefono=$emp[0]["telefono"];
$emp_fax=$emp[0]["fax"];
$emp_web=$emp[0]["web"];
$emp_email=$emp[0]["email"];
}

// Seleccionamos cobros:
if ($cod_cobro_ini && $cod_cobro_fin)
{
for ($a=$cod_cobro_ini; $a<=$cod_cobro_fin; $a++)
{
// Si hemos recibido originalmente factura inicial y final, entonces mostramos recibos de cobros:
if ($copia_ini && $copia_fin)
{
$factura="SELECT * FROM cobros $empresa and cod_cobro = '$a'";
//echo "<br /> $factura <br />";
$consulta_fac=mysql_query($factura, $link) or die ("<br /> No se han seleccionado cobros: ".mysql_error()."<br /> $factura <br />");

$fac=mysql_fetch_array($consulta_fac);

$cod_cobro=$fac["cod_cobro"];
$cod_empresa=$fac["cod_empresa"];
$tabla=$fac["tabla"];
$fecha_cobro=$fac["fecha_cobro"];
$cod_cliente=$fac["cod_cliente"];
$total_cobro=$fac["total_cobro"];
$desc_cobro=$fac["desc_cobro"];
} // Fin de if ($copia_ini && $copia_fin)

if ($tabla=='clientes')
{
$campo1="cod_cliente";
$campo2="nombre_cliente";
}

else if ($tabla=='socios')
{
$campo1="cod_socio";
$campo2="nombre_socio";
}

else if ($tabla=='jugadores')
{
$campo1="cod_jugador";
$campo2="nombre";
}

// Obtenemos los datos del cliente:
$select_cliente="SELECT * FROM $tabla WHERE $campo1 = '$cod_cliente'";
//echo "<br /> $select_cliente <br />";
$consulta_cli=mysql_query($select_cliente) or exit ("<br /> No se ha seleccionado cliente: ".mysql_error()."<br /> $select_cliente <br />");

$fila=mysql_fetch_array($consulta_cli);

$nombre_cliente=trim($fila[$campo2].' '.$fila['apellido1'].' '.$fila['apellido2']);
$razon_social=$fila["razon_social"];

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


// Establecemos un solo vencimiento:
$venci=array();
$venci[1]=$fecha_cobro;
$imp_venci[1]=$total_cobro;
$num_vencis=count($venci);
//echo "<br /> $venci[1]: ".$venci[1]." <br />";
// Generamos tantos recibos como vencimientos tenga la factura:
for ($i=1; $i<=$num_vencis; $i++)
{
//echo "<br /> cod_fac: $cod_fac <br /> venci[$i]: $venci[$i] <br />";
// Si existe vencimiento o es una rectificativa, mostramos recibo:
if ($venci[$i]!=0)
{
?>
  <tr>
    <td height="16"></td>
    <td colspan="8" align="right"><span class="recibo"><img src="/<? echo $carpeta; ?>/imgs/logo.png" style="height:135px;width:123px;" /></span></td>
    <td></td>
  </tr>
  <tr>
    <td width="1%" height="4"></td>
    <td colspan="8"><hr /></td>
    <td width="1%"></td>
  </tr>
  <tr>
    <td></td>
    <td width="26%" class="recibo"><strong>Recibo Cobro n&ordm;:</strong><br />
    <? echo $cod_cobro."&nbsp;&nbsp;&nbsp;(".$cod_empresa.")"; ?></td>
    <td colspan="6" class="recibo"><strong>Localidad de Expedici&oacute;n:</strong><br /><? echo $emp_poblacion; ?></td>
    <td width="25%" class="recibo"><strong>Importe &euro;:</strong><br />
    <? echo "#".formatear($total_cobro)."#"; ?></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td class="recibo"><strong>Fecha de Expedici&oacute;n:</strong><br />
    <? echo fecha_esp($fecha_cobro); ?></td>
    <td colspan="7" class="recibo">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8" class="recibo"><strong>Paga usted
    la cantidad de Euros:</strong><br /><? echo "#".num_a_letra($total_cobro)."#"; ?></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8" class="recibo"><strong>Por el siguiente concepto:</strong><br />
    <? echo $desc_cobro; ?></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="7" class="recibo"><strong>Nombre y Domicilio Pagador:</strong><br />
    <br /><? echo $nombre_cliente; ?>
    <br /><? echo $razon_social; ?>
    <br /><? echo $domicilio_corresp; ?>
    <br /><? echo $c_postal_corresp." - ".$poblacion_corresp; ?>
    <br /><? echo $provincia_corresp; ?></td>
    <td align="right" valign="top"><p><strong>Tel&eacute;fono:</strong><? echo $telefono; ?></p>
    <p align="left"><span class="Estilo5"><? echo $nom_empresa; ?></span><br />
      <span class="clase_datos_emp"> <? echo $emp_domicilio; ?> <br />
      <? echo $emp_c_postal." ".$emp_poblacion." (".$emp_provincia.")"; ?> <br />
Telf: <? echo $emp_telefono; ?>&nbsp;&nbsp;&nbsp;Fax: <? echo $emp_fax; ?> <br />
E-mail: <? echo $emp_email; ?>&nbsp;</span></p></td>
    <td></td>
  </tr>
  <tr style="page-break-after:always">
    <td></td>
    <td colspan="8"><hr /></td>
    <td></td>
  </tr>
<?
} // Fin de for ($i=1; $i<=$num_vencis; $i++)
} // Fin de if ($venci[$i]!=0)
} // Fin de for ($a=$cod_cobro_ini; $a<=$cod_cobro_fin; $a++)
} // Fin de if ($cod_cobro_ini && $cod_cobro_fin)
?>
</table>
</body>
</html>