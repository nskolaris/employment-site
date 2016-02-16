<style>
	tr.borrador{background-color: rgba(192, 192, 192, 1);}
	tr.activo{background-color: rgba(147, 236, 147, 1);}
	tr.terminado{background-color: rgba(255, 163, 163, 1);}
</style>
<script>
	var avisos;
	var current_aviso;
	
	$(document).ready(function(){
		<?php foreach($avisos as $i=>$aviso){unset($avisos[$i]['Aviso']['descripcion']);} ?>
		avisos = JSON.parse('<?php echo json_encode($avisos); ?>');
		
		$('#permisos-container [type=radio]').click(function(){
			ToggleUsuariosContainer($(this).val());
		});
		
		/* Tooltips */
		$('.table .acciones a').tooltip();
	});
	
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

	function CambiarPermisos(){
	
		var checked_element = $('#permisos-container [type=radio]:checked');
		var permiso_id = checked_element.val();
		
		var data = {
			aviso_id: avisos[current_aviso].Aviso.id, 
			permiso_id: checked_element.val()
		};
		
		if(permiso_id == '3'){
			var usuarios_internos = {};
			$('#permisos-container [type=checkbox]').each(function(){
				if($(this).prop('checked')){
					usuarios_internos[$(this).val()] = $(this).val();
				}
			});
			data.usuarios_internos = usuarios_internos;
		}
		
		$.post('<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'cambiar_permisos')); ?>', data, function(response){
			if(response == 'ok'){
				avisos[current_aviso].Permiso.id = permiso_id;
				$('#permisos-container').modal('hide');
			}else{
				alert(response);
			}
		});
	}
	
	function OpenPermisos(index){
		current_aviso = index;
		$('#permisos-container [type=radio]').prop('checked',false);
		$('#permisos-container [type=checkbox]').prop('checked',false);
		$('#permisos-container [value='+avisos[index].Permiso.id+'][type=radio]').prop('checked',true);
		if(avisos[index].Permiso.id == 3){
			$.each(avisos[index].AvisoPermiso,function(index,value){
				$('#usuarios_internos [value='+value.usuario_interno_id+']').prop('checked',true);
			});
		}
		$('#permisos-container').modal('show');
		ToggleUsuariosContainer(avisos[index].Permiso.id);
	}
</script>

<div class="col-md-12">
	<h1>Listado de avisos</h1>
	<table class="table">
		<thead>
			<tr>
				<th>Puesto</th>
				<th>Dias restantes</th>
				<th>Cantidad de postulantes</th>
				<th>Usuario</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($avisos as $i => $aviso){ ?>
				<?php switch($aviso['Aviso']['habilitado']){
					case 0:
					$status = 'Borrador';
					$class = 'borrador';
					break;
					
					case 1:
					$status = 'Activo';
					$class = 'activo';
					break;
					
					case 2:
					$status = 'Terminado';
					$class = 'terminado';
					break;
					
					case 3:
					$status = 'Vencido';
					$class = 'terminado';
					break;
				} ?>
				<tr class="<?php echo $class; ?>">
					<td><?php echo $aviso['Aviso']['puesto']; ?></td>
					<td>
					<?php if($aviso['Aviso']['dias_restantes']>0){ ?>
						<?php echo $aviso['Aviso']['dias_restantes']; ?>
					<?php }elseif($aviso['Aviso']['dias_restantes']>-30){ ?>
						<?php echo (30-$aviso['Aviso']['dias_restantes']).' (para ver CVS)'; ?>
					<?php }else{ ?>
						<?php echo '-'; ?>
					<?php } ?>
					</td>
					<td>
					<?php 
						$no_leidos = 0;
						foreach($aviso['CurriculumAviso'] as $cv){
							if($cv['nuevo']){$no_leidos++;}
						}
						echo $aviso['Aviso']['aplicantes_count'].' totales';
						if($aviso['Aviso']['dias_restantes']>-30){
							echo '/ <a href="'.$this->Html->Url(array('controller'=>'curriculum_avisos','action'=>'index',$aviso['Aviso']['id'])).'">'.$no_leidos.' no leidos</a>';
						}
					?>
					</td>
					<td><?php echo $aviso['UsuarioInterno']['nombre'].' '.$aviso['UsuarioInterno']['apellido']; ?></td>
					<td><?php echo $status; ?></td>
					<td class="acciones">
						<?php 
							if($aviso['Aviso']['aplicantes_count'] < 1 && $aviso['Aviso']['habilitado'] < 2){
								echo $this->Html->Link('',array('controller'=>'avisos','action'=>'editar',$aviso['Aviso']['id']),array('class'=>'glyphicon glyphicon-pencil','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Editar')); 
							}
						?>
						<?php if($aviso['Aviso']['dias_restantes']>-30){
							echo $this->Html->Link('',array('controller'=>'curriculum_avisos','action'=>'index',$aviso['Aviso']['id']),array('class'=>'glyphicon glyphicon-user','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Ver postulantes')); 
						} ?>
						<?php echo $this->Html->Link('','javascript:void(0)',array('onClick'=>'OpenPermisos('.$i.');','class'=>'glyphicon glyphicon-eye-open','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Permisos')); ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<!-- Permisos -->
<div class="modal fade" id="permisos-container" tabindex="-1" role="dialog" aria-labelledby="permisos-containerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
			<h4 class="modal-title" id="permisos-containerLabel">¿Quienes pueden gestionar este aviso?</h4>
		</div>
		<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<input type="radio" name="permiso_id" value="1"/>
						<label for="permiso_id">Todos</label>
					</div>
					<div class="col-md-12">
						<input type="radio" name="permiso_id" value="2"/>
						<label for="permiso_id">Solo yo</label>
					</div>
					<div class="col-md-12">
						<input type="radio" name="permiso_id" value="3"/>
						<label for="permiso_id">Yo y los siguientes usuarios:</label>
						<div id="usuarios_internos" style="display: none; padding: 0px 10px;">
						<?php foreach($usuarios_internos as $usuario_interno){ ?>
							<div>
								<input value="<?php echo $usuario_interno['UsuarioInterno']['id']; ?>" type="checkbox"/>
								<p style="display: inline;"><?php echo $usuario_interno['UsuarioInterno']['nombre'].' '.$usuario_interno['UsuarioInterno']['apellido']; ?></p>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onClick="CambiarPermisos();">Aceptar</button>
		</div>
    </div>
  </div>
</div>