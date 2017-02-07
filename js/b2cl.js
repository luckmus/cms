function searchIndex(name){
    URL = 'http://127.0.0.1/cms/modules/FRONTEND/userSide/delivery.php?action=zipcity&city='+name;
    console.log(URL);
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    if (res.flag_error==0){
                        getDeliveryPosobility(res.zip, 100, 100);
                    
                    }
          }
      catch(err)
          {
            console.log(err);
          } 
      
                  
      }
    });
}

function getDeliveryPosobility(index, price, weight){
    URL = 'http://127.0.0.1/cms/modules/FRONTEND/userSide/delivery.php?action=tarif&index='+index+'&price='+price+'&weight='+weight;
    
    console.log(URL);
      $.ajax({
      url: URL,
      context: document.body,
      success: function(data){                                                               
      try
          {
                    console.log( data );
                    var res = jQuery.parseJSON(data);
                    applyDeliveryPlaces(res);
          }
      catch(err)
          {
            console.log(err);
          } 
      
                  
      }
    });
}

function applyDeliveryPlaces(places){

    if (places.flag_error>0){
        jqAlert(places.comment, null);
        return;
    }
    var id = "accordion"+getRandId();
    var accordionText = '';
    
    var geoSetted = false;
    var geo1 = 37.64;
    var geo2 = 55.76;
    for(var i=0; i<places.delivery_ways.length; i++){
        var item = places.delivery_ways[i];
       accordionText += placeView(item, id);
       if ((geoSetted==false)){
            var geo = extractGEO(item);
            if (geo!=null){
                geo1 = geo[0];
                geo2 = geo[1];
                geoSetted = true;
            }
       }
    }
    $('#delivery_places').html("<div id='YMapsID' style='width:600px;height:400px'></div>"+'<div id="'+id+'">'+accordionText+' </div>');
    $( "#"+id ).accordion();
    $('#delivery_places').html();
    YMaps.jQuery(function () {
        // ������� ��������� ����� � ����������� ��� � ���������� ����������
        console.log("cart setted -1");
        //var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
        var map = new YMaps.Map(document.getElementById("YMapsID"));
        console.log("cart setted0");    
        // ������������� ��������� ��������� ����������� �����: ����� ����� � ����������� ���������������
        map.setCenter(new YMaps.GeoPoint(geo1, geo2), 10);
        console.log("cart setted");
    });

}

function extractGEO(item){
       if ((item.GPS!='')){
            var from = item.GPS.indexOf("lng:")+4;
            var till = item.GPS.indexOf(";", from);
            geo1 = item.GPS.substring(from, till);
            from = item.GPS.indexOf("lat:")+4;
            till = item.GPS.indexOf(";", from);
            geo2 = item.GPS.substring(from);
            console.log(geo2);
            return new Array(geo1, geo2);
       }
       return null;
}

function placeView(item, id){
    var res = '<h3>'+item.������������+'</h3>';
    res += '<div>';
    
    res += '<div><span class="delivery_item">���������:</span>'+item.���������+"</div>";
    if (item.�����!=''){
        res += '<div><span class="delivery_item">�����:</span>'+item.�����+"</div>";
    }
    if (item['����� ������']!=''){
        res += '<div><span class="delivery_item">����� ������:</span>'+item['����� ������']+"</div>";
    }
    res += "<button onClick=\"$( '#"+id+"' ).accordion( 'option', 'disabled', true );\">�������</button>";
    
    
    res += '</div>';
    return res;
}