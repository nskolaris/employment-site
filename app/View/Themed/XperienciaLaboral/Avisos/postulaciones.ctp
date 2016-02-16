<script>
$(document).ready(function(){
	/* Tooltips */
	$('.acciones a').tooltip();
});
</script>
<div class="col-md-12">
	<h1>Mis postulaciones</h1>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Puesto</th>
				<th>Dias restantes</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($avisos as $i => $aviso){ ?>
				<tr>
					<td><?php echo $aviso['Aviso']['puesto']; ?></td>
					<td><?php echo $aviso['Aviso']['dias_restantes']; ?></td>
					<td><?php echo ($aviso['Aviso']['habilitado']==1?'Activo':'Borrador'); ?></td>
					<td class="acciones">
						<?php echo $this->Html->Link('',array('controller'=>'curriculum_avisos','action'=>'remover',$aviso['CurriculumAviso']['id']),array('class'=>'glyphicon glyphicon-remove','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Remover postulación')); ?>
						<?php echo $this->Html->Link('',array('controller'=>'avisos','action'=>'ver',$aviso['Aviso']['id']),array('target'=>'_blank','class'=>'glyphicon glyphicon-search','data-toggle'=>'tooltip','data-placement'=>'bottom','title'=>'Ver')); ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>