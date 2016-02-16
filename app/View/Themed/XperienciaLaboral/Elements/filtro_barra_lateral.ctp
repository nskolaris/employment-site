<script>
	$(document).ready(function(){
	
		$('#filtro_barra_lateral .titulo a').first().addClass('activado');
		$('#filtro_barra_lateral .lista').first().show();
	
		$('#filtro_barra_lateral .titulo a').click(function(){
			$('#filtro_barra_lateral .lista').hide();
			$('#filtro_barra_lateral .titulo a').removeClass('activado');
			$(this).addClass('activado');
			$('#filtro_barra_lateral #lista-'+$(this).attr('id')).show();
		});
		
	});
</script>
<div id="filtro_barra_lateral">
	<?php 
		if(!empty($conditions)){
			foreach($conditions as $i => $condition){
				if($i == 'Aviso.area_id'){
					$filtro_area_activo = true;
				} 
				if($i == 'Aviso.provincia_id'){ 
					$filtro_provincia_activo = true;
				}
			}
		} 
	?>
	<?php if(!isset($filtro_area_activo) || !isset($filtro_provincia_activo)){ ?>
		<div class="titulo">
			<h4>
				Ofertas por 
				<?php if(!isset($filtro_area_activo)){ ?><a href="javascript:void(0);" id="area">Área</a><?php } ?>
				<span>|</span>
				<?php if(!isset($filtro_provincia_activo)){ ?><a href="javascript:void(0);" id="ubicacion">ubicación</a><?php } ?>
			</h4>
		</div>
		<?php 
			$url_replaced = str_replace('avisos','',$this->params->url);
			$url = 'avisos'.$url_replaced.'/';
		?>
		<?php if(!isset($filtro_area_activo)){ ?>
			<ul class="lista" id="lista-area" style="display: none;">
				<?php foreach($areas_avisos as $i => $area){ ?>
					<li><a href="<?php echo $url.strtolower($area).'-a'.$i; ?>"><?php echo $area; ?></a></li>
				<?php } ?>
			</ul>
		<?php } ?>
		<?php if(!isset($filtro_provincia_activo)){ ?>
			<ul class="lista" id="lista-ubicacion" style="display: none;">
				<?php foreach($ubicaciones_avisos as $i => $ubicacion){ ?>
					<li><a href="<?php echo $url.strtolower($ubicacion).'-p'.$i; ?>"><?php echo $ubicacion; ?></a></li>
				<?php } ?>
			</ul>
		<?php } ?>
	<?php } ?>
</div>