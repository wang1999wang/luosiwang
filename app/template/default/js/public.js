$(function() {
	showSuccMsg();
	$(".close").click(function() {
		$(".alert,.oper-info").slideUp();
		setTimeout("$('.alert,.oper-info').remove()",2000);
	});
	if ($(".action-error").text().length<=1){
		$(".action-error").hide();
	}
	var cw = document.documentElement.clientWidth;
	var ch = document.documentElement.clientHeight;
	$(".textareahtml").each(function(){$(this).html($(this).html().replace(/\n/g,"<br/>"));});
//	$(".header").css({'padding-left': (cw-1080)/2});
//	$(".footer > .lm-footer").css({'padding-left': (cw-1080)/2});
	$("#menu > ul > li").hover(
		function() {$(this).find('ul').stop(true, true).fadeIn();$(this).addClass('currt')} ,
		function() {$(this).find("ul").stop(true, true).fadeOut();$(this).removeClass('currt')}
	);
	$(".weixin b").hover(
		function(){$(".weixin-overbox").fadeIn();},
		function(){$(".weixin-overbox").fadeOut();}
	);
	
	$(".img_map area").each(function(){
		var posi = $(this).attr('coords');
		var array = posi.split(",");
		var rsl = "";
		var width = 1920;
		var height = 709;
		var cw = document.documentElement.clientWidth;
		var ch = document.documentElement.clientHeight;
		if ('y'==$(this).parent().parent().find('img').attr('data-full')) {
			ch+=17;
		}
		for(var i=0;i<array.length;i++){
			if ('y'==$(this).parent().parent().find('img').attr('data-full')){
				rsl+=','+ parseInt(parseInt(array[i])*(ch-80)/height);
			} else {
				rsl+=','+ parseInt(parseInt(array[i])*cw/width);
			}
		}
		$(this).attr('coords', rsl.substring(1));
	});
});
function goAction(url){
	window.location.href = url;
}

function getUrlParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
	var r = window.location.search.substr(1).match(reg);
	if (r != null)
		return unescape(r[2]);
	return null;
}

function showSuccMsg() {
	var operTag = getUrlParam("operTag")
	if (operTag != null) {
		createAlert(operTag);
		$(".alert").slideDown();
		if (operTag == 'succ'){
			setTimeout("$('.oper-info').slideUp();",2000);
			setTimeout("$('.oper-info').remove()",2500);
		}
	}
}

function createAlert(tag){
	var alertHtml = null;
	if (tag == "succ") {
		alertHtml = '<div class="oper-info alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>操作成功</div>';
	} else {
		var msg = null;
			msg = '操作失败';
		alertHtml = '<div class="oper-info alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>';
	}
	$(".breadcrumb").append(alertHtml);
}