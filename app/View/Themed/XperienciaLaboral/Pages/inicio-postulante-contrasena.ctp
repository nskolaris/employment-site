<div id="contrasena" class="col-md-12 nospaces form-personal">
	<div class="row">
		<div class="col-md-12 form-contrasena">
			<?php 
				if(!isset($empresa)){
					$url = $this->Html->Url(array('controller'=>'usuarios','action'=>'cambiar_clave'));
				}else{
					$url = $this->Html->Url(array('controller'=>'empresas','action'=>'cambiar_clave'));
				}
			?>
			<form method="post" action="<?php echo $url; ?>">
				<div>
					<?php if($token == null){ ?>
					<div class="item row">
						<div class="col-md-4">
							<label for="password">Contraseña actual</label>
						</div>
						<div class="col-md-4">
							<input type="password" name="password" class="botonplano inputplano" />
						</div>
					</div>
					<?php }else{ ?>
						<input type="hidden" name="token" value="<?php echo $token; ?>" />
					<?php } ?>
					<div class="item row">
						<div class="col-md-4">
							<label for="new_password">Contraseña nueva</label>
						</div>
						<div class="col-md-4">
							<input type="password" name="new_password" class="botonplano inputplano" />
						</div>
					</div>
					<div class="item row">
						<div class="col-md-4">
							<label for="repeat_new_password">Repetir contraseña nueva</label>
						</div>
						<div class="col-md-4">
							<input type="password" name="repeat_new_password" class="botonplano inputplano" />
						</div>
					</div>
					<div class="item row">
						<div class="col-md-4 col-md-offset-4">
							<input class="submit botonplano" type="submit" value="Guardar"/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>