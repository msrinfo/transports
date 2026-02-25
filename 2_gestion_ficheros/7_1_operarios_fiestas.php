<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Operarios Fiestas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<? echo $archivos; ?>
<link href='/segu_admin/interfaz_segu.css' rel='stylesheet' type='text/css' />

<?
/*--------------------------------------------------------------------------------------------
  POST
--------------------------------------------------------------------------------------------*/
if ($_POST)
{
  $cod_operario   = $_POST["cod_operario"];
  $cod_oper       = $cod_operario;
  $fecha_ini      = fecha_ing($_POST["fecha_ini"]);
  $fecha_fin      = fecha_ing($_POST["fecha_fin"]);
  $observaciones  = $_POST["observaciones"];

  // Si fecha final está vacía, fecha final toma valor de fecha inicial:
  if ($fecha_fin==0)
    $fecha_fin=$fecha_ini;

  $any_fin_act=substr($fecha_fin,0,4);
  $any_ini_act=substr($fecha_ini,0,4);

  if($any_fin_act!=$usuario_any)
  {
  ?>
    <script type="text/javascript">
    alert("La fecha FINAL indicada NO SE CORRESPONDE con el año actual");
    </script>
  <?
  }

  if($any_ini_act!=$usuario_any)
  {
  ?>
    <script type="text/javascript">
    alert("La fecha  INICIAL indicada NO SE CORRESPONDE con el año actual");
    </script>
  <?
  }

  /*
  FUNCIONAMIENTO:
  - Si el intervalo recibido invade días de otro intervalo ya existente, no dejamos grabar.
  */

  // Comprobamos intervalo:
  $existe_int=sel_campo(
    "COUNT(cod_operario)","alias","op_fiestas",
    "cod_operario = '$cod_operario'
     AND fecha_ini != '$fecha_ini'
     AND (fecha_ini <= '$fecha_fin' AND fecha_fin >= '$fecha_ini')"
  );

  if ($existe_int > 0)
  {
  ?>
    <script type="text/javascript">
    alert("Ha elegido uno o más días que ya pertenecen a otra fiesta.\nElija otras fechas.");
    history.back();
    </script>
  <?
    exit();
  }

  // Comprobamos si existe:
  $existe=sel_campo("COUNT(cod_operario)","","op_fiestas","cod_operario = '$cod_operario' AND fecha_ini = '$fecha_ini'");

  if ($existe==1)
  {
    // MODIFICAMOS:
    $insertar_art="UPDATE op_fiestas SET
      fecha_fin='$fecha_fin',
      observaciones='$observaciones'
      WHERE cod_operario = '$cod_operario' and fecha_ini = '$fecha_ini'";

    $result_art = mysql_query ($insertar_art, $link) or die ("No se ha modificado: ".mysql_error()."<br /> $insertar_art <br />");
  }
  else
  {
    // INSERTAMOS NUEVO:
    $insertar_art="INSERT INTO op_fiestas
      (cod_operario,fecha_ini,fecha_fin,observaciones)
      VALUES
      ('$cod_operario','$fecha_ini','$fecha_fin','$observaciones')";

    $result_art = mysql_query ($insertar_art, $link) or die ("<br />No se ha insertado: ".mysql_error()."<br />$insertar_art<br />");
  }

  // Como el chofer tiene fiesta ponemos sus albaranes a conductor pendiente:
  if($fecha_ini != $fecha_fin)
  {
    $select_alb="SELECT cod_albaran, cod_empresa
                 FROM albaranes
                 WHERE cod_operario = '$cod_operario'
                   AND fecha_carga >= '$fecha_ini'
                   AND fecha_carga <= '$fecha_fin'";
  }
  else
  {
    $select_alb="SELECT cod_albaran, cod_empresa
                 FROM albaranes
                 WHERE cod_operario = '$cod_operario'
                   AND fecha_carga='$fecha_ini'";
  }

  $query_alb=mysql_query($select_alb, $link) or die ("No se ha seleccionado: ".mysql_error()."<br /> $select_alb <br />");
  $existe_alb=mysql_num_rows($query_alb);

  if($existe_alb > 0)
  {
    while ($alb=mysql_fetch_array($query_alb))
    {
      $cod_albaran=$alb["cod_albaran"];
      $cod_empresa=$alb["cod_empresa"];

      $update_alb="UPDATE albaranes SET cod_operario = '99'
                   WHERE cod_albaran='$cod_albaran' and cod_empresa='$cod_empresa'";

      $query_up_alb=mysql_query($update_alb, $link) or die ("No se ha updateado: ".mysql_error()."<br /> $update_alb <br />");
    }
  ?>
    <script type="text/javascript">
    alert("Aquest operari té assignats albarans per a aquest dia. Passaràn a estar pendents.");
    </script>
  <?
  }

  // Recargamos página:
  ?>
  <script type="text/javascript">
  enlace(direccion_conta(''),'cod_operario','<? echo $cod_operario; ?>','','','','','','','','','','','','','','','','','','');
  </script>
  <?
  exit();
}
/*--------------------------------------------------------------------------------------------
  FIN POST
--------------------------------------------------------------------------------------------*/


/*--------------------------------------------------------------------------------------------
  GET
--------------------------------------------------------------------------------------------*/
if ($_GET)
{
  $cod_operario=$_GET["cod_operario"];
  $cod_oper=$cod_operario;
  $fecha_ini=$_GET["fecha_ini"];
  $fecha_fin=$_GET["fecha_fin"];

  $eliminar=$_GET["eliminar"];

  $nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");

  $fecha_ext_ini=fecha_ing($fecha_ini);
  $fecha_ext_fin=fecha_ing($fecha_fin);

  // Comprobamos si existe:
  $existe=sel_campo("cod_operario","","op_fiestas","cod_operario = '$cod_operario' and fecha_ini='$fecha_ext_ini' and fecha_fin='$fecha_ext_fin'");

  if ($existe)
  {
    // ELIMINAR
    if ($eliminar==1)
    {
      $eliminar_art="DELETE FROM op_fiestas
                     WHERE cod_operario = '$cod_operario'
                       and fecha_ini='$fecha_ext_ini'
                       and fecha_fin='$fecha_ext_fin'";

      $result=mysql_query($eliminar_art, $link) or die ("No se ha eliminado: ".mysql_error()."<br /> $eliminar_art <br />");

      if ($_GET["conservar_oper"]!='si')
        $cod_operario='';

      $nombre_op=$fecha_ini=$fecha_fin=$observaciones="";
    }

    if($cod_operario && $fecha_ini)
    {
      $select_sedes="SELECT * FROM op_fiestas
                     WHERE cod_operario = '$cod_operario'
                       and fecha_ini='$fecha_ext_ini'
                       and  fecha_fin='$fecha_ext_fin'";

      $query_sedes=mysql_query($select_sedes, $link) or die ("No se ha seleccionado sede: ".mysql_error()."<br /> $select_sedes <br />");
      $art=mysql_fetch_array($query_sedes);

      $fecha_ini=fecha_esp($art["fecha_ini"]);
      $fecha_fin=fecha_esp($art["fecha_fin"]);
      $observaciones=$art["observaciones"];
    }
  }
}
/*--------------------------------------------------------------------------------------------
  FIN GET
--------------------------------------------------------------------------------------------*/
?>

<script type="text/javascript">
//--------------------------------------------------------------------------------------------
// Calendario de RANGO (usa tu 18_01_calendrng.php sin tocar el calendario normal)
//--------------------------------------------------------------------------------------------
function muestraCalendarioRango(raiz,formulario_destino,campo_ini,campo_fin)
{
  var pag_calendario = "/comun/02_basicos/18_01_calendrng.php"
                     + "?campo_ini=" + escape(campo_ini)
                     + "&campo_fin=" + escape(campo_fin);

  abrir_ventanas(
    "",
    pag_calendario,
    "Calendario",
    "width=300,height=320,top=170,left=350,directories=no,location=no,menubar=no,resizable=no,scrollbars=yes,status=yes"
  );
}



//--------------------------------------------------------------------------------------------
function enviar(event)
{
  var ser_no_vacio = new Array(); var ser_ambos = new Array(); var ser_numero = new Array();

  ser_no_vacio[0]="fecha_ini";
  ser_ambos[0]="cod_operario";

  var validado = control_error_js(event,ser_no_vacio,ser_ambos,ser_numero);

  if (validado)
  {
    document.forms[0].submit();
  }
}
//--------------------------------------------------------------------------------------------
</script>
</head>

<body onKeyPress="tabular(event);" onLoad="foco_inicial('cod_operario')">
<table>
<form name="albaranes" id="albaranes" method="post" enctype="multipart/form-data" action="">
  <tr class="titulo">
    <td colspan="10">Operaris Festes </td>
  </tr>

  <tr>
    <td width="4">&nbsp;</td>
    <td width="240"><strong>Codi Operari </strong></td>
    <td width="91"><strong>Data Festiva Ini</strong></td>
    <td width="92"><strong>Data Festiva Fin</strong></td>
    <td colspan="3"><strong>Observacions</strong></td>
    <td width="119">&nbsp;</td>
    <td width="42">&nbsp;</td>
    <td width="6">&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>
      <input name="cod_operario" title="C&oacute;digo Conductor" type="text" id="cod_operario" size="2" maxlength="2"
             value="<? echo "$cod_operario"; ?>"
             onBlur="buscar_conta(event,'operarios',cod_operario.value,'cod_operario',cod_operario.value,'','','','','','','','','','','refrescar');">
      <img src="/comun/imgs/lupa.gif" onClick="abrir(event,'cod_operario');">
      <input name="nombre_op" title="Nombre Operario" type="text" id="nombre_op" size="30" maxlength="40"
             value="<? echo a_html($nombre_op,"bd->input"); ?>" readonly="true" class="readonly">
    </td>

    <!-- FECHA INI: abre calendario de rango -->
    <td>
      <input name="fecha_ini" title="Fecha Ini" type="text" id="fecha_ini" size="11" maxlength="10"
             value="<? echo "$fecha_ini"; ?>" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" title="Calendario"
           onClick="muestraCalendarioRango('','albaranes','fecha_ini','fecha_fin');">
    </td>

    <!-- FECHA FIN: también abre calendario de rango -->
    <td>
      <input name="fecha_fin" title="Fecha Fin" type="text" id="fecha_fin" size="11" maxlength="10"
             value="<? echo "$fecha_fin"; ?>" onBlur="control_fechas_conta(event)">
      <img src="/comun/imgs/calendario.gif" title="Calendario"
           onClick="muestraCalendarioRango('','albaranes','fecha_ini','fecha_fin');">
    </td>

    <td colspan="4">
      <input name="observaciones" title="observaciones" type="text" id="observaciones" size="50" maxlength="40"
             value="<? echo a_html($observaciones,"bd->input"); ?>">
    </td>

    <td>
      <img src="/comun/imgs/guardar2.gif" title="Guardar" onClick="enviar(event);" onMouseOver="window.top.focus();">
    </td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>

<?
/*--------------------------------------------------------------------------------------------
  LISTADO
--------------------------------------------------------------------------------------------*/
if($cod_operario)
  $mostrar_art="SELECT * FROM op_fiestas WHERE cod_operario='$cod_operario'";
else
  $mostrar_art="SELECT * FROM op_fiestas";

$result_art=mysql_query($mostrar_art, $link) or die ("No se han seleccionado: ".mysql_error()."<br /> $mostrar_art <br />");
$total_filas=mysql_num_rows($result_art);

$lineas_mostrar=20;
$limit=paginar("limitar");

if ($total_filas > 0)
{
  $mostrar_art .= " ORDER BY cod_operario,fecha_ini $limit";
  $result_art=mysql_query($mostrar_art, $link) or die ("No se han seleccionado: ".mysql_error()."<br /> $mostrar_art <br />");

  while($art=mysql_fetch_array($result_art))
  {
    $cod_operario=$art["cod_operario"];
    $fecha_ini=fecha_esp($art["fecha_ini"]);
    $fecha_fin=fecha_esp($art["fecha_fin"]);
    $nombre_op=sel_campo("nombre_op","","operarios","cod_operario = '$cod_operario'");
    $observaciones=$art["observaciones"];

    $cont_color++;
    if ($cont_color % 2 == 0) $color=$color_par;
    else $color=$color_impar;
?>
  <tr bgcolor="<? echo $color; ?>">
    <td>&nbsp;</td>
    <td><div align="left"><? echo $cod_operario; ?> <? echo $nombre_op; ?></div></td>
    <td><? echo $fecha_ini; ?></td>
    <td><? echo $fecha_fin; ?></td>
    <td colspan="4"><? echo $observaciones; ?></td>

    <td>
      <img src="/comun/imgs/editar.gif" title="Modificar"
           onClick="enlace(direccion_conta(''),'cod_operario','<? echo $cod_operario; ?>','fecha_ini','<? echo $fecha_ini; ?>','observaciones','<? echo $observaciones; ?>','fecha_fin','<? echo $fecha_fin; ?>','','','','','','','','','','','','');">
      <img src="/comun/imgs/eliminar2.gif" title="Eliminar"
           onClick="if(confirm('¿Está seguro de que desea borrar el festivo <? echo $fecha_fin; ?> del conductor <? echo a_html($cod_operario.': '.$nombre_op,'bd->javascript'); ?>?')) {enlace(direccion_conta(''),'cod_operario','<? echo a_html($cod_operario,'bd->javascript'); ?>','fecha_ini','<? echo $fecha_ini; ?>','fecha_fin','<? echo $fecha_fin; ?>','eliminar','1','conservar_oper','<? if ($cod_oper) {echo 'si';} ?>','','','','','','','','','','')};">
    </td>

    <td>&nbsp;</td>
  </tr>
<?
  }
}

paginar("rellenar");
?>

  <tr>
    <td>&nbsp;</td>
    <td colspan="8">
<?
$campo_pag[1]="cod_operario"; $valor_pag[1]=$cod_oper;
paginar("paginar");
?>
    </td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td colspan="8"><hr /></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td colspan="2" align="center">
      <img src="/comun/imgs/nuevo.gif" title="Nuevo" onClick="location.href=direccion_conta('');"><br />
      Nuevo
    </td>
    <td width="223" align="center">&nbsp;</td>
    <td width="76" align="center">&nbsp;</td>
    <td width="40">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

</form>
</table>
</body>
</html>
