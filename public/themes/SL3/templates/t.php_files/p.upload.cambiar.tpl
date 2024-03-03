<div class="row">
   <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 avatar-cambiar">
      <div onclick="avatar.accion.tipo('pc'); return false" class="box-type type-pc bg-info d-flex flex-column justify-content-center align-items-center"><iconify-icon icon="la:desktop"></iconify-icon> <span>Desde PC</span></div>
      <div onclick="avatar.accion.tipo('url'); return false" class="box-type type-url bg-primary d-flex flex-column justify-content-center align-items-center"><iconify-icon icon="la:link"></iconify-icon> <span>Desde URL</span></div>
   </div>
   <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
      <div class="grid-avatares-ajax">
      {foreach $tsAvatares item=ava}
         <a class="avatar" href="javascript:avatar.accion.seleccionar({$tsUser->uid}, {$ava.name})">
            <img src="{$tsConfig.images}/loadImage.gif" 
            data-src="{$tsCarpeta}/{$ava.img}" 
            alt="Avatar #{$ava.name}" 
            class="rounded shadow images">
         </a>
      {/foreach}
      </div>
      <div id="type-selection"></div>
   </div>
</div>
{jsdelivr type='scripts' sources=['feather-icons','vanilla-lazyload'] combine=true}
<style>
.grid-avatares-ajax {
   display: grid;
   grid-template-columns: repeat(4, 1fr);
   gap: .6rem;
}
.box-type {
   margin-bottom: 0.4rem;
   padding: 1rem 0;
   color: var(--bs-body-bg);
   border-radius: 0.4rem;
}
.grid-avatares-ajax {
   gap: .3rem;
}
.grid-avatares-ajax a {
   display: inline-block;
   height: 120px;
   width: 120px;
}
.grid-avatares-ajax a img {
   width: 100%;
   height: 100%;
   object-fit: cover;
}
</style>
<script>
   feather.replace();

   var myLazyLoad = new LazyLoad({
      elements_selector: '.images',
      use_native: true,
      class_loading: 'lazy-loading'
   })
   myLazyLoad.update();
   
</script>