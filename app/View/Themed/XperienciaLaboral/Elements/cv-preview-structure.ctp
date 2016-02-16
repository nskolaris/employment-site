<?php foreach($postulantes as $i => $postulante){ ?>
	<tr id="cv-preview-<?php echo $postulante['CurriculumAviso']['id']; ?>" ca_id="<?php echo $postulante['CurriculumAviso']['id']; ?>" user_id="<?php echo $postulante['Usuario']['id']; ?>" class="<?php echo ($postulante['CurriculumAviso']['nuevo'] == 1?'nuevo':''); ?>">
		<?php $class = ($postulante['CurriculumAviso']['preferido'] == 1 ? 'glyphicon-star' : 'glyphicon-star-empty'); ?>
		
		<td><a href="javascript:void(0);" id="<?php echo $postulante['CurriculumAviso']['id']; ?>" class="favorite glyphicon <?php echo $class; ?>"></a></td>
		
		<td class="nombre">
			<a href="javascript:void(0);" id="nombre_posultante" onClick="OpenCV(<?php echo $postulante['Usuario']['id']; ?>)">
				<?php echo $postulante['Usuario']['DatosPersonales']['nombre'].' '.$postulante['Usuario']['DatosPersonales']['apellido']; ?>
			</a>
			<?php echo $this->Html->Link('','javascript:void(0);',array('style'=>'float: right;','class'=>'glyphicon glyphicon-list-alt tooltip-link','onClick'=>'OpenNotes('.$postulante['CurriculumAviso']['id'].');','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Ver notas')); ?>
		</td>
		
		<td><?php 
			$birthDate =$postulante['Usuario']['DatosPersonales']['fnacimiento'];
			$birthDate = explode("-", $birthDate);
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			? ((date("Y") - $birthDate[0]) - 1)
			: (date("Y") - $birthDate[0]));
			echo $age;
		?></td>
		
		<td>
			<span>
				<?php echo (isset($postulante['Usuario']['DatosPersonales']['ciudad'])?$postulante['Usuario']['DatosPersonales']['ciudad'].', ':''); ?>
				<?php echo (isset($postulante['Usuario']['DatosPersonales']['Provincia']['denominacion'])?$postulante['Usuario']['DatosPersonales']['Provincia']['denominacion'].', ':''); ?>
				<?php echo (isset($postulante['Usuario']['DatosPersonales']['Provincia']['Pais']['denominacion'])?$postulante['Usuario']['DatosPersonales']['Provincia']['Pais']['denominacion']:''); ?>			
			</span>
		</td>
		
		<td>
			<?php if(isset($postulante['Usuario']['Estudio'][0]['titulo'])){ ?>
				<span><?php echo $postulante['Usuario']['Estudio'][0]['titulo']; ?></span><br>
				<span><?php echo $postulante['Usuario']['Estudio'][0]['EstudioInstitucion']['denominacion']; ?></span><br>
				<span class="fechas">Hasta <?php echo $postulante['Usuario']['Estudio'][0]['ffin'].' - '.$postulante['Usuario']['Estudio'][0]['ffin']; ?></span>
			<?php }else{ ?>
				<span>Sin estudios</span>
			<?php } ?>
		</td>
		
		<td>
			<?php if(isset($postulante['Usuario']['Experiencia'][0]['puesto'])){ ?>
				<span><?php echo $postulante['Usuario']['Experiencia'][0]['puesto'].' - '.$postulante['Usuario']['Experiencia'][0]['LaboralNivelPuesto']['denominacion']; ?></span><br>
				<span><?php echo $postulante['Usuario']['Experiencia'][0]['empresa']; ?></span><br>
				<span class="fechas">Hasta <?php echo $postulante['Usuario']['Experiencia'][0]['ffin'].' - '.$postulante['Usuario']['Experiencia'][0]['ffin']; ?></span>
			<?php }else{ ?>
				<span>Sin experiencia</span>
			<?php } ?>
		</td>
		
		<td class="acciones">
			<a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Abrir" class="glyphicon glyphicon-new-window" onClick="OpenCV(<?php echo $postulante['Usuario']['id']; ?>,true)"></a>
			<a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Marcar como nuevo" class="glyphicon glyphicon-eye-close" onClick="FlagNuevo(<?php echo $postulante['Usuario']['id']; ?>,1)"></a>
		</td>
		
	</tr>
<?php } ?>