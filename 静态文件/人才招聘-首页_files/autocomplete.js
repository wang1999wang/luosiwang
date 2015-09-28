(function ($) {
    $.fn.autoCmpt = function (options) {
        var options = $.extend({}, $.fn.autoCmpt.defaults, options);
        var lastquery = ""; //上次请求的内容
        var cache_name = new Array(); //浏览器数据缓存
        var cache_length;
        var p = null; //智能提示对象
        if ($("#suggest").length < 1) p = $("<div/>", { "id": "suggest" }).appendTo("body"); //生成提示框
        else p = $("#suggest");
        $(this).live("focusin", function () { $(this).trigger("keyup"); if (options.multi) $(this).addClass("autoCmpt-multi"); })
        .val('')//避免刷新页面时出现旧值
		.attr('autocomplete', 'off')
        .live("focusout", function () {
            if (!p.data("show")) $("#suggest").hide(); //清除提示框
        })
        .live("keyup", function (event) {
            var obj = $(this);
            var k = event.keyCode;
            if ($("#suggest").is(":hidden")) {
                if ((k >= 65 && k <= 90) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 186 || k == 222 || k == 40 || k == 46 || (typeof (k) == "undefined")) {
                    getSuggest(this);
                    return;
                }
            }
            else {
                //37:left,39:right;40:down,38:up,27:esc,9:tab
                if (k == 39) k = 40;
                if (k == 37) k = 38;
                if (k == 9) k = 27;
                var curobj;
                switch (k) {
                    case 40: //down
                        var o = $(".highlight");
                        var v;
                        if (o.length == 0) {
                            curobj = $("#suggest p:first");
                            v = curobj.addClass("highlight").find(".sname").html();
                        } else {
                            curobj = o.eq(0).removeClass("highlight").next("p");
                            v = curobj.addClass("highlight").find(".sname").html();
                            if (v == null) {
                                v = $("#suggest p:first").addClass("highlight").find(".sname").html();
                                $("#moreSuggest").removeClass("highlight");
                            }
                        }
                        if (v != "更多...") obj.val(v);
                        break;
                    case 38: //up
                        var o = $(".highlight");
                        var v;
                        if (o.length == 0) {
                            curobj = $("#suggest p:last");
                            v = curobj.addClass("highlight").find(".sname").html();
                        } else {
                            curobj = o.filter(":last").removeClass("highlight").prev("p");
                            v = curobj.addClass("highlight").find(".sname").html();
                        }
                        if (v == null) {
                            curobj = $("#suggest p:last").removeClass("highlight").prev("p");
                            v = curobj.addClass("highlight").find(".sname").html();
                        }
                        if (v != "更多...") obj.val(v);
                        break;
                    case 27: //escape
                        $("#suggest").hide();
                        curobj = $(".highlight:not(#moreSuggest)");
                        if (obj.attr("qid") != "-1" && curobj.length == 1) bindHospitalIdByElement(obj, curobj);
                        break;
                    case 13: //enter
                        //$("#btn_Query").click();
                        //return false;
                        break;
                    default:
                        if ((k >= 65 && k <= 90) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 186 || k == 222 || k == 40) {
                            getSuggest(this);
                        }
                        break;
                }
            }
        });
        function getSuggest(obj) {
            var t = $(obj);
            if (t.data("xmlhttp")) t.data("xmlhttp").abort(); //假如有之前的请求存在，则手动停止它
            var o = t.offset();
            var h = t.height();
            var v = t.val();
            //var v = t.val().replace(/[\s',，|\\\/。;；]/, ''); //去无意义字符
            if (!options.emptyRequest && v == '') return; //请求关键词为空是否阻止提交
            if (options.parentID != 'null') {//设置为依赖父ID，则强制检测和更改URL
                var pe = $("#" + options.parentID);
                var pev = pe.val();
                if (!options.usePrentValue) pev = pe.attr("qid") || -1; //如果设置为不使用元素value（默认），则取其qid值，无值则设为-1;
                if (pev == '' || pev == -1) return; //要求父ID，父ID为空，则拒绝提交
            }
            if (t.is(".autoCmpt-q-last") && v == lastquery) { p.show(); return; } //与最后一次请求的发起者和内容相同，直接显示内容

            $(".autoCmpt-q-last").removeClass("autoCmpt-q-last");
            var url = options.url;
            var x = $.ajax({ async: false, type: "post", url: encodeURI(url), dataType: "json", data: { t: new Date().getMilliseconds(), keyword: v, pid: pev }, success: function (data) {
                t.removeData("xmlhttp"); //清除ajax请求的xmlHttpRequest对象
                t.addClass("autoCmpt-q-last"); //标识是最后一个发出请求的元素

                var names = data.result;
                var l = $(names).length;
                if (l < 1) return;
                cache_name = names;
                cache_length = l;
                appendElements(l, names);
                lastquery = v;
                p.css({ left: o.left, top: o.top + h }).show();
            }
            });
            t.data("xmlhttp", x); //保存当前ajax请求的xmlHttpRequest对象
        }

        $("#moreSuggest").live("mouseup", function () {
            var d = $("#moreSuggest").data("datas");
            if (d == undefined) return;
            appendElements(d.length, d.names);
            $(".autoCmpt-q-last").eq(0).focus();
        });

        //生成提示元素的公用方法
        function appendElements(lengh, names) {
            var left = 0;
            var n = 10;
            var multiColumn = $(".autoCmpt-q-last").hasClass("autoCmpt-multi");
            if (multiColumn) {
                n = 32;
            }
            p.empty();
            for (var i = 0; i < n && i < lengh; i++) {
                //  p.append("<p sid=\"" + $(names)[i][0] + "\" pid=\"" + $(names)[i][3] + "\"><span class=\"inputcode\">" + $(names)[i][2] + "</span><span class=\"sname\">" + $(names)[i][1] + "</span></p>");
                p.append("<p sid=\"" + names[i].parameterKey + "\"><span class=\"sname\">" + names[i].parameterValue + "</span></p>");
            }
            if (lengh > n) {
                left = lengh - n;
                // p.append("<p id=\"moreSuggest\" sid=\"-1\">更多...</p>");
                $("#moreSuggest").data("datas", { length: left, names: names.slice(9) });
            }
            if (multiColumn && lengh > 10) {
                p.find("p").addClass("narrow");
                p.find(".inputcode").hide();
            }
            else {
                $(".narrow").removeClass("narrow");
                p.find(".inputcode").show();
            }
            //  p.prepend("<div class='sugtips'>输入中文/拼音首字母或方向键选择</div>");
            p.show();
        }

        $("#suggest p").live("mouseover", function () {
            $(".highlight").removeClass("highlight");
            $(this).addClass("highlight");
            p.data("show", true); //避免触发源失焦造成提示窗口消失
        })
        .live("mouseout", function () {
            $(this).removeClass("highlight");
            p.data("show", false);
        })
        .live("click", function () {
            var v = $(this).find(".sname").html();
            $(".autoCmpt-q-last").val(v).focus().attr("qid", $(this).attr("sid"));
            p.data("show", false);
            p.hide();
        });
    };
    $.fn.autoCmpt.defaults = {
        url: "", //ajax请求的地址
        emptyRequest: true, //是否允许关键词为空也提交
        parentID: 'null', //给定父元素ID，则建立了强关联，该父元素无值则不会提交
        usePrentValue: false, //如果上面给定了parentID，此项默认使用其qid值，否则使用其value值
        multi: false//是否一列提示多个
    }
})(jQuery);


(function (a) { 
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.Search_Init = function(){
        
        
    };
})(jQuery);




(function ($) {
    $.fn.ComSearchAutoCmpt = function (options) {
        var options = $.extend({}, $.fn.ComSearchAutoCmpt.defaults, options);
        $(".masterSearch .searchTag a").live("click",function(){
            var tabName = "";
            tabName = $(this).attr("id");
            if(tabName == "tabProduct"){
                options.searchType = 0 ;
            }else if (tabName == "tabSupplier"){
                options.searchType = 1 ;
            }else if(tabName == "tabStandard"){
                options.searchType = 2 ;
                options.searchTabType = $("topStandardTypes").val();
            }else if(tabName == "tabNews"){
                options.searchType = 3 ;
                options.searchTabType = $("topNewsTypes").val();
                
              
             
            }else{
                return ;
            }
        });
        $(".listBoxForSearch a").live("click",function(){
            var tabval = $(this).attr("data-val");
            options.searchTabType = tabval;
           
          
            
        });
        var lastquery = ""; //上次请求的内容
        var cache_name = new Array(); //浏览器数据缓存
        var cache_length;
        var p = null; //智能提示对象
        var focusmark = 0; //搜索框失去焦点标记
        if ($("#suggest").length < 1) p = $("<div/>", { "id": "suggest" }).appendTo("body"); //生成提示框
        else p = $("#suggest");
        $(this).live("focusin", function () { 
            if(focusmark==0){
                $(this).trigger("keyup"); if (options.multi) $(this).addClass("autoCmpt-multi"); 
            }
            else{
                focusmark=0;
            }
        })
        .val('')//避免刷新页面时出现旧值
		.attr('autocomplete', 'off')
        .live("focusout", function () {
            focusmark=1;
            if (!p.data("show")) $("#suggest").hide(); //清除提示框
        })
        .live("keyup", function (event) {
            var obj = $(this);
            var k = event.keyCode;
         
            if ($("#suggest").is(":hidden")) {
                if ((k >= 65 && k <= 90) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 186 || k == 222 || k == 40 || k == 46 || (typeof (k) == "undefined")) {
                    getSuggest(this);
                    return;
                }
            }
            else {
                //37:left,39:right;40:down,38:up,27:esc,9:tab
                if (k == 39) k = 40;
                if (k == 37) k = 38;
                if (k == 9) k = 27;
                var curobj;
                switch (k) {
                    case 40: //down
                        var o = $(".highlight");
                        var v;
                        if (o.length == 0) {
                            curobj = $("#suggest p:first");
                            v = curobj.addClass("highlight").find(".sname").html();
                        } else {
                            curobj = o.eq(0).removeClass("highlight").next("p");
                            v = curobj.addClass("highlight").find(".sname").html();
                            if (v == null) {
                                v = $("#suggest p:first").addClass("highlight").find(".sname").html();
                                $("#moreSuggest").removeClass("highlight");
                            }
                        }
                        if (v != "更多...") obj.val(v);
                        break;
                    case 38: //up
                        var o = $(".highlight");
                        var v;
                        if (o.length == 0) {
                            curobj = $("#suggest p:last");
                            v = curobj.addClass("highlight").find(".sname").html();
                        } else {
                            curobj = o.filter(":last").removeClass("highlight").prev("p");
                            v = curobj.addClass("highlight").find(".sname").html();
                        }
                        if (v == null) {
                            curobj = $("#suggest p:last").removeClass("highlight").prev("p");
                            v = curobj.addClass("highlight").find(".sname").html();
                        }
                        if (v != "更多...") obj.val(v);
                        break;
                    case 27: //escape
                        $("#suggest").hide();
                        curobj = $(".highlight:not(#moreSuggest)");
                        if (obj.attr("qid") != "-1" && curobj.length == 1) bindHospitalIdByElement(obj, curobj);
                        break;
                    case 13: //enter
                        //$("#btn_Query").click();
                        //return false;
                        break;
                    default:
                        if ((k >= 65 && k <= 90) || k == 8 || k == 32 || (k >= 48 && k <= 57) || k == 186 || k == 222 || k == 40) {
                            getSuggest(this);
                        }
                        break;
                }
            }
        });
        function getSuggest(obj) {
            var t = $(obj);
            if (t.data("xmlhttp")) t.data("xmlhttp").abort(); //假如有之前的请求存在，则手动停止它
            var o = t.offset();
            var h = t.height();
            var v = t.val();
            //var v = t.val().replace(/[\s',，|\\\/。;；]/, ''); //去无意义字符
            
            if (!options.emptyRequest && v == '') return; //请求关键词为空是否阻止提交
            if (options.parentID != 'null') {//设置为依赖父ID，则强制检测和更改URL
                var pe = $("#" + options.parentID);
                var pev = pe.val();
                if (!options.usePrentValue) pev = pe.attr("qid") || -1; //如果设置为不使用元素value（默认），则取其qid值，无值则设为-1;
                if (pev == '' || pev == -1) return; //要求父ID，父ID为空，则拒绝提交
            }
//            if (t.is(".autoCmpt-q-last") && v == lastquery) { p.show(); return; } //与最后一次请求的发起者和内容相同，直接显示内容

            $(".autoCmpt-q-last").removeClass("autoCmpt-q-last");
            var url = options.url;

            var x = $.ajax({ async: false, type: "post", url: encodeURI(url), dataType: "json", data: { t: new Date().getMilliseconds(), keyword: v, searchtype: options.searchType, tabtype: options.searchTabType }, success: function (data) {
                    if (data.status.code == "1001") {
                        t.removeData("xmlhttp"); //清除ajax请求的xmlHttpRequest对象
                        //t.addClass("autoCmpt-q-last"); //标识是最后一个发出请求的元素
                    
                        var names = data.result;
                        var l = $(names).length;
                        if (l < 1) return;
                        cache_name = names;
                        cache_length = l;
                        appendElements(l, names);
                        lastquery = v;
                        p.css({ left: o.left, top: o.top + h }).show();
                    }
                    else {                    
                         t.removeData("xmlhttp"); //清除ajax请求的xmlHttpRequest对象
                        if (!p.data("show")) $("#suggest").hide(); //清除提示框
                    }
                },

                error: function (data) {
                    t.removeData("xmlhttp"); //清除ajax请求的xmlHttpRequest对象
                    if (!p.data("show")) $("#suggest").hide(); //清除提示框
                }
            });
            t.data("xmlhttp", x); //保存当前ajax请求的xmlHttpRequest对象
        }

        $("#moreSuggest").live("mouseup", function () {
            var d = $("#moreSuggest").data("datas");
            if (d == undefined) return;
            appendElements(d.length, d.names);
            $(".autoCmpt-q-last").eq(0).focus();
        });

        //生成提示元素的公用方法
        function appendElements(lengh, names) {
            var left = 0;
            var n = 10;
            var multiColumn = $(".autoCmpt-q-last").hasClass("autoCmpt-multi");
            if (multiColumn) {
                n = 32;
            }
            p.empty();
            for (var i = 0; i < n && i < lengh; i++) {
                p.append("<a href=\"" + names[i].parameterKeyUrl + "\"><p><span class=\"sname\">" + names[i].parameterKeyName + "</span></p></a>");
            }
            if (lengh > n) {
                left = lengh - n;
                // p.append("<p id=\"moreSuggest\" sid=\"-1\">更多...</p>");
                $("#moreSuggest").data("datas", { length: left, names: names.slice(9) });
            }
            if (multiColumn && lengh > 10) {
                p.find("p").addClass("narrow");
                p.find(".inputcode").hide();
            }
            else {
                $(".narrow").removeClass("narrow");
                p.find(".inputcode").show();
            }
            //  p.prepend("<div class='sugtips'>输入中文/拼音首字母或方向键选择</div>");
            p.show();
        }

        $("#suggest p").live("mouseover", function () {
            $(".highlight").removeClass("highlight");
            $(this).addClass("highlight");
            p.data("show", true); //避免触发源失焦造成提示窗口消失
        })
        .live("mouseout", function () {
            $(this).removeClass("highlight");
            p.data("show", false);
        })
    };
    $.fn.ComSearchAutoCmpt.defaults = {
        url: "", //ajax请求的地址
        emptyRequest: true, //是否允许关键词为空也提交
        parentID: 'null', //给定父元素ID，则建立了强关联，该父元素无值则不会提交
        usePrentValue: false, //如果上面给定了parentID，此项默认使用其qid值，否则使用其value值
        multi: false, //是否一列提示多个
        searchType: 1, //搜索类型
        searchTabType : 1
    }
})(jQuery);