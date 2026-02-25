<? if (!$carpeta) {if ($_COOKIE['01_carpeta']) {include $_SERVER['DOCUMENT_ROOT'].'/'.$_COOKIE['01_carpeta'].'/datos_conexion.php';} else {exit('<br /><br />NO EXISTE CARPETA.');}} ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Albarans Enviats</title>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--<meta HTTP-EQUIV="REFRESH" content="30">-->


<? echo $archivos; ?>
<? if ($carpeta_css) { ?>
<link href='/<? echo $carpeta_css; ?>/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } else { ?>
<link href='/comun/css/interfaz_conta.css' rel='stylesheet' type='text/css' />
<? } ?>


<?

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
$rem=$_POST["rem"];


$ii=0;
$num=count($rem);

for($i=0; $i < $num; $i++)
{
	//echo "I::::".$i;
// Obtenemos datos:
//$c=sel_sql("SELECT * FROM facturas WHERE tabla = '$tabla' AND cod_factura = '".$rem[$i]."'");


//******************************************** FIN DE CAMPOS PARA ENVIAR A SERES:************************************************//


// Realizamos la consulta: 
//$sql="UPDATE albaranes SET enviado = 'si' WHERE cod_albaran='".$rem[$i]."'";
//$result=mysql_query($sql, $link) or die ("<br /> No se ha modificado: ".mysql_error()."<br /> $sql <br />");


// ****************************************SACAMOS DATOS DEL ALBARAN PARA INSERTARLO:********************************************

$select_ord="SELECT * FROM albaranes WHERE cod_albaran ='".$rem[$i]."'";
$query_ord=mysql_query($select_ord, $link) or die ("<br /> No se ha comprobado orden: ".mysql_error()."<br /> $select_ord <br />");
$existe_ord=mysql_num_rows($query_ord);


$cod_albaran=$ord["cod_albaran"];
$cod_empresa=$ord["cod_empresa"];


//$archivo_remoto = $num_fact.'.txt';


$sql="UPDATE albaranes SET enviado = '' WHERE cod_albaran='".$rem[$i]."'";
$result=mysql_query($sql, $link) or die ("<br /> No se ha modificado: ".mysql_error()."<br /> $sql <br />");

$ii++;
} // Fin de for


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
alert("<? echo $ii; ?> Albarans Modificat");
enlace(direccion_conta(''),'','','','','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos el script:
exit();
}

$fecha_ini=fecha_ing($_GET["fecha_ini"]);
$fecha_fin=fecha_ing($_GET["fecha_fin"]);
$ver=$_GET["ver"];

if($ver=='CONFIRMATS')
	$confirmat="and descargado='si'";
else if ($ver=='PENDENTS')
	$confirmat="and descargado=''";
else
	$confirmat='';
// Realizamos la consulta: 

$sql="SELECT *
FROM albaranes
WHERE enviado = 'si' and fecha_carga>='$fecha_ini' and fecha_descarga<='$fecha_fin' $confirmat"; 
//echo $sql;

/*echo "<br/><br/>$sql";
echo "<br/><br/>$ver";
*/
$result=mysql_query($sql, $link) or die ("<br /> No se ha seleccionado: ".mysql_error()."<br /> $mostrar <br />");
$total_filas=mysql_num_rows($result);



?>
<script type="text/javascript">
function enviar(event)
{

var cod_albaran = document.getElementById('cod_albaran').value;

if (cod_albaran)
	mensaje="Ha seleccionado albaranes que quedarán abiertos para volver a enviarlos\n\n¿Está seguro que desea continuar?";
	
if (confirm(mensaje))
	document.forms[0].submit();

} // Fin de function


function marcar_todos(event,accion)
{
var disp=obt_disp(event);
var e = document.getElementsByTagName('input');

var checked=false;
if (accion)
	checked=accion;
else if (disp.checked==true)
	checked=true;

for (var i=0; i < e.length; i++)
{
	if (e[i].type=='checkbox')
	{
	e[i].checked=checked;
	} // Fin de if
} // Fin de for

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
            <td colspan="9" class="texto_blanco_titulo"> Resum Albarans Confirmats</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="6"><? 
if($total_filas==0)
{
echo "<BR/><BR/>NO HI HA ALBARANS ENVIATS AMB AQUESTES DADES.<BR/><BR/>";
exit();
}
?></td>
          </tr>
<?

// Realizamos la consulta: 
/**/
$sql="SELECT *
FROM albaranes
WHERE enviado = 'si' and fecha_carga>='$fecha_ini' and fecha_descarga<='$fecha_fin' $confirmat";

//echo $sql;

/*$sql="SELECT *
FROM `multas`
WHERE (fecha_multa <= '2014-01-25'
AND cod_enganche = '-'
and estado='v' and tipo_servicio='1')";

// PROVISIONAL PARA TRASPASAR SOLO LAS QUE FALTAN:
$sql="select * from 
multas
WHERE fecha_multa <= '2014-01-10'
AND cod_enganche = '-'
AND hora <= '14:00' and estado='v' order by cod_multa";
*/
$c=sel_sql($sql);
$total_filas=count($c);

?>
          <tr>
            <td width="124" class="texto_blanco_peq"><input type="checkbox" onClick="marcar_todos(event)" />
            Marcar Tots&nbsp;</td>
            <td width="101" class="texto_blanco_peq">&nbsp;</td>
            <td width="94" class="texto_blanco_peq">&nbsp;</td>
            <td width="171" class="texto_blanco_peq"><input type="button" name="guardar" id="guardar" title="Guardar" value="TREURE CONFIRMAT" onClick="enviar(event);" onMouseOver="window.top.focus();"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq">&nbsp;</td>
            <td width="109" class="texto_blanco_peq"><strong>Resultats:</strong></td>
            <td width="86" class="texto_blanco_peq"><? echo $total_filas; ?>&nbsp;</td>
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
          <tr>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Albar&agrave;</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Data</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Client</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq">&nbsp;</td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Conductor</strong></td>
            <td bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Conductor</strong></td>
            <td colspan="2" bgcolor="#CCCCCC" class="texto_blanco_peq"><strong>Confirmat</strong></td>
    </tr>
    
 
 
     <?

$mat_mostrar=$total_filas;
$inicial=0;

for ($i=$inicial; $i < $mat_mostrar; $i++)
{
$cod_albaran=$c[$i]["cod_albaran"];

// comprobamos que no está confirmado

$cod_empresa=$c[$i]["cod_empresa"];
$fecha_carga=$c[$i]["fecha_carga"];
$fecha_descarga=$c[$i]["fecha_descarga"];
$cod_cliente=$c[$i]["cod_cliente"];
$nombre_cliente=$c[$i]["nombre_cliente"];
$cod_operario=$c[$i]["cod_operario"];

$nombre_op=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario'");

$cod_operario2=$c[$i]["cod_operario2"];
$nombre_op2=sel_campo("nombre_op","","operarios","cod_operario='$cod_operario2'");

$foto=$c[$i]["foto"];
//$fecha_actual=sprintf("%04s-%02s-%02s", $h['year'],$h['mon'],$h['mday']);

// CONEXION ON LINE PARA VER ESTADO ALBARAN:
conectar_segu_tablets(ttonline);
$confirmado=sel_campo("confirmado", "","albaranes","cod_albaran='$cod_albaran'");
$base=$carpeta."_".substr($usuario_any,-2);
conectar_segu($base);


// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
?>
          <tr bgcolor="<? echo $color; ?>">
            <td class="texto_blanco_peq"><? if($confirmado!='si'){?><input type="checkbox" name="rem[]" value="<? echo $cod_albaran; ?>" <? echo $checked; ?>><? } ?><span class="vinculo" onClick="mostrar(event,direccion_conta('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php'), 'cod_albaran','<? echo $cod_albaran; ?>','','','cod_empresa','<? echo $cod_empresa; ?>','','','','','','','','','','','','','','');"><? echo $cod_albaran; ?></span> - <? if ($foto) { ?>
              &nbsp;<span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta.'/fotos/'.$usuario_any.'/'.$foto; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo $foto; } ?></span></td>
            <td class="texto_blanco_peq"><? echo fecha_esp($fecha_carga); ?></td>
            <td colspan="3" class="texto_blanco_peq"><? echo $cod_cliente; ?> <? echo $nombre_cliente; ?></td>
            <td class="texto_blanco_peq"><? echo $nombre_op; ?></td>
            <td class="texto_blanco_peq"><? echo $nombre_op2; ?></td>
            <td class="texto_blanco_peq"><? echo $confirmado; if($confirmado=='') echo "no"; ?></td>
            <td class="texto_blanco_peq"><span class="vinculo">
            <input name="cod_albaran" title="Multa;" type="hidden" id="cod_albaran" size="6" maxlength="6" value="<? echo $cod_albaran; ?>">
            </span></td>
          </tr>
          
<?
} // Fin de for

?>
<tr bgcolor="<? echo $color; ?>">
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td colspan="3" class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
  <td class="texto_blanco_peq">&nbsp;</td>
</tr>
<tr bgcolor="<? echo $color; ?>">
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td colspan="3" class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq"><input name="buscar" type="button" value="Nueva B&uacute;squeda" onClick="location.href='03_00_albs_resumen.php'"></td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
            <td class="texto_blanco_peq">&nbsp;</td>
    </tr>
</form>
</table>
</body>
</html>