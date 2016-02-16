<style>
	#buscador{
		height: auto;
		border: 0px none;
		margin-top: 20px;
	}
	
	#buscador .buscartexto{
		font-size: 15px;
		position: initial;
		padding: 0px 15px;
		margin: 10px 0px;
	}
	
	#buscador #buscarfield{
		position: initial;
		height: 25px;
		margin: 10px 0px 10px -40px;
		width: 95%;
	}
	
	#buscador #buscar{
		position: initial;
		margin: 7px 0px 6px -30px;
		height: 30px;
		width: 95px;
		font-size: 13px;
	}
	
	#filtro_barra_lateral{margin-top: -20px;}
</style>
<div id="avisos" class="col-md-12 nospaces">
	<div class="row">
		<?php echo $this->element('breadcrumb'); ?>
		<div class="col-md-4 ofertas">
			<div class="subcontent">
				<?php echo $this->element('filtro_barra_lateral'); ?>
			</div>
		</div>
		<div class="col-md-8" style="float: right;">
			<?php echo $this->Element('buscador'); ?>
		</div>
		<div class="col-md-8 destacados" style="float: right;">
			<div class="subcontent">
				<?php $cantidad = count($avisos); ?>
				<p class="resultados">Se <?php echo ($cantidad==1?'encontró':'encontraron').' '.$cantidad.' oferta'.($cantidad==1?'':'s'); ?> de trabajo en la siguiente búsqueda:</p>
				<!--<div class="titulo">
					<h3>Avisos sponsoreados</h3>
				</div>-->
				<ul class="lista">
					<!--<div class="sponsoreado">
					<?php
						/*for($i=0;$i<3;$i++){
							echo $this->element('item_listado_aviso');
						}*/
					?>
					</div>-->
					<?php 
						foreach($avisos as $aviso){
							echo $this->element('item_listado_aviso',array('aviso'=>$aviso));
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>