var Al=Object.defineProperty;var ui=e=>{throw TypeError(e)};var Rl=(e,t,n)=>t in e?Al(e,t,{enumerable:!0,configurable:!0,writable:!0,value:n}):e[t]=n;var $=(e,t,n)=>Rl(e,typeof t!="symbol"?t+"":t,n),Qr=(e,t,n)=>t.has(e)||ui("Cannot "+n);var h=(e,t,n)=>(Qr(e,t,"read from private field"),n?n.call(e):t.get(e)),I=(e,t,n)=>t.has(e)?ui("Cannot add the same private member more than once"):t instanceof WeakSet?t.add(e):t.set(e,n),T=(e,t,n,r)=>(Qr(e,t,"write to private field"),r?r.call(e,n):t.set(e,n),n),M=(e,t,n)=>(Qr(e,t,"access private method"),n);var Ri=Array.isArray,Il=Array.prototype.indexOf,$n=Array.prototype.includes,Ol=Array.from,xr=Object.keys,Yn=Object.defineProperty,bn=Object.getOwnPropertyDescriptor,Pl=Object.getOwnPropertyDescriptors,Ll=Object.prototype,Dl=Array.prototype,Ii=Object.getPrototypeOf,fi=Object.isExtensible,Ut=()=>{};function Ml(e){for(var t=0;t<e.length;t++)e[t]()}function Oi(){var e,t,n=new Promise((r,a)=>{e=r,t=a});return{promise:n,resolve:e,reject:t}}var _e=2,Tn=4,Or=8,Ia=1<<24,nt=16,bt=32,Tt=64,la=128,We=512,be=1024,ye=2048,mt=4096,Ze=8192,it=16384,Ht=32768,sa=1<<25,Vt=65536,Er=1<<17,Nl=1<<18,un=1<<19,Ul=1<<20,ln=65536,Sr=1<<21,mn=1<<22,Ft=1<<23,yn=Symbol("$state"),Fl=Symbol("legacy props"),Vl=Symbol(""),gr=Symbol("attributes"),ca=Symbol("class"),ua=Symbol("style"),Fn=Symbol("text"),zn=Symbol("form reset"),Pr=new class extends Error{constructor(){super(...arguments);$(this,"name","StaleReactionError");$(this,"message","The reaction that called `getAbortSignal()` was re-run or destroyed")}},tr=!!globalThis.document?.contentType&&globalThis.document.contentType.includes("xml"),nr=3,rr=8;function Pi(e){return e===this.v}function Li(e,t){return e!=e?t==t:e!==t||e!==null&&typeof e=="object"||typeof e=="function"}function jl(e){return!Li(e,this.v)}function zl(e){throw new Error("https://svelte.dev/e/lifecycle_outside_component")}function Hl(){throw new Error("https://svelte.dev/e/async_derived_orphan")}function Bl(e){throw new Error("https://svelte.dev/e/effect_in_teardown")}function Kl(){throw new Error("https://svelte.dev/e/effect_in_unowned_derived")}function Yl(e){throw new Error("https://svelte.dev/e/effect_orphan")}function Gl(){throw new Error("https://svelte.dev/e/effect_update_depth_exceeded")}function ql(){throw new Error("https://svelte.dev/e/hydration_failed")}function Wl(){throw new Error("https://svelte.dev/e/state_descriptors_fixed")}function Zl(){throw new Error("https://svelte.dev/e/state_prototype_fixed")}function Jl(){throw new Error("https://svelte.dev/e/state_unsafe_mutation")}function Xl(){throw new Error("https://svelte.dev/e/svelte_boundary_reset_onerror")}var Ql=1,es=2,Oa="[",Di="[!",hi="[?",Mi="]",sn={},he=Symbol("uninitialized"),Ni="http://www.w3.org/1999/xhtml",ts="http://www.w3.org/2000/svg",ns="http://www.w3.org/1998/Math/MathML",rs="@attach",Ie=null;function An(e){Ie=e}function Rt(e,t=!1,n){Ie={p:Ie,i:!1,c:null,e:null,s:e,x:null,r:P,l:null}}function It(e){var t=Ie,n=t.e;if(n!==null){t.e=null;for(var r of n)mo(r)}return e!==void 0&&(t.x=e),t.i=!0,Ie=t.p,e??{}}function Ui(){return!0}var qt=[];function Fi(){var e=qt;qt=[],Ml(e)}function $t(e){if(qt.length===0&&!Hn){var t=qt;queueMicrotask(()=>{t===qt&&Fi()})}qt.push(e)}function as(){for(;qt.length>0;)Fi()}function is(){console.warn("https://svelte.dev/e/derived_inert")}function ar(e){console.warn("https://svelte.dev/e/hydration_mismatch")}function os(){console.warn("https://svelte.dev/e/select_multiple_invalid_value")}function ls(){console.warn("https://svelte.dev/e/svelte_boundary_reset_noop")}var L=!1;function gt(e){L=e}var z;function Ce(e){if(e===null)throw ar(),sn;return z=e}function cn(){return Ce(wt(z))}function ee(e){if(L){if(wt(z)!==null)throw ar(),sn;z=e}}function Pa(e=1){if(L){for(var t=e,n=z;t--;)n=wt(n);z=n}}function La(e=!0){for(var t=0,n=z;;){if(n.nodeType===rr){var r=n.data;if(r===Mi){if(t===0)return n;t-=1}else(r===Oa||r===Di||r[0]==="["&&!isNaN(Number(r.slice(1))))&&(t+=1)}var a=wt(n);e&&n.remove(),n=a}}function Vi(e){if(!e||e.nodeType!==rr)throw ar(),sn;return e.data}function Ct(e){if(typeof e!="object"||e===null||yn in e)return e;let t=Ii(e);if(t!==Ll&&t!==Dl)return e;var n=new Map,r=Ri(e),a=N(0),i=on,l=s=>{if(on===i)return s();var f=F,c=on;Xe(null),yi(i);var v=s();return Xe(f),yi(c),v};return r&&n.set("length",N(e.length)),new Proxy(e,{defineProperty(s,f,c){(!("value"in c)||c.configurable===!1||c.enumerable===!1||c.writable===!1)&&Wl();var v=n.get(f);return v===void 0?l(()=>{var p=N(c.value);return n.set(f,p),p}):k(v,c.value,!0),!0},deleteProperty(s,f){var c=n.get(f);if(c===void 0){if(f in s){let v=l(()=>N(he));n.set(f,v),Bn(a)}}else k(c,he),Bn(a);return!0},get(s,f,c){if(f===yn)return e;var v=n.get(f),p=f in s;if(v===void 0&&(!p||bn(s,f)?.writable)&&(v=l(()=>{var m=Ct(p?s[f]:he),b=N(m);return b}),n.set(f,v)),v!==void 0){var d=o(v);return d===he?void 0:d}return Reflect.get(s,f,c)},getOwnPropertyDescriptor(s,f){var c=Reflect.getOwnPropertyDescriptor(s,f);if(c&&"value"in c){var v=n.get(f);v&&(c.value=o(v))}else if(c===void 0){var p=n.get(f),d=p?.v;if(p!==void 0&&d!==he)return{enumerable:!0,configurable:!0,value:d,writable:!0}}return c},has(s,f){if(f===yn)return!0;var c=n.get(f),v=c!==void 0&&c.v!==he||Reflect.has(s,f);if(c!==void 0||P!==null&&(!v||bn(s,f)?.writable)){c===void 0&&(c=l(()=>{var d=v?Ct(s[f]):he,m=N(d);return m}),n.set(f,c));var p=o(c);if(p===he)return!1}return v},set(s,f,c,v){var p=n.get(f),d=f in s;if(r&&f==="length")for(var m=c;m<p.v;m+=1){var b=n.get(m+"");b!==void 0?k(b,he):m in s&&(b=l(()=>N(he)),n.set(m+"",b))}if(p===void 0)(!d||bn(s,f)?.writable)&&(p=l(()=>N(void 0)),k(p,Ct(c)),n.set(f,p));else{d=p.v!==he;var A=l(()=>Ct(c));k(p,A)}var C=Reflect.getOwnPropertyDescriptor(s,f);if(C?.set&&C.set.call(v,c),!d){if(r&&typeof f=="string"){var U=n.get("length"),de=Number(f);Number.isInteger(de)&&de>=U.v&&k(U,de+1)}Bn(a)}return!0},ownKeys(s){o(a);var f=Reflect.ownKeys(s).filter(p=>{var d=n.get(p);return d===void 0||d.v!==he});for(var[c,v]of n)v.v!==he&&!(c in s)&&f.push(c);return f},setPrototypeOf(){Zl()}})}function di(e){try{if(e!==null&&typeof e=="object"&&yn in e)return e[yn]}catch{}return e}function ss(e,t){return Object.is(di(e),di(t))}var rn,fa,ji,zi,Hi;function ha(){if(rn===void 0){rn=window,fa=document,ji=/Firefox/.test(navigator.userAgent);var e=Element.prototype,t=Node.prototype,n=Text.prototype;zi=bn(t,"firstChild").get,Hi=bn(t,"nextSibling").get,fi(e)&&(e[ca]=void 0,e[gr]=null,e[ua]=void 0,e.__e=void 0),fi(n)&&(n[Fn]=void 0)}}function ot(e=""){return document.createTextNode(e)}function Ve(e){return zi.call(e)}function wt(e){return Hi.call(e)}function oe(e,t){if(!L)return Ve(e);var n=Ve(z);if(n===null)n=z.appendChild(ot());else if(t&&n.nodeType!==nr){var r=ot();return n?.before(r),Ce(r),r}return t&&Lr(n),Ce(n),n}function vn(e,t=!1){if(!L){var n=Ve(e);return n instanceof Comment&&n.data===""?wt(n):n}if(t){if(z?.nodeType!==nr){var r=ot();return z?.before(r),Ce(r),r}Lr(z)}return z}function ne(e,t=1,n=!1){let r=L?z:e;for(var a;t--;)a=r,r=wt(r);if(!L)return r;if(n){if(r?.nodeType!==nr){var i=ot();return r===null?a?.after(i):r.before(i),Ce(i),i}Lr(r)}return Ce(r),r}function cs(e){e.textContent=""}function us(){return!1}function Da(e,t,n){return document.createElementNS(t??Ni,e,void 0)}function Lr(e){if(e.nodeValue.length<65536)return;let t=e.nextSibling;for(;t!==null&&t.nodeType===nr;)t.remove(),e.nodeValue+=t.nodeValue,t=e.nextSibling}function Bi(e){var t=P;if(t===null)return F.f|=Ft,e;if((t.f&Ht)===0&&(t.f&Tn)===0)throw e;Nt(e,t)}function Nt(e,t){for(;t!==null;){if((t.f&la)!==0){if((t.f&Ht)===0)throw e;try{t.b.error(e);return}catch(n){e=n}}t=t.parent}throw e}var fs=-7169;function ce(e,t){e.f=e.f&fs|t}function Ma(e){(e.f&We)!==0||e.deps===null?ce(e,be):ce(e,mt)}function Ki(e){if(e!==null)for(let t of e)(t.f&_e)===0||(t.f&ln)===0||(t.f^=ln,Ki(t.deps))}function Yi(e,t,n){(e.f&ye)!==0?t.add(e):(e.f&mt)!==0&&n.add(e),Ki(e.deps),ce(e,be)}function Gi(e,t,n){if(e==null)return t(void 0),Ut;let r=lr(()=>e.subscribe(t,n));return r.unsubscribe?()=>r.unsubscribe():r}var hn=[];function hs(e,t=Ut){let n=null,r=new Set;function a(s){if(Li(e,s)&&(e=s,n)){let f=!hn.length;for(let c of r)c[1](),hn.push(c,e);if(f){for(let c=0;c<hn.length;c+=2)hn[c][0](hn[c+1]);hn.length=0}}}function i(s){a(s(e))}function l(s,f=Ut){let c=[s,f];return r.add(c),r.size===1&&(n=t(a,i)||Ut),s(e),()=>{r.delete(c),r.size===0&&n&&(n(),n=null)}}return{set:a,update:i,subscribe:l}}function Vn(e){let t;return Gi(e,n=>t=n)(),t}var da=Symbol("unmounted");function vi(e,t,n){let r=n[t]??(n[t]={store:null,source:lo(void 0),unsubscribe:Ut});if(r.store!==e&&!(da in n))if(r.unsubscribe(),r.store=e??null,e==null)r.source.v=void 0,r.unsubscribe=Ut;else{var a=!0;r.unsubscribe=Gi(e,i=>{a?r.source.v=i:k(r.source,i)}),a=!1}return e&&da in n?Vn(e):o(r.source)}function ds(){let e={};function t(){Mr(()=>{for(var n in e)e[n].unsubscribe();Yn(e,da,{enumerable:!1,value:!0})})}return[e,t]}var ea=null,dn=null,D=null,va=null,rt=null,pa=null,Hn=!1,ta=!1,gn=null,br=null,pi=0;var vs=1,wn,Lt,Xt,_n,kn,Qt,xn,kt,qn,Me,Wn,Dt,ht,dt,En,Sn,Y,ga,jn,ba,qi,Wi,mr,ps,ma,pn,Ar=class Ar{constructor(){I(this,Y);$(this,"id",vs++);I(this,wn,!1);$(this,"linked",!0);I(this,Lt,null);I(this,Xt,null);$(this,"async_deriveds",new Map);$(this,"current",new Map);$(this,"previous",new Map);$(this,"unblocked",new Set);I(this,_n,new Set);I(this,kn,new Set);I(this,Qt,new Set);I(this,xn,0);I(this,kt,new Map);I(this,qn,null);I(this,Me,[]);I(this,Wn,[]);I(this,Dt,new Set);I(this,ht,new Set);I(this,dt,new Map);I(this,En,new Set);$(this,"is_fork",!1);I(this,Sn,!1)}skip_effect(t){h(this,dt).has(t)||h(this,dt).set(t,{d:[],m:[]}),h(this,En).delete(t)}unskip_effect(t,n=r=>this.schedule(r)){var r=h(this,dt).get(t);if(r){h(this,dt).delete(t);for(var a of r.d)ce(a,ye),n(a);for(a of r.m)ce(a,mt),n(a)}h(this,En).add(t)}capture(t,n,r=!1){t.v!==he&&!this.previous.has(t)&&this.previous.set(t,t.v),(t.f&Ft)===0&&(this.current.set(t,[n,r]),rt?.set(t,n)),this.is_fork||(t.v=n)}activate(){D=this}deactivate(){D=null,rt=null}flush(){try{ta=!0,D=this,M(this,Y,jn).call(this)}finally{pi=0,pa=null,gn=null,br=null,ta=!1,D=null,rt=null,an.clear()}}discard(){for(let t of h(this,kn))t(this);h(this,kn).clear(),h(this,Qt).clear(),M(this,Y,pn).call(this)}register_created_effect(t){h(this,Wn).push(t)}increment(t,n){if(T(this,xn,h(this,xn)+1),t){let r=h(this,kt).get(n)??0;h(this,kt).set(n,r+1)}}decrement(t,n){if(T(this,xn,h(this,xn)-1),t){let r=h(this,kt).get(n)??0;r===1?h(this,kt).delete(n):h(this,kt).set(n,r-1)}h(this,Sn)||(T(this,Sn,!0),$t(()=>{T(this,Sn,!1),this.linked&&this.flush()}))}transfer_effects(t,n){for(let r of t)h(this,Dt).add(r);for(let r of n)h(this,ht).add(r);t.clear(),n.clear()}oncommit(t){h(this,_n).add(t)}ondiscard(t){h(this,kn).add(t)}on_fork_commit(t){h(this,Qt).add(t)}run_fork_commit_callbacks(){for(let t of h(this,Qt))t(this);h(this,Qt).clear()}settled(){return(h(this,qn)??T(this,qn,Oi())).promise}static ensure(){var t;if(D===null){let n=D=new Ar;M(t=n,Y,ma).call(t),!ta&&!Hn&&$t(()=>{h(n,wn)||n.flush()})}return D}apply(){{rt=null;return}}schedule(t){if(pa=t,t.b?.is_pending&&(t.f&(Tn|Or|Ia))!==0&&(t.f&Ht)===0){t.b.defer_effect(t);return}for(var n=t;n.parent!==null;){n=n.parent;var r=n.f;if(gn!==null&&n===P&&(F===null||(F.f&_e)===0))return;if((r&(Tt|bt))!==0){if((r&be)===0)return;n.f^=be}}h(this,Me).push(n)}};wn=new WeakMap,Lt=new WeakMap,Xt=new WeakMap,_n=new WeakMap,kn=new WeakMap,Qt=new WeakMap,xn=new WeakMap,kt=new WeakMap,qn=new WeakMap,Me=new WeakMap,Wn=new WeakMap,Dt=new WeakMap,ht=new WeakMap,dt=new WeakMap,En=new WeakMap,Sn=new WeakMap,Y=new WeakSet,ga=function(){if(this.is_fork)return!0;for(let r of h(this,kt).keys()){for(var t=r,n=!1;t.parent!==null;){if(h(this,dt).has(t)){n=!0;break}t=t.parent}if(!n)return!0}return!1},jn=function(){var f,c,v;if(T(this,wn,!0),pi++>1e3&&(M(this,Y,pn).call(this),gs()),!M(this,Y,ga).call(this)){for(let p of h(this,Dt))h(this,ht).delete(p),ce(p,ye),this.schedule(p);for(let p of h(this,ht))ce(p,mt),this.schedule(p)}let t=h(this,Me);T(this,Me,[]),this.apply();var n=gn=[],r=[],a=br=[];for(let p of t)try{M(this,Y,ba).call(this,p,n,r)}catch(d){throw Xi(p),d}if(D=null,a.length>0){var i=Ar.ensure();for(let p of a)i.schedule(p)}if(gn=null,br=null,M(this,Y,ga).call(this)){M(this,Y,mr).call(this,r),M(this,Y,mr).call(this,n);for(let[p,d]of h(this,dt))Ji(p,d);a.length>0&&M(f=D,Y,jn).call(f);return}let l=M(this,Y,qi).call(this);if(l){M(c=l,Y,Wi).call(c,this);return}h(this,Dt).clear(),h(this,ht).clear();for(let p of h(this,_n))p(this);h(this,_n).clear(),va=this,gi(r),gi(n),va=null,h(this,qn)?.resolve();var s=D;if(this.linked&&h(this,xn)===0&&M(this,Y,pn).call(this),h(this,Me).length>0){s===null&&(s=this,M(this,Y,ma).call(this));let p=s;h(p,Me).push(...h(this,Me).filter(d=>!h(p,Me).includes(d)))}s!==null&&M(v=s,Y,jn).call(v)},ba=function(t,n,r){t.f^=be;for(var a=t.first;a!==null;){var i=a.f,l=(i&(bt|Tt))!==0,s=l&&(i&be)!==0,f=s||(i&Ze)!==0||h(this,dt).has(a);if(!f&&a.fn!==null){l?a.f^=be:(i&Tn)!==0?n.push(a):or(a)&&((i&nt)!==0&&h(this,ht).add(a),Rn(a));var c=a.first;if(c!==null){a=c;continue}}for(;a!==null;){var v=a.next;if(v!==null){a=v;break}a=a.parent}}},qi=function(){for(var t=h(this,Lt);t!==null;){if(!t.is_fork){for(let[n,[,r]]of this.current)if(t.current.has(n)&&!r)return t}t=h(t,Lt)}return null},Wi=function(t){var r;for(let[a,i]of t.current)!this.previous.has(a)&&t.previous.has(a)&&this.previous.set(a,t.previous.get(a)),this.current.set(a,i);for(let[a,i]of t.async_deriveds){let l=this.async_deriveds.get(a);l&&i.promise.then(l.resolve)}let n=a=>{var i=a.reactions;if(i!==null)for(let f of i){var l=f.f;if((l&_e)!==0)n(f);else{var s=f;l&(mn|nt)&&!this.async_deriveds.has(s)&&(h(this,ht).delete(s),ce(s,ye),this.schedule(s))}}};for(let a of this.current.keys())n(a);this.oncommit(()=>t.discard()),M(r=t,Y,pn).call(r),D=this,M(this,Y,jn).call(this)},mr=function(t){for(var n=0;n<t.length;n+=1)Yi(t[n],h(this,Dt),h(this,ht))},ps=function(){var v;M(this,Y,pn).call(this);for(let p=ea;p!==null;p=h(p,Xt)){var t=p.id<this.id,n=[];for(let[d,[m,b]]of this.current){if(p.current.has(d)){var r=p.current.get(d)[0];if(t&&m!==r)p.current.set(d,[m,b]);else continue}n.push(d)}if(t)for(let[d,m]of this.async_deriveds){let b=p.async_deriveds.get(d);b&&m.promise.then(b.resolve)}if(h(p,wn)){var a=[...p.current.keys()].filter(d=>!this.current.has(d));if(a.length===0)t&&p.discard();else if(n.length>0){if(t)for(let d of h(this,En))p.unskip_effect(d,m=>{var b;(m.f&(nt|mn))!==0?p.schedule(m):M(b=p,Y,mr).call(b,[m])});p.activate();var i=new Set,l=new Map;for(var s of n)Zi(s,a,i,l);l=new Map;var f=[...p.current.keys()].filter(d=>this.current.has(d)?this.current.get(d)[0]!==d.v:!0);if(f.length>0)for(let d of h(this,Wn))(d.f&(it|Ze|Er))===0&&Na(d,f,l)&&((d.f&(mn|nt))!==0?(ce(d,ye),p.schedule(d)):h(p,Dt).add(d));if(h(p,Me).length>0){p.apply();for(var c of h(p,Me))M(v=p,Y,ba).call(v,c,[],[]);T(p,Me,[])}p.deactivate()}}}},ma=function(){dn===null?ea=dn=this:(T(dn,Xt,this),T(this,Lt,dn)),dn=this},pn=function(){var t=h(this,Lt),n=h(this,Xt);t===null?ea=n:T(t,Xt,n),n===null?dn=t:T(n,Lt,t),this.linked=!1};var jt=Ar;function X(e){var t=Hn;Hn=!0;try{for(var n;;){if(as(),D===null)return n;D.flush()}}finally{Hn=t}}function gs(){try{Gl()}catch(e){Nt(e,pa)}}var _t=null;function gi(e){var t=e.length;if(t!==0){for(var n=0;n<t;){var r=e[n++];if((r.f&(it|Ze))===0&&or(r)&&(_t=new Set,Rn(r),r.deps===null&&r.first===null&&r.nodes===null&&r.teardown===null&&r.ac===null&&ko(r),_t?.size>0)){an.clear();for(let a of _t){if((a.f&(it|Ze))!==0)continue;let i=[a],l=a.parent;for(;l!==null;)_t.has(l)&&(_t.delete(l),i.push(l)),l=l.parent;for(let s=i.length-1;s>=0;s--){let f=i[s];(f.f&(it|Ze))===0&&Rn(f)}}_t.clear()}}_t=null}}function Zi(e,t,n,r){if(!n.has(e)&&(n.add(e),e.reactions!==null))for(let a of e.reactions){let i=a.f;(i&_e)!==0?Zi(a,t,n,r):(i&(mn|nt))!==0&&(i&ye)===0&&Na(a,t,r)&&(ce(a,ye),Ua(a))}}function Na(e,t,n){let r=n.get(e);if(r!==void 0)return r;if(e.deps!==null)for(let a of e.deps){if($n.call(t,a))return!0;if((a.f&_e)!==0&&Na(a,t,n))return n.set(a,!0),!0}return n.set(e,!1),!1}function Ua(e){D.schedule(e)}function Ji(e,t){if(!((e.f&bt)!==0&&(e.f&be)!==0)){(e.f&ye)!==0?t.d.push(e):(e.f&mt)!==0&&t.m.push(e),ce(e,be);for(var n=e.first;n!==null;)Ji(n,t),n=n.next}}function Xi(e){ce(e,be);for(var t=e.first;t!==null;)Xi(t),t=t.next}function bs(e){let t=0,n=ir(0),r;return()=>{ja()&&(o(n),Nr(()=>(t===0&&(r=lr(()=>e(()=>Bn(n)))),t+=1,()=>{$t(()=>{t-=1,t===0&&(r?.(),r=void 0,Bn(n))})})))}}var ms=Vt|un;function ys(e,t,n,r){new ya(e,t,n,r)}var Ne,Zn,Ye,en,Ae,Ge,Se,Ue,xt,tn,Mt,Cn,Jn,Xn,Et,Rr,te,Qi,eo,to,wa,yr,wr,_a,ka,ya=class{constructor(t,n,r,a){I(this,te);$(this,"parent");$(this,"is_pending",!1);$(this,"transform_error");I(this,Ne);I(this,Zn,L?z:null);I(this,Ye);I(this,en);I(this,Ae);I(this,Ge,null);I(this,Se,null);I(this,Ue,null);I(this,xt,null);I(this,tn,0);I(this,Mt,0);I(this,Cn,!1);I(this,Jn,new Set);I(this,Xn,new Set);I(this,Et,null);I(this,Rr,bs(()=>(T(this,Et,ir(h(this,tn))),()=>{T(this,Et,null)})));T(this,Ne,t),T(this,Ye,n),T(this,en,i=>{var l=P;l.b=this,l.f|=la,r(i)}),this.parent=P.b,this.transform_error=a??this.parent?.transform_error??(i=>i),T(this,Ae,sr(()=>{if(L){let i=h(this,Zn);cn();let l=i.data===Di;if(i.data.startsWith(hi)){let f=JSON.parse(i.data.slice(hi.length));M(this,te,eo).call(this,f)}else l?M(this,te,to).call(this):M(this,te,Qi).call(this)}else M(this,te,wa).call(this)},ms)),L&&T(this,Ne,z)}defer_effect(t){Yi(t,h(this,Jn),h(this,Xn))}is_rendered(){return!this.is_pending&&(!this.parent||this.parent.is_rendered())}has_pending_snippet(){return!!h(this,Ye).pending}update_pending_count(t,n){M(this,te,_a).call(this,t,n),T(this,tn,h(this,tn)+t),!(!h(this,Et)||h(this,Cn))&&(T(this,Cn,!0),$t(()=>{T(this,Cn,!1),h(this,Et)&&Tr(h(this,Et),h(this,tn))}))}get_effect_pending(){return h(this,Rr).call(this),o(h(this,Et))}error(t){if(!h(this,Ye).onerror&&!h(this,Ye).failed)throw t;D?.is_fork?(h(this,Ge)&&D.skip_effect(h(this,Ge)),h(this,Se)&&D.skip_effect(h(this,Se)),h(this,Ue)&&D.skip_effect(h(this,Ue)),D.on_fork_commit(()=>{M(this,te,ka).call(this,t)})):M(this,te,ka).call(this,t)}};Ne=new WeakMap,Zn=new WeakMap,Ye=new WeakMap,en=new WeakMap,Ae=new WeakMap,Ge=new WeakMap,Se=new WeakMap,Ue=new WeakMap,xt=new WeakMap,tn=new WeakMap,Mt=new WeakMap,Cn=new WeakMap,Jn=new WeakMap,Xn=new WeakMap,Et=new WeakMap,Rr=new WeakMap,te=new WeakSet,Qi=function(){try{T(this,Ge,tt(()=>h(this,en).call(this,h(this,Ne))))}catch(t){this.error(t)}},eo=function(t){let n=h(this,Ye).failed;n&&T(this,Ue,tt(()=>{n(h(this,Ne),()=>t,()=>()=>{})}))},to=function(){let t=h(this,Ye).pending;t&&(this.is_pending=!0,T(this,Se,tt(()=>t(h(this,Ne)))),$t(()=>{var n=T(this,xt,document.createDocumentFragment()),r=ot();n.append(r),T(this,Ge,M(this,te,wr).call(this,()=>tt(()=>h(this,en).call(this,r)))),h(this,Mt)===0&&(h(this,Ne).before(n),T(this,xt,null),Kn(h(this,Se),()=>{T(this,Se,null)}),M(this,te,yr).call(this,D))}))},wa=function(){try{if(this.is_pending=this.has_pending_snippet(),T(this,Mt,0),T(this,tn,0),T(this,Ge,tt(()=>{h(this,en).call(this,h(this,Ne))})),h(this,Mt)>0){var t=T(this,xt,document.createDocumentFragment());So(h(this,Ge),t);let n=h(this,Ye).pending;T(this,Se,tt(()=>n(h(this,Ne))))}else M(this,te,yr).call(this,D)}catch(n){this.error(n)}},yr=function(t){this.is_pending=!1,t.transfer_effects(h(this,Jn),h(this,Xn))},wr=function(t){var n=P,r=F,a=Ie;yt(h(this,Ae)),Xe(h(this,Ae)),An(h(this,Ae).ctx);try{return jt.ensure(),t()}catch(i){return Bi(i),null}finally{yt(n),Xe(r),An(a)}},_a=function(t,n){var r;if(!this.has_pending_snippet()){this.parent&&M(r=this.parent,te,_a).call(r,t,n);return}T(this,Mt,h(this,Mt)+t),h(this,Mt)===0&&(M(this,te,yr).call(this,n),h(this,Se)&&Kn(h(this,Se),()=>{T(this,Se,null)}),h(this,xt)&&(h(this,Ne).before(h(this,xt)),T(this,xt,null)))},ka=function(t){h(this,Ge)&&(we(h(this,Ge)),T(this,Ge,null)),h(this,Se)&&(we(h(this,Se)),T(this,Se,null)),h(this,Ue)&&(we(h(this,Ue)),T(this,Ue,null)),L&&(Ce(h(this,Zn)),Pa(),Ce(La()));var n=h(this,Ye).onerror;let r=h(this,Ye).failed;var a=!1,i=!1;let l=()=>{if(a){ls();return}a=!0,i&&Xl(),h(this,Ue)!==null&&Kn(h(this,Ue),()=>{T(this,Ue,null)}),M(this,te,wr).call(this,()=>{M(this,te,wa).call(this)})},s=f=>{try{i=!0,n?.(f,l),i=!1}catch(c){Nt(c,h(this,Ae)&&h(this,Ae).parent)}r&&T(this,Ue,M(this,te,wr).call(this,()=>{try{return tt(()=>{var c=P;c.b=this,c.f|=la,r(h(this,Ne),()=>f,()=>l)})}catch(c){return Nt(c,h(this,Ae).parent),null}}))};$t(()=>{var f;try{f=this.transform_error(t)}catch(c){Nt(c,h(this,Ae)&&h(this,Ae).parent);return}f!==null&&typeof f=="object"&&typeof f.then=="function"?f.then(s,c=>Nt(c,h(this,Ae)&&h(this,Ae).parent)):s(f)})};function no(e,t,n,r){let a=Fa;var i=e.filter(d=>!d.settled);if(n.length===0&&i.length===0){r(t.map(a));return}var l=P,s=ws(),f=i.length===1?i[0].promise:i.length>1?Promise.all(i.map(d=>d.promise)):null;function c(d){if((l.f&it)===0){s();try{r(d)}catch(m){Nt(m,l)}Cr()}}var v=ro();if(n.length===0){f.then(()=>c(t.map(a))).finally(v);return}function p(){Promise.all(n.map(d=>_s(d))).then(d=>c([...t.map(a),...d])).catch(d=>Nt(d,l)).finally(v)}f?f.then(()=>{s(),p(),Cr()}):p()}function ws(){var e=P,t=F,n=Ie,r=D;return function(i=!0){yt(e),Xe(t),An(n),i&&(e.f&it)===0&&(r?.activate(),r?.apply())}}function Cr(e=!0){yt(null),Xe(null),An(null),e&&D?.deactivate()}function ro(){var e=P,t=e.b,n=D,r=t.is_rendered();return t.update_pending_count(1,n),n.increment(r,e),()=>{t.update_pending_count(-1,n),n.decrement(r,e)}}function Fa(e){var t=_e|ye;return P!==null&&(P.f|=un),{ctx:Ie,deps:null,effects:null,equals:Pi,f:t,fn:e,reactions:null,rv:0,v:he,wv:0,parent:P,ac:null}}var dr=Symbol("obsolete");function _s(e,t,n){let r=P;r===null&&Hl();var a=void 0,i=ir(he),l=!F,s=new Set;return Ps(()=>{var f=P,c=Oi();a=c.promise;try{Promise.resolve(e()).then(c.resolve,m=>{m!==Pr&&c.reject(m)}).finally(Cr)}catch(m){c.reject(m),Cr()}var v=D;if(l){if((f.f&Ht)!==0)var p=ro();if(r.b.is_rendered())v.async_deriveds.get(f)?.reject(dr);else for(let m of s.values())m.reject(dr);s.add(c),v.async_deriveds.set(f,c)}let d=(m,b=void 0)=>{p?.(),s.delete(c),b!==dr&&(v.activate(),b?(i.f|=Ft,Tr(i,b)):((i.f&Ft)!==0&&(i.f^=Ft),Tr(i,m)),v.deactivate())};c.promise.then(d,m=>d(null,m||"unknown"))}),Mr(()=>{for(let f of s)f.reject(dr)}),new Promise(f=>{function c(v){function p(){v===a?f(i):c(a)}v.then(p,p)}c(a)})}function Ee(e){let t=Fa(e);return uo(t),t}function ks(e){var t=e.effects;if(t!==null){e.effects=null;for(var n=0;n<t.length;n+=1)we(t[n])}}function Va(e){var t,n=P,r=e.parent;if(!At&&r!==null&&e.v!==he&&(r.f&(it|Ze))!==0)return is(),e.v;yt(r);try{e.f&=~ln,ks(e),t=po(e)}finally{yt(n)}return t}function ao(e){var t=Va(e);if(!e.equals(t)&&(e.wv=ho(),(!D?.is_fork||e.deps===null)&&(D!==null?(D.capture(e,t,!0),va?.capture(e,t,!0)):e.v=t,e.deps===null))){ce(e,be);return}At||(rt!==null?(ja()||D?.is_fork)&&rt.set(e,t):Ma(e))}function xs(e){if(e.effects!==null)for(let t of e.effects)(t.teardown||t.ac)&&(t.teardown?.(),t.ac?.abort(Pr),t.fn!==null&&(t.teardown=Ut),t.ac=null,Gn(t,0),Ha(t))}function io(e){if(e.effects!==null)for(let t of e.effects)t.teardown&&t.fn!==null&&Rn(t)}var $r=new Set,an=new Map,oo=!1;function ir(e,t){var n={f:0,v:e,reactions:null,equals:Pi,rv:0,wv:0};return n}function N(e,t){let n=ir(e);return uo(n),n}function lo(e,t=!1,n=!0){let r=ir(e);return t||(r.equals=jl),r}function k(e,t,n=!1){F!==null&&(!at||(F.f&Er)!==0)&&Ui()&&(F.f&(_e|nt|mn|Er))!==0&&(Je===null||!$n.call(Je,e))&&Jl();let r=n?Ct(t):t;return Tr(e,r,br)}function Tr(e,t,n=null){if(!e.equals(t)){an.set(e,At?t:e.v);var r=jt.ensure();if(r.capture(e,t),(e.f&_e)!==0){let a=e;(e.f&ye)!==0&&Va(a),rt===null&&Ma(a)}e.wv=ho(),so(e,ye,n),P!==null&&(P.f&be)!==0&&(P.f&(bt|Tt))===0&&(Ke===null?$s([e]):Ke.push(e)),!r.is_fork&&$r.size>0&&!oo&&Es()}return t}function Es(){oo=!1;for(let e of $r){(e.f&be)!==0&&ce(e,mt);let t;try{t=or(e)}catch{t=!0}t&&Rn(e)}$r.clear()}function Bn(e){k(e,e.v+1)}function so(e,t,n){var r=e.reactions;if(r!==null)for(var a=r.length,i=0;i<a;i++){var l=r[i],s=l.f,f=(s&ye)===0;if(f&&ce(l,t),(s&Er)!==0)$r.add(l);else if((s&_e)!==0){var c=l;rt?.delete(c),(s&ln)===0&&(s&We&&(P===null||(P.f&Sr)===0)&&(l.f|=ln),so(c,mt,n))}else if(f){var v=l;(s&nt)!==0&&_t!==null&&_t.add(v),n!==null?n.push(v):Ua(v)}}}function Ss(e,t){if(t){let n=document.body;e.autofocus=!0,$t(()=>{document.activeElement===n&&e.focus()})}}var bi=!1;function co(){bi||(bi=!0,document.addEventListener("reset",e=>{Promise.resolve().then(()=>{if(!e.defaultPrevented)for(let t of e.target.elements)t[zn]?.()})},{capture:!0}))}function Dr(e){var t=F,n=P;Xe(null),yt(null);try{return e()}finally{Xe(t),yt(n)}}function Cs(e,t,n,r=n){e.addEventListener(t,()=>Dr(n));let a=e[zn];a?e[zn]=()=>{a(),r(!0)}:e[zn]=()=>r(!0),co()}var _r=!1,At=!1;function mi(e){At=e}var F=null,at=!1;function Xe(e){F=e}var P=null;function yt(e){P=e}var Je=null;function uo(e){F!==null&&(Je===null?Je=[e]:Je.push(e))}var Re=null,Le=0,Ke=null;function $s(e){Ke=e}var fo=1,Wt=0,on=Wt;function yi(e){on=e}function ho(){return++fo}function or(e){var t=e.f;if((t&ye)!==0)return!0;if(t&_e&&(e.f&=~ln),(t&mt)!==0){for(var n=e.deps,r=n.length,a=0;a<r;a++){var i=n[a];if(or(i)&&ao(i),i.wv>e.wv)return!0}(t&We)!==0&&rt===null&&ce(e,be)}return!1}function vo(e,t,n=!0){var r=e.reactions;if(r!==null&&!(Je!==null&&$n.call(Je,e)))for(var a=0;a<r.length;a++){var i=r[a];(i.f&_e)!==0?vo(i,t,!1):t===i&&(n?ce(i,ye):(i.f&be)!==0&&ce(i,mt),Ua(i))}}function po(e){var A;var t=Re,n=Le,r=Ke,a=F,i=Je,l=Ie,s=at,f=on,c=e.f;Re=null,Le=0,Ke=null,F=(c&(bt|Tt))===0?e:null,Je=null,An(e.ctx),at=!1,on=++Wt,e.ac!==null&&(Dr(()=>{e.ac.abort(Pr)}),e.ac=null);try{e.f|=Sr;var v=e.fn,p=v();e.f|=Ht;var d=e.deps,m=D?.is_fork;if(Re!==null){var b;if(m||Gn(e,Le),d!==null&&Le>0)for(d.length=Le+Re.length,b=0;b<Re.length;b++)d[Le+b]=Re[b];else e.deps=d=Re;if(ja()&&(e.f&We)!==0)for(b=Le;b<d.length;b++)((A=d[b]).reactions??(A.reactions=[])).push(e)}else!m&&d!==null&&Le<d.length&&(Gn(e,Le),d.length=Le);if(Ui()&&Ke!==null&&!at&&d!==null&&(e.f&(_e|mt|ye))===0)for(b=0;b<Ke.length;b++)vo(Ke[b],e);if(a!==null&&a!==e){if(Wt++,a.deps!==null)for(let C=0;C<n;C+=1)a.deps[C].rv=Wt;if(t!==null)for(let C of t)C.rv=Wt;Ke!==null&&(r===null?r=Ke:r.push(...Ke))}return(e.f&Ft)!==0&&(e.f^=Ft),p}catch(C){return Bi(C)}finally{e.f^=Sr,Re=t,Le=n,Ke=r,F=a,Je=i,An(l),at=s,on=f}}function Ts(e,t){let n=t.reactions;if(n!==null){var r=Il.call(n,e);if(r!==-1){var a=n.length-1;a===0?n=t.reactions=null:(n[r]=n[a],n.pop())}}if(n===null&&(t.f&_e)!==0&&(Re===null||!$n.call(Re,t))){var i=t;(i.f&We)!==0&&(i.f^=We,i.f&=~ln),i.v!==he&&Ma(i),xs(i),Gn(i,0)}}function Gn(e,t){var n=e.deps;if(n!==null)for(var r=t;r<n.length;r++)Ts(e,n[r])}function Rn(e){var t=e.f;if((t&it)===0){ce(e,be);var n=P,r=_r;P=e,_r=!0;try{(t&(nt|Ia))!==0?Ls(e):Ha(e),wo(e);var a=po(e);e.teardown=typeof a=="function"?a:null,e.wv=fo;var i}finally{_r=r,P=n}}}async function Zt(){await Promise.resolve(),X()}function o(e){var t=e.f,n=(t&_e)!==0;if(F!==null&&!at){var r=P!==null&&(P.f&it)!==0;if(!r&&(Je===null||!$n.call(Je,e))){var a=F.deps;if((F.f&Sr)!==0)e.rv<Wt&&(e.rv=Wt,Re===null&&a!==null&&a[Le]===e?Le++:Re===null?Re=[e]:Re.push(e));else{(F.deps??(F.deps=[])).push(e);var i=e.reactions;i===null?e.reactions=[F]:$n.call(i,F)||i.push(F)}}}if(At&&an.has(e))return an.get(e);if(n){var l=e;if(At){var s=l.v;return((l.f&be)===0&&l.reactions!==null||bo(l))&&(s=Va(l)),an.set(l,s),s}var f=(l.f&We)===0&&!at&&F!==null&&(_r||(F.f&We)!==0),c=(l.f&Ht)===0;or(l)&&(f&&(l.f|=We),ao(l)),f&&!c&&(io(l),go(l))}if(rt?.has(e))return rt.get(e);if((e.f&Ft)!==0)throw e.v;return e.v}function go(e){if(e.f|=We,e.deps!==null)for(let t of e.deps)(t.reactions??(t.reactions=[])).push(e),(t.f&_e)!==0&&(t.f&We)===0&&(io(t),go(t))}function bo(e){if(e.v===he)return!0;if(e.deps===null)return!1;for(let t of e.deps)if(an.has(t)||(t.f&_e)!==0&&bo(t))return!0;return!1}function lr(e){var t=at;try{return at=!0,e()}finally{at=t}}function As(e){P===null&&(F===null&&Yl(),Kl()),At&&Bl()}function Rs(e,t){var n=t.last;n===null?t.last=t.first=e:(n.next=e,e.prev=n,t.last=e)}function lt(e,t){var n=P;n!==null&&(n.f&Ze)!==0&&(e|=Ze);var r={ctx:Ie,deps:null,nodes:null,f:e|ye|We,first:null,fn:t,last:null,next:null,parent:n,b:n&&n.b,prev:null,teardown:null,wv:0,ac:null};D?.register_created_effect(r);var a=r;if((e&Tn)!==0)gn!==null?gn.push(r):jt.ensure().schedule(r);else if(t!==null){try{Rn(r)}catch(l){throw we(r),l}a.deps===null&&a.teardown===null&&a.nodes===null&&a.first===a.last&&(a.f&un)===0&&(a=a.first,(e&nt)!==0&&(e&Vt)!==0&&a!==null&&(a.f|=Vt))}if(a!==null&&(a.parent=n,n!==null&&Rs(a,n),F!==null&&(F.f&_e)!==0&&(e&Tt)===0)){var i=F;(i.effects??(i.effects=[])).push(a)}return r}function ja(){return F!==null&&!at}function Mr(e){let t=lt(Or,null);return ce(t,be),t.teardown=e,t}function De(e){As();var t=P.f,n=!F&&(t&bt)!==0&&(t&Ht)===0;if(n){var r=Ie;(r.e??(r.e=[])).push(e)}else return mo(e)}function mo(e){return lt(Tn|Ul,e)}function Is(e){jt.ensure();let t=lt(Tt|un,e);return()=>{we(t)}}function Os(e){jt.ensure();let t=lt(Tt|un,e);return(n={})=>new Promise(r=>{n.outro?Kn(t,()=>{we(t),r(void 0)}):(we(t),r(void 0))})}function za(e){return lt(Tn,e)}function Ps(e){return lt(mn|un,e)}function Nr(e,t=0){return lt(Or|t,e)}function ke(e,t=[],n=[],r=[]){no(r,t,n,a=>{lt(Or,()=>e(...a.map(o)))})}function sr(e,t=0){var n=lt(nt|t,e);return n}function yo(e,t=0){var n=lt(Ia|t,e);return n}function tt(e){return lt(bt|un,e)}function wo(e){var t=e.teardown;if(t!==null){let n=At,r=F;mi(!0),Xe(null);try{t.call(null)}finally{mi(n),Xe(r)}}}function Ha(e,t=!1){var n=e.first;for(e.first=e.last=null;n!==null;){let a=n.ac;a!==null&&Dr(()=>{a.abort(Pr)});var r=n.next;(n.f&Tt)!==0?n.parent=null:we(n,t),n=r}}function Ls(e){for(var t=e.first;t!==null;){var n=t.next;(t.f&bt)===0&&we(t),t=n}}function we(e,t=!0){var n=!1;(t||(e.f&Nl)!==0)&&e.nodes!==null&&e.nodes.end!==null&&(_o(e.nodes.start,e.nodes.end),n=!0),ce(e,sa),Ha(e,t&&!n),Gn(e,0);var r=e.nodes&&e.nodes.t;if(r!==null)for(let i of r)i.stop();wo(e),e.f^=sa,e.f|=it;var a=e.parent;a!==null&&a.first!==null&&ko(e),e.next=e.prev=e.teardown=e.ctx=e.deps=e.fn=e.nodes=e.ac=e.b=null}function _o(e,t){for(;e!==null;){var n=e===t?null:wt(e);e.remove(),e=n}}function ko(e){var t=e.parent,n=e.prev,r=e.next;n!==null&&(n.next=r),r!==null&&(r.prev=n),t!==null&&(t.first===e&&(t.first=r),t.last===e&&(t.last=n))}function Kn(e,t,n=!0){var r=[];xo(e,r,!0);var a=()=>{n&&we(e),t&&t()},i=r.length;if(i>0){var l=()=>--i||a();for(var s of r)s.out(l)}else a()}function xo(e,t,n){if((e.f&Ze)===0){e.f^=Ze;var r=e.nodes&&e.nodes.t;if(r!==null)for(let s of r)(s.is_global||n)&&t.push(s);for(var a=e.first;a!==null;){var i=a.next;if((a.f&Tt)===0){var l=(a.f&Vt)!==0||(a.f&bt)!==0&&(e.f&nt)!==0;xo(a,t,l?n:!1)}a=i}}}function Ds(e){Eo(e,!0)}function Eo(e,t){if((e.f&Ze)!==0){e.f^=Ze,(e.f&be)===0&&(ce(e,ye),jt.ensure().schedule(e));for(var n=e.first;n!==null;){var r=n.next,a=(n.f&Vt)!==0||(n.f&bt)!==0;Eo(n,a?t:!1),n=r}var i=e.nodes&&e.nodes.t;if(i!==null)for(let l of i)(l.is_global||t)&&l.in()}}function So(e,t){if(e.nodes)for(var n=e.nodes.start,r=e.nodes.end;n!==null;){var a=n===r?null:wt(n);t.append(n),n=a}}function wi(e){let t={get:n=>Vn(t.store)[n],set:(n,r)=>{typeof n=="string"?Object.assign(Vn(t.store),{[n]:r}):Object.assign(Vn(t.store),n),t.store.set(Vn(t.store))},store:hs(e)};return t}globalThis.$altcha=globalThis.$altcha||{algorithms:new Map,defaults:wi({}),i18n:wi({}),instances:new Set,plugins:new Set};var Ms={ariaLinkLabel:"Altcha (official website)",cancel:"Cancel",enterCode:"Enter code",enterCodeAria:"Enter code you hear. Press Space to play audio.",enterCodeFromImage:"To proceed, please enter the code from the image below.",error:"Verification failed. Try again later.",expired:"Verification expired. Try again.",footer:'Protected by <a href="https://altcha.org/" tabindex="-1" target="_blank" aria-label="Altcha (official website)">ALTCHA</a>',getAudioChallenge:"Get an audio challenge",label:"I'm not a robot",loading:"Loading...",reload:"Reload",verify:"Verify",verificationRequired:"Verification required!",verified:"Verified",verifying:"Verifying...",waitAlert:"Verifying... please wait."};"$altcha"in globalThis&&globalThis.$altcha.i18n.set("en",Ms);var Ns="5",Ai;typeof window<"u"&&((Ai=window.__svelte??(window.__svelte={})).v??(Ai.v=new Set)).add(Ns);var Jt=Symbol("events"),Co=new Set,xa=new Set;function $o(e,t,n,r={}){function a(i){if(r.capture||Ea.call(t,i),!i.cancelBubble)return Dr(()=>n?.call(this,i))}return e.startsWith("pointer")||e.startsWith("touch")||e==="wheel"?$t(()=>{t.addEventListener(e,a,r)}):t.addEventListener(e,a,r),a}function ge(e,t,n,r,a){var i={capture:r,passive:a},l=$o(e,t,n,i);(t===document.body||t===window||t===document||t instanceof HTMLMediaElement)&&Mr(()=>{t.removeEventListener(e,l,i)})}function Ur(e,t,n){(t[Jt]??(t[Jt]={}))[e]=n}function Fr(e){for(var t=0;t<e.length;t++)Co.add(e[t]);for(var n of xa)n(e)}var _i=null;function Ea(e){var t=this,n=t.ownerDocument,r=e.type,a=e.composedPath?.()||[],i=a[0]||e.target;_i=e;var l=0,s=_i===e&&e[Jt];if(s){var f=a.indexOf(s);if(f!==-1&&(t===document||t===window)){e[Jt]=t;return}var c=a.indexOf(t);if(c===-1)return;f<=c&&(l=f)}if(i=a[l]||e.target,i!==t){Yn(e,"currentTarget",{configurable:!0,get(){return i||n}});var v=F,p=P;Xe(null),yt(null);try{for(var d,m=[];i!==null;){var b=i.assignedSlot||i.parentNode||i.host||null;try{var A=i[Jt]?.[r];A!=null&&(!i.disabled||e.target===i)&&A.call(i,e)}catch(C){d?m.push(C):d=C}if(e.cancelBubble||b===t||b===null)break;i=b}if(d){for(let C of m)queueMicrotask(()=>{throw C});throw d}}finally{e[Jt]=t,delete e.currentTarget,Xe(v),yt(p)}}}var Us=globalThis?.window?.trustedTypes&&globalThis.window.trustedTypes.createPolicy("svelte-trusted-html",{createHTML:e=>e});function Fs(e){return Us?.createHTML(e)??e}function To(e){var t=Da("template");return t.innerHTML=Fs(e.replaceAll("<!>","<!---->")),t.content}function je(e,t){var n=P;n.nodes===null&&(n.nodes={start:e,end:t,a:null,t:null})}function ae(e,t){var n=(t&Ql)!==0,r=(t&es)!==0,a,i=!e.startsWith("<!>");return()=>{if(L)return je(z,null),z;a===void 0&&(a=To(i?e:"<!>"+e),n||(a=Ve(a)));var l=r||ji?document.importNode(a,!0):a.cloneNode(!0);if(n){var s=Ve(l),f=l.lastChild;je(s,f)}else je(l,l);return l}}function Vs(e,t,n="svg"){var r=!e.startsWith("<!>"),a=`<${n}>${r?e:"<!>"+e}</${n}>`,i;return()=>{if(L)return je(z,null),z;if(!i){var l=To(a),s=Ve(l);i=Ve(s)}var f=i.cloneNode(!0);return je(f,f),f}}function Ba(e,t){return Vs(e,t,"svg")}function vr(e=""){if(!L){var t=ot(e+"");return je(t,t),t}var n=z;return n.nodeType!==nr?(n.before(n=ot()),Ce(n)):Lr(n),je(n,n),n}function ki(){if(L)return je(z,null),z;var e=document.createDocumentFragment(),t=document.createComment(""),n=ot();return e.append(t,n),je(t,n),e}function j(e,t){if(L){var n=P;((n.f&Ht)===0||n.nodes.end===null)&&(n.nodes.end=z),cn();return}e!==null&&e.before(t)}function js(e){return e.endsWith("capture")&&e!=="gotpointercapture"&&e!=="lostpointercapture"}var zs=["beforeinput","click","change","dblclick","contextmenu","focusin","focusout","input","keydown","keyup","mousedown","mousemove","mouseout","mouseover","mouseup","pointerdown","pointermove","pointerout","pointerover","pointerup","touchend","touchmove","touchstart"];function Hs(e){return zs.includes(e)}var Bs={formnovalidate:"formNoValidate",ismap:"isMap",nomodule:"noModule",playsinline:"playsInline",readonly:"readOnly",defaultvalue:"defaultValue",defaultchecked:"defaultChecked",srcobject:"srcObject",novalidate:"noValidate",allowfullscreen:"allowFullscreen",disablepictureinpicture:"disablePictureInPicture",disableremoteplayback:"disableRemotePlayback"};function Ks(e){return e=e.toLowerCase(),Bs[e]??e}var Ys=["touchstart","touchmove"];function Gs(e){return Ys.includes(e)}function pt(e,t){var n=t==null?"":typeof t=="object"?`${t}`:t;n!==(e[Fn]??(e[Fn]=e.nodeValue))&&(e[Fn]=n,e.nodeValue=`${n}`)}function Ao(e,t){return Ro(e,t)}function qs(e,t){ha(),t.intro=t.intro??!1;let n=t.target,r=L,a=z;try{for(var i=Ve(n);i&&(i.nodeType!==rr||i.data!==Oa);)i=wt(i);if(!i)throw sn;gt(!0),Ce(i);let l=Ro(e,{...t,anchor:i});return gt(!1),l}catch(l){if(l instanceof Error&&l.message.split(`
`).some(s=>s.startsWith("https://svelte.dev/e/")))throw l;return l!==sn&&console.warn("Failed to hydrate: ",l),t.recover===!1&&ql(),ha(),cs(n),gt(!1),Ao(e,t)}finally{gt(r),Ce(a)}}var pr=new Map;function Ro(e,{target:t,anchor:n,props:r={},events:a,context:i,intro:l=!0,transformError:s}){ha();var f=void 0,c=Os(()=>{var v=n??t.appendChild(ot());ys(v,{pending:()=>{}},m=>{Rt({});var b=Ie;if(i&&(b.c=i),a&&(r.$$events=a),L&&je(m,null),f=e(m,r)||{},L&&(P.nodes.end=z,z===null||z.nodeType!==rr||z.data!==Mi))throw ar(),sn;It()},s);var p=new Set,d=m=>{for(var b=0;b<m.length;b++){var A=m[b];if(!p.has(A)){p.add(A);var C=Gs(A);for(let ue of[t,document]){var U=pr.get(ue);U===void 0&&(U=new Map,pr.set(ue,U));var de=U.get(A);de===void 0?(ue.addEventListener(A,Ea,{passive:C}),U.set(A,1)):U.set(A,de+1)}}}};return d(Ol(Co)),xa.add(d),()=>{for(var m of p)for(let C of[t,document]){var b=pr.get(C),A=b.get(m);--A==0?(C.removeEventListener(m,Ea),b.delete(m),b.size===0&&pr.delete(C)):b.set(m,A)}xa.delete(d),v!==n&&v.parentNode?.removeChild(v)}});return Sa.set(f,c),f}var Sa=new WeakMap;function Ws(e,t){let n=Sa.get(e);return n?(Sa.delete(e),n(t)):Promise.resolve()}var et,vt,Fe,nn,Qn,er,Ir,In=class{constructor(t,n=!0){$(this,"anchor");I(this,et,new Map);I(this,vt,new Map);I(this,Fe,new Map);I(this,nn,new Set);I(this,Qn,!0);I(this,er,t=>{if(h(this,et).has(t)){var n=h(this,et).get(t),r=h(this,vt).get(n);if(r)Ds(r),h(this,nn).delete(n);else{var a=h(this,Fe).get(n);a&&(h(this,vt).set(n,a.effect),h(this,Fe).delete(n),a.fragment.lastChild.remove(),this.anchor.before(a.fragment),r=a.effect)}for(let[i,l]of h(this,et)){if(h(this,et).delete(i),i===t)break;let s=h(this,Fe).get(l);s&&(we(s.effect),h(this,Fe).delete(l))}for(let[i,l]of h(this,vt)){if(i===n||h(this,nn).has(i))continue;let s=()=>{if(Array.from(h(this,et).values()).includes(i)){var c=document.createDocumentFragment();So(l,c),c.append(ot()),h(this,Fe).set(i,{effect:l,fragment:c})}else we(l);h(this,nn).delete(i),h(this,vt).delete(i)};h(this,Qn)||!r?(h(this,nn).add(i),Kn(l,s,!1)):s()}}});I(this,Ir,t=>{h(this,et).delete(t);let n=Array.from(h(this,et).values());for(let[r,a]of h(this,Fe))n.includes(r)||(we(a.effect),h(this,Fe).delete(r))});this.anchor=t,T(this,Qn,n)}ensure(t,n){var r=D,a=us();if(n&&!h(this,vt).has(t)&&!h(this,Fe).has(t))if(a){var i=document.createDocumentFragment(),l=ot();i.append(l),h(this,Fe).set(t,{effect:tt(()=>n(l)),fragment:i})}else h(this,vt).set(t,tt(()=>n(this.anchor)));if(h(this,et).set(r,t),a){for(let[s,f]of h(this,vt))s===t?r.unskip_effect(f):r.skip_effect(f);for(let[s,f]of h(this,Fe))s===t?r.unskip_effect(f.effect):r.skip_effect(f.effect);r.oncommit(h(this,er)),r.ondiscard(h(this,Ir))}else L&&(this.anchor=z),h(this,er).call(this,r)}};et=new WeakMap,vt=new WeakMap,Fe=new WeakMap,nn=new WeakMap,Qn=new WeakMap,er=new WeakMap,Ir=new WeakMap;function Zs(e,t,...n){var r=new In(e);sr(()=>{let a=t()??null;r.ensure(a,a&&(i=>a(i,...n)))},Vt)}function Ka(e){Ie===null&&zl(),De(()=>{let t=lr(e);if(typeof t=="function")return t})}function pe(e,t,n=!1){var r;L&&(r=z,cn());var a=new In(e),i=n?Vt:0;function l(s,f){if(L){var c=Vi(r);if(s!==parseInt(c.substring(1))){var v=La();Ce(v),a.anchor=v,gt(!1),a.ensure(s,f),gt(!0);return}}a.ensure(s,f)}sr(()=>{var s=!1;t((f,c=0)=>{s=!0,l(c,f)}),s||l(-1,null)},i)}var Js=Symbol("NaN");function Xs(e,t,n){L&&cn();var r=new In(e);sr(()=>{var a=t();a!==a&&(a=Js),r.ensure(a,n)})}function Io(e,t,n=!1,r=!1,a=!1,i=!1){var l=e,s="";if(n){var f=e;L&&(l=Ce(Ve(f)))}ke(()=>{var c=P;if(s===(s=t()??"")){L&&cn();return}if(n&&!L){c.nodes=null,f.innerHTML=s,s!==""&&je(Ve(f),f.lastChild);return}if(c.nodes!==null&&(_o(c.nodes.start,c.nodes.end),c.nodes=null),s!==""){if(L){z.data;for(var v=cn(),p=v;v!==null&&(v.nodeType!==rr||v.data!=="");)p=v,v=wt(v);if(v===null)throw ar(),sn;je(z,p),l=Ce(v);return}var d=r?ts:a?ns:void 0,m=Da(r?"svg":a?"math":"template",d);m.innerHTML=s;var b=r||a?m:m.content;if(je(Ve(b),b.lastChild),r||a)for(;Ve(b);)l.before(Ve(b));else l.before(b)}})}function Qs(e,t,n){var r;L&&(r=z,cn());var a=new In(e);sr(()=>{var i=t()??null;if(L){var l=Vi(r),s=l===Oa,f=i!==null;if(s!==f){var c=La();Ce(c),a.anchor=c,gt(!1),a.ensure(i,i&&(v=>n(v,i))),gt(!0);return}}a.ensure(i,i&&(v=>n(v,i)))},Vt)}function ec(e,t){var n=void 0,r;yo(()=>{n!==(n=t())&&(r&&(we(r),r=null),n&&(r=tt(()=>{za(()=>n(e))})))})}function Oo(e){var t,n,r="";if(typeof e=="string"||typeof e=="number")r+=e;else if(typeof e=="object")if(Array.isArray(e)){var a=e.length;for(t=0;t<a;t++)e[t]&&(n=Oo(e[t]))&&(r&&(r+=" "),r+=n)}else for(n in e)e[n]&&(r&&(r+=" "),r+=n);return r}function tc(){for(var e,t,n=0,r="",a=arguments.length;n<a;n++)(e=arguments[n])&&(t=Oo(e))&&(r&&(r+=" "),r+=t);return r}function nc(e){return typeof e=="object"?tc(e):e??""}var xi=[...` 	
\r\f\xA0\v\uFEFF`];function rc(e,t,n){var r=e==null?"":""+e;if(n){for(var a of Object.keys(n))if(n[a])r=r?r+" "+a:a;else if(r.length)for(var i=a.length,l=0;(l=r.indexOf(a,l))>=0;){var s=l+i;(l===0||xi.includes(r[l-1]))&&(s===r.length||xi.includes(r[s]))?r=(l===0?"":r.substring(0,l))+r.substring(s+1):l=s}}return r===""?null:r}function Ei(e,t=!1){var n=t?" !important;":";",r="";for(var a of Object.keys(e)){var i=e[a];i!=null&&i!==""&&(r+=" "+a+": "+i+n)}return r}function na(e){return e[0]!=="-"||e[1]!=="-"?e.toLowerCase():e}function ac(e,t){if(t){var n="",r,a;if(Array.isArray(t)?(r=t[0],a=t[1]):r=t,e){e=String(e).replaceAll(/\s*\/\*.*?\*\/\s*/g,"").trim();var i=!1,l=0,s=!1,f=[];r&&f.push(...Object.keys(r).map(na)),a&&f.push(...Object.keys(a).map(na));var c=0,v=-1;let A=e.length;for(var p=0;p<A;p++){var d=e[p];if(s?d==="/"&&e[p-1]==="*"&&(s=!1):i?i===d&&(i=!1):d==="/"&&e[p+1]==="*"?s=!0:d==='"'||d==="'"?i=d:d==="("?l++:d===")"&&l--,!s&&i===!1&&l===0){if(d===":"&&v===-1)v=p;else if(d===";"||p===A-1){if(v!==-1){var m=na(e.substring(c,v).trim());if(!f.includes(m)){d!==";"&&p++;var b=e.substring(c,p).trim();n+=" "+b+";"}}c=p+1,v=-1}}}}return r&&(n+=Ei(r)),a&&(n+=Ei(a,!0)),n=n.trim(),n===""?null:n}return e==null?null:String(e)}function ic(e,t,n,r,a,i){var l=e[ca];if(L||l!==n||l===void 0){var s=rc(n,r,i);(!L||s!==e.getAttribute("class"))&&(s==null?e.removeAttribute("class"):t?e.className=s:e.setAttribute("class",s)),e[ca]=n}else if(i&&a!==i)for(var f in i){var c=!!i[f];(a==null||c!==!!a[f])&&e.classList.toggle(f,c)}return i}function ra(e,t={},n,r){for(var a in n){var i=n[a];t[a]!==i&&(n[a]==null?e.style.removeProperty(a):e.style.setProperty(a,i,r))}}function oc(e,t,n,r){var a=e[ua];if(L||a!==t){var i=ac(t,r);(!L||i!==e.getAttribute("style"))&&(i==null?e.removeAttribute("style"):e.style.cssText=i),e[ua]=t}else r&&(Array.isArray(r)?(ra(e,n?.[0],r[0]),ra(e,n?.[1],r[1],"important")):ra(e,n,r));return r}function Ca(e,t,n=!1){if(e.multiple){if(t==null)return;if(!Ri(t))return os();for(var r of e.options)r.selected=t.includes(Si(r));return}for(r of e.options){var a=Si(r);if(ss(a,t)){r.selected=!0;return}}(!n||t!==void 0)&&(e.selectedIndex=-1)}function lc(e){var t=new MutationObserver(()=>{Ca(e,e.__value)});t.observe(e,{childList:!0,subtree:!0,attributes:!0,attributeFilter:["value"]}),Mr(()=>{t.disconnect()})}function Si(e){return"__value"in e?e.__value:e.value}var Nn=Symbol("class"),Un=Symbol("style"),Po=Symbol("is custom element"),Lo=Symbol("is html"),sc=tr?"link":"LINK",cc=tr?"input":"INPUT",uc=tr?"option":"OPTION",fc=tr?"select":"SELECT",hc=tr?"progress":"PROGRESS";function Ya(e){if(L){var t=!1,n=()=>{if(!t){if(t=!0,e.hasAttribute("value")){var r=e.value;q(e,"value",null),e.value=r}if(e.hasAttribute("checked")){var a=e.checked;q(e,"checked",null),e.checked=a}}};e[zn]=n,$t(n),co()}}function dc(e,t){var n=Ga(e);n.value===(n.value=t??void 0)||e.value===t&&(t!==0||e.nodeName!==hc)||(e.value=t??"")}function vc(e,t){t?e.hasAttribute("selected")||e.setAttribute("selected",""):e.removeAttribute("selected")}function q(e,t,n,r){var a=Ga(e);L&&(a[t]=e.getAttribute(t),t==="src"||t==="srcset"||t==="href"&&e.nodeName===sc)||a[t]!==(a[t]=n)&&(t==="loading"&&(e[Vl]=n),n==null?e.removeAttribute(t):typeof n!="string"&&Do(e).includes(t)?e[t]=n:e.setAttribute(t,n))}function pc(e,t,n,r,a=!1,i=!1){if(L&&a&&e.nodeName===cc){var l=e,s=l.type==="checkbox"?"defaultChecked":"defaultValue";s in n||Ya(l)}var f=Ga(e),c=f[Po],v=!f[Lo];let p=L&&c;p&&gt(!1);var d=t||{},m=e.nodeName===uc;for(var b in t)b in n||(n[b]=null);n.class?n.class=nc(n.class):n[Nn]&&(n.class=null),n[Un]&&(n.style??(n.style=null));var A=Do(e);for(let E in n){let V=n[E];if(m&&E==="value"&&V==null){e.value=e.__value="",d[E]=V;continue}if(E==="class"){var C=e.namespaceURI==="http://www.w3.org/1999/xhtml";ic(e,C,V,r,t?.[Nn],n[Nn]),d[E]=V,d[Nn]=n[Nn];continue}if(E==="style"){oc(e,V,t?.[Un],n[Un]),d[E]=V,d[Un]=n[Un];continue}var U=d[E];if(!(V===U&&!(V===void 0&&e.hasAttribute(E)))){d[E]=V;var de=E[0]+E[1];if(de!=="$$")if(de==="on"){let le={},B="$$"+E,H=E.slice(2);var ue=Hs(H);if(js(H)&&(H=H.slice(0,-7),le.capture=!0),!ue&&U){if(V!=null)continue;e.removeEventListener(H,d[B],le),d[B]=null}if(ue)Ur(H,e,V),Fr([H]);else if(V!=null){let Qe=function(xe){d[E].call(this,xe)};var ve=Qe;d[B]=$o(H,e,Qe,le)}}else if(E==="style")q(e,E,V);else if(E==="autofocus")Ss(e,!!V);else if(!c&&(E==="__value"||E==="value"&&V!=null))e.value=e.__value=V;else if(E==="selected"&&m)vc(e,V);else{var W=E;v||(W=Ks(W));var st=W==="defaultValue"||W==="defaultChecked";if(V==null&&!c&&!st)if(f[E]=null,W==="value"||W==="checked"){let le=e,B=t===void 0;if(W==="value"){let H=le.defaultValue;le.removeAttribute(W),le.defaultValue=H,le.value=le.__value=B?H:null}else{let H=le.defaultChecked;le.removeAttribute(W),le.defaultChecked=H,le.checked=B?H:!1}}else e.removeAttribute(E);else st||A.includes(W)&&(c||typeof V!="string")?(e[W]=V,W in f&&(f[W]=he)):typeof V!="function"&&q(e,W,V)}}}return p&&gt(!0),d}function Vr(e,t,n=[],r=[],a=[],i,l=!1,s=!1){no(a,n,r,f=>{var c=void 0,v={},p=e.nodeName===fc,d=!1;if(yo(()=>{var b=t(...f.map(o)),A=pc(e,c,b,i,l,s);d&&p&&"value"in b&&Ca(e,b.value);for(let U of Object.getOwnPropertySymbols(v))b[U]||we(v[U]);for(let U of Object.getOwnPropertySymbols(b)){var C=b[U];U.description===rs&&(!c||C!==c[U])&&(v[U]&&we(v[U]),v[U]=tt(()=>ec(e,()=>C))),A[U]=C}c=A}),p){var m=e;za(()=>{Ca(m,c.value,!0),lc(m)})}d=!0})}function Ga(e){return e[gr]??(e[gr]={[Po]:e.nodeName.includes("-"),[Lo]:e.namespaceURI===Ni})}var Ci=new Map;function Do(e){var t=e.getAttribute("is")||e.nodeName,n=Ci.get(t);if(n)return n;Ci.set(t,n=[]);for(var r,a=e,i=Element.prototype;i!==a;){r=Pl(a);for(var l in r)r[l].set&&l!=="innerHTML"&&l!=="textContent"&&l!=="innerText"&&n.push(l);a=Ii(a)}return n}function gc(e,t,n=t){var r=new WeakSet;Cs(e,"input",async a=>{var i=a?e.defaultValue:e.value;if(i=aa(e)?ia(i):i,n(i),D!==null&&r.add(D),await Zt(),i!==(i=t())){var l=e.selectionStart,s=e.selectionEnd,f=e.value.length;if(e.value=i??"",s!==null){var c=e.value.length;l===s&&s===f&&c>f?(e.selectionStart=c,e.selectionEnd=c):(e.selectionStart=l,e.selectionEnd=Math.min(s,c))}}}),(L&&e.defaultValue!==e.value||lr(t)==null&&e.value)&&(n(aa(e)?ia(e.value):e.value),D!==null&&r.add(D)),Nr(()=>{var a=t();if(e===document.activeElement){var i=D;if(r.has(i))return}aa(e)&&a===ia(e.value)||e.type==="date"&&!a&&!e.value||a!==e.value&&(e.value=a??"")})}function aa(e){var t=e.type;return t==="number"||t==="range"}function ia(e){return e===""?null:+e}function oa(e,t){return e===t||e?.[yn]===t}function zt(e={},t,n,r){var a=Ie.r,i=P;return za(()=>{var l,s;return Nr(()=>{l=s,s=[],lr(()=>{oa(n(...s),e)||(t(e,...s),l&&oa(n(...l),e)&&t(null,...l))})}),()=>{let f=i;for(;f!==a&&f.parent!==null&&f.parent.f&sa;)f=f.parent;let c=()=>{s&&oa(n(...s),e)&&t(null,...s)},v=f.teardown;f.teardown=()=>{c(),v?.()}}}),e}var bc={get(e,t){if(!e.exclude.includes(t))return e.props[t]},set(e,t){return!1},getOwnPropertyDescriptor(e,t){if(!e.exclude.includes(t)&&t in e.props)return{enumerable:!0,configurable:!0,value:e.props[t]}},has(e,t){return e.exclude.includes(t)?!1:t in e.props},ownKeys(e){return Reflect.ownKeys(e.props).filter(t=>!e.exclude.includes(t))}};function jr(e,t,n){return new Proxy({props:e,exclude:t},bc)}function re(e,t,n,r){var a=r,i=!0,l=()=>(i&&(i=!1,a=r),a),s;s=e[t],s===void 0&&r!==void 0&&(s=l());var f;f=()=>{var d=e[t];return d===void 0?l():(i=!0,d)};var c=!1,v=Fa(()=>(c=!1,f())),p=P;return(function(d,m){if(arguments.length>0){let b=m?o(v):d;return k(v,b),c=!0,a!==void 0&&(a=b),d}return At&&c||(p.f&it)!==0?v.v:o(v)})}function mc(e){return new $a(e)}var St,qe,$a=class{constructor(t){I(this,St);I(this,qe);var n=new Map,r=(i,l)=>{var s=lo(l,!1,!1);return n.set(i,s),s};let a=new Proxy({...t.props||{},$$events:{}},{get(i,l){return o(n.get(l)??r(l,Reflect.get(i,l)))},has(i,l){return l===Fl?!0:(o(n.get(l)??r(l,Reflect.get(i,l))),Reflect.has(i,l))},set(i,l,s){return k(n.get(l)??r(l,s),s),Reflect.set(i,l,s)}});T(this,qe,(t.hydrate?qs:Ao)(t.component,{target:t.target,anchor:t.anchor,props:a,context:t.context,intro:t.intro??!1,recover:t.recover,transformError:t.transformError})),(!t?.props?.$$host||t.sync===!1)&&X(),T(this,St,a.$$events);for(let i of Object.keys(h(this,qe)))i==="$set"||i==="$destroy"||i==="$on"||Yn(this,i,{get(){return h(this,qe)[i]},set(l){h(this,qe)[i]=l},enumerable:!0});h(this,qe).$set=i=>{Object.assign(a,i)},h(this,qe).$destroy=()=>{Ws(h(this,qe))}}$set(t){h(this,qe).$set(t)}$on(t,n){h(this,St)[t]=h(this,St)[t]||[];let r=(...a)=>n.call(this,...a);return h(this,St)[t].push(r),()=>{h(this,St)[t]=h(this,St)[t].filter(a=>a!==r)}}$destroy(){h(this,qe).$destroy()}};St=new WeakMap,qe=new WeakMap;var Mo=class{};typeof HTMLElement=="function"&&(Mo=class extends HTMLElement{constructor(t,n,r){super();$(this,"$$ctor");$(this,"$$s");$(this,"$$c");$(this,"$$cn",!1);$(this,"$$d",{});$(this,"$$r",!1);$(this,"$$p_d",{});$(this,"$$l",{});$(this,"$$l_u",new Map);$(this,"$$me");$(this,"$$shadowRoot",null);this.$$ctor=t,this.$$s=n,r&&(this.$$shadowRoot=this.attachShadow(r))}addEventListener(t,n,r){if(this.$$l[t]=this.$$l[t]||[],this.$$l[t].push(n),this.$$c){let a=this.$$c.$on(t,n);this.$$l_u.set(n,a)}super.addEventListener(t,n,r)}removeEventListener(t,n,r){if(super.removeEventListener(t,n,r),this.$$c){let a=this.$$l_u.get(n);a&&(a(),this.$$l_u.delete(n))}}async connectedCallback(){if(this.$$cn=!0,!this.$$c){let n=function(i){return l=>{let s=Da("slot");i!=="default"&&(s.name=i),j(l,s)}};var t=n;if(await Promise.resolve(),!this.$$cn||this.$$c)return;let r={},a=yc(this);for(let i of this.$$s)i in a&&(i==="default"&&!this.$$d.children?(this.$$d.children=n(i),r.default=!0):r[i]=n(i));for(let i of this.attributes){let l=this.$$g_p(i.name);l in this.$$d||(this.$$d[l]=kr(l,i.value,this.$$p_d,"toProp"))}for(let i in this.$$p_d)!(i in this.$$d)&&this[i]!==void 0&&(this.$$d[i]=this[i],delete this[i]);this.$$c=mc({component:this.$$ctor,target:this.$$shadowRoot||this,props:{...this.$$d,$$slots:r,$$host:this}}),this.$$me=Is(()=>{Nr(()=>{this.$$r=!0;for(let i of xr(this.$$c)){if(!this.$$p_d[i]?.reflect)continue;this.$$d[i]=this.$$c[i];let l=kr(i,this.$$d[i],this.$$p_d,"toAttribute");l==null?this.removeAttribute(this.$$p_d[i].attribute||i):this.setAttribute(this.$$p_d[i].attribute||i,l)}this.$$r=!1})});for(let i in this.$$l)for(let l of this.$$l[i]){let s=this.$$c.$on(i,l);this.$$l_u.set(l,s)}this.$$l={}}}attributeChangedCallback(t,n,r){this.$$r||(t=this.$$g_p(t),this.$$d[t]=kr(t,r,this.$$p_d,"toProp"),this.$$c?.$set({[t]:this.$$d[t]}))}disconnectedCallback(){this.$$cn=!1,Promise.resolve().then(()=>{!this.$$cn&&this.$$c&&(this.$$c.$destroy(),this.$$me(),this.$$c=void 0)})}$$g_p(t){return xr(this.$$p_d).find(n=>this.$$p_d[n].attribute===t||!this.$$p_d[n].attribute&&n.toLowerCase()===t)||t}});function kr(e,t,n,r){let a=n[e]?.type;if(t=a==="Boolean"&&typeof t!="boolean"?t!=null:t,!r||!n[e])return t;if(r==="toAttribute")switch(a){case"Object":case"Array":return t==null?null:JSON.stringify(t);case"Boolean":return t?"":null;case"Number":return t??null;default:return t}else switch(a){case"Object":case"Array":return t&&JSON.parse(t);case"Boolean":return t;case"Number":return t!=null?+t:t;default:return t}}function yc(e){let t={};return e.childNodes.forEach(n=>{t[n.slot||"default"]=!0}),t}function Bt(e,t,n,r,a,i){let l=class extends Mo{constructor(){super(e,n,a),this.$$p_d=t}static get observedAttributes(){return xr(t).map(s=>(t[s].attribute||s).toLowerCase())}};return xr(t).forEach(s=>{Yn(l.prototype,s,{get(){return this.$$c&&s in this.$$c?this.$$c[s]:this.$$d[s]},set(f){f=kr(s,f,t),this.$$d[s]=f;var c=this.$$c;if(c){var v=bn(c,s)?.get;v?c[s]=f:c.$set({[s]:f})}}})}),r.forEach(s=>{Yn(l.prototype,s,{get(){return this.$$c?.[s]}})}),e.element=l,l}var wc=ae('<div class="altcha-checkbox"><input/> <svg aria-hidden="true" width="12" height="9" viewBox="0 0 12 9"><polyline points="1 5 4 8 11 1"></polyline></svg> <div class="altcha-spinner altcha-checkbox-spinner" aria-hidden="true"></div></div>');function No(e,t){Rt(t,!0);let n=re(t,"loading"),r=jr(t,["$$slots","$$events","$$legacy","$$host","loading"]),a;function i(){a?.click()}var l={get loading(){return n()},set loading(v){n(v),X()}},s=wc(),f=oe(s);Vr(f,()=>({type:"checkbox",...r}),void 0,void 0,void 0,void 0,!0),zt(f,v=>a=v,()=>a);var c=ne(f,2);return Pa(2),ee(s),ke(()=>q(s,"data-loading",n())),Ur("click",c,i),j(e,s),It(l)}Fr(["click"]);Bt(No,{loading:{}},[],[],{mode:"open"});var _c=ae('<div class="altcha-checkbox-native"><input/> <div class="altcha-spinner altcha-checkbox-native-spinner"></div></div>');function Uo(e,t){Rt(t,!0);let n=re(t,"loading"),r=jr(t,["$$slots","$$events","$$legacy","$$host","loading"]);var a={get loading(){return n()},set loading(s){n(s),X()}},i=_c(),l=oe(i);return Vr(l,()=>({type:"checkbox",...r}),void 0,void 0,void 0,void 0,!0),Pa(2),ee(i),ke(()=>q(i,"data-loading",n())),j(e,i),It(a)}Bt(Uo,{loading:{}},[],[],{mode:"open"});var kc=ae('<div><a target="_blank" class="altcha-logo" aria-hidden="true" tabindex="-1"><svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.33955 16.4279C5.88954 20.6586 12.1971 21.2105 16.4279 17.6604C18.4699 15.947 19.6548 13.5911 19.9352 11.1365L17.9886 10.4279C17.8738 12.5624 16.909 14.6459 15.1423 16.1284C11.7577 18.9684 6.71167 18.5269 3.87164 15.1423C1.03163 11.7577 1.4731 6.71166 4.8577 3.87164C8.24231 1.03162 13.2883 1.4731 16.1284 4.8577C16.9767 5.86872 17.5322 7.02798 17.804 8.2324L19.9522 9.01429C19.7622 7.07737 19.0059 5.17558 17.6604 3.57212C14.1104 -0.658624 7.80283 -1.21043 3.57212 2.33956C-0.658625 5.88958 -1.21046 12.1971 2.33955 16.4279Z" fill="currentColor"></path><path d="M3.57212 2.33956C1.65755 3.94607 0.496389 6.11731 0.12782 8.40523L2.04639 9.13961C2.26047 7.15832 3.21057 5.25375 4.8577 3.87164C8.24231 1.03162 13.2883 1.4731 16.1284 4.8577L13.8302 6.78606L19.9633 9.13364C19.7929 7.15555 19.0335 5.20847 17.6604 3.57212C14.1104 -0.658624 7.80283 -1.21043 3.57212 2.33956Z" fill="currentColor"></path><path d="M7 10H5C5 12.7614 7.23858 15 10 15C12.7614 15 15 12.7614 15 10H13C13 11.6569 11.6569 13 10 13C8.3431 13 7 11.6569 7 10Z" fill="currentColor"></path></svg></a></div>');function qa(e,t){Rt(t,!0);let n=re(t,"strings"),r="https://altcha.org";var a={get strings(){return n()},set strings(s){n(s),X()}},i=kc(),l=oe(i);return q(l,"href",r),ee(i),ke(()=>q(l,"aria-label",n().ariaLinkLabel)),j(e,i),It(a)}Bt(qa,{strings:{}},[],[],{mode:"open"});var xc=ae('<div class="altcha-footer"><p></p> <!></div>');function Ta(e,t){Rt(t,!0);let n=re(t,"logo"),r=re(t,"strings");var a={get logo(){return n()},set logo(c){n(c),X()},get strings(){return r()},set strings(c){r(c),X()}},i=xc(),l=oe(i);Io(l,()=>r().footer,!0),ee(l);var s=ne(l,2);{var f=c=>{qa(c,{get strings(){return r()}})};pe(s,c=>{n()&&c(f)})}return ee(i),j(e,i),It(a)}Bt(Ta,{logo:{},strings:{}},[],[],{mode:"open"});var Ec=ae('<div class="altcha-switch"><input/>  <div class="altcha-switch-toggle"><div class="altcha-spinner altcha-switch-spinner"></div></div></div>');function Fo(e,t){Rt(t,!0);let n=re(t,"loading"),r=jr(t,["$$slots","$$events","$$legacy","$$host","loading"]),a;function i(){a?.click()}var l={get loading(){return n()},set loading(v){n(v),X()}},s=Ec(),f=oe(s);Vr(f,()=>({type:"checkbox",...r}),void 0,void 0,void 0,void 0,!0),zt(f,v=>a=v,()=>a);var c=ne(f,2);return ee(s),ke(()=>q(s,"data-loading",n())),Ur("click",c,i),j(e,s),It(l)}Fr(["click"]);Bt(Fo,{loading:{}},[],[],{mode:"open"});var me=(e=>(e.ERROR="error",e.LOADING="loading",e.PLAYING="playing",e.PAUSED="paused",e.READY="ready",e))(me||{}),K=(e=>(e.CODE="code",e.ERROR="error",e.VERIFIED="verified",e.VERIFYING="verifying",e.UNVERIFIED="unverified",e.EXPIRED="expired",e))(K||{}),Sc=ae('<div class="altcha-code-challenge-title"> </div>'),Cc=ae('<div class="altcha-spinner"></div>'),$c=Ba('<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.8659 3.00017L22.3922 19.5002C22.6684 19.9785 22.5045 20.5901 22.0262 20.8662C21.8742 20.954 21.7017 21.0002 21.5262 21.0002H2.47363C1.92135 21.0002 1.47363 20.5525 1.47363 20.0002C1.47363 19.8246 1.51984 19.6522 1.60761 19.5002L11.1339 3.00017C11.41 2.52187 12.0216 2.358 12.4999 2.63414C12.6519 2.72191 12.7782 2.84815 12.8659 3.00017ZM10.9999 16.0002V18.0002H12.9999V16.0002H10.9999ZM10.9999 9.00017V14.0002H12.9999V9.00017H10.9999Z"></path></svg>'),Tc=Ba('<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M15 7C15 6.44772 15.4477 6 16 6C16.5523 6 17 6.44772 17 7V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V7ZM7 7C7 6.44772 7.44772 6 8 6C8.55228 6 9 6.44772 9 7V17C9 17.5523 8.55228 18 8 18C7.44772 18 7 17.5523 7 17V7Z"></path></svg>'),Ac=Ba('<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4 12H7C8.10457 12 9 12.8954 9 14V19C9 20.1046 8.10457 21 7 21H4C2.89543 21 2 20.1046 2 19V12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V19C22 20.1046 21.1046 21 20 21H17C15.8954 21 15 20.1046 15 19V14C15 12.8954 15.8954 12 17 12H20C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12Z"></path></svg>'),Rc=ae('<button type="button" class="altcha-button altcha-button-secondary"><!></button>'),Ic=ae('<audio hidden="" autoplay=""></audio>'),Oc=ae('<div class="altcha-code-challenge"><form data-code-challenge="true"><!> <div class="altcha-code-challenge-text"> </div> <img class="altcha-code-challenge-image" alt=""/> <div class="altcha-code-challenge-row"><input type="text" class="altcha-input" autocomplete="off" name="" required=""/> <!> <button type="button" class="altcha-button altcha-button-secondary"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2V4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 9.25022 5.38734 6.82447 7.50024 5.38451L7.5 8H9.5V2L3.5 2V4L5.99918 3.99989C3.57075 5.82434 2 8.72873 2 12Z"></path></svg></button></div> <div class="altcha-code-challenge-buttons"><button type="submit" class="altcha-button"> </button> <button type="button" class="altcha-button altcha-button-secondary"> </button></div></form> <!></div>');function Vo(e,t){Rt(t,!0);let n=re(t,"audioUrl"),r=re(t,"codeChallenge"),a=re(t,"config"),i=re(t,"imageUrl"),l=re(t,"onCancel"),s=re(t,"onReload"),f=re(t,"onSubmit"),c=re(t,"strings"),v=N(void 0),p=N(void 0),d=N(void 0),m=N(!1),b=N(""),A=N(!1);Ka(()=>(a().disableAutoFocus||Zt().then(()=>{o(d)?.focus()}),()=>{o(p)&&(o(p).pause(),k(p,void 0))}));function C(){k(v,me.PAUSED,!0)}function U(w){k(v,me.ERROR,!0)}function de(){k(v,me.READY,!0)}function ue(){k(v,me.LOADING,!0)}function ve(){k(v,me.PLAYING,!0)}function W(){k(v,me.PAUSED,!0)}function st(w){w.code==="Space"?(w.preventDefault(),w.stopPropagation(),V()):w.code==="Escape"&&(w.preventDefault(),w.stopPropagation(),l()?.())}function E(w){w.preventDefault(),w.stopPropagation(),f()?.(o(b))}function V(){o(p)?o(v)===me.LOADING||(o(p).paused?(n()&&o(p).src!==n()&&(o(p).src=n()),o(p).currentTime=0,o(p).play()):o(p).pause()):(k(A,!0),requestAnimationFrame(()=>{o(p)&&n()&&(o(p).src=n(),o(p).play())}))}var le={get audioUrl(){return n()},set audioUrl(w){n(w),X()},get codeChallenge(){return r()},set codeChallenge(w){r(w),X()},get config(){return a()},set config(w){a(w),X()},get imageUrl(){return i()},set imageUrl(w){i(w),X()},get onCancel(){return l()},set onCancel(w){l(w),X()},get onReload(){return s()},set onReload(w){s(w),X()},get onSubmit(){return f()},set onSubmit(w){f(w),X()},get strings(){return c()},set strings(w){c(w),X()}},B=Oc(),H=oe(B),Qe=oe(H);{var xe=w=>{var se=Sc(),Gt=oe(se,!0);ee(se),ke(()=>pt(Gt,c().verificationRequired)),j(w,se)};pe(Qe,w=>{a().codeChallengeDisplay!=="standard"&&w(xe)})}var $e=ne(Qe,2),ie=oe($e,!0);ee($e);var ct=ne($e,2),S=ne(ct,2),Z=oe(S);Ya(Z),Z.disabled=o(m),zt(Z,w=>k(d,w),()=>o(d));var Oe=ne(Z,2);{var y=w=>{var se=Rc(),Gt=oe(se);{var Hr=Te=>{var ut=Cc();j(Te,ut)},Dn=Te=>{var ut=$c();j(Te,ut)},Br=Te=>{var ut=Tc();j(Te,ut)},Kr=Te=>{var ut=Ac();j(Te,ut)};pe(Gt,Te=>{o(v)===me.LOADING?Te(Hr):o(v)===me.ERROR?Te(Dn,1):o(v)===me.PLAYING?Te(Br,2):Te(Kr,-1)})}ee(se),ke(()=>{q(se,"title",c().getAudioChallenge),se.disabled=o(v)===me.LOADING||o(v)===me.ERROR,q(se,"aria-label",o(v)===me.LOADING?c().loading:c().getAudioChallenge)}),ge("click",se,()=>V(),!0),j(w,se)};pe(Oe,w=>{r().audio&&w(y)})}var Kt=ne(Oe,2);ee(S);var cr=ne(S,2),ze=oe(cr),zr=oe(ze,!0);ee(ze);var Yt=ne(ze,2),On=oe(Yt,!0);ee(Yt),ee(cr),ee(H);var Pn=ne(H,2);{var Ln=w=>{var se=Ic();zt(se,Gt=>k(p,Gt),()=>o(p)),ge("error",se,U),ge("loadstart",se,ue),ge("canplay",se,de),ge("pause",se,W),ge("playing",se,ve),ge("ended",se,C),j(w,se)};pe(Pn,w=>{o(A)&&w(Ln)})}return ee(B),ke(()=>{pt(ie,c().enterCodeFromImage),q(ct,"src",i()),q(Z,"minlength",r().length||1),q(Z,"maxlength",r().length),q(Z,"placeholder",c().enterCode),q(Z,"aria-label",o(v)===me.LOADING?c().loading:o(v)===me.PLAYING?"":c().enterCodeAria),q(Z,"aria-live",o(v)?"assertive":"polite"),q(Z,"aria-busy",o(v)===me.LOADING),q(Kt,"title",c().reload),q(Kt,"aria-label",c().reload),q(ze,"aria-label",c().verify),pt(zr,c().verify),q(Yt,"aria-label",c().cancel),pt(On,c().cancel)}),ge("submit",H,E,!0),Ur("keydown",Z,st),gc(Z,()=>o(b),w=>k(b,w)),ge("click",Kt,()=>s()?.(),!0),ge("click",Yt,()=>l()?.(),!0),j(e,B),It(le)}Fr(["keydown"]);Bt(Vo,{audioUrl:{},codeChallenge:{},config:{},imageUrl:{},onCancel:{},onReload:{},onSubmit:{},strings:{}},[],[],{mode:"open"});var Pc=ae('<div class="altcha-popover-backdrop" data-backdrop=""></div>'),Lc=ae('<div class="altcha-popover-arrow"></div>'),Dc=ae('<div role="button" class="altcha-popover-close">&times;</div>'),Mc=ae('<!> <div><!> <!> <div class="altcha-popover-content"><!></div></div>',1);function Aa(e,t){Rt(t,!0);let n=re(t,"anchor"),r=re(t,"children"),a=re(t,"display",7,"standard"),i=re(t,"backdrop",7,!1),l=re(t,"onClickOutside"),s=re(t,"onClickOutsideDelay",7,600),f=re(t,"onClose"),c=re(t,"placement",7,"auto"),v=re(t,"updateUISignal"),p=re(t,"variant",7,"neutral"),d=jr(t,["$$slots","$$events","$$legacy","$$host","anchor","children","display","backdrop","onClickOutside","onClickOutsideDelay","onClose","placement","updateUISignal","variant"]),m=N(void 0),b=N(void 0),A=N(!1),C=N(0);De(()=>{c()!=="auto"&&k(A,c()==="top")}),De(()=>{v()&&W()}),Ka(()=>{let S=a()==="bottomsheet"||a()==="overlay";return S&&(o(b)&&document.body.append(o(b)),o(m)&&document.body.append(o(m))),W(),Zt().then(()=>{k(C,Date.now(),!0)}),()=>{S&&(o(b)&&document.body.removeChild(o(b)),o(m)&&document.body.removeChild(o(m)))}});function U(){f()?.()}function de(S){let Z=S.target;!o(m)?.contains(Z)&&(!s()||o(C)+s()<Date.now())&&l()?.()}function ue(){W()}function ve(){W()}function W(){if(n()&&c()==="auto"&&o(m)){let S=n().getBoundingClientRect(),Oe=document.documentElement.clientHeight-(S.top+S.height)<o(m).clientHeight;o(A)!==Oe&&k(A,Oe)}}var st={get anchor(){return n()},set anchor(S){n(S),X()},get children(){return r()},set children(S){r(S),X()},get display(){return a()},set display(S="standard"){a(S),X()},get backdrop(){return i()},set backdrop(S=!1){i(S),X()},get onClickOutside(){return l()},set onClickOutside(S){l(S),X()},get onClickOutsideDelay(){return s()},set onClickOutsideDelay(S=600){s(S),X()},get onClose(){return f()},set onClose(S){f(S),X()},get placement(){return c()},set placement(S="auto"){c(S),X()},get updateUISignal(){return v()},set updateUISignal(S){v(S),X()},get variant(){return p()},set variant(S="neutral"){p(S),X()}},E=Mc();ge("click",rn,de,!0),ge("resize",rn,ue),ge("scroll",rn,ve);var V=vn(E);{var le=S=>{var Z=Pc();zt(Z,Oe=>k(b,Oe),()=>o(b)),j(S,Z)};pe(V,S=>{i()&&S(le)})}var B=ne(V,2);Vr(B,()=>({...d,class:`altcha-popover ${(t.class||"")??""}`,"data-popover":!0,"data-variant":p(),"data-top":o(A),"data-display":a()}));var H=oe(B);{var Qe=S=>{var Z=Lc();j(S,Z)};pe(H,S=>{a()==="standard"&&S(Qe)})}var xe=ne(H,2);{var $e=S=>{var Z=Dc();ge("click",Z,U,!0),j(S,Z)};pe(xe,S=>{a()!=="standard"&&S($e)})}var ie=ne(xe,2),ct=oe(ie);return Zs(ct,()=>r()??Ut),ee(ie),ee(B),zt(B,S=>k(m,S),()=>o(m)),j(e,E),It(st)}Bt(Aa,{anchor:{},children:{},display:{},backdrop:{},onClickOutside:{},onClickOutsideDelay:{},onClose:{},placement:{},updateUISignal:{},variant:{}},[],[],{mode:"open"});function Nc(e){return Array.from(new Uint8Array(e)).map(t=>t.toString(16).padStart(2,"0")).join("")}function Uc(e,t="altcha-css",n){if(typeof document<"u"&&document&&!document.getElementById(t)){let r=document.createElement("style");r.id=t,r.textContent=e;let a=document.currentScript?.nonce??document.querySelector('meta[name="csp-nonce"]')?.content;a&&(r.nonce=a),document.head.appendChild(r)}}async function jo(e){let{challenge:t,concurrency:n=navigator.hardwareConcurrency,controller:r=new AbortController,createWorker:a,onOutOfMemory:i=d=>d>1?Math.floor(d/2):0,counterMode:l,timeout:s=9e4}=e,f=Math.min(16,Math.max(1,n)),c=[],v=()=>{for(let d of c)d.terminate()};for(let d=0;d<f;d++)c.push(await a(t.parameters.algorithm));let p=null;try{p=await Promise.race(c.map((d,m)=>(r.signal.addEventListener("abort",()=>{d.postMessage({type:"abort"})}),new Promise((b,A)=>{d.addEventListener("error",C=>{A(C)}),d.addEventListener("message",C=>{if(C.data){for(let U of c)U!==d&&U.postMessage({type:"abort"});if(C.data.error)return A(new Error(C.data.error))}b(C.data)}),d.postMessage({challenge:t,counterMode:l,counterStart:m,counterStep:f,timeout:s,type:"work"})}))))}catch(d){if(d instanceof Error&&!!d?.message?.includes("Out of memory")&&i){v();let b=i(f);if(b)return jo({...e,challenge:t,controller:r,concurrency:b,createWorker:a})}throw d}finally{v()}return r.signal.aborted?null:p||null}var Ra=class{constructor(t={}){$(this,"TAG_CODES",{INPUT:1,TEXTAREA:2,SELECT:3,BUTTON:4,A:5,DETAILS:6,SUMMARY:7,IFRAME:8,VIDEO:9,AUDIO:10});$(this,"maxSamples");$(this,"sampleInterval");$(this,"target");$(this,"focusStartTime",0);$(this,"focusInteraction",0);$(this,"focusInteractionTimer",null);$(this,"lastPointerSample",0);$(this,"lastTouchSample",0);$(this,"lastScrollSample",0);$(this,"pendingPointer",null);$(this,"pendingTouch",null);$(this,"focus",[]);$(this,"pointer",[]);$(this,"scroll",[]);$(this,"touch",[]);$(this,"onFocus",t=>{if(this.focusInteraction===2)return;let n=t.target;if(!(n instanceof Element))return;let r=performance.now();this.focusStartTime===0&&(this.focusStartTime=r),this.focus.push([Math.round(r-this.focusStartTime),n.tabIndex,this.TAG_CODES[n.tagName]??0,this.focusInteraction?1:0]),this.evict(this.focus)});$(this,"onInteraction",t=>{this.focusInteraction="keyCode"in t?1:2,this.focusInteractionTimer&&clearTimeout(this.focusInteractionTimer),this.focusInteractionTimer=setTimeout(()=>{this.focusInteraction=0},100)});$(this,"onPointer",t=>{if(t.pointerType==="touch")return;let n=t.timeStamp||performance.now();this.pendingPointer=[Math.round(t.clientX),Math.round(t.clientY),Math.round(n)],n-this.lastPointerSample>=this.sampleInterval&&(this.pointer.push(this.pendingPointer),this.lastPointerSample=n,this.pendingPointer=null,this.evict(this.pointer))});$(this,"onScroll",()=>{let t=performance.now();t-this.lastScrollSample<this.sampleInterval||(this.scroll.push([Math.round(window.scrollY),Math.round(t)]),this.lastScrollSample=t,this.evict(this.scroll))});$(this,"onTouchMove",t=>{let n=t.timeStamp||performance.now(),r=t.touches[0];r&&(this.pendingTouch=[Math.round(r.clientX),Math.round(r.clientY),Math.round(n),Math.round(r.force*1e3)/1e3,Math.round(r.radiusX||0),Math.round(r.radiusY||0)],n-this.lastTouchSample>=this.sampleInterval&&(this.touch.push(this.pendingTouch),this.lastTouchSample=n,this.pendingTouch=null,this.evict(this.touch)))});let{maxSamples:n=60,sampleInterval:r=50,target:a=window}=t;this.maxSamples=n,this.sampleInterval=r,this.target=a,this.attach()}destroy(){let t={capture:!0};this.target.removeEventListener("focusin",this.onFocus,t),this.target.removeEventListener("keydown",this.onInteraction,t),this.target.removeEventListener("pointerdown",this.onInteraction,t),this.target.removeEventListener("pointermove",this.onPointer,t),this.target.removeEventListener("scroll",this.onScroll,t),this.target.removeEventListener("touchmove",this.onTouchMove,t)}export(){return{focus:this.focus,maxTouchPoints:navigator.maxTouchPoints||0,pointer:this.pointer,scroll:this.scroll,time:Date.now(),touch:this.touch}}attach(){let t={passive:!0,capture:!0};this.target.addEventListener("focusin",this.onFocus,t),this.target.addEventListener("keydown",this.onInteraction,t),this.target.addEventListener("pointerdown",this.onInteraction,t),this.target.addEventListener("pointermove",this.onPointer,t),this.target.addEventListener("scroll",this.onScroll,t),this.target.addEventListener("touchmove",this.onTouchMove,t)}evict(t){t.length>this.maxSamples&&t.splice(0,t.length-this.maxSamples)}},Fc=ae('<div class="altcha-overlay-backdrop" data-backdrop=""></div>'),Vc=ae('<div class="altcha-overlay-content"></div>'),jc=ae('<div role="button" class="altcha-overlay-close">&times;</div> <!>',1),zc=ae('<div class="altcha-floating-arrow"></div>'),Hc=ae('<input type="hidden"/>'),Bc=ae('<div class="altcha-error">Secure context (HTTPS) required.</div>'),Kc=ae('<div class="altcha-error"> </div>'),Yc=ae('<div class="altcha-error"> </div>'),Gc=ae("<!> <!>",1),qc=ae('<!> <div class="altcha"><!> <div class="altcha-main"><div><div class="altcha-checkbox-wrap"><!> <label><!></label></div> <!></div> <!> <!> <!></div> <!></div>',1);function Wc(e,t){Rt(t,!0);let n=()=>vi(v,"$altchaDefaults",a),r=()=>vi(b,"$altchaI18nStore",a),[a,i]=ds(),l='input[type="text"]:not([data-no-spamfilter]), textarea:not([data-no-spamfilter])',s='input[type="submit"], button[type="submit"], button:not([type="button"]):not([type="reset"])',f=["ar","fa","he","ur"],{isSecureContext:c}=globalThis,{store:v}=globalThis.$altcha.defaults,p=navigator.hardwareConcurrency||2,d=navigator.deviceMemory||0,m=d&&d<=4?Math.min(4,p):p,b=globalThis.$altcha.i18n.store,A=t.$$host,C=(u,g)=>{Zt().then(()=>{A?.dispatchEvent(new CustomEvent(u,{detail:g}))})},U=null,de=N(Ct(new URL(location.origin))),ue=N(!1),ve=N(null),W=N(null),st=N(null),E=N(Ct(K.UNVERIFIED)),V=N(void 0),le=N(void 0),B=N(null),H=N(void 0),Qe=N(null),xe=N(null),$e=N(null),ie=N(null),ct=N(Ct([])),S=N(0),Z=N(Ct({})),Oe=N(!0),y=Ee(()=>({fetch:(u,g)=>fetch(u,g),audioChallengeLanguage:"",auto:"off",barPlacement:"bottom",challenge:"",codeChallenge:null,codeChallengeDisplay:"standard",credentials:null,debug:!1,disableAutoFocus:!1,display:"standard",floatingAnchor:"",floatingOffset:8,floatingPersist:!1,floatingPlacement:"auto",hideFooter:!1,hideLogo:!1,humanInteractionSignature:!0,language:"",mockError:!1,minDuration:500,overlayContent:"",name:"altcha",popoverPlacement:"auto",retryOnOutOfMemoryError:!0,setCookie:null,serverVerificationFields:!1,serverVerificationTimeZone:!1,test:!1,timeout:9e4,type:"checkbox",validationMessage:"",verifyFunction:null,verifyUrl:"",workers:m,...n(),...o(Z)})),Kt=Ee(()=>`altcha-checkbox-${t.id||Math.floor(Math.random()*1e12).toString(16)}`),cr=Ee(()=>Yo(o(y).type)),ze=Ee(()=>o(y).auto),zr=Ee(()=>o(E)===K.VERIFYING),Yt=Ee(()=>!o(y).hideFooter),On=Ee(()=>!o(y).hideLogo&&o(y).display!=="bar"),Pn=Ee(()=>Go(r(),[o(y).language,document.documentElement.lang,...navigator.languages])),Ln=Ee(()=>f.includes(o(Pn).language)?"rtl":void 0),w=Ee(()=>({...o(Pn).strings})),se=Ee(()=>o(ve)?.audio?.match(/^(https?:)?\//)?ur(o(ve).audio,o(de),{language:o(y).audioChallengeLanguage||o(Pn).language}).toString():o(ve)?.audio),Gt=Ee(()=>o(ve)?.image?.match(/^(https?:)?\//)?ur(o(ve).image,o(de)):o(ve)?.image);De(()=>{Mn({auto:t.auto,challenge:t.challenge,display:t.display,language:t.language,name:t.name,type:t.type,workers:t.workers})}),De(()=>{if(t.configuration)try{Mn(JSON.parse(t.configuration))}catch{J("unable to parse the `configuration` attribute (JSON expected)")}}),De(()=>{o(st)!==o(y).display&&fr(o(y).display)}),De(()=>{o(ue)&&o(E)===K.VERIFYING&&k(ue,!1)}),De(()=>{!o(ue)&&o(E)===K.VERIFIED&&k(ue,!0)}),De(()=>{if(!o(ue)){let u=Yr();u&&u.checked&&(u.checked=!1)}}),De(()=>{o(E)===K.VERIFIED&&Yr()?.setCustomValidity("")}),De(()=>{if(o(ze)==="onload"){let u=setTimeout(()=>{fn()},1);return()=>{u&&clearTimeout(u)}}}),De(()=>{o(xe)&&J("error:",o(xe))}),De(()=>{o(ie)&&o(y).setCookie&&ll(o(ie),o(y).setCookie)}),Ka(()=>(J("mounted","3.1.0"),A&&globalThis.$altcha.instances.add(A),k(B,o(H)?.closest("form"),!0),o(B)?.addEventListener("reset",Qa),o(B)?.addEventListener("submit",ei,{capture:!0}),o(B)?.addEventListener("focusin",Xa),Hr(),o(y).humanInteractionSignature&&(J("human interaction signature enabled"),U=new Ra),C("load"),c||J("secure context (HTTPS) required"),()=>{Br(),A&&globalThis.$altcha.instances.delete(A),o($e)&&clearTimeout(o($e)),o(B)?.removeEventListener("reset",Qa),o(B)?.removeEventListener("submit",ei,{capture:!0}),o(B)?.removeEventListener("focusin",Xa),U?.destroy()}));function Hr(){k(ct,[...globalThis.$altcha.plugins].map(u=>new u(A)),!0),J("activating plugins",o(ct).map(u=>u.constructor.name));for(let u of o(ct))u.activate()}async function Dn(u,...g){let _;for(let x of o(ct))_=await x[u].call(x,...g);return _}function Br(){for(let u of o(ct))u.destroy()}function Kr(u){let[g,_]=u.salt.split("?"),x={};if(_)try{Object.assign(x,Object.fromEntries(new URLSearchParams(_).entries()))}catch{}let O={codeChallenge:u.codeChallenge,parameters:{algorithm:u.algorithm,cost:1,data:x,expiresAt:x?.expires?parseInt(x.expires,10):void 0,keyLength:u.algorithm==="SHA-512"?64:u.algorithm==="SHA-384"?48:32,nonce:Nc(new TextEncoder().encode(u.salt)),keyPrefix:u.challenge,salt:""},signature:u.signature};return Object.defineProperties(O,{_originalSalt:{enumerable:!1,value:u.salt,writable:!1},_version:{enumerable:!1,value:1,writable:!1}}),O}function Te(u,g){return{algorithm:u.parameters.algorithm,challenge:u.parameters.keyPrefix,number:g.counter,salt:"_originalSalt"in u?u._originalSalt:u.parameters.nonce,signature:u.signature,took:g.time||0}}async function ut(u){await new Promise(g=>setTimeout(g,u))}async function Ja(u=o(y).challenge,g){let _=await Dn("onFetchChallenge",u),x=null;if(_!==void 0)return _;if(typeof u=="string")if(u.startsWith("{")){J("parsing JSON challenge");try{x=JSON.parse(u)}catch{throw new Error("Unable to parse JSON challenge.")}}else{J("fetching challenge from",g?.method||"GET",u),k(de,new URL(u,location.origin),!0);let O=await o(y).fetch(u,{credentials:o(y).credentials||void 0,...g});await ni(O);let R=O.headers.get("x-altcha-config");R&&al(R);let G=await O.json();if(G&&"his"in G&&G.his){if(J("requested HIS"),!U)throw new Error("Server requested HIS data but collector is disabled.");return Ja(ur(G.his.url,o(de)),{body:JSON.stringify({his:U.export()}),headers:{"content-type":"application/json"},method:"POST"})}G&&"hisResult"in G&&G.hisResult&&J("HIS result",G.hisResult),x=G}else if(u&&typeof u=="object")try{x=JSON.parse(JSON.stringify(u))}catch{throw new Error("Unable to parse JSON challenge.")}if(Bo(x)&&(x=Kr(x)),!Ko(x))throw new Error("Challenge validation failed.");return x}function Bo(u){return typeof u=="object"&&"challenge"in u}function Ko(u){return!!u&&typeof u=="object"&&"parameters"in u&&!!u.parameters&&typeof u.parameters=="object"&&"algorithm"in u.parameters&&"nonce"in u.parameters&&"salt"in u.parameters&&"keyPrefix"in u.parameters}function Yr(){return document.getElementById(o(Kt))}function Yo(u){switch(u){case"checkbox":return No;case"switch":return Fo;default:return Uo}}function Go(u,g){let _=Object.keys(u).map(O=>O.toLowerCase()),x=g.reduce((O,R)=>(R=R.toLowerCase(),O||(u[R]?R:null)||_.find(G=>R.split("-")[0]===G.split("-")[0])||null),null);return u[x||""]||(x="en"),{language:x,strings:u[x]}}function qo(u){switch(u){case"bar":return o(y).barPlacement||"bottom";case"floating":return o(y).floatingPlacement||"auto";default:return}}function Wo(u){return[...o(B)?.querySelectorAll(l)||[]].reduce((_,x)=>{let O=x.name,R=x.value;return O&&R&&(_[O]=/\n/.test(R)?R.replace(new RegExp("(?<!\\r)\\n","g"),`\r
`):R),_},{})}function Zo(){try{return Intl.DateTimeFormat().resolvedOptions().timeZone}catch{}}function ur(u,g,_){let x=new URL(u,g);if(x.search||(x.search=g.search),_)for(let O in _)_[O]!==void 0&&_[O]!==null&&x.searchParams.set(O,_[O]);return x.toString()}function Jo(u){!o(ue)&&u.currentTarget.checked?(u.preventDefault(),u.currentTarget.checked=!1,o(E)!==K.VERIFYING&&fn()):u.currentTarget.checked||(u.preventDefault(),He())}function Xo(u){o(E)===K.VERIFYING?u.currentTarget.setCustomValidity(o(w).waitAlert):o(y).validationMessage&&u.currentTarget.setCustomValidity(o(y).validationMessage)}function Qo(){fr(o(y).display),He()}function el(){hr()}function tl(u){let g=u.target;o(y).display==="floating"&&g&&!A?.contains(g)&&!g.hasAttribute("data-backdrop")&&!g.closest("[data-popover]")&&o(E)!==K.VERIFIED&&!o(y).floatingPersist&&Gr()}function Xa(u){o(ze)==="onfocus"&&o(E)===K.UNVERIFIED&&fn()}function Qa(){fr(o(y).display),He()}function ei(u){u.target?.getAttribute("data-code-challenge")!=="true"&&o(ze)==="onsubmit"&&o(E)===K.UNVERIFIED&&(u.preventDefault(),u.stopPropagation(),k(Qe,u.submitter,!0),qr(),fn().then(_=>{_&&!o(ve)&&Zt().then(()=>{ti(o(Qe))})}))}function nl(u){u.persisted&&(fr(o(y).display),He())}function rl(){hr()}function al(u){try{let g=JSON.parse(u);g&&typeof g=="object"&&Mn({serverVerificationFields:g?.sentinel?.fields,serverVerificationTimeZone:g?.sentinel?.timeZone,verifyUrl:g.verifyurl,...g})}catch(g){J("unable to configure from x-altcha-config header",g)}}function il(u=20){if(!o(H))return;let g=o(y).floatingPlacement;if(!o(le)&&(k(le,(o(y).floatingAnchor instanceof HTMLElement?o(y).floatingAnchor:o(y).floatingAnchor?document.querySelector(o(y).floatingAnchor):o(B)?.querySelector(s))||o(B),!0),!o(le))){J("unable to find floating anchor element");return}let _=parseInt(o(y).floatingOffset,10)||12,x=o(le).getBoundingClientRect(),O=o(H).getBoundingClientRect(),R=document.documentElement.clientHeight,G=document.documentElement.clientWidth,Pe=!g||g==="auto"?x.bottom+O.height+_+u>R:g==="top",Q=Math.max(u,Math.min(G-u-O.width,x.left+x.width/2-O.width/2));if(o(H).style.setProperty("--altcha-floating-left",`${Q}px`),o(H).style.setProperty("--altcha-floating-top",Pe?`${x.top-(O.height+_)}px`:`${x.bottom+_}px`),o(H).setAttribute("data-floating-position",Pe?"top":"bottom"),o(V)){let fe=o(V).getBoundingClientRect();o(V).style.left=x.left-Q+x.width/2-fe.width/2+"px"}}async function ol(u,g){let _=await Dn("onRequestServerVerification",u,g);if(_!==void 0)return _;if(J("requesting server verification from",o(y).verifyUrl),!o(y).verifyUrl)throw new Error("Parameter verifyUrl must be set for server verification.");let x=await o(y).fetch(ur(o(y).verifyUrl,o(de)),{body:JSON.stringify({code:g,fields:o(y).serverVerificationFields?Wo():void 0,payload:u,timeZone:o(y).serverVerificationTimeZone?Zo():void 0}),credentials:o(y).credentials||void 0,headers:{"Content-Type":"application/json"},method:"POST"});await ni(x);let O=await x.json();return O&&typeof O=="object"&&"payload"in O&&O.payload&&C("serververification",O),O}function ti(u){o(B)&&"requestSubmit"in o(B)?o(B).requestSubmit(u):o(B)?.reportValidity()&&(u?u.click():o(B).submit())}function ll(u,g={}){let{domain:_,name:x=o(y).name,maxAge:O,path:R,sameSite:G,secure:Pe}=g,Q=`${encodeURIComponent(x)}=${encodeURIComponent(u)}`;_&&(Q+=`; Domain=${_}`),O!=null&&(Q+=`; Max-Age=${O}`),R&&(Q+=`; Path=${R}`),G&&(Q+=`; SameSite=${G}`),Pe&&(Q+="; Secure"),document.cookie=Q}function fr(u){switch(u){case"bar":case"floating":case"overlay":Gr(),(!o(ze)||o(ze)==="off")&&(o(Z).auto="onsubmit");break;case"standard":qr()}o(st)!==u&&k(st,u,!0)}function sl(u){o($e)&&clearTimeout(o($e));let g=()=>{o(E)!==K.UNVERIFIED?(k(ue,!1),Be(K.EXPIRED)):He(),C("expired")},_=u*1e3-Date.now();_>=1?k($e,setTimeout(g,_),!0):g()}async function ni(u){if(u.status>=400){if(u.headers.get("content-type")?.includes("/json")){let _;try{_=await u.json()}catch{}if(_&&"error"in _)throw new Error(`Server responded with ${u.status} - ${_.error}`)}throw new Error(`Server responded with ${u.status}.`)}let g=u.headers.get("content-type");if(!g||!g.includes("/json"))throw new Error(`Server responded with invalid content-type. Expected application/json, received ${g}.`)}async function ri(u){if(!o(ie)){Be(K.ERROR,"Cannot verify code challenge without PoW payload.");return}Be(K.VERIFYING);let g=null;if(o(y).verifyUrl)g=await ol(o(ie),u);else if(o(y).verifyFunction)g=await o(y).verifyFunction(o(ie),u);else{Be(K.ERROR,"Parameter verifyUrl is required for code challenge verification.");return}g?.payload&&(k(ie,g.payload,!0),J("server payload",o(ie))),g?.verified===!0?(J("verified"),Be(K.VERIFIED),C("verified",{payload:o(ie)}),o(ze)==="onsubmit"&&Zt().then(()=>{ti(o(Qe))})):Be(K.ERROR,g?.reason||"Verification failed."),o(y).disableAutoFocus||Yr()?.focus()}function Mn(u){Object.assign(o(Z),{...Object.fromEntries(Object.entries(u).filter(([g,_])=>_!==void 0))})}function cl(){return{...o(y)}}function ul(){return o(E)}function Gr(){k(Oe,!1)}function J(...u){(o(y).debug||u.some(g=>g instanceof Error))&&console[u[0]instanceof Error?"error":"log"]("ALTCHA",`[name=${o(y).name}]`,...u)}function He(u=K.UNVERIFIED,g=null){k(ue,!1),k(xe,g,!0),k(ie,null),o(W)&&o(W).abort(),o($e)&&(clearTimeout(o($e)),k($e,null)),Be(u)}function Be(u,g=null){k(E,u,!0),k(xe,g,!0),C("statechange",{payload:o(ie),state:o(E)})}function qr(){k(Oe,!0),Zt().then(()=>{hr()})}function hr(){if(o(y).display==="floating")return il();k(S,o(S)+1)}async function fn(u={}){let{concurrency:g=Math.max(1,o(y).workers),controller:_=new AbortController,minDuration:x=o(y).minDuration}=u,O=performance.now(),R=null,G=null,Pe=!1,Q=await Dn("onVerify",u);if(Q!==void 0)return Q;He(K.VERIFYING),k(W,_,!0);try{if(!c)throw new Error("Secure context (HTTPS) required.");if(o(y).mockError)throw new Error("Mock error.");if(o(y).test)return J("running test mode with null challenge"),await ut(Math.max(0,x-(performance.now()-O))),o(W)?.signal.aborted?(He(),null):(k(ie,btoa(JSON.stringify({challenge:null,solution:null,test:!0})),!0),J("verified"),Be(K.VERIFIED),C("verified",{payload:o(ie)}),{payload:o(ie)});if(R=await Ja(),!R)throw new Error("Failed to fetch challenge.");J("challenge",R),"configuration"in R&&(J("re-configuring from challenge",R.configuration),Mn(R.configuration)),R.parameters.expiresAt&&sl(R.parameters.expiresAt),Pe="_version"in R&&R._version===1;let fe=globalThis.$altcha.algorithms.get(R.parameters.algorithm);if(!fe)throw new Error(`Unsupported algorithm ${R.parameters.algorithm}.`);if(G=await jo({challenge:R,concurrency:g,controller:_,createWorker:fe,counterMode:Pe?"string":"uint32",onOutOfMemory:Ot=>{if(J("out of memory error received"),C("outofmemory"),o(y).retryOnOutOfMemoryError&&Ot>1){let Pt=Math.floor(Ot/2);return J(`retrying with ${Pt} workers...`),Pt}},timeout:o(y).timeout}),o(W)?.signal.aborted)return He(),null;if(!G)throw new Error("Failed to find solution.");J("solution",G),await ut(Math.max(0,x-(performance.now()-O))),k(ve,R.codeChallenge||o(y).codeChallenge||null,!0),Pe?k(ie,btoa(JSON.stringify(Te(R,G))),!0):k(ie,btoa(JSON.stringify({challenge:{parameters:R.parameters,signature:R.signature},solution:G})),!0),o(ve)?(J("requesting code verification"),Be(K.CODE),C("codechallenge",{codeChallenge:o(ve)})):o(y).verifyUrl?await ri():(J("verified"),Be(K.VERIFIED),C("verified",{payload:o(ie)}))}catch(fe){return J("verification failed",fe),Be(K.ERROR,String(fe)),null}finally{k(W,null)}return{challenge:R,payload:o(ie),solution:G}}var fl={configure:Mn,getConfiguration:cl,getState:ul,hide:Gr,log:J,reset:He,setState:Be,show:qr,updateUI:hr,verify:fn},ai=qc();ge("scroll",fa,el),ge("click",fa,tl),ge("pageshow",rn,nl),ge("resize",rn,rl);var ii=vn(ai);{var hl=u=>{var g=Fc();j(u,g)};pe(ii,u=>{o(y).display==="overlay"&&o(Oe)&&u(hl)})}var ft=ne(ii,2),oi=oe(ft);{var dl=u=>{var g=jc(),_=vn(g),x=ne(_,2);{var O=R=>{var G=Vc();Io(G,()=>document.querySelector(o(y).overlayContent)?.innerHTML,!0),ee(G),j(R,G)};pe(x,R=>{o(y).overlayContent&&R(O)})}ge("click",_,Qo,!0),j(u,g)};pe(oi,u=>{o(y).display==="overlay"&&o(Oe)&&u(dl)})}var Wr=ne(oi,2),Zr=oe(Wr),Jr=oe(Zr),li=oe(Jr);{let u=Ee(()=>o(y).display==="standard"&&o(ze)!=="onsubmit"||o(E)===K.VERIFYING);Qs(li,()=>o(cr),(g,_)=>{_(g,{get id(){return o(Kt)},name:"",get required(){return o(u)},get loading(){return o(zr)},get checked(){return o(ue)},onchange:Jo,oninvalid:Xo})})}var Xr=ne(li,2),vl=oe(Xr);{var pl=u=>{var g=vr();ke(()=>pt(g,o(w).verificationRequired)),j(u,g)},gl=u=>{var g=vr();ke(()=>pt(g,o(w).verifying)),j(u,g)},bl=u=>{var g=vr();ke(()=>pt(g,o(w).verified)),j(u,g)},ml=u=>{var g=vr();ke(()=>pt(g,o(w).label)),j(u,g)};pe(vl,u=>{o(E)===K.CODE&&o(ve)?u(pl):o(E)===K.VERIFYING?u(gl,1):o(E)===K.VERIFIED?u(bl,2):u(ml,-1)})}ee(Xr),ee(Jr);var yl=ne(Jr,2);{var wl=u=>{qa(u,{get strings(){return o(w)}})};pe(yl,u=>{o(On)&&u(wl)})}ee(Zr);var si=ne(Zr,2);{var _l=u=>{{let g=Ee(()=>o(y).display==="bar"&&o(On));Ta(u,{get logo(){return o(g)},get strings(){return o(w)}})}};pe(si,u=>{o(Yt)&&u(_l)})}var ci=ne(si,2);{var kl=u=>{var g=zc();zt(g,_=>k(V,_),()=>o(V)),j(u,g)};pe(ci,u=>{o(y).display==="floating"&&u(kl)})}var xl=ne(ci,2);{var El=u=>{var g=Hc();Ya(g),ke(()=>{q(g,"name",o(y).name),dc(g,o(ie))}),j(u,g)};pe(xl,u=>{o(y).setCookie||u(El)})}ee(Wr);var Sl=ne(Wr,2);{var Cl=u=>{Aa(u,{get anchor(){return o(H)},onClickOutside:()=>{c&&He()},get placement(){return o(y).popoverPlacement},role:"alert",variant:"error",get dir(){return o(Ln)},get updateUISignal(){return o(S)},children:(g,_)=>{var x=ki(),O=vn(x);{var R=Q=>{var fe=Bc();j(Q,fe)},G=Q=>{var fe=Kc(),Ot=oe(fe,!0);ee(fe),ke(()=>pt(Ot,o(w).expired)),j(Q,fe)},Pe=Q=>{var fe=Yc(),Ot=oe(fe,!0);ee(fe),ke(()=>{q(fe,"title",o(xe)),pt(Ot,o(w).error)}),j(Q,fe)};pe(O,Q=>{!o(xe)&&!c?Q(R):!o(xe)&&o(E)===K.EXPIRED?Q(G,1):Q(Pe,-1)})}j(g,x)},$$slots:{default:!0}})},$l=u=>{var g=ki(),_=vn(g);Xs(_,()=>o(ve),x=>{{let O=Ee(()=>o(y).codeChallengeDisplay!=="standard");Aa(x,{get anchor(){return o(H)},get backdrop(){return o(O)},get display(){return o(y).codeChallengeDisplay},onClose:()=>{He()},get placement(){return o(y).popoverPlacement},role:"dialog",get"aria-label"(){return o(w).verificationRequired},get dir(){return o(Ln)},get updateUISignal(){return o(S)},children:(R,G)=>{var Pe=Gc(),Q=vn(Pe);Vo(Q,{get audioUrl(){return o(se)},get imageUrl(){return o(Gt)},onCancel:()=>He(),onReload:()=>fn(),onSubmit:Pt=>ri(Pt),get codeChallenge(){return o(ve)},get config(){return o(y)},get strings(){return o(w)}});var fe=ne(Q,2);{var Ot=Pt=>{Ta(Pt,{get logo(){return o(On)},get strings(){return o(w)}})};pe(fe,Pt=>{o(Yt)&&o(y).codeChallengeDisplay!=="standard"&&Pt(Ot)})}j(R,Pe)},$$slots:{default:!0}})}}),j(u,g)};pe(Sl,u=>{o(xe)||o(E)===K.EXPIRED||!c?u(Cl):o(ve)&&o(E)===K.CODE&&u($l,1)})}ee(ft),zt(ft,u=>k(H,u),()=>o(H)),ke(u=>{q(ft,"data-state",o(E)),q(ft,"data-display",o(y).display||void 0),q(ft,"data-placement",u),q(ft,"data-visible",o(Oe)||void 0),q(ft,"dir",o(Ln)),q(Xr,"for",o(Kt)),ft.dir=ft.dir},[()=>qo(o(y).display)]),j(e,ai);var Tl=It(fl);return i(),Tl}typeof window<"u"&&window.customElements&&!customElements.get("altcha-widget")&&customElements.define("altcha-widget",Bt(Wc,{auto:{type:"String"},challenge:{type:"String"},configuration:{type:"String"},display:{type:"String"},language:{type:"String"},name:{type:"String"},theme:{type:"String"},type:{type:"String"},workers:{type:"Number"}},[],["configure","getConfiguration","getState","hide","log","reset","setState","show","updateUI","verify"]));var zo=`(function() {
  "use strict";
  function bufferStartsWith(buffer, prefix) {
    if (prefix.length > buffer.length) {
      return false;
    }
    for (let i = 0; i < prefix.length; i++) {
      if (buffer[i] !== prefix[i]) {
        return false;
      }
    }
    return true;
  }
  function bufferToHex(buffer) {
    return Array.from(new Uint8Array(buffer)).map((b) => b.toString(16).padStart(2, "0")).join("");
  }
  function concatBuffers(a, b) {
    const out = new Uint8Array(a.length + b.length);
    out.set(a, 0);
    out.set(b, a.length);
    return out;
  }
  function hexToBuffer(hex) {
    if (hex.length % 2 !== 0) {
      throw new Error(\`Hex string must have an even length. Got: \${hex}\`);
    }
    const buffer = new ArrayBuffer(hex.length / 2);
    const view = new DataView(buffer);
    for (let i = 0; i < hex.length; i += 2) {
      const byteString = hex.substring(i, i + 2);
      const byteValue = parseInt(byteString, 16);
      view.setUint8(i / 2, byteValue);
    }
    return new Uint8Array(buffer);
  }
  async function delay(ms) {
    await new Promise((resolve) => setTimeout(resolve, ms));
  }
  function timeDuration(start) {
    return Math.floor((performance.now() - start) * 10) / 10;
  }
  class PasswordBuffer {
    constructor(nonce, mode = "uint32") {
      this.nonce = nonce;
      this.mode = mode;
      this.buffer = new Uint8Array(this.nonce.length + this.COUNTER_BYTES);
      this.buffer.set(this.nonce, 0);
      this.dataView = new DataView(this.buffer.buffer);
    }
    COUNTER_BYTES = 4;
    buffer;
    dataView;
    encoder = new TextEncoder();
    /**
     * Appends the counter to the nonce buffer.
     * In 'string' mode, encodes the counter as a UTF-8 string.
     * In 'uint32' mode, writes the counter as a big-endian 32-bit integer.
     */
    setCounter(n) {
      if (this.mode === "string") {
        return concatBuffers(this.nonce, this.encoder.encode(n.toString()));
      }
      this.dataView.setUint32(this.nonce.length, n, false);
      return this.buffer;
    }
  }
  async function solveChallenge(options) {
    const {
      challenge,
      controller,
      counterMode = "uint32",
      counterStart = 0,
      counterStep = 1,
      deriveKey: deriveKey2,
      timeout = 9e4
    } = options;
    const { nonce, keyPrefix, salt } = challenge.parameters;
    const nonceBuf = hexToBuffer(nonce);
    const saltBuf = hexToBuffer(salt);
    const keyPrefixBuf = keyPrefix.length % 2 === 0 ? hexToBuffer(keyPrefix) : null;
    const password = new PasswordBuffer(nonceBuf, counterMode);
    const start = performance.now();
    let counter = counterStart;
    let iterations = 0;
    let derivedKeyHex = "";
    let lastYield = start;
    while (true) {
      if (controller?.signal.aborted || timeout && iterations % 10 === 0 && performance.now() - start > timeout) {
        return null;
      }
      const { derivedKey } = await deriveKey2(
        challenge.parameters,
        saltBuf,
        password.setCounter(counter)
      );
      if (iterations % 10 === 0 && performance.now() - lastYield > 200) {
        await delay(0);
        lastYield = performance.now();
      }
      if (keyPrefixBuf ? bufferStartsWith(derivedKey, keyPrefixBuf) : bufferToHex(derivedKey).startsWith(keyPrefix)) {
        derivedKeyHex = bufferToHex(derivedKey);
        break;
      }
      counter = counter + counterStep;
      iterations = iterations + 1;
    }
    return {
      counter,
      derivedKey: derivedKeyHex,
      time: timeDuration(start)
    };
  }
  function handler(options) {
    const { deriveKey: deriveKey2 } = options;
    let controller = void 0;
    self.onmessage = async (message) => {
      const { challenge, counterMode, counterStart, counterStep, timeout, type } = message.data;
      if (type === "abort") {
        controller?.abort();
      } else if (type === "work") {
        controller = new AbortController();
        let solution;
        try {
          solution = await solveChallenge({
            challenge,
            controller,
            counterStart,
            counterStep,
            deriveKey: deriveKey2,
            counterMode,
            timeout
          });
        } catch (err) {
          return self.postMessage({ error: err });
        }
        self.postMessage(solution);
      }
    };
  }
  function getDigest(algorithm) {
    switch (algorithm) {
      case "PBKDF2/SHA-512":
        return "SHA-512";
      case "PBKDF2/SHA-384":
        return "SHA-384";
      case "PBKDF2/SHA-256":
      default:
        return "SHA-256";
    }
  }
  async function deriveKey(parameters, salt, password) {
    const { algorithm, cost, keyLength = 32 } = parameters;
    const passwordKey = await crypto.subtle.importKey(
      "raw",
      password,
      { name: "PBKDF2" },
      false,
      ["deriveKey"]
    );
    const derivedKey = await crypto.subtle.deriveKey(
      {
        name: "PBKDF2",
        salt,
        iterations: cost,
        hash: getDigest(algorithm)
      },
      passwordKey,
      { name: "AES-GCM", length: keyLength * 8 },
      true,
      ["encrypt"]
    );
    return {
      derivedKey: new Uint8Array(await crypto.subtle.exportKey("raw", derivedKey))
    };
  }
  handler({
    deriveKey
  });
})();
`,$i=typeof self<"u"&&self.Blob&&new Blob(["(self.URL || self.webkitURL).revokeObjectURL(self.location.href);",zo],{type:"text/javascript;charset=utf-8"});function Wa(e){let t;try{if(t=$i&&(self.URL||self.webkitURL).createObjectURL($i),!t)throw"";let n=new Worker(t,{name:e?.name});return n.addEventListener("error",()=>{(self.URL||self.webkitURL).revokeObjectURL(t)}),n}catch{return new Worker("data:text/javascript;charset=utf-8,"+encodeURIComponent(zo),{name:e?.name})}}var Ho=`(function() {
  "use strict";
  function bufferStartsWith(buffer, prefix) {
    if (prefix.length > buffer.length) {
      return false;
    }
    for (let i = 0; i < prefix.length; i++) {
      if (buffer[i] !== prefix[i]) {
        return false;
      }
    }
    return true;
  }
  function bufferToHex(buffer) {
    return Array.from(new Uint8Array(buffer)).map((b) => b.toString(16).padStart(2, "0")).join("");
  }
  function concatBuffers(a, b) {
    const out = new Uint8Array(a.length + b.length);
    out.set(a, 0);
    out.set(b, a.length);
    return out;
  }
  function hexToBuffer(hex) {
    if (hex.length % 2 !== 0) {
      throw new Error(\`Hex string must have an even length. Got: \${hex}\`);
    }
    const buffer = new ArrayBuffer(hex.length / 2);
    const view = new DataView(buffer);
    for (let i = 0; i < hex.length; i += 2) {
      const byteString = hex.substring(i, i + 2);
      const byteValue = parseInt(byteString, 16);
      view.setUint8(i / 2, byteValue);
    }
    return new Uint8Array(buffer);
  }
  async function delay(ms) {
    await new Promise((resolve) => setTimeout(resolve, ms));
  }
  function timeDuration(start) {
    return Math.floor((performance.now() - start) * 10) / 10;
  }
  class PasswordBuffer {
    constructor(nonce, mode = "uint32") {
      this.nonce = nonce;
      this.mode = mode;
      this.buffer = new Uint8Array(this.nonce.length + this.COUNTER_BYTES);
      this.buffer.set(this.nonce, 0);
      this.dataView = new DataView(this.buffer.buffer);
    }
    COUNTER_BYTES = 4;
    buffer;
    dataView;
    encoder = new TextEncoder();
    /**
     * Appends the counter to the nonce buffer.
     * In 'string' mode, encodes the counter as a UTF-8 string.
     * In 'uint32' mode, writes the counter as a big-endian 32-bit integer.
     */
    setCounter(n) {
      if (this.mode === "string") {
        return concatBuffers(this.nonce, this.encoder.encode(n.toString()));
      }
      this.dataView.setUint32(this.nonce.length, n, false);
      return this.buffer;
    }
  }
  async function solveChallenge(options) {
    const {
      challenge,
      controller,
      counterMode = "uint32",
      counterStart = 0,
      counterStep = 1,
      deriveKey: deriveKey2,
      timeout = 9e4
    } = options;
    const { nonce, keyPrefix, salt } = challenge.parameters;
    const nonceBuf = hexToBuffer(nonce);
    const saltBuf = hexToBuffer(salt);
    const keyPrefixBuf = keyPrefix.length % 2 === 0 ? hexToBuffer(keyPrefix) : null;
    const password = new PasswordBuffer(nonceBuf, counterMode);
    const start = performance.now();
    let counter = counterStart;
    let iterations = 0;
    let derivedKeyHex = "";
    let lastYield = start;
    while (true) {
      if (controller?.signal.aborted || timeout && iterations % 10 === 0 && performance.now() - start > timeout) {
        return null;
      }
      const { derivedKey } = await deriveKey2(
        challenge.parameters,
        saltBuf,
        password.setCounter(counter)
      );
      if (iterations % 10 === 0 && performance.now() - lastYield > 200) {
        await delay(0);
        lastYield = performance.now();
      }
      if (keyPrefixBuf ? bufferStartsWith(derivedKey, keyPrefixBuf) : bufferToHex(derivedKey).startsWith(keyPrefix)) {
        derivedKeyHex = bufferToHex(derivedKey);
        break;
      }
      counter = counter + counterStep;
      iterations = iterations + 1;
    }
    return {
      counter,
      derivedKey: derivedKeyHex,
      time: timeDuration(start)
    };
  }
  function handler(options) {
    const { deriveKey: deriveKey2 } = options;
    let controller = void 0;
    self.onmessage = async (message) => {
      const { challenge, counterMode, counterStart, counterStep, timeout, type } = message.data;
      if (type === "abort") {
        controller?.abort();
      } else if (type === "work") {
        controller = new AbortController();
        let solution;
        try {
          solution = await solveChallenge({
            challenge,
            controller,
            counterStart,
            counterStep,
            deriveKey: deriveKey2,
            counterMode,
            timeout
          });
        } catch (err) {
          return self.postMessage({ error: err });
        }
        self.postMessage(solution);
      }
    };
  }
  async function deriveKey(parameters, salt, password) {
    const { algorithm, keyLength = 32 } = parameters;
    const iterations = Math.max(1, parameters.cost);
    let data = void 0;
    let derivedKey = void 0;
    for (let i = 0; i < iterations; i++) {
      if (i === 0) {
        data = concatBuffers(salt, password);
      } else {
        data = derivedKey;
      }
      derivedKey = new Uint8Array(
        (await crypto.subtle.digest(algorithm, data)).slice(0, keyLength)
      );
    }
    return {
      parameters: {},
      derivedKey
    };
  }
  handler({
    deriveKey
  });
})();
`,Ti=typeof self<"u"&&self.Blob&&new Blob(["(self.URL || self.webkitURL).revokeObjectURL(self.location.href);",Ho],{type:"text/javascript;charset=utf-8"});function Za(e){let t;try{if(t=Ti&&(self.URL||self.webkitURL).createObjectURL(Ti),!t)throw"";let n=new Worker(t,{name:e?.name});return n.addEventListener("error",()=>{(self.URL||self.webkitURL).revokeObjectURL(t)}),n}catch{return new Worker("data:text/javascript;charset=utf-8,"+encodeURIComponent(Ho),{name:e?.name})}}var Zc=`:root {
  --altcha-border-color: var(--altcha-color-neutral);
  --altcha-border-width: 1px;
  --altcha-border-radius: 6px;
  --altcha-color-base: light-dark(oklch(100% 0.00011 271.152), oklch(20.904% 0.00002 271.152));
  --altcha-color-base-content: light-dark(
  	oklch(20.904% 0.00002 271.152),
  	oklch(100% 0.00011 271.152)
  );
  --altcha-color-error: oklch(51.284% 0.20527 28.678);
  --altcha-color-error-content: oklch(100% 0.00011 271.152);
  --altcha-color-neutral: light-dark(oklch(83.591% 0.0001 271.152), oklch(46.04% 0.00005 271.152));
  --altcha-color-neutral-content: light-dark(
  	oklch(46.76% 0.00005 271.152),
  	oklch(100% 0.00011 271.152)
  );
  --altcha-color-primary: oklch(40.279% 0.2449 268.131);
  --altcha-color-primary-content: oklch(100% 0.00011 271.152);
  --altcha-color-success: oklch(55.748% 0.18968 142.511);
  --altcha-color-success-content: oklch(100% 0.00011 271.152);
  --altcha-checkbox-border-color: light-dark(
  	oklch(66.494% 0.00233 15.434),
  	oklch(51.028% 0.00006 271.152)
  );
  --altcha-checkbox-border-radius: 5px;
  --altcha-checkbox-border-width: var(--altcha-border-width);
  --altcha-checkbox-outline: 2px solid var(--altcha-checkbox-outline-color);
  --altcha-checkbox-outline-color: -webkit-focus-ring-color;
  --altcha-checkbox-outline-offset: 2px;
  --altcha-checkbox-size: 22px;
  --altcha-checkbox-transition-duration: var(--altcha-transition-duration);
  --altcha-input-background-color: var(--altcha-color-base);
  --altcha-input-border-radius: 3px;
  --altcha-input-border-width: 1px;
  --altcha-input-color: var(--altcha-color-base-content);
  --altcha-max-width: 320px;
  --altcha-padding: 0.75rem;
  --altcha-popover-arrow-size: 6px;
  --altcha-popover-color: var(--altcha-border-color);
  --altcha-shadow: drop-shadow(3px 3px 6px oklch(0% 0 0 / 0.2));
  --altcha-spinner-color: var(--altcha-color-base-content);
  --altcha-switch-background-color: var(--altcha-color-neutral);
  --altcha-switch-border-radius: calc(infinity * 1px);
  --altcha-switch-height: var(--altcha-checkbox-size);
  --altcha-switch-padding: 0.25rem;
  --altcha-switch-width: calc(var(--altcha-checkbox-size) * 1.75);
  --altcha-switch-toggle-border-radius: 100%;
  --altcha-switch-toggle-color: var(--altcha-color-neutral-content);
  --altcha-switch-toggle-size: calc(
  	var(--altcha-switch-height) - calc(var(--altcha-switch-padding) * 2)
  );
  --altcha-transition-duration: 0.6s;
  --altcha-z-index: 99999999;
  --altcha-z-index-popover: 999999999;
}

@supports (-moz-appearance: none) {
  :root {
    --altcha-checkbox-outline-color: var(--altcha-color-primary);
  }
}
.altcha {
  all: revert-layer;
  display: none;
  font-family: inherit;
  font-size: inherit;
  position: relative;
}
.altcha[data-visible] {
  display: block;
}
.altcha-popover, .altcha-popover * {
  all: revert-layer;
  box-sizing: border-box;
  font-family: inherit;
  font-size: inherit;
  line-height: 1.25;
}
.altcha * {
  all: revert-layer;
  box-sizing: border-box;
  font-family: inherit;
  font-size: inherit;
  line-height: 1.25;
}
.altcha a, .altcha-popover a {
  color: currentColor;
  text-decoration: none;
}
.altcha a:hover, .altcha-popover a:hover {
  color: currentColor;
}
.altcha-main {
  align-items: start;
  background-color: var(--altcha-color-base);
  border: var(--altcha-border-width, 1px) solid var(--altcha-border-color);
  border-radius: var(--altcha-border-radius, 0);
  color: var(--altcha-color-base-content);
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  justify-content: space-between;
  padding: var(--altcha-padding);
  max-width: var(--altcha-max-width, 100%);
}
.altcha-main > * {
  display: flex;
  width: 100%;
}
.altcha-main > *:first-child {
  flex-grow: 1;
}
.altcha-checkbox-wrap {
  align-items: center;
  display: flex;
  flex-direction: row;
  flex-grow: 1;
  gap: 0.5rem;
}
.altcha-checkbox-wrap > * {
  display: flex;
}
.altcha-logo {
  opacity: 0.7;
}
.altcha-footer {
  align-items: center;
  display: flex;
  flex-grow: 1;
  gap: 0.5rem;
  justify-content: flex-end;
  font-size: 0.7rem;
  opacity: 0.7;
}
.altcha-footer p {
  margin: 0;
  padding: 0;
}
.altcha-error {
  font-size: 0.85rem;
}
.altcha-button {
  align-items: center;
  background: var(--altcha-color-primary);
  border: var(--altcha-input-border-width) solid var(--altcha-color-primary);
  border-radius: var(--altcha-input-border-radius);
  color: var(--altcha-color-primary-content);
  cursor: pointer;
  display: flex;
  font-size: 0.9rem;
  gap: 0.5rem;
  padding: 0.35rem;
}
.altcha-button:focus {
  border-color: var(--altcha-color-primary);
  outline: var(--altcha-checkbox-outline);
  outline-offset: var(--altcha-checkbox-outline-offset);
}
.altcha-button > .altcha-spinner, .altcha-button > svg {
  height: 20px;
  width: 20px;
}
.altcha-button-secondary {
  background: transparent;
  border-color: var(--altcha-color-neutral);
  color: var(--altcha-color-neutral-content);
}
.altcha-input {
  background: var(--altcha-input-background-color);
  border: var(--altcha-input-border-width) solid var(--altcha-color-neutral);
  border-radius: var(--altcha-input-border-radius);
  color: var(--altcha-input-color);
  flex-grow: 1;
  font-size: 1rem;
  min-width: 0;
  padding: 0.25rem;
  width: auto;
}
.altcha-input:focus {
  border-color: var(--altcha-color-primary);
  outline: var(--altcha-checkbox-outline);
  outline-offset: var(--altcha-checkbox-outline-offset);
}
.altcha-spinner {
  animation: altcha-rotate 0.6s linear infinite;
  border-radius: 100%;
  border: var(--altcha-checkbox-border-width) solid var(--altcha-spinner-color);
  border-bottom-color: transparent;
  border-right-color: transparent;
  opacity: 0.7;
}
.altcha-popover {
  background-color: var(--altcha-color-base);
  border: var(--altcha-border-width) solid var(--altcha-border-color);
  border-radius: var(--altcha-border-radius);
  color: var(--altcha-color-base-content);
  filter: var(--altcha-shadow);
  position: absolute;
  left: calc(var(--altcha-padding) / 2);
  max-width: calc(var(--altcha-max-width) - var(--altcha-padding));
  top: calc(var(--altcha-padding) + var(--altcha-checkbox-size) + var(--altcha-popover-arrow-size));
  z-index: var(--altcha-z-index-popover);
}
.altcha-popover-arrow {
  border: var(--altcha-popover-arrow-size) solid transparent;
  border-bottom-color: var(--altcha-popover-color);
  content: "";
  height: 0;
  left: calc(var(--altcha-checkbox-size) / 2);
  position: absolute;
  top: calc(var(--altcha-popover-arrow-size) * -2);
  width: 0;
}
.altcha-popover-content {
  max-height: 100dvh;
  overflow: auto;
  padding: var(--altcha-padding);
}
.altcha-popover[data-top=true][data-display=standard] {
  bottom: calc(100% - (var(--altcha-padding) - var(--altcha-popover-arrow-size)));
  top: auto;
}
.altcha-popover[data-top=true][data-display=standard] .altcha-popover-arrow {
  border-bottom-color: transparent;
  border-top-color: var(--altcha-popover-color);
  bottom: calc(var(--altcha-popover-arrow-size) * -2);
  top: auto;
}
.altcha-popover[data-variant=error] {
  --altcha-popover-color: var(--altcha-color-error);
  background-color: var(--altcha-color-error);
  border-color: var(--altcha-color-error);
  color: var(--altcha-color-error-content);
}
.altcha-popover[data-variant=error] .altcha-popover-content {
  padding: calc(var(--altcha-padding) / 1.5) var(--altcha-padding);
}
.altcha-popover[data-display=overlay] {
  animation: altcha-overlay-slidein 0.5s forwards;
  left: 50%;
  position: fixed;
  top: 45%;
  transform: translate(-50%, -50%);
  width: var(--altcha-max-width);
  z-index: var(--altcha-z-index);
}
.altcha-popover[data-display=bottomsheet] {
  animation: altcha-bottomsheet-slideup 0.5s forwards;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  border-bottom: 0;
  bottom: -100%;
  left: 50%;
  position: fixed;
  top: auto;
  transform: translate(-50%, 0);
  width: var(--altcha-max-width);
  z-index: var(--altcha-z-index);
}
.altcha-popover[data-display=bottomsheet] .altcha-popover-content {
  padding-bottom: calc(var(--altcha-padding) * 2);
}
.altcha-popover-backdrop {
  background: var(--altcha-color-base-content);
  bottom: 0;
  left: 0;
  opacity: 0.1;
  position: fixed;
  right: 0;
  top: 0;
  transition: opacity 0.5s;
  z-index: var(--altcha-z-index);
}
.altcha-popover-close {
  color: var(--altcha-color-base-content);
  cursor: pointer;
  display: inline-block;
  font-size: 1rem;
  height: 1.25rem;
  line-height: 0.95;
  position: absolute;
  right: 0;
  text-align: center;
  text-shadow: 0 0 1px var(--altcha-color-base);
  top: -1.5rem;
  width: 1.25rem;
  z-index: var(--altcha-z-index);
}
[dir=rtl] .altcha-popover {
  left: auto;
  right: calc(var(--altcha-padding) / 2);
}
[dir=rtl] .altcha-popover-arrow {
  left: auto;
  right: calc(var(--altcha-checkbox-size) / 2);
}
[dir=rtl] .altcha-popover-close {
  left: 0;
  right: auto;
}
.altcha-popover[data-display=bottomsheet] .altcha-footer, .altcha-popover[data-display=overlay] .altcha-footer {
  align-items: center;
  justify-content: center;
  padding-top: 1rem;
  gap: 0.5rem;
}
.altcha-popover[data-display=bottomsheet] .altcha-footer svg, .altcha-popover[data-display=overlay] .altcha-footer svg {
  height: 18px;
  width: 18px;
  vertical-align: middle;
}
.altcha-code-challenge > form {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.altcha-code-challenge-title {
  font-weight: 600;
}
.altcha-code-challenge-text {
  font-size: 0.85rem;
}
.altcha-code-challenge-image {
  background: white;
  border: var(--altcha-input-border-width) solid var(--altcha-color-neutral);
  border-radius: var(--altcha-input-border-radius);
  object-fit: contain;
  height: 50px;
}
.altcha-code-challenge-row {
  display: flex;
  gap: 0.5rem;
}
.altcha-code-challenge-buttons {
  align-items: center;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin-top: var(--altcha-padding);
  justify-content: space-between;
}
.altcha-code-challenge-buttons button {
  justify-content: center;
  width: 100%;
}
.altcha-checkbox {
  cursor: pointer;
  height: var(--altcha-checkbox-size);
  position: relative;
  width: var(--altcha-checkbox-size);
}
.altcha-checkbox input {
  appearance: none;
  background: var(--altcha-input-background-color);
  border: var(--altcha-checkbox-border-width, 2px) solid var(--altcha-checkbox-border-color);
  border-radius: var(--altcha-checkbox-border-radius);
  cursor: pointer;
  height: var(--altcha-checkbox-size);
  left: 0;
  margin: 0;
  padding: 0;
  position: absolute;
  top: 0;
  width: var(--altcha-checkbox-size);
}
.altcha-checkbox input:before {
  border-radius: var(--altcha-checkbox-border-radius);
  content: "";
  width: 100%;
  height: 100%;
  background: var(--altcha-color-neutral);
  display: block;
  transform: scale(0);
}
.altcha-checkbox input:checked {
  background-color: var(--altcha-color-success);
  border-color: var(--altcha-color-success);
}
.altcha-checkbox input:checked::before {
  background-color: var(--altcha-color-success);
  opacity: 0;
  transform: scale(2.2);
  transition: all var(--altcha-checkbox-transition-duration) ease;
  transition-delay: 0.1s;
}
.altcha-checkbox svg {
  --altcha-radio-svg-size: calc(var(--altcha-checkbox-size) * 0.5);
  --altcha-radio-svg-offset: calc(var(--altcha-checkbox-size) * 0.25);
  fill: none;
  left: var(--altcha-radio-svg-offset);
  height: var(--altcha-radio-svg-size);
  opacity: 0;
  position: absolute;
  stroke: currentColor;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-dasharray: 16px;
  stroke-dashoffset: 16px;
  top: var(--altcha-radio-svg-offset);
  transform: translate3d(0, 0, 0);
  width: var(--altcha-radio-svg-size);
}
.altcha-checkbox input:checked + svg {
  color: var(--altcha-color-success-content);
  opacity: 1;
  stroke-dashoffset: 0;
  transition: all var(--altcha-checkbox-transition-duration) ease;
  transition-delay: 0.1s;
}
.altcha-checkbox-spinner {
  display: none;
  left: 0;
  height: var(--altcha-checkbox-size);
  position: absolute;
  top: 0;
  width: var(--altcha-checkbox-size);
}
.altcha-checkbox[data-loading=true] input {
  appearance: none;
  opacity: 0;
  pointer-events: none;
}
.altcha-checkbox[data-loading=true] .altcha-checkbox-spinner {
  display: block;
}
.altcha-checkbox-native {
  height: var(--altcha-checkbox-size);
  position: relative;
  width: var(--altcha-checkbox-size);
}
.altcha-checkbox-native input {
  height: var(--altcha-checkbox-size);
  margin: 0;
  width: var(--altcha-checkbox-size);
}
.altcha-checkbox-native-spinner {
  display: none;
  left: 0;
  height: var(--altcha-checkbox-size);
  position: absolute;
  top: 0;
  width: var(--altcha-checkbox-size);
}
.altcha-checkbox-native[data-loading=true] input {
  appearance: none;
  opacity: 0;
  pointer-events: none;
}
.altcha-checkbox-native[data-loading=true] .altcha-checkbox-native-spinner {
  display: block;
}
.altcha-switch {
  align-items: center;
  border-radius: var(--altcha-switch-border-radius);
  background-color: var(--altcha-switch-background-color);
  display: flex;
  height: var(--altcha-switch-height);
  padding: var(--altcha-switch-padding);
  position: relative;
  width: var(--altcha-switch-width);
}
.altcha-switch:focus-within {
  outline: var(--altcha-checkbox-outline);
  outline-offset: var(--altcha-checkbox-outline-offset);
}
.altcha-switch input {
  appearance: none;
  cursor: pointer;
  height: 100%;
  left: 0;
  opacity: 0;
  position: absolute;
  top: 0;
  width: 100%;
}
.altcha-switch-toggle {
  align-items: center;
  background-color: var(--altcha-switch-toggle-color);
  border-radius: var(--altcha-switch-toggle-border-radius);
  cursor: pointer;
  display: flex;
  height: var(--altcha-switch-toggle-size);
  justify-content: center;
  left: var(--altcha-switch-padding);
  position: absolute;
  transition: width 150ms ease-out, left 150ms ease-out;
  width: var(--altcha-switch-toggle-size);
}
.altcha-switch-spinner {
  display: none;
  height: var(--altcha-switch-toggle-size);
  width: var(--altcha-switch-toggle-size);
}
.altcha-switch[data-loading=true] {
  pointer-events: none;
}
.altcha-switch[data-loading=true] .altcha-switch-spinner {
  display: block;
}
.altcha-switch[data-loading=true] .altcha-switch-toggle {
  background-color: transparent;
  left: calc(50% - var(--altcha-switch-toggle-size) / 2);
}
[data-state=verified] .altcha-switch {
  --altcha-switch-background-color: var(--altcha-color-success);
}
[data-state=verified] .altcha-switch-toggle {
  background-color: var(--altcha-color-success-content);
  left: calc(100% - var(--altcha-switch-height) + var(--altcha-switch-padding));
}
[dir=rtl] .altcha-switch-toggle {
  left: calc(100% - var(--altcha-switch-height) + var(--altcha-switch-padding));
}
[dir=rtl][data-state=verified] .altcha-switch-toggle {
  left: var(--altcha-switch-padding);
}
.altcha-floating-arrow {
  border: 6px solid transparent;
  border-bottom-color: var(--altcha-border-color);
  content: "";
  height: 0;
  left: 12px;
  position: absolute;
  top: -12px;
  width: 0;
}
.altcha-overlay-backdrop {
  bottom: 0;
  left: 0;
  position: fixed;
  right: 0;
  top: 0;
  transition: opacity var(--altcha-transition-duration);
  z-index: var(--altcha-z-index);
}
.altcha-overlay-close {
  display: inline-block;
  color: currentColor;
  cursor: pointer;
  font-size: 1rem;
  height: 1rem;
  line-height: 0.85;
  position: absolute;
  right: 0;
  text-align: center;
  text-shadow: 0 0 1px var(--altcha-color-base);
  top: -1.5rem;
  width: 1rem;
  z-index: var(--altcha-z-index);
}
.altcha[data-display=overlay] {
  animation: altcha-overlay-slidein var(--altcha-transition-duration) forwards;
  filter: var(--altcha-shadow);
  left: 50%;
  opacity: 0;
  position: fixed;
  top: 45%;
  transform: translate(-50%, -50%);
  z-index: var(--altcha-z-index);
}
.altcha[data-display=overlay] .altcha-main {
  width: var(--altcha-max-width);
}
.altcha[data-display=floating] {
  display: none;
  filter: var(--altcha-shadow);
  left: var(--altcha-floating-left, -100%);
  position: fixed;
  top: var(--altcha-floating-top, -100%);
  z-index: var(--altcha-z-index);
}
.altcha[data-display=floating] .altcha-main {
  width: var(--altcha-max-width);
}
.altcha[data-display=floating][data-floating-position=top] .altcha-floating-arrow {
  border-bottom-color: transparent;
  border-top-color: var(--altcha-border-color);
  bottom: -12px;
  top: auto;
}
.altcha[data-display=floating][data-visible] {
  display: flex;
}
.altcha[data-display=bar] {
  bottom: -100%;
  filter: var(--altcha-shadow);
  left: 0;
  position: fixed;
  right: 0;
  transition: bottom var(--altcha-transition-duration), top var(--altcha-transition-duration);
  z-index: var(--altcha-z-index);
}
.altcha[data-display=bar] .altcha-main {
  align-items: center;
  border-radius: 0;
  border-width: var(--altcha-border-width) 0 0 0;
  flex-direction: row;
  max-width: 100% !important;
}
.altcha[data-display=bar] .altcha-main > * {
  width: auto;
}
.altcha[data-display=bar][data-placement=top] {
  bottom: auto;
  top: -100%;
}
.altcha[data-display=bar][data-placement=top] .altcha-main {
  border-width: 0 0 var(--altcha-border-width) 0;
}
.altcha[data-display=bar][data-placement=bottom]:not([data-state=unverified]) {
  bottom: 0;
}
.altcha[data-display=bar][data-placement=top]:not([data-state=unverified]) {
  top: 0;
}
.altcha[data-display=invisible] {
  display: none;
}

@keyframes altcha-rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes altcha-bottomsheet-slideup {
  100% {
    bottom: 0;
  }
}
@keyframes altcha-overlay-slidein {
  100% {
    opacity: 1;
    top: 50%;
  }
}`;Uc(Zc);$altcha.algorithms.set("SHA-256",()=>new Za);$altcha.algorithms.set("SHA-384",()=>new Za);$altcha.algorithms.set("SHA-512",()=>new Za);$altcha.algorithms.set("PBKDF2/SHA-256",()=>new Wa);$altcha.algorithms.set("PBKDF2/SHA-384",()=>new Wa);$altcha.algorithms.set("PBKDF2/SHA-512",()=>new Wa);
