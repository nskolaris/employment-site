<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		// STYLES
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('xperiencialaboral');
		
		// SCRIPTS
		echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
		echo $this->Html->script('modernizr.custom.39338');
		echo $this->Html->script('respond.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('PIE');
		echo $this->Html->script('//modernizr.com/downloads/modernizr.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<script>
	$(document).ready(function(){
		var vp_height = $(window).height();
		$('body').height(vp_height);
	});
</script>
<body>
	<div id="content-xperiencia" class="container backend control">
		<div id="header">
			<?php echo $this->element('header-control'); ?>
		</div>
		<div id="sidebar">
			<?php echo $this->element('sidebar-control'); ?>
		</div>
		<div id="content" class="row">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>
