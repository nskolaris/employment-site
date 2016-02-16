<div id="micv" class="col-md-12 form-personal">
	<div class="row">
		<div class="col-md-8 subcontent">

			<div class="item contenedor" model="DatosPersonales" id="datos_personales">
			
				<div class="display">
				
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Datos Personales</h3>
						</div>
					</div></div>
					
					<div class="contenido">
						<div class="col-md-3 fotoperfil">
							<div class="subcontent">
								<div class="row">
									<div class="col-md-12 contfotoperfil">
										<img src="" style="width:110px;" class="user-image" alt="Foto de perfil"/>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<ul class="lista nospaces">
								<li>
									<strong>
										<span class="data" id="DatosPersonales-nombre"></span>
										<span class="data" id="DatosPersonales-apellido"></span>
									</strong>
									<a class="favorite-star glyphicon" href="javascript:void(0);"></a>
								</li>
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
			</div>

			<div class="item contenedor" model="DatosPersonales" id="datos_personales-residencia">

				<div class="display">
					<div class="titulo">
						<div class="row">
							<div class="col-md-9">
								<h3 class="nospaces">Lugar de residencia</h3>
							</div>
						</div>
					</div>
					<div class="contenido">
						<div class="col-md-12">
							<p class="solotexto"><span class="data" id="DatosPersonales-domicilio"></span>, <span class="data" id="DatosPersonales-Provincia-denominacion"></span>, <span class="data" id="DatosPersonales-Pais-denominacion"></span></p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="item contenedor" model="Presentacion" id="presentaciones">
			
				<div class="display">
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Presentación/Bio</h3>
						</div>
					</div></div>
					<div class="contenido">
						<div class="col-md-12">
							<p class="solotexto data" id="Presentacion-descripcion"></p>
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
					</div></div>
					
					<div class="contenido"><div class="col-md-12">
						<p class="solotexto">Expectativa salarial: <strong>$<span class="data" id="PreferenciaLaboral-sueldo_bruto"></span> en mano</strong></p>
					</div></div>
					
				</div>
			</div>
			
			<div class="item contenedor multiple" model="Experiencia" id="experiencias">

					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Experiencia laboral</h3>
						</div>
					</div></div>
					
					<div class="template-display" style="display: none;">
						<div class="contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4><span id="Experiencia-index-puesto"></span>, <span id="Experiencia-index-empresa"></span>, <span id="Experiencia-index-Pais-denominacion"></span></h4>
							<em><span id="Experiencia-index-finicio"></span> - <span id="Experiencia-index-ffin"></span></em>
							<p id="Experiencia-index-descripcion"></p>
						</li></ul></div></div>
					</div>

					<div class="items"></div>
					
			</div>
			
			<div class="item contenedor multiple" model="Estudio" id="estudios">

					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Estudios</h3>
						</div>
					</div></div>
					
					<div class="template-display" style="display: none;">
						<div class="contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4><span id="Estudio-index-titulo"></span>, <span id="Estudio-index-EstudioInstitucion-denominacion"></span></h4>
							<em><span id="Estudio-index-finicio"></span> - <span id="Estudio-index-ffin"></span></em>
							<p><strong id="Estudio-index-EstudioNivel-denominacion"></strong></p>
						</li></ul></div></div>
					</div>
					
					<div class="items"></div>

			</div>
	
			<div class="item contenedor multiple" model="ConocimientoIdioma" id="conocimiento_idiomas">
			
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Idiomas</h3>
						</div>
					</div></div>
					
					<div class="template-display" style="display: none;">
						<div class="contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4 id="ConocimientoIdioma-index-ConocIdioma-denominacion"></h4>
							<em>
								Escrito <span id="ConocimientoIdioma-index-ConocNivelOral-denominacion"></span>. 
								Oral <span id="ConocimientoIdioma-index-ConocNivelEscrito-denominacion"></span>. 
							</em>
						</li></ul></div></div>
					</div>
					
					<div class="items"></div>

			</div>
			
			<div class="item contenedor multiple" model="ConocimientoInformatica" id="conocimiento_informaticas">
			
					<div class="titulo"><div class="row">
						<div class="col-md-9">
							<h3 class="nospaces">Informática</h3>
						</div>
					</div></div>

					<div class="template-display" style="display: none;">
						<div class="contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
							<h4 id="ConocimientoInformatica-index-ConocSoftware-denominacion"></h4>
							<em id="ConocimientoInformatica-index-ConocNivel-denominacion"></em>
						</li></ul></div></div>
					</div>
					
					<div class="items"></div>

			</div>
			
			<div class="item contenedor multiple" model="ConocimientoExtra" id="conocimiento_extras">

				<div class="titulo"><div class="row">
					<div class="col-md-9">
						<h3 class="nospaces">Conocimientos adicionales</h3>
					</div>
				</div></div>
				
				<div class="template-display" style="display: none;">
					<div class="contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
						<h4 id="ConocimientoExtra-index-nombre"></h4>
						<em id="ConocimientoExtra-index-descripcion"></em>
						<em id="ConocimientoExtra-index-ConocNivel-denominacion"></em>
					</li></ul></div></div>
				</div>

				<div class="items"></div>

			</div>

			<div class="item contenedor multiple" model="Referencia" id="referencias">
			
				<div class="titulo"><div class="row">
					<div class="col-md-9">
						<h3 class="nospaces">Referencias</h3>
					</div>
				</div></div>
				
				<div class="template-display" style="display: none;">
					<div class="contenido item-container" id="index"><div class="col-md-12"><ul class="lista nospaces"><li>
						<span id="Referencia-index-id" style="display:none;"></span>
						<h4><span id="Referencia-index-nombre"></span> <span id="Referencia-index-apellido"></span></h4>
						<em id="Referencia-index-telefono"></em>
						<em id="Referencia-index-email"></em>
					</li></ul></div></div>
				</div>
					
				<div class="items"></div>
				
			</div>
		
		</div>
	</div>
</div>