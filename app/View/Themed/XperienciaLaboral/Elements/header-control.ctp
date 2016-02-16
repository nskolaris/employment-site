<script>
	$(document).ready(function(){
		var width = $('#header .user-menu').outerWidth();
		$('#header .user-menu').width(width);
	
		$('#header .user-menu').click(function(){
			ToogleMenu();
		});
		
		function ToogleMenu(){
			if($('#header .user-menu .items').is(":visible")){
				$('#header .user-menu .glyphicon').removeClass('glyphicon-chevron-down');
				$('#header .user-menu .glyphicon').addClass('glyphicon-chevron-right');
				$('#header .user-menu .items').animate({height: 0},250,function(){
					$('#header .user-menu .items').hide();
				});
				
			}else{
				$('#header .user-menu .glyphicon').removeClass('glyphicon-chevron-right');
				$('#header .user-menu .glyphicon').addClass('glyphicon-chevron-down');
				$('#header .user-menu .items').height(0);
				$('#header .user-menu .items').show();
				$('#header .user-menu .items').animate({height: $('#header .user-menu .items').get(0).scrollHeight},250);
			}
		}
	});
</script>

<div id="bar" class="col-md-12">
	<div class="row">
		<div class="col-md-6">
			<div class="logo"></div>
		</div>
		<div class="col-md-3">
			<div class="links">
				<span>Consultas</span>
				<span class="tel">(52) 55 26 31 63 58</span>
			</div>
		</div>
		<div class="col-md-3">
			<?php if(isset($admin)){ ?>
				<div class="user-menu">
					<div class="name"><?php echo $admin['Admin']['username']; ?></div>
					<div class="glyphicon glyphicon-chevron-right" style="float: right;"></div>
					<ul class="items">
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'pages','action'=>'home')); ?>">Home y estadísticas</a></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'empresas','action'=>'control_index')); ?>">Empresas</a></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'control_index')); ?>">Avisos</a></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'control_compras')); ?>">Compras</a></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'control_gestionar')); ?>">Productos</a></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'control_gestionar')); ?>">Usuarios</a></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'slides','action'=>'control_index')); ?>">Gestion del slider</a></li>
						<li class="separador"></li>
						<li><a href="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'logout')); ?>">Logout</a></li>
					</ul>
				</div>
			<?php } ?>
		</div>
	</div>
</div>