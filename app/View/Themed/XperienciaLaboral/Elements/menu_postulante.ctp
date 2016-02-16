<script>
	$(document).ready(function(){
	
		<?php if(isset($location)){ ?>
			var selected = '<?php echo $location; ?>';
			$('#menu_postulante li#'+selected).addClass('selected');
		<?php } ?>
		
		$('#menu_postulante li').css('cursor','pointer');
		
		$('#menu_postulante li').click(function(){
			window.location = $this.attr('url');
		});
	});
</script>
<div class="col-md-12 menu" id="menu_postulante">
	<ul class="nospaces">
		<li url="<?php echo $this->Html->Url('javascript:void(0);'); ?>">Contraseña</li>
		<li url="<?php echo $this->Html->Url('javascript:void(0);'); ?>">Notificaciones</li>
		<li id="micv" url="<?php echo $this->Html->Url(array('controller'=>'users','action'=>'datos')); ?>">Mi CV</li>
		<li url="<?php echo $this->Html->Url('javascript:void(0);'); ?>">Mis postulaciones</li>
		<li url="<?php echo $this->Html->Url('javascript:void(0);'); ?>">Privacidad</li>
	</ul>
</div>