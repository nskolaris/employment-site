<script>
	$(document).ready(function(){
		/*$('#buscador #buscar').click(function(){
			if($('#buscador #buscarfield').val() != ''){
				window.location.href = "<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'busqueda')); ?>/"+$('#buscador #buscarfield').val();
			}
		});*/
	});
</script>
<div id="buscador" class="col-md-12 nospaces">
	<div class="row">
		<?php echo $this->Form->create('Aviso',array('action'=>'busqueda')); ?>
		<div class="col-md-4 nospaces">
			<label class="buscartexto">Buscador de empleos:</label>
		</div>
		<div class="col-md-6 nospaces">
			<!--<input id="buscarfield" class="botonplano inputplano" />-->
			<?php echo $this->Form->input('Aviso.keywords',array('class'=>'botonplano inputplano','label'=>'','id'=>'buscarfield')); ?>
		</div>
		<div class="col-md-2 nospaces">
			<input id="buscar" type="submit" value="Buscar" class="botonplano" />
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>