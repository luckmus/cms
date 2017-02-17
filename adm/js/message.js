    function deleteParamValueFE(paramValId,delMsgPlace,tabId){                    
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+getRandId()+"&title=Параметры&msgText=Удалить значение параметра?&successFnc=deleteParamValueBE&successFncParam="+paramValId+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
    }
    function deleteParamValueBE(paramValId, tabId){
        //alert('value = '+value+' val = '+val);
        var URL = host+"adm/BACKEND/em_param_values.php?mode=delete&id="+paramValId;
        //alert(URL);
        $.ajax({
            url: URL,             // указываем URL и
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            modalAlert("Ошибка  удаления параметра "+data);
                        }
                        else{
                         $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                             
                        }
                     }
            });            
    }
    function edtParamValueFE(pid, paramValId, delMsgPlace,tabId){ 
        var id = getRandId();
        URL = host+"/modules/FRONTEND/dlgMessages/param_value_edt.php?id="+id+"&mode="+1+"&pid="+pid+"&paramValId="+paramValId+"&successFnc=addParamValueBE&successFncParam='edit',"+paramValId+","+id+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
       runAJAXXML(URL,delMsgPlace);
   }
    function addParamValueFE(pid, delMsgPlace,tabId){ 
        var id = getRandId();
        URL = host+"/modules/FRONTEND/dlgMessages/param_value_edt.php?id="+id+"&mode="+0+"&pid="+pid+"&successFnc=addParamValueBE&successFncParam='add',"+pid+","+id+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
       runAJAXXML(URL,delMsgPlace);
   }        
    
    function addParamValueBE(mode, pid, id, tabId){
        var value = $('#name'+id).val();
        var descrVal = $('#descr'+id).val();

        //alert('value = '+value+' val = '+val);
        var URL = host+"adm/BACKEND/em_param_values.php?mode="+mode+"&pid="+pid+"&value="+value+"&descr="+descrVal;
        //alert(URL);
        $.ajax({
            url: URL,             // указываем URL и
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  сохранения параметра "+data);
                        }
                        else{
                         $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                             
                        }
                     }
            });            
    }

function addCategParam(backUrl, id, dialogId,tabId){  
                    backUrl = backUrl+"&pid="+id;
                    //alert(backUrl);
                     $.ajax({
                     url: backUrl,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success                   
                        if (data!=1){
                            alert('Ошибка добавления характеристики категории');
                        }
                        
                        $("#"+tabId).tabs("load", $("#"+tabId).tabs("option", "selected")); 
                        dialogId.dialog( "close" );
                     }
                     });    
}

    function deleteCatParamFE(cid, id,delMsgPlace,tabId){                    
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Категории&msgText=Удалить категорию?&successFnc=deleteCatParamBE&successFncParam="+cid+","+id+","+tabId+"&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
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
            document.getElementById(delMsgPlace).innerHTML = res[0];
            setTimeout(res[1],0)
            }
        });
               
    }
    
    function  deleteCatParamBE(cid,pid,tabId){
        var URL = host+ "adm/BACKEND/em_category_params_be.php?mode=delparam&id="+cid+"&pid="+pid;
        //alert(URL);
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления характеристики "+data);
                        }
                        else{
                            //alert(tabId);
                             $(tabId).tabs("load", $(tabId).tabs("option", "selected"));
                             
                        }
                     }
                     });        
    }
        //0 - вниз, 1 - вверх
    function moveCatParam(cid,pid,tabId, moveMode){
        var mode;
        switch(moveMode){
            case 0: 
                mode = "downparam";
            break;
            case 1: 
                mode = "upparam";
            break;
            default:
                return;
            break;
        }
        var URL = host+ "adm/BACKEND/em_category_params_be.php?mode="+mode+"&id="+cid+"&pid="+pid;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            modalAlert("Ошибка  смещения характеристики: "+data);
                        }
                        else{
                             $(tabId).tabs("load", $(tabId).tabs("option", "selected"));
                             
                        }
                     }
                     });         
    }
    function deleteCatFE(cid,delMsgPlace,tabId){                    
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Удаление&msgText=Удалить значение?&successFnc=deleteCatBE&successFncParam="+cid+","+"'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        // формируем AJAX запрос
        runAJAXXML(URL,delMsgPlace);
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
            document.getElementById(delMsgPlace).innerHTML = res[0];
            setTimeout(res[1],0)
            }
        });
               
    } 
    function deleteCatBE(cid,tabId){   
        var URL = host+ "adm/BACKEND/em_category_params_be.php?mode=del&id="+cid;
        //alert(URL);
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления Категории "+data);
                        }
                        else{
                        //alert('Ok '+tabId);
                        //reloadCategTabs(tabId);
                        reloadTabs(tabId, "adm/jCategory.php");
                            // $(tabId).tabs("load", $(tabId).tabs("option", "selected"));
                             
                        }
                     }
                     });        
    }
    
    function setGoodsParamValFE(type, goodId, paramId, delMsgPlace,tabId){  
        var id = Math.floor(Math.random(1,1000000)*1000);
        var valIDContName = 'param'+goodId+''+paramId+''+id;
        var valContName = 'paramval'+goodId+''+paramId+''+id;
        URL = host+"/modules/FRONTEND/dlgMessages/goods_param_edt.php?id="+id+"&act="+type+"&goodId="+goodId+"&paramId="+paramId+"&successFnc=setGoodsParamValBE&successFncParam="+type+","+goodId+",'"+valIDContName+"','"+valContName+"','"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        // формируем AJAX запрос
     
     runAJAXXML(URL,delMsgPlace);
    } 
    
    
    function EdtGoodsParamValFE(type, goodId, paramId, paramValueId, delMsgPlace,tabId){ 
        var id = Math.floor(Math.random(1,1000000)*1000);
        var valIDContName = 'param'+goodId+''+paramId+''+id;
        var valContName = 'paramval'+goodId+''+paramId+''+id;
        URL = host+"/modules/FRONTEND/dlgMessages/goods_param_edt.php?id="+id+"&act="+type+"&goodId="+goodId+"&paramId="+paramId+"&successFnc=setGoodsParamValBE&successFncParam="+type+","+paramValueId+",'"+valIDContName+"','"+valContName+"','"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
       runAJAXXML(URL,delMsgPlace);
    }    
    
    
       
    
    function setGoodsParamValBE(type,goodId, valueId, value, tabId){
        var valiD = $('#'+valueId).val();
        var val = "";
        if ($('#'+value).val()!=null){
            val = $('#'+value).val();
        }
        //alert('value = '+value+' val = '+val);
        var URL = host+"adm/BACKEND/em_goods_param_be.php?mode="+type+"&id="+goodId+"&valueId="+valiD+"&value="+val;
        //alert(URL);
        $.ajax({
            url: URL,             // указываем URL и
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  сохранения параметра "+data);
                        }
                        else{
                         $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                             
                        }
                     }
            });            
    }
     
    
    function deleteGoodParamFE(goodid, valueid,paramId,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Параметры товара&msgText=Удалить параметр?&successFnc=deleteGoodParamBE&successFncParam="+goodid+","+valueid+","+paramId+",'"+tabId+"'&isXML=1";                                                                                             
        console.log("URL", URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function deleteGoodParamBE(goodId,valueId, paramId, tabId){
        var URL = host+"adm/BACKEND/em_goods_param_be.php?mode="+2+"&id="+goodId+"&valueId="+valueId+"&paramId="+paramId;
        //alert(URL);
        $.ajax({
            url: URL,             // указываем URL и
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления параметра "+data);
                        }
                        else{
                            console.log("deleteGoodParamBE");  
                            $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                            //reloadTabs(tabId, "adm/jCategory.php");
                        }
                     }
            });            
    } 

    function archivateGoodsFE(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Товары&msgText=Перенести в архив?&successFnc=archivateGoodsBE&successFncParam="+goodid+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function archivateGoodsBE(goodId, tabId){      
       var URL = host+"adm/BACKEND/em_goods_be.php?mode="+5+"&id="+goodId;
        //alert(URL);
        reloadTabs(tabId,"adm/goods.php");
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления "+data);
                        }
                        else{ 
                            reloadTabs(tabId, "adm/goods.php");
                        }
                     }
                     });    
    }
    
   


    function unArchivateGoodsFE(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Товары&msgText=Перенести в товары?&successFnc=unArchivateGoodsBE&successFncParam="+goodid+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function unArchivateGoodsBE(goodId, tabId){      
       var URL = host+"adm/BACKEND/em_goods_be.php?mode="+6+"&id="+goodId;
        //alert(URL);
        reloadTabs(tabId,"adm/goods.php");
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления "+data);
                        }
                        else{ 
                            reloadTabs(tabId, "adm/goods.php");
                        }
                     }
                     });    
    }

    function deleteGoodsFE(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Товары&msgText=Удалить?&successFnc=deleteGoodsBE&successFncParam="+goodid+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function deleteGoodsBE(goodId, tabId){      
       var URL = host+"adm/BACKEND/em_goods_be.php?mode="+2+"&id="+goodId;
        //alert(URL);
        reloadTabs(tabId,"adm/goods.php");
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления "+data);
                        }
                        else{ 
                            reloadTabs(tabId, "adm/goods.php");
                        }
                     }
                     });    
    }
    function addGoodsFE(delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/add_new_goods.php?mode=1&id="+Math.floor(Math.random(1,1000000)*1000)+"&tabId="+tabId+"&isXML=1";        
        runAJAXXML(URL,delMsgPlace);
    }
    
    function addGoodsBE(goodsName, catId,tabId){  
       var name = $( "#"+goodsName ).val();    
       var categ = $( "#"+catId ).val();    
       var URL = host+"adm/BACKEND/em_goods_be.php?mode=1"+"&name="+name+"&catId="+categ;
        //alert(URL);
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  добавления "+data);
                        }
                        else{                         
                        reloadTabs(tabId, "adm/goods.php");
                        }
                     }
                     });    
    }
    function copyGoodsFEConfirm(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Товары&msgText=Копировать товар?&successFnc=copyGoodsBE&successFncParam="+goodid+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function copyGoodsFE(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/add_new_goods.php?mode=2&id="+Math.floor(Math.random(1,1000000)*1000)+"&tabId="+tabId+"&goodId="+goodid+"&isXML=1";        
        runAJAXXML(URL,delMsgPlace);
    }
        
    function copyGoodsBE(goodsId, newName, tabId){   
       var name = $( "#"+newName ).val();
       var URL = host+"adm/BACKEND/em_goods_be.php?mode=3"+"&id="+goodsId+"&name="+name+"&tabId="+tabId;
        //alert(URL);
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  копирования "+data);
                        }
                        else{                         
                        reloadTabs(tabId, "adm/goods.php");
                        }
                     }
                     });    
    }  
    
    function saveGoodsBE(agoodId, acatId, aname, adescr, aimageFile, ametaDescription, ametakeywords, tabId){
        var vcatId           = $( "#"+acatId ).val();
        var vname            = $( "#"+aname ).val();
        var vdescr           = $( "#"+adescr ).val();
        var vdescr           = tinyMCE.get(adescr).getContent();
        var vimageFile       = $( "#"+aimageFile ).val();
        var vmetaDescription = $( "#"+ametaDescription ).val();
        //var vmetaDescription = "";
        var vmetakeywords    = $( "#"+ametakeywords ).val();
        //var vmetakeywords    = "";
        
        URL = host+"adm/BACKEND/em_goods_be.php";
        try{   

                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'mode': 4,
                       'name': vname, 
                       'catId': vcatId,
                       'goodId':agoodId,
                       'descr':vdescr,
                       'imageFile':vimageFile,
                       'metaDescription':vmetaDescription,
                       'metakeywords':vmetakeywords},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  копирования "+data);
                        }
                        else{                         
                            $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                        }
                     }
                     });             
                     //*/      
        }catch (e){alert(e);}
    }  
    
function savePromoBE(id, aname, adescr, avalue, adate, tabId, mode){
        var vname            = $( "#"+aname ).val();
        var vdescr           = tinyMCE.get(adescr).getContent();
        var vvalue       = $( "#"+avalue ).val();
        var vdate = $( "#"+adate ).val();
        
        URL = host+"adm/BACKEND/em_promo_be.php";
        try{   

                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'mode': mode,
                       'name': vname, 
                       'descr': vdescr,
                       'value':vvalue,
                       'date':vdate,
                       'id':id},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  копирования "+data);
                        }
                        else{                         
                            $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                        }
                     }
                     });             
                     //*/      
        }catch (e){alert(e);}
    }    
    
    function addPromoFE(delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/add_new_promo.php?mode=1&id="+Math.floor(Math.random(1,1000000)*1000)+"&tabId="+tabId+"&isXML=1";        
        runAJAXXML(URL,delMsgPlace);
    }
    function addPromoBE(goodsName,tabId){  
       var name = $( "#"+goodsName ).val();       
       var URL = host+"adm/BACKEND/em_promo_be.php?mode=1"+"&name="+name;
        //alert(URL);
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  добавления "+data);
                        }
                        else{  
                            reloadTabs(tabId, "adm/promo.php");
                        }
                     }
                     });    
    }
    
    function deletePromoFE(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Промо-коды&msgText=Удалить?&successFnc=deletePromoBE&successFncParam="+goodid+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function deletePromoBE(goodId, tabId){      
       var URL = host+"adm/BACKEND/em_promo_be.php?mode="+2+"&id="+goodId;
        //alert(URL);
        //reloadTabs(tabId,"adm/goods.php");
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  удаления "+data);
                        }
                        else{ 
                            reloadTabs(tabId, "adm/promo.php");
                        }
                     }
                     });    
    }
    
    function copyPromoFEConfirm(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/confirm.php?id="+Math.floor(Math.random(1,1000000)*1000)+"&title=Промо-коды&msgText=Копировать промо-код?&successFnc=copyPromoFE&successFncParam="+goodid+",'"+tabId+"'&isXML=1";                                                                                             
        //alert(URL);
        runAJAXXML(URL,delMsgPlace);
               
    }    
    
    function copyPromoFE(goodid,delMsgPlace,tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/add_new_promo.php?mode=2&id="+Math.floor(Math.random(1,1000000)*1000)+"&tabId="+tabId+"&id="+goodid+"&isXML=1";        
        console.log("copyPromoFE", URL);
        runAJAXXML(URL,delMsgPlace);
    }
    
    function copyPromoBE(goodsId, newName, tabId){   
       var name = $( "#"+newName ).val();
       var URL = host+"adm/BACKEND/em_promo_be.php?mode=3"+"&id="+goodsId+"&name="+name+"&tabId="+tabId;
        //alert(URL);
        //return;
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  копирования "+data);
                        }
                        else{                         
                        reloadTabs(tabId, "adm/promo.php");
                        }
                     }
                     });    
    }
    
    function addPhotoGalFE(delMsgPlace,goodsId, tabId){        
        URL = host+"/modules/FRONTEND/dlgMessages/selectGoodsPhotos.php?mode=1&id="+Math.floor(Math.random(1,1000000)*1000)+"&tabId="+tabId+"&goods_id="+goodsId+"&isXML=1&msgId="+delMsgPlace;        
        console.log(URL);
        runAJAXXML(URL,delMsgPlace);
    }    
    
     function addGalleryPhotoBE(goodId, photo, descr, tabId, msgId){      
     console.log("tabId", tabId);
      //$("body").remove("#"+msgId);
        URL = host+"adm/BACKEND/em_goods_be.php";
        try{   
                     descr = $('#'+descr).val();
                     photo = $('#'+photo).val();
                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'mode': 7,
                       'photo': photo, 
                       'descr': descr,
                       'goodId':goodId},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            alert("Ошибка  добавления "+data);
                        }
                        else{                         
                            $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
                        }
                     }
                     });             
                     //*/      
        }catch (e){alert(e);}  
    }
    
    function deleteGalPhoto(id, tabId){
        alert('реализовать удаление '+id);
        $('#'+tabId).tabs("load", $('#'+tabId).tabs("option", "selected"));
    }