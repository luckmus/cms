var litemLen = 0;
var rowMax = 0;
var colMax = 0;
var scrollH = 16;
var rowH = 0;

var img = new Array();
var pos = new Array();
	
$(document).ready(function(){
	lcontentheight();

	$(".limg").click(function(){
		var $litem = $(this).parent().parent();
		if(openedID == $(this).parent().parent().attr("id")) {
			lactiveCloseOnly(true);
		} else if(!$lopened) {
			$("#info").html(0);
			lopen($(this).parent().parent());
		} else if($lopened) {
			$("#info").html(1);
			lactiveCloseAndOpen(this);
		}
	});

	$(".litem")
		.mouseenter(function(){
			$(".netshad",this).animate({marginTop:-8},100);
		})
		.mouseleave(function(){
			$(".netshad",this).animate({marginTop:0},100);
		});

	$(".mclose").click(function(){
		lactiveCloseOnly(true);
	});
});

$(window).resize(function() {
	lcontentheight();
});

function lopen(litem) {
	var id = $(litem).attr("id");

	openedID = id;
	$lopened = $(litem);
	if(img[id]["row"] == rowMax-1) {
		if(rowMax==1){
			moveOthers(id,"fw");
		} else {
			$(litem).css("z-index","1000").animate({height:rowH*2,marginTop:-rowH},300,function(){moveOthers(id,"fw")});
		}
	} else {
		$(litem).css("z-index","1000").animate({height:rowH*2},300,function(){moveOthers(id,"fw")});
	}
	var $netshad = $(".netshad",$(litem));
	$netshad.animate({top:rowH*2-40},300).fadeOut(300);
	$(litem).animate({width:650},300);
	$("#sc").animate({scrollLeft:400*img[id]["col"]-sw/2+650/2},1000);
}

function moveOthers(id,direction) {
	var newMargin = direction=="fw" ? 250 : 0;
	if(img[id]["row"] == rowMax-1) {
		for(var k=img[id]["col"]+1; k<colMax; k++) {
			if(pos[rowMax-1][k])
				$("#"+pos[rowMax-1][k]["id"]).animate({marginLeft:newMargin},300);
		}
		if(rowMax!=1){
			for(var m=img[id]["col"]+1; m<colMax; m++) {
				if(pos[rowMax-2][m])
					$("#"+pos[rowMax-2][m]["id"]).animate({marginLeft:newMargin},300);
			}
		}
	} else {
		var rowNum = img[id]["row"];
		for(var k=img[id]["col"]+1; k<colMax; k++) {
			if(pos[rowNum][k])
				$("#"+pos[rowNum][k]["id"]).animate({marginLeft:newMargin},300);
		}
		for(var m=img[id]["col"]+1; m<colMax; m++) {
			if(pos[rowNum+1][m])
				$("#"+pos[rowNum+1][m]["id"]).animate({marginLeft:newMargin},300);
		}
	}
}

function lactiveCloseOnly(trg) {
	$lopened
		.animate({height:rowH,width:400,marginTop:0},300,function(){
			$(this).css("z-index","1");
			$(".netshad",this).css("top",rowH-40).show();
			if(trg) {
				$lopened = undefined;
				openedID = undefined;
			}
		});
	moveOthers($lopened.attr("id"),"bw")
}

function lactiveCloseAndOpen(objNext) {
	lactiveCloseOnly(false);
	lopen($(objNext).parent().parent());
	//$lopened = undefined;
}

function lcontentheight(){
	img = new Array();
	pos = new Array();
	rowMax = 0;
	colMax = 0;
	$lopened = false;
	bodyH = $("body").height()-180;
	$("#mcont").height(bodyH-scrollH);

	var colCount = Math.floor(sw/400);
	var rowCount = Math.floor((bodyH-scrollH)/200);

	rowH = Math.floor((bodyH - scrollH) / rowCount);
	var avaliableCount = colCount * rowCount;

	litemLen = $(".litem").length;

	var rowCurr = 0;
	var colCurr = 0;
	var colFull = 1;
	var itemCurr = 0;
	rowMax = rowCount;
	for(var k=0; k<litemLen; k++){
		if(!pos[rowCurr]) pos[rowCurr] = new Array();
		if(!pos[rowCurr][colCurr]) pos[rowCurr][colCurr] = new Array();
		pos[rowCurr][colCurr]["id"] = "litem_" + k;
		//pos[rowCurr][colCurr]["y"] = rowCurr*200;
		pos[rowCurr][colCurr]["y"] = rowCurr*rowH;
		pos[rowCurr][colCurr]["x"] = colCurr*400;
		if(!img["litem_"+k]) img["litem_"+k] = new Array();
		img["litem_"+k]["row"] = rowCurr;
		img["litem_"+k]["col"] = colCurr;
		$("#litem_"+k).css("top",rowCurr*rowH).css("left",colCurr*400).css("margin-left",0).css("width",400).css("height",rowH);
		$(".netshad",$("#litem_"+k)).css("top",rowH-40).show();
		if(k < litemLen-1) {
			if(rowCurr == rowMax-1) {
				rowCurr = 0;
				colCurr++;
				colFull++;
			} else {
				rowCurr++;
			}
		}
		colMax = colCurr>colMax ? colCurr : colMax;
		colMax += 1;
		$("#litem_"+k).height(rowH);
	}
	$("#lcont").width(colFull*400).height(bodyH-scrollH);
}

function previewApply(id, img) {
    $("#limg"+id).attr("src", img);
}