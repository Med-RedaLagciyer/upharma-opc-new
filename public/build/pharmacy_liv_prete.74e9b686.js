/*! For license information please see pharmacy_liv_prete.74e9b686.js.LICENSE.txt */
(self.webpackChunk=self.webpackChunk||[]).push([[143],{24068:(e,t,r)=>{"use strict";var n=r(76348),a=r.n(n);const s=JSON.parse('{"base_url":"","routes":{"app_admin_synchronisation":{"tokens":[["text","/admin/parametrage/synchronisation/"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_article":{"tokens":[["text","/admin/parametrage/synchronisation/api_article"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_demande_cab":{"tokens":[["text","/admin/parametrage/synchronisation/api_demande_cab"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_demande_det":{"tokens":[["text","/admin/parametrage/synchronisation/api_demande_det"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_cab":{"tokens":[["text","/admin/parametrage/synchronisation/api_livraison_cab"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_det":{"tokens":[["text","/admin/parametrage/synchronisation/api_livraison_det"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_lot":{"tokens":[["text","/admin/parametrage/synchronisation/api_livraison_lot"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"fixArticleMissing":{"tokens":[["text","/admin/parametrage/synchronisation/fixArticleMissing"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_list":{"tokens":[["text","/admin/parametrage/users/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_operation":{"tokens":[["variable","/","[^/]++","user",true],["text","/admin/parametrage/users/user_operation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_all":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["text","/admin/parametrage/users/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_sousmodule":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["variable","/","[^/]++","sousModule",true],["text","/admin/parametrage/users/sousmodule"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_module":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["variable","/","[^/]++","module",true],["text","/admin/parametrage/users/module"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_operation_add":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["variable","/","[^/]++","operation",true],["text","/admin/parametrage/users/operation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_parametrage_users_toggle_active":{"tokens":[["variable","/","[^/]++","user",true],["text","/admin/parametrage/users/activer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"auto_demande_det":{"tokens":[["text","/auto/sync/auto_demande_det"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_etudiant_rdv_listing_list":{"tokens":[["text","/etudiant/rendez-vous/listing/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_etudiant_rdv_getPatientInfo":{"tokens":[["variable","/","[^/]++","patient",true],["text","/etudiant/rendez-vous/listing/detailpatient"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_etudiant_rdv_listing_new":{"tokens":[["text","/etudiant/rendez-vous/listing/new"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_etudiant_rdv_listing_details":{"tokens":[["variable","/","[^/]++","rendezvous",true],["text","/etudiant/rendez-vous/listing/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_etudiant_rdv_listing_annuler":{"tokens":[["text","/etudiant/rendez-vous/listing/annuler"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_etudiant_rdv_listing_valider":{"tokens":[["text","/etudiant/rendez-vous/listing/valider"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_home":{"tokens":[["text","/"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_redirect":{"tokens":[["text","/redirect"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_exports_export_excel_livraison":{"tokens":[["text","/exports/export_excel_livraison"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_exports_export_pdf_livraison":{"tokens":[["text","/exports/export_pdf_livraison"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_list":{"tokens":[["text","/pharmacy/livraison/confirme/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_details":{"tokens":[["text","/pharmacy/livraison/confirme/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_preter":{"tokens":[["text","/pharmacy/livraison/confirme/prete"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_future":{"tokens":[["text","/pharmacy/livraison/confirme/future"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_observation":{"tokens":[["text","/pharmacy/livraison/confirme/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_list":{"tokens":[["text","/pharmacy/livraison/cree/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_details":{"tokens":[["text","/pharmacy/livraison/cree/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_envoyer":{"tokens":[["text","/pharmacy/livraison/cree/envoyer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_observation":{"tokens":[["text","/pharmacy/livraison/cree/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_list":{"tokens":[["text","/pharmacy/livraison/envoye/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_details":{"tokens":[["text","/pharmacy/livraison/envoye/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_confirmer":{"tokens":[["text","/pharmacy/livraison/envoye/confirmer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_observation":{"tokens":[["text","/pharmacy/livraison/envoye/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_list":{"tokens":[["text","/pharmacy/livraison/future/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_details":{"tokens":[["text","/pharmacy/livraison/future/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_livrer":{"tokens":[["text","/pharmacy/livraison/future/livrer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_observation":{"tokens":[["text","/pharmacy/livraison/future/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_list":{"tokens":[["text","/pharmacy/livraison/livre/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_details":{"tokens":[["text","/pharmacy/livraison/livre/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_valider":{"tokens":[["text","/pharmacy/livraison/livre/valider"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_observation":{"tokens":[["text","/pharmacy/livraison/livre/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_list":{"tokens":[["text","/pharmacy/livraison/prete/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_details":{"tokens":[["text","/pharmacy/livraison/prete/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_livrer":{"tokens":[["text","/pharmacy/livraison/prete/livrer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_observation":{"tokens":[["text","/pharmacy/livraison/prete/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_register_new":{"tokens":[["text","/register/new"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_login":{"tokens":[["text","/login"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_logout":{"tokens":[["text","/logout"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"forgot_password":{"tokens":[["text","/forgot"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_reset_password":{"tokens":[["text","/passwordchange"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]}},"prefix":"","host":"localhost","port":"","scheme":"http","locale":""}');a().setRoutingData(s)},25589:(e,t,r)=>{var n=r(74692);function a(e){return a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a(e)}function s(){"use strict";s=function(){return t};var e,t={},r=Object.prototype,n=r.hasOwnProperty,o=Object.defineProperty||function(e,t,r){e[t]=r.value},i="function"==typeof Symbol?Symbol:{},c=i.iterator||"@@iterator",l=i.asyncIterator||"@@asyncIterator",u=i.toStringTag||"@@toStringTag";function d(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{d({},"")}catch(e){d=function(e,t,r){return e[t]=r}}function p(e,t,r,n){var a=t&&t.prototype instanceof g?t:g,s=Object.create(a.prototype),i=new j(n||[]);return o(s,"_invoke",{value:O(e,r,i)}),s}function h(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}t.wrap=p;var m="suspendedStart",f="suspendedYield",v="executing",_="completed",y={};function g(){}function k(){}function w(){}var x={};d(x,c,(function(){return this}));var b=Object.getPrototypeOf,q=b&&b(b(N([])));q&&q!==r&&n.call(q,c)&&(x=q);var L=w.prototype=g.prototype=Object.create(x);function E(e){["next","throw","return"].forEach((function(t){d(e,t,(function(e){return this._invoke(t,e)}))}))}function S(e,t){function r(s,o,i,c){var l=h(e[s],e,o);if("throw"!==l.type){var u=l.arg,d=u.value;return d&&"object"==a(d)&&n.call(d,"__await")?t.resolve(d.__await).then((function(e){r("next",e,i,c)}),(function(e){r("throw",e,i,c)})):t.resolve(d).then((function(e){u.value=e,i(u)}),(function(e){return r("throw",e,i,c)}))}c(l.arg)}var s;o(this,"_invoke",{value:function(e,n){function a(){return new t((function(t,a){r(e,n,t,a)}))}return s=s?s.then(a,a):a()}})}function O(t,r,n){var a=m;return function(s,o){if(a===v)throw Error("Generator is already running");if(a===_){if("throw"===s)throw o;return{value:e,done:!0}}for(n.method=s,n.arg=o;;){var i=n.delegate;if(i){var c=A(i,n);if(c){if(c===y)continue;return c}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if(a===m)throw a=_,n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);a=v;var l=h(t,r,n);if("normal"===l.type){if(a=n.done?_:f,l.arg===y)continue;return{value:l.arg,done:n.done}}"throw"===l.type&&(a=_,n.method="throw",n.arg=l.arg)}}}function A(t,r){var n=r.method,a=t.iterator[n];if(a===e)return r.delegate=null,"throw"===n&&t.iterator.return&&(r.method="return",r.arg=e,A(t,r),"throw"===r.method)||"return"!==n&&(r.method="throw",r.arg=new TypeError("The iterator does not provide a '"+n+"' method")),y;var s=h(a,t.iterator,r.arg);if("throw"===s.type)return r.method="throw",r.arg=s.arg,r.delegate=null,y;var o=s.arg;return o?o.done?(r[t.resultName]=o.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,y):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,y)}function M(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function D(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function j(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(M,this),this.reset(!0)}function N(t){if(t||""===t){var r=t[c];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var s=-1,o=function r(){for(;++s<t.length;)if(n.call(t,s))return r.value=t[s],r.done=!1,r;return r.value=e,r.done=!0,r};return o.next=o}}throw new TypeError(a(t)+" is not iterable")}return k.prototype=w,o(L,"constructor",{value:w,configurable:!0}),o(w,"constructor",{value:k,configurable:!0}),k.displayName=d(w,u,"GeneratorFunction"),t.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===k||"GeneratorFunction"===(t.displayName||t.name))},t.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,w):(e.__proto__=w,d(e,u,"GeneratorFunction")),e.prototype=Object.create(L),e},t.awrap=function(e){return{__await:e}},E(S.prototype),d(S.prototype,l,(function(){return this})),t.AsyncIterator=S,t.async=function(e,r,n,a,s){void 0===s&&(s=Promise);var o=new S(p(e,r,n,a),s);return t.isGeneratorFunction(r)?o:o.next().then((function(e){return e.done?e.value:o.next()}))},E(L),d(L,u,"Generator"),d(L,c,(function(){return this})),d(L,"toString",(function(){return"[object Generator]"})),t.keys=function(e){var t=Object(e),r=[];for(var n in t)r.push(n);return r.reverse(),function e(){for(;r.length;){var n=r.pop();if(n in t)return e.value=n,e.done=!1,e}return e.done=!0,e}},t.values=N,j.prototype={constructor:j,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(D),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function a(n,a){return i.type="throw",i.arg=t,r.next=n,a&&(r.method="next",r.arg=e),!!a}for(var s=this.tryEntries.length-1;s>=0;--s){var o=this.tryEntries[s],i=o.completion;if("root"===o.tryLoc)return a("end");if(o.tryLoc<=this.prev){var c=n.call(o,"catchLoc"),l=n.call(o,"finallyLoc");if(c&&l){if(this.prev<o.catchLoc)return a(o.catchLoc,!0);if(this.prev<o.finallyLoc)return a(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return a(o.catchLoc,!0)}else{if(!l)throw Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return a(o.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var a=this.tryEntries[r];if(a.tryLoc<=this.prev&&n.call(a,"finallyLoc")&&this.prev<a.finallyLoc){var s=a;break}}s&&("break"===e||"continue"===e)&&s.tryLoc<=t&&t<=s.finallyLoc&&(s=null);var o=s?s.completion:{};return o.type=e,o.arg=t,s?(this.method="next",this.next=s.finallyLoc,y):this.complete(o)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),y},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),D(r),y}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var n=r.completion;if("throw"===n.type){var a=n.arg;D(r)}return a}}throw Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:N(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),y}},t}function o(e,t,r,n,a,s,o){try{var i=e[s](o),c=i.value}catch(e){return void r(e)}i.done?t(c):Promise.resolve(c).then(n,a)}function i(e){return function(){var t=this,r=arguments;return new Promise((function(n,a){var s=e.apply(t,r);function i(e){o(s,n,a,i,c,"next",e)}function c(e){o(s,n,a,i,c,"throw",e)}i(void 0)}))}}r(52675),r(89463),r(66412),r(2259),r(78125),r(16280),r(76918),r(28706),r(2008),r(51629),r(74423),r(64346),r(23792),r(44114),r(94490),r(34782),r(60739),r(62010),r(33110),r(4731),r(60479),r(59904),r(84185),r(40875),r(79432),r(10287),r(26099),r(16034),r(3362),r(21699),r(47764),r(42762),r(23500),r(62953),n(document).ready((function(){var e=null;n("#scanInput").focus(),n("#scanInput").on("keypress",function(){var e=i(s().mark((function e(t){var r,a,o,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t.preventDefault(),"Enter"!==t.key){e.next=28;break}if(r=n("#scanInput").val().trim()){e.next=7;break}return window.notyf.dismissAll(),window.notyf.error("Merci de scanner le codebarre ou bien tappez le code Livraison."),e.abrupt("return");case 7:return n("#detailsModal #detailsBody").html(""),n("#detailsModal #detailsBody").html('<main class="d-flex justify-content-center align-items-center flex-wrap">\n                <div class="spinner-grow" role="status"></div>\n                <div class="spinner-grow" role="status"></div>\n                <div class="spinner-grow" role="status"></div>\n            </main>'),n("body #detailsModal").modal("show"),e.prev=10,e.next=13,axios.post(Routing.generate("app_pharmacy_livraison_prete_details",{codeLivraison:r}));case 13:return a=e.sent,e.next=16,a.data;case 16:o=e.sent,n("#detailsModal #detailsBody").html(""),n("#detailsModal #detailsBody").html(o.detailLivraison),n("#list_details").DataTable(),e.next=28;break;case 22:e.prev=22,e.t0=e.catch(10),window.notyf.dismissAll(),console.log(e.t0.response.data.error),e.t0.response&&e.t0.response.data?(i=e.t0.response.data.error,window.notyf.error(i)):window.notyf.error("Something went wrong!"),n("body #detailsModal").modal("hide");case 28:case"end":return e.stop()}}),e,null,[[10,22]])})));return function(t){return e.apply(this,arguments)}}()),n("select").select2();n.fn.dataTable.isDataTable("#list_Livraison_prete")&&n("#list_Livraison_prete").DataTable().clear().destroy();var t=[],r=n("#list_Livraison_prete").DataTable({lengthMenu:[[10,15,25,50,100,2e13],[10,15,25,50,100,"All"]],order:[[0,"asc"]],ajax:{url:Routing.generate("app_pharmacy_livraison_prete_list"),type:"get",data:function(e){},beforeSend:function(t){e&&e.abort(),e=t},dataSrc:function(e){return window.globalActions=Array.isArray(e.actions)?e.actions:Object.values(e.actions),e.data}},processing:!0,serverSide:!0,deferRender:!0,responsive:!0,columns:[{name:"livCab.id",data:"id"},{name:"demandeCab.code",data:"code_dem_cab"},{name:"demandeCab.date",data:"date_dem"},{name:"livCab.code",data:"code_liv_cab"},{name:"livCab.date",data:"date_liv"},{name:"demandeCab.patient",data:"patient"},{name:"demandeCab.dossierPatient",data:"dossierPatient"},{name:"status.designation",data:"statut_liv"},{name:"actions",date:null,orderable:!1,searchable:!1,render:function(e,t,r){var n='<div class="dropdown" style="">\n                            <svg class="icon" fill="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n                                <circle cx="12" cy="5" r="2"></circle>\n                                <circle cx="12" cy="12" r="2"></circle>\n                                <circle cx="12" cy="19" r="2"></circle>\n                            </svg>\n                            <div class="actions dropdown-menu dashboard-dropdown dropdown-menu-center mt-2 py-1">';return window.globalActions.forEach((function(e){n+='\n                            <a href="#" data-id="'.concat(r.id,'" class="dropdown-item ').concat(e.className,'"><i class="fa ').concat(e.icon,'"></i>&nbsp;').concat(e.nom,"</a>")})),n+="</div>"}}],columnDefs:[{targets:0,orderable:!1,searchable:!1,render:function(e,r,n,a){var s=t.includes(e)?"checked":"";return'<input type="checkbox" class="selectLivraison" data-id="'.concat(e,'" ').concat(s,">")}},{targets:3,render:function(e,t,r,n){return e?'<a href="#" data-id="'.concat(r.id,'" class="detailsLiv">').concat(e,"</a>"):e}},{targets:5,render:function(e,t,r,n){return e?'<span id="truncated-text" title="'.concat(e,'">').concat(e.length>40?e.substring(0,40)+"...":e,"</span>"):e}},{targets:2,render:function(e,t,r,n){return window.moment(e.date).format("YYYY-MM-DD")}},{targets:4,render:function(e,t,r,n){return window.moment(e.date).format("YYYY-MM-DD")}}],language:datatablesFrench,createdRow:function(e,t,r){},initComplete:function(){n(".selectAllLivraisons").on("change",(function(){var e=n(this).prop("checked");n("input.selectLivraison").each((function(){n(this).prop("checked",e);var r=n(this).data("id");e&&!t.includes(r)?t.push(r):!e&&t.includes(r)&&(t=t.filter((function(e){return e!==r})))}))})),n("#list_Livraison_prete tbody").on("change","input.selectLivraison",(function(){var e=n(this).data("id");n(this).prop("checked")?t.includes(e)||t.push(e):t=t.filter((function(t){return t!==e})),a()})),n("thead .selection").on("click",(function(e){e.stopPropagation()}))},drawCallback:function(){a()}});function a(){var e=n("#list_Livraison_prete tbody input.selectLivraison").length===n("#list_Livraison_prete tbody input.selectLivraison:checked").length;n(".selectAllLivraisons").prop("checked",e)}n("body").on("click",".detailsLiv",function(){var e=i(s().mark((function e(t){var r,a,o,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),r=n(this).attr("data-id"),n("#detailsModal #detailsBody").html(""),n("#detailsModal #detailsBody").html('<main class="d-flex justify-content-center align-items-center flex-wrap">\n                <div class="spinner-grow" role="status"></div>\n                <div class="spinner-grow" role="status"></div>\n                <div class="spinner-grow" role="status"></div>\n            </main>'),n("#detailsModal").modal("show"),e.prev=5,e.next=8,axios.post(Routing.generate("app_pharmacy_livraison_prete_details",{idLivraison:r}));case 8:return a=e.sent,e.next=11,a.data;case 11:o=e.sent,n("#detailsModal #detailsBody").html(""),n("#detailsModal #detailsBody").html(o.detailLivraison),n("#list_details").DataTable(),e.next=22;break;case 17:e.prev=17,e.t0=e.catch(5),window.notyf.dismissAll(),console.log(e.t0.response.data),e.t0.response&&e.t0.response.data?(console.log("Attempting to hide modal after error..."),i=e.t0.response.data.error,window.notyf.error(i),n("#detailsModal").modal("hide")):window.notyf.error("Something went wrong!");case 22:case"end":return e.stop()}}),e,this,[[5,17]])})));return function(t){return e.apply(this,arguments)}}());var o=function(){var e=i(s().mark((function e(t){var a,o,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,window.notyf.open({type:"info",message:"En cours..",duration:9e6}),e.next=4,axios.post(Routing.generate("app_pharmacy_livraison_prete_livrer",{id_livraison:t}));case 4:return a=e.sent,e.next=7,a.data;case 7:o=e.sent,window.notyf.dismissAll(),window.notyf.open({type:"success",message:o,duration:3e3}),r.ajax.reload(),n("#detailsModal").modal("hide"),e.next=19;break;case 14:e.prev=14,e.t0=e.catch(0),window.notyf.dismissAll(),console.log(e.t0),e.t0.response&&e.t0.response.data?(i=e.t0.response.data.error,window.notyf.error(i)):window.notyf.error("Something went wrong!");case 19:case"end":return e.stop()}}),e,null,[[0,14]])})));return function(t){return e.apply(this,arguments)}}();n("body").on("click",".ModalLivrerLiv",function(){var e=i(s().mark((function e(t){var r;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),r=n(this).attr("data-id"),e.next=4,o(r);case 4:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()),n("body").on("click",".LivrerLiv",function(){var e=i(s().mark((function e(t){var r;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),r=n(this).attr("data-id"),e.next=4,o(r);case 4:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()),n("body").on("click",".observationMass",function(){var e=i(s().mark((function e(r){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(r.preventDefault(),!(t.length<=0)){e.next=4;break}return window.notyf.error("Merci de choisir une ou plusieurs livraisons."),e.abrupt("return");case 4:n("#observation_modal #observation").attr("data-livraisons",JSON.stringify(t)),n("#observation_modal").modal("show");case 6:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()),n("body").on("click",".observation",function(){var e=i(s().mark((function e(t){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.preventDefault(),livraison=[n(this).attr("data-id")],n("#observation_modal #observation").attr("data-livraisons",JSON.stringify(livraison)),n("#observation_modal").modal("show");case 4:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()),n("body").on("click","#saveOBS",function(){var e=i(s().mark((function e(t){var a,o,i,c,l;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),a=n("#observation_modal #observation").val(),o=n("#observation_modal #observation").attr("data-livraisons"),e.prev=3,window.notyf.open({type:"info",message:"En cours..",duration:9e6}),e.next=7,axios.post(Routing.generate("app_pharmacy_livraison_prete_observation",{livraisons:JSON.parse(o),observation:a}));case 7:return i=e.sent,e.next=10,i.data;case 10:c=e.sent,window.notyf.dismissAll(),window.notyf.open({type:"success",message:c,duration:3e3}),n("#observation_modal #observation").val(""),n("#observation_modal #observation").attr("data-livraisons",""),n("#observation_modal").modal("hide"),r.ajax.reload(),e.next=24;break;case 19:e.prev=19,e.t0=e.catch(3),window.notyf.dismissAll(),console.log(e.t0),e.t0.response&&e.t0.response.data?(l=e.t0.response.data.error,window.notyf.error(l)):window.notyf.error("Something went wrong!");case 24:case"end":return e.stop()}}),e,null,[[3,19]])})));return function(t){return e.apply(this,arguments)}}()),n("body").on("click","#pdfLivraison",(function(e){e.preventDefault(),livraison=n(this).attr("data-id");var t=Routing.generate("app_pharmacy_exports_export_pdf_livraison",{livraison});window.open(t,"_blank")})),n("body").on("click","#extractionExcel",(function(e){e.preventDefault();var t=Routing.generate("app_pharmacy_exports_export_excel_livraison");window.open(t,"_blank")}))}))},41436:(e,t,r)=>{"use strict";var n=r(78227)("match");e.exports=function(e){var t=/./;try{"/./"[e](t)}catch(r){try{return t[n]=!1,"/./"[e](t)}catch(e){}}return!1}},60788:(e,t,r)=>{"use strict";var n=r(20034),a=r(44576),s=r(78227)("match");e.exports=function(e){var t;return n(e)&&(void 0!==(t=e[s])?!!t:"RegExp"===a(e))}},60511:(e,t,r)=>{"use strict";var n=r(60788),a=TypeError;e.exports=function(e){if(n(e))throw new a("The method doesn't accept regular expressions");return e}},32357:(e,t,r)=>{"use strict";var n=r(43724),a=r(79039),s=r(79504),o=r(42787),i=r(71072),c=r(25397),l=s(r(48773).f),u=s([].push),d=n&&a((function(){var e=Object.create(null);return e[2]=2,!l(e,2)})),p=function(e){return function(t){for(var r,a=c(t),s=i(a),p=d&&null===o(a),h=s.length,m=0,f=[];h>m;)r=s[m++],n&&!(p?r in a:l(a,r))||u(f,e?[r,a[r]]:a[r]);return f}};e.exports={entries:p(!0),values:p(!1)}},60706:(e,t,r)=>{"use strict";var n=r(10350).PROPER,a=r(79039),s=r(47452);e.exports=function(e){return a((function(){return!!s[e]()||"​᠎"!=="​᠎"[e]()||n&&s[e].name!==e}))}},43802:(e,t,r)=>{"use strict";var n=r(79504),a=r(67750),s=r(655),o=r(47452),i=n("".replace),c=RegExp("^["+o+"]+"),l=RegExp("(^|[^"+o+"])["+o+"]+$"),u=function(e){return function(t){var r=s(a(t));return 1&e&&(r=i(r,c,"")),2&e&&(r=i(r,l,"$1")),r}};e.exports={start:u(1),end:u(2),trim:u(3)}},47452:e=>{"use strict";e.exports="\t\n\v\f\r                　\u2028\u2029\ufeff"},28706:(e,t,r)=>{"use strict";var n=r(46518),a=r(79039),s=r(34376),o=r(20034),i=r(48981),c=r(26198),l=r(96837),u=r(97040),d=r(1469),p=r(70597),h=r(78227),m=r(77388),f=h("isConcatSpreadable"),v=m>=51||!a((function(){var e=[];return e[f]=!1,e.concat()[0]!==e})),_=function(e){if(!o(e))return!1;var t=e[f];return void 0!==t?!!t:s(e)};n({target:"Array",proto:!0,arity:1,forced:!v||!p("concat")},{concat:function(e){var t,r,n,a,s,o=i(this),p=d(o,0),h=0;for(t=-1,n=arguments.length;t<n;t++)if(_(s=-1===t?o:arguments[t]))for(a=c(s),l(h+a),r=0;r<a;r++,h++)r in s&&u(p,h,s[r]);else l(h+1),u(p,h++,s);return p.length=h,p}})},2008:(e,t,r)=>{"use strict";var n=r(46518),a=r(59213).filter;n({target:"Array",proto:!0,forced:!r(70597)("filter")},{filter:function(e){return a(this,e,arguments.length>1?arguments[1]:void 0)}})},74423:(e,t,r)=>{"use strict";var n=r(46518),a=r(19617).includes,s=r(79039),o=r(6469);n({target:"Array",proto:!0,forced:s((function(){return!Array(1).includes()}))},{includes:function(e){return a(this,e,arguments.length>1?arguments[1]:void 0)}}),o("includes")},64346:(e,t,r)=>{"use strict";r(46518)({target:"Array",stat:!0},{isArray:r(34376)})},60739:(e,t,r)=>{"use strict";var n=r(46518),a=r(79039),s=r(48981),o=r(72777);n({target:"Date",proto:!0,arity:1,forced:a((function(){return null!==new Date(NaN).toJSON()||1!==Date.prototype.toJSON.call({toISOString:function(){return 1}})}))},{toJSON:function(e){var t=s(this),r=o(t,"number");return"number"!=typeof r||isFinite(r)?t.toISOString():null}})},79432:(e,t,r)=>{"use strict";var n=r(46518),a=r(48981),s=r(71072);n({target:"Object",stat:!0,forced:r(79039)((function(){s(1)}))},{keys:function(e){return s(a(e))}})},16034:(e,t,r)=>{"use strict";var n=r(46518),a=r(32357).values;n({target:"Object",stat:!0},{values:function(e){return a(e)}})},21699:(e,t,r)=>{"use strict";var n=r(46518),a=r(79504),s=r(60511),o=r(67750),i=r(655),c=r(41436),l=a("".indexOf);n({target:"String",proto:!0,forced:!c("includes")},{includes:function(e){return!!~l(i(o(this)),i(s(e)),arguments.length>1?arguments[1]:void 0)}})},42762:(e,t,r)=>{"use strict";var n=r(46518),a=r(43802).trim;n({target:"String",proto:!0,forced:r(60706)("trim")},{trim:function(){return a(this)}})}},e=>{var t=t=>e(e.s=t);e.O(0,[2],(()=>(t(24068),t(25589))));e.O()}]);