<? 

//--------------------------------------------------------------------------------------------
//                                				GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_operario=$_GET["cod_operario"];
$cod_oper=$cod_operario;
$fecha_i=$_GET["fecha_ini"];
$fecha_f=$_GET["fecha_fin"];
$cod_empresa=$_GET["cod_empresa"];
$cod_empr=$cod_empresa;
$clasificacion=$_GET["clasificacion"];
$prec_dieta=$_GET["prec_dieta"];
$prec_diet=$prec_dieta;
$dies_reals=$_GET["dies_reals"];

}
//--------------------------------------------------------------------------------------------
//                                				FIN GET
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                				POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_operario=$_POST["cod_operario"];
$cod_oper=$cod_operario;
$fecha_i=$_POST["fecha_ini"];
$fecha_f=$_POST["fecha_fin"];
$cod_empresa=$_POST["cod_empresa"];
$cod_empr=$cod_empresa;
$clasificacion=$_POST["clasificacion"];
$prec_dieta=$_POST["prec_dieta"];
$prec_diet=$prec_dieta;
$dies_reals=$_POST["dies_reals"];

}


//--------------------------------------------------------------------------------------------
//                             				FIN POST
//--------------------------------------------------------------------------------------------

if($prec_dieta=="")
	{
	$prec_dieta=0;
	}
	
	

//--------------------------------------------------------------------------------------------
//                                			CONDICIONES
//--------------------------------------------------------------------------------------------
$where="WHERE";
// Si no recibimos cliente, dejamos la variable vacía:
$cliente="";

if ($cod_operario)
{
	$cliente="$where cod_operario = '$cod_operario'";
	// Si cliente está vacío, el contenido de la variable cambia:
	$where="AND";
	$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");
}

// Según el cod_empresa, se seleccionará una empresa u otra:
if ($cod_empresa)
{
	$empres="$where cod_empresa = '$cod_empresa'";
	$where="AND";
}


if ($fecha_i || $fecha_f )
{
$fecha_ini=fecha_ing($fecha_i);
$fecha_fin=fecha_ing($fecha_f);

// Si no recibimos fecha_carga inicial, dejamos la variable vacía
if (!$fecha_i && !$fecha_f)
	$periodo="";
else
{
if ($fecha_i && $fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini' and fecha_carga <= '$fecha_fin')";
	
if ($fecha_i && !$fecha_f)
	$periodo="$where (fecha_carga >= '$fecha_ini')";
	
if (!$fecha_i && $fecha_f)
	$periodo="$where (fecha_carga <= '$fecha_fin')";
}

$where="and";
} //FIN if (!$fecha_i && !$fecha_f)

// Establecemos el orden:
$orden="cod_operario, fecha_carga";
//--------------------------------------------------------------------------------------------
//                                		 FIN CONDICIONES
//--------------------------------------------------------------------------------------------

// OBTENEMOS TOTALES: 
$albaranes="SELECT COUNT(cod_albaran) as total_filas FROM albaranes $cliente $empres $periodo $num_iva";
$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado totales: ".mysql_error()."<br /> $albaranes <br />");
$total=mysql_fetch_array($result_fact);
$total_filas=$total["total_filas"];

// Obtenemos suma de dias por conductor de todos los conductores:
//$fechas="SELECT DISTINCT(fecha_carga) FROM albaranes $cliente $empres $periodo $num_iva";
$fechas="SELECT COUNT(DISTINCT(fecha_carga)) AS cli_dias FROM albaranes $cliente $empres $periodo $num_iva GROUP BY cod_operario";
$result_fechas=mysql_query($fechas, $link) or die ("<br /> No se han seleccionado clientes: ".mysql_error()."<br /> $cuenta <br />");

while ($ft=mysql_fetch_assoc($result_fechas))
{
$fechas_tot += $ft["cli_dias"];
}


//Volvemos a hacer la consulta pero limitandola al numero de paginas y filas
$albaranes="SELECT * FROM albaranes $cliente $empres $periodo $num_iva ORDER BY $orden $limit";

$result_fact=mysql_query($albaranes, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $albaranes <br />");


if ($result_fact)
{
// GENERAR ARCHIVOS:
$nombre_archivo='dietas.csv';


//Si los clientes son diferentes creamos toda una fila para poner el fac_total del cliente
if($cod_cli!=$cod_operario)
{
$totcli="SELECT COUNT(DISTINCT(fecha_carga)) AS cli_dias FROM albaranes $cliente $empres $periodo $num_iva $where cod_operario = '$cod_operario' ORDER BY cod_operario";
//echo "<br /> totcli: $totcli <br />";
$result_cli=mysql_query($totcli, $link) or die ("<br /> No se han seleccionado totales de albaranes: ".mysql_error()."<br /> $totcli <br />");

$clie=mysql_fetch_array($result_cli);

$cli_dias=$clie["cli_dias"];

$total_dies = $dies_reals - $cli_dias;
}


$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

/*echo "DIES: $dies_reals";
echo "cli_dias: $cli_dias";
exit();*/

// Cabecera:
$mat[0]=$cod_operario.' '.$nombre_op.';;;;'.$dies_reals.'DIES *'.$prec_dieta.'€ ='.$dies_reals * $prec_dieta.'€'.';TREU:'.$total_dies;
$mat[1]='CÓDIGO;FECHA;DESCARGA';

while($alb=mysql_fetch_array($result_fact))
{
$cod_albaran=$alb["cod_albaran"];
$fecha_carga=fecha_esp($alb["fecha_carga"]);
$cod_empresa=$alb["cod_empresa"];
$cod_operario=$alb["cod_operario"];
$precio_chof=$alb["precio_chof"];
$cod_descarga=$alb["cod_descarga"];

if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
}

$mat[]=$cod_albaran.';'.$fecha_carga.';'.$poblacion;
} // Fin de while

}
// Volcamos móviles en archivo de texto:
$contenido_archivo=implode("\r\n", $mat);
descargar_arch($nombre_archivo,$contenido_archivo);
?>