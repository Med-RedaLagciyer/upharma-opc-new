/*! For license information please see admin_users.c606e4da.js.LICENSE.txt */
(self.webpackChunk=self.webpackChunk||[]).push([[69],{24068:(e,t,r)=>{"use strict";var a=r(76348),n=r.n(a);const s=JSON.parse('{"base_url":"","routes":{"api_article_fix":{"tokens":[["text","/admin/parametrage/synchronisation_fix/api_article_fix"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_demande_cab_fix":{"tokens":[["text","/admin/parametrage/synchronisation_fix/api_demande_cab_fix"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_demande_det_fix":{"tokens":[["text","/admin/parametrage/synchronisation_fix/api_demande_det_fix"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_cab_fix":{"tokens":[["text","/admin/parametrage/synchronisation_fix/api_livraison_cab_fix"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_det_fix":{"tokens":[["text","/admin/parametrage/synchronisation_fix/api_livraison_det_fix"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_lot_fix":{"tokens":[["text","/admin/parametrage/synchronisation_fix/api_livraison_lot_fix"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_synchronisation":{"tokens":[["text","/admin/parametrage/synchronisation/"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_article":{"tokens":[["text","/admin/parametrage/synchronisation/api_article"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_demande_cab":{"tokens":[["text","/admin/parametrage/synchronisation/api_demande_cab"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_demande_det":{"tokens":[["text","/admin/parametrage/synchronisation/api_demande_det"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_cab":{"tokens":[["text","/admin/parametrage/synchronisation/api_livraison_cab"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_det":{"tokens":[["text","/admin/parametrage/synchronisation/api_livraison_det"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"api_livraison_lot":{"tokens":[["text","/admin/parametrage/synchronisation/api_livraison_lot"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"fixArticleMissing":{"tokens":[["text","/admin/parametrage/synchronisation/fixArticleMissing"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_list":{"tokens":[["text","/admin/parametrage/users/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_operation":{"tokens":[["variable","/","[^/]++","user",true],["text","/admin/parametrage/users/user_operation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_all":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["text","/admin/parametrage/users/all"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_sousmodule":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["variable","/","[^/]++","sousModule",true],["text","/admin/parametrage/users/sousmodule"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_module":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["variable","/","[^/]++","module",true],["text","/admin/parametrage/users/module"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_admin_parametrage_users_operation_add":{"tokens":[["variable","/","[^/]++","type",true],["variable","/","[^/]++","user",true],["variable","/","[^/]++","operation",true],["text","/admin/parametrage/users/operation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_parametrage_users_toggle_active":{"tokens":[["variable","/","[^/]++","user",true],["text","/admin/parametrage/users/activer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"auto_demande_det":{"tokens":[["text","/auto/sync/auto_demande_det"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_home":{"tokens":[["text","/"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_redirect":{"tokens":[["text","/redirect"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_exports_export_excel_livraison":{"tokens":[["text","/exports/export_excel_livraison"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_exports_export_pdf_livraison":{"tokens":[["text","/exports/export_pdf_livraison"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_list":{"tokens":[["text","/pharmacy/livraison/confirme/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_details":{"tokens":[["text","/pharmacy/livraison/confirme/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_preter":{"tokens":[["text","/pharmacy/livraison/confirme/prete"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_future":{"tokens":[["text","/pharmacy/livraison/confirme/future"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_confirme_observation":{"tokens":[["text","/pharmacy/livraison/confirme/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_list":{"tokens":[["text","/pharmacy/livraison/cree/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_details":{"tokens":[["text","/pharmacy/livraison/cree/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_envoyer":{"tokens":[["text","/pharmacy/livraison/cree/envoyer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_cree_observation":{"tokens":[["text","/pharmacy/livraison/cree/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_list":{"tokens":[["text","/pharmacy/livraison/envoye/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_details":{"tokens":[["text","/pharmacy/livraison/envoye/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_confirmer":{"tokens":[["text","/pharmacy/livraison/envoye/confirmer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_envoye_observation":{"tokens":[["text","/pharmacy/livraison/envoye/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_list":{"tokens":[["text","/pharmacy/livraison/future/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_details":{"tokens":[["text","/pharmacy/livraison/future/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_livrer":{"tokens":[["text","/pharmacy/livraison/future/livrer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_future_observation":{"tokens":[["text","/pharmacy/livraison/future/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_list":{"tokens":[["text","/pharmacy/livraison/livre/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_details":{"tokens":[["text","/pharmacy/livraison/livre/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_valider":{"tokens":[["text","/pharmacy/livraison/livre/valider"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_livre_observation":{"tokens":[["text","/pharmacy/livraison/livre/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_list":{"tokens":[["text","/pharmacy/livraison/prete/list"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_details":{"tokens":[["text","/pharmacy/livraison/prete/details"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_livrer":{"tokens":[["text","/pharmacy/livraison/prete/livrer"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_livraison_prete_observation":{"tokens":[["text","/pharmacy/livraison/prete/observation"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_pharmacy_misc_maj":{"tokens":[["text","/misc/maj"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_register_new":{"tokens":[["text","/register/new"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_login":{"tokens":[["text","/login"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_logout":{"tokens":[["text","/logout"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"forgot_password":{"tokens":[["text","/forgot"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]},"app_reset_password":{"tokens":[["text","/passwordchange"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":[],"schemes":[]}},"prefix":"","host":"localhost","port":"","scheme":"http","locale":""}');n().setRoutingData(s)},7402:(e,t,r)=>{var a=r(74692);function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function s(){"use strict";s=function(){return t};var e,t={},r=Object.prototype,a=r.hasOwnProperty,o=Object.defineProperty||function(e,t,r){e[t]=r.value},i="function"==typeof Symbol?Symbol:{},c=i.iterator||"@@iterator",u=i.asyncIterator||"@@asyncIterator",p=i.toStringTag||"@@toStringTag";function l(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{l({},"")}catch(e){l=function(e,t,r){return e[t]=r}}function h(e,t,r,a){var n=t&&t.prototype instanceof g?t:g,s=Object.create(n.prototype),i=new T(a||[]);return o(s,"_invoke",{value:S(e,r,i)}),s}function d(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}t.wrap=h;var m="suspendedStart",f="suspendedYield",v="executing",_="completed",y={};function g(){}function k(){}function x(){}var b={};l(b,c,(function(){return this}));var w=Object.getPrototypeOf,q=w&&w(w(D([])));q&&q!==r&&a.call(q,c)&&(b=q);var L=x.prototype=g.prototype=Object.create(b);function E(e){["next","throw","return"].forEach((function(t){l(e,t,(function(e){return this._invoke(t,e)}))}))}function O(e,t){function r(s,o,i,c){var u=d(e[s],e,o);if("throw"!==u.type){var p=u.arg,l=p.value;return l&&"object"==n(l)&&a.call(l,"__await")?t.resolve(l.__await).then((function(e){r("next",e,i,c)}),(function(e){r("throw",e,i,c)})):t.resolve(l).then((function(e){p.value=e,i(p)}),(function(e){return r("throw",e,i,c)}))}c(u.arg)}var s;o(this,"_invoke",{value:function(e,a){function n(){return new t((function(t,n){r(e,a,t,n)}))}return s=s?s.then(n,n):n()}})}function S(t,r,a){var n=m;return function(s,o){if(n===v)throw Error("Generator is already running");if(n===_){if("throw"===s)throw o;return{value:e,done:!0}}for(a.method=s,a.arg=o;;){var i=a.delegate;if(i){var c=j(i,a);if(c){if(c===y)continue;return c}}if("next"===a.method)a.sent=a._sent=a.arg;else if("throw"===a.method){if(n===m)throw n=_,a.arg;a.dispatchException(a.arg)}else"return"===a.method&&a.abrupt("return",a.arg);n=v;var u=d(t,r,a);if("normal"===u.type){if(n=a.done?_:f,u.arg===y)continue;return{value:u.arg,done:a.done}}"throw"===u.type&&(n=_,a.method="throw",a.arg=u.arg)}}}function j(t,r){var a=r.method,n=t.iterator[a];if(n===e)return r.delegate=null,"throw"===a&&t.iterator.return&&(r.method="return",r.arg=e,j(t,r),"throw"===r.method)||"return"!==a&&(r.method="throw",r.arg=new TypeError("The iterator does not provide a '"+a+"' method")),y;var s=d(n,t.iterator,r.arg);if("throw"===s.type)return r.method="throw",r.arg=s.arg,r.delegate=null,y;var o=s.arg;return o?o.done?(r[t.resultName]=o.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,y):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,y)}function M(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function A(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function T(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(M,this),this.reset(!0)}function D(t){if(t||""===t){var r=t[c];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var s=-1,o=function r(){for(;++s<t.length;)if(a.call(t,s))return r.value=t[s],r.done=!1,r;return r.value=e,r.done=!0,r};return o.next=o}}throw new TypeError(n(t)+" is not iterable")}return k.prototype=x,o(L,"constructor",{value:x,configurable:!0}),o(x,"constructor",{value:k,configurable:!0}),k.displayName=l(x,p,"GeneratorFunction"),t.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===k||"GeneratorFunction"===(t.displayName||t.name))},t.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,x):(e.__proto__=x,l(e,p,"GeneratorFunction")),e.prototype=Object.create(L),e},t.awrap=function(e){return{__await:e}},E(O.prototype),l(O.prototype,u,(function(){return this})),t.AsyncIterator=O,t.async=function(e,r,a,n,s){void 0===s&&(s=Promise);var o=new O(h(e,r,a,n),s);return t.isGeneratorFunction(r)?o:o.next().then((function(e){return e.done?e.value:o.next()}))},E(L),l(L,p,"Generator"),l(L,c,(function(){return this})),l(L,"toString",(function(){return"[object Generator]"})),t.keys=function(e){var t=Object(e),r=[];for(var a in t)r.push(a);return r.reverse(),function e(){for(;r.length;){var a=r.pop();if(a in t)return e.value=a,e.done=!1,e}return e.done=!0,e}},t.values=D,T.prototype={constructor:T,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(A),!t)for(var r in this)"t"===r.charAt(0)&&a.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function n(a,n){return i.type="throw",i.arg=t,r.next=a,n&&(r.method="next",r.arg=e),!!n}for(var s=this.tryEntries.length-1;s>=0;--s){var o=this.tryEntries[s],i=o.completion;if("root"===o.tryLoc)return n("end");if(o.tryLoc<=this.prev){var c=a.call(o,"catchLoc"),u=a.call(o,"finallyLoc");if(c&&u){if(this.prev<o.catchLoc)return n(o.catchLoc,!0);if(this.prev<o.finallyLoc)return n(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return n(o.catchLoc,!0)}else{if(!u)throw Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return n(o.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&a.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var s=n;break}}s&&("break"===e||"continue"===e)&&s.tryLoc<=t&&t<=s.finallyLoc&&(s=null);var o=s?s.completion:{};return o.type=e,o.arg=t,s?(this.method="next",this.next=s.finallyLoc,y):this.complete(o)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),y},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),A(r),y}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var a=r.completion;if("throw"===a.type){var n=a.arg;A(r)}return n}}throw Error("illegal catch attempt")},delegateYield:function(t,r,a){return this.delegate={iterator:D(t),resultName:r,nextLoc:a},"next"===this.method&&(this.arg=e),y}},t}function o(e,t,r,a,n,s,o){try{var i=e[s](o),c=i.value}catch(e){return void r(e)}i.done?t(c):Promise.resolve(c).then(a,n)}function i(e){return function(){var t=this,r=arguments;return new Promise((function(a,n){var s=e.apply(t,r);function i(e){o(s,a,n,i,c,"next",e)}function c(e){o(s,a,n,i,c,"throw",e)}i(void 0)}))}}r(52675),r(89463),r(66412),r(2259),r(78125),r(16280),r(76918),r(28706),r(50113),r(51629),r(23792),r(62062),r(44114),r(94490),r(34782),r(62010),r(4731),r(60479),r(59904),r(84185),r(40875),r(10287),r(26099),r(3362),r(47764),r(23500),r(62953),a(document).ready((function(){var e=null;a("select").select2(),a.fn.dataTable.isDataTable("#list_users")&&a("#list_users").DataTable().clear().destroy();var t=function(){a(".sousModules").map((function(){0===a(this).parent().find(".inputOperation").not(":checked").length&&a(this).find(".inputSousModule").prop("checked",!0)})),a(".modules").map((function(){0===a(this).parent().find(".inputSousModule").not(":checked").length&&a(this).find(".inputModule").prop("checked",!0)})),0===a(".modules").find(".inputModule").not(":checked").length&&a(".tous").prop("checked",!0)},r=a("#list_users").DataTable({lengthMenu:[[10,15,25,50,100,2e13],[10,15,25,50,100,"All"]],order:[[0,"desc"]],ajax:{url:Routing.generate("app_admin_parametrage_users_list"),type:"get",data:function(e){},beforeSend:function(t){e&&e.abort(),e=t}},processing:!0,serverSide:!0,deferRender:!0,responsive:!0,columns:[{name:"u.id",data:"id"},{name:"u.username",data:"username"},{name:"u.nom",data:"nom"},{name:"u.prenom",data:"prenom"},{name:"u.email",data:"email"},{name:"u.roles",data:"roles"},{name:"u.created",data:"created"},{name:"u.enable",data:"enable"},{orderable:!1,searchable:!1,data:"id"}],columnDefs:[{targets:5,render:function(e,t,r,a){var n="";return e.forEach((function(e){"ROLE_ADMIN"==e&&(color="azure"),"ROLE_USER"==e&&(color="green"),"ROLE_SUPERADMIN"==e&&(color="red"),n+='<span class="badge bg-'.concat(color,'  text-white -fg mx-1">').concat(e,"</span>")})),n}},{targets:6,render:function(e,t,r,a){return e?window.moment(e.date).format("YYYY-MM-DD HH:mm:ss"):"NULL"}},{targets:7,render:function(e,t,r,a){return 1==e?'<i class="fa-solid fa-circle-check" style="color: #1fbe8e;"></i>':'<i class="fa-solid fa-ban" style="color: #e70c53;"></i>'}},{targets:8,render:function(e,t,r,a){return'\n                        <div class="dropdown" style="">\n                            <svg class="icon" fill="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n                                <circle cx="12" cy="5" r="2"></circle>\n                                <circle cx="12" cy="12" r="2"></circle>\n                                <circle cx="12" cy="19" r="2"></circle>\n                            </svg>\n                            <div class="actions dropdown-menu dashboard-dropdown dropdown-menu-center mt-2 py-1">\n                                <a href="#" data-id="'.concat(r.id,'" class="dropdown-item toggleEnable">').concat(1==r.enable?"<i class='fa fa-ban'></i>&nbsp; Dévalider":"<i class='fa fa-circle-check'></i>&nbsp; Valider",'</a>\n                                <a href="#" data-id="').concat(r.id,'" class="dropdown-item privilegeBtn"><i class=\'fa fa-circle-plus\'></i>&nbsp; Privilége</a>\n                            </div>\n                        </div>\n                    ')}}],language:datatablesFrench,initComplete:function(){a("thead .selection").on("click",(function(e){e.stopPropagation()}))}});a("body").on("click",".privilegeBtn",function(){var e=i(s().mark((function e(r){var n,o,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r.preventDefault(),n=a(this).attr("data-id"),a(".privilege input:checkbox").prop("checked",!1),e.prev=3,e.next=6,axios.post(Routing.generate("app_admin_parametrage_users_operation",{user:n}));case 6:return o=e.sent,e.next=9,o.data;case 9:e.sent.map((function(e){console.log(e),a(".buttons ."+e.id).prop("checked",!0)})),t(),a(".privilege input:checkbox").attr("data-user",n),a("#privilegeModal").modal("show"),e.next=21;break;case 16:e.prev=16,e.t0=e.catch(3),window.notyf.dismissAll(),console.log(e.t0),e.t0.response&&e.t0.response.data?(i=e.t0.response.data,window.notyf.error(i)):window.notyf.error("Something went wrong!");case 21:case"end":return e.stop()}}),e,this,[[3,16]])})));return function(t){return e.apply(this,arguments)}}()),a(".Collapsable").on("click",(function(){a(this).parent().children().toggle(),a(this).toggle()})),a(".inputSousModule").on("click",i(s().mark((function e(){var r,n,o,i,c;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=a(this).attr("data-user"),o=a(this).attr("data-module"),a(this).is(":checked")?(a(this).parent().parent().find(".inputOperation").prop("checked",!0),r="/admin/parametrage/users/sousmodule/"+o+"/"+n+"/add"):(a(this).parent().parent().find(".inputOperation").prop("checked",!1),r="/admin/parametrage/users/sousmodule/"+o+"/"+n+"/remove"),t(),e.prev=4,e.next=7,axios.post(r);case 7:i=e.sent,i.data,e.next=15;break;case 11:e.prev=11,e.t0=e.catch(4),c=e.t0.response.data,Toast.fire({icon:"error",title:c});case 15:case"end":return e.stop()}}),e,this,[[4,11]])})))),a(".inputModule").on("click",i(s().mark((function e(){var r,n,o,i,c;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=a(this).attr("data-id"),o=a(this).attr("data-user"),a(this).is(":checked")?(a(this).parent().parent().find("input:checkbox").prop("checked",!0),r="/admin/parametrage/users/module/"+n+"/"+o+"/add"):(a(this).parent().parent().find("input:checkbox").prop("checked",!1),r="/admin/parametrage/users/module/"+n+"/"+o+"/remove"),t(),e.prev=4,e.next=7,axios.post(r);case 7:i=e.sent,i.data,e.next=15;break;case 11:e.prev=11,e.t0=e.catch(4),c=e.t0.response.data,Toast.fire({icon:"error",title:c});case 15:case"end":return e.stop()}}),e,this,[[4,11]])})))),a(".inputOperation").on("click",i(s().mark((function e(){var r,n,o,i,c;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=a(this).attr("data-user"),o=a(this).attr("data-operation"),r=a(this).is(":checked")?"/admin/parametrage/users/operation/"+o+"/"+n+"/add":"/admin/parametrage/users/operation/"+o+"/"+n+"/remove",t(),e.prev=4,e.next=7,axios.post(r);case 7:i=e.sent,i.data,e.next=15;break;case 11:e.prev=11,e.t0=e.catch(4),c=e.t0.response.data,Toast.fire({icon:"error",title:c});case 15:case"end":return e.stop()}}),e,this,[[4,11]])})))),a(".tous").on("click",i(s().mark((function e(){var r,n,o,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=a(this).attr("data-user"),a(this).is(":checked")?(a(".tous").parent().parent().find("input:checkbox").prop("checked",!0),r="/admin/parametrage/users/all/"+n+"/add"):(a(".tous").parent().parent().find("input:checkbox").prop("checked",!1),r="/admin/parametrage/users/all/"+n+"/remove"),t(),e.prev=3,e.next=6,axios.post(r);case 6:o=e.sent,o.data,e.next=14;break;case 10:e.prev=10,e.t0=e.catch(3),i=e.t0.response.data,Toast.fire({icon:"error",title:i});case 14:case"end":return e.stop()}}),e,this,[[3,10]])})))),a("body").on("click",".toggleEnable",function(){var e=i(s().mark((function e(t){var n,o,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),e.prev=1,n=a(this).attr("data-id"),window.notyf.open({type:"info",message:"En cours..",duration:9e6}),e.next=6,axios.post(Routing.generate("app_parametrage_users_toggle_active",{user:n}));case 6:return o=e.sent,e.next=9,o.data;case 9:e.sent,window.notyf.dismissAll(),window.notyf.open({type:"success",message:"Succés",duration:3e3}),r.ajax.reload(!1),e.next=20;break;case 15:e.prev=15,e.t0=e.catch(1),window.notyf.dismissAll(),console.log(e.t0),e.t0.response&&e.t0.response.data?(i=e.t0.response.data,window.notyf.error(i)):window.notyf.error("Something went wrong!");case 20:case"end":return e.stop()}}),e,this,[[1,15]])})));return function(t){return e.apply(this,arguments)}}())}))},28706:(e,t,r)=>{"use strict";var a=r(46518),n=r(79039),s=r(34376),o=r(20034),i=r(48981),c=r(26198),u=r(96837),p=r(97040),l=r(1469),h=r(70597),d=r(78227),m=r(77388),f=d("isConcatSpreadable"),v=m>=51||!n((function(){var e=[];return e[f]=!1,e.concat()[0]!==e})),_=function(e){if(!o(e))return!1;var t=e[f];return void 0!==t?!!t:s(e)};a({target:"Array",proto:!0,arity:1,forced:!v||!h("concat")},{concat:function(e){var t,r,a,n,s,o=i(this),h=l(o,0),d=0;for(t=-1,a=arguments.length;t<a;t++)if(_(s=-1===t?o:arguments[t]))for(n=c(s),u(d+n),r=0;r<n;r++,d++)r in s&&p(h,d,s[r]);else u(d+1),p(h,d++,s);return h.length=d,h}})},50113:(e,t,r)=>{"use strict";var a=r(46518),n=r(59213).find,s=r(6469),o="find",i=!0;o in[]&&Array(1)[o]((function(){i=!1})),a({target:"Array",proto:!0,forced:i},{find:function(e){return n(this,e,arguments.length>1?arguments[1]:void 0)}}),s(o)},62062:(e,t,r)=>{"use strict";var a=r(46518),n=r(59213).map;a({target:"Array",proto:!0,forced:!r(70597)("map")},{map:function(e){return n(this,e,arguments.length>1?arguments[1]:void 0)}})}},e=>{var t=t=>e(e.s=t);e.O(0,[2],(()=>(t(24068),t(7402))));e.O()}]);