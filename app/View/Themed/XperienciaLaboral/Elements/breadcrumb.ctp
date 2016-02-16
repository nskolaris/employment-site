<div class="col-md-12 bcumb">
	<ol class="breadcrumb nospaces">
		<?php
		if($this->params->params['action'] == 'index'){
			if(!empty($conditions)){
				?><li><?php echo $this->Html->Link('Bolsa de trabajo','/avisos'); ?></li><?php
				$last_key = key(array_slice($conditions,-1,1,TRUE));
				foreach($conditions as $i => $condition){
					if($i == 'Aviso.area_id'){
						$string = $areas_avisos[$condition];
						$link = strtolower($string).'-a'.$condition;
					} 
					if($i == 'Aviso.provincia_id'){ 
						$string = 'Trabajos en '.$ubicaciones_avisos[$condition];
						$link = strtolower($string).'-p'.$condition;
					}
					if($i == $last_key){
						?><li class="active"><strong><?php echo $string; ?></strong></li><?php
					}else{
						?><li><a href="<?php echo 'avisos/'.$link; ?>"><?php echo $string; ?></a></li><?php
					}
				}
			}else{
				?><li class="active"><strong>Bolsa de trabajo</strong></li><?php
			}
		}elseif($this->params->params['action'] == 'busqueda'){
			?><li><?php echo $this->Html->Link('Bolsa de trabajo','/avisos'); ?></li><?php
			?><li class="active"><strong>"<?php echo /*$this->params->params['pass'][0]*/$busqueda; ?>"</strong></li><?php
		}elseif($this->params->params['action'] == 'ver'){
			?><li><?php echo $this->Html->Link('Bolsa de trabajo','/avisos'); ?></li><?php
			?><li class="active"><strong><?php echo $aviso['Aviso']['puesto'].' en '.$aviso['Empresa']['nombre_comercial']; ?></strong></li><?php
		}else{ 
			?><li class="active"><strong>Bolsa de trabajo</strong></li><?php
		}
	?>
	</ol>
</div>