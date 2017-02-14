function widjetCallback(result){
    console.log(result);
    selectDeleveryMethod(2, result);
}

function getBBPoints(index, price, weigth){

$('#bb_curier_info').hide("slow");
$( "#select_cur_del" ).off('click');
URL = host+'/modules/FRONTEND/userSide/delivery.php?action=tarif&index='+index+'&price='+price+'&weight='+weigth;
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    if ((res.price==null) || (res.price==0)){
                        jqAlert('���������� �������� �� ������� ������ ����������', null);
                    }else{
                        showCurrierInfo(res);
                    }
          }
      catch(err)
          {
            console.log(err);
          } 
      
                  
      }
    });
}

function declineParsel(trackNum, onExec){

URL = host+'/modules/FRONTEND/userSide/delivery.php?action=decline&track_num='+trackNum;
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
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