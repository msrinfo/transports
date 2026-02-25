<?

//--------------------------------------------------------------------------------------------
//                                CONECTAR CON SERVIDOR TABLETS
//---------------------------------------------------------------------------------------------
function conectar_segu_tablets($base)
{
conectar_serv('127.0.0.1','msr','inf523111or') or die("error conexion");
$db=mysql_select_db($base);

//echo "$base";
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                CONECTAR CON SERVIDOR LOCAL
//---------------------------------------------------------------------------------------------
function conectar_segu($base)
{
conectar_serv('127.0.0.1','msr','inf523111or');
conectar_base($base);
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                MOSTRAR LISTA DESPLEGABLE
//--------------------------------------------------------------------------------------------
function mostrar_lista($tabla,$valor)
{
global $base_datos_conta, $base_datos;


$mostar_valor1='si';
$longitud=12;

// OPERARIOS
if ($tabla=="operarios")
{
/*
$fecha=getdate();
$hoy=$fecha[mday].'-'.$fecha[mon].'-'.$fecha[year];

$tabla="operarios, op_fiestas WHERE operarios.cod_operario = op_fiestas.cod_operario and op_fiestas.fecha != '$hoy'";
*/

$campo1="cod_operario";
$campo2="nombre_op";
}

// FORMAS DE PAGO
else if ($tabla=="formas_pago")
{
$campo1="cod_forma";
$campo2="descripcion";
}

// TIPOS DE PAGO
else if ($tabla=="tipos_pago")
{
$campo1="cod_tipo";
$campo2="desc_tipo";
}

// EMPRESAS
else if ($tabla=="empresas")
{
// Conectamos con contabilidad:
conectar_base($base_datos_conta);

$campo1="cod_empresa";
$campo2="nom_empresa";

if ($valor!="")
	$empresa="WHERE cod_empresa = '$valor'";
	
}

// BANCOS
else if ($tabla=="bancos")
{
conectar_base($base_datos_conta);

$campo1="cod_banco";
$campo2="CONCAT(nom_banco,': ',cc_banco)";
/*
if ($valor!="")
	$empresa .= " AND $campo1 = '$valor'";
//*/
//*
if ($cod_empresa!='')
	$empresa .= " WHERE SUBSTRING(cod_cuenta,1,2) = '$cod_empresa'";
//*/
$longitud=40;
//$orden=$campo1.','.$campo2;
}

// GRUPOS
else if ($tabla=="grupos")
{
$campo1="cod_grupo";
$campo2="desc_grupo";
}


$select_tabla="SELECT $campo1,$campo2 FROM $tabla $empresa ORDER BY $campo1,$campo2";


$query_tabla=mysql_query($select_tabla) or die ("<br /> No se ha obtenido lista: ".mysql_error()."<br /> $consulta <br />");

while($array=mysql_fetch_array($query_tabla))
{
$opt1[]=$array[$campo1];
$opt2[]=substr($array[$campo2],0,$longitud); // Limitamos el texto a mostrar.
}


// Mostramos lista:
opciones_select($opt1,$opt2,$valor,'si');

// Conectamos con cuenta:
conectar_base($base_datos);
} // Fin de function
//--------------------------------------------------------------------------------------------
//                                FIN DE FUNCIÓN
//--------------------------------------------------------------------------------------------
?>