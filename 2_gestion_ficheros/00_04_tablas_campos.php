<?
// Establecemos tablas:
$tablas[0]="clientes";				$nombre_tablas[0]="Clientes";
$tablas[1]="proveedores";			$nombre_tablas[1]="Proveedores";
$tablas[2]="acreedores";			$nombre_tablas[2]="Acreedores";
$tablas[3]="formas_pago";			$nombre_tablas[3]="Formas de Pago";
$tablas[4]="tipos_pago";			$nombre_tablas[4]="Tipos de Pago";
$tablas[5]="personal";				$nombre_tablas[5]="Personal";
$tablas[6]="familias";				$nombre_tablas[6]="Familias";
$tablas[7]="operarios";				$nombre_tablas[7]="Conductores";
$tablas[8]="operadoras";			$nombre_tablas[8]="Operadoras";
$tablas[9]="tarjetas";				$nombre_tablas[9]="Tarjetas";
$tablas[10]="descargas";			$nombre_tablas[10]="Descargas";
$tablas[11]="tarifas";				$nombre_tablas[11]="Tarifas";
$tablas[12]="terminales";			$nombre_tablas[12]="Terminales";


if (strpos($ruta_script, "listados_basicos.php")===false)
{
$num_campos=4; // Nº de campos a mostrar en el listado.

$tabla=$_GET["tabla"];

//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
for ($i = 0; $i < count($tablas); $i++)
{
if ($tabla==$tablas[$i])
{
$fichero=$nombre_tablas[$i];

switch($i)
{
case 0:
$caja[0]="cod_cliente";				$desc_caja[0]="Codi Client";
$caja[1]="razon_social";			$desc_caja[1]="Raó Social";
$caja[2]="nombre_cliente";			$desc_caja[2]="Nom";
$caja[3]="nif_cif";					$desc_caja[3]="N.I.F.";
$caja[4]="domicilio";				$desc_caja[4]="Domicili";
$caja[5]="c_postal";				$desc_caja[5]="Codi Postal";
$caja[6]="poblacion";				$desc_caja[6]="Població";
$caja[7]="provincia";				$desc_caja[7]="Província";
$caja[8]="telefono";				$desc_caja[8]="Telèfon";
$caja[9]="tel_movil";				$desc_caja[9]="Tèl. Mòvil";
$caja[10]="fax";					$desc_caja[10]="Fax";
$caja[11]="web";					$desc_caja[11]="Web";
$caja[12]="email";					$desc_caja[12]="E-mail";
$caja[13]="num_cuenta";				$desc_caja[13]="C. Corrent";
$caja[14]="cod_forma";				$desc_caja[14]="Forma Pag.";
$caja[15]="cod_tipo";				$desc_caja[15]="Tipus Pag.";
$caja[16]="copias_fac";				$desc_caja[16]="Còpies x Fac.";
$caja[17]="dia_pago";				$desc_caja[17]="Dia Pagam.";
$caja[18]="dia_pago2";				$desc_caja[18]="2º Dia Pagam.";
$caja[19]="observaciones";			$desc_caja[19]="Observacions";

break;

case 1:
$caja[0]="cod_proveedor";			$desc_caja[0]="Codi Prov.";
$caja[1]="razon_social";			$desc_caja[1]="Raó Social";
$caja[2]="nombre_prov";				$desc_caja[2]="Nom";
$caja[3]="nif_cif";					$desc_caja[3]="N.I.F.";
$caja[4]="domicilio";				$desc_caja[4]="Domicili";
$caja[5]="c_postal";				$desc_caja[5]="Codi Postal";
$caja[6]="poblacion";				$desc_caja[6]="Població";
$caja[7]="provincia";				$desc_caja[7]="Província";
$caja[8]="telefono";				$desc_caja[8]="Telèfon";
$caja[9]="tel_movil";				$desc_caja[9]="Tèl. Mòvil";
$caja[10]="fax";					$desc_caja[10]="Fax";
$caja[11]="web";					$desc_caja[11]="Web";
$caja[12]="email";					$desc_caja[12]="E-mail";
$caja[13]="observaciones";			$desc_caja[13]="Observacions";
break;

case 2:
$caja[0]="cod_acreedor";			$desc_caja[0]="Codi Acred.";
$caja[1]="razon_social";			$desc_caja[1]="Raó Social";
$caja[2]="nombre_acre";				$desc_caja[2]="Nom";
$caja[3]="nif_cif";					$desc_caja[3]="N.I.F.";
$caja[4]="domicilio";				$desc_caja[4]="Domicili";
$caja[5]="c_postal";				$desc_caja[5]="Codi Postal";
$caja[6]="poblacion";				$desc_caja[6]="Població";
$caja[7]="provincia";				$desc_caja[7]="Província";
$caja[8]="telefono";				$desc_caja[8]="Telèfon";
$caja[9]="tel_movil";				$desc_caja[9]="Tèl. Mòvil";
$caja[10]="fax";					$desc_caja[10]="Fax";
$caja[11]="web";					$desc_caja[11]="Web";
$caja[12]="email";					$desc_caja[12]="E-mail";
$caja[13]="observaciones";			$desc_caja[13]="Observacions";
break;

case 3:
$caja[0]="cod_forma";				$desc_caja[0]="Forma Pag.";
$caja[1]="descripcion";				$desc_caja[1]="Descripció";
break;

case 4:
$caja[0]="cod_tipo";				$desc_caja[0]="Tipus Pag.";
$caja[1]="desc_tipo";				$desc_caja[1]="Descripció";
break;

case 5:
$caja[0]="cod_personal";			$desc_caja[0]="Codi Pers.";
$caja[1]="nombre";					$desc_caja[1]="Nom Pers.";
$caja[2]="nif_cif";					$desc_caja[2]="N.I.F.";
$caja[3]="domicilio";				$desc_caja[3]="Domicili";
$caja[4]="c_postal";				$desc_caja[4]="Codi Postal";
$caja[5]="poblacion";				$desc_caja[5]="Població";
$caja[6]="provincia";				$desc_caja[6]="Província";
$caja[7]="telefono";				$desc_caja[7]="Telèfon";
$caja[8]="tel_movil";				$desc_caja[8]="Tèl. Mòvil";
$caja[9]="fax";						$desc_caja[9]="Fax";
$caja[10]="web";					$desc_caja[10]="Web";
$caja[11]="email";					$desc_caja[11]="E-mail";
$caja[12]="num_cuenta";				$desc_caja[12]="C. Corrent";
$caja[13]="sueldo";					$desc_caja[13]="Sou";
$caja[14]="liquidacion";			$desc_caja[14]="Liquidació";
$caja[15]="contrato";				$desc_caja[15]="Contracte";
$caja[16]="contrato_venci";			$desc_caja[16]="Venc. Cont.";
$caja[17]="observaciones";			$desc_caja[17]="Observacions";
break;

case 6:
$caja[0]="cod_familia";				$desc_caja[0]="Código Fam.";
$caja[1]="descripcion";				$desc_caja[1]="Descripción";
$caja[2]="descuento";				$desc_caja[2]="Descuento";
break;

case 7:
$caja[0]="cod_operario";			$desc_caja[0]="Codi Cond.";
$caja[1]="nombre_op";				$desc_caja[1]="Nom Cond.";
$caja[2]="precio_hora";				$desc_caja[2]="Preu Hora";
break;

case 8:
$caja[0]="cod_operadora";			$desc_caja[0]="Codi Op.";
$caja[1]="descripcion";				$desc_caja[1]="Descripció";
break;

case 9:
$caja[0]="cod_tarjeta";				$desc_caja[0]="Codi Targ.";
$caja[1]="mat1";					$desc_caja[1]="Matricula 1";
$caja[2]="mat2";					$desc_caja[2]="Matricula 2";
break;

case 10:
$caja[0]="cod_descarga";			$desc_caja[0]="Codi Descàrrega";
$caja[1]="cod_cliente";				$desc_caja[1]="Codi Client";
$caja[2]="poblacion";				$desc_caja[2]="Població";
$caja[3]="precio_cli";				$desc_caja[3]="Preu Client";
$caja[4]="precio_chof";				$desc_caja[4]="Preu Xofer";
$caja[5]="usr_modif";				$desc_caja[5]="Usuari Modificació";
$caja[6]="fecha_modif";				$desc_caja[6]="Data Modificació";
$caja[7]="horas_descarga";			$desc_caja[7]="Hores";
$caja[8]="mts3";					$desc_caja[8]="Mts3";	
$caja[9]="total_kms";				$desc_caja[9]="Total Kms";		
$caja[10]="preu_total_viaje";		$desc_caja[10]="Preu Total viatge";			
$caja[11]="preu_km";				$desc_caja[11]="Preu/Km";			
break;

case 11:
$caja[0]="cod_tarifa";				$desc_caja[0]="Codi Tar.";
$caja[1]="desc_tarifa";				$desc_caja[1]="Descripció";
$caja[2]="salida";					$desc_caja[2]="Sortida";
$caja[3]="hora";					$desc_caja[3]="Hora";
$caja[4]="hora_espera";				$desc_caja[4]="Hores Espera";
$caja[5]="cabestrany";				$desc_caja[5]="Cabestrany";
$caja[6]="fuera_horas";				$desc_caja[6]="Fora Horas";
$caja[7]="kms";						$desc_caja[7]="kilòmetres";
$caja[8]="peajes";					$desc_caja[8]="Peatges";
$caja[9]="festivos";				$desc_caja[9]="Festius";
$caja[10]="aseguradora";			$desc_caja[10]="Asseguradora";
break;

case 12:
$caja[0]="cod_terminal";			$desc_caja[0]="Codi Term.";
$caja[1]="nombre_terminal";			$desc_caja[1]="Nom Term.";
$caja[2]="color";					$desc_caja[2]="Color";
break;
} // Fin de switch
} // Fin de if
} // Fin de for
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------

// Obtenemos descripciones:
if (strpos($ruta_script, "listados_impr.php")!==false)
{
for ($i = 0; $i < count($caja); $i++)
{
	for ($a = 0; $a < $num_campos; $a++)
	{
		if ($campo[$a]==$caja[$i])
			$desc_campo[$a]=$desc_caja[$i];
	} // Fin de for

	if ($orden==$caja[$i])
		$desc_orden=$desc_caja[$i];
} // Fin de for
} // Fin de: Si es archivo imprimir listado.
} // Fin de: Si no es archivo seleccionar tabla.
?>