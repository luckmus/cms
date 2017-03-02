function sendAddParcel(orderId){
URL = host+'/modules/FRONTEND/userSide/delivery.php?action=add&orderId='+orderId;
console.log('send order add to bb', orderId);
$('#overlay').attr("style", "visibility:visible");
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      $('#overlay').attr("style", "visibility:hidden");
      try
          {
            console.log( data );
            var res = jQuery.parseJSON(data);
            //jqAlert(res.err, null);
            if (res.err!=null){
                jqAlert(res.err, null);
            }else{
                jqAlert("Информация о заказе передана в службу доставки", reload);
            }
          }
      catch(err)
          {
          jqAlert("Ошибка подключения к серверу ББ", null);
            console.log(err);
          } 
      
                  
      }
    });

}

function declineParsel(trackNum, onExec){

    URL = host+'/modules/FRONTEND/userSide/delivery.php?action=decline&track_num='+trackNum;
    $('#overlay').attr("style", "visibility:visible");
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){   
      $('#overlay').attr("style", "visibility:hidden");                                                            
      try
          {
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    onExec(res);
          }
      catch(err)
          {
            console.log(err);
          } 
      
                  
      }
    });
}

function applyDecline(declRes){
    if (declRes.err!=null){
        jqAlert(declRes.err, null);
    }
    else{
        jqAlert(declRes.text, reload);
    }
}