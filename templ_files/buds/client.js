var divElements=document.getElementsByTagName("div");for(var jixt=0;jixt<divElements.length;jixt++)if(divElements[jixt].id.search("liveTexButton_")!=-1){var port=window.livetexTest?":"+window.livetexTest:"";divElements[jixt].innerHTML='<img src="'+(/https/.test(document.location.href)?"https":"http")+"://cs15.livetex.ru"+port+'/img/loadbtn.gif" width="80" height="12" class="livetexBtnPreloader" />'}window.livetexTestLoadingFSB="undef: step = start",window.livetexTestLink="",window.console||(window.console={log:function(a){},error:function(a){},debug:function(a){}}),window.livetexTestLoadingFSB="undef: step = console start";if(window.liveTex&&window.liveTexID&&window.liveTex_object){window.liveTex=function(a){var b,c,d,e,f,g=a,h=window.livetexTest?":"+window.livetexTest:"",i=/https/.test(document.location.href)?"https":"http",j=/livetexLog/.test(document.location.href),k=!1,l=!1,m={},n,o,p,q="",r=function(a,b,c,d){var f=0,g=!1,h=m.check(),i=function(a,b,c){var d;f+=1,d=jquery15.ajax({url:a,dataType:b,timeout:f*1e3+5e3}),typeof d.fail!="undefined"?d.fail(n):d.error(n),d.success(c)},j=function(a,b){i(a,"jsonp",function(a){if(g)return;g=!0,b(a)})},k=function(a,b){i(a,"script",function(){if(g)return;g=!0,b()})},l=function(){switch(b){case"jsonp":j(a,c);break;case"script":k(a,c);break;default:return}},n=function(){var b="";if(g)return;b+="_"+a+"_"+(e||"none")+"_"+h+"_"+m.check()+"_",f<6?setTimeout(l,1e3):s("timeout_"+d,b,"")};l()};window.livetexTestLoadingFSB="undef: step = livetex start",m.start=(new Date).getTime(),m.check=function(){return(new Date).getTime()-this.start},m.step=function(a){window.console&&j&&console.log(a+" "+this.check())};var s=function(a,b,c){var d={msg:encodeURIComponent(b),script:a},e=encodeURIComponent("["+document.location.href+"]").split("#").join("");c&&(d.stack=c),jquery15.post(i+"://cs15.livetex.ru/errcheck2.php?b="+encodeURIComponent(navigator.userAgent)+"&u=["+e+"]",d)},t=function(a){var b=a.fn.jquery.split(".")[0].toString(),c=a.fn.jquery.split(".")[1].toString(),d=a.fn.jquery.split(".")[2]?a.fn.jquery.split(".")[2].toString():0;return c.length>1&&(c=c[0]),a.fn&&+b>=1&&+c>=7&&(+c==7?+d>=2:!0)},u=function(){window.livetexTestLoadingFSB="undef: step = _onload (start)",m.step("liveTex test: step 5");if(!window.liveTexLabel)return setTimeout(u,100),!0;window.livetexTestLoadingFSB="undef: step = _onload(after livetexlabel load)";if(k)return!1;window.livetexTestLoadingFSB="undef: step = _onload(after flag loaded)",k=!0;try{if(window.liveSettings){window.livetexTestLoadingFSB="undef: step = _onload(we got livesettings)",m.step("liveTex test: step 6"),liveSettings.jarl.id&&(window.livetexTestLoadingFSB="undef: step = _onload(into label)",m.step("liveTex test: step 7"),b=new liveTexLabel(liveSettings.jarl),m.step("liveTex test: step 8"),c=new liveTexAutoWelcome(b,liveSettings.auto),m.step("liveTex test: step 9"),window.liveSettings.jarl_sound&&(d=new liveTexSoundLabel(liveSettings.jarl_sound))),window.livetexTestLoadingFSB="undef: step = _onload(after label)";if(window.liveSettings.buttons&&window.liveSettings.buttons.length){window.livetexTestLoadingFSB="undef: step = _onload(into buttons)";for(var a=0,e=liveSettings.buttons.length;a<e;a++)typeof liveSettings.buttons[a]!="undefined"&&new liveTexButton(liveSettings.buttons[a])}window.livetexTestLoadingFSB="undef: step = _onload(after buttons)",m.step("liveTex test: step 10"),jquery15.cookie("livetex_uid",liveSettings.id_session,{path:"/",expires:20160}),jquery15.cookie("livetex_siteid",liveSettings.id_site,{path:"/",expires:20160})}window.livetexTestLoadingFSB="1"}catch(f){if(/BingPreview/.test(navigator.userAgent))return;s("catched_onload",f.message,f.stack),window.livetexTestLoadingFSB="FSB Except =|"+f.message+"|"}},v=function(a){if(a&&a.error){s("custom_badrequest",a.error,a.stack);return}if(!a){s("custom_livetexsimple_empty",q,{});return}window.livetexTestLoadingFSB="undef: step = livetex preload(start)",m.step("liveTex test: step 4"),m.step("4");var b,c,d={},e={},f=!1;window.livetexTestLoadingFSB="undef: step = livetex preload(before settings)";for(var j=0,k=a.button_list.length;j<k;j++)d["id"+a.button_list[j].local_id]=a.button_list[j];window.livetexTestLoadingFSB="undef: step = livetex preload(after buttons)";for(var l=0,n=a.auto_list.length;l<n;l++)a.auto_list[l].local_id=="-1"?(f=!0,e.id1=a.auto_list[l]):e["id"+a.auto_list[l].local_id]=a.auto_list[l];window.livetexTestLoadingFSB="undef: step = livetex preload(prepared settings)",f&&liveSettings.auto.splice(0,1,{id:1,settings:{no_chat:"true",time_sec_page:"1"},oper:{say:""},is_active:!1,is_activated:!1}),window.livetexTestLoadingFSB="undef: step = livetex preload(splice label)";for(var o=0,p=liveSettings.buttons.length;o<p;o++){if(typeof liveSettings.buttons[o]=="undefined"){liveSettings.buttons.splice(o,1),o-=1,p-=1;continue}b="id"+liveSettings.buttons[o].id.split("liveTexButton_").join(""),c=d[b],c?(liveSettings.buttons[o].name=c.member_firstname,liveSettings.buttons[o].depart=c.group_name,liveSettings.buttons[o].foto=c.member_photo_url,liveSettings.buttons[o].state=!!c.state,liveSettings.buttons[o].no_group=a.flag_no_group,liveSettings.buttons[o].voice||(liveSettings.buttons[o].member_id=c.member_id,liveSettings.buttons[o].group_id=c.group_id),liveSettings.buttons[o].flag_custom===1&&(c.state?(liveSettings.buttons[o].width=liveSettings.buttons[o].customSettings.custom_w,liveSettings.buttons[o].height=liveSettings.buttons[o].customSettings.custom_h,liveSettings.buttons[o].custom_def_w=liveSettings.buttons[o].customSettings.custom_w,liveSettings.buttons[o].custom_def_h=liveSettings.buttons[o].customSettings.custom_h):(liveSettings.buttons[o].width=liveSettings.buttons[o].customSettings.custom_woff,liveSettings.buttons[o].height=liveSettings.buttons[o].customSettings.custom_hoff,liveSettings.buttons[o].custom_def_w=liveSettings.buttons[o].customSettings.custom_woff,liveSettings.buttons[o].custom_def_h=liveSettings.buttons[o].customSettings.custom_hoff))):(liveSettings.buttons.splice(o,1),o-=1,p-=1)}window.livetexTestLoadingFSB="undef: step = livetex preload(set buttons)";for(var t=0,v=liveSettings.auto.length;t<v;t++)b="id"+liveSettings.auto[t].id,c=e[b],!c||!c.state?liveSettings.auto[t]=null:(liveSettings.auto[t].oper.name=c.member_firstname+" "+c.member_lastname,liveSettings.auto[t].oper.bg=c.member_photo_url,liveSettings.auto[t].oper.member_id=c.member_id,liveSettings.auto[t].oper.depart=c.group_name,liveSettings.auto[t].member_id=c.member_id,liveSettings.auto[t].group_id=c.group_id,b=="id1"&&(liveSettings.auto[t].oper.say=c.text));window.livetexTestLoadingFSB="undef: step = livetex preload(set auto)";for(var w=0,x=liveSettings.auto.length,y=[];w<x;w++)liveSettings.auto[w]!==null&&y.push(liveSettings.auto[w]);window.livetexTestLoadingFSB="undef: step = livetex preload(del auto)",liveSettings.auto=y,liveSettings.session_part_id=a.session_id,liveSettings.session_part_key=a.session_key,liveSettings.stable=a.flag_server_stable?"stable":"unstable",liveSettings.id_session=a.session_id+a.session_key,liveSettings.id_site=g,liveSettings.jarl.state=a.flag_state,liveSettings.state=a.flag_state,liveSettings.jarl.no_group=a.flag_no_group,liveSettings.jarl_sound&&(liveSettings.jarl_sound.flag_slabel_state=!!a.flag_slabel_state),liveSettings.location={},liveSettings.location.country_name=a.country_name,liveSettings.location.region_name=a.region_name,liveSettings.location.city_name=a.city_name;var z=jquery15.ajaxSettings.cache;jquery15.ajaxSettings.cache=!0,i==="https"&&(h="");var A=i+"://cs15.livetex.ru"+h+"/js/compiled/from_server_body.min.js";r(A,"script",u,"fsb"),window.livetexTestLoadingFSB="FSBLOAD: step = livetex preload(script start loading)",window.livetexTestLink=A,m.step("liveTex test: step 4.1"),jquery15.ajaxSettings.cache=z},w=function(b){window.livetexTestLoadingFSB="undef: step = jquery onload(start)",m.step("liveTex test: step 2");if(l)return!1;window.livetexTestLoadingFSB="undef: step = jquery onload(before version check)";if(!window.jQuery||!t(window.jQuery))return setTimeout(function(){w(b)},100),m.step("liveTex test: step 2.05 - repeat, jQ version is - "+(window.jQuery?jQuery.fn.jquery:"none")),!0;window.livetexTestLoadingFSB="undef: step = jquery onload(after version check)",l=!0,window.console&&$&&$.fn&&j&&console.log("$-ver pre1: "+$.fn.jquery),b?(window.livetexTestLoadingFSB="undef: step = jquery onload(new loaded version check)",window.jquery15=jQuery.noConflict(!0),window.console&&$&&$.fn&&j?console.log("$-ver post2-1: "+$.fn.jquery):window.console&&j&&console.log("$-ver post2-1 error ")):(window.livetexTestLoadingFSB="undef: step = jquery onload(old version check)",window.jquery15=jQuery,window.console&&$&&$.fn&&j?console.log("$-ver post2-2: "+$.fn.jquery):window.console&&j&&console.log("$-ver post2-2 error ")),window.jquery15.cookie=function(a,b,c){var d="undefined"!=typeof c&&c.expires?c.expires:"",e="undefined"!=typeof c&&c.path?"; path="+c.path:"",f="undefined"!=typeof c&&c.domain?"; domain="+c.domain:"",g="undefined"!=typeof c&&c.secure?"; secure":"",h={ONE_MINUTE:6e4},i=function(a){var b=document.cookie&&0<document.cookie.length,c=b?document.cookie:null;return null===c?null:l(c.split(";"),a)},j=function(a,b,c,d,e,f){return d=m(d),document.cookie=[a,"=",encodeURIComponent(b),d,c,e,f].join(""),b},k=function(a,b,c,d){return j(a,"",b,-1,c,d)},l=function(a,b){var c=null,d=null,e=null,f;for(f=0;f<a.length;f++){d=jquery15.trim(a[f]),c=d.substring(0,b.length+1);if(c===b+"="){e=decodeURIComponent(d.substring(b.length+1));break}}return e||null},m=function(a){var b;return"number"==typeof a?(b=new Date,b.setTime(b.getTime()+a*h.ONE_MINUTE),"; expires="+b.toUTCString()):"undefined"!=typeof a&&a&&a.toUTCString?"; expires="+a.toUTCString():""};return"undefined"==typeof b?i(a):null===b?k(a,e,f,g):j(a,b,e,d,f,g)},m.step("liveTex test: step 2.1");var c;(a+"").length<3?c="0"+(a+""):c=a;var d=(c+"").length-3,e=["js/settings/",(c+"").substr(d,1)+"","/",(c+"").substr(d+1,1),"/",(c+"").substr(d+2,1),"/",c,".js?r=",Math.floor(Math.random()*1e4)].join("");window.livetexTestLoadingFSB="undef: step = jquery onload(path)",i==="https"&&(h="");var f=i+"://cs15.livetex.ru"+h+"/"+e;window.livetexTestLoadingFSB="undef: step = jquery onload(before load script)",r(f,"script",x,"settings"),window.livetexTestLoadingFSB="SETTINGS: step = jquery onload(after load script)",window.livetexTestLink=f},x=function(){var a=[i,"://",window.livetexBalancer||"lb3.livetex.ru","/","?sender=client&action=getserver"].join("");m.step("liveTex test: step 2.2 - settings loaded, start preload balancer"),y(a),window.livetexTestLoadingFSB="BALANCER: step = settings onload ver2(after start balancer loading ["+a+"])",m.step("liveTex test: step 2.3 - start after start preload balancer")},y=function(a){var b=B("livetex_balancer");if(b!=null&&window.JSON!==undefined&&window.JSON.parse!==undefined){b=JSON.parse(b);if(b.result_info&&b.result_info==="ok"){window.console&&j&&console.log("Balancer cached"),z(b);return}}window.console&&j&&console.log("Balancer load"),r(a,"jsonp",z,"balancer")},z=function(b,c){!c&&b.result_info&&b.result_info==="ok"&&window.JSON!==undefined&&window.JSON.stringify!==undefined&&jquery15.cookie("livetex_balancer",JSON.stringify(b),{path:"/",expires:5}),window.livetexTestLoadingFSB="undef: step = balancer onload(start)",m.step("liveTex test: step 3"),window.console&&j&&console.log(b),e=B("livetex_uid")||null;var d=B("livetex_time_all")||"0";p=+B("livetex_countpage"),o=+B("livetex_visit");if(p===0||o===0)o+=1;p+=1;var g=jquery15("title").text().substring(0,1024)||"null",h=f=b.server,k=new Date;k=k.getTime();var l="/?site_id="+a+"&session_id="+e,s=D(),t=s?"&seo_type=true&seo_engine="+s.engine+"&seo_q="+encodeURIComponent(s.query):"&seo_type=false",u=window.livetexAdditional?"&additional="+encodeURIComponent(livetexAdditional):"";window.livetexTestLoadingFSB="undef: step = balancer onload(after vars)";var w=s&&s.realReferrer!=""?s.realReferrer:document.referrer;l+="&referer="+(encodeURIComponent(w)||"null")+"&url="+encodeURIComponent(document.location.href).split("#").join("")+u+"&use_time="+d+"&use_visits="+o+"&use_pages="+p+"&title="+encodeURIComponent(g)+"&nocache="+k+t+"&flag_simple=true&settings="+A(),window.livetexTestLoadingFSB="undef: step = balancer onload(after getstring)",i==="https"&&(h=h.split(":80").join("")),l=i+"://"+h+l,window.livetexTestLoadingFSB="undef: step = balancer onload(after serv split)",q=l,r(l,"jsonp",v,"http"),window.livetexTestLoadingFSB="undef: step = balancer onload(after script load)",m.step("liveTex test: step 3.1"),n=m.check(),window.livetexTestLoadingFSB="HTTP: step = balancer onload(after step check)",window.livetexTestLink=l},A=function(){if(!window.liveSettings){s("custom_liveSettings_empty","Empty liveSettings",{});return}window.livetexTestLoadingFSB="undef: step = getsettings onload (start)";var a="",b="",c;for(var d=0,e=liveSettings.buttons.length;d<e;d++)window.livetexTestLoadingFSB="undef: step = getsettings onload (in buttons)",a&&(a+="-"),a+=[liveSettings.buttons[d].id.split("liveTexButton_").join(""),liveSettings.buttons[d].member_id,liveSettings.buttons[d].group_id].join(".");window.livetexTestLoadingFSB="undef: step = getsettings onload (after buttons)";for(var f=0,g=liveSettings.auto.length;f<g;f++)window.livetexTestLoadingFSB="undef: step = getsettings onload (in auto)",b&&(b+="-"),b+=[liveSettings.auto[f].id,liveSettings.auto[f].member_id,liveSettings.auto[f].group_id].join(".");return window.livetexTestLoadingFSB="undef: step = getsettings onload (after auto)",c="("+a+")("+b+")",window.console&&j&&console.log("liveTex Settings: "+c),c},B=function(a){window.livetexTestLoadingFSB="undef: step = begin cookie (start)";var b=null;if(document.cookie&&document.cookie!=""){var c=document.cookie.split(";");for(var d=0;d<c.length;d++){var e=String.prototype.trim?c[d]==null?"":c[d].trim():c[d]==null?"":c[d].toString().replace(/^\s+/,"").replace(/\s+$/,"");if(e.substring(0,a.length+1)==a+"="){b=decodeURIComponent(e.substring(a.length+1));break}}}return window.livetexTestLoadingFSB="undef: step = begin cookie (finish cookie)",b},C=function(a,b){window.livetexTestLoadingFSB="undef: step = begin create script (start)",window.livetexTestLoadingFSB="undef: step = create script";var c=document.getElementsByTagName("head")[0],d=document.createElement("script");d.type="text/javascript",d.src=a,d.onload=d.onreadystatechange=b,c.appendChild(d),window.livetexTestLoadingFSB="undef: step = begin cookie (finish script)"},D=function(){window.livetexTestLoadingFSB="undef: step = referer script(start)";var a=[{start:"http://www.google.",query:"q",name:"google"},{start:"http://yandex.",query:"text",name:"yandex"},{start:"rambler.ru/search",query:"query",name:"rambler"},{start:"http://go.mail.ru/",query:"q",name:"mailru"},{start:"http://www.bing.com/",query:"q",name:"bing"},{start:"search.yahoo.com/search",query:"p",name:"yahoo"},{start:"http://ru.ask.com/",query:"q",name:"ask"},{start:"http://search.qip.ru/search",query:"query",name:"qip"}],b=document.referrer,c="",d="",e,f;window.livetexTestLoadingFSB="undef: step = referer script(after engines)";for(var g in a){if(!a.hasOwnProperty(g))continue;if(b.indexOf(a[g].start)==-1)continue;e=b.indexOf("?"+a[g].query+"=");if(e==-1){e=b.indexOf("&"+a[g].query+"=");if(e==-1)return!1}d=a[g].name,c=a[g].query,f=a[g].hasOwnProperty("cp1251")}window.livetexTestLoadingFSB="undef: step = referer script(after for)";if(!d)return!1;b=b.substr(e+c.length+2);var h=b.indexOf("&");window.livetexTestLoadingFSB="undef: step = referer script(after indexof)",h!=-1&&(b=b.substr(0,h));if(f){window.livetexTestLoadingFSB="undef: step = referer script(before 1251)";function i(a){var b=unescape("%u0402%u0403%u201A%u0453%u201E%u2026%u2020%u2021%u20AC%u2030%u0409%u2039%u040A%u040C%u040B%u040F%u0452%u2018%u2019%u201C%u201D%u2022%u2013%u2014%u0000%u2122%u0459%u203A%u045A%u045C%u045B%u045F%u00A0%u040E%u045E%u0408%u00A4%u0490%u00A6%u00A7%u0401%u00A9%u0404%u00AB%u00AC%u00AD%u00AE%u0407%u00B0%u00B1%u0406%u0456%u0491%u00B5%u00B6%u00B7%u0451%u2116%u0454%u00BB%u0458%u0405%u0455%u0457"),c=function(a){return a>=192&&a<=255?String.fromCharCode(a-192+1040):a>=128&&a<=191?b.charAt(a-128):String.fromCharCode(a)},d="";for(var e=0;e<a.length;e++)d+=c(a.charCodeAt(e));return d}b=unescape(b),b=i(b)}else b=decodeURIComponent(b);window.livetexTestLoadingFSB="undef: step = referer script(afer 1251)",b=b.replace(/[+]+/g," "),window.livetexTestLoadingFSB="undef: step = referer script(afer reg)";var j="";if(d==="google"){var k=/&q=(.+?)&/;if(k.test(document.referrer)){var l=k.exec(document.referrer);j="http://google.com/search?q="+l[1]}}return{engine:d,query:b,realReferrer:j}};return m.step("liveTex test: step 1"),!window.jQuery||!t(window.jQuery)?(window.livetexTestLoadingFSB="undef: step = loading jq 1.7.2",m.step("liveTex test: step 1.1"),C(i+"://cs15.livetex.ru"+h+"/js/jquery-1.7.2.min.js",function(){m.step("liveTex test: step 1.1.1"),w(!0)}),m.step("liveTex test: step 1.1.0")):(window.livetexTestLoadingFSB="undef: step = NOT loading jq 1.7.2",m.step("liveTex test: step 1.2"),w(!1),m.step("liveTex test: step 1.2.0")),{label:function(){return b},auto_welcome:function(){return c},site_id:function(){return g},getServer:function(){return f},getStatus:function(){return window.liveSettings?liveSettings.state:!1},hideLabel:function(){window.jquery15&&jquery15("#content_"+liveSettings.jarl.id).hide()},showLabel:function(){if(window.liveSettings&&liveSettings.jarl&&liveSettings.jarl.flag_hide_offline&&!liveSettings.jarl.state)return;window.jquery15&&jquery15("#"+liveSettings.jarl.id).show()}}};if(window.liveTex_object===!0){window.livetexTestLoadingFSB="undef: step = livetex start create";try{liveTex_object=new liveTex(liveTexID)}catch(e){jquery15.post("http://cs15.livetex.ru/errcheck.php?b="+encodeURIComponent(navigator.userAgent)+"&u=["+encodeURIComponent("["+document.location.href+"]").split("#").join("")+"]",{msg:encodeURIComponent(e.message),script:"catched_livetexObject",stack:e.stack})}window.ltAPI=liveTex_object,window.livetexTestLoadingFSB="undef: step = livetex create"}}else console.log(window.liveTex),console.log(window.liveTexID),console.log(window.liveTex_object),window.livetexTestLoadingFSB="undef: step = bad site settings";