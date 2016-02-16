<form action="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'login')); ?>" method="post">
	<div class="col-md-4" style="margin: auto; position: absolute; left: 0px; right: 0px; top: 60px;">
		<div class="item row">
			<label for="">Usuario</label>
			<input name="username" class="botonplano inputplano" />
		</div>
		<div class="item row">
			<label for="">Contraseña</label>
			<input name="password" type="password" class="botonplano clave inputplano" />
		</div>
		<div class="item row">
			<input class="botonplano submit" type="submit" value="Iniciar Sesión" />
		</div>
	</div>
</form>