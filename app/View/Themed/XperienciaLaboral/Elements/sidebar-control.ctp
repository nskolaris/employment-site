<?php if(isset($admin)){ ?>
	<script>
		$(document).ready(function(){
			$('#expand').click(function(){
				ToogleExpansion();
			});
			
			function ToogleExpansion(){
				if(!$('#expand').hasClass('expanded')){
					$('#expand').addClass('expanded');
					$('#sidebar .row a').addClass('open');
					$('#sidebar .row a').animate({fontSize: '15px'},250,function(){
						$('#sidebar .row a .text').css('opacity','0');
						$('#sidebar .row a .text').css('display','inline-block');
						$('#sidebar .row a .text').animate({opacity: '1'},250);
					});
					$('#content').animate({left: '15%'},250,function(){});
					$('#sidebar').animate({width: '15%'},250,function(){});
				}else{
					$('#expand').removeClass('expanded');
					$('#sidebar .row a .text').hide();
					$('#sidebar .row a').animate({fontSize: '25px'},250,function(){
						$('#sidebar .row a').removeClass('open');
					});
					$('#content').animate({left: '5%'},250,function(){});
					$('#sidebar').animate({width: '5%'},250,function(){});
				}
			}
		});
	</script>
	<div class="row">
		<a id="expand" class="item glyphicon glyphicon-chevron-right" href="javascript:void(0);"></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon-home" href="<?php echo $this->Html->Url(array('controller'=>'pages','action'=>'control_home')); ?>"><div class="text">Home y estadísticas</div></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon-briefcase" href="<?php echo $this->Html->Url(array('controller'=>'empresas','action'=>'control_index')); ?>"><div class="text">Empresas</div></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon-file" href="<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'control_index')); ?>"><div class="text">Avisos</div></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon-usd" href="<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'control_compras')); ?>"><div class="text">Compras</div></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon-shopping-cart" href="<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'control_gestionar')); ?>"><div class="text">Productos</div></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon glyphicon-user" href="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'control_gestionar')); ?>"><div class="text">Usuarios</div></a>
	</div>
	<div class="row">
		<a class="item glyphicon glyphicon glyphicon-forward" href="<?php echo $this->Html->Url(array('controller'=>'slides','action'=>'control_index')); ?>"><div class="text">Gestion del slider</div></a>
	</div>
<?php } ?>