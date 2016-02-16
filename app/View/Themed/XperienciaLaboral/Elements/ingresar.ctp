<style>
	input.error{border: 1px solid #F00;}
	.error{color: red!important; margin: 0px 5px;}
</style>
<script>
	var login_popup_open = false;
	
	$(document).keypress(function(e) {
		if(e.which == 13) {
			if($('#form-ingresar').is(':visible')){
				ValidateLogin();
			}else if($('#form-crear-cuenta').is(':visible')){
				ValidateRegister();
			}
		}
	});
	
	function ToogleLoginPopup(){
		if(!login_popup_open){
			$('#ingresar').fadeIn(200,function(){
				login_popup_open = true;
				$('#ingresar .overlay').click(ToogleLoginPopup);
			});
		}else{
			RemovePostulacionAttempt();
			$('#ingresar').fadeOut(200,function(){
				$('#form-ingresar').show();
				$('#form-crear-cuenta').hide();
				login_popup_open = false;
				$('#ingresar .overlay').unbind('click');
			});
		}
	}
	
	function ToogleRegisterPopup(){
		ToogleLoginPopup();
		CrearCuenta();
	}
	
	function CrearCuenta(){
		$('#form-ingresar').hide();
		$('#form-crear-cuenta').show();
	}
	
	function RecoverPassword(){
		if((email = $('#form-ingresar [name="email"]').val()) != ''){
			$.post('<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'recover_password')); 5?>',{email: email},function(response){
				response_decoded = JSON.parse(response);
				alert(response_decoded.message);
			});
		}else{
			alert('Ingrese un e-mail para recibir su contraseña alli');
		}
	}
	
	function AddPostulacionAttempt(aviso_id){
		$('#ingresar form').each(function(){
			$(this).prepend('<input name="postulacion_attempt" class="postulacion_attempt" type="hidden" value="'+aviso_id+'"/>');
		});
	}
	
	function RemovePostulacionAttempt(){
		$('#ingresar form .postulacion_attempt').each(function(){
			$(this).remove();
		});
	}
	
	function ValidateLogin(){
		data = {};
		$('#form-ingresar input').removeClass('error');
		$('#form-ingresar label .error').html('');
		$('#form-ingresar input').each(function(){
			data[$(this).attr('name')] = $(this).val();
		});
		$.post('<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'validate_login')); ?>', data, function(response){
			try{
			  error_data = JSON.parse(response);
			}catch(exception){
			  error_data = null;
			}
			
			if(error_data){
				var error_data = JSON.parse(response);
				$.each(error_data,function(index,value){
					$('#form-ingresar [name="'+index+'"]').addClass('error');
					$('#form-ingresar [name="'+index+'"]').closest('.item').find('label .error').html(value);
				});
			}else{
				$('#form-ingresar').submit();
			}
		});
	}
	
	function ValidateRegister(){
		if($('#form-crear-cuenta [name="bases"]').is(":checked")){
			data = {};
			$('#form-crear-cuenta input').removeClass('error');
			$('#form-crear-cuenta label .error').html('');
			$('#form-crear-cuenta input').each(function(){
				data[$(this).attr('name')] = $(this).val();
			});
			$.post('<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'validate_register')); ?>', data, function(response){
				try{
				  error_data = JSON.parse(response);
				}catch(exception){
				  error_data = null;
				}
				
				if(error_data){
					var error_data = JSON.parse(response);
					$.each(error_data,function(index,value){
						$('#form-crear-cuenta [name="'+index+'"]').addClass('error');
						$('#form-crear-cuenta [name="'+index+'"]').closest('.item').find('label .error').html(value);
					});
				}else{
					$('#form-crear-cuenta').submit();
				}
			});
		}else{
			$('#form-crear-cuenta [name="bases"]').addClass('error');
			$('#form-crear-cuenta [name="bases"]').closest('.item').find('.error').html('Debe aceptar las bases y condiciones.');
		}
	}
</script>
<div id="ingresar" class="col-md-12 nospaces">
	<div class="overlay"></div>
	<div class="subcontent">
	
		<form id="form-ingresar" action="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'login')); ?>" method="post">
			<div>
				<div class="titulo">
					<h2 class="nospaces">Ingresar</h2>
				</div>
				<div class="item row">
					<label for="">Email<span class="error"></span></label>
					<input name="email" class="botonplano emailnombre inputplano" />
				</div>
				<div class="item row">
					<label for="">Contraseña<span class="error"></span></label>
					<input name="password" type="password" class="botonplano clave inputplano" />
				</div> 
				<div class="item row">
					<input type="checkbox" /><span class="recuperar" >Recordar</span>
					<a href="javascript:void(0);" style="float: right;" onClick="RecoverPassword();"><span class="recuperar">Recuperar contraseña</span></a>
				</div>
				<div class="item row">
					<input class="botonplano submit" onClick="ValidateLogin();" type="button" value="Iniciar Sesión" />
				</div>
				<p><a href="javascript:void(0);" onClick="CrearCuenta();" style="margin-right: 5px;">Crear una cuenta</a>si no estás registrado.</p>
			</div>
			<input type="hidden" name="current_page" value="<?php echo $this->here; ?>"/>
		</form>
		
		<form id="form-crear-cuenta" action="<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'add')); ?>" method="post" style="display: none;">
			<div>
				<div class="titulo">
					<h2 class="nospaces">Crear una cuenta</h2>
				</div>
				<div class="item row">
					<label for="">Email<span class="error"></span></label>
					<input name="email" class="botonplano emailnombre inputplano" />
				</div>
				<div class="item row">
					<label for="">Contraseña<span class="error"></span></label>
					<input name="password" type="password" class="botonplano clave inputplano" />
				</div>
				<div class="item row">
					<label for="">Confirmar Contraseña<span class="error"></span></label>
					<input name="password_repeat" type="password" class="botonplano clave inputplano" />
				</div>
				<div class="item row">
					<label for="">Acepto las <a href="<?php echo $this->Html->Url('/files/bases.pdf'); ?>" target='_blank'>bases y condiciones</a></label>
					<input name="bases" type="checkbox" class="botonplano inputplano" style="display: inline-block ! important; width: auto; height: auto;" />
					<br><span class="error"></span>
				</div>
				<div class="item row">
					<input class="botonplano submit" onClick="ValidateRegister();" type="button" value="Crear" />
				</div>
			</div>
		</form>
		
	</div>
</div>