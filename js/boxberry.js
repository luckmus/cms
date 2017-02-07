function widjetCallback(result){
    console.log(result);
}

function getBBPoints(index, price, weigth){

$('#bb_curier_info').hide("slow");
URL = host+'/modules/FRONTEND/userSide/delivery.php?action=tarif&index='+index+'&price='+price+'&weight='+weigth;
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    showCurrierInfo(res);
          }
      catch(err)
          {
            console.log(err);
          } 
      
                  
      }
    });
}

function showCurrierInfo(info){
    if ((info.length<=0) || (info[0].err!=null)){
        console.log(info);
        jqAlert(info[0].err, null);
        return;
    }
    info = info[0];
    $('#bb_cur_del_price').html(info.price_service);
    $('#bb_cur_del_period').html(info.delivery_period);
    $('#bb_curier_info').show("slow");
}