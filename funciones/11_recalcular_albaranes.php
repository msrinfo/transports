<?
// Mostramos hora de inicio:
echo "<br />".mostrar_hora()."<br />";


// Seleccionamos facturas que NO son rectificativas:
$select_fac="SELECT * FROM albaranes WHERE cod_cliente=1549";
echo "<br /> $select_fac <br />";
$query_fac=mysql_query($select_fac) or die ("<br /> No se han seleccionado albaranes: ".mysql_error()."<br /> $select_fac <br />");

$cont=0;

while($fac=mysql_fetch_array($query_fac))
{
$cod_albaran=$fac["cod_albaran"];
$cod_empresa=$fac["cod_empresa"];
$fecha=$fac["fecha"];
$cod_cliente=$fac["cod_cliente"];
$prec_desc_bomba_cli=$fac["prec_desc_bomba_cli"];
$lts_desc_bomba=$fac["lts_desc_bomba"];
$total_servidos=$fac["total_servidos"];
$precio_cli=$fac["precio_cli"];
$prec_doble_carga_cli=$fac["prec_doble_carga_cli"];
$prec_doble_desc_cli=$fac["prec_doble_desc_cli"];
$horas_espera=$fac["horas_espera"];
$prec_horas_espera=$fac["prec_horas_espera"];

$cant_blue=$fac["cant_blue"];
$cant_sp95=$fac["cant_sp95"];
$cant_sp98=$fac["cant_sp98"];
$cant_go_a=$fac["cant_go_a"];
$cant_go_a1=$fac["cant_go_a1"];
$cant_go_b=$fac["cant_go_b"];
$cant_go_c=$fac["cant_go_c"];
$cant_bio=$fac["cant_bio"];

$serv_blue=$fac["serv_blue"];
$serv_sp95=$fac["serv_sp95"]; 	
$serv_sp98=$fac["serv_sp98"];	
$serv_go_a=$fac["serv_go_a"];
$serv_go_a1=$fac["serv_go_a1"];
$serv_go_b=$fac["serv_go_b"];
$serv_go_c=$fac["serv_go_c"];
$serv_bio=$fac["serv_bio"];

$a_cobrar=$fac["a_cobrar"];

$suma_pedidos= $cant_blue + $cant_sp95 + $cant_sp98 + $cant_go_a + $cant_go_a1 + $cant_go_b + $cant_go_c + $cant_bio;

$suma_servidos = $serv_blue + $serv_sp95 + $serv_sp98 + $serv_go_a + $serv_go_a1 + $serv_go_b + $serv_go_c + $serv_bio;

if($a_cobrar=="1")
{
$total_servidos=1;
}
else
{
$total_servidos=$suma_servidos;
}
$base= (($prec_desc_bomba_cli * $lts_desc_bomba) + ($total_servidos * $precio_cli) + $prec_doble_carga_cli + $prec_doble_desc_cli) + ($horas_espera * $prec_horas_espera);


$update_fac="UPDATE albaranes SET

base='$base'

WHERE cod_albaran = '$cod_albaran' and cod_empresa = '$cod_empresa'";

$query_update_fac=mysql_query($update_fac) or die ("<br /> No se ha actualizado facturas: ".mysql_error()."<br /> $update_fac <br />");

$cont++;
} // Fin de while($fac=mysql_fetch_array($query_fac))
//} // Fin de while($emp=mysql_fetch_array($query_emp))

// Mostramos hora de finalización:
echo "<br />".mostrar_hora()."<br />";
?>
<script type='text/javascript'>
alert('Recálculo de albaranes completado. <? echo $cont; ?>');
</script>