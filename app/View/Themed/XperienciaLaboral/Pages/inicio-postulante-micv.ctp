<style>
.inputplano.error{
	border: 3px solid red;
}

.error-string{color: red;}

.loading{
	background-image: url(img/loading.gif);
	height: 30px;
	width: 30px;
	float: left;
	background-size: contain;
	background-position: center center;
	background-repeat: no-repeat;
}

.flash-message{
	position: fixed;
	top: 0px;
	left: 0px;
	right: 0px;
	//margin: auto;
	//width: 100%;
	background-color: rgba(46, 185, 198, 0.9);
	border-image: none;
	text-align: center;
	padding: 10px;
	font-size: 20px;
	display: none;
	color: white;
	z-index: 30;
}

#completion-wizard{
	position: absolute;
	top: 0px;
	right: 0px;
	background-color: #EDEDED;
	border-bottom: 8px solid #D2D2D2;
	margin: 20px;
	width: 290px;
	padding: 20px;
	padding-bottom: 10px;
}

	#completion-wizard .secciones{}
	
		#completion-wizard .secciones .seccion{
			font-family: "Lato",sans-serif;
			color: #8C8C8C;
			font-size: 16px;
			text-decoration: none;
			display: block;
			overflow: hidden;
			margin: 5px 0px;
		}
		
		#completion-wizard .secciones .seccion:hover{text-decoration: underline;}
		
			#completion-wizard .secciones .seccion .status{
				width: 25px;
				height: 25px;
				background-size: contain;
				background-position: center center;
				background-repeat: no-repeat;
				float: right;
			}
			
			#completion-wizard .secciones .seccion .status.completo{
				background-image: url(img/ok.png);
			}
			
			#completion-wizard .secciones .seccion .status.incompleto{
				background-image: url(img/edit.png);
			}
		
	#completion-wizard .porcentaje{
		position: relative;
		padding: 5px;
		background-color: lightgray;
		margin-bottom: 20px;
	}
		#completion-wizard .porcentaje .text{
			position: relative;
			z-index: 20;
			color: #686868;
			font-weight: bold;
			text-align: center;
		}
	
		#completion-wizard .porcentaje .bar{
			width: 0%;
			height: 100%;
			position: absolute;
			z-index: 10;
			top: 0px;
			left: 0;
			background: rgb(228,223,60); /* Old browsers */
			background: -moz-linear-gradient(top, rgba(228,223,60,1) 0%, rgba(205,205,33,1) 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(228,223,60,1)), color-stop(100%,rgba(205,205,33,1))); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top, rgba(228,223,60,1) 0%,rgba(205,205,33,1) 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top, rgba(228,223,60,1) 0%,rgba(205,205,33,1) 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top, rgba(228,223,60,1) 0%,rgba(205,205,33,1) 100%); /* IE10+ */
			background: linear-gradient(to bottom, rgba(228,223,60,1) 0%,rgba(205,205,33,1) 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e4df3c', endColorstr='#cdcd21',GradientType=0 ); /* IE6-9 */
		}
</style>
<script>
	var animation_going = false;
	
	var user = JSON.parse('<?php echo json_encode($user); ?>');
	
	$(document).ready(function(){
	
		FillData(user);
	
		if(user.DatosPersonales.id == null){
			$('#datos_personales div.display').hide();
			$('#datos_personales div.edit').show();
		}
		
		$('.item.contenedor .add-item').click(function(){
			var id = $(this).closest('.item.contenedor').attr('id');
			AddItem(id);
		});
		
		$('.item.contenedor .cancel-add-item').click(function(){
			var id = $(this).closest('.item.contenedor').attr('id');
			CancelAddItem(id);
		});
		
		$('div.display .modify').click(function(){
			var id = $(this).closest('.item.contenedor').attr('id');
			OpenEdit(id);
		});
		
		$('div.edit .btn-cancel').click(function(){
			var id = $(this).closest('.item.contenedor').attr('id');
			CloseEdit(id);
		});
		
		$('div.edit .btn-submit').click(function(){
			SubmitData($(this));
		});
		
		$('#img-upload').change(function(){
			readURL(this);
		});
		
		$('[name=pais_residencia_id]').change(function(){
			UpdateCombo($('[name=provincia_residencia_id]'),'<?php echo $this->Html->Url(array('controller'=>'datos_personales','action'=>'get_provincias')); ?>/'+$(this).val());
		});
		
		$('#estudios [name=pais_id]').change(function(){
			UpdateCombo($('#estudios [name=institucion_id]'),'<?php echo $this->Html->Url(array('controller'=>'estudios','action'=>'get_instituciones')); ?>/'+$(this).val());
		});
		
		$(window).scroll(function(){
			BindTop($('#completion-wizard'));
		});

		GetProfileImage();
		BindButtons();
		FillCompletionWizard();
	});
	
	function UpdateCombo(element,url){
		$.post(url,function(response){
			data = JSON.parse(response);
			element.html('<option value="">Seleccione</option>');
			$.each(data,function(index,value){
				element.append('<option value="'+index+'">'+value+'</option>');
			});
		});
	}
	
	function GetProfileImage(){
		$.post('<?php echo 'img/profile_pics/'.$user['Usuario']['id'].'.jpg'; ?>',null,function(response){
			if(response){
				$('.user-image').attr('src','<?php echo 'img/profile_pics/'.$user['Usuario']['id'].'.jpg'; ?>');
			} 
		})
	}
	
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.user-image').attr('src', e.target.result);
				$.post('<?php echo $this->Html->Url(array('controller'=>'usuarios','action'=>'save_image')); ?>',{imgdata: e.target.result},function(response){
					if(response != 'error'){
					
					}
				});
            }
            reader.readAsDataURL(input.files[0]);
        }	
    }
	
	function BindButtons(){
		$('a.borrar').unbind('click');
		$('a.borrar').click(function(){
			EraseItem($(this));
		});
		$('a.editar').unbind('click');
		$('a.editar').click(function(){
			EditItem($(this));
		});
	}
	
	function AddItem(id){
		EraseInputData($('#'+id+' .template-edit'));
		OpenElement($('#'+id+' .template-edit'),function(){
			$('#'+id+' .add-item').text('Cancelar');
			$('#'+id+' .add-item').unbind('click');
			$('#'+id+' .add-item').click(function(){
				CancelAddItem(id);
			});
		});
	}
	
	function CancelAddItem(id,callback){
		CloseElement($('#'+id+' .template-edit'),function(){
			$('#'+id+' .add-item').text('Agregar');
			$('#'+id+' .add-item').unbind('click');
			$('#'+id+' .add-item').click(function(){
				AddItem(id);
			});
			if(callback != undefined){callback();}
		});
	}
	
	function OpenEdit(id){
		CloseElement($('#'+id+' div.display .row.contenido'),function(){
			$('#'+id+' div.display').hide();
			$('#'+id+' div.edit').show();

			var model = $('#'+id).attr('model');
			FillInputData(user[model],$('#'+id+' div.edit'));

			OpenElement($('#'+id+' div.edit .row.contenido'));
		});
	}
	
	function CloseEdit(id){
		CloseElement($('#'+id+' div.edit .row.contenido'),function(){
			$('#'+id+' div.edit').hide();
			$('#'+id+' div.display').show();
			OpenElement($('#'+id+' div.display .row.contenido'));
		});
	}

	function SubmitData(button){
		var action = button.attr('action');
		var id = button.closest('.item.contenedor').attr('id');
		data = {};
		data['usuario_id'] = <?php echo $user['Usuario']['id']; ?>;
		
		$('#'+id+' .field-container input, #'+id+' .field-container textarea, #'+id+' .field-container select').each(function(){
			CleanErrorMessages($(this));
			if($(this).is(':radio')){
				if($(this).prop('checked')){
					data[$(this).attr('name')] = $(this).val();
				}
			}else{
				if($(this).attr('name') != undefined){
					data[$(this).attr('name')] = $(this).val();
				}
			}
		});
		
		ShowLoading($('#'+id));
		
		$.post('<?php echo $this->Html->Url('/'); ?>'+action,data,function(response){
			response_decoded = JSON.parse(response);
			if(response_decoded.status){
				data = response_decoded.data;
				user = $.extend(user,data);
				if(button.closest('.item.contenedor').hasClass('multiple')){
					CancelAddItem(id,function(){
						updateItems(id,data);
						setTimeout(CheckCompletion,1000);
					});
				}else{
					FillData(data);
					CloseEdit(id);
					CheckCompletion();
				}
			}else{
				$.each(response_decoded.errores,function(index,value){
					var input = $('#'+id+' .field-container [name="'+index+'"]');
					input.addClass('error');
					input.parent().append('<span class="error-string">'+value[0]+'</span>');
				});
			}
			HideLoading($('#'+id),response_decoded.message);
		});
	}

	function FillData(data,index_string){
		if(index_string==undefined){index_string='';}
		$.each(data,function(index,value){
			if(value instanceof Object){
				if(typeof index== "number"){
					var model = index_string.replace('-','');
					AddNewItem(model,index);
				}
				FillData(value,index_string+index+'-');
			}else{
				$('#'+index_string+index).html(value);
			}
		});
		$('.solotexto').show();
		$('.data').each(function(){
			if($(this).html()==''){
				$(this).closest('.solotexto').hide();
			}
		});
	}

	function AddNewItem(model,index){
		var template = $('[model="'+model+'"] .template-display').html();
		if(template != undefined){
			template = template.replace(/index/g,index);
			$('[model="'+model+'"] .items').append(template);
		}
	}
	
	function EraseItem(element){
		var item_container = element.closest('.item-container');
		var index = item_container.attr('id');
		var model = element.closest('.item.contenedor').attr('model');
		var action = element.closest('.item.contenedor').attr('id');
		var id = user[model][index]['id'];
		action += '/delete/'+id;
		$.post('<?php echo $this->Html->Url('/'); ?>'+action,{},function(response){
			if(response != 'error'){
				CloseElement(item_container,function(){
					item_container.remove();
					CheckCompletion();
				});
			}else{
				alert('Ocurrió un error');
			}
		});
	}
	
	function EditItem(element){
		var item_container = element.closest('.item-container');
		var index = item_container.attr('id');
		var model = element.closest('.item.contenedor').attr('model');
		var id = element.closest('.item.contenedor').attr('id');
		CloseElement(item_container,function(){
			FillInputData(user[model][index],$('#'+id+' .template-edit'));
			OpenElement($('#'+id+' .template-edit'),function(){
				$('#'+id+' .add-item').text('Cancelar');
				$('#'+id+' .add-item').unbind('click');
				$('#'+id+' .add-item').click(function(){
					CancelAddItem(id,function(){
						OpenElement(item_container);
					});
				});
			});
		});
	}
	
	function EraseInputData(element){
		element.find('input, textarea, select').each(function(){
			if($(this).attr('name') != undefined){
				CleanErrorMessages($(this));
				if($(this).is(':radio')){
					$(this).prop('checked',false)
				}
				$(this).val('');
			}
		});
	}
	
	function FillInputData(data,element){
		element.find('input, textarea, select').each(function(){
			if($(this).attr('name') != undefined){
				CleanErrorMessages($(this));
				if($(this).is(':radio')){
					if($(this).val() == data[$(this).attr('name')]){
						$(this).prop('checked',true)
					}
				}
				$(this).val(data[$(this).attr('name')]);
			}
		});
	}
	
	function CleanErrorMessages(element){
		element.removeClass('error');
		element.parent().find('.error-string').remove();
	}
	
	function CloseElement(element,callback){
		if(!animation_going){
			animation_going = true;
			element.animate({height: 0},500,function(){
				element.hide();
				animation_going = false;
				if(callback != undefined){
					callback();
				}
			});
		}
	}
	
	function OpenElement(element,callback){
		if(!animation_going){
			animation_going = true;
			element.height(0);
			element.show();
			element.animate({height: element.get(0).scrollHeight},500,function(){
				element.css('height','auto');
				animation_going = false;
				if(callback != undefined){
					callback();
				}
			});
		}
	}
	
	function updateItems(id,data){
		CloseElement($('#'+id+' .items'),function(){
			$('#'+id+' .items').html('');
			FillData(data);
			BindButtons();
			OpenElement($('#'+id+' .items'));
		});
	}
	
	function ShowLoading(element){
		element.find('.edit .contedit').prepend('<div class="loading"></div>');
	}
	
	function HideLoading(element,message){
		element.find('.loading').remove();
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

	function BindTop(element){
		var eTop = element.offset().top;
		if(eTop - $(window).scrollTop() < 0 || parseInt(element.css('top')) > 0){
			element.offset({top: $(window).scrollTop()+20});
		}
		
		if(parseInt(element.css('top')) < 0){
			element.css('top','0px');
		}
	}
	
	function FillCompletionWizard(){
		$('.item.contenedor').each(function(){
			var title = $(this).find('.titulo h3').first().text();
			$('#completion-wizard .secciones').append('<a class="seccion" seccion_id="'+$(this).attr('id')+'" href="javascript:void(0)">'+title+'</a>');
		});
		$('#completion-wizard .seccion').click(function(){
			$('#'+$(this).attr('seccion_id')).scrollView();
		});
		CheckCompletion();
	}
	
	function CheckCompletion(){
		var count = 0;
		var complete = 0;
		$('.item.contenedor').each(function(){
			count++;
			var seccion = $('#completion-wizard [seccion_id='+$(this).attr('id')+']');
			seccion.find('.status').remove();
			if($(this).hasClass('multiple')){
				if($(this).find('.items .item-container').length > 0){
					seccion.append('<div class="status completo"></div>');
					complete++;
				}else{
					seccion.append('<div class="status incompleto"></div>');
				}
			}else{
				var model = $(this).attr('model');
				var completo = true;
				$(this).find('.required').each(function(){
					if(user[model][$(this).attr('name')] == undefined){
						completo = false;
					}
				});
				if(completo){
					seccion.append('<div class="status completo"></div>');
					complete++;
				}else{
					seccion.append('<div class="status incompleto"></div>');
				}
			}
		});
		var porcentaje = (complete * 100)/count;
		$('#completion-wizard .porcentaje .text').text(porcentaje+'% completo');
		$('#completion-wizard .porcentaje .bar').animate({width: porcentaje+'%'},2000,function(){});
		if(porcentaje >= 50){
			$('.ver-vacantes').show();
		}else{
			$('.ver-vacantes').hide();
		}
	}
	
	$.fn.scrollView = function(){
		return this.each(function(){
			$('html, body').animate({scrollTop: $(this).offset().top}, 500);
		});
	}
</script>
<div id="micv" class="col-md-12 form-personal">
	<div class="row">
		<div class="col-md-8 subcontent">

			<div class="item contenedor" model="DatosPersonales" id="datos_personales">
			
				<div class="display">
				
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Datos Personales</h3>
						</div>
						<div class="col-md-3 contedit">
							<a class="botonplano edit modify" href="javascript:void(0);">Editar</a>
						</div>
					</div></div>
					
					<div class="row contenido">
						<div class="col-md-3 fotoperfil">
							<div class="subcontent">
								<div class="row">
									<div class="col-md-12 contfotoperfil">
										<img src="http://placehold.it/110x110" style="width:110px;" class="user-image" alt="p"/>
									</div>
									<div class="col-md-12 contsubirimagen">
										<div style="display: none;">
											<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
												<input type="file" id="img-upload" name="upl" multiple />
											</form>
										</div>
										<a href="javascript:void(0);" onClick="$('#img-upload').trigger('click');" class="botonplano subirimagen">Subir imagen</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<ul class="lista nospaces">
								<li><strong>
									<span class="data" id="DatosPersonales-nombre"></span>
									<span class="data" id="DatosPersonales-apellido"></span>
								</strong></li>
								<li><span class="data" id="DatosPersonales-edad"></span> años</li>
								<li class="data" id="DatosPersonales-EstadoCivil-denominacion"></li>
								<li>
									<span class="data" id="DatosPersonales-TipoDocumento-denominacion"></span>
									<span class="data" id="DatosPersonales-nrodocumento"></span>
								</li>
								<li class="data" id="DatosPersonales-telefono_hogar"></li>
								<li class="data" id="DatosPersonales-telefono_celular"></li>
								<li id="Usuario-email"></li>
							</ul>
						</div>
					</div>
					
				</div>
				
				<div class="edit field-container">
					<div class="titulo">
						<div class="row">
							<div class="col-md-9">
								<h3 class="nospaces">Datos Personales</h3>
							</div>
							<div class="col-md-3 contedit">
								<a href="javascript:void(0);" class="botonplano edit btn-cancel">Cancelar</a>
							</div>
						</div>
					</div>
					<div class="row contenido">
						<div class="col-md-3 fotoperfil">
							<div class="subcontent">
								<div class="row">
									<div class="col-md-12 contfotoperfil">
										<img src="http://placehold.it/110x110" style="width:110px;" class="user-image" alt="p"/>
									</div>
									<div class="col-md-12 contsubirimagen">
										<div style="display: none;">
											<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
												<input type="file" id="img-upload" name="upl" multiple />
											</form>
										</div>
										<a href="javascript:void(0);" onClick="$('#img-upload').trigger('click');" class="botonplano subirimagen">Subir imagen</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="nombre">Nombres</label>
								</div>
								<div class="col-md-8 nospaces">
									<input name="nombre" class="required botonplano inputplano"/>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="apellido">Apellidos</label>
								</div>
								<div class="col-md-8 nospaces">
									<input name="apellido" class="required botonplano inputplano"/>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8  nospaces">
									<label for="sexo_id">Sexo</label>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8 nospaces">
									<div class="row">
										<div class="col-md-5">
											<input name="sexo_id" value="2" type="radio" />
											<label for="sexo_id">Femenino</label>
										</div>
										<div class="col-md-5">
											<input name="sexo_id" value="1" type="radio" />
											<label for="sexo_id">Masculino</label>
										</div>
									</div>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="fnacimiento">Fecha de nacimiento</label>
								</div>
								<div class="col-md-8 nospaces">
									<div class="row">
										<div class="col-md-4">
											<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$dias,'name'=>'fnacimiento-dia')); ?>
										</div>
										<div class="col-md-4">
											<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$meses,'name'=>'fnacimiento-mes')); ?>
										</div>
										<div class="col-md-4">
											<select name="fnacimiento-ano" class="botonplano inputplano" >
												<?php
													for ($i=1996;$i>1900;$i--){
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<span>(DD/MM/AAAA)</span>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="pais_nacionalidad_id">Nacionalidad</label>
								</div>
								<div class="col-md-8 nospaces">
									<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$paises,'name'=>'pais_nacionalidad_id')); ?>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-12 nospaces">
									<label for="estadocivil_id">Estado civil</label>
								</div>
								<div class="col-md-12 nospaces">
									<div class="row">
										<div class="col-md-3">
											<input type="radio" name="estadocivil_id" value="2"/>
											<label for="estadocivil_id">Casado/a</label>
										</div>
										<div class="col-md-3 nospaces">
											<input type="radio" name="estadocivil_id" value="3"/>
											<label for="estadocivil_id">Divorciado/a</label>
										</div>
										<div class="col-md-3 nospaces">
											<input type="radio" name="estadocivil_id" value="1"/>
											<label for="estadocivil_id">Soltero/a</label>
										</div>
										<div class="col-md-3 nospaces">
											<input type="radio" name="estadocivil_id" value="4"/>
											<label for="estadocivil_id">Viudo/a</label>
										</div>
									</div>
								</div>
							</div>
							<div class="item row">
									<div class="col-md-12 nospaces">
										<label for="tipodocumento_id">Documento</label>
									</div>
									<div class="col-md-12 nospaces">
										<div class="col-md-2 nospaces">
											<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$tipos_documentos,'name'=>'tipodocumento_id')); ?>
										</div>
										<div class="col-md-2">
											<label for="nrodocumento">Número</label>
										</div>
										<div class="col-md-4">
											<input name="nrodocumento" class="botonplano inputplano" value="<?php echo (isset($user['DatosPersonales']['nrodocumento'])?$user['DatosPersonales']['nrodocumento']:''); ?>"/>
										</div>
										<div class="col-md-12">
											<p>Ingresa sólo números sin puntos, espacios ni comas.</p>
										</div>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="telefono_hogar">Teléfono</label>
								</div>
								<div class="col-md-8 nospaces">
									<div class="row">
										<div class="col-md-4">
											<input name="telefono_hogar-cod" class="botonplano inputplano" />
										</div>
										<div class="col-md-8">
											<input name="telefono_hogar-num" class="botonplano inputplano" />
										</div>
									</div>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="telefono_celular">Celular</label>
								</div>
								<div class="col-md-8 nospaces">
									<div class="row">
										<div class="col-md-4">
											<input name="telefono_celular-cod" class="botonplano inputplano" />
										</div>
										<div class="col-md-8">
											<input name="telefono_celular-num" class="botonplano inputplano" />
										</div>
									</div>
								</div>
							</div>
							<div class="item row">
								<div class="col-md-12 nospaces">
									<input class="submit botonplano btn-submit" type="submit" action="datos_personales/save" value="Guardar datos"/>
									<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="item contenedor" model="DatosPersonales" id="datos_personales-residencia">

				<div class="display">
					<div class="titulo">
						<div class="row">
							<div class="col-md-9">
								<h3 class="nospaces">Lugar de residencia</h3>
							</div>
							<div class="col-md-3 contedit">
								<a class="botonplano edit modify" href="javascript:void(0);">Editar</a>
							</div>
						</div>
					</div>
					<div class="row contenido">
						<div class="col-md-12">
							<p class="solotexto">
								<span class="data" id="DatosPersonales-domicilio"></span>, 
								<span class="data" id="DatosPersonales-Provincia-denominacion"></span>, 
								<span class="data" id="DatosPersonales-Pais-denominacion"></span></p>
						</div>
					</div>
				</div>
				
				<div class="edit field-container">
					<div class="titulo">
						<div class="row">
							<div class="col-md-9">
								<h3 class="nospaces">Lugar de residencia</h3>
							</div>
							<div class="col-md-3 contedit">
								<a href="javascript:void(0);" class="botonplano edit btn-cancel">Cancelar</a>
							</div>
						</div>
					</div>
					<div class="row contenido">
						<div class="col-md-9">
						
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="pais_residencia_id">Pais</label>
								</div>
								<div class="col-md-8 nospaces">
									<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$paises,'name'=>'pais_residencia_id')); ?>
								</div>
							</div>
							
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="provincia_residencia_id">Provincia</label>
								</div>
								<div class="col-md-8 nospaces">
									<?php echo $this->Form->input('',array('class'=>'required botonplano inputplano','options'=>array(''=>'Seleccione'),'name'=>'provincia_residencia_id')); ?>
								</div>
							</div>
						
						
							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="domicilio">Domicilio</label>
								</div>
								<div class="col-md-8 nospaces">
									<input name="domicilio" class="required botonplano inputplano"/>
								</div>
							</div>

							<div class="item row">
								<div class="col-md-8 nospaces">
									<label for="codigo_postal">Código postal</label>
								</div>
								<div class="col-md-8 nospaces">
									<input name="codigo_postal" class="required botonplano inputplano"/>
								</div>
							</div>
							
							<div class="item row">
								<div class="col-md-12 nospaces">
									<input class="submit botonplano btn-submit" type="submit" action="datos_personales/save" value="Guardar datos"/>
									<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="row contenido">
						<div class="col-md-12">
							<p class="solotexto">Aguas Calientes, Ciudad de México, México</p>
						</div>
						<div class="col-md-12">
							<div class="col-md-8 nospaces">
								<input class="botonplano inputplano" value="Avenida Alvarez Thomas 2620" />
							</div>
							<div class="col-md-4 nospaces"><a href="#" class="botonplano edit localizar">Localizar en el mapa</a></div>
						</div>
						<div class="col-md-12">
							<div class="locacionmapa">
								<iframe width="573" height="357" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=Avenida%20Alvarez%20Thomas%202620%2C%20Buenos%20Aires%2C%20Argentina&key=AIzaSyDUZ6F4czMHvre5hbnkCR5zop-MPEQRcdo"></iframe> 
							</div>
						</div>
					</div>-->
				</div>
			</div>
			
			<div class="item contenedor" model="Presentacion" id="presentaciones">
			
				<div class="display">
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Presentación/Bio</h3>
						</div>
						<div class="col-md-3 contedit">
							<a class="botonplano edit modify" href="javascript:void(0);">Editar</a>
						</div>
					</div></div>
					<div class="row contenido">
						<div class="col-md-12">
							<p class="solotexto data" id="Presentacion-descripcion"></p>
						</div>
					</div>
				</div>
				
				<div class="edit field-container">
					<div class="titulo">
						<div class="row">
							<div class="col-md-9">
								<h3 class="nospaces">Presentación/Bio</h3>
							</div>
							<div class="col-md-3 contedit">
								<a href="javascript:void(0);" class="botonplano edit btn-cancel">Cancelar</a>
							</div>
						</div>
					</div>
					<div class="row contenido">
						<div class="col-md-12">
							<textarea name="descripcion" cols="30" rows="5" class="required botonplano inputplano textarea"></textarea>
						</div>
						<div class="col-md-12">
							<input class="submit botonplano btn-submit" type="submit" action="presentaciones/save" value="Guardar"/>
							<input class="submit botonplano inactive" type="submit" value="Cancelar"/>
						</div>
					
					</div>
				</div>
			</div>
			
			<div class="item contenedor" model="PreferenciaLaboral" id="preferencias_laborales">

				<div class="display">
				
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Preferencias salariales</h3>
						</div>
						<div class="col-md-3 contedit">
							<a class="botonplano edit modify" href="javascript:void(0);">Editar</a>
						</div>
					</div></div>
					
					<div class="row contenido"><div class="col-md-12">
						<p class="solotexto">Expectativa salarial: <strong>$<span class="data" id="PreferenciaLaboral-sueldo_bruto"></span> en mano</strong></p>
					</div></div>
					
				</div>
				
				<div class="edit field-container">
				
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Preferencias salariales</h3>
						</div>
						<div class="col-md-3 contedit">
							<a href="javascript:void(0);" class="botonplano edit btn-cancel">Cancelar</a>
						</div>
					</div></div>
						
					<div class="row contenido">
					
						<div class="col-md-12"><div class="row">
							<div class="col-md-4">
								<p class="solotexto">Expectativa salarial: $</p>
							</div>
							<div class="col-md-4">
								<input class="required botonplano inputplano salarial" name="sueldo_bruto"/>
							</div>
						</div></div>
						
						<div class="col-md-12">
							<input class="submit botonplano btn-submit" type="submit" action="preferencias_laborales/save" value="Guardar"/>
							<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
			<div class="item contenedor multiple" model="Experiencia" id="experiencias">

					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Experiencia laboral</h3>
						</div>
						<div class="col-md-3 contedit">
							<a href="javascript:void(0);" class="botonplano edit add-item">Agregar</a>
						</div>
					</div></div>
					
					<div class="template-display" style="display: none;">
						<div class="row contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4><span id="Experiencia-index-puesto"></span>, <span id="Experiencia-index-empresa"></span>, <span id="Experiencia-index-Pais-denominacion"></span></h4>
							<em><span id="Experiencia-index-finicio"></span> - <span id="Experiencia-index-ffin"></span></em>
							<p id="Experiencia-index-descripcion"></p>
							<a class="editar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-edit.png'); ?></a>
							<a class="borrar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-borrar.png'); ?></a>
						</li></ul></div></div>
					</div>
					
					<div class="template-edit field-container edit" style="display: none;">
						<div class="row contenido"><div class="col-md-12">
						
								<input type="hidden" name="id"/>
						
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="puesto">Título/Puesto</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<input class="botonplano inputplano" name="puesto"/>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="nivelpuesto_id">Seniority</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$niveles_puestos,'name'=>'nivelpuesto_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="empresa">Empresa</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<input class="botonplano inputplano" name="empresa"/>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="pais_id">País</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$paises,'name'=>'pais_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item fechainicio row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="finicio-ffin">Fecha de inicio</label>
									</div></div></div>
									<div class="col-md-12 inputs">
										<div class="row">
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$meses,'name'=>'finicio-mes')); ?>
											</div>
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$anios,'name'=>'finicio-ano')); ?>
											</div>
											<div class="col-md-1 nospaces alabel">
												<label for="">a</label>
											</div>
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$meses,'name'=>'ffin-mes')); ?>
											</div>
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$anios,'name'=>'ffin-ano')); ?>
											</div>
											<div class="col-md-2 nospaces">
												<input name="ffin-presente" type="checkbox"/>
												<label for="">al presente</label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="area_id">Área</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$areas_laborales,'name'=>'area_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="industria_id">Industria</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$industrias,'name'=>'industria_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-6 nospaces">
												<label for="descripcion">Descripción de responsabilidades</label>
											</div>
										</div>
									</div>
									<div class="col-md-12 nospaces">
										<textarea name="descripcion" cols="30" rows="5" class="botonplano inputplano textarea"></textarea>
									</div>
									<div class="col-md-12 nospaces">
										<input class="submit botonplano btn-submit" type="submit" action="experiencias/save" value="Guardar"/>
										<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="items"></div>
					
			</div>
			
			<div class="item contenedor multiple" model="Estudio" id="estudios">

					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Estudios</h3>
						</div>
						<div class="col-md-3 contedit">
							<a href="javascript:void(0);" class="botonplano edit add-item">Agregar</a>
						</div>
					</div></div>
					
					<div class="template-display" style="display: none;">
						<div class="row contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4><span id="Estudio-index-titulo"></span>, <span id="Estudio-index-EstudioInstitucion-denominacion"></span></h4>
							<em><span id="Estudio-index-finicio"></span> - <span id="Estudio-index-ffin"></span></em>
							<p><strong id="Estudio-index-EstudioNivel-denominacion"></strong></p>
							<a class="editar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-edit.png'); ?></a>
							<a class="borrar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-borrar.png'); ?></a>
						</li></ul></div></div>
					</div>
					
					<div class="template-edit field-container edit" style="display: none;">
						<div class="row contenido">
							<div class="col-md-12">
								<input type="hidden" name="id"/>
							
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="titulo">Título</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<input class="botonplano inputplano" name="titulo"/>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="pais_id">País</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$paises,'name'=>'pais_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="institucion_id">Institución</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$estudio_instituciones,'name'=>'institucion_id')); ?>
									</div></div></div>
								</div>

								<div class="item fechainicio row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="finicio">Fecha de inicio</label>
									</div></div></div>
									<div class="col-md-12 inputs">	
										<div class="row">
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$meses,'name'=>'finicio-mes')); ?>
											</div>
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$anios,'name'=>'finicio-ano')); ?>
											</div>
											<div class="col-md-1 nospaces alabel">
												<label for="ffin">a</label>
											</div>
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$meses,'name'=>'ffin-mes')); ?>
											</div>
											<div class="col-md-2 nospaces">
												<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$anios,'name'=>'ffin-ano')); ?>
											</div>
											<div class="col-md-2 nospaces">
												<input name="ffin-presente" type="checkbox"/>
												<label for="">al presente</label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="nivel_id">Nivel de estudio</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$estudio_niveles,'name'=>'nivel_id')); ?>
									</div></div></div>
								</div>

								<div class="item row">
									<div class="col-md-12 nospaces">
										<input class="submit botonplano btn-submit" type="submit" action="estudios/save" value="Guardar"/>
										<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="items"></div>

			</div>
	
			<div class="item contenedor multiple" model="ConocimientoIdioma" id="conocimiento_idiomas">
			
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Idiomas</h3>
						</div>
						<div class="col-md-3 contedit">
							<a href="javascript:void(0);" class="botonplano edit add-item">Agregar</a>
						</div>
					</div></div>
					
					<div class="template-display" style="display: none;">
						<div class="row contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4 id="ConocimientoIdioma-index-ConocIdioma-denominacion"></h4>
							<em>
								Escrito <span id="ConocimientoIdioma-index-ConocNivelOral-denominacion"></span>. 
								Oral <span id="ConocimientoIdioma-index-ConocNivelEscrito-denominacion"></span>. 
							</em>
							<a class="editar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-edit.png'); ?></a>
							<a class="borrar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-borrar.png'); ?></a>
						</li></ul></div></div>
					</div>
					
					<div class="template-edit field-container edit" style="display: none;">
						<div class="row contenido"><div class="col-md-12">
						
								<input type="hidden" name="id"/>
						
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="idioma_id">Idioma</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$idiomas,'name'=>'idioma_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="nivel_escrito_id">Escrito</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$idioma_niveles,'name'=>'nivel_escrito_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="nivel_oral_id">Oral</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$idioma_niveles,'name'=>'nivel_oral_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12 nospaces">
										<input class="submit botonplano btn-submit" type="submit" action="conocimiento_idiomas/save" value="Guardar"/>
										<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="items"></div>

			</div>
			
			<div class="item contenedor multiple" model="ConocimientoInformatica" id="conocimiento_informaticas">
			
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Informática</h3>
						</div>
						<div class="col-md-3 contedit">
							<a href="javascript:void(0);" class="botonplano edit add-item">Agregar</a>
						</div>
					</div></div>

					<div class="template-display" style="display: none;">
						<div class="row contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4 id="ConocimientoInformatica-index-ConocSoftware-denominacion"></h4>
							<em id="ConocimientoInformatica-index-ConocNivel-denominacion"></em>
							<a class="editar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-edit.png'); ?></a>
							<a class="borrar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-borrar.png'); ?></a>
						</li></ul></div></div>
					</div>
					
					<div class="template-edit field-container edit" style="display: none;">
						<div class="row contenido"><div class="col-md-12">
						
								<input type="hidden" name="id"/>
						
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="software_id">Área</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$software,'name'=>'software_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<label for="nivel_id">Nivel</label>
									</div></div></div>
									<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
										<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$niveles_conocimiento,'name'=>'nivel_id')); ?>
									</div></div></div>
								</div>
								
								<div class="item row">
									<div class="col-md-12 nospaces">
										<input class="submit botonplano btn-submit" type="submit" action="conocimiento_informaticas/save" value="Guardar"/>
										<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="items"></div>

			</div>
			
			<div class="item contenedor multiple" model="ConocimientoExtra" id="conocimiento_extras">

				<div class="titulo"><div class="row">
					<div class="col-md-9">
						<h3 class="nospaces">Conocimientos adicionales</h3>
					</div>
					<div class="col-md-3 contedit">
						<a href="javascript:void(0);" class="botonplano edit add-item">Agregar</a>
					</div>
				</div></div>
				
				<div class="template-display" style="display: none;">
					<div class="row contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
						<h4 id="ConocimientoExtra-index-nombre"></h4>
						<em id="ConocimientoExtra-index-descripcion"></em>
						<em id="ConocimientoExtra-index-ConocNivel-denominacion"></em>
						<a class="editar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-edit.png'); ?></a>
						<a class="borrar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-borrar.png'); ?></a>
					</li></ul></div></div>
				</div>
				
				<div class="template-edit field-container edit" style="display: none;">
					<div class="row contenido"><div class="col-md-12">
					
							<input type="hidden" name="id"/>
					
							<div class="item row">
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="nombre">Nombre</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<input class="botonplano inputplano" name="nombre"/>
								</div></div></div>
							</div>
							
							<div class="item row">
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="descripcion">Descripción</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<textarea name="descripcion" cols="30" rows="5" class="botonplano inputplano textarea"></textarea>
								</div></div></div>
							</div>
							
							<div class="item row">
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="nivel_id">Nivel</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<?php echo $this->Form->input('',array('class'=>'botonplano inputplano','options'=>$niveles_conocimiento,'name'=>'nivel_id')); ?>
								</div></div></div>
							</div>
							
							<div class="item row">
								<div class="col-md-12 nospaces">
									<input class="submit botonplano btn-submit" type="submit" action="conocimiento_extras/save" value="Guardar"/>
									<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				
				<div class="items"></div>

			</div>

			<div class="item contenedor multiple" model="Referencia" id="referencias">
			
				<div class="titulo"><div class="row">
					<div class="col-md-9">
						<h3 class="nospaces">Referencias</h3>
					</div>
					<div class="col-md-3 contedit">
						<a href="javascript:void(0);" class="botonplano edit add-item">Agregar</a>
					</div>
				</div></div>
				
				<div class="template-display" style="display: none;">
					<div class="row contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
						<span id="Referencia-index-id" style="display:none;"></span>
						<h4><span id="Referencia-index-nombre"></span> <span id="Referencia-index-apellido"></span></h4>
						<em id="Referencia-index-telefono"></em>
						<em id="Referencia-index-email"></em>
						<a class="editar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-edit.png'); ?></a>
						<a class="borrar" href="javascript:void(0);"><?php echo $this->Html->Image('micv-borrar.png'); ?></a>
					</li></ul></div></div>
				</div>
					
				<div class="template-edit field-container edit" style="display: none;">
				
					<input type="hidden" name="id"/>
				
					<div class="row contenido">
						<div class="col-md-12">
							<div class="item row">
							
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="nombre">Nombre</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<input class="botonplano inputplano" name="nombre"/>
								</div></div></div>
								
							</div>
							
							<div class="item row">
							
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="apellido">Apellido</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<input class="botonplano inputplano" name="apellido"/>
								</div></div></div>
								
							</div>

							<div class="item row">
							
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="telefono">Teléfono</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<input class="botonplano inputplano" name="telefono"/>
								</div></div></div>
								
							</div>
							
							
							<div class="item row">
							
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<label for="email">E-mail</label>
								</div></div></div>
								<div class="col-md-12"><div class="row"><div class="col-md-6 nospaces">
									<input class="botonplano inputplano" name="email"/>
								</div></div></div>
								
							</div>
							
							<div class="item row">
								<div class="col-md-12 nospaces">
									<input class="submit botonplano btn-submit" type="submit" action="referencias/save" value="Guardar"/>
									<input class="submit botonplano inactive btn-cancel" type="submit" value="Cancelar"/>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				
				<div class="items"></div>
				
			</div>
		
		</div>
	</div>
</div>
<div class="flash-message"></div>
<div id="completion-wizard">
	<div class="ver-vacantes" style="display:none; margin: 0px 0px 10px;">
	<?php //echo $this->Html->Link('Ver vacantes', array('controller'=>'avisos','action'=>'index')); ?>
	<button type="button" class="btn btn-primary" onClick="window.location.href='<?php echo $this->Html->Url(array('controller'=>'avisos','action'=>'index')); ?>';">Ver vacantes</button>
	</div>
	<div class="porcentaje">
		<div class="text"></div>
		<div class="bar"></div>
	</div>
	<div class="secciones"></div>
</div>