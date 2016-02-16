<?php
if(isset($pages) and is_int($pages)){
?>
<div id="paginator" class="col-md-12">
	<div class="row">
		<div class="col-md-3 anterior">
			<a href="#" class="botonplano">< Anterior</a>
		</div>
		<div class="col-md-6 pages">
	<?php
		$separator = '<span>|</span>';
		$currentClass = ' class="current" ';
		for($i=1;$i<=$pages;$i++){
			echo '<a href="#"';
			if(isset($current) and is_int($current) and $i == $current){
				echo $currentClass;
			}
			echo '>'.$i.'</a>';
			if($i!==$pages){
				echo $separator;
			}
		}
	?>
		</div>
		<div class="col-md-3 siguiente">
			<a href="#" class="botonplano">Siguiente ></a>
		</div>
	</div>
</div>
<?php
}