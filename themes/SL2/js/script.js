//
(() => {
  	"use strict";

   /* SCROLL */
   const loaderNavegationFixed = () => {
      // Le cambiamos las clases al menu
      if ($(window).scrollTop() >= 185) {
         $(".navbar.navbar-expand-lg").addClass('sticky-top');
         $('.navbar-brand').fadeIn(300);
      } else {
         $(".navbar.navbar-expand-lg").removeClass('sticky-top');
         $('.navbar-brand').fadeOut(300);
      }
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
      const listTooltip = document.querySelectorAll('[data-bs-toggle="tooltip"]')
      const tooltipList = [...listTooltip].map(element => new bootstrap.Tooltip(element))
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

function modechange() {
   if(global_data.user_key > 0) {
      let htmlElement = document.documentElement; // Obtener el elemento html
      let currentMode = htmlElement.dataset.bsTheme;
      let mode = (currentMode === 'dark') ? 'light' : 'dark';
      htmlElement.dataset.bsTheme = mode;
      const uid = global_data.user_key;
      $("#mode_change").html((mode === 'dark' ? 'light' : 'dark'))
      $.post(global_data.url + '/settings-mode.php', { mode, uid }, res => console.log(res));
   }
}

$(document).on('keydown', event => {
   if (event.key === 'M' && event.shiftKey) modechange();
   if (event.key === '/' && event.code === 'NumpadDivide') {
      event.preventDefault();
      $('input[type=search].search_menu').focus();
   }
});

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