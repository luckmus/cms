//посылает запрос на формирование кэша конфигурации
function getCache(ConfigId,host,parentdiv,CacheStateDivId)
{  
    //alert(1);
    text="<TABLE border='0'><tr>"
    text=text + "<td><IMG SRC='../iface/icons/process.gif'></td>";
    text=text + "<td><b>Идет кэширование конфигурации, <br>это может занять несколько минут</b></td>";
    text=text+"</tr></TABLE>";

    document.getElementById('animation').innerHTML = text;
    document.getElementById('animation').style.display = '';
    document.getElementById('animation').style.top = document.body.scrollTop+ document.body.clientHeight / 2-150;
    document.getElementById('animation').style.height = 100; 
    document.getElementById('animation').style.MozOpacity='0.95';
    try
    {
        document.getElementById('cachestate' + ConfigId).removeChild(document.getElementById(idreswnd));         
    }
    catch (err){}      
 
    reswnd =  document.createElement('DIV');
    reswnd.id='cachestate'+ConfigId;  
    resajaxobjwnd = new sack();
 //alert(host+"GetCache.php/?configid="+ConfigId);      
    resajaxobjwnd.requestFile = host+"ajax/GetCache.php/?confId="+ConfigId+"&extype=xml2xid&mode=cache";    
    resajaxobjwnd.onCompletion = function(){ ShowReportResult(ConfigId, resajaxobjwnd,reswnd,CacheStateDivId); };  
    resajaxobjwnd.runAJAX();
 
}

//фунция выводит результат работы кеширования
function ShowReportResult(wnd, ao,resplace,parentdiv)
{                
        resplace.innerHTML = ao.response;      
          
         try
         {
            document.getElementById('cachestate' + wnd).removeChild(document.getElementById(parentdiv)); 
         }        
         catch (err){ }
         
        document.getElementById('cachestate' + wnd).appendChild(resplace);        
  
          
}