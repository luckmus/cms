var $mopened;
var $lopened;
var openedID;
var bodyH;
var speedScrollX = 75;				// скорость горизонтального скролла
var sw;
var sh;

function detectId(id, defaultId) {

	return id.substr(defaultId.length);

}

$(document).ready(function(){
	sw = $(window).width();
	sh = $(window).height();

	$("#sc").mousewheel(function(event, delta) {
		var $sc = $("#sc");
		var x0 = $sc.scrollLeft();
		$sc.scrollLeft(x0 - delta*speedScrollX);
	});


	$("#bfindopen").click(function() {
		var o = $(this).offset();
		this.blur();
		var $sp = $("#searchpan");
		$sp/*.css("top",o.top-20).css("left",o.left-27)*/.fadeIn(200);
	});

    $('.show_txt_bascket').tooltip();
});                                             

$(window).resize(function() {
	sw = $(this).width();
	sh = $(this).height();
});

function buySizeApply(_this, id, price, size) {
	$("#netpriceVar_"+id).html(price);
    $("#size_card_"+id).val(size);

//    $('#mitem_'+id+' .card_size').css("font-size", "1.5em");
//    $('#litem_'+id+' .card_size').css("font-size", "1.5em");
//    $(_this).css("font-size", "2em");

    $('#mitem_'+id+' .card_size').removeClass('price_select');
    $('#litem_'+id+' .card_size').removeClass('price_select');
    $(_this).addClass('price_select');

}

function unBuble(event) {
	event = event || window.event;
	event.cancelBubble = true;
	if (event.stopPropagation) {
		event.stopPropagation();
	}
}

function addBasket(stock_id, item_id, show) {
    var price = $('#netpriceVar_'+item_id).html();
    var size = $('#size_card_'+item_id).val();

    var processResult = function(result, errors){
        if (result && result.bascket_item) {
            $('#basket').html(result.bascket_item);
            //корзина купили
            $('.buy_'+stock_id).hide();
            $('.buy_ok_'+stock_id).show();

            if (show) {
                $("#cart").fadeIn(200);
                $('#cart-scroll-area').jScrollPane({scrollbarWidth:4, animateStep: 70});
                prepareSumAll();
            }
        } else {
            alert('При добавлении произошла ошибка.');
        }
    }

    JsHttpRequest.query('/ajax/stock/addbasket/', {'stock_id':stock_id, 'price':price, 'size':size}, processResult, true);
}

function rmBasket(id) {
    if(!confirm('Вы точно хотите удалить?')) return;

    var processResult = function(result, errors){
        if (result && result.rez) {
            $('#cart-scroll-area #bascket_card_'+id).remove();
            $('#bascket_img_'+id).remove();
            $('#cart-scroll-area .bascet_table tr:first').css({'background':'0'});
            
            var kol = $('#basket_count').html();
            kol--;
            if (kol <1 ) {
                $('#basket_show').hide();
            } else {
                $('#basket_count').html(kol);
            }

            //корзина купили
            $('.buy_'+id).show();
            $('.buy_ok_'+id).hide();
        } else {
            alert('При удалении произошла ошибка.');
        }
    }

    JsHttpRequest.query('/ajax/stock/rmbasket/', {'id':id}, processResult, true);
}

function cartOpen(obj)
{/*
    var o = $(obj).offset();
    obj.blur();
    var $sp = $("#cart");
        $sp.fadeOut(1);
        $sp.css('display', 'block');
    $sp.fadeIn(200);
    //$('#cart-scroll-area').jScrollPane({scrollbarWidth: 4, reinitialiseOnImageLoad: true, animateStep: 70});
*/
    prepareSumAll();
}

function bascketPrice(obj, event, id)
{
    if(event.keyCode==13) {

        var val = obj.value;
        val = val.replace(/[^0-9]*/gi, '');
        if (val=='' || val=='0') val = '1';
        obj.value = val;

        prepareSum(id);
    }
}

function prepareNumber(obj, event, id)
{
	var keyCode = event.which | event.keyCode;
/*
	if (keyCode > 36 && keyCode < 41) return;
    if (keyCode > 47 && keyCode < 59) return;
    if (keyCode > 95 && keyCode < 106) return;38 40
*/
//alert(keyCode);
    var val = obj.value;
    val = val.replace(/[^0-9]*/gi, '');
    
     if (keyCode == 38 && val < 100) {
         val++;
     }
     if (keyCode == 40 && val > 1) {
         val--;
     }

    obj.value = val;
    if (val=='' || val=='0') return;    

    prepareSum(id);
}

function bascketSelectSize(id, price)
{
   $('#bascket_card_'+id+' .price_on').val(price);
   $('#bascket_card_'+id+' .cost_on').html(price);

   prepareSum(id);
}

function prepareSum(id)
{
    var count = $('#bascket_card_'+id+' .bascket_count').val();
    var price = $('#bascket_card_'+id+' .price_on').val(price);
    var rez = count * price;
    $('#bascket_card_'+id+' .cost').html(rez);
    $('#bascket_card_'+id+' .price').val(rez);

    prepareSumAll();
}

function prepareSumAll()
{
    var counter = 0;
    var sum = 0;
    $('#cart .price').each(function(){
        sum=parseFloat(sum)+parseFloat($(this).val());
        counter++;
    });

    $('#bascket_count_all').html(counter);
    $('#bascket_price_all').html(sum);
}

function sendFormBascet()
{
    /*
    $('#cart #cart-scroll-area').html('ss');
    $('#cart .order').hide();
    */
    if ($('#bascet_name').val() == '') {
        alert('Не заполнено поле имя!');
        return;
    }
    if ($('#bascet_phone').val() == '') {
        alert('Не заполнено поле телефон!');
        return;
    }
    //$('#send_bascet').submit();

    var processResult = function(result, errors){
        if (result && result.rez) {
            $('#cart #cart-scroll-area').html(result.rez);
            $('#cart #cart-scroll-area').css('overflow', 'auto');
            $('#cart .order').hide();
            $('#cart-scroll-area').jScrollPane({scrollbarWidth:4, animateStep: 70});
            $('#basket_count').html('0');
            $('#basket_list_img').html('');
            setTimeout("$('#basket_show').hide();", result.time);
        } else {
            alert('При добавлении произошла ошибка.');
        }        
    }

    JsHttpRequest.query('/ajax/stock/sendOrder/', 
        {'form' : $('#send_bascet')[0]},
        processResult, true);
}

function preparePhone(obj)
{
    var val = obj.value;
    val = val.replace(/[^0-9-+,\s]*/gi, '');
    obj.value = val;
}

function searchLoadList(select)
{
    var processResult = function(result, errors){
        if (result && result.rez) {
            $('#form_search').html(result.rez);
        } else {
            alert('При добавлении произошла ошибка.');
        }
        $('#form_search select').attr({"disabled":""});
    }

    var form = $('#form_search').serialize();
    $('#form_search select').attr({"disabled":"disabled"});
    JsHttpRequest.query('/ajax/stock/searchloadlist/',  form+ '&search[select]='+select, processResult, true);
}