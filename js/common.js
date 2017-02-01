function getRandId(){
    return Math.floor(Math.random(1,1000000)*1000);
}
function parseMsgXML(xml){
try
  {
  console.log("xml", xml);
    var obj = jQuery.parseJSON(xml);
    console.log("obj", obj);
    
  }
catch(err)
  {
    alert(err.description);
  }    
    
    return new Array(obj.content,obj.js);
}
function runAJAXXML(URL,MsgPlace){
//console.log("runAJAXXML:"+ URL);
$.ajax({
  url: URL,
  context: document.body,
  success: function(data){
    try
  {
            //console.log( data );
            var res = parseMsgXML(data);
            document.getElementById(MsgPlace).innerHTML = "";
            document.getElementById(MsgPlace).innerHTML = res[0];            
            //setTimeout(res[1],0);
            //console.log( res);
            eval(res[1]);
  }
catch(err)
  {
    //alert(err.description);
    console.log(err);
  } 
  
              
  }
});
            //alert("runAJAXXML");

  
    }
function parseMsgXML1(xml){
    var content = "";
    var js      = "";
     var a = $('<div>').append($(xml).find('content').clone()).remove().html();
     var b = $('<div>').append($(xml).find('content').clone()).remove(); 
     content = $('<div>').append($(b).find('div').clone()).remove().html();
    $('js',xml).each(function(i, _item){
                js = $(_item).text();
            });      
    return new Array(content,js);
}
function runAJAXXML1(URL,MsgPlace){
        $.ajax({
            url: URL,
            dataType: (jQuery.browser.msie) ? "text" : "xml", // проверка IE и выбор типа данных
            success: function(xmlData){
                var data;
                if ( typeof xmlData == "string") {
                    // если это IE то создаем ActiveX объект и приобразуем строковую переменную в XML
                    data = new ActiveXObject( "Microsoft.XMLDOM");
                    data.async = false;
                    data.loadXML( xmlData);
                } else {
                    data = xmlData;
                }
            
            // генерация HTML кода
            var _result = "";            
            var res = parseMsgXML(data);
            //alert("runAJAXXML");
            document.getElementById(MsgPlace).innerHTML = "";
            document.getElementById(MsgPlace).innerHTML = res[0];            
            setTimeout(res[1],0)
            },
        });    
    }
    function reloadTabs(tabId, source){
    
    
    //tabId='allcat-cont';
        $("#"+tabId).html("");
        var URL = host+ source;        
        runAJAXXML(URL,tabId);
        return;
        $.ajax({
            url: URL,
            dataType: (jQuery.browser.msie) ? "text" : "xml", // проверка IE и выбор типа данных
            success: function(xmlData){
                var data;
            
                if ( typeof xmlData == "string") {
                    // если это IE то создаем ActiveX объект и приобразуем строковую переменную в XML
                    data = new ActiveXObject( "Microsoft.XMLDOM");
                    data.async = false;
                    data.loadXML( xmlData);
                } else {
                    data = xmlData;
                }
            // генерация HTML кода
            var _result = "";
            console.log(data);
            var res = parseMsgXML(data);
            document.getElementById(tabId).innerHTML = res[0];
            setTimeout(res[1],0);            
            },
            error: function(XMLHttpRequest, textStatus, errorThrown ){
                alert('Erorr: '+textStatus +"  "+URL );
            }
        });
     
    }
    
    function modalAlert(text){
        URL = host+"/modules/FRONTEND/dlgMessages/alert.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Инфо&msgText="+text+"&isXML=1";                                                                                                 
        runAJAXXML(URL,modalAlertPlace);
        return;
    }
      
    function jqAlert(text, callback){
        var id = ("ada"+Math.random()+"_").replace(".", "");
        $("body").append('<div id="'+id+'"><p class="validateTips">'+text+'</p></div>');
            
            $( "#"+id ).dialog({
                height: 160,
                width: 350,
                modal: true,
                title:"Информация",
                buttons: {   
                    "Ok": function() {
                                $( this ).dialog( "close" );   
                            }
                    },
                
                close: function() {            
                    $("body").remove("#"+id);
                    callback(); 
                }
            }
        );
    }
    
       
    function showAccountData(userId){
        URL = host+"/modules/FRONTEND/dlgMessages/userSide/account_data.php?&userId="+userId+"&title=Инфо&isXML=1&r=" + Math.random();     
        runAJAXXML(URL,modalAlertPlace);
        return;        
        
        $.ajax({
            url: URL,
            dataType: (jQuery.browser.msie) ? "text" : "xml", // проверка IE и выбор типа данных
            success: function(xmlData){
                var data;
                if ( typeof xmlData == "string") {
                    // если это IE то создаем ActiveX объект и приобразуем строковую переменную в XML
                    data = new ActiveXObject( "Microsoft.XMLDOM");
                    data.async = false;
                    data.loadXML( xmlData);
                } else {
                    data = xmlData;
                }
            // генерация HTML кода
            var _result = "";
            var res = parseMsgXML(data);
            document.getElementById(modalAlertPlace).innerHTML = res[0];
            setTimeout(res[1],0)
            }
        });         
    }
    