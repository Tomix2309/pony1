<div class="avatares">
	<div class="row">
	   <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 avatar-cambiar">
	      <div onclick="avatar.accion.tipo('pc'); return false" class="box-type type-pc bg-info d-flex flex-column justify-content-center align-items-center"><i data-feather="monitor"></i> <span>Desde PC</span></div>
	      <div onclick="avatar.accion.tipo('url'); return false" class="box-type type-url bg-primary d-flex flex-column justify-content-center align-items-center"><i data-feather="link-2"></i> <span>Desde URL</span></div>
	   </div>
	   <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
	      <div class="grid-avatares">
	      {foreach $tsAvatares item=ava}
	         <a class="avatar" href="javascript:avatar.accion.seleccionar({$tsUser->uid}, {$ava.name})">
	            {image type="avatar" alt="Avatar #{$ava.name}" class="rounded shadow img-fit-cover img-responsive" src="{$tsCarpeta}/{$ava.img}"}
	         </a>
	      {/foreach}
	      </div>
	      <div id="type-selection"></div>
	   </div>
	</div>
</div>