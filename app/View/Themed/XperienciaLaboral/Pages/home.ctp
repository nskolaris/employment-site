<?php echo $this->element('slider'); ?>
<?php echo $this->element('buscador'); ?>
<div id="empleos" class="col-md-12 nospaces">
	<div class="row">
		<div class="col-md-4 ofertas">
			<div class="subcontent">
				<?php echo $this->element('filtro_barra_lateral'); ?>
			</div>
		</div>
		<div class="col-md-8 destacados">
			<div class="subcontent">
				<div class="titulo">
					<h3>Empleos Destacados</h3>
				</div>
				<ul class="lista">
					<?php 
					foreach($destacados as $aviso){
						echo $this->element('item_listado_aviso',array('aviso'=>$aviso));
					}
					?>
				</ul>
				<?php //echo $this->Html->Link('Ver más vacantes',array('controller'=>'avisos','action'=>'index')); ?>
				<button type="button" class="btn btn-primary" onClick="window.location.href='<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'index')); ?>';">Ver más vacantes</button>
			</div>
		</div>
	</div>
</div>