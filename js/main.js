//Powered by uimix.com;
//date:2013-10-20;
//vivo website function;

VIVO_UIMIX.main.keyEvent = {
	init : function(){
		var keyBox=$("#vivo-contain .focus-event .key-event");

		keyBox.find("ul").on({
			mouseenter : function(){
				$(this).find("i").css({display:"block",opacity:0}).stop().animate({opacity:1},300);
			},
			mouseleave : function(){
				$(this).find("i").stop().animate({opacity:0},300,function(){
					$(this).css({display:"none"});
				});
			},
			click : function(){
				var href=$(this).find("a").attr("href"),
				w=parseInt($(this).find("a").attr("data-width")) ? parseInt($(this).find("a").attr("data-width")) : 550,
				h=parseInt($(this).find("a").attr("data-height")) ? parseInt($(this).find("a").attr("data-height")) : 300;

				if(href=="" || href=="#") return false;
				VIVO_UIMIX.video(href,w,h);
				return false;
			}
		},"li.video")
		.on({
			mouseenter : function(){
				$(this).find("i").css({opacity:0,display:"block"});
				$(this).find("i").stop().animate({height:80,opacity:1},400);
			},
			mouseleave : function(){
				$(this).find("i").stop().animate({height:0,opacity:0},300,function(){
					$(this).css({display:"none"});
				});
			}
		},"li.pictext");
	}
};

VIVO_UIMIX.main.news = {
	init : function(){
		VIVO_UIMIX.main.news.high();
		VIVO_UIMIX.main.news.newsShare();
	},
	high : function(){
		var newsHigh=$(".news-box .news-high"),
		slideItem=newsHigh.find("ul li"),
		newsTotal=slideItem.size(),
		swBth=newsHigh.find(".slide-switch"),
		sCode="",speed=5000,curItem=0,t=null;

		for(var i=0; i<newsTotal; ++i){
			sCode+="<a></a>";
		}
		swBth.append(sCode);

		slideItem.css({opacity:0,zIndex:1,display:"none"});
		swBth.children("a").mouseenter(function(){
			
			if($(this).hasClass("current")) return;
			$(this).addClass("current").siblings().removeClass();

			slideItem.eq($(this).index()).stop().delay(300).css({display:"block",opacity:0,zIndex:10}).animate({opacity:1},800)
			.siblings().css({zIndex:1}).animate({opacity:0},300,function(){
				$(this).css({display:"none"});
			});
			curItem=$(this).index();
		}).click(function(){
			return false;
		}).first().mouseenter();

		t=setInterval(function(){
			curItem= curItem<newsTotal-1 ? ++curItem : 0;
			swBth.children("a").eq(curItem).mouseenter();
		},speed);
	},
	newsShare : function(){
		var shareBox=$(".news-box .share-bar"),
		shareList=shareBox.find(" .share-list"),
		shareTotal=shareList.find("ul li").size(),
		shareBtn=shareBox.find(".share-btn"),
		isopen=false;

		shareList.find("ul").css({width: 120 * shareTotal})
		.find("li a").click(function(){
			var type=$(this).attr('type'),
			s= type=="tencentweibo" ? "@vivomobile" : "@vivo智能手机",
			topic="#vivo"+$(".news-box h1.title").text()+"#",
			des=$(".news-content .news-title h2").text(),
			content = topic+" "+des+" (分享自 "+s+")",
			url = location.href,
			image=false,
			imgURL="";

			if($(".news-content .news-views img").size()>0){
				image=$(".news-content .news-views img").first().attr("src");
				image= image.indexOf("vivo.com.cn")==-1 ?  "http://www.vivo.com.cn"+image : image;
			}else{
                image="http://www.vivo.com.cn/images/vivo-logo-x2.png";
            }

			window.open(VIVO_UIMIX.share.url(type, content, url, image));
			return false;
		});

		shareBtn.find("a").click(function(){
            if($(this).hasClass("current")){
                var th=$(this);
                shareList.stop().animate({height:1},300,function(){
                    $(this).css({display:"none"});
                    th.removeClass("current");
                });
            }else{
                var th=$(this);
                th.addClass("current");
                shareList.stop().css({display:"block",height:0}).animate({height:110},500);
            }
			return false;
		});
	}
};

VIVO_UIMIX.main.eventbox = {
	init : function(){
		var eventBox=$("#vivo-contain .focus-event .social-section .event-box"),
		eventList=eventBox.find("ul li"),
		totalLi=eventList.size(),
		curLi=oldLi=0;

		eventList.each(function(i,j){
			var j=$(j);
			j.css({opacity:0,display:"none",zIndex:1});
			j.find("h2").children().css({opacity:0});
			j.find(".event-content").children().css({opacity:0});
			if(i==0){
				j.css({opacity:1,display:"block"});
				j.find("h2").children().css({opacity:1});
				j.find(".event-content").children().css({opacity:1});
			}

			eventBox.find(".event-switch strong").append("<b></b>");
		});
		eventBox.find(".event-switch strong b").first().addClass("current");
		var isgo=true,
		t=null,
		delay=5000,
		switchLi=function(n){
			eventList.eq(n).siblings().css({zIndex:1});
			eventList.eq(n).css({opacity:0,display:"block",zIndex:100}).stop().animate({opacity:1},300,function(){
				$(this).find("h2").children().stop().animate({opacity:1},50);
				$(this).find(".event-content").children().stop().delay(100).animate({opacity:1},300);
				eventList.eq(n).siblings().css({opacity:0,display:"none",zIndex:1});
				eventList.eq(n).siblings().find("h2").children().css({opacity:0});
				eventList.eq(n).siblings().find(".event-content").children().css({opacity:0});
				eventBox.find(".event-switch strong b").eq(n).addClass("current").siblings().removeClass("current");
				isgo=true;
			});
		}
		eventBox.on({
			click : function(){
				// if(!isgo) return false;
				isgo=false;
				curLi= curLi > 0 ? --curLi : totalLi-1;
				switchLi(curLi);
				return false;
			}
		},"a.prev")
		.on({
			click : function(){
				if(!isgo) return false;
				isgo=false;
				curLi= curLi < totalLi-1 ? ++curLi : 0;
				switchLi(curLi);
				return false;
			}
		},"a.next");

		eventList.on({
			mouseenter : function(){
				clearInterval(t);
			},
			mouseleave : function(){
				t=setInterval(function(){
					eventBox.find("a.next").click();
				},delay);
			}
		});

		t=setInterval(function(){
			eventBox.find("a.next").click();
		},delay);

	}
};

VIVO_UIMIX.main.products = {
	init : function(){
		
	}
};

VIVO_UIMIX.main.service = {
	init : function(){
		VIVO_UIMIX.main.service.slideNav();
		VIVO_UIMIX.main.service.playVideo();
	},

	slideNav : function(){
		var slideMain=$(".download-box .dl-findmobile .dl-mobile-slide"),
		slideBox=slideMain.find(".choose-mobile"),
		prevBtn=slideMain.find("a.prev"),
		nextBtn=slideMain.find("a.next"),
		slideTab=slideMain.find(".tab-mobile"),
		tabLine=slideTab.find("i"),
		sprev=snext=true;

		slideBox.children("div").each(function(i,j){
			var j=$(j),
			total=j.find("ul li").size(),
			w=j.find("ul li").width();

			j.attr({"num":total}).find("ul").css({width: w * total});
		}).css({display:"none"});

		var checkPN=function(){
			sprev ? prevBtn.addClass("start") : prevBtn.removeClass("start");
			snext ? nextBtn.addClass("start") : nextBtn.removeClass("start");
		};
		var isplay=true,curNum=0,
		changeSlide=function(index){
			isplay=false;
			slideBox.children("div").eq(index).addClass("current").siblings().removeClass("current");

			var tim=0,
			ob=slideBox.children("div").eq(curNum),
			cb=slideBox.children("div").eq(index),
			ototal=parseInt(ob.attr("num")) < 5 ? 5 : parseInt(ob.attr("num")),
			ctotal=parseInt(cb.attr("num")) < 5 ? 5 : parseInt(cb.attr("num")),
			ospace=curNum<index ? -ototal : ototal,
			cspace=curNum<index ? -ctotal : ctotal;

			if(VIVO_UIMIX.html5()){
				if(curNum!=index){
					sprev=snext=false;
					checkPN();
					if(ospace<0){
						ob.find("ul li").each(function(i,j){
							if(i<=5) tim+=(i+1)*50;
							$(j).css({"transition-delay": (i+1)*50 +"ms","transform":"translate3D("+ ospace*100 +"%,0,0)"});
							
							var f=setTimeout(function(){
								clearTimeout(f);
								cb.find("ul li").removeAttr("style");
								cb.css({display:"block"}).siblings().css({display:"none"});
								var fs=setTimeout(function(){
									clearTimeout(fs);
									cb.find("ul li").each(function(s,j){
										$(j).css({"transition-delay": (s+1)*50 +"ms"}).addClass("start").parent().parent().siblings().find("ul li").removeClass("start");
									});

									if(parseInt(cb.attr("num"))>5){
										snext=true;
										sprev=false;
									}else{
										snext=false;
										sprev=false;
									}
									checkPN();

								},50);
								isplay=true;
								curNum=index;
							},tim+500);
						});
					}else{
						ob.find("ul li").each(function(i,j){
							if(i<=5) tim+=(i+1)*50;
							$(j).css({"transition-delay": (ototal-(i+1))*50 +"ms","transform":"translate3D("+ ospace*100 +"%,0,0)"});
							
							var f=setTimeout(function(){
								clearTimeout(f);
								cb.css({display:"block"}).siblings().css({display:"none"});
								var fs=setTimeout(function(){
									clearTimeout(fs);
									cb.find("ul li").each(function(s,j){
										$(j).css({"transition-delay": (ctotal-(s+1))*50 +"ms","transform":"translate3D(0,0,0)",width:200});
									});

									if(parseInt(cb.attr("num"))>5){
										snext=true;
										sprev=false;
									}else{
										snext=false;
										sprev=false;
									}
									checkPN();

								},50);
								isplay=true;
								curNum=index;
							},tim+500);
							
						});
					}

				}else{

					if(parseInt(cb.attr("num"))>5){
						snext=true;
						sprev=false;
					}else{
						snext=false;
						sprev=false;
					}
					checkPN();

					for(var i=0; i<parseInt(cb.attr("num")); ++i){
						cb.find("ul li").eq(i).css({"transition-delay": (i+1)*50 +"ms"}).addClass("start");
					}
					cb.css({display:"block"});
					isplay=true;
				}
			}else{

				if(parseInt(cb.attr("num"))>5){
					snext=true;
					sprev=false;
				}else{
					snext=false;
					sprev=false;
				}
				checkPN();
				cb.css({display:"block",opacity:0}).stop().animate({opacity:1},500)
				.siblings().stop().animate({opacity:0},300,function(){
					$(this).css({display:"none"});
				});				
				slideBox.children("div.cl").find("ul li").addClass("start");
				isplay=true;
			}
		};

		slideTab.find("a").on({
			mouseenter : function(){
				tabLine.stop().animate({width:$(this).width(),left:$(this).position().left+20},300);
			},
			mouseleave : function(){
				if($(this).hasClass("current")) return false;
				tabLine.stop().animate({width:$(this).siblings(".current").width(),left:$(this).siblings(".current").position().left+20},300);
			},
			click : function(){
				if($(this).hasClass("current") || !isplay) return false;
				$(this).addClass("current").siblings().removeClass("current");
				changeSlide($(this).index());
				return false;
			}
		}).first().click().mouseenter();

		var step=5,c=0,w=200,
		antList=function(n){
			var csbTotal=parseInt(slideBox.children("div.current").attr("num"));
			checkPN();
			if(VIVO_UIMIX.html5()){
				slideBox.children("div.current").find("ul li").each(function(i,j){
					var s= n ? (parseInt($(j).parent().parent().attr("num"))-i)*50 : (i+1)*50;
					$(j).css({"transition-delay": s +"ms","transform":"translate3D("+ -c*200 +"px,0,0)",width:200});
				});
			}else{
				slideBox.children("div.current").find("ul").stop().animate({left: -c*200},500);
			}
			// console.log("c: "+c);
		};

		prevBtn.click(function(){
			c=Math.max(c-step,0);
			if(c>0){
				sprev=true;
				snext=true;
			}else{
				sprev=false;
				snext=true;
			}
			antList(1);
			return false;
		});
		nextBtn.click(function(){
			c=Math.min(c+step,parseInt(slideBox.children("div.current").attr("num"))-step);
			if(c+step >= parseInt(slideBox.children("div.current").attr("num"))){
				snext=false;
				sprev=true;
			}else{
				snext=true;
				sprev=true;
			}
			antList();
			return false;
		});
	},

	playVideo : function(){
		var videoList=$(".svideo-box"),
		videoLink=videoList.find(".svideo-section ul li a");

		videoLink.click(function(){
			var href=$(this).attr("href"),
			w=parseInt($(this).attr("data-width")) ? parseInt($(this).attr("data-width")) : 550,
			h=parseInt($(this).attr("data-height")) ? parseInt($(this).attr("data-height")) : 300;

			if(href=="" || href=="#") return false;
			VIVO_UIMIX.video(href,w,h);
			return false;
		}).mouseenter(function(){
			if($(this).find("b").size()<=0) $(this).append("<b></b>");
			$(this).find("b").stop().css({display:"block",opacity:0}).animate({opacity:1},500);
		}).mouseleave(function(){
			$(this).find("b").stop().animate({opacity:0},300,function(){
				$(this).css({display:"none"});
			});
		});
	},

	openList : function(){
		var serviceBox=$("#vivo-contain .vivo-service"),
		sItem=serviceBox.find(".service-content-item dl");

		sItem.each(function(i,j){
			var j=$(j);
			if(j.find("dt").size()<4){
				j.find("dd").css({"border-top":"1px #eee solid", top: -1});
			}

			j.find("dt").click(function(){
				var th=$(this),
				f=setTimeout(function(){
					VIVO_UIMIX.scroll(th.offset().top-50,300);
				},10);

				if($(this).hasClass("current")){
					$(this).removeClass("current").siblings("dd").slideUp({step : function(){
						$(this).hide();
					}});
					return false;
				}
				$(this).parent().parent().find("dd").slideUp({step : function(){
					$(this).hide();
				}}).siblings("dt").removeClass("current");

				th.addClass("current").siblings("dt").removeClass("current").siblings("dd").eq($(this).index()).slideDown({step : function(){
					$(this).show();
				}});

				return false;
			});

			if(i==0){
				// j.find("dt").first().click();
			}
		});
	}
};

VIVO_UIMIX.main.downloads = {
	init : function(){
		if(!$("#vivo-contain .vivo-download").size()) return;
		VIVO_UIMIX.main.downloads.hotSlide();
	},
	hotSlide : function(){
		var downloadBox=$("#vivo-contain .vivo-download"),
		slideBox=downloadBox.find(".hot-phone-box ul"),
		prev=downloadBox.find(".download-list a.prev"),
		next=downloadBox.find(".download-list a.next"),
		slideItem=slideBox.find("li"),
		total=slideItem.size(),
		w=slideItem.width(),
		tw=220,
		step=5,
		c=0;


		slideBox.css({width: total * tw});
		downloadBox.find(".download-list").on({
			click : function(){
				// slideBox.animate({left: -(c*w)},500);
				c=Math.max(c-step,0);
				antList(1);
				return false;
			}
		},"a.prev")
		.on({
			click : function(){
				c=Math.min(c+step,total-step);
				antList();
				return false;
			}
		},"a.next");

		var antList=function(n){
			// slideBox.addClass("move");
			if(VIVO_UIMIX.html5()){
				slideBox.find("li").each(function(i,j){
					var s= n ? (total-i)*50 : (i+1)*50;
					$(j).css({"transform":"translateX("+ (-c*w) +"px)","transition-delay": s + "ms"});
					var f=setTimeout(function(){
						// $(j).removeClass("move");
						// $(j).css("width","");
					},s);
				});	
			}else{
				slideBox.stop().animate({left:-c*w},500);
			}
			
		};
	}
};
