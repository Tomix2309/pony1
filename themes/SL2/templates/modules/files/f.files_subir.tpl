<div id="form_upload" class="text-center w-75 bg-white p-4 mx-auto">
   <form id="New_upload" action="{$tsConfig.url}/files-subir.php" method="post" enctype="multipart/form-data">
      <div id="Select_file">
         <a href="javascript: void(0);" class="Fbtn text-uppercase list_text">Seleccionar archivo
            <input type="file" name="archivo" id="New_file" />
         </a>
         <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
               <div class="form-group text-start">
                  <label class="form-checkbox">Archivo privado <input type="checkbox" class="form-check-input" id="privado" name="privado"><span class="form-icon"></span> </label>
               </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
               <div class="form-group">
                  <select name="carpeta" class="form-select" id="carpeta">
                     <option value="0" class="form-select option" id="carpeta-0" selected>Sin carpeta</option>
                     {foreach $tsCarpetas key=id item=carpeta}
                        <option value="{$carpeta.car_id}" class="form-select option" id="carpeta-{$carpeta.car_id}">{$carpeta.car_name}</option>
                     {/foreach}
                  </select>
               </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"></div>
         </div>
      </div>
         <div class="result_text">
         </div>
      
		   	
      <input type="submit" value="Subir archivo" id="start_upload" class="btn btn-sm btn-block btn-primary" />
   </form>
   <div id="progress">
      <div id="bar"></div>
      <div id="percent">0%</div>
   </div>            
   <div id="message"></div>
</div>
<script src="https://cdn.jsdelivr.net/gh/jquery-form/form@4.3.0/dist/jquery.form.min.js"></script>
<script src="{$tsConfig.js}/files.subir.js?{$smarty.now}"></script>