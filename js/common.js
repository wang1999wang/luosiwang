//Powered by uimix.com;
//date:2013-10-20;
//vivo website common function;
function A(url, param, success, error) {
	if (url[0] != '/') {
		url = '/' + url;
	}
	var ajax = {type: "POST", url: url, dataType: 'json'};
	if (param) ajax.data = param;
	ajax.success = function(data) {
		if (data.no == 0) {
			if (success) success(data.data);
		} else {
			if (error) error(data.no, data.msg);
		}
	};
	if (error) {
		ajax.error = function() {
			error(500, '访问网络失败，请检查您的网络连接并重试');
		}
	}
	$.ajax(ajax);
}


var L={
	success : function(){
		VIVO_UIMIX.main.head.loginSuccess();
	},
	logout : function(){
		VIVO_UIMIX.main.head.loginout();
	},
	close : function(){
		VIVO_UIMIX.main.head.loginClose();
	},
	goStep : function(index,step){
		VIVO_UIMIX.main.head.goStep(index,step);
	}
};


var Q = {
	init: function() {
		$('#vivo-head .vivo-search form input.data_q').keyup(Q.check);
	},
	last_val: false,
	wait_intval: false,
	query: function() {
		Q.wait_intval = false;
		var q = Q.last_val;
		var params = {q:q};
		A('qsearch', params, function(data) {
			if (!data || data.length == 0 || q != Q.last_val) {
				return;
			}
			var html = '';
			var info = [];
			for (var i in data) {
				var p = data[i];
				if (p.type == 'keywords') {
					html += '<li><a class="cl" href="#"><b><img src="' +p.image+ '" width="60" height="60"></b><h2></h2><p></p><span>快速查看</span></a></li>';
					info.push([p.url, p.name, p.desc]);
				} else {
					html += '<li><a class="cl" href="#"><b><img src="' +p.image+ '" width="60" height="60"></b><h2></h2><p></p><span>快速查看</span></a></li>';
					html += '<li><a class="cl" href="#"><b><img src="/images/qk-results-dlico.png" width="60" height="60"></b><h2></h2><p></p><span>快速查看</span></a></li>';
					info.push([p.url, p.name, p.desc]);
					info.push([p.download_url, p.name, '固件、Funtouch OS、视频、使用教程、等等。']);
				}
			}
			$('#vivo-head .vivo-search .qk-results ul').html(html);
			var lis = $('#vivo-head .vivo-search .qk-results ul li');
			for (var i = 0; i < info.length; ++i) {
				var j = lis.eq(i);
				j.find('a').attr('href', info[i][0]);
				j.find('h2').text(info[i][1]);
				j.find('p').text(info[i][2]);
			}
			$('#vivo-head .vivo-search .qk-results').show();
			$('#vivo-head .vivo-search .qk-results .other-results a').attr('href', '/search?'+$.param({q:q}));
		}, function() {});
	},
	check: function() {
		$('#vivo-head .vivo-search .qk-results').hide();
		var q = $.trim($('#vivo-head .vivo-search form input.data_q').val());
		if (q == Q.last_val) {
			return;
		}
		Q.last_val = q;
		if (q == '') {
			return;
		}
		if (Q.wait_intval) clearTimeout(Q.wait_intval);
		Q.wait_intval = setTimeout(Q.query, 300);
	}
};
$(document).ready(Q.init);

var VIVO_UIMIX = {
	i : 0,
	init: function(c) {
		var c = c ? c : VIVO_UIMIX;
		for (var i in c) {if (c[i] && c[i].init) {c[i].init();}}
	},
	html5 : function(){
		var thisBody = document.body || document.documentElement,
	    thisStyle = thisBody.style,
	    support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined;
		if(support!==undefined) {return true}else{return false}
	},
	scroll : function(n,speed){
		$("body,html").stop().animate({scrollTop:n},speed);
	},
    platform: function () {
        var u = navigator.userAgent,
            app = navigator.appVersion,
            e=window.navigator.userAgent;
        var ieNub=999,browserName=false;
        var thisBody = document.body || document.documentElement,
	    thisStyle = thisBody.style,
	    support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined;
        support= support!==undefined ? true : false;
        
        if(e.indexOf("MSIE") >= 0){
            if(e.indexOf("MSIE 6.0")>0) ieNub=6;
            if(e.indexOf("MSIE 7.0")>0) ieNub=7;
            if(e.indexOf("MSIE 8.0")>0) ieNub=8;
            if(e.indexOf("MSIE 9.0")>0) ieNub=9;
            if(e.indexOf("MSIE 10.0")>0) ieNub=10;
            if(e.indexOf("MSIE 11.0")>0) ieNub=11;
            if(e.indexOf("MSIE 12.0")>0) ieNub=12;
            browserName='ie';
        }else{
            if (e.indexOf("Firefox") >= 0) browserName="firefox";
            if(e.indexOf("Safari") >= 0) browserName="safari";
            if(e.indexOf("Chrome") >= 0) browserName="chrome";
            if(e.indexOf("Opera") >= 0) browserName="opera";
        }
        return {
            trident: u.indexOf('Trident') > -1,
            presto: u.indexOf('Presto') > -1,
            webKit: u.indexOf('AppleWebKit') > -1,
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/),
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
            iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1,
            iPad: u.indexOf('iPad') > -1,
            webApp: u.indexOf('Safari') == -1,
            ismobile : !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) || u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
            html5: support,
            ie: ieNub,
            browser: browserName
        };
        
    }(),
    pf : function(){
        var ra='(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-resolution: 1.5dppx)';
        return {
            retina : window.devicePixelRatio > 1 ? true : window.matchMedia && window.matchMedia(ra).matches ? true : false
        }
    }(),
    cRetina : function(){
        var a=this;
        $('img[data-x2]').each(function(){
            if(a.pf.retina){
                $(this).attr({'src':$(this).attr('data-x2')});
            }
        });
    },
	browser : function(n){
        if(n){
            return VIVO_UIMIX.platform.ie;
        }else{
            return VIVO_UIMIX.platform.browser;
        }
	},
	iepng : function(){
		
		if(VIVO_UIMIX.browser(1)==6){
			for(var j=0; j<document.images.length; j++)
			{
				var img = document.images[j];
				var imgName = img.src.toUpperCase();
				if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
				{
				 var imgID = (img.id) ? "id='" + img.id + "' " : "";
				 var imgClass = (img.className) ? "class='" + img.className + "' " : "";
				 var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
				 var imgAlt = (img.alt) ? "alt='" + img.alt + "' " : "alt='" + img.title + "' ";
				 var imgStyle = "display:inline-block;" + img.style.cssText;
				 if (img.align == "left") imgStyle = "float:left;" + imgStyle;
				 if (img.align == "right") imgStyle = "float:right;" + imgStyle;
				 if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
				 var strNewHTML = "<i " + imgID + imgClass + imgTitle +  " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'" + img.src + "\', sizingMethod='scale');\"></i>";
				 img.outerHTML = strNewHTML;
				 j = j-1;
				}
			}
		}
	},
	pageLoading : function(p){
		if(!VIVO_UIMIX.html5() || !$("body").hasClass("load")){
			if(p && p.run) p.run();
			return;
		}
		var imgAll=[],
		imgTotal=curload=retried=per=0,
		imgcomplete = function(){
			per=parseInt(curload * 100.0 / imgTotal + 0.5);
			if(curload>=imgTotal){
				$("body").addClass("loaded").removeClass("load");
				if(p && p.run) p.run();
				return;
			}

			var imgurl=new Image();
			$(imgurl).load(function(){
				curload++;
				retried=0;
				setTimeout(imgcomplete,1);
			}).error(function(){
				retried++;
				if(retried<3){
					imgcomplete();
				}else{
					curload++;
					retried=0;
					setTimeout(imgcomplete,1);
				}
			});
			imgurl.src=imgAll[curload];
		};

		var s=0
		for(var j=0; j<document.images.length; j++){
			var imgEle=document.images[j];
			if(imgEle.src){
				imgAll.push(imgEle.src);
			}
		}
		imgTotal=imgAll.length;
		imgcomplete();
	},
	fullscreen : function(obj,t){
		if(!obj){return}
		var o= null || obj,
		el = document.documentElement,cl=document,rfs =el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen,cfs =cl.cancelFullScreen || cl.webkitCancelFullScreen || cl.mozCancelFullScreen;
		if(t){o.toggle(function(){rfs.call(el);t.text("退出");return false;},function(){cfs.call(cl);t.text("全屏");return false;});}else{o.on("dblclick", function() {rfs.call(el);return false;});}
	},
	gotop : function(){
		if($("#vivo-airbox").size()<=0) $("body").append("<div id='vivo-airbox'></div>");
		if($("#vivo-airbox #gotop").size()<=0) $("#vivo-airbox").prepend("<div id='gotop' style='display:none;'><a href='#' title='返回顶部'></a></div>");
		
		var gotop=$("#gotop");
		gotop.unbind('click','mouseenter','mouseleave');

		gotop.on({
			click : function(){
				VIVO_UIMIX.scroll(0,600);
				return false;
			},
			mouseenter : function(){
				if(VIVO_UIMIX.browser(1)<9){
					$(this).css({backgroundPosition:"0 -50px"});
				}
			},
			mouseleave : function(){
				if(VIVO_UIMIX.browser(1)<9){
					$(this).css({backgroundPosition:"0 0"});
				}
			}
		},"a").appendTo();
        

		if(VIVO_UIMIX.browser()!="ie" || VIVO_UIMIX.browser(1)>9){
			gotop.find("a").css({backgroundPosition:"0 -100px"});
		}

		var rz=function(){
			var curtop=$(this).scrollTop(),
				setH=$(this).height(),
				fixH=setH-100;


			if(curtop>500){
				if(gotop.hasClass("active")) return;
				gotop.addClass("active").css({display:"block",opacity:0}).stop().animate({opacity:1,top:fixH},200);
			}else{
				gotop.removeClass("active").stop().animate({opacity:0,top:setH},300,function(){
					$(this).css({display:"none"});
				});
			}
		};

		$(window).on({
			scroll : rz,
			resize : function(){
				if(gotop.hasClass("active")) gotop.css({top: $(this).height()-100});
			}
		}).scroll().resize();
	},
	video : function(url){
		if(typeof(swfobject)=="undefined"){
			alert("swfobject未加载!");
			return false;
		}
		if(url=="" || url=="#") return false;
		
		var w=h=0,resourseURL='',urlArr=[];
		if($("#video_layer").size()<=0){
			$("#vivo-wrap").append('<div id="video_layer" style="display:none;"><div class="video-obox"><a class="close"></a><div class="videoo"><span id="video_place"></span></div></div></div>');
		}

		if(url.indexOf("#")!= -1){
			urlArr=url.split("#");
			resourseURL=urlArr[0];
			w=parseInt(urlArr[1]);
			h=parseInt(urlArr[2]);
		}else{
			resourseURL=url;
			w=680;
			h=408;
		}

		var flashvars = {
			MM_ComponentVersion : 1,
			streamName : resourseURL,
			skinName : "Clear_Skin_1",
			autoPlay :　true,
			autoRewind : false
		},
		videoBox=$("#video_layer"),
		videoShow=videoBox.find(".video-obox"),
		closeBtn=videoBox.find("a.close");

		closeBtn.click(function(){
			videoBox.stop().animate({opacity:0},300,function(){
				$(this).css({display:"none"});
			});
			return false;
		});

		videoBox.css({display:"block",opacity:0}).stop().animate({opacity:1},500);
		videoShow.stop().delay(300).animate({width:w+20,height:h+20,marginLeft:-(w+20)/2,marginTop:-(h+20)/2},200,function(){
			if(videoShow.find("span#video_place").size()<=0) videoShow.find(".videoo").html("<span id='video_place'></span>");
			swfobject.embedSWF("script/flvplayer.swf", "video_place", w, h, "9.0.0","expressInstall.swf",flashvars,{wmode:"transparent"},null);
		});

		var r=function(){
			videoBox.css({height:$(window).height()});
		};
		$(window).on("resize",r).resize();
	}
};

VIVO_UIMIX.share = {
    init : function(){
        
    },
	url: function(type, content, url, image, des) {
        
		switch(type) {
			case 'weibo':
				return VIVO_UIMIX.share.weibo_url(content, url, image, des);
			case 'douban':
				return VIVO_UIMIX.share.douban_url(content, url, image, des);
			case 'renren':
				return VIVO_UIMIX.share.renren_url(content, url, image, des);
			case 'tencentweibo':
				return VIVO_UIMIX.share.tencentweibo_url(content, url, image, des);
			case 'qzone':
				return VIVO_UIMIX.share.qzone_url(content, url, image, des);
			case 'kaixin':
				return VIVO_UIMIX.share.kaixin_url(content, url, image, des);
			case '163weibo':
				return VIVO_UIMIX.share.t163weibo(content, url, image, des);
			case 'sohu':
				return VIVO_UIMIX.share.sohu(content, url, image, des);
			case 'msn':
				return VIVO_UIMIX.share.msn(content, url, image, des);
			default:
				return false;
		}
	},

	t163weibo: function(content, url, image) {
		var param = {info: content + ' ' + url};
		if (image) {
			param['images'] = image;
			param['togImg'] = true;
		}
		return 'http://t.163.com/article/user/checkLogin.do?' + $.param(param);
	},

	weibo_url: function(content, url, image) {
		var param = {title: content + ' ' + url};
		if (image) {
			param['pic'] = encodeURI(image);
		}
		return 'http://service.weibo.com/share/share.php?' + $.param(param);
	},

	renren_url: function(content, url, image, des) {
        var rrShareParam = {
            resourceUrl : url,
            srcUrl : '',
            pic : image,
            title : content,
            description : des
        };
        return 'http://widget.renren.com/dialog/share?' + $.param(rrShareParam);
	},

	qzone_url: function(content, url, image, des) {
		var param = {title: content};
		if (url) {
			param['url'] = url;
		}
		if (image) {
			param['pics'] = image;
		}
		return 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?' + $.param(param);
	},

	douban_url: function(content, url, image) {
		var param = {title: content};
		if (url) {
			param['url'] = url;
		}
		if (image) {
			param['pic'] = image;
		}
		return 'http://www.douban.com/recommend/?' + $.param(param);
	},

	tencentweibo_url: function(content, url, image) {
		var param = {title: content};
		if (url) {
			param['url'] = url;
		}
		if (image) {
			param['pic'] = image;
		}
		return 'http://v.t.qq.com/share/share.php?' + $.param(param);
	},

	kaixin_url: function(content, url, image) {
		var param = {rtitle: content};
		if (url) {
			param['rurl'] = url;
		}
		if (image) {
			param['pic'] = image;
		}
		return 'http://www.kaixin001.com/repaste/share.php?' + $.param(param);
	},

	sohu: function(content, url, image) {
		var param = {title: content};
		if (url) {
			param['url'] = url;
		}
		if (image) {
			param['pic'] = image;
		}
		return 'http://t.sohu.com/third/post.jsp?' + $.param(param);
	},

	msn: function(content, url, image) {
		var param = {title: content};
		if (url) {
			param['url'] = url;
		}
		if (image) {
			param['screenshot '] = image;
		}
		return 'http://profile.live.com/badge?' + $.param(param);
	}
};

// PC official website

VIVO_UIMIX.main = {
	init : function(){
		VIVO_UIMIX.init(VIVO_UIMIX.main);
		// VIVO_UIMIX.main.fixcontain();
//		VIVO_UIMIX.iepng();
//		if(VIVO_UIMIX.browser(1)==6){setTimeout(function(){$("[href]").focus(function() {this.blur()})},1000)}
		jQuery.easing.def="easeOutCubic";
		$("img").mousedown(function(e){return false});
        VIVO_UIMIX.cRetina();
		if($('#gotop').size()<=0) VIVO_UIMIX.gotop();
	},
	fixcontain: function(){
		if($("#vivo-contain").size()<=0) return;
		$(window).resize(function(){
			var wh=$(this).height(),vw=$("#vivo-wrap"),ct=$("#vivo-contain"),hd=$("#vivo-head"),fd=$("#vivo-foot");
			if(wh<vw.height()) return;
			ct.css({height:wh-hd.height()-fd.height()});
		}).resize();
	}
};

VIVO_UIMIX.main.head = {
	init : function(){
		VIVO_UIMIX.main.head.loginReg();

		var headBox=$("#vivo-head"),
		navBox=headBox.find(".vivo-nav"),
		navList=navBox.find("ul"),
		quickProduct=headBox.find(".vivo-menu-series"),
		quickComm=headBox.find(".vivo-menu-community"),
		searchBox=headBox.find(".vivo-search"),
		searchInput=searchBox.find("input"),
		searchBtn=navBox.find(".search-user a.search"),
		loginBtn=navBox.find(".search-user a.user"),
		loginMenu=headBox.find(".vivo-menu-user"),
		closeSearchBtn=searchBox.find("a.close"),
		isSearchClose=true,
		isMenuEnter=isCommEnter=false;

		closeSearchBtn.css({opacity:0});
		searchBox.on({
			mouseenter : function(){
				closeSearchBtn.animate({opacity:1},300);
			},
			mouseleave : function(){
				closeSearchBtn.animate({opacity:0},300);
			}
		});

		searchBtn.on("click",function(){
			if(isSearchClose){
				searchBox.children().css({opacity:0});
				searchBox.css({display:"block",height:0}).stop().animate({height:80},300);
				searchBox.children().stop().delay(300).animate({opacity:1},500);
				searchInput.focus().val("");
				$(this).addClass("current");
				isSearchClose=false;
			}else{
				searchBox.stop().animate({height:0},300,function(){
					$(this).css({display:"none"});
					isSearchClose=true;
				});
				$(this).removeClass("current");
			}
			return false;
		});
		closeSearchBtn.on("click",function(){
			searchBtn.click();
			return false;
		});

		var isuserMenu=false;
		loginBtn.on({
			click :function(){
				if($(this).attr("href")!="#") return;
				if($(this).hasClass("logined") || $("#loginreg_layer").size()<=0) return false;
				if(searchBox.is(":visible")) searchBtn.click(); //close search
				if($("#video_layer") && $("#video_layer").is(":visible")) $("#video_layer").find("a.close").click(); //close video
				
				$("#loginreg_layer").css({display:"block",marginTop:-$(window).height()}).stop().animate({marginTop:0},500,function(){
					$("#vivo-wrap").css({display:"none"});
					$("#loginreg_layer").find(".lr-title .btn-box a").first().click();
				});
				return false;
			},
			mouseenter : function(){
				if(!$(this).hasClass("logined")) return false;
				loginMenu.css({display:"block",opacity:0,marginTop:-20}).stop().animate({marginTop:0,opacity:1},300);
			},
			mouseleave : function(){
				if(!$(this).hasClass("logined")) return false;
				var t=setTimeout(function(){
					if(isuserMenu) return false;
					loginMenu.stop().animate({opacity:0},300,function(){
						$(this).css({display:"none"});
					});
				},300);
			}
		});
		loginMenu.on({
			mouseenter : function(){
				isuserMenu=true;
			},
			mouseleave : function(){
				isuserMenu=false;
				loginMenu.stop().animate({opacity:0},300,function(){
					$(this).css({display:"none"});
				});
			}
		}).on({
			click : function(){
				loginMenu.mouseleave();
			}
		},"dl dd a");

		// 社区导航快捷菜单
		// navList.on({
		// 	mouseenter : function(){
		// 		var space= isSearchClose ? 0 : 80;
		// 		quickComm.css({display:"block",opacity:0,top:(60+space-20),zIndex:99}).stop().animate({opacity:1,top:(60+space)},300);
		// 		$(this).addClass("active");
		// 	},
		// 	mouseleave : function(){
		// 		var ths=$(this);
		// 		var f=setTimeout(function(){
		// 			if(!isCommEnter){
		// 				ths.removeClass("active");
		// 				quickComm.stop().animate({opacity:0},500,function(){
		// 					$(this).css({display:"none"});
		// 					isCommEnter=false;
		// 				});
		// 			}
		// 		},200);
		// 	}
		// },"li.community");
		// quickComm.on({		
		// 	mouseenter : function(){
		// 		isCommEnter=true;
		// 	},
		// 	mouseleave : function(){
		// 		navList.parent().find("li.community").removeClass("active");
		// 		$(this).stop().animate({opacity:0},500,function(){
		// 			$(this).css({display:"none"});
		// 			isCommEnter=false;
		// 		});
		// 	}
		// });

		if($("body").hasClass("products")) return;
		navList.on({
			mouseenter : function(){
				var space= isSearchClose ? 0 : 80;
				quickProduct.css({display:"block",opacity:0,top:(60+space-20),zIndex:99}).stop().animate({opacity:1,top:(60+space)},300);
				$(this).addClass("active");
			},
			mouseleave : function(){
				var ths=$(this);
				var f=setTimeout(function(){
					if(!isMenuEnter){
						ths.removeClass("active");
						quickProduct.stop().animate({opacity:0},500,function(){
							$(this).css({display:"none"});
							isMenuEnter=false;
						});
					}
				},200);
			}
		},"li.product");
		quickProduct.on({		
			mouseenter : function(){
				isMenuEnter=true;
			},
			mouseleave : function(){
				navList.parent().find("li.product").removeClass("active");
				$(this).stop().animate({opacity:0},500,function(){
					$(this).css({display:"none"});
					isMenuEnter=false;
				});
			}
		});
	},
	loginReg : function(){
		var loginReg=$("#loginreg_layer"),
		lrTitle=loginReg.find(".lr-title"),
		closeBtn=lrTitle.find("a.close"),
		lrBox=loginReg.find(".lr-box"),
		loginSwitchBtn=lrTitle.find(".btn-box"),
		loginBox=lrBox.find(".fieldset"),
		loginMethodBox=loginBox.find(".fieldset-fill .fieldset-section"),
		loginCornerIco=lrTitle.find("em"),
		lrOtherMethod=loginBox.find(".other-method"),
		winH=0;


		loginSwitchBtn.find("a").on({
			mouseenter : function(){
				var th=$(this);
				loginCornerIco.stop().animate({left:th.offset().left+(th.width()/2)-19},500);
			},
			mouseleave : function(){
				loginCornerIco.stop().animate({left:loginSwitchBtn.find("a.current").offset().left+(loginSwitchBtn.find("a.current").width()/2)-19},500);
			},
			click : function(){
				var th=$(this);
				if(th.hasClass("current")) return false;
				th.addClass("current").siblings().removeClass("current");
				loginCornerIco.stop().animate({left:loginSwitchBtn.find("a.current").offset().left+(loginSwitchBtn.find("a.current").width()/2)-19},500);

				if(!lrOtherMethod.is(":visible")) lrOtherMethod.css({display:"block",opacity:0}).stop().delay(300).animate({opacity:1},500);
				if(!loginBox.is(":visible")){
					loginBox.siblings().stop().animate({opacity:0},300,function(){
						$(this).css({display:"none"});
						loginBox.stop().css({display:"block",opacity:0}).animate({opacity:1},500);
					});
				}

				loginMethodBox.eq(th.index()).css({display:"block",zIndex:10,opacity:0}).stop().delay(300).animate({opacity:1},500)
				.siblings().css({zIndex:1}).stop().delay(0).animate({opacity:0},500,function(){
					$(this).css({display:"none"});
				});

				return false;
			}
		});

		if($("body").hasClass("loginreg")){
			loginSwitchBtn.find("a").first().click();
		}
		if($("body").hasClass("emailsuccess")){
			VIVO_UIMIX.main.head.goStep(2,".emailver-tips");
		}



		closeBtn.click(function(){
			if($("body").hasClass("loginreg")) return;
			loginReg.stop().animate({marginTop:-winH},500,function(){
				lrBox.children("div").first().css({opacity:1,display:"block",zIndex:10}).siblings().css({opacity:0,display:"none",zIndex:1});
				lrBox.children("div").find("input").val("");
				$(this).css({display:"none"});
			});
			$("#vivo-wrap").css({display:"block"});
			return false;
		});

		var r=function(){
			winH=$(window).height();
			lrTitle.css({height:winH/2 - 60});
			lrBox.css({height:winH/2 + 60});

			if($("body").hasClass("loginreg")) return;
			loginReg.css({height:winH-1});
		};
		$(window).resize("resize",r).resize();

	},
	loginSuccess : function(){
		var loginReg=$("#loginreg_layer"),
		lrTitle=loginReg.find(".lr-title"),
		closeBtn=lrTitle.find("a.close"),
		loginBtn=$(".vivo-nav .search-user a.user");

		loginBtn.addClass("logined");
		closeBtn.click();
		return false;
	},
	loginout : function(){
		var loginBtn=$(".vivo-nav .search-user a.user");
		loginBtn.find("b img").remove();
		loginBtn.removeClass("logined");
		return false;
	},
	loginClose : function(){
		$("#loginreg_layer .lr-title a.close").click();
		return false;
	},
	goStep : function(index,step){
		var loginReg=$("#loginreg_layer"),
		lrTitle=loginReg.find(".lr-title"),
		lrBox=loginReg.find(".lr-box"),
		loginSwitchBtn=lrTitle.find(".btn-box a");
		loginSwitchBtn.eq(index).click();

		if(!step) return false;
		var o=lrBox.find(step);
		o.siblings().stop().animate({opacity:0},300,function(){
			$(this).css({display:"none"});
			o.css({display:"block",opacity:0}).stop().animate({opacity:1},500);
		});
	}
};

VIVO_UIMIX.main.foot = {
	init : function(){
		var footBox=$("#vivo-foot .vivo-footer"),
		snsBox=footBox.find(".vivo-sns-list"),
		weixin=snsBox.find("a.weixin"),
		weixinoverbox=snsBox.find(".vivo-weixin-overbox");

		weixin.on({
			mouseenter : function(){
				weixinoverbox.css({display:"block",opacity:0}).stop().animate({opacity:1},300);
			},
			mouseleave : function(){
				weixinoverbox.stop().animate({opacity:0},300,function(){
					$(this).css({display:"none",opacity:0});
				});
			},
			click : function(){
				return false;
			}
		});
	}
};

// Mobile version
VIVO_UIMIX.mobile = {
	init : function(){
		VIVO_UIMIX.init(VIVO_UIMIX.mobile);
	}
};

// PC mall
VIVO_UIMIX.mall = {
	init : function(){
		VIVO_UIMIX.init(VIVO_UIMIX.mall);
	}
};

// PC forum
VIVO_UIMIX.forum = {
	init : function(){
		VIVO_UIMIX.init(VIVO_UIMIX.forum);
	}
};

// PC mobilephone's products
VIVO_UIMIX.products = {
	init : function(){
		VIVO_UIMIX.init(VIVO_UIMIX.products);
	}
};



$(document).ready(function() {VIVO_UIMIX.init()});
