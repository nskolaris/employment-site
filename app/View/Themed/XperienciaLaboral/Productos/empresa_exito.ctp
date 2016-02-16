<script>
	function GoHome(){
		window.location.href = "<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'index')); ?>";
	}
</script>
<div class="col-md-12" style="text-align: center; padding: 15px; font-size: 22px;">
	El producto fue adquirido con exito. Un ejecutivo se contactara con usted para activarlo.<br><br>
	<button type="button" onClick="GoHome();" class="btn btn-primary">Volver al inicio</button>
</div>