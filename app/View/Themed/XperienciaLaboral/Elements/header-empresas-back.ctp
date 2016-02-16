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
		<div class="col-md-3">
			<div class="logo"></div>
		</div>
		<div class="col-md-3">
			<?php 
				$has_avisos_restantes = (isset($empresa_producto['avisos_restantes']) && $empresa_producto['avisos_restantes'] > 0);
				$has_dias_restantes = (isset($empresa_producto['dias_restantes']) && $empresa_producto['dias_restantes'] > 0);
				$padding = ($has_avisos_restantes^$has_dias_restantes?'13':'5');
			?>
			<div style="padding: <?php echo $padding; ?>px 0px;">
				<div class="producto_activo">
					<?php if($has_avisos_restantes){ ?>
						Avisos disponibles: <?php echo $empresa_producto['avisos_restantes']; ?>
					<?php }if($has_dias_restantes){ ?>
						<?php if($has_avisos_restantes){ ?><br><?php } ?>
						Dias restantes de la suscripción: <?php echo $empresa_producto['dias_restantes']; ?>
					<?php } ?>
					<?php if(!$has_avisos_restantes && !$has_dias_restantes){ ?>
						No tiene ningun plan de avisos activo,<br>para comprar haga click <a href="<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'index')); ?>">aqui</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div style="padding: 13px 0px;">
				<span>Consultas</span>
				<span class="tel">(52) 55 26 31 63 58</span>
			</div>
		</div>
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
	</div>
</div>