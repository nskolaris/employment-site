<style>
input.error{border: 3px solid red;}

.error-string{color: red; margin: 0px 6px;}

.titulo h3{
	color: #D42A86 !important;
	margin: 0px 0px 5px;
	font-size: 30px;
}

.form-personal .submit{background: none repeat scroll 0% 0% #D42A86 !important;}

textarea{height: 160px !important;}
</style>

<script>
	<?php if(isset($errores)){ ?>var errores = JSON.parse('<?php echo json_encode($errores); ?>');<?php } ?>;
	<?php /*if(isset($valores)){ $valores['descripcion'] = h($valores['descripcion']); ?>var valores = JSON.parse('<?php echo json_encode($valores); ?>');<?php }*/ ?>

	$(document).ready(function(){
		$('[name=pais_id]').change(function(){
			UpdateCombo($('[name=provincia_id]'),'<?php echo $this->Html->Url(array('controller'=>'datos_personales','action'=>'get_provincias','empresa'=>false)); ?>/'+$(this).val());
		});
		
		if($('[name=pais_id]').val() != ''){
			UpdateCombo($('[name=provincia_id]'),'<?php echo $this->Html->Url(array('controller'=>'datos_personales','action'=>'get_provincias','empresa'=>false)); ?>/'+$('[name=pais_id]').val());
		}
		
		<?php if(isset($aviso)){ ?>
			
			var aviso;
			
			$.post('<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'get_ajax','empresa'=>false,$aviso['Aviso']['id'])); ?>',function(response){
				aviso = JSON.parse(response);
				FillInputs();
			});
			
			function FillInputs(){
				$.each(aviso.Aviso, function(index, value){
					$('[name='+index+']').val(value);
					if($('[name='+index+']').is(':checkbox') && value == 1){
						$('[name='+index+']').prop('checked', true);
					}
				});
				$('#aviso-form').prepend('<input type="hidden" name="id" value="<?php echo $aviso['Aviso']['id']; ?>"/>');
			}
			
		<?php } ?>
		
		if(typeof errores != 'undefined'){
			$.each(errores,function(index,value){
				if(!$('[name="'+index+'"]').hasClass('error')){
					$('[name="'+index+'"]').addClass('error');
					
					if(typeof value === 'string'){
						var error_txt = value;
					}else{
						var error_txt = value[0];
					}
					
					$('[name="'+index+'"]').closest('.item').find('label').first().append('<span class="error-string">'+error_txt+'</span>');
				}
			});
		}
		
		if(typeof valores != 'undefined'){
			$.each(valores,function(index,value){
				$('[name="'+index+'"]').val(value);
			});
		}
		
		$('#permisos-container [type=radio]').click(function(){
			ToggleUsuariosContainer($(this).val());
		});
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
	
	function ToggleUsuariosContainer(val){
		if(val == 3){
			$('#usuarios_internos').height(0);
			$('#usuarios_internos').show();
			$('#usuarios_internos').animate({height: $('#usuarios_internos').get(0).scrollHeight},250);
		}else{
			if($('#usuarios_internos').is(':visible')){
				$('#usuarios_internos').animate({height: 0},250,function(){
					$('#usuarios_internos').hide();
				});
			}
		}
	}
</script>

<div class="col-md-12 form-personal">

	<form method="post" id="aviso-form" action="<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'add')); ?>">

		<div class="titulo"><div class="row"><div class="col-md-9">
			<h3 class="nospaces">Datos del aviso</h3>
		</div></div></div>
		
		<div class="item row">
			<div class="col-md-12 nospaces">
				<label for="puesto">Puesto</label>
			</div>
			<div class="col-md-12 nospaces">
				<input name="puesto" class="required botonplano inputplano" value="<?php echo (isset($valores['puesto'])?$valores['puesto']:''); ?>"/>
			</div>
		</div>
		
		<div class="item row">
			<div class="col-md-12 nospaces">
				<label for="descripcion">Descripcion</label>
			</div>
			<div class="col-md-12 nospaces">
				<textarea name="descripcion" class="required botonplano inputplano"><?php echo (isset($valores['descripcion'])?$valores['descripcion']:''); ?></textarea>
			</div>
		</div>
		
		<div class="col-md-6 row">
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="area_id">Area</label>
				</div>
				<div class="col-md-10 nospaces">
					<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','empty'=>'Seleccione','options'=>$areas,'name'=>'area_id','selected'=>(isset($valores['area_id'])?$valores['area_id']:''))); ?>
				</div>
			</div>
			
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="nivel_id">Nivel</label>
				</div>
				<div class="col-md-10 nospaces">
					<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','empty'=>'Seleccione','options'=>$niveles,'name'=>'nivel_id','selected'=>(isset($valores['nivel_id'])?$valores['nivel_id']:''))); ?>
				</div>
			</div>
			
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="tipotrabajo_id">Tipo de trabajo</label>
				</div>
				<div class="col-md-10 nospaces">
					<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','empty'=>'Seleccione','options'=>$tipos,'name'=>'tipotrabajo_id','selected'=>(isset($valores['tipotrabajo_id'])?$valores['tipotrabajo_id']:''))); ?>
				</div>
			</div>
		</div>
		
		
		<div class="col-md-6 row">
		
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="sueldo_bruto">Sueldo bruto</label>
				</div>
				<div class="col-md-10 nospaces">
					<div class="input-group">
						<span class="input-group-addon">MX$</span>
						<input name="sueldo_bruto" type="text" class="required botonplano inputplano form-control" value="<?php echo (isset($valores['sueldo_bruto'])?$valores['sueldo_bruto']:''); ?>"/>
					</div>
				</div>
			</div>
			
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="pais">País</label>
				</div>
				<div class="col-md-10 nospaces">
					<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$paises,'name'=>'pais_id','selected'=>(isset($pais)?$pais:''),'empty'=>'Seleccione el Pais','selected'=>(isset($valores['pais_id'])?$valores['pais_id']:''))); ?>
				</div>
			</div>
			
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="provincia_id">Estado</label>
				</div>
				<div class="col-md-10 nospaces">
					<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','empty'=>'Seleccione','options'=>$provincias,'name'=>'provincia_id','selected'=>(isset($valores['provincia_id'])?$valores['provincia_id']:''))); ?>
				</div>
			</div>
			
			<div class="item row">
				<div class="col-md-10 nospaces">
					<label for="provincia_id">Delegación o municipio</label>
				</div>
				<div class="col-md-10 nospaces">
					<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','name'=>'barrio','value'=>(isset($valores['barrio'])?$valores['barrio']:''))); ?>
				</div>
			</div>

		</div>
		
		<?php if(isset($empresa_producto['dias_restantes']) && $empresa_producto['dias_restantes'] > 0){ ?>
		<div class="item row">
			<div class="col-md-10 nospaces">
				<input name="habilitado" type="checkbox" style="margin-right: 10px;"/><label for="habilitado">Habilitado</label>
			</div>
		</div>
		<?php } ?>
		
		<div class="item row" id="permisos-container">
			<div class="col-md-10 nospaces">
				<label for="habilitado">Permisos</label>
			</div>
			<div class="col-md-10 nospaces">
				<div class="col-md-12">
					<input id="permiso-1" type="radio" name="data[permiso_id]" value="1"/>
					<label for="permiso_id">Todos</label>
				</div>
				<div class="col-md-12">
					<input id="permiso-2" type="radio" name="data[permiso_id]" value="2"/>
					<label for="permiso_id">Solo yo</label>
				</div>
				<div class="col-md-12">
					<input id="permiso-3" type="radio" name="data[permiso_id]" value="3"/>
					<label for="permiso_id">Yo y los siguientes usuarios:</label>
					<div id="usuarios_internos" style="display: none; padding: 0px 10px;">
					<?php foreach($usuarios_internos as $usuario_interno){ ?>
						<div class="col-md-12">
							<input name="usuario-interno-<?php echo $usuario_interno['UsuarioInterno']['id']; ?>" value="on" type="checkbox"/>
							<?php echo $usuario_interno['UsuarioInterno']['nombre'].' '.$usuario_interno['UsuarioInterno']['apellido']; ?>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="item row">
			<div class="col-md-12 nospaces">
				<input class="submit botonplano btn-submit" type="submit" value="Guardar datos"/>
			</div>
		</div>

	</form>
</div>