function sendAddParcel(orderId){
URL = host+'/modules/FRONTEND/userSide/delivery.php?action=add&orderId='+orderId;
console.log('send order add to bb', orderId);
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
            console.log( data );
            var res = jQuery.parseJSON(data);
            //jqAlert(res.err, null);
            if (res.err!=null){
                jqAlert(res.err, null);
            }else{
                jqAlert("���������� � ������ �������� � ������ ��������", reload);
            }
          }
      catch(err)
          {
            console.log(err);
          } 
      
                  
      }
    });

}