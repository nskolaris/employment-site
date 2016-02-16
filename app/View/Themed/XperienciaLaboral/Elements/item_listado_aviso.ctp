<li>
	<div class="row">
		<div class="col-md-2">
			<img src="<?php echo $this->PhpThumb->url('img/profile_pics/empresas/'.$aviso['Empresa']['id'].'.jpg', array('w' => 110, 'h'=>65,'zc' => 1)); ?>" class="icono" alt=""/>
			<!--<a class="icono" href="#"><img src="http://placehold.it/110x65" alt="p"/></a>-->
		</div>
		<div class="col-md-10">
			<div class="subcontent">
				<h5 class="titulo nospaces"><?php echo $this->Html->Link($aviso['Aviso']['puesto'],array('controller'=>'avisos','action'=>'ver',$aviso['Aviso']['id'])); ?></h5>
				<p class="empresa"><?php echo $aviso['Empresa']['nombre_comercial']; ?></p>
				<p class="descripcion">
					<strong><?php echo $aviso['Provincia']['denominacion']; ?></strong> 
					<span>|</span> 
					<?php echo $aviso['LaboralTipoTrabajo']['denominacion']; ?> 
					<span>|</span> 
					Hace <?php echo $aviso['Aviso']['tiempo']; ?>
				</p>
			</div>
		</div>
	</div>
</li>