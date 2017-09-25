
<div class="megallery_wrapper">
	<div class="row">
	
		<div class="column">
			<div class="row ">
					<div class="column col12 top">
						<div class="barFormSide " style="width:200px">
							<div class="megallery_content_title">Galleries:</div>
							<div class="megallery_content_tool">
								<ul>
									<li><a href="#" data-icon="add" onclick=manager.gallery().add()>Add</a></li>
									<li><a href="#" data-icon="del" onclick=manager.gallery().del() style="visibility:hidden">Del</a></li>
							
								</ul>
							</div>
							
							<div id="listGallery">
								
							</div>
					
						</div>

						<div  class="barFormSide " style="width:200px;">
							<div class="megallery_content_title">Parameters of Gallery:</div>
							
							<div id="box_galleryinfo" style="visibility:hidden">
								<a href="#" data-icon="add" onclick=manager.gallery().save()>Save</a>
								<hr>
								<label><strong>Status:</strong></label> <label id='gallerymaster_status'></label>
								<br>
								Mode:<br><select name="gallery_mode" >
									<option value='gallery' disabled selected>Select</option>
									<option value='gallery'  >Gallery</option>
									<option value='compact'  >Compact</option>
								</select>
								<br>
								<label><strong>Delay(ms):</strong></label><br><input type="text" id='gallerymaster_delay' value="" placeholder=""></label>
							</div>
							<!-- <div id="listGalleryParameter">
								
							</div> -->
					
						</div>

					</div>
					<div class="column top " >

						<!-- <div class="barFormSide megallery_info" >
							<div class="row left">
								<div class="column col9 left"></div>					
								<div class="column left"></div>										 
						
								<div class="column right"></div>										 
							</div>
						</div>
						
						 -->
						<div class="barForm megallery_gallerycontent" >
							<div id="galleryContent">
								Select or create a gallery
							</div>
						</div>

					</div>



					<div class="column col12 top" style="width: 244px;">
						<div class="barFormSide " style="width:246px;position:fixed;height: 80%;">
							
							<div class="megallery_info">
															
								<div><label><strong>Galerry:</strong></label><br><label id='gallery_title'></label></div>
								<div><label><strong>Shortcode:</strong></label><br><label id='gallery_shortcode'></label></div>
								<div><label><strong>Itens:</strong></label> <label id='gallery_count'></label></div>
								<div><label><strong>Status:</strong></label> <label id='gallery_status'></label>


							</div>
							
							<hr>

							<div class="megallery_content_title">Parameters of image:</div>
							<!-- <div class="megallery_content_tool">
								<ul>
									<li><a href="#" data-icon="add">Add</a></li>
									<li><a href="#" data-icon="del">del</a></li>
								</ul>
							</div> -->
							
							<form name="parameters_item">
								<label>Id</label><br>
								<input type="text" name="megallery_form_id" readonly="" ><br>
								<label>Title</label><br>
								<input type="text" name="megallery_form_title" placeholder="Titulo"><br>
								<label>Description</label><br>
								<input type="text" name="megallery_form_description" placeholder="Descrição"><br>
								<label>Link</label><br>
								<input type="text" name="megallery_form_link" placeholder="Link"><br>
								<label>Target</label><br>
								<input type="text" name="megallery_form_target" placeholder="_blank" value="_blank"><br>
								

								<input type="hidden" name="megallery_form_gallery" >								

								<a class="button" onclick=manager.saveItem();>Save</a>
							</form>
						</div>

					</div>


			</div>

		</div>

		
		<!-- <div class="column  top">
			
		
			<div class="barForm absolute" style="left:220px;top:40px;z-index:-1">
				<div id="galleryContent">
					
				</div>
			</div>
		</div> -->
	</div>
</div>