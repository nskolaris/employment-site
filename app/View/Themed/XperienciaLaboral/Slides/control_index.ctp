<style>
	.slides-data{margin-bottom: 15px;}
		.slides-data .slide-data{border: 1px solid rgba(194, 194, 194, 1); padding: 10px 0px;}
			.slides-data .slide-data .image{border-right: 1px solid rgba(194, 194, 194, 1);}
				.slides-data .slide-data .image .image-container{width: 50%; float: right;}
					.slides-data .slide-data .image .image-container img{width: 100%;}
			.slides-data .slide-data label{margin-right: 10px;}
			.slides-data .slide-data input.text{width: 90%; padding: 0px 10px;}
			.slides-data .slide-data input.image-input{width: 50%; float: left;}
			.slides-data .slide-data .checkbox{margin: 0px;}
			.slides-data .slide-data .col-md-6{margin-bottom: 15px;}
</style>
<script>
	$(document).ready(function(){
		$('.image-input').change(function(){
			readURL(this,$(this));
		});
	
		$('#add-slide-btn').click(function(){
			$('.slides-data').append($('.template').html());
			$('.image-input').change(function(){
				readURL(this,$(this));
			});
			$('.eliminar-btn').click(function(){
				Delete($(this));
			});
		});
		
		$('#save-btn').click(Save);
		
		$('.eliminar-btn').click(function(){
			Delete($(this));
		});
	});
	
	function Save(){
		var data = [];
		$('.slides-data .slide-data').each(function(){
			if($(this).find('.image-container img').attr('src') != undefined){
				var element = {
					image_data: $(this).find('.image-container img').attr('src'),
					image_name: $(this).find('.image-input').val(),
					borrador: $(this).find('.checkbox').is(':checked'),
					url: $(this).find('input.text').val()
				};
				
				if($(this).attr('id') != undefined){
					element.id = $(this).attr('id');
				}
				
				data.push(element);
			}
		});
		if(data.length > 0){
			$.post('<?php echo $this->Html->Url(array('controller'=>'slides','action'=>'add')); ?>',{data: data},function(response){
				if(response == 'ok'){
					location.reload();
				}
			});
		}
	}
	
	function Delete(element){
		if(element.closest('.slide-data').attr('id') != undefined){
			$.post('<?php echo $this->Html->Url(array('controller'=>'slides','action'=>'delete')); ?>/'+element.closest('.slide-data').attr('id'),function(response){
				if(response == 'ok'){
					element.closest('.slide-data').remove();
				}
			});
		}else{
			element.closest('.slide-data').remove();
		}
	}
	
	function readURL(input, element) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
               element.closest('.image').find('.image-container img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }	
	}
</script>
<div class="col-md-12">

	<h1>Gestión del slider</h1>
	
	<div class="slides-data col-md-12 row">
		<?php foreach($slides as $slide){ ?>
			<div class="slide-data col-md-12" id="<?php echo $slide['Slide']['id']; ?>">
				<div class="col-md-6 image">
					<input type="file" class="image-input" name="imagen" multiple/>
					<div class="image-container">
						<img src="<?php echo 'img/slides/'.$slide['Slide']['image']; ?>"/>
					</div>
				</div>
				<div class="col-md-6">
					<?php echo $this->Form->input('',array('name'=>'url','label'=>'Url','value'=>$slide['Slide']['url'],'class'=>'text')); ?>
				</div>
				<div class="col-md-6">
					<?php echo $this->Form->input('',array('name'=>'borrador','label'=>'Borrador','checked'=>$slide['Slide']['borrador'],'class'=>'checkbox','type'=>'checkbox')); ?>
				</div>
				<div class="col-md-6">
					<button type="button" class="eliminar-btn btn btn-danger">Eliminar</button>
				</div>
			</div>
		<?php } ?>
	</div>
	
	<div class="template" style="display: none;">
	
		<div class="slide-data col-md-12">
			<div class="col-md-6 image">
				<input type="file" class="image-input" name="imagen" multiple/>
				<div class="image-container">
					<img/>
				</div>
			</div>
			<div class="col-md-6">
				<?php echo $this->Form->input('',array('name'=>'url','label'=>'Url','class'=>'text')); ?>
			</div>
			<div class="col-md-6">
				<?php echo $this->Form->input('',array('name'=>'borrador','label'=>'Borrador','class'=>'checkbox','type'=>'checkbox')); ?>
			</div>
			<div class="col-md-6">
				<button type="button" class="eliminar-btn btn btn-danger">Eliminar</button>
			</div>
		</div>
	
	</div>
	
	<button id="add-slide-btn" type="button" class="btn btn-default">Agregar slide</button>
	<button id="save-btn" type="button" class="btn btn-primary">Guardar</button>

</div>