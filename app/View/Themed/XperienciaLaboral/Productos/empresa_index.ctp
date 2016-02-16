<style>
.titulo h3{
	color: #D42A86 !important;
	font-size: 30px;
}

.separador{border-bottom: 1px solid #D2D2D2; margin: 20px 0px;}

.categoria{}

	.categoria .producto{
		margin: 10px 50px;
		background: none repeat scroll 0% 0% #EDEDED;
		text-align: center;
		border-radius: 5px;
		border-bottom: 5px solid #D2D2D2;
	}
	
		.categoria .producto .denominacion{
			background: none repeat scroll 0% 0% #D42A86;
			color: #FFF;
			font-weight: bold;
			font-size: 26px;
			border-bottom: 5px solid #C20D62;
			padding: 25px 75px;
		}
		
		.categoria .producto .descripcion{
			padding: 10px;
			color: #848484;
			margin-top: 15px;
		}
		
		.categoria .producto .precio-duracion{
			font-weight: bold;
		}
		
			.categoria .producto .precio-duracion .precio{font-size: 30px;}
			
			.categoria .producto .precio-duracion .duracion{}
		
		.categoria .producto .btn-comprar{
			background-color: #D42A86;
			color: #FFF;
			border-bottom: 4px solid #C20D62;
			font-weight: bold;
			font-size: 20px;
			border-radius: 5px;
			padding: 5px;
			margin: 20px 20px 30px;
			cursor: pointer;
		}
</style>

<script>

	var selected_id;

	function ConfirmBuy(id){
		selected_id = id;
		$('#confirmacion').modal('show');
	}

	function Buy(){
		$.post('<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'adquirir')); ?>/'+selected_id,function(response){
			if(response == 'ok'){
				window.location.href = "<?php echo $this->Html->Url(array('controller'=>'productos','action'=>'exito')); ?>";
			}
		});
	}
	
</script>

<div class="col-md-12">

	<div class="titulo"><div class="row"><div class="col-md-12">
		<h3>Productos</h3>
	</div></div></div>
	
	<?php foreach($categorias as $categoria){ ?>
		<div class="categoria">
			<!--<div class="titulo"><div class="row"><div class="col-md-12">
				<h4><?php echo $categoria['Categoria']['denominacion']; ?></h4>
			</div></div></div>-->
			
			<div class="item">
			<?php foreach($categoria['Producto'] as $producto){ ?>

					<div class="col-md-4 nospaces">
						<div class="producto">
							<div class="denominacion"><?php echo $producto['denominacion']; ?></div>
							<div class="descripcion"><?php echo $producto['descripcion']; ?></div>
							<div class="precio-duracion">
								<div class="precio">MX$ <?php echo $producto['Configuracion']['importe']; ?></div>
								<!--<div class="duracion">
									<?php if($producto['Configuracion']['cantidad']!=null){
										echo $producto['Configuracion']['cantidad'].' aviso'.($producto['Configuracion']['cantidad']!=1?'s':'');
										if($producto['Configuracion']['dias_vigencia']!=null){
											echo 'por '.$producto['Configuracion']['dias_vigencia'].' dia'.($producto['Configuracion']['dias_vigencia']!=1?'s':'');
										}
									}else{
										echo $producto['Configuracion']['dias_vigencia'].' dias';
									} ?>
								</div>-->
							</div>
							<div class="btn-comprar" onClick="ConfirmBuy(<?php echo $producto['id']; ?>);">Comprar</div>
						</div>
					</div>
				
				
			<?php } ?>
			</div>
		</div>
		
		<div class="separador col-md-12"></div>
		
	<?php } ?>
	
</div>

<div class="modal fade" id="confirmacion" tabindex="-1" role="dialog" aria-labelledby="confirmacionLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancelar</span></button>
				<h4 class="modal-title" id="confirmacionLabel">Confirmación</h4>
			</div>
			<div class="modal-body">
				Esta por comprar el producto
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" onClick="Buy();">Confirmar</button>
			</div>
		</div>
	</div>
</div>