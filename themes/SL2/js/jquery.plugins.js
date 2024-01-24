const SL2 = {
   start: () => Pace.start(),
   stop: () => Pace.stop(),
   restart: () => Pace.restart(),
   done: () => Pace.done(),
   hide: () => Pace.hide()
}
/**
 * Plugins globales que utilizará el script.
 * Los plugins: (fueron obtenidos desde https://locutus.io/php/)
 *  # Empty 
 *  # Htmlspecialchars_decode 
 *  # Number_format 
 *  # Base64_encode
 *  # Rawurlencode
*/
empty = n => {let e,r,t;const f=[undefined,null,!1,0,"","0"];for(r=0,t=f.length;r<t;r++)if(n===f[r])return!0;if("object"==typeof n){for(e in n)if(n.hasOwnProperty(e))return!1;return!0}return!1}
htmlspecialchars_decode = (e,E) => {let T=0,_=0,t=!1;void 0===E&&(E=2),e=e.toString().replace(/&lt;/g,"<").replace(/&gt;/g,">");const c={ENT_NOQUOTES:0,ENT_HTML_QUOTE_SINGLE:1,ENT_HTML_QUOTE_DOUBLE:2,ENT_COMPAT:2,ENT_QUOTES:3,ENT_IGNORE:4};if(0===E&&(t=!0),"number"!=typeof E){for(E=[].concat(E),_=0;_<E.length;_++)0===c[E[_]]?t=!0:c[E[_]]&&(T|=c[E[_]]);E=T}return E&c.ENT_HTML_QUOTE_SINGLE&&(e=e.replace(/&#0*39;/g,"'")),t||(e=e.replace(/&quot;/g,'"')),e=e.replace(/&amp;/g,"&")}
number_format = (e,t,n,i) => {e=(e+"").replace(/[^0-9+\-Ee.]/g,"");const r=isFinite(+e)?+e:0,o=isFinite(+t)?Math.abs(t):0,a=void 0===i?",":i,d=void 0===n?".":n;let l="";return l=(o?function(e,t){if(-1===(""+e).indexOf("e"))return+(Math.round(e+"e+"+t)+"e-"+t);{const n=(""+e).split("e");let i="";return+n[1]+t>0&&(i="+"),(+(Math.round(+n[0]+"e"+i+(+n[1]+t))+"e-"+t)).toFixed(t)}}(r,o).toString():""+Math.round(r)).split("."),l[0].length>3&&(l[0]=l[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,a)),(l[1]||"").length<o&&(l[1]=l[1]||"",l[1]+=new Array(o-l[1].length+1).join("0")),l.join(d)}
base64_encode = a => {const b=function(a){return encodeURIComponent(a).replace(/%([0-9A-F]{2})/g,function(a,b){return String.fromCharCode("0x"+b)})};if(!("undefined"!=typeof window))return new Buffer(a).toString("base64");else if("undefined"!=typeof window.btoa)return window.btoa(b(a));const c="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";let d,e,f,g,h,j,k,l,m=0,n=0,o="";const p=[];if(!a)return a;a=b(a);do d=a.charCodeAt(m++),e=a.charCodeAt(m++),f=a.charCodeAt(m++),l=d<<16|e<<8|f,g=63&l>>18,h=63&l>>12,j=63&l>>6,k=63&l,p[n++]=c.charAt(g)+c.charAt(h)+c.charAt(j)+c.charAt(k);while(m<a.length);o=p.join("");const q=a.length%3;return(q?o.slice(0,q-3):o)+"===".slice(q||3)}
rawurlencode = str => encodeURIComponent(str).replace(/!/g,'%21').replace(/'/g,'%27').replace(/\(/g,'%28').replace(/\)/g,'%29').replace(/\*/g,'%2A')

isYoutube = linkVideo =>{ 
	var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/; 
	var match = linkVideo.match(regExp); 
	return (match && match[7].length === 11) ? match[7] : false;
}
/**
 * A lightweight youtube embed. 
 * Still should feel the same to the user, just MUCH faster to initialize and paint.
 *
 * Thx to these as the inspiration
 *   https://storage.googleapis.com/amp-vs-non-amp/youtube-lazy.html
 *   https://autoplay-youtube-player.glitch.me/
 *
 * Once built it, I also found these:
 *   https://github.com/ampproject/amphtml/blob/master/extensions/amp-youtube (👍👍)
 *   https://github.com/Daugilas/lazyYT
 *   https://github.com/vb/lazyframe
*/
class LiteYTEmbed extends HTMLElement {
   connectedCallback() {
      this.videoId = this.getAttribute('videoid');
      
      // A label for the button takes priority over a [playlabel] attribute on the custom-element
      if (!this.style.backgroundImage) {
        this.style.backgroundImage = `url("https://i.ytimg.com/vi/${this.videoId}/maxresdefault.jpg")`;
      }
      // Añadimos el logo del sitio
      let logosite = this.querySelector('.logo-site');
      logosite = document.createElement('img');
      logosite.src = global_data.url + '/files/SyntaxisLite-ico-32.png';
      logosite.alt = global_data.s_title;
      logosite.classList.add('lty-logosite');
      this.append(logosite);

      this.addEventListener('pointerover', LiteYTEmbed.warmConnections, {once: true});
      this.addEventListener('click', this.addIframe);
  	}
  	static addPrefetch(kind, url, as) {
      const linkEl = document.createElement('link');
      linkEl.rel = kind;
      linkEl.href = url;
      if (as) linkEl.as = as;
      document.head.append(linkEl);
   }

   static warmConnections() {
      if (LiteYTEmbed.preconnected) return;
      LiteYTEmbed.addPrefetch('preconnect', 'https://www.youtube-nocookie.com');
      LiteYTEmbed.addPrefetch('preconnect', 'https://www.google.com');
      LiteYTEmbed.addPrefetch('preconnect', 'https://googleads.g.doubleclick.net');
      LiteYTEmbed.addPrefetch('preconnect', 'https://static.doubleclick.net');
      LiteYTEmbed.preconnected = false;
   }
   addIframe(e) {
      if (this.classList.contains('lyt-activated')) return;
      e.preventDefault();
      this.classList.add('lyt-activated');
      //
      const params = new URLSearchParams(this.getAttribute('params') || []);
      params.append('autoplay', '1');
      //
      const iframeEl = document.createElement('iframe');
      iframeEl.width = 560 - 60;
      iframeEl.height = 315 - 60;
      // No encoding necessary as [title] is safe. https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html#:~:text=Safe%20HTML%20Attributes%20include
      iframeEl.title = this.playLabel;
      iframeEl.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
      iframeEl.allowFullscreen = true;
      // https://stackoverflow.com/q/64959723/89484
      iframeEl.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(this.videoId)}?${params.toString()}`;
      this.append(iframeEl);

      // Set focus for a11y
      iframeEl.focus();
   }
}
// Register custom element
customElements.define('lite-youtube', LiteYTEmbed);

// Redireccionar
function obtenerParametroDeURL(nombreParametro) {
   var url = window.location.href;
   nombreParametro = nombreParametro.replace(/[\[\]]/g, "\\$&");
   var regex = new RegExp("[?&]" + nombreParametro + "(=([^&#]*)|&|#|$)"),
       resultados = regex.exec(url);
   if (!resultados) return null;
   if (!resultados[2]) return '';
   return resultados[2];
}

/**
 * MyDialog v2
 * @autor Miguel92
*/
var mydialog = {
   is_show: false,
   class_aux: '',
   size: 'normal', // small | normal | big
   mask_close: true,
   close_button: false,
   template: `<div id="dialog">
      <div id="header_dialog">
         <div id="title"></div>
         <div id="close"></div>
      </div>
      <div id="cuerpo">
         <div id="procesando">
            <div id="mensaje"></div>
         </div>
         <div id="modalBody"></div>
      </div>
      <div id="buttons"></div>
   </div>`,
   show: function(activeClass){
      if(this.is_show) return;
      else this.is_show = true;
      if($('#mydialog').html() == '') $('#mydialog').show().html(this.template);
      $('footer').after('<div id="mask"></div>')
      // Para los tamaños del modal
      $('#mydialog').addClass(this.size);
      // Añadimos clase auxiliar si existe
      if(activeClass) $('#mydialog').addClass(this.class_aux);
      else if(this.class_aux != ''){
         $('#mydialog').removeClass(this.class_aux);
         this.class_aux = '';
      }
      // Cerramos modal con la mascará
      if(this.mask_close) $('#mask').on('click', () => mydialog.close());
      // Añadimos el botón para cerrar el modal
      if(this.close_button)
         $('#mydialog #dialog #close').html('<span onclick="mydialog.close()" class="close_dialog">&times;</span>');

      $('#mydialog #dialog').css('position', 'absolute');
      $('#mydialog #dialog').fadeIn('fast');
      $(window).on('resize', mydialog.center);
   },
   close: function(){
      //Vuelve todos los parametros por default
      this.class_aux = '';
      this.mask_close = true;
      this.close_button = false;
      this.size = 'normal';

      this.is_show = false;
      $('#mask').remove();
      $('#mydialog #dialog').fadeOut('fast', () => $(this).remove());
      this.procesando_fin();
   },
   center: function() {
      let diaghei = ($('#mydialog #dialog').height() > $(window).height()-60);
      let ubicacion = $(window).height() / 2 - $('#mydialog #dialog').height() / 2;
      $('#mydialog #dialog').css({
         'position': (diaghei ? 'absolute' : 'fixed'), 
         'top': (diaghei ? 20 : ubicacion),
         'left': $(window).width()/2-$('#mydialog #dialog').width()/2
      });
   },
   title: title => $('#mydialog #title').html(title),
   body: body => $('#mydialog #cuerpo #modalBody').html(body),
   buttons: (...args) => {
      if(args.length === 1) {
         $('#mydialog #buttons').hide();
         return;
      }
      const obj = {
         ok:{action:args[3], text:args[2], active:args[1], focus:args[5]},
         fail:{action:args[8], text:args[7], active:args[6], focus:args[10]} 
      };
      if(args.length <= 7) delete obj.fail;
      mydialog.buttons_action(args[0], obj);
   },
   buttons_action: (remBtn, dataObject) => { 
      var is_html = ''; 
      if(!dataObject.ok && !dataObject.fail && remBtn) $('#mydialog #buttons').hide()
      // Si existe "OK"
      if(dataObject.ok) {
         // Si tiene accion definido
         if(dataObject.ok.action === 'close' || !dataObject.ok.action) dataObject.ok.action = 'mydialog.close()';
         let classdisabled = dataObject.ok.active ? '' : ' disabled';
         is_html += `<input type="button" class="btn btn-success mBtn btnOk${classdisabled}" style="display:inline-block!important;" onclick="${dataObject.ok.action}" value="${dataObject.ok.text}"${classdisabled} />`;
      }
      // Si existe "fail"
      if(dataObject.fail) {
         // Si tiene accion definido
         if(dataObject.fail.action === 'close' || !dataObject.fail.action) dataObject.ok.action = 'mydialog.close()';
         let classdisabled = dataObject.fail.active ? '' : ' disabled';
         is_html += `<input type="button" class="btn btn-danger mBtn btnCancel${classdisabled}" style="display:inline-block!important;" onclick="${dataObject.ok.action}" value="${dataObject.fail.text}"${classdisabled} />`;
      }
      // Por que si se ejecuta 2 veces y el 1ro tiene mydialog.buttons(false)
      // El 2do ya no se visualizará ya que no existe en el DOM #buttons
      $('#mydialog #buttons').show().html(is_html)
      
      if(!dataObject.ok && !dataObject.fail) {
         if(dataObject.ok.focus) $('#mydialog #buttons .mBtn.btnOk').focus();
         else if(dataObject.fail.focus) $('#mydialog #buttons .mBtn.btnCancel').focus();
      }
   },
   alert: function(title, body, reload){
      this.show();
      this.title(title);
      this.body(body);
      this.buttons(true, true, 'Aceptar', 'mydialog.close();' + (reload ? 'location.reload();' : 'close'), true, true, false);
      this.center();
   },
   error_500: function(fun_reintentar){
      setTimeout(function(){
         mydialog.procesando_fin();
         mydialog.show();
         mydialog.title('Error');
         mydialog.body('Error al intentar procesar lo solicitado');
         mydialog.buttons(true, true, 'Reintentar', 'mydialog.close();'+fun_reintentar, true, true, true, 'Cancelar', 'close', true, false);
         mydialog.center();
      }, 200);
   },
   procesando_inicio: function(value, title){
      if(!this.is_show){
         this.show();
         this.title(title);
         this.body('');
         this.buttons(false, false);
         this.center();
      }
      $('#mydialog #procesando #mensaje').html('<img src="'+global_data.img+'/loading_bar.gif" />');
      $('#mydialog #procesando').fadeIn('fast');
   },
   procesando_fin: function(){
      $('#mydialog #procesando').fadeOut('fast');
   },
   faster: obj => {
      if(!empty(obj.class_aux)) mydialog.class_aux = obj.addClass;
      if(obj.close_button) mydialog.close_button = obj.close_button;
      if(obj.mask_button) mydialog.mask_button = obj.mask_button;
      if(obj.size) mydialog.size = obj.size; // small | normal | big
      mydialog.show(true);
      mydialog.title(obj.title);
      mydialog.body(obj.body);
      if(typeof obj.buttons === 'boolean') {
         mydialog.buttons(false)
      } else if(obj.buttons.fail !== undefined) {
         mydialog.buttons(true, true, obj.buttons.ok.text, obj.buttons.ok.action, true, true, true, obj.buttons.fail.text, obj.buttons.fail.action, true, false);
      } else {
         mydialog.buttons(true, true, obj.buttons.ok.text, obj.buttons.ok.action, true, true, false);
      }
      mydialog.center();
   }

};
document.onkeydown = function(e) {
   key = (e == null) ? event.keyCode : e.which;
   if (key == 27) //escape, close mydialog
      mydialog.close();
};