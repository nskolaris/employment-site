<?php if(!isset($empresas)){ ?>
	<?php if(count($slides) > 0){ ?>
	<style>
		#slider{height: 303px; overflow-x: hidden;}
			#slider .row{height: 100%; overflow-y: hidden; position: relative;}
				#slider .row .slide{
					height: 100%;
					background-size: cover;
					background-position: center center;
					float: left;
				}
	</style>
	<script>
	var slides_count;
	var current_slide = 1;

	$(document).ready(function(){
		$('#slider .row').append($('#slider .row .slide').first().clone());
		slides_count = $('#slider .row .slide').length;
		$('#slider .row').css('width',(slides_count*104)+'%');
		$('#slider .row .slide').css('width',(100/slides_count)+'%');
		<?php if(count($slides) > 1){ ?>setInterval(Slide,5000);<?php } ?>
	});

	function Slide(){
		$('#slider .row').animate({left: '-='+($('#slider .row').width()/slides_count)},500,function(){
			current_slide++;
			if(current_slide == slides_count){
				$('#slider .row').css('left','0%');
				current_slide = 1;
			}
		});
	}
	</script>
	<div id="slider" class="col-md-12">
		<div class="row">
			<?php foreach($slides as $slide){ ?>
				<a href="<?php echo $slide['Slide']['url']; ?>"><div class="slide" style="background-image: url(img/slides/<?php echo $slide['Slide']['image']; ?>);"></div></a>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
<?php }else{ ?>
	<div id="slider" class="col-md-12 slider-empresas">
		<div class="row">
		<?php echo $this->Html->image('home-empresas.jpg',array('class'=>'slide-img col-md-8 nospaces')); ?>
		<div class="slide-cap col-md-4 nospaces">
			<h3>XPERIENCIA LABORAL</h3>
			<p>Somos el portal de empleos con mayor  experiencia en recursos humanos.</p>
		</div>
		</div>
	</div>
<?php } ?>