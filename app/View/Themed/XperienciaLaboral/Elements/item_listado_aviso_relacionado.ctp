<li>
	<div class="row">
		<div class="col-md-4">
			<img src="<?php echo $this->PhpThumb->url('img/profile_pics/empresas/'.$aviso['Empresa']['id'].'.jpg', array('w' => 83, 'h'=>49,'zc' => 1)); ?>" class="icono" alt=""/>
			<!--<a class="icono" href="#"><img src="http://placehold.it/83x49" alt="p"/></a>-->
		</div>
		<div class="col-md-8">
			<div class="subcontent">
				<h5 class="titulo nospaces" ><?php echo $this->Html->Link($aviso['Aviso']['puesto'],array('controller'=>'avisos','action'=>'ver',$aviso['Aviso']['id'])); ?></h5>
				<p class="empresa"><?php echo $aviso['Empresa']['nombre_comercial']; ?></p>
			</div>
		</div>
	</div>
</li>