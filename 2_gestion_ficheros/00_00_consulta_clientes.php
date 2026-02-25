<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} 



// Fichero que realiza la consulta en la base de datos y devuelve los resultados
if(isset($_POST["word"]))
{

	if($_POST["word"]{0}=="*")
		$result=mysql_query("SELECT * FROM clientes WHERE nombre_cliente LIKE '%".substr($_POST["word"],1)."%' and nombre_cliente<>'".$_POST["word"]."' ORDER BY nombre_cliente LIMIT 10",$link);
	else
		$result=mysql_query("SELECT * FROM clientes WHERE nombre_cliente LIKE '".$_POST["word"]."%' and nombre_cliente<>'".$_POST["word"]."' ORDER BY nom_calnombre_clientele LIMIT 10",$link);

	while($row=mysql_fetch_array($result))
	{
		// Mostramos las lineas que se mostraran en el desplegable. Cada enlace
		// tiene una funcion javascript que pasa los parametros necesarios a la
		// funcion selectItem
		echo "<a style='color:#fff; font-family:Verdana, Geneva, sans-serif; font-size:23px; text-decoration:none;' href=\"javascript:selectItem('".$_POST["nombre_cliente"]."','".$row["nombre_cliente"]."')\">".$row["nombre_cliente"]."</a><br/>";
	}
}
?>
