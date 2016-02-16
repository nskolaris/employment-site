<?php echo $this->element('slider',array('empresas'=>true)); ?>
<script>
	function RecoverPassword(){
		if((username = $('.subcontent form [name="username"]').val()) != ''){
			$.post('<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'recover_password_empresa')); 5?>',{username: username},function(response){
				response_decoded = JSON.parse(response);
				alert(response_decoded.message);
			});
		}else{
			alert('Debe ingresar un nombre de usuario');
		}
	}
</script>
<div id="empresas" class="col-md-12">
	<div class="row">
		<div class="col-md-8 herramientas nospaces">
			<div class="subcontent">
				<h3>Las mejores herramientas para administrar y facilitar tus búsquedas.</h3>
				<ul class="listaherramientas">
					<li class="herr_publicacion">
						<h3>Publicación inmediata de su vacante laboral. <br/>Buena relación costo/resultado en cvs (currículums)</h3>
						<p>Los avisos aparecerán online inmediatamente después de terminar el proceso de publicación.</p></li>
					<li class="herr_clasificacion">
						<h3>Clasificación de candidatos</h3>
						<p>Los avisos aparecerán online inmediatamente después de terminar el proceso de publicación.</p></li>
					<li class="herr_notas">
						<h3>Notas en los CVs</h3>
						<p>Incluí comentarios en los CV's usando las notas en cada uno.</p>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-4 registro_login nospaces">
			<div class="row">
			
				<div class="col-md-12 registrarEmpresa itemRegistroLogin">
					<div class="subcontent">
						<h3>¿Eres nuevo en el sitio?</h3>
						<div class="linkRegistrarEmpresa">
							<?php echo $this->Html->link($this->Html->image('registrarempresa.jpg'),array('controller'=>'empresas','action'=>'add'),array('class'=>'', 'escape'=>false)); ?>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 loginEmpresa itemRegistroLogin">
					<div class="subcontent">
						<form method="post" action="<?php echo $this->Html->Url(array('controller'=>'empresas','action'=>'login')); ?>">
							<h3>Empresas registradas</h3>
							<div class="input">
								<input name="username" class="botonplano inputplano inputcuadrado" placeholder="Usuario"/>
							</div>
							<div class="input">
								<input name="password" type="password" class="botonplano inputplano inputcuadrado" placeholder="Contraseña"/>
							</div>
							<a href="javascript:void(0);" onClick="RecoverPassword();"><span class="recuperar">Recuperar contraseña</span></a>
							<div class="input ingresarEmpresa">
								<input type="submit" class="botonplano" value="ingresar" />
							</div>
						</form>
					</div>
				</div>
				
				<div class="col-md-12 consultaEmpresa itemRegistroLogin">
					<div class="subcontent">
						<h3>Consultas</h3>
						<div class="link">
							<a href="mailto:ventas@xperiencialaboral.com">ventas@xperiencialaboral.com</a>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>