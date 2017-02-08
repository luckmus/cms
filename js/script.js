

    function showAddOrderFE_cart(msgPlace, goodsId, goodsPrice, userId, fromCart, promo){   

        //$('#'+msgPlace).empty();
        console.log("promo", promo);
        document.getElementById(msgPlace).innerHTML = "";
        var id = Math.floor(Math.random(1,1000000)*1000);
        URL = host+"/modules/FRONTEND/dlgMessages/userSide/add_order_with_cart.php?id="+id+"&fromCart="+fromCart+"&userId="+userId+"&promo="+promo+"&successFnc=showAddOrderBE&successFncParam="+goodsId+",'"+goodsPrice+"',"+id+",'"+userId+"', '"+fromCart+"'&isXML=1&r=" + Math.random();                                                                                             
        runAJAXXML(URL,msgPlace);
        return;
        
    }
        
    function showAddOrderFE(msgPlace, goodsId, goodsPrice, userId){   
    /*     
        //alert(1);
        msgPlace = msgPlace +'1';
       // alert(2);
        $('#'+msgPlace).remove();
        //alert(3);
        $('body').append('<div style= "visibility:hidden" id="'+msgPlace+'"></div>');
        //alert(4);
        */
        
        //$('#'+msgPlace).empty();
        document.getElementById(msgPlace).innerHTML = "";
        var id = Math.floor(Math.random(1,1000000)*1000);
        URL = host+"/modules/FRONTEND/dlgMessages/userSide/add_order.php?id="+id+"&userId="+userId+"&successFnc=showAddOrderBE&successFncParam="+goodsId+",'"+goodsPrice+"',"+id+",'"+userId+"', 'false'&isXML=1&r=" + Math.random();                                                                                             
        runAJAXXML(URL,msgPlace);
        return;
        /*
        //alert(URL+'\n'+msgPlace);
        // формируем AJAX запрос
        try{
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
            //document.getElementById(msgPlace).innerHTML = res[0];
            $('#'+msgPlace).html(res[0]);
            setTimeout(res[1],0)
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert('Ошибка');
            }
        });
        }catch (e){console.log(e);}               
        */
    }
    
    function showAddOrderBE(goodsId, goodsPriceId,id,userId, fromCart, promo){
        URL = host+"modules/BACKEND/userSide/add_order_be.php";
        console.log("fromCart", fromCart);
        var price = $('#'+goodsPriceId).val();
        if ((price==null)||(price=='')){
            price = $('#'+goodsPriceId).html();
        }
        try{   
                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'rcontrdig': $('#rcontrdig'+id).val(),  
                        'name': $('#firstnameid'+id).val(), 
                       'lastname': $('#lastеnameid'+id).val(),
                       'tel':$('#telid'+id).val(),
                       'email':$('#emailid'+id).val(),
                       'adress':$('#adresid'+id).val(),
                       'descr':$('#descrid'+id).val(),
                       'delivery':$('#selected_delivery_method').val(),
                       'userId':userId,
                       'price':price,
                       'promo':promo,
                        'goodsId': goodsId,
                       'fromCart':fromCart},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                     console.log(data);
                        if(data.trim()!="1"){
                            modalAlert("Ошибка записи заказа: \n"+data);
                        }
                        else{
                            deleteCookie('cart');
                            jqAlert('Заказ добавлен', reload);
                            
                            
                        }
                     }
                     });             
                     //*/      
        }catch (e){console.log(e);}
        
    }
    
    function reload(){
        console.log("reload");
        location.reload();
    }
    
    function refreshControlDig(cntrldg){    
        $('#'+cntrldg).attr("src", host+"/icons/ajax-loader.gif");
        $('#'+cntrldg).attr("src", host+"/controldig.php?r=" + Math.random());
    }

    function showAuthorisationFromLogin(loginMsgId, msgPlace){
         showAuthorisationFE(msgPlace,"","");
        $(loginMsgId).dialog( "close" ); 
    
    }
    function showAuthorisationFE(msgPlace, userId){
        var id = Math.floor(Math.random(1,1000000)*1000);
        URL = host+"/modules/FRONTEND/dlgMessages/userSide/registation.php?id="+id+"&userId="+userId+"&successFnc=showAuthorisationBE&successFncParam="+id+",'"+userId+"'&isXML=1&r=" + Math.random();                                                                                             
        //alert(URL+'\n'+msgPlace);
        runAJAXXML(URL,msgPlace);
        return;        
        // формируем AJAX запрос
        try{
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
            document.getElementById(msgPlace).innerHTML = res[0];
            //$('#'+msgPlace).html(res[0]);
            setTimeout(res[1],0)
            },
            error: function(xhr, ajaxOptions, thrownError){
               // alert('add order error \n'+xhr.statusText );
            }
        });
        }catch (e){console.log(e);}    
    } 
    function showAuthorisationBE(id,userId){
        URL = host+"modules/BACKEND/userSide/registration_be.php";
        //alert(URL);
        var mode;
        var oldPwd;
        var successMsg;
        if (userId==""){
            mode = 0;
            oldPwd = "";
            successMsg = 'Вы успешно зарегистрированы!';
        }
        else{
            mode = 3;
            oldPwd =$('#oldpwdid'+id).val();
            successMsg = 'Регистрационные данные успешно изменены!';
        }
        try{   
                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'mode': mode,
                        'userId': userId,
                        'rcontrdig': $('#rcontrdig'+id).val(),  
                        'name': $('#firstnameid'+id).val(), 
                       'lastname': $('#lastеnameid'+id).val(),
                       'tel':$('#telid'+id).val(),
                       'email':$('#emailid'+id).val(),
                       'adress':$('#adresid'+id).val(),
                       'login':$('#loginid'+id).val(),
                       'pwd':$('#pwdid'+id).val(),
                       'oldpwd':oldPwd,
                       'repwd':$('#repwdid'+id).val()},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            modalAlert("Ошибка регистрации: \n"+data);
                            $("#message"+id).dialog(); 
                        }
                        else{
                            modalAlert(successMsg);
                        }
                     },
                     error: function(xhr, ajaxOptions, thrownError){
                        modalAlert("Ошибка регистрации"); 
                        }
                     
                     });             
                     //*/      
        }catch (e){console.log(e);}    
    }
    function showLogin(msgPlace){
        var id = Math.floor(Math.random(1,1000000)*1000);
        URL = host+"/modules/FRONTEND/dlgMessages/userSide/login.php?id="+id+"&successFnc=showLoginBE&successFncParam="+id+"&isXML=1&r=" + Math.random();                                                                                             
        runAJAXXML(URL,msgPlace);
        return;        
        //alert(URL+'\n'+msgPlace);
        // формируем AJAX запрос
        try{
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
            document.getElementById(msgPlace).innerHTML = res[0];
            //$('#'+msgPlace).html(res[0]);
            setTimeout(res[1],0)
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert('add order error \n'+xhr.statusText );
            }
        });
        }catch (e){console.log(e);}    
    }    
    function showLoginBE(id){
        URL = host+"modules/BACKEND/userSide/registration_be.php";
        try{   
                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'mode': 1,
                       'login':$('#login'+id).val(),
                       'pwd':$('#pwd'+id).val()},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data=="1"){
                            modalAlert("Ошибка авторизации: \n"+data);
                            location.href = host;
                            return;
                        }
                        if(data=="0"){
                            modalAlert("Ошибка пары логин/пароль");
                            return;
                        }                        
                        else{
                            modalAlert("Ошибка авторизации");
                        }
                     },
                     error: function(xhr, ajaxOptions, thrownError){
                        alert('Ошибка ' );
                        }
                     });             
                     //*/      
        }catch (e){console.log(e);}
    }
        
    function logOut(){
        URL = host+"modules/BACKEND/userSide/registration_be.php";
        try{   
                     $.ajax({
                     type: "POST",
                     url: URL,             // указываем URL и
                     data:{'mode': 2},
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success*
                        if(data!="1"){
                            modalAlert("Ошибка выхода: \n"+data);
                        }
                        else{
                            location.href = host;
                        }
                     },
                     error: function(xhr, ajaxOptions, thrownError){
                        alert('Ошибка ' );
                        }
                     });             
                     //*/      
        }catch (e){console.log(e);}
    
    }

    function showBuySelectDlg(text, id, addCallBack, cb11, cb12, buyCallBack, cb21, cb22, cb23, cb24 ){
        $(function() {
        id = ("aada"+Math.random()+"_").replace(".", "");
        console.log("id", id);
           $("body").append('<div id="'+id+'"><p class="validateTips">'+text+'</p></div>');
        $( "#"+id ).dialog( "destroy" );
                
        
        
        $( "#"+id ).dialog({
            autoOpen: false,
            height: 160,
            width: 350,
            modal: true,
            title:"Покупка",
            buttons: {   
            /*
                "Купить сейчас": function() {
                  console.log("buy");
                  $( this ).dialog( "close" );
                  buyCallBack(id, cb21, cb22, cb23, cb24);
                  
                },
            */
                "В корзину":function() {
                   console.log("add to card");  
                   $( this ).dialog( "close" );
                   addCallBack(cb11,cb12)
                    
                  
                },
                "Отмена": function() {
                    
                    $( this ).dialog( "close" );
                }   
            },
            
            close: function() {            
            $("body").remove("#"+id);
                //allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });

    });
    $( "#"+id ).dialog( "open" );                                                                                                                          

    }
    
    
    function showCartValue(){    
        showCartValueNum(readCart().length);
    }
                                          
    function showCartValueNum(cartVal){ 
        $("#cart_value").text(cartVal);
    }
    
    function afterAddToCartDialog(url){
    console.log("afterAddToCartDialog", url);
        var id = ("aada"+Math.random()+"_").replace(".", "");           
        console.log("afterAddToCartDialog", id);
        $("body").append('<div id="'+id+'"><p class="validateTips">Успешно добавленно а корзину</p></div>');
                
        
        
        $( "#"+id ).dialog({
            autoOpen: false,
            height: 160,
            width: 350,
            modal: true,
            title:"Покупка",
            buttons: {   
                "Продолжить покупки": function() {
                  console.log("buy");
                  $( this ).dialog( "close" );
                  
                },
                "Перейти в корзину":function() {
                   console.log("add to card");  
                   $( this ).dialog( "close" );
                   window.open(url+"?show=cart","_self");
                    
                  
                }
            },
            
            close: function() {            
            $("body").remove("#"+id);
                //allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });

    $( "#"+id ).dialog( "open" );                                                                                                                          

    }
    
function applyPromo(name){
    var URL = SITE_URL+'/modules/FRONTEND/userSide/promo_info.php?promo='+name
    $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    displayPromoInfo( res);
          }
      catch(err)
          {
            console.log(err);
            return false;
          } 
      
                  
      }
    });
}   

function displayPromoInfo(data){
    if (data.id!=null){
        $('#promo_text').text('Скидка по промо-коду');
        $('#promo_value').text(data.value+'%'+' ('+data.minusSum+data.currency+' )');
        $('#paymentSum').val(data.summ);
        $('#summ_with_promo').text(data.summ+' '+data.currency);
        $('#promo_name_hidden').val(data.name);
    }else{
        
        $('#promo_text').text('');
        $('#promo_value').text('');
        $('#summ_with_promo').text('');
        $('#promo_name_hidden').val('');
        modalAlert(data.msg);
    }
}

function selectDelivery(){
    
    if ($('[name=delivery]:checked').val()==2){
        $('#self_descr').hide("slow");
        $('#cur_descr').show("slow");
        $('#bb_descr').hide("slow");
        $('#bb_curier_info').hide("slow");       
        $('#selected_delivery_method_panel').hide("slow");
    
    }else if ($('[name=delivery]:checked').val()==3){
         $('#self_descr').hide("slow");
        $('#cur_descr').hide("slow");
        $('#bb_descr').show("slow");
        //selectDeleveryMethod(3, null);
        $('#selected_delivery_method_panel').hide("slow");
    }else   if ($('[name=delivery]:checked').val()==1){ 
        $('#self_descr').show("slow");
        $('#cur_descr').hide("slow");
        $('#bb_descr').hide("slow");
        $('#bb_curier_info').hide("slow");
        selectDeleveryMethod(1, null);
          
    }
    else{
       $('#self_descr').show("slow");
        $('#cur_descr').hide("slow");
        $('#bb_descr').hide("slow");
        $('#bb_curier_info').hide("slow");
    }
    
}
/**
  1-самовывоз
  2-ПВЗ
  3-курьер
*/
function selectDeleveryMethod(method, pvz){

    $('#selected_delivery_method').val();
    switch(method){
        case 1:
            $('#selected_delivery_method').val('{"method":1}');
            showDeliveryInfo(method, null);
        break;
        case 2:
            $('#selected_delivery_method').val('{"method":2, "pvzId":"'+pvz.id+'"}');
            showDeliveryInfo(method, pvz);
        break;
        case 3:
            $('#selected_delivery_method').val('{"method":3}');
            showDeliveryInfo(method, null);
        break;
    }
    
}
function showDeliveryInfo(method, pvz){
    $('#selected_delivery_method_panel').show("slow");    
    $('#select_delivery_panel').hide("slow");  
    var text = '<a href="#" onclick="changeDeleveryMethod()"><img src="icons/Pencil-icon.png" alt="Изменить способ доставки" title="Изменить способ доставки"></a>';
    switch(method){
        case 1:
            text += getDeliveryInfoSelf();
        break;
        case 2:
            text += getDeliveryInfoPVZ(pvz);
        break;
    }
    $('#selected_delivery_method_panel').html(text);
}

function getDeliveryInfoPVZ(pvz){
    var text = '<table><tr><td>Город:</td><td>'+pvz.name+'</td></tr><tr><td>Адрес:<td>'+pvz.address+'</td></tr><tr><td>График работы::<td>'+pvz.workschedule+'</td></tr><tr><td>Телефон:<td>'+pvz.phone+'</td></tr><tr><td>Стоимость доставки:<td><b>'+pvz.price+' руб.</b></td></tr><tr><td>Срок доставки:<td><b>'+pvz.period+' дней</b></td></tr></table>';
    return text;
}

function getDeliveryInfoSelf(){
    var text = '<div>Самовывоз</div>';
    return text;
}

function changeDeleveryMethod(){
   $('#selected_delivery_method_panel').hide("slow");    
   $('#select_delivery_panel').show("slow");  
   $('#selected_delivery_method').val('');
   $('[name=delivery]:checked').removeAttr('checked');     
   selectDelivery();
}



