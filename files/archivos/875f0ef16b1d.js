/* Imgur Upload Script */
(function (root, factory) {
   "use strict";
   if (typeof define === 'function' && define.amd) define([], factory);
   else if (typeof exports === 'object') module.exports = factory();
   else root.Imgur = factory();
}(this, function () {
   "use strict";
   var dropzoneClass = '.dropzone',
   info = '.PsychoLinfo',
   infoText = 'Arrastre el archivo aquí o haga clic para seleccionar una imagen',
   inputClass = 'input_class';
   var Imgur = options => {
      if (!this || !(this instanceof Imgur)) return new Imgur(options);
      if (!options) options = {};
      if (!options.clientid) throw 'Provide a valid Client Id here: https://api.imgur.com/';
      this.clientid = options.clientid;
      this.endpoint = 'https://api.imgur.com/3/image';
      this.callback = options.callback || undefined;
      this.dropzone = document.querySelectorAll(dropzoneClass);
      this.info = document.querySelectorAll(info);
      this.run();
   };
   Imgur.prototype = {
      createEls: (name, props, text) => {
         var el = document.createElement(name), p;
         for (p in props) {
            if (props.hasOwnProperty(p)) el[p] = props[p];
         }
         if (text) el.appendChild(document.createTextNode(text));
         return el;
      },
      insertAfter: (referenceNode, newNode) => {
         referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
      },
      post: (path, data, callback) => {
         var xhttp = new XMLHttpRequest();
         xhttp.open('POST', path, true);
         xhttp.setRequestHeader('Authorization', 'Client-ID ' + this.clientid);
         xhttp.onreadystatechange = () => {
            if (this.readyState === 4) {
               if (this.status >= 200 && this.status < 300) {
                  var response = '';
                  try {
                     response = JSON.parse(this.responseText);
                  } catch (err) {
                     response = this.responseText;
                  }
                  callback.call(window, response);
               } else throw new Error(this.status + " - " + this.statusText);
            }
         };
         xhttp.send(data);
         xhttp = null;
      },
      createDragZone: () => {
         var p1, input;
         p1 = this.createEls('p', {}, infoText);
         input = this.createEls('input', {type: 'file', className: inputClass, accept: 'image/*'});
         Array.prototype.forEach.call(this.info, zone => {
            zone.appendChild(p1);
         }.on(this));
         Array.prototype.forEach.call(this.dropzone, zone => {
            zone.appendChild(input);
            this.status(zone);
            this.upload(zone);
         }.on(this));
      },
      loading: () => {
         var div, table, img;
         div = this.createEls('div', {className: 'loading-modal'});
         table = this.createEls('table', {className: 'loading-table'});
         img = this.createEls('img', {className: 'loading-image', src: global_data.img + 'images/loading-spin.svg'});
         div.appendChild(table);
         table.appendChild(img);
         document.body.appendChild(div);
      },
      status: el => this.insertAfter(el, this.createEls('div', {className: 'estado'})),
      matchFiles: (file, zone) => {
         var status = zone.nextSibling;
         if (file.type.match(/image/) && file.type !== 'image/svg+xml') {
            document.body.classList.add('loading');
            status.classList.remove('success', 'danger');
            status.innerHTML = '';
            var fd = new FormData();
            fd.append('image', file);
            this.post(this.endpoint, fd, data => {
               document.body.classList.remove('loading');
               typeof this.callback === 'function' && this.callback.call(this, data);
            }.on(this));
         } else {
            status.classList.remove('success');
            status.classList.add('danger');
            status.innerHTML = 'Invalid archive';
         }
      },
      upload: zone => {
         var events = ['dragenter', 'dragleave', 'dragover', 'drop'], file, target, i, len;
         zone.addEventListener('change', e => {
            if (e.target && e.target.nodeName === 'INPUT' && e.target.type === 'file') {
               target = e.target.files;
               for (i = 0, len = target.length; i < len; i += 1) {
                  file = target[i];
                  this.matchFiles(file, zone);
               }
               document.querySelector('.loading-modal').classList.add('show');
            }
         }.on(this), false);
         events.map(event => {
            zone.addEventListener(event, e => {
               if (e.target && e.target.nodeName === 'INPUT' && e.target.type === 'file') {
                  if (event === 'dragleave' || event === 'drop') {
                     e.target.parentNode.classList.remove('dropzone-dragging');
                  } else {
                     e.target.parentNode.classList.add('dropzone-dragging');
                  }
               }
            }, false);
         });
      },
      run: () => {
         var loadingModal = document.querySelector('.loading-modal');
         if (!loadingModal) this.loading();
         this.createDragZone();
      }
   };
   return Imgur;
}));