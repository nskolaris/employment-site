<?php 
	echo $this->Html->css('datepicker');
	echo $this->Html->script('bootstrap-datepicker');
?>
<style>
	.counters{float: right;}
		.counters div{
			text-align: center;
			float: right;
			border-bottom: 5px solid #CDCD21;
			background-color: #E3DF3B;
			margin: 20px 2%;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			padding: 10px 0px;
		}
			.counters div .number{font-weight: bold; font-size: 15px;}
			
	.stats-container{padding: 10px; height: 90%;}
		.stats-container .tab-content{
			background-color: white;
			border: 1px solid #DDD;
			border-top: none;
			-webkit-border-bottom-right-radius: 10px;
			-webkit-border-bottom-left-radius: 10px;
			-moz-border-radius-bottomright: 10px;
			-moz-border-radius-bottomleft: 10px;
			border-bottom-right-radius: 10px;
			border-bottom-left-radius: 10px;
			height: 90%;
		}
			.stats-container .tab-content .tab-pane{overflow: hidden; padding: 5px 20px; height: 100%;}
				.stats-container .tab-content .tab-pane .filtros{border-bottom: 1px solid #DDD; padding: 0px;}
					.stats-container .tab-content .tab-pane .filtros .separador{
						display: inline-block;
						margin: 0px 10px;
						height: 45px;
						margin-bottom: -5px;
						border-right: 1px solid #DDD;
					}
					.stats-container .tab-content .tab-pane .filtros .input{display: inline-block; margin: 0px 10px 10px;}
					.stats-container .tab-content .tab-pane .filtros .input.checkbox{margin-left: 30px;}
						.stats-container .tab-content .tab-pane .filtros .input.checkbox label{padding-left: 5px;}
				.stats-container .tab-content .tab-pane .charts{height: 85%;}
				.stats-container .tab-content .tab-pane .count{
					border-bottom: 5px solid #CDCD21;
					background-color: #E3DF3B;
					margin: 10px 0px;
					-webkit-border-radius: 10px;
					-moz-border-radius: 10px;
					border-radius: 10px;
					text-align: center;
					font-size: 30px;
					padding: 10px 0px;
				}
					.stats-container .tab-content .tab-pane .count .number{font-size: 50px;}
	
</style>
<?php
	echo $this->Html->script('https://www.google.com/jsapi');
?>
<script>
google.load('visualization', '1.0', {'packages':['corechart']});

google.setOnLoadCallback(function(){
	LoadChart('avisos');
});

$(document).ready(function(){
	
	$('.nav-tabs a').click(function(){
		var controller = $(this).attr('href').replace('#','');
		LoadChart(controller);
	});
	
	/* Tooltips */
	$('#botonera button').tooltip({container: 'body'});
	
	$('.btn-filtrar').click(function(){
		var controller = $(this).closest('.tab-pane').attr('id');
		LoadChart(controller);
	});
	
	$('.btn-limpiar').click(function(){
		var controller = $(this).closest('.tab-pane').attr('id');
		LimpiarFiltros(controller);
	});
	
	$('.group-by').change(function(){
		var controller = $(this).closest('.tab-pane').attr('id');
		LoadChart(controller);
	});
	
	$('.fecha-selector').datepicker({
		format: "dd/mm/yyyy"
	});
});

function LoadChart(controller){
	var conditions = {};
	$('#'+controller).find('.filtros .filtro').each(function(){
		if($(this).is(':checkbox')){
			if($(this).prop('checked')){
				conditions[$(this).attr('name')] = 1;
			}
		}else{
			conditions[$(this).attr('name')] = $(this).val();
		}
	});
	var group_by = $('#'+controller).find('.group-by').find(":selected").val();
	var title = $('#'+controller).find('.group-by').find(":selected").text();
	var url = '<?php echo Router::url('/'); ?>control/'+controller+'/get_grouped_by/'+group_by;
	drawChart(title,controller+'-chart',url,conditions);
}

function LimpiarFiltros(controller){
	$('#'+controller).find('.filtros .filtro').each(function(){
		if($(this).is(':checkbox')){
			$(this).prop('checked',false);
		}else{
			$(this).val('');
		}
	});
	LoadChart(controller);
}

function drawChart(title, element_id, data_url,conditions){
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	if(conditions == undefined){conditions = {};}
	$.post(data_url, conditions, function(response){
		if(response != 'error'){
			var response_decoded = JSON.parse(response);
			var options = {'title': title, 'height': '100%'};
			var total = 0;
			$.each(response_decoded, function(index, value){
				data.addRows([[value[0].name, parseInt(value[0].count)]]);
				total += parseInt(value[0].count);
			});
			$('#'+element_id).closest('.tab-pane').find('.count .number').html(total);
			var chart = new google.visualization.PieChart(document.getElementById(element_id));
			chart.draw(data, options);
		}
	});
}
</script>
<div class="col-md-12" style="height: 100%;">

	<h1 style="float: left;" class="col-md-4 row">Estadísticas</h1>

	<div class="counters col-md-8 row">
		<div class="col-md-3" id="avisos-counter">
			Avisos publicados: <span class="number"><?php echo $avisos_count; ?></span>
		</div>
		<div class="col-md-3" id="usuarios-counter">
			Usuarios registrados: <span class="number"><?php echo $usuarios_count; ?></span>
		</div>
		<div class="col-md-3" id="empresas-counter">
			Empresas registradas: <span class="number"><?php echo $empresas_count; ?></span>
		</div>
	</div>
	
	<div class="col-md-12 stats-container">
	
		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#avisos" role="tab" data-toggle="tab">Avisos</a></li>
			<li><a href="#usuarios" role="tab" data-toggle="tab">Usuarios</a></li>
			<li><a href="#empresas" role="tab" data-toggle="tab">Empresas</a></li>
		</ul>
	
		<div class="tab-content">
			<div class="tab-pane active" id="avisos">
				<div class="col-md-12 filtros form-personal">
					<?php $options = array(
						'LaboralTipoTrabajo.denominacion' => 'Tipo de trabajo',
						'LaboralArea.denominacion' => 'Área',
						'LaboralNivelPuesto.denominacion' => 'Nivel',
						'Empresa.nombre_comercial' => 'Empresa'
					); ?>
					<?php echo $this->Form->input('Aviso.group',array('label'=>'Agrupar por:','options'=>$options,'class'=>'inputplano botonplano group-by')); ?>
					<div class="separador"></div>
					<?php echo $this->Form->input('Aviso.habilitado',array('type'=>'checkbox','class'=>'filtro','checked'=>true)); ?>
					<?php echo $this->Form->input('Aviso.created >=',array('label'=>'Fecha desde','class'=>'fecha-selector inputplano botonplano filtro')); ?>
					<?php echo $this->Form->input('Aviso.created <=',array('label'=>'Fecha hasta','class'=>'fecha-selector inputplano botonplano filtro')); ?>
					<div id="botonera" style="float: right; margin: 10px 0px;" class="btn-group botonera">
						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Todos" class="btn btn-limpiar btn-default glyphicon glyphicon-asterisk"></button>
						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Filtrar" class="btn btn-filtrar btn-primary glyphicon glyphicon-search"></button>
					</div>
				</div>
				<div class="col-md-10 charts">
					<div style="position: relative;height: 100%;" id="avisos-chart"></div>
				</div>
				<div class="col-md-2 count">
					<div class="number"></div> Avisos
				</div>
			</div>
			<div class="tab-pane" id="usuarios">
				<div class="col-md-12 filtros form-personal">
					<?php $options = array(
						'DatosPersonales.provincia_residencia_id' => 'Ubicación',
						'DatosPersonales.edad' => 'Rango de edad',
						'DatosPersonales.sexo_id' => 'Sexo',
						'Estudio.area_id' => 'Área de estudio',
						'Estudio.nivel_id' => 'Máximo nivel alcanzado',
						'Experiencia.nivelpuesto_id' => 'Nivel de puesto (experiencia)',
						'Experiencia.industria_id' => 'Industria (experiencia)',
						'Experiencia.area_id' => 'Área (experiencia)',
						'DatosPersonales.estadocivil_id' => 'Estado civil',
					); ?>
					<?php echo $this->Form->input('Usuario.group_by',array('label'=>'Agrupar por:','options'=>$options,'class'=>'inputplano botonplano group-by')); ?>
					<div class="separador"></div>
					<?php echo $this->Form->input('Usuario.created >=',array('label'=>'Fecha desde','class'=>'fecha-selector inputplano botonplano filtro')); ?>
					<?php echo $this->Form->input('Usuario.created <=',array('label'=>'Fecha hasta','class'=>'fecha-selector inputplano botonplano filtro')); ?>
					<div id="botonera" style="float: right; margin: 10px 0px;" class="btn-group botonera">
						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Todos" onClick="LimpiarFiltros();" class="btn btn-default glyphicon glyphicon-asterisk"></button>
						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Filtro avanzado" class="btn btn-filtrar btn-primary glyphicon glyphicon-search"></button>
					</div>
				</div>
				<div class="col-md-10 charts">
					<div style="position: relative;height: 100%;" id="usuarios-chart"></div>
				</div>
				<div class="col-md-2 count">
					<div class="number"></div> Usuarios
				</div>
			</div>
			<div class="tab-pane" id="empresas">
				<div class="col-md-12 filtros form-personal">
					<?php $options = array(
						'LaboralIndustria.denominacion' => 'Industria'
					); ?>
					<?php echo $this->Form->input('Empresa.group_by',array('label'=>'Agrupar por:','options'=>$options,'class'=>'inputplano botonplano group-by')); ?>
					<div class="separador"></div>
					<?php echo $this->Form->input('Empresa.created >=',array('label'=>'Fecha desde','class'=>'fecha-selector inputplano botonplano filtro')); ?>
					<?php echo $this->Form->input('Empresa.created <=',array('label'=>'Fecha hasta','class'=>'fecha-selector inputplano botonplano filtro')); ?>
					<div id="botonera" style="float: right; margin: 10px 0px;" class="btn-group botonera">
						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Todos" onClick="LimpiarFiltros();" class="btn btn-default glyphicon glyphicon-asterisk"></button>
						<button type="button" data-toggle="tooltip" data-placement="bottom" title="Filtro avanzado" class="btn btn-filtrar btn-primary glyphicon glyphicon-search"></button>
					</div>
				</div>
				<div class="col-md-10 charts">
					<div style="position: relative;height: 100%;" id="empresas-chart"></div>
				</div>
				<div class="col-md-2 count">
					<div class="number"></div> Empresas
				</div>
			</div>
		</div>
	</div>
	
</div>