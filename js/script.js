

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
        // ��������� AJAX ������
        try{
        $.ajax({
            url: URL,
            dataType: (jQuery.browser.msie) ? "text" : "xml", // �������� IE � ����� ���� ������
            success: function(xmlData){
                var data;
                if ( typeof xmlData == "string") {
                    // ���� ��� IE �� ������� ActiveX ������ � ����������� ��������� ���������� � XML
                    data = new ActiveXObject( "Microsoft.XMLDOM");
                    data.async = false;
                    data.loadXML( xmlData);
                } else {
                    data = xmlData;
                }
            // ��������� HTML ����
            var _result = "";
            var res = parseMsgXML(data);
            //document.getElementById(msgPlace).innerHTML = res[0];
            $('#'+msgPlace).html(res[0]);
            setTimeout(res[1],0)
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert('������');
            }
        });
        }catch (e){console.log(e);}               
        */
    }
    
    function showAddOrderBE(goodsId, goodsPriceId,id,userId, fromCart, promo){
        if ($('#selected_delivery_method').val().trim()==''){
            jqAlert('������ �������� �� ������.', null);
            return;
        }
        $('#apply_loader').attr("style", "visibility:visible");
        $( "#apply_order_btn" ).prop( "disabled", true );
        URL = host+"modules/BACKEND/userSide/add_order_be.php";
        console.log("fromCart", fromCart);
        var price = $('#'+goodsPriceId).val();
        if ((price==null)||(price=='')){
            price = $('#'+goodsPriceId).html();
        }
        try{   
                     $.ajax({
                     type: "POST",
                     url: URL,             // ��������� URL �
                     data:{'rcontrdig': $('#rcontrdig'+id).val(),  
                        'name': $('#firstnameid'+id).val(), 
                       'lastname': $('#last�nameid'+id).val(),
                       'tel':$('#telid'+id).val(),
                       'email':$('#emailid'+id).val(),
                       //'adress':$('#adresid'+id).val(),
                       'descr':$('#descrid'+id).val(),
                       'delivery':$('#selected_delivery_method').val(),
                       'userId':userId,
                       'price':price,
                       'promo':promo,
                       'goodsId': goodsId,
                       'fromCart':fromCart},
                     success: function (data, textStatus) { // ������ ���� ���������� �� ������� success*
                     $('#apply_loader').attr("style", "visibility:hidden");
                     console.log(data);
                     
                        var res = jQuery.parseJSON(data);  
                        console.log("res", res);
                        if((res.err!='') || (res.order_id==0)){
                        $( "#apply_order_btn" ).prop( "disabled", false );
                            modalAlert("������ ������ ������: \n"+res.err);
                        }
                        else{
                            deleteCookie('cart');
                            //jqAlert('����� ��������', reload);
                            var msg_add = "����� ��������";
                            if (parseInt(res.ediscount)>0){
                                 msg_add += "<br/>��� ������ ������ � �����, ��� ���������������  �������������� <b>"+parseInt(res.ediscount)+"% ���������� ������</b>.";
                            }
                            jqAlert(msg_add, function(){
        $( "#id_MNT_AMOUNT" ).val(res.price);
        $( "#id_MNT_TRANSACTION_ID" ).val(res.order_id);
        var token = "&token="+res.token;
        $( "#id_MNT_SUCCESS_URL" ).val($( "#id_MNT_SUCCESS_URL" ).val()+token);
        $( "#id_MNT_RETURN_URL" ).val($( "#id_MNT_RETURN_URL" ).val()+token);
        $( "#id_MNT_FAIL_URL" ).val($( "#id_MNT_FAIL_URL" ).val()+token);
        $( "#id_MNT_INPROGRESS_URL" ).val($( "#id_MNT_INPROGRESS_URL" ).val()+token);
        console.log("res", res);
        console.log("MNT_INPROGRESS_URL", $( "#id_MNT_INPROGRESS_URL" ).val());                              
        console.log("id_MNT_FAIL_URL", $( "#id_MNT_FAIL_URL" ).val());                              
        console.log("id_MNT_RETURN_URL", $( "#id_MNT_RETURN_URL" ).val());                              
        console.log("id_MNT_FAIL_URL", $( "#id_MNT_FAIL_URL" ).val());                              
        jqAlert("������� �� �������� ������...", null)
        $( "#payanyway_from" ).submit();});
                            
                        }
                     }
                     });             
                     //*/      
        }catch (e){console.log(e);$('#apply_loader').attr("style", "visibility:hidden");$( "#apply_order_btn" ).prop( "disabled", false );}
        
    }   
    
    function sendToPay(res){
        $( "#id_MNT_AMOUNT" ).val(res.price);
        $( "#id_MNT_TRANSACTION_ID" ).val(res.order_id);
        console.log("res", res);
        jqAlert("������� �� �������� ������...", null)
        $( "#payanyway_from" ).submit();
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
        // ��������� AJAX ������
        try{
        $.ajax({
            url: URL,                                                                                                                                          
            dataType: (jQuery.browser.msie) ? "text" : "xml", // �������� IE � ����� ���� ������
            success: function(xmlData){
                var data;
                if ( typeof xmlData == "string") {
                    // ���� ��� IE �� ������� ActiveX ������ � ����������� ��������� ���������� � XML
                    data = new ActiveXObject( "Microsoft.XMLDOM");
                    data.async = false;
                    data.loadXML( xmlData);
                } else {
                    data = xmlData;
                }
            // ��������� HTML ����
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
            successMsg = '�� ������� ����������������!';
        }
        else{
            mode = 3;
            oldPwd =$('#oldpwdid'+id).val();
            successMsg = '��������������� ������ ������� ��������!';
        }
        try{   
                     $.ajax({
                     type: "POST",
                     url: URL,             // ��������� URL �
                     data:{'mode': mode,
                        'userId': userId,
                        'rcontrdig': $('#rcontrdig'+id).val(),  
                        'name': $('#firstnameid'+id).val(), 
                       'lastname': $('#last�nameid'+id).val(),
                       'tel':$('#telid'+id).val(),
                       'email':$('#emailid'+id).val(),
                       'adress':$('#adresid'+id).val(),
                       'login':$('#loginid'+id).val(),
                       'pwd':$('#pwdid'+id).val(),
                       'oldpwd':oldPwd,
                       'repwd':$('#repwdid'+id).val()},
                     success: function (data, textStatus) { // ������ ���� ���������� �� ������� success*
                        if(data!="1"){
                            modalAlert("������ �����������: \n"+data);
                            $("#message"+id).dialog(); 
                        }
                        else{
                            modalAlert(successMsg);
                        }
                     },
                     error: function(xhr, ajaxOptions, thrownError){
                        modalAlert("������ �����������"); 
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
        // ��������� AJAX ������
        try{
        $.ajax({
            url: URL,
            dataType: (jQuery.browser.msie) ? "text" : "xml", // �������� IE � ����� ���� ������
            success: function(xmlData){
                var data;
                if ( typeof xmlData == "string") {
                    // ���� ��� IE �� ������� ActiveX ������ � ����������� ��������� ���������� � XML
                    data = new ActiveXObject( "Microsoft.XMLDOM");
                    data.async = false;
                    data.loadXML( xmlData);
                } else {
                    data = xmlData;
                }
            // ��������� HTML ����
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
                     url: URL,             // ��������� URL �
                     data:{'mode': 1,
                       'login':$('#login'+id).val(),
                       'pwd':$('#pwd'+id).val()},
                     success: function (data, textStatus) { // ������ ���� ���������� �� ������� success*
                        if(data=="1"){
                            modalAlert("������ �����������: \n"+data);
                            location.href = host;
                            return;
                        }
                        if(data=="0"){
                            modalAlert("������ ���� �����/������");
                            return;
                        }                        
                        else{
                            modalAlert("������ �����������");
                        }
                     },
                     error: function(xhr, ajaxOptions, thrownError){
                        alert('������ ' );
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
                     url: URL,             // ��������� URL �
                     data:{'mode': 2},
                     success: function (data, textStatus) { // ������ ���� ���������� �� ������� success*
                        if(data!="1"){
                            modalAlert("������ ������: \n"+data);
                        }
                        else{
                            location.href = host;
                        }
                     },
                     error: function(xhr, ajaxOptions, thrownError){
                        alert('������ ' );
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
            title:"�������",
            buttons: {   
            /*
                "������ ������": function() {
                  console.log("buy");
                  $( this ).dialog( "close" );
                  buyCallBack(id, cb21, cb22, cb23, cb24);
                  
                },
            */
                "� �������":function() {
                   console.log("add to card");  
                   $( this ).dialog( "close" );
                   addCallBack(cb11,cb12)
                    
                  
                },
                "������": function() {
                    
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
        $("body").append('<div id="'+id+'"><p class="validateTips">������� ���������� � �������</p></div>');
                
        
        
        $( "#"+id ).dialog({
            autoOpen: false,
            height: 160,
            width: 400,
            modal: true,
            title:"�������",
            buttons: {   
                "���������� �������": function() {
                  console.log("buy");
                  $( this ).dialog( "close" );
                  
                },
                "������� � �������":function() {
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
    var URL = host+'/modules/FRONTEND/userSide/promo_info.php?promo='+name;
    $('#promo_loader').attr("style", "visibility:visible");
    $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    $('#promo_loader').attr("style", "visibility:hidden");
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    displayPromoInfo( res);
          }
      catch(err)
          {
          $('#promo_loader').attr("style", "visibility:hidden");
          jqAlert(err, null);
            console.log(err);
            return false;
          } 
      
                  
      }
    });
}   

function displayPromoInfo(data){
    if (data.id!=null){
        $('#promo_text').text('������ �� �����-����');
        $('#promo_value').text(data.value+'%'+' ('+data.minusSum+data.currency+' )');
        $('#paymentSum').val(data.summ);
        $('#summ_with_promo').text(data.summ+' '+data.currency);
        $('#promo_name_hidden').val(data.name);
    }else{
        
        $('#promo_text').text('');
        $('#promo_value').text('');
        $('#summ_with_promo').text('');
        $('#promo_name_hidden').val('');        
        $('#promo_id').text('');
        $('#promo_id').val('');
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
        $('#selected_delivery_method_panel').hide("slow");
        $('#bb_delivery_index').focus();
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
  1-���������
  2-���
  3-������
*/
function selectDeleveryMethod(method, pvz){

    $('#selected_delivery_method').val('');
    switch(method){
        case 1:
            $('#selected_delivery_method').val('{"method":1}');
            showDeliveryInfo(method, null);
        break;
        case 2:
            $('#selected_delivery_method').val('{"method":2, "pvzId":'+JSON.stringify(pvz)+'}');      
            showDeliveryInfo(method, pvz);
        break;
        case 3:
            $('#selected_delivery_method').val('{"method":3, "curr":'+JSON.stringify(pvz)+'}');
            showDeliveryInfo(method, pvz);
            
        break;
    }
    console.log($('#selected_delivery_method').val());
    
}
function showDeliveryInfo(method, pvz){
    
    var text = '<a href="#" onclick="changeDeleveryMethod()"><img src="icons/Pencil-icon.png" alt="�������� ������ ��������" title="�������� ������ ��������"></a>';
    switch(method){
        case 1:
            text += getDeliveryInfoSelf();
        break;
        case 2:
            text += getDeliveryInfoPVZ(pvz);
        break;
        case 3:
            var res = getDeliveryInfoCur(pvz);
            if (res!=false){
                text += res;
            }else{
                return false;
            }
        break;
    }
    $('#selected_delivery_method_panel').show("slow");    
    $('#select_delivery_panel').hide("slow");  
    $('#selected_delivery_method_panel').html(text);
    return true;
}

function getDeliveryInfoPVZ(pvz){
    var text = '<table><tr><td>�����:</td><td>'+pvz.name+'</td></tr><tr><td>�����:<td>'+pvz.address+'</td></tr><tr><td>������ ������::<td>'+pvz.workschedule+'</td></tr><tr><td>�������:<td>'+pvz.phone+'</td></tr><tr><td>��������� ��������:<td><b>'+pvz.price+' ���.</b></td></tr><tr><td>���� ��������:<td><b>'+pvz.period+' ����</b></td></tr></table>';
    return text;
}

function getDeliveryInfoSelf(){
    var text = '<div>���������</div>';
    return text;
}

function changeDeleveryMethod(){
   $('#selected_delivery_method_panel').hide("slow");    
   $('#select_delivery_panel').show("slow");  
   $('#selected_delivery_method').val('');
   $('[name=delivery]:checked').removeAttr('checked');     
   selectDelivery();
}

function getDeliveryInfoCur(info){
    if ($('#cur_city_name').val().trim()==''){
        jqAlert('�������� ����������� ������ �� �������', null);
        $('#selected_delivery_method').val('');
        return false;
    }
    if ($('#cur_address').val().trim()==''){
        jqAlert('�����, �� �������� ���������� ����������� ��������, �� ������', null);
        $('#selected_delivery_method').val('');
        return false;
    }
    
    var text = '<table><tr><td>���������� �����:</td><td>'+$('#cur_city_name').val().trim()+'</td></tr><tr><td>�����:<td>'+$('#cur_address').val().trim()+'</td></tr><tr><td>��������� ��������:<td><b>'+info.price+' ���.</b></td></tr><tr><td>���� ��������:<td><b>'+info.delivery_period+' ����</b></td></tr></table>';
    var deliveryDescr = JSON.parse(   $('#selected_delivery_method').val());
    deliveryDescr.address = $('#cur_address').val().trim();    
    deliveryDescr.city = $('#cur_city_name').val().trim();
    deliveryDescr.index = $('#bb_delivery_index').val().trim();    
    $('#selected_delivery_method').val(JSON.stringify(deliveryDescr)); 
    //console.log($('#selected_delivery_method').val());
    return text;
}





