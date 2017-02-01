    
function buySizeApply1(_this, id, price, size_descr, size, num) {
    $("#netpriceVar_"+id).html(price);    
    $("#size_card_"+id).val(size);
    $("#size_card_descr_"+id).html(size_descr);

//    $('#mitem_'+id+' .card_size').css("font-size", "1.5em");
//    $('#litem_'+id+' .card_size').css("font-size", "1.5em");
//    $(_this).css("font-size", "2em");
    $('#mitem_'+num+' .card_size').removeClass('price_select');
    $('#litem_'+num+' .card_size').removeClass('price_select');
    $(_this).addClass('price_select');
}    