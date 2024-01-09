var Miguel92 = {},
DoneProfile = localStorage.getItem('TourPefil');
(function($){
  	"use strict";

   const $window = $(window);
   const $document = $(document);

   /* SCROLL */
  const loaderFadeLogo = () => {
      // Le cambiamos las clases al menu
      if ($window.scrollTop() > 265) $("nav").removeClass('navbar-pill').addClass('navbar-pill-off');
      else $("nav").removeClass('navbar-pill-off').addClass('navbar-pill');
   }

   /* DOCUMENT READY */
   const loaderFatherIcons = () => {
      // Constante de 2 opciones "clase" y "stroke"
      const $klass = 'featherIcons', $stroke_w = 1.5
      // le incorporamos a los SVG
      feather.replace({ 
         class: $klass, 
         'stroke-width': $stroke_w 
      });
   }
  	const loaderTipsy = () => {
      // Buscamos el objeto o enlace
   	var $link = $('a[title]');
      // Le aplicamos los atributos necesarios
   	$link.tipsy({fade: true, html: true, gravity: $.fn.tipsy.autoNS});
   }
   const loaderLazy = () => {
      var LazyLoadClass = ['.image', '.background', '.iframe']
      LazyLoadClass.map( lazyload => {
         let NewOptions = {
            elements_selector: lazyload,
            use_native: true,
            class_loading: 'lazy-loading'
         }
         if(lazyload === '.background') {
            // Agregamos
            NewOptions = Object.assign(NewOptions, {class_loaded: 'lazy-loaded'})
            // Quitamos -> use_native: true
            delete NewOptions.use_native
         }
         new LazyLoad(NewOptions)
      });
   }
	const loaderScrollToTop = () => {  
	 	$('.subir').on('click', () => $('body, html').animate({scrollTop: '40px'}, 1000));
  	}

   // Window scroll functions
   $window.on('scroll', () => loaderFadeLogo());
 	// Document ready functions
   $document.ready(() => {
     loaderFatherIcons(),
     loaderLazy(),
     loaderTipsy(),
     loaderScrollToTop();
	});

})(jQuery);


if(global_data.logueado === 'si' && global_data.page === 'perfil') {
   const driver = window.driver.js.driver;
   const iniciarPaseo = driver({
      showProgress: true,
      nextBtnText: 'Siguiente ›',
      prevBtnText: '‹ Anterior',
      doneBtnText: 'Hecho',
      steps: [
         {
            element: '#cambiar-portada',
            popover: {
               title: 'Cambiar Portada',
               description: 'Con este botón podrás cambiar la portada de tu perfil y usar la imagen que más te guste!',
               position: 'left',
            }
         }, {
            element: '#cambiar-foto',
            popover: {
               title: 'Cambiar Avatar',
               description: 'Haciendo clic sobre la imagen, vas a poder cambiar tu avatar o seleccionar una ya predefinida por ' + global_data.s_title,
               position: 'bottom'
            }
         }, {
            element: '#publicar',
            popover: {
               title: 'Publicar contenido',
               description: 'Acá puedes compartir un estado, foto, enlace o un video con todos tus seguidores y ellos también te podrán publicar en tu muro.',
               position: 'top'
            },
         }
      ]
   });

   localStorage.setItem('TourPefil', 'c');
   // Start the introduction
   if (DoneProfile != 'completo') iniciarPaseo.drive();
}