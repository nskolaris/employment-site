<style>
	input.error{border: 3px solid red;}
	
	select.error{border: 3px solid red;}

	.error-string{color: red; margin:0px 6px; font-size: 10px;}

	.titulo h3{color: #C10D62 !important;}

	.edit .subirimagen{background: none repeat scroll 0% 0% #C10D62 !important;}

	.form-personal{padding: 5px;}

	.form-personal .submit{background: none repeat scroll 0% 0% #C10D62 !important;}
</style>
<script>
	<?php if(isset($errores)){ ?>var errores = JSON.parse('<?php echo json_encode($errores); ?>');<?php } ?>
	
	<?php if(isset($valores)){ ?>var valores = JSON.parse('<?php echo json_encode($valores); ?>');<?php } ?>

	$(document).ready(function(){
		$('#img-upload').change(function(){
			readURL(this);
		});
		
		$('[name=pais]').change(function(){
			UpdateCombo($('[name=provincia_id]'),'<?php echo $this->Html->Url(array('controller'=>'datos_personales','action'=>'get_provincias','empresas'=>false)); ?>/'+$(this).val());
		});
		
		$('#empresa-form').submit(function(){Submit(); return false;});
		
		if($('[name=pais]').val() != ''){
			UpdateCombo($('[name=provincia_id]'),'<?php echo $this->Html->Url(array('controller'=>'datos_personales','action'=>'get_provincias','empresas'=>false)); ?>/'+$('[name=pais]').val());
		}
		
		if(typeof errores != 'undefined'){
			$.each(errores,function(index,value){
				if(!$('[name="'+index+'"]').hasClass('error')){
					$('[name="'+index+'"]').addClass('error');
					$('[name="'+index+'"]').closest('.item').append('<span class="error-string">'+value+'</span>');
				}
			});
		}
		
		if(typeof valores != 'undefined'){
			$.each(valores,function(index,value){
				if(index!='upl'){
					$('[name="'+index+'"]').val(value);
				}
			});
		}
	});
	
	function UpdateCombo(element,url){
		$.post(url,function(response){
			data = JSON.parse(response);
			element.html('<option value="">Seleccione</option>');
			$.each(data,function(index,value){
				element.append('<option value="'+index+'">'+value+'</option>');
			});
			if(typeof valores != 'undefined'){
				$.each(valores,function(index,value){
					$('[name="'+index+'"]').val(value);
				});
			}
		});
	}
	
	function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.user-image').attr('src', e.target.result);
				$.post('<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'save_image','empresa'=>false)); ?>',{imgdata: e.target.result, origin: 'empresas'},function(response){
					if(response != 'error'){
					
					}
				});
            }
            reader.readAsDataURL(input.files[0]);
        }	
	}
	
	function Submit(){
		if($('[name="bases"]').is(":checked")){
			$('#empresa-form').submit();
		}else{
			$('[name="bases"]').addClass('error');
			$('[name="bases"]').closest('.item').append('<span class="error-string">Debe aceptar las bases y condiciones</span>');
		}
	}
</script>
<div id="micv" class="col-md-12 form-personal">

	<?php if(!isset($user['UsuarioInterno'])){$action = 'add';}else{$action = 'edit';} ?>
	
	<form method="post" id="empresa-form" action="<?php echo $this->Html->Url(array('controller'=>'empresas','action'=>$action)); ?>">
		
		<div class="item contenedor col-md-6">
				
			<div class="titulo"><div class="row"><div class="col-md-12">
				<h3 class="nospaces">Datos de la empresa</h3>
			</div></div></div>
			
			<div class="row contenido">
				
				<div class="col-md-4 fotoperfil">
					<div class="subcontent">
						<div class="row">
							<div class="col-md-12 contfotoperfil">
								<img src="<?php echo (isset($user['Empresa']['id'])?$this->PhpThumb->url('img/profile_pics/empresas/'.$user['Empresa']['id'].'.jpg', array('w' => 110, 'zc' => 1)):''); ?>" style="width:110px;" class="user-image" alt=""/>
							</div>
							<div class="col-md-12 contsubirimagen">
								<div style="display: none;">
									<div id="upload" method="post" action="upload.php" enctype="multipart/form-data">
										<input type="file" id="img-upload" name="upl" multiple />
									</div>
								</div>
								<a href="javascript:void(0);" onClick="$('#img-upload').trigger('click');" class="botonplano subirimagen">Subir imagen</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-10">
					<div class="item row">
						<label for="nombre_comercial">Nombre comercial</label>
						<input name="nombre_comercial" class="required botonplano inputplano" value="<?php echo (isset($user['Empresa']['nombre_comercial'])?$user['Empresa']['nombre_comercial']:''); ?>"/>
					</div>
					
					<div class="item row">
						<label for="razon_social">Razón social</label>
						<input name="razon_social" class="required botonplano inputplano" value="<?php echo (isset($user['Empresa']['razon_social'])?$user['Empresa']['razon_social']:''); ?>"/>
					</div>
					
					<div class="item row">
						<label for="industria_id">Ramo o actividad</label>
						<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','empty'=>'Seleccione','options'=>$industrias,'name'=>'industria_id','selected'=>(isset($user['Empresa']['industria_id'])?$user['Empresa']['industria_id']:''))); ?>
					</div>
					
					<div class="item row">
						<label for="calle">Calle</label>
						<input name="calle" class="required botonplano inputplano" value="<?php echo (isset($user['Empresa']['calle'])?$user['Empresa']['calle']:''); ?>"/>
					</div>
					
					<div class="item row">
						<label for="altura">N° Ext</label>
						<input name="altura" class="required botonplano inputplano" value="<?php echo (isset($user['Empresa']['altura'])?$user['Empresa']['altura']:''); ?>"/>
					</div>
					
					<div class="item row">
						<label for="codigo_postal">Código Postal</label>
						<input name="codigo_postal" class="required botonplano inputplano" value="<?php echo (isset($user['Empresa']['codigo_postal'])?$user['Empresa']['codigo_postal']:''); ?>"/>
					</div>

					<div class="item row">
						<label for="pais">País</label>
						<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','empty'=>'Seleccione','options'=>$paises,'name'=>'pais','selected'=>(isset($pais)?$pais:18))); ?>
					</div>
					
					<div class="item row">
						<label for="provincia_id">Estado</label>
						<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>(isset($provincias)?$provincias:array(''=>'Seleccione')),'name'=>'provincia_id','selected'=>(isset($user['Empresa']['provincia_id'])?$user['Empresa']['provincia_id']:''))); ?>
					</div>
					
					<div class="item row">
						<label for="rfc">RFC</label>
						<input name="rfc" class="required botonplano inputplano" value="<?php echo (isset($user['Empresa']['rfc'])?$user['Empresa']['rfc']:''); ?>"/>
					</div>
					
				</div>
			</div>
		</div>

		<?php if(!isset($user['UsuarioInterno'])){ ?>
		
			<div class="item contenedor col-md-6">

				<div class="titulo">
					<div class="row">
						<div class="col-md-12">
							<h3 class="nospaces">Datos de usuario</h3>
						</div>
					</div>
				</div>
				
				<div class="row contenido">

					<div class="col-md-10">
					
						<div class="item row">
							<label for="email">E-mail</label>
							<input name="email" class="required botonplano inputplano"/>
						</div>
						
						<div class="item row">
							<label for="nombre">Nombre</label>
							<input name="nombre" class="required botonplano inputplano"/>
						</div>
						
						<div class="item row">
							<label for="apellido">Apellido</label>
							<input name="apellido" class="required botonplano inputplano"/>
						</div>
						
						<div class="item row">
							<label for="username">Nombre de usuario</label>
							<input name="username" class="required botonplano inputplano"/>
						</div>
						
						<div class="item row">
							<label for="password">Contraseña</label>
							<input name="password" type="password" class="required botonplano inputplano"/>
						</div>
						
						<div class="item row">
							<label for="password_repeat">Confirmación de contraseña</label>
							<input name="password_repeat" type="password" class="required botonplano inputplano"/>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		<?php }else{ ?>
			<input name="id" type="hidden" value="<?php echo $user['Empresa']['id']; ?>"/>
		<?php } ?>

		<div class="item row col-md-12">
			<label for="bases">Acepto las <a href="<?php echo $this->Html->Url('/files/bases.pdf'); ?>" target='_blank'>bases y condiciones</a></label>
			<input name="bases" type="checkbox" class="botonplano inputplano" style="display: inline-block ! important; width: auto; height: auto;" />
			<br>
		</div>

		
		<div class="item row">
			<div class="col-md-12">
				<button class="submit botonplano btn-submit">Guardar datos</button>
			</div>
		</div>
			
	</form>
</div>