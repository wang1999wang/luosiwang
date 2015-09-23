//Powered by uimix.com;
//date:2014-06-09;
//v2 date:2014-12-20;
//vivo website products shows common function;

VIVO_UIMIX.products.header = {
	init : function(){
		var nheader=$("#mobile-header"),
		wrap=$("#mobile-wrap"),
		stage=$("#mobile-contain .stage"),
		_gb_nav_search=$('#vivo-head .vivo-nav .search-user a.search'),
		sharelayer=$("#mobile-share");

		var _H_=new this.mobileNav();
		var _P_=new this.popup();

		$(window).on({
			resize : function(){
				$(this).scroll();
				_P_.resize();
			},
			scroll : function(){

				var btop=$(this).scrollTop();

				_H_.closeAll();

				for(var i=0; i<stage.size(); i++){
					if(btop > stage.eq(i).offset().top && btop < stage.eq(i).offset().top+stage.eq(i).height()-50){
						if(stage.eq(i).hasClass("c")){
							//nheader.addClass("dark");
						}else{
							//nheader.removeClass("dark");
						}
					}
				}

				if(btop>wrap.offset().top+112){
					if(nheader.hasClass("f")) return;
					if(!$('html').hasClass('can-animate') || !$('html').hasClass('layer-ant')){
						//nheader.css({position:"absolute",top:-61});
						var tim=10;
					}else{
						var tim=0;
					}
					var s=setTimeout(function(){
						//nheader.addClass("f").css({position:"fixed",top:0});
					},tim);
				}

				if(btop<wrap.offset().top+61){
					//nheader.css({position:"relative",top:0}).removeClass("f dark");
				}

			}
		}).resize().scroll();
	},


	mobileNav : function(){
		var H=VIVO_UIMIX.products.header.mobileNav.prototype,
			TH=this,
			_header=$('.header-wrap'),
			_headerSearch=_header.find('#vivo-head .vivo-nav .search-user'),
			_navlist=_header.find('.mobile-header ul'),
			_funcBox=_header.find('#mobile-func-nav'),
			_shareBox=_header.find('#mobile-share'),
            _shopingPl=_header.find('#mobile-shopping-pl'),
            ishandover=false,
			setHeight=144,
			isEnd=true,
			_delay=0;





		_navlist.on({
			click : function(){
				if(!$('body').hasClass('funcnav-close')){
					if($(this).hasClass('current')){
						TH.closeFunc();
						$(this).removeClass('current');
					}else{
						TH.openFunc();
						$(this).addClass('current');
					}
					return false;
				}
			}
		},'li.vp-overviews')
		.on({
			click : function(){
				if($(this).hasClass('current')){
					TH.closeShare();
					$(this).removeClass('current');
				}else{
					TH.openShare();
					$(this).addClass('current');
				}
				return false;
			}
		},'li.vp-share')
		.on({
			click : function(){
				
			},
            mouseenter : function(){
                if($(this).hasClass('stop')) return;
                ishandover=true;
                if(!_shopingPl.is(':visible')) _shopingPl.css({display:'block',height:0}).clearQueue().animate({height:136},500,'easeInOutQuad');
            },
            mouseleave : function(){
                ishandover=false;
                setTimeout(function(){
                    if(!ishandover){
                        _shopingPl.clearQueue().animate({height:0},300,'easeInOutQuad',function(){
                            $(this).css({display:'none'});
                        });
                    }
                },200);
            }
		},'li.vp-purchase a');

        _shopingPl.on({
            mouseenter : function(){
                ishandover=true;
            },
            mouseleave : function(){
                ishandover=false;
                setTimeout(function(){
                    if(!ishandover){
                        _shopingPl.clearQueue().animate({height:0},300,'easeInOutQuad',function(){
                            $(this).css({display:'none'});
                        });
                    }
                },200);
            }
        });

		var stitle=$("meta[name='og:title']").attr("content"),
			svia=$("meta[name='og:via']").attr("content"),
			stopic=$("meta[name='og:topic']").attr("content"),
			simage=$("meta[name='og:image']").attr("content");		
		_shareBox.find('.share-ico li a').click(function(){

			if(!TH.checkShare()) return false;

			var S_type = $(this).attr('type'),
				S_via = S_type==="tencentweibo" ? "@vivomobile" : svia,
				S_content = stopic+" "+stitle+" (分享自 "+S_via+")",
				S_url = location.href,
				S_image = simage ? simage : '',
				S_imgArr=[];

			if(S_image && S_image.indexOf("|") != -1){
				S_imgArr=S_image.split("|");
				var s=Math.floor(Math.random()*S_imgArr.length);
				S_image=$("meta[name='og:reimg']").attr("content")+'share/'+S_imgArr[s];
			}
			TH.shareTo(S_type, S_content, S_url, S_image);
			return false;
		});





		_funcBox.find('.mobile-func-nav a').click(function(){
			H.funcTo($(this).attr('f'));
			return false;
		});
		




		H.openFunc=function(){
			TH.checkDelay();
			TH.closeAll();
			var fixHeight=_funcBox.find('.mobile-func-nav a').size()>8 ? setHeight+120 : setHeight;
			var t=setTimeout(function(){
				_funcBox.clearQueue().css({display:'block',height:0}).animate({height:fixHeight},300);
			},_delay);
		};
		H.closeFunc=function(){
			_funcBox.clearQueue().animate({height:0},200,'easeOutCirc',function(){
				$(this).css({display:'none'});
			});
		};
		H.openShare=function(){
			TH.checkDelay();
			TH.closeAll();
			var t=setTimeout(function(){
				_shareBox.clearQueue().css({display:'block',height:0}).animate({height:setHeight},300);
			},_delay);
		};
		H.closeShare=function(){
			_shareBox.clearQueue().animate({height:0},200,'easeOutCirc',function(){
				$(this).css({display:'none'});
			});
		};
		H.checkDelay=function(){
			_delay= _navlist.children('li.current').size()>0 ? 300 : 0;
		};
		H.closeAll=function(){
			_headerSearch.find('.search.current').click();
			_navlist.children('li.current').click();
		};

		H.checkShare=function(){
			if(stitle && svia && stopic){return true;}else{return false;}
		};
		H.shareTo=function(type, content, url, image){
			window.open(VIVO_UIMIX.share.url(type, content, url, image));
		};

		H.funcTo=function(o){
			$('html,body').clearQueue().animate({scrollTop: parseFloat($(o).offset().top)},500);
		};
	},


	popup : function(){
		var P=VIVO_UIMIX.products.header.popup.prototype,
			TH=this,
			_header=$('.header-wrap'),
			_funcBox=_header.find('#mobile-func-nav'),
			_navlist=_header.find('.mobile-header ul'),
			_popupLayer=$('.popup-page'),
			_popupBtn=_popupLayer.find('.popup-nav');


		_navlist.on({
			click : function(){
				_popupBtn.find('a.parameters-btn').click();
				return false;
			}
		},'li.vp-specs')
		.on({
			click : function(){
				_popupBtn.find('a.gallery-btn').click();
				return false;
			}
		},'li.vp-gallery')
		.on({
			click : function(){
				_popupBtn.find('a.third-btn').click();
				return false;
			}
		},'li.vp-third');




		_funcBox.find('.mobile-func-par')
		.on({
			click : function(){
				_popupBtn.find('a.parameters-btn').click();
				return false;
			}
		},'a.fp1')
		.on({
			click : function(){
				_popupBtn.find('a.gallery-btn').click();
				return false;
			}
		},'a.fp2')
		.on({
			click : function(){
				_popupBtn.find('a.third-btn').click();
				return false;
			}
		},'a.fp3');





		_popupBtn.on({
			click : function(){
				TH.closeLayer();
				return false;
			}
		},'a.close-btn')
		.on({
			click : function(){
				if($(this).hasClass('current')) return false;
				$(this).addClass('current').siblings().removeClass('current');
				TH.openLayer('specs-content');
				return false;
			}
		},'a.parameters-btn')
		.on({
			click : function(){
				if($(this).hasClass('current')) return false;
				$(this).addClass('current').siblings().removeClass('current');
				TH.openLayer('photo-content');
				return false;
			}
		},'a.gallery-btn')
		.on({
			click : function(){
				if($(this).hasClass('current')) return false;
				$(this).addClass('current').siblings().removeClass('current');
				TH.openLayer('three-content');
				return false;
			}
		},'a.third-btn');





		var isOpen,winTop,
			isanimate=VIVO_UIMIX.browser(1)<10 || !VIVO_UIMIX.html5() ?  false : true;


		P.openLayer=function(o){
			isOpen=_popupLayer.hasClass('open') ? true : false;
			if(o==='three-content') TH.initThree();
			if(o==='specs-content') TH.initPara();
			if(o==='photo-content') TH.initPhoto();
			if(isOpen){
				$('.'+o).clearQueue().css({zIndex:5,display:'block',opacity:0}).animate({opacity:1},500,function(){
					$(this).siblings('.pp').css({display:'none'});
				})
				.siblings('.pp').css({zIndex:1});
				return;
			}

			if(isanimate){
				winTop=$(window).scrollTop();
				$('.'+o).css({display:'block'});
				_popupLayer.clearQueue().css({display:'block',opacity:0}).animate({opacity:1},500,function(){
					var f=setTimeout(function(){
						_popupBtn.addClass('showpn');
					},200);

				});
				var t=setTimeout(function(){
					_popupLayer.addClass('open');
				},200);
				var s=setTimeout(function(){
					$('html').addClass('layer-ant');
				},800);
			}else{
				winTop=$(window).scrollTop();
				_popupLayer.addClass('open').clearQueue().css({display:'block',opacity:0}).animate({opacity:1},500);
				$('.'+o).css({display:'block'});
				$('html').addClass('layer-ant');
				_popupBtn.addClass('showpn');
			}
			
		};
		P.closeLayer=function(){
			$('html').removeClass('layer-ant');
			$('body,html').scrollTop(winTop);
			_popupLayer.removeClass("open").find('em.loading').css({display: 'none'});
			var closeDelay = isanimate ? 800 : 0;

			var t=setTimeout(function(){
				_popupLayer.clearQueue().animate({opacity:0},300,function(){
					$(this).css({display:'none'}).find('.pp').css({display:'none',zIndex:1});
					_popupBtn.removeClass('showpn').find('a.current').removeClass('current');
					if(typeof TH._switch === 'object') TH._switch.find('a').first().click();
					TH.resize();
				});
			},closeDelay);
		};
		P.initPara=function(){
			_popupLayer.find(".specs-content").scrollTop(1);
		};
		var isInitPhoto=false;
		P.initPhoto=function(){
			if(isInitPhoto) return;
			isInitPhoto=true;

			TH._P_loading=_popupLayer.find('em.loading');
			TH._P_photoBox=_popupLayer.find('.photo-content');
			TH._imgArr=[];
			var _switch=TH._P_photoBox.find('.slide-box'),
				_switchHtml='',galleryList='<ol>',
				_slideBox=TH._P_photoBox.find('.previews'),
				_slideTotal=parseInt(TH._P_photoBox.attr('img_total')),
				_slideName=TH._P_photoBox.attr('img_name');

			TH._switch=_switch;
			

			for(var i=0; i<_slideTotal; ++i){
				TH._imgArr.push($("meta[name='og:reimg']").attr("content")+'gallery/'+_slideName+'-b-'+ (i+1) +'.jpg');
				galleryList+='<li><img src="'+TH._imgArr[i]+'" /></li>';
				_switchHtml+='<a href="#"><b></b></a>';
				if(i>_slideTotal) galleryList+='<ol>';
			}
			_slideBox.html(galleryList);
			_switch.html(_switchHtml);
			_slideBox.find('ol').css({width: $(window).width() * _slideTotal}).addClass('cl').find('li').css({width: $(window).width()});


			var isLeft,isRight,curItem=0;			

			TH._P_photoBox.on({
				mousemove : function(E){
					isLeft = E.pageX<$(this).width()/3 ? true : false;
					isRight = E.pageX>($(this).width()-$(this).width()/3) ? true : false;

					if(isLeft){
						$(this).find('a.photo-prev').addClass('show');
					}else{
						$(this).find('a.photo-prev').removeClass('show');
					}

					if(isRight){
						$(this).find('a.photo-next').addClass('show');
					}else{
						$(this).find('a.photo-next').removeClass('show');
					}
				}
			})
			.on({
				click : function(e){
					curItem = curItem>0 ? --curItem : _slideTotal-1;
					_switch.find('a').eq(curItem).click();
					return false;
				}
			},'a.photo-prev')
			.on({
				click : function(e){
					curItem = curItem<_slideTotal-1 ? ++curItem : 0;
					_switch.find('a').eq(curItem).click();
					return false;
				}
			},'a.photo-next');

			$(document).on({
				keydown : function(E){
					if(!TH._P_photoBox.is(':visible')) return false;
					if(E.keyCode===37) TH._P_photoBox.find('a.photo-prev').click();
					if(E.keyCode===39) TH._P_photoBox.find('a.photo-next').click();
				}
			});



			_switch.find('a').click(function(){
				if($(this).hasClass('current')) return false;
				$(this).addClass('current').siblings().removeClass('current');
				_slideBox.find('ol').clearQueue().animate({left: -($(window).width() * $(this).index())},800)
				.find('li').eq($(this).index()).addClass('in').siblings().removeClass('in');
				curItem=$(this).index();
				return false;
			}).first().click();



			TH.loadImg();
		};
		P.initThree=function(){
			_popupLayer.find('.three-content').html('<iframe frameborder=0 src="'+ $("meta[name='og:reimg']").attr("content") +'360/white.html" scrolling=no></iframe>');
		};
		var L_curload=L_retried=0;
		P.loadImg=function(){
			TH._P_loading.css({display:'block'});
			TH._P_photoBox.css({visibility:'hidden'});
			if(L_curload>=TH._imgArr.length){
				TH._P_loading.remove();
				TH._P_photoBox.css({visibility:'visible'});
				TH._P_photoBox.clearQueue().css({display:'block',opacity:0}).animate({opacity:1},500,function(){
					TH.resize();
				});
			}else{
				var imgurl=new Image();
				$(imgurl).load(function(){
					L_curload++;
					L_retried=0;
					setTimeout(TH.loadImg,10);
				}).error(function(){
					L_retried++;
					if(L_retried<10){
						setTimeout(TH.loadImg,10);
					}else{
						L_curload++;
						L_retried=0;
						setTimeout(TH.loadImg,10);
					}
				});
				TH._P_loading.find("p").html(L_curload / (TH._imgArr.length-1) * 100 + "%");
				imgurl.src=TH._imgArr[L_curload];
			}
		};

		P.resize=function(){
			var winH=$(window).height(),
				maxH=1280,maxW=1280,
				rateH=winH / maxH;

			_popupLayer.css({height: winH});
			_popupLayer.find('.three-content iframe').css({height: winH});
			_popupLayer.find('.three-content').css({height: winH});
			_popupLayer.find('.photo-content').css({height: winH}).find('.previews').css({height: winH});
			_popupLayer.find('.specs-content').css({height: winH});

			_popupLayer.find('.photo-content img').css({width: maxW*rateH , height : winH});

		};

	}
};

