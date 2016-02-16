<script>
	$(document).ready(function(){
		<?php $flash_message = $this->Session->flash(); ?>
		<?php if(isset($flash_message) && $flash_message != ''){ ?>
			var message = '<?php echo $flash_message; ?>';
			ShowFlashMessage(message);
		<?php } ?>
	});

	function ShowFlashMessage(message){
		$('#flash-message').html(message);
		$('#flash-message').css('top',-$('#flash-message').outerHeight());
		$('#flash-message').show();
		$('#flash-message').animate({top: 0},500,function(){
			setTimeout(function(){
				$('#flash-message').animate({top: -$('#flash-message').outerHeight()},500,function(){
					$('#flash-message').hide();
				});
			},2500);
		});
	}
</script>
<div id="flash-message"></div>