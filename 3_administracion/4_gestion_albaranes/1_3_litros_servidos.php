<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Llitres Servits </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />


<?
//--------------------------------------------------------------------------------------------
//                                POST
//--------------------------------------------------------------------------------------------
if ($_POST)
{
$cod_albaran=$_POST["cod_albaran"];
$cod_empresa=$_POST["cod_empresa"];
$dia=fecha_ing($_POST["dia"]);


if($cod_albaran && $cod_empresa)
{
$fecha_carga=sel_campo("fecha_carga","","albaranes","cod_albaran='$cod_albaran' and cod_empresa='$cod_empresa'");
}

$serv_blue=$_POST["serv_blue"];
$serv_sp95=$_POST["serv_sp95"]; 	
$serv_sp98=$_POST["serv_sp98"];	
$serv_go_a=$_POST["serv_go_a"];
$serv_go_a1=$_POST["serv_go_a1"];
$serv_go_b=$_POST["serv_go_b"];
$serv_go_c=$_POST["serv_go_c"];
$serv_bio=$_POST["serv_bio"];

/*echo "
<br /> serv_blue: $serv_blue
<br /> serv_sp95: $serv_sp95
<br /> serv_sp98: $serv_sp98
<br /> serv_go_a: $serv_go_a
<br /> serv_go_a1: $serv_go_a1
<br /> serv_go_b: $serv_go_b
<br /> serv_go_c: $serv_go_c
<br /> serv_bio: $serv_bio
<br /> suma_servidos: $suma_servidos
";
exit();
*/
$serv_redon=$_POST["serv_redon"];
$a_cobrar=$_POST["a_cobrar"];

$prec_desc_bomba_cli=$_POST["prec_desc_bomba_cli"];
$lts_desc_bomba=$_POST["lts_desc_bomba"];  	

$cod_descarga=$_POST["cod_descarga"];


if($cod_descarga)
{
$poblacion=sel_campo("poblacion","","descargas","cod_descarga='$cod_descarga'");
//$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
$horas_descarga=sel_campo("horas_descarga","","descargas","cod_descarga='$cod_descarga'");
$fecha_modif=sel_campo("fecha_modif","","descargas","cod_descarga='$cod_descarga'");

	// Si la fecha de modificacion de precios de la descarga es más reciente que la de carga guardo, sino la busco en el fichero
	if( comparar_fechas($fecha_modif,$fecha_carga)> 0 )
	{
	$precio_cli=$_POST["precio_cli"];
	} else
	{
	$precio_cli=sel_campo("precio_cli","","descargas","cod_descarga='$cod_descarga'");
	}
}

$prec_doble_carga_cli=$_POST["prec_doble_carga_cli"];
$prec_doble_desc_cli=$_POST["prec_doble_desc_cli"];

$horas_espera=$_POST["horas_espera"];
$prec_horas_espera=$_POST["prec_horas_espera"];

$doble_carga=$_POST["doble_carga"];
$doble_descarga=$_POST["doble_descarga"];
$descarga_bomba=$_POST["descarga_bomba"];

if($doble_carga!=1){
	$prec_doble_carga_cli="";
	$prec_doble_carga_chof="";
}

if($doble_descarga!=1){
	$prec_doble_desc_cli="";
	$prec_doble_desc_chof="";
}

if($descarga_bomba!=1){
	$prec_desc_bomba_cli="";
	$prec_desc_bomba_chof="";
	$lts_desc_bomba="";
}


$suma_servidos = $serv_blue + $serv_sp95 + $serv_sp98 + $serv_go_a + $serv_go_a1 + $serv_go_b + $serv_go_c + $serv_bio;

if($a_cobrar=="1")
{
$total_servidos=1;
}
else if($serv_redon==0)
{
$total_servidos=$suma_servidos;
}
else if($serv_redon!=0)
{
$total_servidos=$serv_redon;
}


/*echo "
<br /> cod_albaran: $cod_albaran
<br /> cod_empresa: $cod_empresa
<br /> prec_desc_bomba_cli: $prec_desc_bomba_cli
<br /> lts_desc_bomba: $lts_desc_bomba
<br /> total_servidos: $total_servidos
<br /> precio_cli: $precio_cli
<br /> prec_doble_carga_cli: $prec_doble_carga_cli
<br /> prec_doble_desc_cli: $prec_doble_desc_cli
<br /> horas_espera: $horas_espera
<br /> prec_horas_espera: $prec_horas_espera
<br /> doble_carga: $doble_carga
<br /> doble_descarga $doble_descarga
<br /> descarga_bomba: $descarga_bomba
	
<br /> base: $base
";
exit();
*/

$base= (($prec_desc_bomba_cli * $lts_desc_bomba) + ($total_servidos * $precio_cli) + $prec_doble_carga_cli + $prec_doble_desc_cli) + ($horas_espera * $prec_horas_espera);


// MODIFICAMOS:
$update_alb="UPDATE albaranes SET

serv_blue='$serv_blue',
serv_sp95='$serv_sp95',
serv_sp98='$serv_sp98',
serv_go_a='$serv_go_a',
serv_go_a1='$serv_go_a1',
serv_go_b='$serv_go_b',
serv_go_c='$serv_go_c',
serv_bio='$serv_bio',
suma_servidos='$suma_servidos',
serv_redon='$serv_redon',
a_cobrar='$a_cobrar',
base='$base'

WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";


$query_update_alb = mysql_query ($update_alb, $link) or die ("<br /> No se ha actualizado albarán: ".mysql_error()."<br /> $update_alb <br />");


// ACTUALIZAMOS LA PÁGINA:
?>
<script type="text/javascript">
//alert("PÁGINA ACTUALIZADA");
enlace(direccion_conta(''),'cod_empresa','<? echo $cod_empresa; ?>','dia','<? echo fecha_esp($dia); ?>','','','','','','','','','','','','','','','','');
</script>
<?
// Finalizamos el script:
exit();
} // Fin de if ($_POST)
//--------------------------------------------------------------------------------------------
//                                FIN DE: POST
//--------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------
//                                GET
//--------------------------------------------------------------------------------------------
if ($_GET)
{
$cod_albaran=$_GET["cod_albaran"];
$cod_empresa=$_GET["cod_empresa"];
$dia=$_GET["dia"];


/*
echo "
<br /> cod_albaran: $cod_albaran
<br /> cod_empresa: $cod_empresa
<br /> dia: $dia
";*/


if ($cod_albaran)
{
$select_lin="SELECT * FROM albaranes WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";

$query_lin=mysql_query($select_lin) or die ("<br /> No se ha seleccionado albarán: ".mysql_error()."<br /> $select_lin <br />");

$lin=mysql_fetch_array($query_lin);

$estado=$lin["estado"];
$cod_cliente=$lin["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");

$serv_blue=$lin["serv_blue"];
$serv_sp95=$lin["serv_sp95"]; 	
$serv_sp98=$lin["serv_sp98"];	
$serv_go_a=$lin["serv_go_a"];
$serv_go_a1=$lin["serv_go_a1"];
$serv_go_b=$lin["serv_go_b"];
$serv_go_c=$lin["serv_go_c"];
$serv_bio=$lin["serv_bio"];

$suma_servidos=$lin["suma_servidos"];

$prec_desc_bomba_cli=$lin["prec_desc_bomba_cli"];
$lts_desc_bomba=$lin["lts_desc_bomba"];  	

$cod_descarga=$lin["cod_descarga"];  	
$precio_cli=$lin["precio_cli"];  	

$doble_carga=$lin["doble_carga"];
$doble_descarga=$lin["doble_descarga"];
$descarga_bomba=$lin["descarga_bomba"];

$prec_doble_carga_cli=$lin["prec_doble_carga_cli"];
$prec_doble_desc_cli=$lin["prec_doble_desc_cli"];

$horas_espera=$lin["horas_espera"];
$prec_horas_espera=$lin["prec_horas_espera"];

$serv_redon=$lin["serv_redon"];
$a_cobrar=$lin["a_cobrar"];

$base=$lin["base"];
} // Fin de if ($cod_albaran)
} // Fin de if ($_GET)
//--------------------------------------------------------------------------------------------
//                                FIN DE: GET
//--------------------------------------------------------------------------------------------


if (!$dia)
{
$dia_hoy=getdate();
$dia=$dia_hoy[mday].'-'.$dia_hoy[mon].'-'.$dia_hoy[year];
}
?>
<script type="text/javascript">
function enviar(event)
{
var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

ser_ambos[0]="cod_empresa";
ser_ambos[1]="cod_albaran";

ser_numero[0]="serv_blue";
ser_numero[1]="serv_sp95";
ser_numero[2]="serv_sp98";
ser_numero[3]="serv_go_a";
ser_numero[4]="serv_go_a1";
ser_numero[5]="serv_go_b";
ser_numero[6]="serv_go_c";
ser_numero[7]="serv_bio";

var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

if (validado)
	{
	document.forms[0].submit();
	}
} // Fin de function
</script>
</head>

<body onKeyPress="tabular(event);">
<table>
<form name="form1" id="form1" method="post" action="">
   <tr class="titulo"> 
       <td colspan="16">Llitres Servits </td>
  </tr>
   <tr>
     <td width="1"></td>
     <td width="43">&nbsp;</td>
     <td width="81">&nbsp;</td>
     <td width="64">&nbsp;</td>
     <td width="43">&nbsp;</td>
     <td width="42">&nbsp;</td>
     <td width="45">&nbsp;</td>
     <td width="42">&nbsp;</td>
     <td width="43">&nbsp;</td>
     <td width="42">&nbsp;</td>
     <td width="42">&nbsp;</td>
     <td width="42">&nbsp;</td>
     <td colspan="4"></td>
    </tr>
   <tr>
    <td></td>
    <td colspan="2">Empresa:
      <select name="cod_empresa" id="cod_empresa">
        <? mostrar_lista("empresas",$cod_empresa); ?>
      </select></td>
    <td colspan="2">Dia:
      <input name="dia" title="Dia" type="text" id="dia" size="11" maxlength="10" value="<? echo $dia; ?>" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" title="Calendario" onClick="muestraCalendario('','form1','dia')"></td>
    <td colspan="4"><input name="ver" type="button" value="Veure" onClick="if (dia.value) {location.href=direccion_conta('?cod_empresa='+cod_empresa.value+'&dia='+dia.value)} else {alert('Introdueixi una data.');}">
      <input name="reset" type="button" value="Nou" onClick="location.href=direccion_conta('')"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td colspan="4"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="15"><hr /></td>
    </tr>
  <tr>
    <td></td>
    <td><strong>Albar&agrave;</strong></td>
    <td><strong>Client</strong></td>
    <td><div align="right"><strong>Preu Desc. </strong></div></td>
    <td><div align="right"><strong>ADITIVAT</strong></div></td>
    <td><div align="right"><strong>SP95</strong></div></td>
    <td><div align="right"><strong>SP98</strong></div></td>
    <td><div align="right"><strong>GO A </strong></div></td>
    <td><div align="right"><strong>B1000 </strong></div></td>
    <td><div align="right"><strong>GO B </strong></div></td>
    <td><div align="right"><strong>GO C </strong></div></td>
    <td align="right"><div align="right"><strong>BIO</strong></div></td>
    <td width="33" align="right"><strong>Total</strong></td>
    <td width="58" align="right"><strong>Redon</strong></td>
    <td width="33" align="right"><strong>Quan</strong></td>
    <td width="40"></td>
    </tr>
  <tr>
    <td></td>
    <td><input name="cod_albaran" title="C&oacute;digo Albarán" type="text" id="cod_albaran" size="6" maxlength="6" value="<? echo $cod_albaran; ?>" readonly class="readonly">    </td>
    <td><? echo $cod_cliente."&nbsp;&nbsp;".substr($nombre_cliente, 0, 40); ?></td>
    <td><div align="right"><? echo $base; ?><? //echo $precio_cli; ?></div></td>
    <td><div align="right">
      <input name="serv_blue" title="ADITIVAT" type="text" id="serv_blue" size="8" maxlength="8" value="<? echo "$serv_blue"; ?>">
    </div></td>
    <td><div align="right">
      <input name="serv_sp95" title="serv_sp95" type="text" id="serv_sp95" size="8" maxlength="8" value="<? echo "$serv_sp95"; ?>">
    </div></td>
    <td><div align="right">
      <input name="serv_sp98" title="serv_sp98" type="text" id="serv_sp98" size="8" maxlength="8" value="<? echo "$serv_sp98"; ?>">
    </div></td>
    <td><div align="right">
      <input name="serv_go_a" title="serv_go_a" type="text" id="serv_go_a" size="8" maxlength="8" value="<? echo "$serv_go_a"; ?>">
    </div></td>
    <td><div align="right">
      <input name="serv_go_a1" title="serv_go_a1" type="text" id="serv_go_a1" size="8" maxlength="8" value="<? echo "$serv_go_a1"; ?>">
    </div></td>
    <td><div align="right">
      <input name="serv_go_b" title="serv_go_b" type="text" id="serv_go_b" size="8" maxlength="8" value="<? echo "$serv_go_b"; ?>">
    </div></td>
    <td align="right"><div align="right">
      <input name="serv_go_c" title="serv_go_c" type="text" id="serv_go_c" size="8" maxlength="8" value="<? echo "$serv_go_c"; ?>">
    </div></td>
    <td><div align="right">
      <input name="serv_bio" title="serv_bio" type="text" id="serv_bio" size="8" maxlength="8" value="<? echo "$serv_bio"; ?>">
    </div></td>
    <td align="right">&nbsp;</td>
	<td align="right"><input name="serv_redon" title="serv_redon" type="text" id="serv_redon" size="8" maxlength="8" value="<? echo "$serv_redon"; ?>"></td>
	<td align="right">
	<input name="precio_cli" title="precio_cli" type="hidden" id="precio_cli" size="8" maxlength="8" value="<? echo "$precio_cli"; ?>">
	<input name="suma_servidos" title="suma_servidos" type="hidden" id="suma_servidos" size="8" maxlength="8" value="<? echo "$suma_servidos"; ?>">
	<input name="lts_desc_bomba" title="lts_desc_bomba" type="hidden" id="lts_desc_bomba" size="8" maxlength="8" value="<? echo "$lts_desc_bomba"; ?>">
    <input name="cod_descarga" title="cod_descarga" type="hidden" id="cod_descarga" size="8" maxlength="8" value="<? echo "$cod_descarga"; ?>">
    <input name="prec_doble_carga_cli" title="prec_doble_carga_cli" type="hidden" id="prec_doble_carga_cli" size="8" maxlength="8" value="<? echo "$prec_doble_carga_cli"; ?>">
    <input name="prec_doble_desc_cli" title="prec_doble_desc_cli" type="hidden" id="prec_doble_desc_cli" size="8" maxlength="8" value="<? echo "$prec_doble_desc_cli"; ?>">
    <input name="horas_espera" title="horas_espera" type="hidden" id="horas_espera" size="8" maxlength="8" value="<? echo "$horas_espera"; ?>">
    <input name="prec_horas_espera" title="prec_horas_espera" type="hidden" id="prec_horas_espera" size="8" maxlength="8" value="<? echo "$prec_horas_espera"; ?>">
    <input name="base" title="base" type="hidden" id="base" size="8" maxlength="8" value="<? echo "$base"; ?>">
	<input name="doble_carga" title="doble_carga" type="hidden" id="doble_carga" size="8" maxlength="8" value="<? echo "$doble_carga"; ?>">
	<input name="doble_descarga" title="doble_descarga" type="hidden" id="doble_descarga" size="8" maxlength="8" value="<? echo "$doble_descarga"; ?>">
	<input name="descarga_bomba" title="descarga_bomba" type="hidden" id="descarga_bomba" size="8" maxlength="8" value="<? echo "$descarga_bomba"; ?>">
	
    <input name="fecha_carga" title="base" type="hidden" id="fecha_carga" size="8" maxlength="8" value="<? echo "$fecha_carga"; ?>">
    <input name="a_cobrar" title="a_cobrar" type="text" id="a_cobrar" size="2" maxlength="2" value="<? echo "$a_cobrar"; ?>"></td>
	<td><? if($estado!='f') { ?>
      <img src="/comun/imgs/guardar2.gif" title="Guardar" onClick="enviar(event);"> </td>
	<? } ?>
    </tr>
<?
if ($cod_empresa && $dia)
{
$dia=fecha_ing($dia);
$mostrar_art="SELECT cod_albaran FROM albaranes WHERE cod_empresa = '$cod_empresa' and fecha_carga = '$dia'";
$result_art=mysql_query($mostrar_art, $link) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $mostrar_art <br />");

$total_filas=mysql_num_rows($result_art);

// Limitamos la consulta:
$lineas_mostrar=20;
$limit=paginar("limitar");

if ($total_filas > 0)
{
$mostrar_art="SELECT * FROM albaranes WHERE  cod_empresa = '$cod_empresa' and fecha_carga = '$dia' ORDER BY cod_albaran $limit";
//echo "<br /> $total_filas $mostrar_art <br />";
$result_art=mysql_query($mostrar_art, $link);


while($art=mysql_fetch_array($result_art))
{
$cod_albaran=$art["cod_albaran"];
$cod_cliente=$art["cod_cliente"];
$nombre_cliente=sel_campo("nombre_cliente","","clientes","cod_cliente = '$cod_cliente'");
$precio_cli=$art["precio_cli"];
$foto=$art["foto"];
$foto1=$art["foto1"];
	
$cant_blue=$art["cant_blue"];
$cant_sp95=$art["cant_sp95"]; 	
$cant_sp98=$art["cant_sp98"];	
$cant_go_a=$art["cant_go_a"];
$cant_go_a1=$art["cant_go_a1"];
$cant_go_b=$art["cant_go_b"];
$cant_go_c=$art["cant_go_c"];
$cant_bio=$art["cant_bio"];

	
$serv_blue=$art["serv_blue"];
$serv_sp95=$art["serv_sp95"]; 	
$serv_sp98=$art["serv_sp98"];	
$serv_go_a=$art["serv_go_a"];
$serv_go_a1=$art["serv_go_a1"];
$serv_go_b=$art["serv_go_b"];
$serv_go_c=$art["serv_go_c"];
$serv_bio=$art["serv_bio"];

$suma_servidos=$art["suma_servidos"];

$serv_redon=$art["serv_redon"];
$a_cobrar=$art["a_cobrar"];
$base=$art["base"];
$estado=$art["estado"];

// Decidimos color de fila según contador de color:
$cont_color++;
if ($cont_color % 2 == 0)
	$color=$color_par;
else
	$color=$color_impar;
	?>
	<tr bgcolor="<? echo $color; ?>">
    <td></td>
    <td><span class="vinculo" onClick="mostrar(event,direccion_conta('1_1_albaranes.php'), 'cod_empresa','<? echo $cod_empresa; ?>','cod_albaran','<? echo $cod_albaran; ?>','','','','','','','','','','','','','','','','');"><? echo $cod_albaran;?></span>
	<? if ($foto) { ?>
              &nbsp;<span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta_data.'/fotos/'.$usuario_any.'/'.$foto; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo "foto"; } if ($foto1) { ?> <br>
             <span class="vinculo" onClick="mostrar(event,'/<? echo $carpeta_data.'/fotos/'.$usuario_any.'/'.$foto1; ?>','a','','','','','','','','','','','','','','','','','','','');"><? echo $foto1; }?></td>
    <td><? echo $cod_cliente."&nbsp;&nbsp;".substr($nombre_cliente, 0, 30); ?></td>
    <td><div align="right"><? echo $precio_cli; ?></div></td>
    <td>
	<div align="right">
	<? 
	if($serv_blue!=0){ 
		echo "<font color=' #0033CC'>$serv_blue</font>"; 
	} else if($cant_blue!=0 && $serv_blue==0){ echo $cant_blue; } 
	?>
	</div>	</td>
    <td>
	<div align="right">
	<? 
	if($serv_sp95!=0){ 
		echo "<font color=' #0033CC'>$serv_sp95</font>"; 
	} else if($cant_sp95!=0 && $serv_sp95==0){ echo $cant_sp95; } 
	?>
	</div>	</td>
    <td>
	<div align="right">
	<? 
	if($serv_sp98!=0){ 
		echo "<font color=' #0033CC'>$serv_sp98</font>"; 
	} else if($cant_sp98!=0 && $serv_sp98==0){ echo $cant_sp98; } 
	?>
	</div>	</td>
    <td>
	<div align="right">
	<? 
	if($serv_go_a!=0){ 
		echo "<font color=' #0033CC'>$serv_go_a</font>"; 
	} else if($cant_go_a!=0 && $serv_go_a==0){ echo $cant_go_a; } 
	?>
	</div>	</td>
    <td>
	<div align="right">
	<? 
	if($serv_go_a1!=0){ 
		echo "<font color=' #0033CC'>$serv_go_a1</font>"; 
	} else if($cant_go_a1!=0 && $serv_go_a1==0){ echo $cant_go_a1; } 
	?>
	</div>	</td>
    <td>
	<div align="right">
	<? 
	if($serv_go_b!=0){ 
		echo "<font color=' #0033CC'>$serv_go_b</font>"; 
	} else if($cant_go_b!=0 && $serv_go_b==0){ echo $cant_go_b; } 
	?>
	</div>	</td>
    <td>
	<div align="right">
	<? 
	if($serv_go_c!=0){ 
		echo "<font color=' #0033CC'>$serv_go_c</font>"; 
	} else if($cant_go_c!=0 && $serv_go_c==0){ echo $cant_go_c; } 
	?>
	</div>	</td>
    <td><div align="right">
	<? 
	if($serv_bio!=0){ 
		echo "<font color=' #0033CC'>$serv_bio</font>"; 
	} else if($cant_bio!=0 && $serv_bio==0){ echo $cant_bio; } 
	?>
	</div>	</td>
    <td align="right"><? echo $suma_servidos; ?></td>
    <td align="right"><? echo $serv_redon; ?></td>
    <td align="right"><? echo $a_cobrar; ?></td>
    <td><? if($estado!='f') { ?>
      <img src="/comun/imgs/editar.gif" title="Modificar" onClick="enlace(direccion_conta(''),'cod_albaran','<? echo $cod_albaran; ?>','cod_empresa','<? echo $cod_empresa; ?>','dia','<? echo fecha_esp($dia); ?>','','','','','','','','','','','','','','')"></a>
      <? } ?></td>
    </tr>
<?
} // Fin de while($art=mysql_fetch_array($result_art))
} // Fin de if ($total_filas > 0)
} // Fin de if ($cod_empresa && $dia)

// Rellenamos con filas:
paginar("rellenar");
?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="15">
<?
$campo_pag[1]="cod_empresa"; $valor_pag[1]=$cod_empresa;
$campo_pag[2]="dia"; $valor_pag[2]=fecha_esp($dia);

// Paginamos:
paginar("paginar");
?>
<input name="prec_desc_bomba_cli" title="prec_desc_bomba_cli" type="hidden" id="prec_desc_bomba_cli" size="8" maxlength="8" value="<? echo "$prec_desc_bomba_cli"; ?>"></td>
  </tr>
</form>
</table>
</body>
</html>