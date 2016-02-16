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
			<a href="<?php echo $this->Html->Url('/');?>" ><?php echo $this->Html->image('logo.png', array('alt' => 'Xperiencia Laboral','class'=>'logo')); ?></a>
		</div>
		<div class="col-md-7">
			<?php if(!isset($user)){ ?>
				<?php echo $this->Html->link($this->Html->image('ingresar.png'),'javascript:void(0);',array('onClick'=>'ToogleLoginPopup();','class'=>'boton-bar ingresar', 'escape'=>false)); ?>
				<?php echo $this->Html->link($this->Html->image('cargarcv.png'),'javascript:void(0);',array('class'=>'boton-bar cargarcv', 'escape'=>false, 'onClick' => 'ToogleRegisterPopup();')); ?>
				<?php echo $this->Html->image('separador.gif',array('class'=>'separador')); ?>
				<?php echo $this->Html->link($this->Html->image('empresas.png'),array('controller'=>'empresas'),array('class'=>'boton-bar empresas', 'escape'=>false)); ?>
			<?php }else{ ?>
				<div class="col-md-5 col-md-offset-9">
					<div class="dropdown" id="botonmenupostulante" >
					  <button class="btn btn-default botonplano" onClick="ToggleMenu();" type="button">
						<?php echo (isset($user['DatosPersonales']['nombre']) && isset($user['DatosPersonales']['apellido'])?$user['DatosPersonales']['nombre'].' '.$user['DatosPersonales']['apellido']:$user['Usuario']['email']); ?>
						<span class="caret"></span>
					  </button>
						<ul id="dropdownbotonmenupostulante" class="dropdown-menu" role="menu">
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'cambiar_clave')); ?>">Contraseña</a>
							</li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'datos')); ?>">Mi CV</a>
							</li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'postulaciones')); ?>">Mis Postulaciones</a>
							</li>
							<li role="presentation" class="divider"></li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'logout')); ?>">
									<strong>Cerrar Sesión</strong>
								</a>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>