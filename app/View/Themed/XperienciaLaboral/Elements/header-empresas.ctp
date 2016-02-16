<script>
	var menu_is_open = false;
	function ToggleMenu(){
		var menu = $('#dropdownbotonmenupostulante');
		if(!menu_is_open){
			menu.show();
			menu.offset({top: $('.dropdown button').offset().top + $('.dropdown button').outerHeight(), left: $('.dropdown button').offset().left});
			menu.height(0);
			menu.animate({height: menu.get(0).scrollHeight},500,function(){
				menu.css('height','auto');
				menu_is_open = true;
			});
		}else{
			menu.animate({height: 0},500,function(){
				menu.hide();
				menu_is_open = false;
			});
		}
	}
</script>
<div id="bar" class="col-md-12">
	<div class="row">
		<div class="col-md-4">
			<a href="<?php echo $this->Html->Url('/');?>" ><?php echo $this->Html->image('logo-empresas.png', array('alt' => 'Xperiencia Laboral','class'=>'logo')); ?></a>
		</div>
		<div class="col-md-8">
		
			<div class="links">
				<?php if(!isset($user['UsuarioInterno'])){ ?>
					<span><?php echo $this->Html->Link('Registrar Empresa',array('controller'=>'empresas','action'=>'add')); ?></span>
					<span class="separator">|</span>
				<?php } ?>
				<span><a href="#">Consultas</a></span>
				<span class="tel">Te. (52) 55 26 31 63 58</span>
			</div>
			
			<?php if(isset($user['UsuarioInterno'])){ ?>
				<div class="col-md-3">
					<div class="user-menu">
						<div class="image"></div>
						<div class="name"><?php echo $user['UsuarioInterno']['nombre'].' '.$user['UsuarioInterno']['apellido'].' | '.$user['Empresa']['nombre_comercial']?></div>
						<div class="glyphicon glyphicon-chevron-right" style="float: right;"></div>
						<ul class="items">
							<li><a href="<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'index')); ?>">Avisos</a></li>
							<li><a href="<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'add')); ?>">Nuevo Aviso</a></li>
							<li><a href="<?php echo $this->Html->Url(array('controller'=>'empresas','action'=>'edit')); ?>">Datos de la empresa</a></li>
							<li><a href="<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'index')); ?>">Productos</a></li>
							<li class="separador"></li>
							<li><a href="<?php echo $this->Html->Url(array('controller'=>'empresas','action'=>'logout')); ?>">Logout</a></li>
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>