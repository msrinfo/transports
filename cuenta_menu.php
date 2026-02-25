<div class="capa_principal visibilidad" id="contenedor_principal"><!-- align="left" -->
<ul id="lista0">

<?
//echo "<br /> login: $login <br />";

if ($login=="nobody")
{
} // Fin de login

else
{
?>

<!-- ---------------------------------- GESTIÓN MOSTRADOR ------------------------------------ -->

<li>Gestió Mostrador

	<div class="pos_relativa"><div class="pos_submenus">
	<ul>
	<!--<li onClick="enlace_menu('/<? echo $carpeta_conta; ?>/2_procesos_diarios/buscar_cuentas.php');"> funcion</li>
	<li onClick="enlace_menu('/<? echo $carpeta_comun."/".$carpeta_basicos; ?>/01_01_clientes.php');"> Clients</li>-->
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes_rap.php');">Albarans R&agrave;pids</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php');">Albarans Transport</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_servicios_gondola.php');">Serveis Góndola</li>

	
	
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/0_0_impr_albaranes.php');">Full Viatges Conductor</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/6_combinacion/1_1_menu_hoja_dia.php');">Programació Dia</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_4_crtl_alb.php');">Control Dia Conductors</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/2_1_resumen_alb.php');">Resum Albarans</li>
	</ul>
	</div></div>
</li>

<!-- ---------------------------------- GESTIÓN FICHEROS ------------------------------------ -->

<li>Gestió Fitxers

	<div class="pos_relativa"><div class="pos_submenus">
	<ul>
	
<!-- ---------------------------------- BÁSICOS COMÚN ------------------------------------ -->
<?
// Incluímos el archivo necesario para mostrar el menú de básicos común:
include $carpeta_comun."/".$carpeta_basicos."/00_00_basicos_menu.php";
?>
<!-- ---------------------------------- FIN DE: BÁSICOS COMÚN ---------------------------- -->

	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/11_descargas.php');">Desc&agrave;rregues</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/7_operarios.php');">Conductors</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/7_1_operarios_fiestas.php');">Festes Conductors</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/12_terminales.php');">Terminals</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/13_operadoras.php');">Operadores</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/17_tractoras.php');">Tractores</li>
    <li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/17_tractoras_revisiones.php');">Tractores Revisions</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/18_cisternas.php');">Cisternes</li>
    <li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/18_cisternas_revisiones.php');">Cisternes Revisions</li>
    <li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/14_tarjetas.php');">Targetes</li>
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/16_tarifas.php');">Tarifes</li>
	<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_basicos; ?>/00_01_listados_basicos.php');">Listados</li>

	</ul>
	</div></div>
</li>

<!-- ---------------------------------- ADMINISTRACIÓN ------------------------------------ -->

<li>Administració <? echo $usuario_any; ?>

	<div class="pos_relativa"><div class="pos_submenus">
	<ul>
		
	<li>1. Gestió Albarans &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes_rap.php');">1. Albarans R&agrave;pids</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_albaranes.php');">2. Albarans Transport</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_3_litros_servidos.php');">3. Llitres Servits Real </li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/3_1_resumen_lts.php');">5. Resum Llitres</li>
		</ul>
		</div></div>
	</li>

	<li>2. Gestió Serveis &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/1_1_servicios_gondola.php');">1. Serveis Góndola</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/4_1_resumen_serv.php');">2. Resum de Serveis</li>
		</ul>
		</div></div>
	</li>

	<li>3. Facturació Serveis &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/1_1_fac_serv_crear.php');">1. Facturar Serveis</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/2_1_fac_serv_ver.php');">2. Factures Veure</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/3_1_fac_serv_copias.php');">3. Factures C&ograve;pies</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/4_fac_serv_anular.php');">4. Factures Serv. Anular</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/7_1_resumen_env.php');">9. Resumen Envíos Fact</li>	
		
		</ul>
		</div></div>
	</li>

	<li>4. Facturaci&oacute; Albarans &raquo;
      <div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/1_1_fac_alb_crear.php');">1. Facturar Albarans </li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/2_1_fac_alb_ver.php');">2. Factures Veure</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/3_1_fac_alb_copias.php');">3. Factures C&ograve;pies</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/4_facturas_anular.php');">4. Factures Anular</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/5_1_recibos_facturas.php');">5. Rebuts de Factures</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/5_gestion_facturacion/6_recibos_manuales.php');">6. Rebuts Manuals</li>
		<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_basicos; ?>/20_10_rectificativas.php');">7. Rectificativas</li>
		<!--<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_basicos; ?>/20_20_cobros.php');">8. Cobraments</li>-->
		
		</ul>
		</div></div>
	</li>
	
    <li>5. Gestió Cobraments &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/7_gestion_remesas/03_02_rem.php');">1. Cobros Remesa</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/7_gestion_remesas/03_02_rem_fac.php');">2. Cobros Rem. Factures</li>
        <li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/7_gestion_remesas/03_03_rem.php');">3. LListat Remeses</li>
        <li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/7_gestion_remesas/04_01_pagos.php');">4. Pagaments</li>
         <li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/7_gestion_remesas/03_01_cobros.php');">5. Cobraments</li>
 
		</ul>
	</div></div>
	</li>
    
      <li>6. Gestió SERES &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/SERES/01_01_facts_seres.php');">Enviament Factures</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/SERES/3_1_resumen_facturas.php');">Resumen Factures</li>
 
		</ul>
	</div></div>
	</li>
    
      
      <li>7. Albarans iCloud &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/iCloud/01_01_albs_envio.php');">Enviament Albarans</li>
        <li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/iCloud/02_01_albs_recepcion.php');">Recepció Albarans</li>
        <li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/iCloud/2_1_resumen_alb.php');">Resum Enviats/Rebuts</li>
       <!-- <li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/iCloud/04_00_albs_confirmats.php');">Resum Confirmats</li> -->
 
		</ul>
	</div></div>
	</li>
  <!-- -->
	</ul>
	</div></div>
</li>

<!-- ---------------------------------- GESTIÓN ALMACÉN ------------------------------------ -->

<li>Gesti&oacute; Compres
  <div class="pos_relativa">
    <div class="pos_submenus">
      <ul>
	  
		<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_basicos; ?>/20_30_compras.php');">1. Factures de Compres</li>	
		<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_estad; ?>/2_proveedores/3_1_resumen_compras.php');">2. Resum Compres</li>	
		<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_estad; ?>/2_proveedores/7_1_resumen_vencimientos.php');">3. Resum Venciments</li>	
		</ul>
		
    </div>
  </div>
</li>

<!-- ---------------------------------- GESTIÓN ESTADÍSTICAS ------------------------------------ -->

<li>Gestió Estadístiques
  
  <div class="pos_relativa"><div class="pos_submenus">
	<ul>

<!-- ---------------------------------- ESTADÍSTICA COMÚN ------------------------------------ -->
<?
// Incluímos el archivo necesario para mostrar el menú de estadística común:
include $carpeta_comun."/".$carpeta_estad."/estad_menu.php";


?>
<!-- ---------------------------------- FIN DE: ESTADÍSTICA COMÚN ---------------------------- -->

	<li>3. Estadística Albarans &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/1_1_alb_tar.php');">1. Targetes</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/2_1_alb_nominas.php');">2. N&ograve;mines No Detallat</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/2_1_alb_nominas_detall.php');">3. N&ograve;mines Detallat</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/3_1_alb_descargas.php');">4. Descàrregues</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/4_1_alb_dietas.php');">5. Dietes</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/5_1_op_festes.php');">6. Operaris Festes</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/3_estadistica_alb/7_1_alb_incidencies.php');">7. Albarans Incidències</li>
		</ul>
		</div></div>
	</li>

	<li>4. Estadística Serveis &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/3_administracion/4_gestion_albaranes/2_1_resumen_serv.php');">1. Serveis Matr&iacute;cules</li>
		</ul>
		</div></div>
	</li>
  
  	<li>5. Estadística Vehiculos &raquo;

		<div class="pos_relativa"><div class="pos_submenus2">
		<ul>
        
			<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/6_estadistica_vehiculos/1_1_terminales.php');">1. Terminales</li>
			<li onClick="enlace_menu('/<? echo $carpeta; ?>/5_gestion_estadisticas/6_estadistica_vehiculos/2_1_control_vehiculos.php');">2. Control Vehiculos</li>
		</ul>
		</div></div>
	</li>

	</ul>
	</div></div>
</li>

<!-- ---------------------------------- CONTABILIDAD ------------------------------------ -->
<?
// Incluímos el archivo necesario para mostrar el menú de contabilidad:
include $carpeta_conta."/conta_menu.php";
?>
<!-- ---------------------------------- FIN DE: CONTABILIDAD ---------------------------- -->


<!-- ---------------------------------- UTILIDADES -------------------------------------- -->

<li>Utilitats

	<div class="pos_relativa"><div class="pos_submenus">
	<ul>
	<!--<li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/01_envio_mail.php');">MM</li>-->
	<li onClick="enlace_menu('/<? echo $carpeta; ?>/2_gestion_ficheros/15_act_prec_desc.php');">Preus Desc&agrave;rregues</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/11_recalcular_albaranes.php');">Rec. Alb</li>
		<li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/11_regenera_asientos.php');">Reg Astos</li>
       <? if($login=='admin') { ?>
        <li onClick="enlace_menu('/<? echo $carpeta; ?>/funciones/SERES/01_01_facts_seres.php');">SERES</li>
		
	<? } ?>
	
<!-- ---------------------------------- UTILIDADES COMÚN -->
<?
include $carpeta_comun."/".$carpeta_basicos."/00_10_menu_utilidades.php";
?>
<!-- ---------------------------------- FIN DE: UTILIDADES COMÚN -->

<? if ($existe_tabla_cerr=='si' && ($login=='admin' || $login=='silvia')) { ?>
	<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_utilidades; ?>/02_cerrar_any.php?accion=cerrar');"><a>CERRAR FACT. <? echo $usuario_any; ?></a></li>
	<li onClick="enlace_menu('/<? echo $carpeta_comun; ?>/<? echo $carpeta_utilidades; ?>/02_cerrar_any.php?accion=abrir');"><a>ABRIR FACT. <? echo $usuario_any; ?></a></li>
<? } ?>	
	<!--
	-->
	</ul>
	</div></div>
</li>

<?
} // Fin de else
?>
</ul>
</div>