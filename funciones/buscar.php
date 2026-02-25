<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Buscador General</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//-------------------- GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
/*echo "<script type='text/javascript'>alert('Entramos en GET.');</script>";*/

$direccion=$_GET["direccion"];
$tabla=$_GET["tabla"];
$buscar=$_GET["buscar"];
$senyal=$_GET["senyal"]; // Para realizar acciones específicas de algunos archivos.
$id_caja=$_GET["id_caja"];
$ver=$_GET["ver"]; // Para mostrar -o no- datos en albaranes.
$salvar=$_GET["salvar"];

$cod_cliente=$_GET["cod_cliente"];
$cod_proveedor=$_GET["cod_proveedor"];
$cod_acreedor=$_GET["cod_acreedor"];
$cod_forma=$_GET["cod_forma"];
$cod_tipo=$_GET["cod_tipo"];
$cod_familia=$_GET["cod_familia"];

$cod_descarga=$_GET["cod_descarga"];
$cod_tarjeta=$_GET["cod_tarjeta"];
$cod_tractora=$_GET["cod_tractora"];
$cod_terminal=$_GET["cod_terminal"];
$cod_operadora=$_GET["cod_operadora"];
$cod_conjunto=$_GET["cod_conjunto"];
$cod_tarifa=$_GET["cod_tarifa"];
$cod_servicio=$_GET["cod_servicio"];


$cod_personal=$_GET["cod_personal"];
$cod_operario=$_GET["cod_operario"];
$cod_operario2=$_GET["cod_operario2"];
$cod_articulo=$_GET["cod_articulo"];
$cod_albaran=$_GET["cod_albaran"];
$cod_entrada=$_GET["cod_entrada"];
$cod_empresa=$_GET["cod_empresa"];
$cod_compra=$_GET["cod_compra"];
$cod_factura=$_GET["cod_factura"];
$origen=$_GET["origen"];
$cod_ped_cli=$_GET["cod_ped_cli"];
$cod_ped_prov=$_GET["cod_ped_prov"];
$cod_usuario=$_GET["cod_usuario"];
$cod_presupuesto=$_GET["cod_presupuesto"];
$cod_cobro=$_GET["cod_cobro"];
$matricula=$_GET["matricula"];
$login=$_GET["login"];

include $carpeta_comun.'/'.$carpeta_basicos.'/30_01_var_get.php';
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: GET
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- POST
//--------------------------------------------------------------------------------------------
// Si recibimos una búsqueda desde la caja de texto "buscar", damos el mismo valor a las 2 variables:
if ($_POST)
{
/*echo "<script type='text/javascript'>alert('Entramos en POST.');</script>";*/

$direccion=$_POST["direccion"];
$buscar=$_POST["buscar"];
$id_caja=$_POST["id_caja"];
$salvar=$_POST["salvar"];

$cod_empresa=$_POST["cod_empresa"];
$cod_cliente="";
$cod_proveedor="";
$cod_acreedor="";
$cod_forma="";
$cod_tipo="";
$cod_familia="";
$cod_personal="";
$cod_operario="";
$cod_articulo="";
$cod_albaran="";
$cod_entrada="";
$cod_compra="";
$cod_factura="";
$origen="";
$cod_ped_cli="";
$cod_ped_prov="";
$cod_usuario="";
$cod_presupuesto="";
$cod_cobro="";
$matricula="";
$login="";
$cod_descarga="";
$cod_tarjeta="";
$cod_tractora="";
$cod_terminal="";
$cod_operadora="";
$cod_conjunto="";
$cod_tarifa="";
$cod_servicio="";

include $carpeta_comun.'/'.$carpeta_basicos.'/30_02_var_post.php';

if ($tabla=="articulos")
{
$cod_familia=$_POST["cod_familia"]; // Para buscar artículo por familia.
$cod_cliente=$_POST["cod_cliente"]; // Para cargar descuento familia.
}

if ($tabla=="descargas")
{
$cod_cliente=$_POST["cod_cliente"];
}

// Si queremos conservar la búsqueda de artículo por cliente, obtenemos cod_cliente:
if ($tabla=="operarios" && $salvar=="cod_operario2")
{
$cod_operario=$_POST["cod_operario2"];
$nombre_op2=$_POST["nombre_op2"];
}

} // Fin de if ($_POST)
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: POST
//--------------------------------------------------------------------------------------------



//--------------------------------------------------------------------------------------------
//-------------------- CASOS PARTICULARES SEGÚN LAS VARIABLES RECIBIDAS
//--------------------------------------------------------------------------------------------
if ($tabla=="operarios" && strpos($direccion, "1_1_albaranes.php")!==false)
{
$fecha_carga=fecha_ing($_GET["fecha_carga"]);
}
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: CASOS PARTICULARES SEGÚN LAS VARIABLES RECIBIDAS
//--------------------------------------------------------------------------------------------


/*

echo "
<br /> direccion: $direccion
<br /> buscar: $buscar
<br /> tabla: $tabla
<br /> senyal: $senyal
<br /> salvar: $salvar
<br /> cod_cliente: $cod_cliente
<br /> precio_cli: $precio_cli
<br /> precio_chof: $precio_chof
<br /> origen: $origen
";*/



//--------------------------------------------------------------------------------------------
//-------------------- CONFIGURACIONES SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------
// Buscar en la tabla CLIENTES:
if ($tabla=="clientes")
{
$descr_tabla="Clientes";

$nombre1="Nº Cliente";
$campo[1]="cod_cliente";

$nombre2="Razón Social";
$campo[2]="razon_social";

$nombre3="Nombre";
$campo[3]="nombre_cliente";

$nombre4="Teléfono";
$campo[4]="telefono";
//------------------------------
$campo[5]="tipo_iva";
$campo[6]="";
$campo[7]="";
$campo[8]="";
$campo[9]="";
$campo[15]="bloqueo";
$campo[16]="tel_movil";
//------------------------------

$orden="cod_cliente";

if ($buscar)
$condiciones="(cod_cliente = '$buscar' or razon_social like '%$buscar%' or nombre_cliente like '%$buscar%')";

if ($cod_cliente)
$condiciones="cod_cliente = '$cod_cliente'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla PROVEEDORES:
else if ($tabla=="proveedores")
{
$descr_tabla="Proveedores";

$nombre1="Nº Prov.";
$campo[1]="cod_proveedor";

$nombre2="Razón Social";
$campo[2]="razon_social";

$nombre3="Nombre";
$campo[3]="nombre_prov";

$nombre4="Teléfono";
$campo[4]="telefono";
//------------------------------
$campo[5]="cod_banco";
$campo[6]="nom_banco";

//------------------------------

$orden="cod_proveedor";

if ($buscar)
$condiciones="(cod_proveedor = '$buscar' or razon_social like '%$buscar%' or nombre_prov like '%$buscar%')";

if ($cod_proveedor)
$condiciones="cod_proveedor = '$cod_proveedor'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla ACREEDORES:
else if ($tabla=="acreedores")
{
$descr_tabla="Acreedores";

$nombre1="Nº Acre.";
$campo[1]="cod_acreedor";

$nombre2="Razón Social";
$campo[2]="razon_social";

$nombre3="Nombre";
$campo[3]="nombre_acre";

$nombre4="Teléfono";
$campo[4]="telefono";
//------------------------------
$campo[5]="cod_banco";
$campo[6]="nom_banco";
$campo[7]="tel_movil";
//------------------------------

$orden="cod_acreedor";

if ($buscar)
$condiciones="(cod_acreedor = '$buscar' or razon_social like '%$buscar%' or nombre_acre like '%$buscar%')";

if ($cod_acreedor)
$condiciones="cod_acreedor = '$cod_acreedor'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla FORMAS_PAGO:
else if ($tabla=="formas_pago")
{
$descr_tabla="Formas de Pago";

$nombre1="F. Pago";
$campo[1]="cod_forma";

$nombre2="Descripción";
$campo[2]="descripcion";
//------------------------------

$orden="cod_forma";

if ($buscar)
$condiciones="(cod_forma = '$buscar' or descripcion like '%$buscar%')";

if ($cod_forma)
$condiciones="cod_forma = '$cod_forma'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------


// Buscar en la tabla DESCARGAS:
else if ($tabla=="descargas")
{
$descr_tabla="Descargas";

$nombre1="Cod. Desc.";
$campo[1]="cod_descarga";

$nombre2="Precio Cli.";
$campo[2]="precio_cli";

$nombre3="Población";
$campo[3]="poblacion";

$nombre4="Cliente";
$campo[4]="cod_cliente";

$campo[5]="precio_chof";
$campo[6]="horas_descarga";
//------------------------------

$orden="cod_descarga";

if ($buscar)
$condiciones="(cod_descarga like '%$buscar%' or poblacion like '%$buscar%')";

if ($cod_cliente)
$condiciones="( (cod_descarga like '%$buscar%' or poblacion like '%$buscar%') and cod_cliente = '$cod_cliente')";

if ($cod_descarga)
$condiciones="cod_descarga = '$cod_descarga'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla TERMINALES:
else if ($tabla=="terminales")
{
$descr_tabla="Terminales";

$nombre1="Cod. Term.";
$campo[1]="cod_terminal";

$nombre2="Nombre";
$campo[2]="nombre_terminal";

$nombre3="Color";
$campo[3]="color";
//------------------------------

$orden="cod_terminal";

if ($buscar)
$condiciones="(cod_terminal = '$buscar' or nombre_terminal like '%$buscar%')";

if ($cod_terminal)
$condiciones="cod_terminal = '$cod_terminal'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------


// Buscar en la tabla OPERADORAS:
else if ($tabla=="operadoras")
{
$descr_tabla="Operadoras";

$nombre1="Cod. Op..";
$campo[1]="cod_operadora";

$nombre2="Descripción";
$campo[2]="descripcion";
//------------------------------

$orden="cod_operadora";

if ($buscar)
$condiciones="(cod_operadora = '$buscar' or descripcion like '%$buscar%')";

if ($cod_operadora)
$condiciones="cod_operadora = '$cod_operadora'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla CONJUNTOS:
else if ($tabla=="conjuntos")
{
$descr_tabla="Conjuntos";

$nombre1="Código";
$campo[1]="cod_conjunto";

$nombre2="Descripción";
$campo[2]="desc_conjunto";
//------------------------------

$orden="cod_conjunto";

if ($buscar)
$condiciones="(cod_conjunto = '$buscar' or desc_conjunto like '%$buscar%')";

if ($cod_conjunto)
$condiciones="cod_conjunto = '$cod_conjunto'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------


// Buscar en la tabla TARIFAS:
else if ($tabla=="tarifas")
{
$descr_tabla="Tarifas";

$nombre1="Código";
$campo[1]="cod_tarifa";

$nombre2="Descripción";
$campo[2]="desc_tarifa";

$nombre3="Salida";
$campo[3]="salida";

$nombre4="Hora";
$campo[4]="hora";

$campo[5]="hora_espera";
$campo[6]="cabestrany";
$campo[7]="fuera_horas";
$campo[8]="kms";
$campo[9]="peajes";
$campo[10]="festivos";
$campo[11]="aseguradora";
//------------------------------

$orden="cod_tarifa";

if ($buscar)
$condiciones="(cod_tarifa = '$buscar' or desc_tarifa like '%$buscar%')";

if ($cod_tarifa)
$condiciones="cod_tarifa = '$cod_tarifa'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------


// Buscar en la tabla SERVICIOS:
else if ($tabla=="servicios")
{
$descr_tabla="Serveis";


$campo[0]="cod_empresa";

$nombre1="Codi";
$campo[1]="cod_servicio";

$nombre2="Client";
$campo[2]="cod_cliente";

$nombre3="Data";
$campo[3]="fecha";

$nombre4="Vehicle";
$campo[4]="vehiculo";
//------------------------------
$campo[6]="matricula";
$campo[7]="hora_aviso";
$campo[8]="hora_llegada";
$campo[9]="pto_asistencia";
$campo[10]="cod_tarifa";
$campo[11]="estado";
$campo[12]="cod_factura";
//------------------------------

$orden="cod_servicio";

if ($buscar)
$condiciones="(cod_servicio = '$buscar' and cod_empresa = '$cod_empresa')";

if ($cod_servicio)
$condiciones="cod_servicio = '$cod_servicio' and cod_empresa = '$cod_empresa' ";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla CISTERNAS:
else if ($tabla=="cisternes")
{
$descr_tabla="Cisternes";

$nombre1="Cod.";
$campo[1]="cod_tarjeta";

$nombre2="Mat.1";
$campo[2]="mat1";

//------------------------------

$orden="cod_tarjeta";

if ($buscar)
$condiciones="(cod_tarjeta = '$buscar' or mat1 like '%$buscar%')";

if ($cod_tarjeta)
$condiciones="cod_tarjeta = '$cod_tarjeta'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla tractoras:
else if ($tabla=="tractoras")
{
$descr_tabla="Tractoras";

$nombre1="Cod.";
$campo[1]="cod_tractora";

$nombre2="Mat.2";
$campo[2]="mat2";
//------------------------------

$orden="cod_tractora";

if ($buscar)
$condiciones="(cod_tractora = '$buscar' or mat2 like '%$buscar%')";

if ($cod_tractora)
$condiciones="cod_tractora = '$cod_tractora'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla TARJETAS:
else if ($tabla=="tarjetas")
{
$descr_tabla="Tarjetas";

$nombre1="Cod.";
$campo[1]="cod_tarjeta";

$nombre2="Mat.1";
$campo[2]="mat1";

$nombre3="Tractora";
$campo[3]="cod_tractora";

$nombre4="Mat.2";
$campo[4]="mat2";
//------------------------------

$orden="cod_tarjeta";

if ($buscar)
$condiciones="(cod_tarjeta = '$buscar' or mat1 like '%$buscar%' or mat2 like '%$buscar%')";

if ($cod_tarjeta)
$condiciones="cod_tarjeta = '$cod_tarjeta'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla TIPOS_PAGO:
else if ($tabla=="tipos_pago")
{
$descr_tabla="Tipos de Pago";

$nombre1="Tipo Pago";
$campo[1]="cod_tipo";

$nombre2="Descripción";
$campo[2]="desc_tipo";
//------------------------------

$orden="cod_tipo";

if ($buscar)
$condiciones="(cod_tipo = '$buscar' or desc_tipo like '%$buscar%')";

if ($cod_tipo)
$condiciones="cod_tipo = '$cod_tipo'";
} // Fin de if ($tabla=="cod_tipo")
//--------------------------------------------------------------------------------------------

// Buscar en la tabla PERSONAL:
else if ($tabla=="personal")
{
$descr_tabla="Personal";

$nombre1="Código";
$campo[1]="cod_personal";

$nombre2="Nombre";
$campo[2]="nombre";

$nombre3="D.N.I.";
$campo[3]="nif_cif";

$nombre4="Teléfono";
$campo[4]="telefono";
//------------------------------
$campo[5]="tel_movil";
//------------------------------

$orden="cod_personal";

if ($buscar)
$condiciones="(cod_personal = '$buscar' or nombre like '%$buscar%')";

if ($cod_personal)
$condiciones="cod_personal = '$cod_personal'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla OPERARIOS:
else if ($tabla=="operarios")
{
$descr_tabla="Operarios";

$nombre1="Código";
$campo[1]="cod_operario";

$nombre2="Nombre";
$campo[2]="nombre_op";

$nombre3="P. Hora";
$campo[3]="precio_hora";
//------------------------------

$orden="cod_operario";

if ($buscar)
$condiciones="(cod_operario = '$buscar' or nombre_op like '%$buscar%')";

if ($cod_operario)
$condiciones="cod_operario = '$cod_operario'";

} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla USUARIOS:
else if ($tabla=="usuarios")
{
conectar_base($base_datos_comun);

$descr_tabla="Usuarios";

$nombre1="Login";
$campo[1]="login";

$nombre2="Password";
$campo[2]="password";
//------------------------------

$orden="login";

if ($buscar)
$condiciones="(login = '$buscar' or password like '%$buscar%')";

if ($login)
$condiciones="login = '$login'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla FAMILIAS:
else if ($tabla=="familias")
{
$descr_tabla="Familias";

$nombre1="Familia";
$campo[1]="cod_familia";

$nombre2="Descripción";
$campo[2]="descripcion";

$nombre3="% Dto.";
$campo[3]="descuento";
//------------------------------

$orden="cod_familia";

if ($buscar)
$condiciones="(cod_familia = '$buscar' or descripcion like '%$buscar%')";

if ($cod_familia)
$condiciones="cod_familia = '$cod_familia'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla ARTÍCULOS:
else if ($tabla=="articulos")
{
$descr_tabla="Artículos";

$nombre1="Cod. Art.";
$campo[1]="cod_articulo";

$nombre2="Descripción";
$campo[2]="descr_art";

$nombre3="P. Coste";
$campo[3]="precio_coste";

$nombre4="P. Venta";
$campo[4]="precio_venta";
//------------------------------
$campo[5]="ref_prov";
$campo[6]="desc_prov";
$campo[7]="cod_proveedor"; // Servirá para comprobar si un artículo pertenece a un proveedor.
$campo[8]="bulto";
$campo[9]="unidades_caja";
$campo[10]="existencias";
$campo[11]="precio_coste";
$campo[12]="descuento_art_prov";
$campo[13]="precio_coste_inicial";
$campo[14]="stock_min";
//------------------------------

$orden="descr_art, cod_articulo";

if ($buscar)
{
$condiciones="(cod_articulo like '$buscar%' or descr_art like '$buscar%')";

// Si especificamos una familia (han de ser 3 caracteres y números), buscamos por familia:
$cadena_buscar=strlen($buscar); //echo $cadena_buscar."<br />".ereg("[0-9]{3}", $buscar)."<br />";

if (($cadena_buscar == 3 && ereg("[0-9]{3}", $buscar)) || $cod_familia)
{// $condiciones="$where SUBSTRING(cod_articulo, 1, 3) = '$buscar'";
$condiciones="cod_familia = '$buscar'";
}
} // Fin de if ($buscar)

//$cadena_buscar=strlen($cod_articulo);
//if ($cod_articulo && $cadena_buscar != 3 && ereg("[0-9]{3}", $buscar)==false)
if ($cod_articulo && ($cadena_buscar != 3 || !ereg("[0-9]{3}", $buscar)))
$condiciones="cod_articulo = '$cod_articulo'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------
/*
// Buscar en la tabla DESCUENTOS:
else if ($tabla=="descuentos")
{
$descr_tabla="Descuentos";

$nombre1="Cliente";
$campo[1]="cod_cliente";

$nombre2="Familia";
$campo[2]="cod_familia";

$nombre3="Descuento";
$campo[3]="descuento";


$orden="cod_cliente";

if ($buscar)
$condiciones="(cod_cliente = '$buscar' or cod_familia like '$buscar' or descuento like '$buscar')";

if ($cod_familia)
$condiciones="cod_familia = '$cod_familia'";

if ($cod_cliente)
$condiciones="cod_cliente = '$cod_cliente'";

if (cod_cliente && $cod_familia)
$condiciones="cod_cliente = '$cod_cliente' and cod_familia = '$cod_familia'";
} // Fin de tabla*/
//--------------------------------------------------------------------------------------------

// Buscar en la tabla VEHICULOS:
else if ($tabla=="vehiculos")
{
$descr_tabla="Vehículos";

$nombre1="Matrícula";
$campo[1]="matricula";

$nombre2="Marca";
$campo[2]="marca";

$nombre3="Modelo";
$campo[3]="modelo";

$nombre4="Cliente";
$campo[4]="cod_cliente";
//------------------------------
$campo[5]="bastidor";
$campo[6]="kilometros";
//------------------------------

$orden="matricula";

if ($buscar)
$condiciones="(matricula = '$buscar' or marca like '%$buscar%' or modelo like '%$buscar%')";

if ($matricula)
$condiciones="matricula = '$matricula'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla ALBARANES:
else if ($tabla=="albaranes")
{
$descr_tabla="Albarans";

$campo[0]="cod_empresa";

$nombre1="Nº Alb.";
$campo[1]="cod_albaran";

$nombre2="Client";
$campo[2]="nombre_cliente";

$nombre3="Data Càrrega";
$campo[3]="fecha_carga";

$nombre4="Import";
$campo[4]="base";
//------------------------------
$campo[5]="cod_cliente";
$campo[6]="tipo_iva";
$campo[7]="estado";
$campo[8]="cod_descarga";
//$campo[9]="horas_descarga";
//------------------------------

$orden="cod_albaran";

if ($buscar)
$condiciones="(cod_albaran = '$buscar' or cod_cliente = '$buscar' or nombre_cliente like '%$buscar%')";

if ($cod_cliente)
$condiciones="cod_cliente = '$cod_cliente'";

if ($cod_albaran)
$condiciones="cod_albaran = '$cod_albaran'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla PRESUPUESTOS:
else if ($tabla=="presupuestos")
{
$descr_tabla="Presupuestos";

$campo[0]="cod_empresa";

$nombre1="Nº Pres.";
$campo[1]="cod_presupuesto";

$nombre2="Cliente";
$campo[2]="nombre_cliente";

$nombre3="Fecha";
$campo[3]="fecha";

$nombre4="Importe";
$campo[4]="total";
//------------------------------
$campo[5]="cod_cliente";
$campo[6]="neto_total";
$campo[7]="observaciones";
$campo[8]="referencia";
//------------------------------

$orden="cod_presupuesto";

if ($buscar)
$condiciones="(cod_presupuesto = '$buscar' or cod_cliente = '$buscar' or nombre_cliente like '%$buscar%')";

if ($cod_cliente)
$condiciones="cod_cliente = '$cod_cliente'";

if ($cod_presupuesto)
$condiciones="cod_presupuesto = '$cod_presupuesto'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla ENTRADAS:
else if ($tabla=="entradas")
{
$descr_tabla="Entradas";

$campo[0]="cod_empresa";

$nombre1="Nº Entr.";
$campo[1]="cod_entrada";

$nombre2="Proveedor";
$campo[2]="nombre_prov";

$nombre3="Fecha";
$campo[3]="fecha";

$nombre4="Importe";
$campo[4]="total";
//------------------------------
$campo[5]="cod_proveedor";
$campo[6]="tipo_iva";
$campo[8]="cod_empresa";
$campo[9]="cod_operario";
//------------------------------

$orden="cod_entrada";

if ($buscar)
$condiciones="(cod_entrada = '$buscar' or cod_proveedor = '$buscar' or nombre_prov like '%$buscar%')";

if ($cod_proveedor)
$condiciones="cod_proveedor = '$cod_proveedor'";

if ($cod_entrada)
$condiciones="cod_entrada = '$cod_entrada'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla COMPRAS:
else if ($tabla=="compras")
{
$descr_tabla="Compras";

$campo[0]="cod_empresa";

$nombre1="Cod. Compra";
$campo[1]="cod_compra";

$nombre2="Proveedor";
$campo[2]="nombre_prov";

$nombre3="Acreedor";
$campo[3]="nombre_acre";

$nombre4="Fecha";
$campo[4]="fecha";
//------------------------------
$campo[5]="cod_proveedor";
$campo[6]="cod_acreedor";
$campo[7]="cod_cuenta";
$campo[8]="total";
$campo[9]="importe_iva";
$campo[10]="tipo_iva";
$campo[11]="base";
//------------------------------

$orden="cod_compra DESC";

if ($buscar)
$condiciones="cod_compra LIKE '%$buscar%'";

if ($cod_compra)
$condiciones="cod_compra = '$cod_compra'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla FACTURAS:
else if ($tabla=="facturas" || $tabla=="rectificativas")
{
$descr_tabla="Facturas";

$campo[0]="cod_empresa";

$nombre1="Nº Fac.";
$campo[1]="cod_factura";

if ($tabla=="rectificativas")
	{
	$descr_tabla="Rectificativas";
	$nombre1="Nº Rect.";
	}

$nombre2="Cliente";
$campo[2]="nombre_cliente";

$nombre3="Fecha";
$campo[3]="fac_fecha";

$nombre4="Importe";
$campo[4]="fac_total";
//------------------------------
$campo[5]="cod_cliente";
$campo[6]="tipo_iva";
$campo[7]="origen";
//------------------------------

$orden="cod_factura";

if ($buscar)
$factura="(cod_factura = '$buscar' or cod_cliente = '$buscar' or nombre_cliente like '%$buscar%')";

if ($cod_cliente)
$factura="cod_cliente = '$cod_cliente'";

if ($origen)
$factura="origen = '$origen'";

if ($cod_factura)
$factura="cod_factura = '$cod_factura'";

if ($buscar || $cod_cliente || $origen || $cod_factura)
	$where="and";

if ($tabla=="facturas")
	$rectificativas="$where rectificado = ''";
else if ($tabla=="rectificativas")
	$rectificativas="$where rectificado != ''";

$condiciones="$factura $rectificativas";

// Buscamos en la tabla facturas:
$tabla="facturas";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla PEDIDOS CLIENTES:
else if ($tabla=="pedidos_cli")
{
$descr_tabla="Pedidos de Clientes";

$campo[0]="cod_empresa";

$nombre1="Nº Pedido";
$campo[1]="cod_ped_cli";

$nombre2="Cliente";
$campo[2]="nombre_cliente";

$nombre3="Fecha";
$campo[3]="fecha";

$nombre4="Importe";
$campo[4]="total";
//------------------------------
$campo[5]="cod_cliente";
$campo[6]="tipo_iva";
//------------------------------

$orden="cod_ped_cli";

if ($buscar)
$condiciones="(cod_ped_cli = '$buscar' or cod_cliente = '$buscar' or nombre_cliente like '%$buscar%')";

if ($cod_cliente)
$condiciones="cod_cliente = '$cod_cliente'";

if ($cod_ped_cli)
$condiciones="cod_ped_cli = '$cod_ped_cli'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla PEDIDOS PROVEEDORES:
else if ($tabla=="pedidos_prov")
{
$descr_tabla="Pedidos de Proveedores";

$campo[0]="cod_empresa";

$nombre1="Nº Pedido";
$campo[1]="cod_ped_prov";

$nombre2="Proveedor";
$campo[2]="nombre_prov";

$nombre3="Fecha";
$campo[3]="fecha";

$nombre4="Entrada";
$campo[4]="cod_entrada";
//------------------------------
//$campo[5]="neto_total";
//$campo[6]="tipo_iva";
//------------------------------

$orden="cod_ped_prov";

if ($buscar)
$condiciones="(cod_ped_prov = '$buscar' or cod_proveedor = '$buscar' or cod_ped_prov like '%$buscar%')";

if ($cod_proveedor)
$condiciones="cod_proveedor = '$cod_proveedor'";

if ($cod_ped_prov)
$condiciones="cod_ped_prov = '$cod_ped_prov'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

// Buscar en la tabla COBROS:
else if ($tabla=="cobros")
{
$descr_tabla="Cobros";

$campo[0]="cod_empresa";

$nombre1="Nº Cobro";
$campo[1]="cod_cobro";

$nombre2="Factura";
$campo[2]="cod_factura";

$nombre3="Fecha";
$campo[3]="fecha_cobro";

$nombre4="Importe";
$campo[4]="total_cobro";
//------------------------------
$campo[5]="cod_cliente";
$campo[6]="cod_cuenta";
//------------------------------

$orden="cod_cobro";

if ($buscar)
$condiciones="cod_cobro like '%$buscar%'";

if ($cod_cobro)
$condiciones="cod_cobro = '$cod_cobro'";
} // Fin de tabla
//--------------------------------------------------------------------------------------------

else
{
include $carpeta_comun.'/'.$carpeta_basicos.'/30_03_tablas.php';
}
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: CONFIGURACIONES SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------


// Si no hemos obtenido una búsqueda especial dentro de alguna tabla, establecemos $busqueda:
if (!$busqueda)
{
$condiciones=trim($condiciones); // Eliminamos los espacios en blanco del principio y el final.

// Si recibimos alguna condición o recibimos POST o visitamos una página, buscamos:
if ($condiciones!="" || $_POST || $_GET["pag_actual"])
{
// Si $condiciones no está vacía, añadimos la cláusula WHERE:
if ($condiciones!="")
	$condiciones = "WHERE ".$condiciones;

// Si la tabla no es independiente de la empresa, completamos la búsqueda según la empresa:
if ($campo[0]=="cod_empresa")
{
if ($condiciones!="")
	$condiciones .= " and cod_empresa = '$cod_empresa'";
else
	$condiciones = "WHERE cod_empresa = '$cod_empresa'";
}


$busqueda="SELECT * FROM $tabla $condiciones ORDER BY $orden"; // DESC
} // Fin de: Condiciones consulta buscador.
} // Fin de if (!$busqueda)


//echo "<br /> BÚSQUEDA: '$busqueda' <br /> CONDICIONES: '$condiciones' <br /> DIRECCIÓN: '$direccion' <br />";


// Si hemos recibido condiciones, buscamos:
if ($busqueda)
{
$consulta=mysql_query($busqueda, $link) or die ("<br /> No se ha realizado la búsqueda: ".mysql_error()."<br /> $busqueda <br />");
$total_filas=mysql_num_rows($consulta);
//echo " <br /> total_filas: $total_filas <br />";
?>
<script type='text/javascript'>
function enviar(num_filas,campo,valor,tabla,direccion,senyal,id_caja,cerrar)
{

// MOSTRAR ARGUMENTOS EN VENTANA:
var ver_campos="num_filas: '"+num_filas+"'\ntabla: '"+tabla+"'\ndireccion: '"+direccion+"'\nsenyal: '"+senyal+"'\nid_caja: '"+id_caja+"'\ncerrar: '"+cerrar+"'\ncampo.length: '"+campo.length+"'";

for (i = 0; i < campo.length; i++)
{
	if (campo[i]!="")
		ver_campos += "\ncampo["+i+"]: '"+campo[i]+"' = '"+valor[i]+"'\n";
}
/*alert(ver_campos);*/
//

// Tabulamos desde el buscador:
tabular_buscar(id_caja);

//--------------------------------------------------------------------------------------------
//-------------------- CASOS PARTICULARES SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------
if (tabla=="articulos" || tabla=="clientes" || tabla=="proveedores")
{
for (i = 0; i < campo.length; i++)
{
// CLIENTES:
if (tabla=="clientes")
{
if (campo[i]=="bloqueo")
	var bloqueo=valor[i];
} // Fin de if (tabla=="clientes")

// PROV:
if (tabla=="proveedores")
{
if (campo[i]=="tabla")
	var tabla='proveedores';
} // Fin de if (tabla=="clientes")

// ARTÍCULOS:
if (tabla=="articulos")
{
if (campo[i]=="existencias")
	var existencias=valor[i];

if (campo[i]=="stock_min")
	var stock_min=valor[i];

if (campo[i]=="stock_max")
	var stock_max=valor[i];

if (campo[i]=="descuento_art" && (direccion.search(/1_1_albaranes.php/)!=-1 || direccion.search(/1_1_presupuestos.php/)!=-1 || direccion.search(/1_entradas_compras.php/)!=-1))
	campo[i]="tipo_descuento";

if (campo[i]=="precio_coste" && (direccion.search(/1_1_ped_prov.php/)!=-1 || direccion.search(/1_entradas_compras.php/)!=-1))
	campo[i]="precio";
} // Fin de if (tabla=="articulos")
} // Fin de for
} // Fin de tablas


if (tabla=="articulos")
{
// ALERTAR EXISTENCIAS POR DE BAJO DE STOCK MÍNIMO:
if (direccion.search(/1_1_albaranes.php/)!=-1)
{
var pordebajo="";

if (existencias < stock_min)
	pordebajo = existencias+' < '+stock_min;

//alert(pordebajo);
if (pordebajo!="")
{
alert ('Las existencias de este artículo ESTÁN POR DEBAJO de su stock mínimo: '+pordebajo+'.');
// return false;
}
} // Fin de alertar
} // Fin de if (tabla=="articulos")


// BLOQUEAR CLIENTE:
if (tabla=="clientes" && bloqueo!="" && (direccion.search(/1_1_albaranes.php/)!=-1))
{
alert('BLOQUEADO: '+bloqueo+'.');
opener.document.getElementById("cod_cliente").value="";
//window.close();
return false;
}

if (tabla=="vehiculos" && senyal=="no_borrar" && num_filas > 0)
{
senyal="";
}

//Fiestas Operarios
if (tabla=="operarios" && (direccion.search(/1_1_albaranes.php/)!=-1) && valor[5]!="")
{
alert(valor[5]);
opener.document.getElementById("cod_operario").value="";
opener.document.getElementById("nombre_op").value="";
window.close();
return false;
}

//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: CASOS PARTICULARES SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- SI NO RECIBIMOS SENYAL
//--------------------------------------------------------------------------------------------
if (!senyal || senyal=="no_borrar_buscar" || senyal=="no_borrar" || (senyal=="refrescar_sin_borrar_buscar" && num_filas == 0))
{
// SOBREESCRIBIMOS CAMPOS CON RESULTADOS OBTENIDOS:
if (!senyal || ((senyal=="no_borrar_buscar" || senyal=="no_borrar") && num_filas > 0))
{
var texto = new Object(); // Variable que recogerá objetos del formulario.
var i; // Contador.
for (i=0; i < campo.length; i++)
{
	if(opener.document.getElementById(campo[i]))
	{
	texto=opener.document.getElementById(campo[i]);
	texto.value=valor[i];
	//alert('campo: '+texto.id+'\n  valor: '+texto.value);
	}
} // Fin de for
} // Fin de if

// BORRAMOS CAMPOS EXCEPTO AQUEL DESDE EL CUAL HEMOS BUSCADO:
else if ((senyal=="no_borrar_buscar" || senyal=="refrescar_sin_borrar_buscar") && num_filas == 0) //  && tabla!="albaranes" && tabla!="entradas" && tabla!="compras" && tabla!="vehiculos"
{
var num_elementos_form = opener.document.forms[0].length;
	var i=0;
	for (i=0; i < num_elementos_form; i++)
	{
	var elemento_form = opener.document.forms[0].elements[i];
		if (elemento_form.type=='text' && elemento_form.id!=id_caja)
			elemento_form.value="";
	}
}
} // Fin de if (!senyal)
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: SI NO RECIBIMOS SENYAL
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- SI RECIBIMOS SENYAL
//--------------------------------------------------------------------------------------------
else if (senyal)
{
//alert('SÍ RECIBIMOS SENYAL.');
var variables="";

if(senyal=="cod_operario2")
{
opener.document.getElementById("cod_operario2").value=valor[1];
opener.document.getElementById("nombre_op2").value=valor[2];
}


// Refrescar página para mostrar fila:
if (senyal=="refrescar" || ((senyal=="refrescar_sin_borrar" || senyal=="refrescar_sin_borrar_buscar") && num_filas > 0))
{
		variables=campo[0]+'='+valor[0]+'&'+campo[1]+'='+valor[1];
}

else if (senyal=='tarj')
{
	// Si NO hay resultados: 
	if (num_filas==0)
	{
		// Si no hemos abierto desde el fichero, ofrecemos crear:
		if (direccion.search(/14_tarjetas.php/)==-1 && confirm('La tarjeta buscada no existe. ¿Desea crearla?'))
		{
		// Cambiamos nombre a la ventana para que no sea sobreescrita:
		var ventana = matriz_ventanas();
		window.name = ventana.length;
		
		enlace(direccion_conta('/<? echo $carpeta; ?>/2_gestion_ficheros/14_tarjetas.php'),'','','','','','','','','','','','','','','','','','','','');
		return;
		} // Fin de: ofrecemos crear matricula.
	} // Fin de: Si NO hay resultados.

	else if (direccion.search(/14_tarjetas.php/)==-1)
	{
	opener.document.getElementById(campo[1]).value=valor[1];
	opener.document.getElementById(campo[2]).value=valor[2];
	opener.document.getElementById(campo[3]).value=valor[3];
	opener.document.getElementById(campo[4]).value=valor[4];
	}
}
else if (senyal=='trac')
{
	// Si NO hay resultados: 
	if (num_filas==0)
	{
		// Si no hemos abierto desde el fichero, ofrecemos crear:
		if (direccion.search(/17_tractoras.php/)==-1 && confirm('La tractora buscada no existe. ¿Desea crearla?'))
		{
		// Cambiamos nombre a la ventana para que no sea sobreescrita:
		var ventana = matriz_ventanas();
		window.name = ventana.length;
		
		enlace(direccion_conta('/<? echo $carpeta; ?>/2_gestion_ficheros/17_tractoras.php'),'','','','','','','','','','','','','','','','','','','','');
		return;
		} // Fin de: ofrecemos crear matricula.
	} // Fin de: Si NO hay resultados.

	else if (direccion.search(/17_tractoras.php/)==-1)
	{
	opener.document.getElementById(campo[1]).value=valor[1];
	opener.document.getElementById(campo[2]).value=valor[2];
	}
}

// Cargar familia en fichero Artículos:
if (senyal=="descarga_alb" && opener)
{
	opener.document.getElementById("cod_descarga").value=valor[1];
	opener.document.getElementById("poblacion").value=valor[3];
	
	if (opener.document.getElementById("horas_descarga"))
		opener.document.getElementById("horas_descarga").value=valor[6];
	
	if (opener.document.getElementById("precio_cli"))
		opener.document.getElementById("precio_cli").value=valor[2];
	
	if (opener.document.getElementById("precio_chof"))
		opener.document.getElementById("precio_chof").value=valor[5];
}

// Cambiar cliente en orden:
else if (senyal=="cambio_cli_alb")
{
opener.document.getElementById(campo[1]).value=valor[1];
opener.document.getElementById(campo[3]).value=valor[3];
opener.document.getElementById(campo[5]).value=valor[5];
opener.document.getElementById("cod_descarga").value='';
opener.document.getElementById("poblacion").value='';
opener.document.getElementById("horas_descarga").value='';

// Cambiamos empresa según iva:
opener.cambiar_emp_iva();
}

// Cargar albarán en Facturación Clientes:
if (senyal=="alb_fac")
	variables=campo[0]+'='+valor[0]+'&'+campo[1]+'='+valor[1]+'&'+campo[3]+'='+valor[3]+'&'+campo[6]+'='+valor[6];

// Cargar cliente en Facturación Clientes:
if (senyal=="cli_fac")
	variables=campo[0]+'='+valor[0]+'&'+campo[1]+'='+valor[1]+'&'+campo[3]+'='+valor[3]+'&'+campo[5]+'='+valor[5];

if (senyal=="fac_ini")
{
opener.document.getElementById(campo[0]).value=valor[0];
opener.document.getElementById("cod_factura_ini").value=valor[1];
opener.document.getElementById("nombre_cliente_ini").value=valor[2];
opener.document.getElementById("fac_fecha_ini").value=valor[3];
opener.document.getElementById("fac_total_ini").value=valor[4];
}

else if (senyal=="fac_fin")
{
opener.document.getElementById(campo[0]).value=valor[0];
opener.document.getElementById("cod_factura_fin").value=valor[1];
opener.document.getElementById("nombre_cliente_fin").value=valor[2];
opener.document.getElementById("fac_fecha_fin").value=valor[3];
opener.document.getElementById("fac_total_fin").value=valor[4];
}

// Cargar datos en recibos de facturas:
else if (senyal=="recibo_fac_ini")
{
opener.document.getElementById("cod_factura_ini").value=valor[1];
}

else if (senyal=="recibo_fac_fin")
{
opener.document.getElementById("cod_factura_fin").value=valor[1];
}

// PARA QUE DEVUELVA AL CAMP COD_CLIENTE EL VALOR DE CUALQUIERA SEGUN TABLA SELCCIONADA:
else if (senyal=="clientes" || senyal=="proveedores" || senyal=="acreedores")
{
var cod_empr=opener.document.getElementById("cod_empresa").value;
var tabl=opener.document.getElementById("tabla").value;
var cod_clie=opener.document.getElementById("cod_cliente");
var nombre_clie=opener.document.getElementById("nombre_cliente");


	cod_clie.value=valor[1];
	nombre_clie.value=valor[3];
	
}

	if (variables!="")
	{
	//alert(direccion+'?'+variables);
	opener.location.href=direccion+'?'+variables;
	}
} // Fin de else if (senyal)
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: SI RECIBIMOS SENYAL
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- ACCIONES PARTICULARES SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: ACCIONES PARTICULARES SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------

// CERRAMOS VENTANA:
if (cerrar=="cerrar" || (cerrar=="preguntar" && confirm("El elemento buscado NO existe.\n\n¿Desea cerrar el Buscador?")))
	window.close();
} // Fin de function
</script>
<?
} // Fin de if ($busqueda)
?>
</head>

<body onLoad="document.getElementById('buscar').focus()">
<table class="buscar">
<form method="post" name="buscador" id="buscador" action="">
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="670">
		    <input name="direccion" id="direccion" type="hidden" value="<? echo $direccion; ?>">
            <input name="tabla" id="tabla" type="hidden" value="<? echo $tabla; ?>">
            <input name="senyal" id="senyal" type="hidden" value="<? echo $senyal; ?>">
            <input name="id_caja" id="id_caja" type="hidden" value="<? echo $id_caja; ?>">
            <input name="salvar" id="salvar" type="hidden" value="<? echo $salvar; ?>">
            <input name="cod_cliente" id="cod_cliente" type="hidden" value="<? echo $cod_cliente; ?>">
            <input name="cod_proveedor" id="cod_proveedor" type="hidden" value="<? echo $cod_proveedor; ?>">
            <input name="cod_acreedor" id="cod_acreedor" type="hidden" value="<? echo $cod_acreedor; ?>">
            <input name="cod_forma" id="cod_forma" type="hidden" value="<? echo $cod_forma; ?>">
            <input name="cod_tipo" id="cod_tipo" type="hidden" value="<? echo $cod_tipo; ?>">
            <input name="cod_familia" id="cod_familia" type="hidden" value="<? echo $cod_familia; ?>">
            <input name="cod_personal" id="cod_personal" type="hidden" value="<? echo $cod_personal; ?>">
            <input name="cod_operario" id="cod_operario" type="hidden" value="<? echo $cod_operario; ?>">
			<input name="cod_usuario" id="cod_usuario" type="hidden" value="<? echo $cod_usuario; ?>">
            <input name="cod_articulo" id="cod_articulo" type="hidden" value="<? echo $cod_articulo; ?>">
            <input name="cod_empresa" id="cod_empresa" type="hidden" value="<? echo $cod_empresa; ?>">
			<input name="cod_albaran" id="cod_albaran" type="hidden" value="<? echo $cod_albaran; ?>">
            <input name="cod_entrada" id="cod_entrada" type="hidden" value="<? echo $cod_entrada; ?>">
            <input name="cod_compra" id="cod_compra" type="hidden" value="<? echo $cod_compra; ?>">
            <input name="cod_factura" id="cod_factura" type="hidden" value="<? echo $cod_factura; ?>">
			<input name="origen" id="origen" type="hidden" value="<? echo $origen; ?>">
            <input name="cod_ped_cli" id="cod_ped_cli" type="hidden" value="<? echo $cod_ped_cli; ?>">
            <input name="cod_ped_prov" id="cod_ped_prov" type="hidden" value="<? echo $cod_ped_prov; ?>">
            <input name="cod_presupuesto" id="cod_presupuesto" type="hidden" value="<? echo $cod_presupuesto; ?>">
            <input name="cod_cobro" id="cod_cobro" type="hidden" value="<? echo $cod_cobro; ?>">
			<input name="matricula" id="matricula" type="hidden" value="<? echo $matricula; ?>">
			<input name="login" id="login" type="hidden" value="<? echo $login; ?>">
			<input name="cod_tarjeta" id="cod_tarjeta" type="hidden" value="<? echo $cod_tarjeta; ?>">
			<input name="cod_tractora" id="cod_tractora" type="hidden" value="<? echo $cod_tractora; ?>">
			</td>
<?
include $carpeta_comun.'/'.$carpeta_basicos.'/30_04_cajas.php';
?>
          <td width="10">&nbsp;</td>
        </tr>
		<tr>
          <td>&nbsp;</td>
          <td>Codi o Nom:
            <input name="buscar" id="buscar" type="text" size="35" value="<? echo a_html($buscar,'get/post->input'); ?>">&nbsp;
            <input name="busca" id="busca" type="submit" value="Buscar"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="letra_14">Fitxer: <? echo "$descr_tabla"; ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="letra_12"><? if ($total_filas > 0) {echo "Resultados: $total_filas";} ?></td>
          <td>&nbsp;</td>
        </tr>
</form>
</table>
<?
if ($busqueda)
{
$num_fila = 0; // Variable que decidirá el color de cada fila.
$num_campos = 20; // Cantidad de campos a enviar.
$cont_arrays_js = 0; // Contador para generar tantos arrays javascript como líneas aparezcan.


if ($total_filas > 0)
{
// Limitamos la consulta:
$lineas_mostrar=28;
$limit=paginar("limitar");

$cerrar="cerrar";

$consulta=mysql_query($busqueda." $limit", $link) or die ("<br /> No se ha realizado la búsqueda: ".mysql_error()."<br /> $busqueda <br />");
?>
<table>
        <tr class="titulo_buscar">
          <td width="1%">&nbsp;</td>
          <td width="11%"><? echo $nombre1; ?></td>
          <td width="38%"><? echo $nombre2; ?></td>
          <td width="38%"><? echo $nombre3; ?></td>
          <td width="11%"><? echo $nombre4; ?></td>
          <td width="1%">&nbsp;</td>
        </tr>
<?
while($res=mysql_fetch_assoc($consulta))
{
$cont_arrays_js++; // Incrementamos el contador de arrays javascript.

for ($i = 0; $i <= $num_campos; $i++)
{
if ($senyal=="refrescar" || (($senyal=="refrescar_sin_borrar" || $senyal=="refrescar_sin_borrar_buscar") && $total_filas > 0) || $senyal=="alb_fac" || $senyal=="cli_fac")
{
// Codificamos para enviar por URL:
$valor[$i]=urlencode($res[$campo[$i]]);
}

else
{
// Adaptamos para javascript:
$valor[$i]=str_replace("\r\n", "\\n", addslashes($res[$campo[$i]]));
}


$valor_mostrado[$i]=$res[$campo[$i]];
//echo "<br /> campo: $campo[$i] <br /> valor: $valor[$i]";
} // Fin de for ($i = 1; $i <= $num_campos; $i++)

//--------------------------------------------------------------------------------------------
//-------------------- ADAPTACIONES PARTICULARES DE CAMPOS
//--------------------------------------------------------------------------------------------
if ($tabla=="albaranes" || $tabla=="facturas" || $tabla=="entradas" || $tabla=="cobros" || $tabla=="pedidos_prov" || $tabla=="presupuestos" || $tabla=="servicios")
{
$valor[3]=fecha_esp($valor[3]);
$valor_mostrado[3]=fecha_esp($valor_mostrado[3]);
}

if ($tabla=="compras")
{
	if ($valor_mostrado[5]!=0)
		$valor_mostrado[2]=$valor_mostrado[5]." ".$valor_mostrado[2]; // Código y nombre proveedor.
	if ($valor_mostrado[6]!=0)
		$valor_mostrado[3]=$valor_mostrado[6]." ".$valor_mostrado[3]; // Código y nombre acreedor.
	
$valor[4]=fecha_esp($valor[4]);
$valor_mostrado[4]=fecha_esp($valor_mostrado[4]);
}
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: ADAPTACIONES PARTICULARES DE CAMPOS
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- CONSULTAS EXTRA SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------
if($tabla=="proveedores")
{
	
$campo[5]="tabla";
$valor[5]="proveedores";
}

if($tabla=="operarios")
{
	
$campo[5]="tiene_fiesta";
$valor[5]="";

$fiesta=sel_campo("COUNT(fecha_ini)","fecha_ini","op_fiestas","cod_operario = $valor[1] and fecha_ini <= '$fecha_carga' and fecha_fin >= '$fecha_carga'");

if($fiesta>0)
	$valor[5]="Aquest operari té festa aquest dia.";

} // Fin operarios

else if ($tabla=="articulos" && $cod_cliente)
{
$campo[15]="tipo_descuento"; // Nombre campo descuento en albaranes.

// Si la familia del artículo está en descuento de familia por cliente, obtenemos descuento:
$existe_descuento=sel_campo("COUNT(descuento)","existe_descuento","descuentos","cod_familia = '$valor[8]' and cod_cliente = '$cod_cliente'");

if ($existe_descuento==1)
{
$valor[15]=sel_campo("descuento","","descuentos","cod_familia = '$valor[8]' and cod_cliente = '$cod_cliente'");
}

// En caso contrario, obtenemos descuento de familia:
else
{
$valor[15]=sel_campo("descuento","","familias","cod_familia = '$valor[8]'");
}
} // Fin de: Si la tabla es articulos y recibimos cliente.
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: CONSULTAS EXTRA SEGÚN LA TABLA
//--------------------------------------------------------------------------------------------

// GUARDAMOS EN ARRAYS JAVASCRIPT LOS VALORES DE ARRAYS PHP:
echo "<script type='text/javascript'>";
echo "campo".$cont_arrays_js." = new Array();";
echo "valor".$cont_arrays_js." = new Array();";
for ($i = 0; $i <= $num_campos; $i++)
{
echo "campo".$cont_arrays_js."[".$i."]='".$campo[$i]."';";
echo "valor".$cont_arrays_js."[".$i."]='".$valor[$i]."';";
}
echo "</script>";

	
// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par_buscar;
else
	$color=$color_impar_buscar;
?>
		<tr class="lineas_buscar" bgcolor="<? echo $color; ?>" onClick="enviar('<? echo $total_filas; ?>',<? echo "campo".$cont_arrays_js; ?>,<? echo "valor".$cont_arrays_js; ?>,'<? echo $tabla; ?>','<? echo $direccion; ?>','<? echo $senyal; ?>','<? echo $id_caja; ?>','<? echo $cerrar; ?>');">
          <td>&nbsp;</td>
		  <td><? echo $valor_mostrado[1]; ?></td>
		  <td><? echo $valor_mostrado[2]; ?></td>
		  <td><? echo $valor_mostrado[3]; ?></td>
          <td><? echo $valor_mostrado[4]; ?></td>
		  <td>&nbsp;</td>
		</tr>
<?
} // Fin de while: Resultados.

// Rellenamos con filas:
paginar("rellenar");
?>
		<tr>
          <td>&nbsp;</td>
		  <td colspan="4" align="center">
<?
$campo_pag[0]="buscar"; $valor_pag[0]=$buscar;
$campo_pag[1]="direccion"; $valor_pag[1]=$direccion;
$campo_pag[2]="tabla"; $valor_pag[2]=$tabla;
$campo_pag[3]="senyal"; $valor_pag[3]=$senyal;
$campo_pag[4]="id_caja"; $valor_pag[4]=$id_caja;

$campo_pag[5]="salvar"; $valor_pag[5]=$salvar;
$campo_pag[6]="cod_cliente"; $valor_pag[6]=$cod_cliente;
$campo_pag[7]="cod_proveedor"; $valor_pag[7]=$cod_proveedor;
$campo_pag[8]="cod_acreedor"; $valor_pag[8]=$cod_acreedor;
$campo_pag[9]="cod_forma"; $valor_pag[9]=$cod_forma;

$campo_pag[10]="cod_tipo"; $valor_pag[10]=$cod_tipo;
$campo_pag[11]="cod_familia"; $valor_pag[11]=$cod_familia;
$campo_pag[12]="cod_personal"; $valor_pag[12]=$cod_personal;
$campo_pag[13]="cod_operario"; $valor_pag[13]=$cod_operario;
$campo_pag[14]="cod_usuario"; $valor_pag[14]=$cod_usuario;
$campo_pag[15]="cod_articulo"; $valor_pag[15]=$cod_articulo;
$campo_pag[16]="cod_empresa"; $valor_pag[16]=$cod_empresa;
$campo_pag[17]="cod_albaran"; $valor_pag[17]=$cod_albaran;
$campo_pag[18]="cod_compra"; $valor_pag[18]=$cod_compra;
$campo_pag[19]="cod_forma"; $valor_pag[19]=$cod_forma;

$campo_pag[20]="cod_factura"; $valor_pag[20]=$cod_factura;
$campo_pag[21]="cod_ped_cli"; $valor_pag[21]=$cod_ped_cli;
$campo_pag[22]="cod_ped_prov"; $valor_pag[22]=$cod_ped_prov;
$campo_pag[23]="cod_presupuesto"; $valor_pag[23]=$cod_presupuesto;
$campo_pag[24]="cod_cobro"; $valor_pag[24]=$cod_cobro;
$campo_pag[25]="matricula"; $valor_pag[25]=$matricula;
$campo_pag[26]="login"; $valor_pag[26]=$login;

$campo_pag[27]="origen"; $valor_pag[27]=$origen;
$campo_pag[28]="cod_tarjeta"; $valor_pag[28]=$cod_tarjeta;
$campo_pag[29]="cod_tractora"; $valor_pag[29]=$cod_tractora;


include $carpeta_comun.'/'.$carpeta_basicos.'/30_05_var_pag.php';


// Paginamos:
paginar("paginar");
?>
		  </td>
		  <td>&nbsp;</td>
		</tr>
<?
//--------------------------------------------------------------------------------------------
//-------------------- OBTENCIÓN DE 1 RESULTADO
//--------------------------------------------------------------------------------------------
// Si obtenemos solamente 1 resultado, es una búsqueda concreta (recibimos $buscar) y ha sido realizada desde fuera del buscador (si no recibimos POST), enviamos directamente:
if ($total_filas == 1 && $buscar && !$_POST)
{
?>
<script type='text/javascript'>
enviar('<? echo $total_filas; ?>',<? echo "campo".$cont_arrays_js; ?>,<? echo "valor".$cont_arrays_js; ?>,'<? echo $tabla; ?>','<? echo $direccion; ?>','<? echo $senyal; ?>','<? echo $id_caja; ?>','<? echo $cerrar; ?>');
//alert("ENVIADO");
</script>
<?
} // Fin de: obtención de 1 resultado.
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: OBTENCIÓN DE 1 RESULTADO
//--------------------------------------------------------------------------------------------
} // Fin de if ($total_filas > 0)


//--------------------------------------------------------------------------------------------
//-------------------- CASOS PARTICULARES CUANDO NO SE HALLAN RESULTADOS
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: CASOS PARTICULARES CUANDO NO SE HALLAN RESULTADOS
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//-------------------- CASO GENERAL CUANDO NO SE HALLAN RESULTADOS
//--------------------------------------------------------------------------------------------
else
{
$cerrar="preguntar";

?>
<script type='text/javascript'>
<?
// Creamos arrays vacías con la longitud antes definida:
echo "campo".$cont_arrays_js." = new Array();";
echo "valor".$cont_arrays_js." = new Array();";
for ($i = 0; $i <= $num_campos; $i++)
{
echo "campo".$cont_arrays_js."[".$i."]='".$campo[$i]."';";
echo "valor".$cont_arrays_js."[".$i."]='';";
}
?>
enviar('<? echo $total_filas; ?>',<? echo "campo".$cont_arrays_js; ?>,<? echo "valor".$cont_arrays_js; ?>,'<? echo $tabla; ?>','<? echo $direccion; ?>','<? echo $senyal; ?>','<? echo $id_caja; ?>','<? echo $cerrar; ?>');
</script>
<?
} // Fin de else
//--------------------------------------------------------------------------------------------
//-------------------- FIN DE: CASO GENERAL CUANDO NO SE HALLAN RESULTADOS
//--------------------------------------------------------------------------------------------
} // Fin de if ($busqueda)
?>
</table>
</body>
</html>