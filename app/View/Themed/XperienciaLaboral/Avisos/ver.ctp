<style>
.flash-message{
	position: fixed;
	top: 0px;
	left: 0px;
	right: 0px;
	background-color: rgba(46, 185, 198, 0.9);
	border-image: none;
	text-align: center;
	padding: 10px;
	font-size: 20px;
	display: none;
	color: white;
	z-index: 30;
}
</style>
<script>
	$(document).ready(function(){
		$('#btn-postularme').click(function(){
			Postular();
		});
		
		<?php if($postulado == 1){ ?>
			MostrarMensaje('Tu postulación se ha realizado con éxito');
		<?php } ?>
	});
	
	function Postular(){
		<?php if(isset($user)){ ?>
			$.post('<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'postular',$aviso['Aviso']['id'])); ?>',function(response){
				if(response == 'ok'){
					MostrarMensaje('Tu postulación se ha realizado con éxito');
					setTimeout(function(){location.reload();},3000);
				}
			});
		<?php }else{ ?>
			AddPostulacionAttempt('<?php echo $aviso['Aviso']['id']; ?>');
			ToogleLoginPopup();
		<?php } ?>
	}
	
	function MostrarMensaje(message){
		$('.flash-message').html(message);
		$('.flash-message').css('top',-$('.flash-message').outerHeight());
		$('.flash-message').show();
		$('.flash-message').animate({top: 0},500,function(){
			setTimeout(function(){
				$('.flash-message').animate({top: -$('.flash-message').outerHeight()},500,function(){
					$('.flash-message').hide();
				});
			},2500);
		});
	}
</script>
<div id="avisos" class="col-md-12 nospaces">
	<div class="row">
		<?php echo $this->element('breadcrumb'); ?>
		<div class="col-md-8 aviso">
			<div class="subcontent">
				<div class="row">
					<div class="col-md-3">
						<img src="<?php echo $this->PhpThumb->url('img/profile_pics/empresas/'.$aviso['Empresa']['id'].'.jpg', array('w' => 146, 'h'=>91,'zc' => 1)); ?>" class="avisothumb" alt=""/>
						<!--<img class="avisothumb" src="http://placehold.it/146x91" alt="p"/>-->
					</div>
					<div class="col-md-9">
						<div class="titulo">
							<h3><?php echo $aviso['Empresa']['nombre_comercial']; ?></h3>
							<h2 class="nospaces"><?php echo $aviso['Aviso']['puesto']; ?></h2>
						</div>
					</div>
					<div class="col-md-12 datos">
						<ul class="nospaces">
							<li><strong>Publicado: </strong><?php echo $aviso['Aviso']['finicio_formateada']; ?></li>
							<li><strong>Área: </strong><?php echo $aviso['LaboralArea']['denominacion']; ?></li>
							<li><strong>Tipo de puesto: </strong><?php echo $aviso['LaboralTipoTrabajo']['denominacion']; ?> <?php //echo $this->Html->Link('(ver más empleos '.$aviso['LaboralTipoTrabajo']['denominacion'].')',array('controller'=>'avisos','action'=>'index')); ?></li>
							<li><strong>Salario: </strong><?php echo ($aviso['Aviso']['sueldo_bruto']!=''?'$'.$aviso['Aviso']['sueldo_bruto']:'No especificado'); ?></li>
							<li><strong>Lugar de trabajo: </strong><?php echo (!empty($aviso['Aviso']['barrio'])?$aviso['Aviso']['barrio'].', ':'').$aviso['Provincia']['denominacion'].', '.$aviso['Provincia']['Pais']['denominacion']; ?></li>
						</ul>
					</div>
					
					<div class="col-md-12 requisitos">
						<div class="subcontent">
							<div class="titulo">
								<h4>Descripción:</h4>
							</div>
							<div class="texto">
								<?php echo $aviso['Aviso']['descripcion']; ?>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 detalle">
						<div class="subcontent">
							<?php if($postulado || isset($postulacion)){ ?>
								<a class="botonplano postularme" style="background-color: #C9C9C9;">Postulado</a>
							<?php }else{ ?>
								<a href="javascript:void(0)" id="btn-postularme" class="botonplano postularme">Postularme</a>
							<?php } ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<?php if(count($avisos_relacionados) > 0){ ?>
			<div class="col-md-4 relacionados">
				<div class="subcontent">
					<div class="titulo">
						<h3>Avisos relacionados</h3>
					</div>
					<ul class="lista">
					<?php
						foreach($avisos_relacionados as $aviso_relacionado){
							echo $this->element('item_listado_aviso_relacionado',array('aviso'=>$aviso_relacionado));
						}
					?>
					</ul>
				</div>
			</div>
		<?php } ?>
		
	</div>
</div>
<div class="flash-message"></div>