//
(() => {
  	"use strict";

   /* SCROLL */
   const loaderNavegationFixed = () => {
      // Le cambiamos las clases al menu
      if ($(window).scrollTop() > 265) $(".navegation").addClass('scrolling');
      else $(".navegation").removeClass('scrolling');
   }

   /* DOCUMENT READY */
   const loaderFatherIcons = () => {
      // le incorporamos a los SVG
      feather.replace({ 
         class: 'featherIcons', 'stroke-width': 1.5 
      });
   }
  	const loaderTipsy = () => {
      // Le aplicamos los atributos necesarios
   	$('a[title]').tipsy({fade: true, html: true, gravity: $.fn.tipsy.autoNS});
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

   $(window).on('scroll', () => loaderNavegationFixed());

   loaderFatherIcons();
   loaderLazy();
   loaderTipsy();
   loaderScrollToTop();
	
})();

const ProfileComplete = localStorage.getItem('TourPefil');
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

   localStorage.setItem('TourPefil', 'completo');
   // Start the introduction
   if (ProfileComplete != 'completo') iniciarPaseo.drive();
}