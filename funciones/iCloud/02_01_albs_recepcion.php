<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Recepci&oacute; Albarans iCloud</title>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="REFRESH" content="30">


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?
conectar_segu($base_datos);
	

$h=getdate();
$fecha_actual=sprintf("%02s-%02s-%04s", $h['mday'],$h['mon'],$h['year']);
$hora_actual=sprintf("%02s:%02s:%02s", $h['hours'],$h['minutes'],"00");

$dia_semana = date("l",strtotime ($fecha_actual));

//echo "$dia_semana";

/*if($dia_semana!='Monday')
{
	echo "Avui no es poden traspassar Multes.";	
	exit();
}*/ 

$fecha_actual=fecha_ing($fecha_actual);


if ($_POST)
{
//ttonline.cat/web/ttonline/fotos/

// CONEXION FTP Y SUBIDA DEL ARCHIVO:
$cid = ftp_connect("ttonline.cat");
$resultado = ftp_login($cid, "ttonlineb1","}k8Rxk6L@2025");
if ((!$cid) || (!$resultado)) {
		echo "Fallo en la conexión"; die;
	} else {
		echo "<br/>Connectat.";
		echo "<br/>Realizant Descàrrega. Si us plau, Esperi...";
	
	}
ftp_pasv ($cid, true) ;
	//echo "<br> Cambio a modo pasivo<br />";

ftp_chdir($cid, "web");
ftp_chdir($cid, "ttonline");
ftp_chdir($cid, "fotos");
//ftp_chdir($cid, $usuario_any);
//echo "Cambiado al directorio necesario"; 
/*
exit();

echo "cad: $cadena";
exit();*/

	function escribeLog($msg) {
    global $logFile;
    file_put_contents($logFile, "[".date('Y-m-d H:i:s')."] $msg\n", FILE_APPEND);
}

function conexion_activa($cid) {
    if (!$cid) return false;
    return @ftp_pwd($cid) !== false; // si devuelve false, se perdió la conexión
}

// CONEXION  Y ENVIO DEL ARCHIVO:
//conectar_segu_tablets(ttonline);

	
// comprobamos si ya existe el albaran o es uno nuevo
$albaranes="SELECT cod_albaran,foto, foto1, observa_conductor FROM albaranes WHERE confirmado='si' and descargado=''"; //and fecha_descarga='2025-12-07'
$result_ord=mysql_query($albaranes) or die ("No se han seleccionado : ".mysql_error()."<br /> $albaranes <br />");

$i=0;
while($ord=mysql_fetch_array($result_ord))
{
$cod_albaran=$ord["cod_albaran"];
$foto=$ord["foto"];
$foto1=$ord["foto1"];	
$observa_conductor=$ord["observa_conductor"];

$archivo_remoto=$foto;
$archivo_remoto1=$foto1;	
	
$archivo_local=$_SERVER['DOCUMENT_ROOT'].'/'.$carpeta_data.'/fotos/'.$usuario_any.'/'.$foto;
$archivo_local1=$_SERVER['DOCUMENT_ROOT'].'/'.$carpeta_data.'/fotos/'.$usuario_any.'/'.$foto1;
	

// LOGSS	
$logFile = $_SERVER['DOCUMENT_ROOT'].'/'.$carpeta_data.'/fotos/logs/descarga_fotos.log';
	
// Crear carpeta del log si no existe
$dirLog = dirname($logFile);
if (!is_dir($dirLog)) {
    mkdir($dirLog, 0775, true);
}

// --- FOTO 1 ---
if (trim((string)$archivo_remoto) === '') {
    echo "<br>$cod_albaran: Foto1 No existeix";
    escribeLog("\n$cod_albaran: Foto1 No existeix ($archivo_remoto)");
} else {
    ob_start(); // capturar warnings del FTP solo cuando vamos a llamar a ftp_get
    $ok = ftp_get($cid, $archivo_local, $archivo_remoto, FTP_BINARY);
    $error = trim(ob_get_clean()); // cerramos el buffer y guardamos el warning

    if ($ok) {
        echo "<br>$foto descarregada exitosament\n";
        escribeLog("$foto descargada correctamente ($archivo_remoto -> $archivo_local)");
    } else {
        echo "<br>Error al descarregar $foto.\n";
        escribeLog("Error al descargar $foto: " . ($error ? $error : "Error desconocido"));
    }

    if (!conexion_activa($cid)) {
        escribeLog("Timeout o desconexión FTP durante la descarga de $foto");
    }
}

// --- FOTO 2 ---
if (trim((string)$archivo_remoto1) === '') {
    echo "<br>$cod_albaran: Foto2 No existeix";
    escribeLog("$cod_albaran: Foto2 No existeix ($archivo_remoto1)");
} else {
    ob_start();
    $ok2 = ftp_get($cid, $archivo_local1, $archivo_remoto1, FTP_BINARY);
    $error2 = trim(ob_get_clean());

    if ($ok2) {
        echo "<br>$foto1 descarregada exitosament\n";
        escribeLog("$foto1 descarregada correctament ($archivo_remoto1 -> $archivo_local1)");
    } else {
        echo "<br><br>Error al descarregar $foto1.\n";
        escribeLog("Error al descargar $foto1: " . ($error2 ? $error2 : "Error desconocido"));
    }

    if (!conexion_activa($cid)) {
        escribeLog("Timeout o desconexión FTP durante la descarga de $foto1");
    }
}



	
//conectar_segu_tablets(ttonline);
//$albaranes_online="UPDATE albaranes SET descargado='si' WHERE cod_albaran='$cod_albaran'";
//$result_alb=mysql_query($albaranes_online) or die ("No se han seleccionado : ".mysql_error()."<br /> $albaranes_online <br />");

/*
$base=$carpeta."_".substr($usuario_any,-2);
conectar_segu($base);*/
$albaranes_off="UPDATE albaranes SET foto='$foto',foto1='$foto1', observa_conductor='$observa_conductor',descargado='si' WHERE cod_albaran='$cod_albaran'";
$result_off=mysql_query($albaranes_off) or die ("No se han seleccionado : ".mysql_error()."<br /> $albaranes_off <br />");

$i++;
} // Fin de while



// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
alert("<? echo $i; ?> Albarans Rebuts");
enlace(direccion_conta(''),'','','','','','','','','','','','','','','','','','','','');
</script>
<?

exit();
}

?>
<script type="text/javascript">
function enviar(event)
{
document.forms[0].submit();

} // Fin de function


</script>
</head>

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color:#fff;
}
</style>
<link href="/igruapp/css/interfaz_conta.css" rel="stylesheet" type="text/css">
</head>

<body onKeyPress="tabular(event);">
<table width="915">
<form name="form1" method="post" action="">
          <tr class="titulo"> 
            <td colspan="9" class="texto_blanco_titulo">Recepció Albarans iCloud</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td width="171">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
          </tr>
<?

// CONEXION  Y ENVIO DEL ARCHIVO:
//conectar_segu_tablets(ttonline);

// comprobamos si ya existe el albaran o es uno nuevo
$albaranes="SELECT cod_albaran FROM albaranes WHERE confirmado='si' and descargado=''"; //and fecha_descarga='2025-12-07'
$result_ord=mysql_query($albaranes) or die ("No se han seleccionado : ".mysql_error()."<br /> $albaranes <br />");
$total_filas = mysql_num_rows($result_ord);

?>
           <tr>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td colspan="4" class="texto_blanco_peq"><? echo "HI HA <strong>$total_filas</strong> ALBARANS PENDENTS DE REBRE."; ?>&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td width="94" class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td width="124" class="texto_blanco_peq">&nbsp;</td>
            <td width="101" class="texto_blanco_peq">&nbsp;</td>
            <td colspan="2" class="texto_blanco_peq"><input type="submit" name="guardar" id="guardar" title="Guardar" value="INICIAR SINCRONITZACI&Oacute;"  onMouseOver="window.top.focus();"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq">&nbsp;</td>
            <td width="86" class="texto_blanco_peq">&nbsp;</td>
            <td width="635" class="texto_blanco_peq">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
          </tr>
    
 
<?

?>
</form>
</table>
</body>
</html>