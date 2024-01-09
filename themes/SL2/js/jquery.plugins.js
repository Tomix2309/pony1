/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-applicationcache-backdropfilter-setclasses !*/
!function(n,e,o){var a=[],s={_version:"3.6.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(n,e){var o=this;setTimeout(function(){e(o[n])},0)},addTest:function(n,e,o){a.push({name:n,fn:e,options:o})},addAsyncTest:function(n){a.push({name:null,fn:n})}},Modernizr=function(){};Modernizr.prototype=s,Modernizr=new Modernizr,Modernizr.addTest("applicationcache","applicationCache"in n);var t=e.documentElement;"svg"===t.nodeName.toLowerCase()}(window,document);

/**
 * Plugins globales que utilizará el script.
 * Los plugins: (fueron obtenidos desde https://locutus.io/php/)
 *  # Empty 
 *  # Htmlspecialchars_decode 
 *  # Number_format 
 *  # Base64_encode
*/
empty = n => {let e,r,t;const f=[undefined,null,!1,0,"","0"];for(r=0,t=f.length;r<t;r++)if(n===f[r])return!0;if("object"==typeof n){for(e in n)if(n.hasOwnProperty(e))return!1;return!0}return!1}
htmlspecialchars_decode = (e,E) => {let T=0,_=0,t=!1;void 0===E&&(E=2),e=e.toString().replace(/&lt;/g,"<").replace(/&gt;/g,">");const c={ENT_NOQUOTES:0,ENT_HTML_QUOTE_SINGLE:1,ENT_HTML_QUOTE_DOUBLE:2,ENT_COMPAT:2,ENT_QUOTES:3,ENT_IGNORE:4};if(0===E&&(t=!0),"number"!=typeof E){for(E=[].concat(E),_=0;_<E.length;_++)0===c[E[_]]?t=!0:c[E[_]]&&(T|=c[E[_]]);E=T}return E&c.ENT_HTML_QUOTE_SINGLE&&(e=e.replace(/&#0*39;/g,"'")),t||(e=e.replace(/&quot;/g,'"')),e=e.replace(/&amp;/g,"&")}
number_format = (e,t,n,i) => {e=(e+"").replace(/[^0-9+\-Ee.]/g,"");const r=isFinite(+e)?+e:0,o=isFinite(+t)?Math.abs(t):0,a=void 0===i?",":i,d=void 0===n?".":n;let l="";return l=(o?function(e,t){if(-1===(""+e).indexOf("e"))return+(Math.round(e+"e+"+t)+"e-"+t);{const n=(""+e).split("e");let i="";return+n[1]+t>0&&(i="+"),(+(Math.round(+n[0]+"e"+i+(+n[1]+t))+"e-"+t)).toFixed(t)}}(r,o).toString():""+Math.round(r)).split("."),l[0].length>3&&(l[0]=l[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,a)),(l[1]||"").length<o&&(l[1]=l[1]||"",l[1]+=new Array(o-l[1].length+1).join("0")),l.join(d)}
base64_encode = a => {const b=function(a){return encodeURIComponent(a).replace(/%([0-9A-F]{2})/g,function(a,b){return String.fromCharCode("0x"+b)})};if(!("undefined"!=typeof window))return new Buffer(a).toString("base64");else if("undefined"!=typeof window.btoa)return window.btoa(b(a));const c="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";let d,e,f,g,h,j,k,l,m=0,n=0,o="";const p=[];if(!a)return a;a=b(a);do d=a.charCodeAt(m++),e=a.charCodeAt(m++),f=a.charCodeAt(m++),l=d<<16|e<<8|f,g=63&l>>18,h=63&l>>12,j=63&l>>6,k=63&l,p[n++]=c.charAt(g)+c.charAt(h)+c.charAt(j)+c.charAt(k);while(m<a.length);o=p.join("");const q=a.length%3;return(q?o.slice(0,q-3):o)+"===".slice(q||3)}
rawurlencode = str => encodeURIComponent(str).replace(/!/g,'%21').replace(/'/g,'%27').replace(/\(/g,'%28').replace(/\)/g,'%29').replace(/\*/g,'%2A')

/* Tipsy */
!function(t,e,i){function s(t,e){return"function"==typeof t?t.call(e):t}function o(t){for(;t=t.parentNode;)if(t==document)return!0;return!1}function n(t){return"object"==typeof HTMLElement?t instanceof HTMLElement:t&&"object"==typeof t&&1===t.nodeType&&"string"==typeof t.nodeName}function l(){return"tipsyuid"+h++}function a(e,i){this.$element=t(e),this.options=i,this.enabled=!0,this.fixTitle()}var h=0;a.prototype={show:function(){if(o(this.$element[0])&&(!n(this.$element)||this.$element.is(":visible"))){var e;if(this.enabled&&(e=this.getTitle())){var i=this.tip();i.find(".tipsy-inner"+this.options.theme)[this.options.html?"html":"text"](e),i[0].className="tipsy"+this.options.theme,this.options.className&&i.addClass(s(this.options.className,this.$element[0])),i.remove().css({top:0,left:0,visibility:"hidden",display:"block"}).prependTo(document.body);var a=t.extend({},this.$element.offset());a=this.$element.parents("svg").length>0?t.extend(a,this.$element[0].getBBox()):t.extend(a,{width:this.$element[0].offsetWidth||0,height:this.$element[0].offsetHeight||0});var h,f=i[0].offsetWidth,r=i[0].offsetHeight,p=s(this.options.gravity,this.$element[0]);switch(p.charAt(0)){case"n":h={top:a.top+a.height+this.options.offset,left:a.left+a.width/2-f/2};break;case"s":h={top:a.top-r-this.options.offset,left:a.left+a.width/2-f/2};break;case"e":h={top:a.top+a.height/2-r/2,left:a.left-f-this.options.offset};break;case"w":h={top:a.top+a.height/2-r/2,left:a.left+a.width+this.options.offset}}if(2==p.length&&("w"==p.charAt(1)?h.left=a.left+a.width/2-15:h.left=a.left+a.width/2-f+15),i.css(h).addClass("tipsy-"+p+this.options.theme),i.find(".tipsy-arrow"+this.options.theme)[0].className="tipsy-arrow"+this.options.theme+" tipsy-arrow-"+p.charAt(0)+this.options.theme,this.options.fade?(this.options.shadow&&t(".tipsy-inner").css({"box-shadow":"0px 0px "+this.options.shadowBlur+"px "+this.options.shadowSpread+"px rgba(0, 0, 0, "+this.options.shadowOpacity+")","-webkit-box-shadow":"0px 0px "+this.options.shadowBlur+"px "+this.options.shadowSpread+"px rgba(0, 0, 0, "+this.options.shadowOpacity+")"}),i.stop().css({opacity:0,display:"block",visibility:"visible"}).animate({opacity:this.options.opacity},this.options.fadeInTime)):i.css({visibility:"visible",opacity:this.options.opacity}),this.options.aria){var d=l();i.attr("id",d),this.$element.attr("aria-describedby",d)}}}},hide:function(){this.options.fade?this.tip().stop().fadeOut(this.options.fadeOutTime,function(){t(this).remove()}):this.tip().remove(),this.options.aria&&this.$element.removeAttr("aria-describedby")},fixTitle:function(){var t=this.$element,e=s(this.options.id,this.$element[0]);(t.prop("title")||"string"!=typeof t.prop("original-title"))&&(t.prop("original-title",t.prop("title")||"").removeAttr("title"),t.attr("aria-describedby",e),t.attr("tabindex")===i&&t.attr("tabindex",0))},getTitle:function(){var t,e=this.$element,i=this.options;return this.fixTitle(),"string"==typeof i.title?t=e.prop("title"==i.title?"original-title":i.title):"function"==typeof i.title&&(t=i.title.call(e[0])),t=(""+t).replace(/(^\s*|\s*$)/,""),t||i.fallback},tip:function(){var e=s(this.options.id,this.$element[0]);return this.$tip||(this.$tip=t('<div class="tipsy'+this.options.theme+'" id="'+e+'" role="tooltip"></div>').html('<div class="tipsy-arrow'+this.options.theme+'"></div><div class="tipsy-inner'+this.options.theme+'"></div>').attr("role","tooltip"),this.$tip.data("tipsy-pointee",this.$element[0])),this.$tip},validate:function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},enable:function(){this.enabled=!0},disable:function(){this.enabled=!1},toggleEnabled:function(){this.enabled=!this.enabled}},t.fn.tipsy=function(e){function i(i){var s=t.data(i,"tipsy");return s||(s=new a(i,t.fn.tipsy.elementOptions(i,e)),t.data(i,"tipsy",s)),s}function s(){if(t.fn.tipsy.enabled===!0){var s=i(this);s.hoverState="in",0===e.delayIn?s.show():(s.fixTitle(),setTimeout(function(){"in"==s.hoverState&&o(s.$element)&&s.show()},e.delayIn))}}function n(){var t=i(this);t.hoverState="out",0===e.delayOut?t.hide():setTimeout(function(){"out"!=t.hoverState&&t.$element&&t.$element.is(":visible")||t.hide()},e.delayOut)}if(t.fn.tipsy.enable(),e===!0)return this.data("tipsy");if("string"==typeof e){var l=this.data("tipsy");return l&&l[e](),this}if(e=t.extend({},t.fn.tipsy.defaults,e),e.theme=e.theme&&""!==e.theme?"-"+e.theme:"",e.on||this.each(function(){i(this)}),"manual"!=e.trigger)if(e.on&&e.on!==!0)"focus"!=e.trigger&&(t(this).on("mouseenter",e.on,s),t(this).on("mouseleave",e.on,n)),"blur"!=e.trigger&&(t(this).on("focus",e.on,s),t(this).on("blur",e.on,n));else{if(e.on&&!t.on)throw"Since jQuery 1.9, pass selector as live argument. eg. $(document).tipsy({live: 'a.live'});";var h=e.on?"live":"bind";"focus"!=e.trigger&&this[h]("mouseenter",s)[h]("mouseleave",n),"blur"!=e.trigger&&this[h]("focus",s)[h]("blur",n)}return this},t.fn.tipsy.defaults={aria:!1,className:null,id:"tipsy",delayIn:0,delayOut:0,fade:!1,fadeInTime:400,fadeOutTime:400,shadow:!1,shadowBlur:8,shadowOpacity:1,shadowSpread:0,fallback:"",gravity:"n",html:!1,live:!1,offset:0,opacity:.8,title:"title",trigger:"interactive",theme:""},t.fn.tipsy.revalidate=function(){t(".tipsy").each(function(){var e=t.data(this,"tipsy-pointee");e&&o(e)||t(this).remove()})},t.fn.tipsy.enable=function(){t.fn.tipsy.enabled=!0},t.fn.tipsy.disable=function(){t.fn.tipsy.enabled=!1},t.fn.tipsy.elementOptions=function(e,i){return t.metadata?t.extend({},i,t(e).metadata()):i},t.fn.tipsy.autoNS=function(){return t(this).offset().top>t(document).scrollTop()+t(e).height()/2?"s":"n"},t.fn.tipsy.autoWE=function(){return t(this).offset().left>t(document).scrollLeft()+t(e).width()/2?"e":"w"},t.fn.tipsy.autoNWNE=function(){return t(this).offset().left>t(document).scrollLeft()+t(e).width()/2?"ne":"nw"},t.fn.tipsy.autoSWSE=function(){return t(this).offset().left>t(document).scrollLeft()+t(e).width()/2?"se":"sw"},t.fn.tipsy.autoBounds=function(i,s,o){return function(){var n={ns:o[0],ew:o.length>1?o[1]:!1},l=t(document).scrollTop()+i,a=t(document).scrollLeft()+s,h=t(this);return h.offset().top<l&&(n.ns="n"),h.offset().left<a&&(n.ew="w"),t(e).width()+t(document).scrollLeft()-h.offset().left<s&&(n.ew="e"),t(e).height()+t(document).scrollTop()-h.offset().top<i&&(n.ns="s"),n.ns+(n.ew?n.ew:"")}},t.fn.tipsy.autoBounds2=function(i,s){return function(){var o={},n=t(document).scrollTop()+i,l=t(document).scrollLeft()+i,a=t(this);return s.length>1?(o.ns=s[0],o.ew=s[1]):"e"==s[0]||"w"==s[0]?o.ew=s[0]:o.ns=s[0],a.offset().top<n&&(o.ns="n"),a.offset().left<l&&(o.ew="w"),t(e).width()+t(document).scrollLeft()-(a.offset().left+a.width())<i&&(o.ew="e"),t(e).height()+t(document).scrollTop()-(a.offset().top+a.height())<i&&(o.ns="s"),o.ns?o.ns+(o.ew?o.ew:""):o.ew}}}(jQuery,window);

isYoutube = linkVideo =>{ 
	var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/; 
	var match = linkVideo.match(regExp); 
	return (match && match[7].length === 11) ? match[7] : false;
}
/**
 * A lightweight youtube embed. Still should feel the same to the user, just MUCH faster to initialize and paint.
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
      let playBtnEl = this.querySelector('.lty-playbtn');
      // A label for the button takes priority over a [playlabel] attribute on the custom-element
      this.playLabel = (playBtnEl && playBtnEl.textContent.trim()) || this.getAttribute('playlabel') || 'Play';
      if (!this.style.backgroundImage) {
        this.style.backgroundImage = `url("https://i.ytimg.com/vi/${this.videoId}/maxresdefault.jpg")`;
      }
      if (!playBtnEl) {
         playBtnEl = document.createElement('button');
         playBtnEl.type = 'button';
         playBtnEl.classList.add('lty-playbtn');
         this.append(playBtnEl);
      }
      if (!playBtnEl.textContent) {
         const playBtnLabelEl = document.createElement('span');
         playBtnLabelEl.className = 'lyt-visually-hidden';
         playBtnLabelEl.textContent = this.playLabel;
         playBtnEl.append(playBtnLabelEl);
      }
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