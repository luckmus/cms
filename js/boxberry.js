function widjetCallback(result){
    console.log(result);
    selectDeleveryMethod(2, result);
}

function getBBPoints(index, price, weigth){

$('#bb_curier_info').hide("slow");
$( "#select_cur_del" ).off('click');
$('#currier_loader').show("slow");
$('#currier_loader').attr("style", "visibility:visible");
URL = host+'/modules/FRONTEND/userSide/delivery.php?action=tarif&index='+index+'&price='+price+'&weight='+weigth;
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    $('#currier_loader').hide("slow");
                    $('#currier_loader').attr("style", "visibility:hidden");
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    if ( Array.isArray(res) && (res[0].err != null)){
                        jqAlert(res[0].err, null);   
                    }else
                    if ((res.price==null) || (res.price==0)){
                        jqAlert('���������� �������� �� ������� ������ ����������', null);
                    }else{
                        showCurrierInfo(res);
                    }
          }
      catch(err)
          {
          $('#currier_loader').hide("slow");
          $('#currier_loader').attr("style", "visibility:hidden");
          jqAlert('������ ��������� ���������� �� ������ ��������, ���������� ����� ��� ��������� � ����', null);
            console.log(err);
          } 
      
                  
      }
    });
}



function showCurrierInfo(info){
console.log("showCurrierInfo", info );  
    if ((Array.isArray(info)==true) && ((info.length<=0) || (info[0].err!=null))){
        console.log(info);
        jqAlert(info[0].err, null);
        return;
    }
    if (Array.isArray(info)==true){
        info = info[0];
    }
    $('#bb_cur_del_price').html(info.price);
    $('#bb_cur_del_period').html(info.delivery_period);
    $('#bb_curier_info').show("slow");   
    $( "#select_cur_del" ).on('click',function() {selectDeleveryMethod(3, info)});
    $( "#bb_delivery_index" ).on('input', function() { clearDeliveryInfoOnChangeIndexAfterCalculatePrice() });
}

function clearDeliveryInfoOnChangeIndexAfterCalculatePrice(){
$( "#bb_delivery_index" ).off('input');
    jqAlert('����������� ��������� ������� ���������� ��������. �� ��������� �� ������ ��������, ���������� ����� ������� ������ ��������',null);
    $('#selected_delivery_method').val('');
    
    changeDeleveryMethod();
}