
function goToUrl(url)
{
    location.href = url;
}

$(function()
{


    /**
     * Обработчик событий. Выпадающий список категорий в блогах.
     */
    $(".select_169").change(function(){

        location.href = $(this).val();

    });


    /**
     * Обработчик кнопки в избранное (блоги и луки)
     */

    $(".to-favorite").live('click',function(e){

        e.preventDefault();
        var $this = $(this);
        var params = $this.attr('id').split("_");

        $.post("/community/add_favorite", {module_name:params[1], subject_id:params[2],csrf_test_name:$.cookie('csrf_test_name')}, function(data){
                if(data.result){
                    var result_layer = $this.find('em');

                    if(data.action == 'unfav')
                    {
                        result_layer.html('В избранное');


                        $this.addClass('disable');
                    }
                    else
                    {
                        result_layer.html('В избранном');
                        $this.removeClass('disable');

                    }

                }
                else{

                    console.log('Невозможно добавить в избранное');
                }
            },
            'json');



    });

    $(".like-it").live('click',function(e){

        e.preventDefault();
        var $this = $(this);
        var params = $this.attr('id').split("_");

        $.post("/community/add_like", {module_name:params[1], subject_id:params[2],csrf_test_name:$.cookie('csrf_test_name')}, function(data){
                if(data.result){
                    var result_layer = $this.find('em');

                    //console.log(result_layer);
                    if(data.action == 'unlike')
                    {
                        result_layer.html(data.total);
                        $this.addClass('disable');
                        if(params[1]=='comments')
                        {
                            $this.find('span').removeClass('c-heart-icon');
                            $this.find('span').addClass('heart-icon');
                            $("#amount_likes_"+params[2]).html(data.total);
                        }


                    }
                    else
                    {
                        result_layer.html(data.total);
                        $this.removeClass('disable');

                        if(params[1]=='comments')
                        {
                            $this.find('span').removeClass('heart-icon');
                            $this.find('span').addClass('c-heart-icon');
                            $("#amount_likes_"+params[2]).html(data.total);
                        }


                    }

                }
                else{

                    console.log('Невозможно лайкнуть');
                }
            },
            'json');

    });


    /*--- Community ---*/
    $('.select_169').selectmenu({
        style:'dropdown',
        width: 169,
        menuWidth: 187
    });

    $('.addtags').selectmenu({
        style:'dropdown',
        width: 100,
        menuWidth: 100
    });


    /* Ordered list */
    $('.c-profile ol li').each(
        function(i) {
            $(this).prepend('<span class="list-num"></span>');
            $(this).find('.list-num').text(i + 1);
        }
    );


	/* jQuery UI Button */
	$(function() {
		$('.button').button();
	});
	$(function() {
		$('#payment-method').buttonset();
	});
    $(function() {
		$('#lightbox-payment-method').buttonset();
	});
	/* jQuery UI Tabs */
	$(function() {
		$( "#tabs" ).tabs({ selected: 2 });
	});
	/* jQuery UI Selectmenu */
	$('.select_158').selectmenu({
		style:'dropdown',
		width: 140,
		menuWidth: 158
	});
	$('.select_138').selectmenu({
		style:'dropdown',
		width: 118,
		menuWidth: 138
	});
	$('.select_148').selectmenu({
		style:'dropdown',
		width: 128,
		menuWidth: 148
	});
	$('.select_173').selectmenu({
		style:'dropdown',
		width: 155,
		menuWidth: 173
	});
	$('.select_98').selectmenu({
		style:'dropdown',
		width: 78,
		menuWidth: 98
	});
	$('.select_114').selectmenu({
		style:'dropdown',
		width: 94,
		menuWidth: 114
	});
	/* jQuery UI Accordion */
	$(".accordion").accordion({
		collapsible: true,
		autoHeight: false,
		navigation: true,
		icons: false,
		header: "> li > h4"
	});
	
		
	/* jQzoom */
	$('.jqzoom_lightbox').jqzoom({
    	zoomType: 'standard',
		zoomWidth: 357,
		zoomHeight: 357,
		xOffset: 0,
		title: false,
    	lens:false,
		position: "right",
    	preloadImages: false,
    	alwaysOn:false
    });
	$('.jqzoom').jqzoom({
    	zoomType: 'standard',
		zoomWidth: 357,
		zoomHeight: 357,
		xOffset: 0,
		title: false,
    	lens:true,
		position: "right",
    	preloadImages: false,
    	alwaysOn:false
    });

    $('.jqzoom-tall').jqzoom({
    	zoomType: 'standard',
		zoomWidth: 320,
		zoomHeight: 462,
		xOffset: 86,
		title: false,
    	lens:true,
		position: "right",
    	preloadImages: false,
    	alwaysOn:false
    });    
	
	$('#related').jcarousel({
		scroll: 1
	});
        $('#related-2').jcarousel({
		scroll: 1
	});
	
	/* Main page slider */
	$("#mp-slider").cycle({
		fx: 'fade',
		speed: 400,
		timeout: 10000,
		prev: '#slide-prev',
		next: '#slide-next',
		pager: '#slider-nav'
	});
	
	/* Order history */
	$('.order-info').hide();
	$('.expand').toggle(
		function() {
			$(this).parent('.tr').next('.order-info').stop(true, true).animate({height: 'show'}, 150);
			$(this).addClass('expandet');
		},
		function() {
			$(this).parent('.tr').next('.order-info').stop(true, true).animate({height: 'hide'}, 150);
			$(this).removeClass('expandet');
		}
	);

    /* Sub menu */
	$('#ru_nav > ul > li').hover(
		function() {
			if ($(this).children('.sub-menu').is(":animated")) {
				$(this).children('.sub-menu').css({"z-index" : "16000"}).stop(true,true).css({display : "block", height : "auto"});
				$(this).children('a').addClass("hover");
			}
			else {
				$(this).children('.sub-menu').css({"z-index" : "16000"}).stop(true,true).animate({height : "show", opacity : "show"});
				$(this).children('a').addClass("hover");
			}
		},
		function() {
			$(this).children('.sub-menu').css({"z-index" : "10000"}).stop(true,true).animate({height : "hide", opacity : "hide"}, 300);
			$(this).children('a').removeClass("hover");
		}
	);

        $('#en_nav > ul > li').hover(
		function() {
			if ($(this).children('.sub-menu').is(":animated")) {
				$(this).children('.sub-menu').css({"z-index" : "16000"}).stop(true,true).css({display : "block", height : "auto"});
				$(this).children('a').addClass("hover");
			}
			else {
				$(this).children('.sub-menu').css({"z-index" : "16000"}).stop(true,true).animate({height : "show", opacity : "show"});
				$(this).children('a').addClass("hover");
			}
		},
		function() {
			$(this).children('.sub-menu').css({"z-index" : "10000"}).stop(true,true).animate({height : "hide", opacity : "hide"}, 300);
			$(this).children('a').removeClass("hover");
		}
	);
	
	/* Lightbox */
	var $fadespeed = 200
	$('.log-link-class').click(function(e) {
            e.preventDefault()
            $('.form-lightbox-wrap').fadeOut($fadespeed);
            $('.log-lightbox').fadeIn($fadespeed);
            $('body').css({"overflow" : "hidden", "position" : "relative"});
            $('.overlay').fadeTo($fadespeed, 0.6);
        });
	$('.add-address').click(function(e) {
		e.preventDefault()
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$('.address-lightbox').fadeIn($fadespeed);
		$('body').css({"overflow" : "hidden", "position" : "relative"});
		$('.overlay').fadeTo($fadespeed, 0.6);
	});
    $('.address').click(function(e) {
		e.preventDefault()
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$('.address-lightbox').fadeIn($fadespeed);
		$('body').css({"overflow" : "hidden", "position" : "relative"});
		$('.overlay').fadeTo($fadespeed, 0.6);
	});
    $('#profile-edit').click(function(e) {
		e.preventDefault()
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$('.profile-lightbox').fadeIn($fadespeed);
		$('body').css({"overflow" : "hidden", "position" : "relative"});
		$('.overlay').fadeTo($fadespeed, 0.6);
	});
    $('#avatar').click(function(e) {
		e.preventDefault()
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$('.avatar-lightbox').fadeIn($fadespeed);
		$('body').css({"overflow" : "hidden", "position" : "relative"});
		$('.overlay').fadeTo($fadespeed, 0.6);
	});
	$('.add-to-cart input').click(function(e) {
		e.preventDefault()
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$('.lightbox_wrap').fadeOut($fadespeed);
		$('.add-to-cart-lightbox').fadeIn($fadespeed);
		$('body').css({"overflow" : "hidden", "position" : "relative"});
		$('.overlay').fadeTo($fadespeed, 0.6);
	});	
        
	$('.lightbox-close').click(function(e) {
		e.preventDefault()
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$('.overlay').fadeOut($fadespeed);
		$('body').css({"overflow" : "visible", "position" : "static"});
	});
	$('.close').click(function(e) {
		e.preventDefault()
		$('.lightbox_wrap').fadeOut($fadespeed);
		$('.overlay').fadeOut($fadespeed);
		$('body').css({"overflow" : "visible", "position" : "static"});
	});
	$('.overlay').click(function() {
		$('.lightbox_wrap').fadeOut($fadespeed);
		$('.form-lightbox-wrap').fadeOut($fadespeed);
		$(this).fadeOut($fadespeed);
		$('body').css({"overflow" : "visible", "position" : "static"});
	});
        
	$('.lightbox_wrap').click(function() {
		$('.overlay').fadeOut($fadespeed);
		$('.lightbox_wrap').fadeOut($fadespeed);
		$('body').css({"overflow" : "visible", "position" : "static"});
	});
	$('.form-lightbox-wrap').click(function() {
		$('.overlay').fadeOut($fadespeed);
		$(this).fadeOut($fadespeed);
		$('body').css({"overflow" : "visible", "position" : "static"});
	});
	$('.lightbox').click(function(e){
		e.stopPropagation();
	});
	$('.form-lightbox').click(function(e){
		e.stopPropagation();
	});
	
	
	$('.guest_book_form').hide();
	$('#guest_book_form_trigger').click(function(e){
		e.preventDefault()
		$('.guest_book_form').toggle('fast');
	});
	
	
	$('.table_sizes_box').hide();
	$('.table_sizes > a').hover(
		function() {
			$(this).next('.table_sizes_box').stop(true,true).animate({width: 'toggle', opacity: 'toggle'}, 250);
	});

        $("#login").click(function(){
            var em   = $("#log-email").val();
            var pass   = $("#log-pass").val();
            var url   = $("#log-url").val();
            var rem = "nain";
            if(document.getElementById("rememberme").checked){
                rem = "da";
            }

            $.post("/users/login", {email:em, password:pass, url:url, rememberme:rem}, function(data){
                if(data == "false"){
                  $("#log-mess").html("<br/>Вы ввели не верные данные");
                  $("#log-pass").val("");
                }
                else{
                    document.location.href = data;
                    $("#hemail").val(em);
                    $("#hpassword").val(pass);
                    $("#hremember").val(rem);
                    $("#hredirect").val(data);
                    $("#ac-form").submit();

                }
            });
            return false;
        });
	
	
	/* HTML 5 placeholder for IE */
	if ( $.browser.msie ) {
		function placeholder(){
			$("input[type=text]").each(function(){
				var phvalue = $(this).attr("placeholder");
				$(this).val(phvalue);
			});
		}
		placeholder();
		$("input[type=text]").focusin(function(){
			var phvalue = $(this).attr("placeholder");
			if (phvalue == $(this).val()) {
			$(this).val("");
			}
		});
		$("input[type=text]").focusout(function(){
			var phvalue = $(this).attr("placeholder");
			if ($(this).val() == "") {
				$(this).val(phvalue);
			}
		});
	}

    // custom
    $("#regemail").focusout(function(){
            var em   = $(this).val();
            $.post("/users/checkemail", {email:em}, function(data){
                $("#reg-email-label").html(data);
            });
            return false;
    });
    

    $("#news_select").change(function(){
        var url = $('#news_select option:selected').val();
        document.location.href = url;
    });

    $("#country_select").change(function(){
        var url = $('#country_select option:selected').val();
        document.location.href = url;
    });

    $("#city_select").change(function(){
        var url = $('#city_select option:selected').val();
        document.location.href = url;
    });
    $(".reply_mess").click(function(){
        $(this).next().slideDown();
        return false;
    });
    $(".reply_but").click(function(){
        var mes_id   = $(this).attr("rel");
        var mes_text = $(this).prev().val();
        var find = "#reply_"+mes_id;
        $(find).html('<div class="guest_book_reply"><span>Ответ</span><p>'+mes_text+'</p></div>');
        $.post("/guestbook/reply/"+mes_id+"", {message:mes_text}, function(){

        });
        return false;
    });

    DD_belatedPNG.fix('.#nav ul li a, .sub-menu');

});